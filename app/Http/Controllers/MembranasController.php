<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembranasController extends Controller
{
     public function show() {
        return view('membrana.show');
    }  
}
