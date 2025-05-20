<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LipidosController extends Controller
{
    public function show() {
        return view('lipidos.show');
    }
}
