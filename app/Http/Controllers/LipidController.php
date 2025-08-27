<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class LipidController extends Controller
{
    /**
     * Show the data for a given lipid profile.
     */
    public function show(string $lipid_id) : \Illuminate\View\View    {

       
        $dummyLipids = [
        'id' => $lipid_id,
        'name' => 'Lipid POPE',
        'formula' => 'C55H98O6',
        'mass' => '885.4',
        'type' => 'Phospholipid',
        'description' => 'This is a dummy lipid for demonstration.'
    ];
     return View::make('lipid', ['lipid' => $dummyLipids]);


        

    }
}
