<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{

  public function download($id,$fileName){
    // Necesitamos la ruta de la base de datos..
    $pathFilesRoot = DB::table('trajectories')
                      ->select('input_folder')
                      ->where('id',$id)->first();

     $file = "";
     $pathFilesRoot= explode("/",rtrim($pathFilesRoot->input_folder,'/'));
     $n= count($pathFilesRoot);
     $file =  "app/public/".$pathFilesRoot[$n-3]."/".$pathFilesRoot[$n-2]."/".$pathFilesRoot[$n-1]."/".$fileName;

     ///var/www/vhosts/supepmem.com/gideon/polar/DRAMP00008/CANCER/
     return response()->download(storage_path($file));
  }


  public function downloadP($id,$fileName){
    // Necesitamos la ruta de la base de datos..
    $pathFilesRoot = DB::table('trajectories')
                      ->select('input_folder')
                      ->where('id',$id)->first();

     $file = "";
     $pathFilesRoot= explode("/",rtrim($pathFilesRoot->input_folder,'/'));
     $n= count($pathFilesRoot);
     $file =  "app/public/".$pathFilesRoot[$n-3]."/".$pathFilesRoot[$n-2]."/".$pathFilesRoot[$n-1]."/analysis/".$fileName;

     ///var/www/vhosts/supepmem.com/gideon/polar/DRAMP00008/CANCER/
     return response()->download(storage_path($file));
  }

  public function downloadff($id,$fileName){

     $file = "";
     $file = 'app/public/forcefields/'.$id.'/'.$fileName;

     return response()->download(storage_path($file));
  }


}
