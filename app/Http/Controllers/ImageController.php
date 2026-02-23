<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
//use Spatie\ImageOptimizer\OptimizerChainFactory;
//use Imagick;


class ImageController extends Controller
{

  function ReDimension($FileName){

    //echo public_path('storage'.$file);
    //$imgExt->readImage(public_path('CHOL.svg'));
    //$imgExt->writeImages('CHOL.jpg', true);



    //$usmap = public_path($FileName);
    $im = new Imagick();
    $imageFile = file_get_contents($FileName);

    if (file_exists($FileName)){

      $im->readImageBlob($imageFile);
      list($ancho, $alto, $tipo, $atributos) = getimagesize($FileName);

      $ctime++;
      echo $ancho.'X'.$alto.'<br>';

      
    }else {
      echo "File does not exist: " . $FileName . "<br>";
    }
  }

    public function index()
    {

        $pathToImage = '/var/www/vhosts/supepmem.com/laravel/public/storage/polar/DRAMP00013/POPE_POPG_1_3/analysis/distCOM_50.png';

        $pathIni = public_path('storage/polar/');

        $file = "storage/polar/DRAMP02483/CANCER/analysis/DOPE.png";

    }


}
