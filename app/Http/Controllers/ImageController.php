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

      /*$im->setImageFormat("PNG");
      //$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);
      $im->resizeImage(2048,2048,imagick::FILTER_POINT,1,true);
      $im->writeImage('conv.png');
      */
      //header('Content-type: image/png');
      //echo $im->getImagesBlob();

      //$im->clear();
      //$im->destroy();
    }else {
    //echo('Dont exist');
    }

    //  dd("Document has been converted");

  }

    public function index()
    {

        //ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
        //$factory = new \ImageOptimizer\OptimizerFactory();
        //$optimizer = $factory->get();

        $pathToImage = '/var/www/vhosts/supepmem.com/laravel/public/storage/polar/DRAMP00013/POPE_POPG_1_3/analysis/distCOM_50.png';

          //ImageOptimizer::optimize($pathToImage);
         //$factory = new \ImageOptimizer\OptimizerFactory();
         //ImageOptimizer::optimize($pathToImage);

        // $optimizerChain = OptimizerChainFactory::create();

         //$optimizerChain->optimize($pathToImage);

        //  app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage);
        $pathIni = public_path('storage/polar/');

        $file = "storage/polar/DRAMP02483/CANCER/analysis/DOPE.png";
/*
        $directory = new \RecursiveDirectoryIterator($pathIni);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = array();
        foreach ($iterator as $info) {

          if (!is_dir($info->getPathname())){
            if (pathinfo($info->getPathname(), PATHINFO_EXTENSION)=="png"){
            $files[] = $info->getPathname();
            echo $info->getPathname()."<br>";
            //$this->ReDimension($info->getPathname());
            }
          }

        }*/
    }


}
