<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class LipidController extends Controller
{
    /**
     * Show the data for a given lipid profile.
     */
    public function show(string $lipid_id) : \Illuminate\View\View    {

        // Fetch lipid data from the database based on the provided lipid_id
        // For example:
        $lipid = DB::table('lipids')->where('id', $lipid_id)->firstOrFail();


        // Get the base data each lipid has from the DB.
       
        $lipids_data= [
            'id' => $lipid_id,
            'name' => $lipid->name ?? 'Nonexistent Lipid',
            'molecule' => $lipid->molecule ?? 'Unknown Molecule',
            'description' => $lipid->description ?? 'No description available.' 
        ];
        // get additional properties if needed
        $properties = DB::table('lipid_properties')
            ->join('properties', 'lipid_properties.property_id', '=', 'properties.id')
            ->select('name','value','unit')
            -> where('lipid_id', $lipid_id)->get();
        $lipids_data['properties'] = $properties;


     return View::make('lipid', ['lipid' => $lipids_data]);


        

    }
}
