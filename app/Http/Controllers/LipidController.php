<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LipidController extends Controller
{
    /**
     * Show the data for a given lipid profile.
     */
    public function show(string $lipid_id): string
    {
        $dummyLipids = [
        'id' => $lipid_id,
        'name' => 'Lipid ' . $lipid_id,
        'formula' => 'C55H98O6',
        'mass' => '885.4',
        'type' => 'Phospholipid',
        'description' => 'This is a dummy lipid for demonstration.'
    ];
    $output = "<h2>Showing details for lipid: {$dummyLipids['id']}</h2>";
    $output .= "<ul>";
    foreach ($dummyLipids as $key => $value) {
        $output .= "<li><strong>" . ucfirst($key) . ":</strong> " . $value . "</li>";
    }
    $output .= "</ul>";

    return $output;
        

    }
}
