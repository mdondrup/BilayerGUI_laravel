<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeptidosController extends Controller
{
    public function show() {
        return view('peptidos.show');
    }
}
