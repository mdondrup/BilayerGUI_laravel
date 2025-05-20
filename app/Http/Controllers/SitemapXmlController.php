<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Trayectoria;

class SitemapXmlController extends Controller
{
    public function sitemap() {
        $trayectorias = Trayectoria::all();
        return response()->view('sitemap', [
            'trayectorias' => $trayectorias
        ])->header('Content-Type', 'text/xml');
      }

}
