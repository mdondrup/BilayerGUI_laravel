<?php

namespace App\Http\Controllers;

use App\Experiments;
use App\Ion;
use App\Lipido;
use App\Trayectoria;
use Illuminate\Http\Request;

// Basic Search Controller.
//  It searches for the text in the name and molecule of the lipids, and in the lipid names of the membranes. It also searches for ions by molecule.
// The search is case-insensitive and allows partial matches. The results are then passed to a view for display.

class SearchController extends Controller
{
    private function escapeLike($text)
    {
        // 1. Escape SQL LIKE special characters (\ first to avoid double-escaping)
        $text = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $text);

        // 2. Convert user-facing wildcards to SQL LIKE wildcards:
        //    *  → %  (match any number of characters)
        //    ?  → _  (match exactly one character)
        $text = str_replace(['*', '?'], ['%', '_'], $text);

        return $text;
    }

    private function escapeLikeLiteral($text)
    {
        // Escape all special characters — no wildcard conversion
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $text);
    }

    /**
     * Strip surrounding quotes and determine if the search should be literal.
     * Returns [$strippedText, $isLiteral].
     * Supports: "text", 'text'
     */
    private function parseQuotedSearch($text)
    {
        if (
            (str_starts_with($text, '"') && str_ends_with($text, '"')) ||
            (str_starts_with($text, "'") && str_ends_with($text, "'"))
        ) {
            return [substr($text, 1, -1), true];
        }

        return [$text, false];
    }

    private function looksLikeDOI($text)
    {
        // Simple regex to check if the text looks like a DOI
        return preg_match('/^10\.\d{4,9}\/[-._;()\/:A-Z0-9]+$/i', $text);
    }

    public function results(Request $request)
    {

        $texto = trim($request->get('text'));

        // Para poner el ID con un numero
        if (str_starts_with(strtoupper($texto), 'ID')) {
            $id = substr($texto, 2);

            if (is_numeric($id)) {
                // $trayectoria = Trayectoria::where('id', $texto)->first();
                // if (!is_null($trayectoria)) {
                return redirect()->route('trayectorias.show', ['trayectoria_id' => $id]);
                // }
            }
        }

        $claves = preg_split("/[\s,]+/", $texto);
        $cadregexp = '';

        // Check if the search is quoted (literal match — no wildcards)
        [$searchText, $isLiteral] = $this->parseQuotedSearch($texto);

        // Escape MySQL REGEXP special characters in each keyword
        // For literal searches, use the unquoted text for regexp building
        $regexpClaves = preg_split("/[\s,]+/", $searchText);
        if (count($regexpClaves) > 0) {

            for ($i = 0; $i < count($regexpClaves); $i++) {
                $escaped = preg_quote($regexpClaves[$i], '/');
                // preg_quote escapes PCRE meta-chars; MySQL REGEXP uses a subset,
                // but this is safe — over-escaping doesn't break MySQL REGEXP.
                $cadregexp = $cadregexp.'(?=.*'.$escaped.')';
            }

        }

        // Escape LIKE special characters; literal mode skips wildcard conversion
        $likeText = $isLiteral
            ? $this->escapeLikeLiteral($searchText)
            : $this->escapeLike($searchText);

        // Literal (quoted) search: exact match; normal search: partial match with surrounding %
        $likePattern = $isLiteral ? $likeText : "%{$likeText}%";

        $lipidos = Lipido::where('molecule', 'LIKE', $likePattern)->orWhere('name', 'LIKE', $likePattern)->get();
        
        $lipidos[] = Lipido::whereHas('properties', function ($query) use ($likePattern) {
            $query->where('value', 'LIKE', $likePattern);
        })->get();
        $lipidos[] = Lipido::whereHas('cross_references', function ($query) use ($likePattern) {
            $query->where('external_id', 'LIKE', $likePattern);
        })->get();
        $lipidos[] = Lipido::whereHas('synonyms', function ($query) use ($likePattern) {
            $query->where('synonym', 'LIKE', $likePattern);
        })->get();
        $lipidos = collect($lipidos)->flatten()->unique('id');
        $lipid_ids = $lipidos->pluck('id')->toArray();

        $iones = Ion::where('molecule', 'LIKE', $likePattern)->get()->unique('molecule');
        $experiments = collect();
        $trayectorias = collect();
        // Search all experiments that are associated with a membrane that has a lipid name matching the search text
        if (! empty($lipid_ids)) {
            $experiments = Experiments::whereHas('membraneComposition', function ($query) use ($lipid_ids) {
                $query->whereIn('lipid_id', $lipid_ids);
            })->get();

            // Now search for trajectories that are associated with those lipids

            $trayectorias = Trayectoria::whereHas('lipidos', function ($query) use ($lipid_ids) {
                $query->whereIn('lipid_id', $lipid_ids);
            })->get();
        }

        $experiments = $experiments->merge(Experiments::where('path', 'LIKE', $likePattern)->get())->unique('id');


        // Also search for trajectories by others fields, to not miss them if they are not associated with the lipids we found
        $trayectorias = $trayectorias->merge(Trayectoria::where('system', 'LIKE', $likePattern)
            ->orWhere('system', 'LIKE', $likePattern)
            ->orWhere('publication', 'LIKE', $likePattern)
            ->orWhere('author', 'LIKE', $likePattern)
            ->orWhere('git_path', 'LIKE', $likePattern)
            ->get())->unique('id');

        if ($this->looksLikeDOI($texto) || str_starts_with(strtolower($texto), 'doi:') || $lipidos->isEmpty()) {
            // If the text looks like a DOI, search for experiments and trajectories with a matching DOI
            // or we haven't found any lipids, so we want to try searching by DOI as a fallback
            // remove 'doi:' prefix if present
            $doiText = str_starts_with(strtolower($texto), 'doi:') ? substr($texto, 4) : $texto;
            $doiLike = $isLiteral
                ? $this->escapeLikeLiteral($doiText)
                : "%{$this->escapeLike($doiText)}%";
            $experimentsByDOI = Experiments::where('article_doi', 'LIKE', $doiLike)->orWhere('data_doi', 'LIKE', $doiLike)->get();
            $experiments = $experiments->merge($experimentsByDOI)->unique('id');
            $trayectoriesByDOI = Trayectoria::where('doi', 'LIKE', $doiLike)->get();
            $trayectorias = $trayectorias->merge($trayectoriesByDOI)->unique('id');
        }

        return view('search.results', [
            'texto' => $texto,
            'cadregexp' => $cadregexp,
            'claves' => $claves,
            'iones' => $iones,
            'lipidos' => $lipidos,
            'experiments' => $experiments,
            'trayectorias' => $trayectorias,
        ]);
    }
}
