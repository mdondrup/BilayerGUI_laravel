<?php

namespace App\Http\Controllers;

use App\Agua;
use App\Ion;
use App\Lipido;
use App\Molecula;
use App\Peptido;
use App\Trayectoria;
use App\Membrana;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function basic(Request $request){
      
	//Recuperamos lo que el usuario escribió en el buscador
	$term = $request->term;


	$queryLipido = Lipido::where('short_name','like','%' . $term . '%')
                        ->orderBy('short_name','ASC')
                        ->select('short_name as label')
                        ->groupBy('short_name')
                        ->get();
  $queryLipido2 = Lipido::where('full_name','like','%' . $term . '%')
                        ->orderBy('full_name','ASC')
                        ->select('full_name as label')
                        ->groupBy('full_name')
                        ->get();

  $queryMembrana = Membrana::where('name','like','%' . $term . '%')
                            ->orderBy('name','ASC')
                            ->select('name as label')
                            ->groupBy('name')
                            ->get();

  $queryPeptido = Peptido::where('name','like','%' . $term . '%')
                          ->orderBy('name','ASC')
                          ->select('name as label')
                          ->groupBy('name')
                          ->get();
  $queryPeptidoSequence = Peptido::where('sequence','like','%' . $term . '%')
                          ->orderBy('name','ASC')
                          ->select('name as label')
                          ->groupBy('name')
                          ->get();

  $queryMolecula = Molecula::where('full_name','like','%' . $term . '%')
                            ->orderBy('full_name','ASC')
                            ->select('full_name as label')
                            ->groupBy('full_name')
                            ->get();

  $queryIones = Ion::where('short_name','like','%' . $term . '%')
                        ->orderBy('short_name','ASC')
                        ->select('short_name as label')
                        ->groupBy('short_name')
                        ->get();
 /* 
 $queryAgua = Agua::where('short_name','like','%' . $term . '%')
                        ->orderBy('short_name','ASC')
                        ->select('short_name as label')
                        ->groupBy('short_name')
                        ->get();
                        */
  $queryTemperature = Trayectoria::where('temperature','like','%' . $term . '%')
                        ->orderBy('temperature','ASC')
                        ->select('temperature as label')
                        ->groupBy('temperature')
                        ->get();


  $querys =new \Illuminate\Database\Eloquent\Collection;
  $querys = $querys->concat($queryLipido);
  $querys = $querys->concat($queryLipido2);
  $querys = $querys->concat($queryMembrana);
  $querys = $querys->concat($queryPeptido);
  $querys = $querys->concat($queryPeptidoSequence);
  $querys = $querys->concat($queryMolecula);
  $querys = $querys->concat($queryIones);
  //$querys = $querys->concat($queryAgua);
  $querys = $querys->concat($queryTemperature);


//var_dump($querys);
//die();

  return $querys;


    }

}
