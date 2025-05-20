<?php
use App\Trayectoria;
/**
 * @var Trayectoria[] $trayectorias
 */
?>
@extends('layouts.compare')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-right">
        <div class="col-md-12">
            <div class="txt-white ">
              <div class="d-flex p-2 justify-content-begin" >
                <?php
                    // Divido la URL para poder mandar los mismos parametros al exportador
                    $newlinkSel = "exportcompare?selected=1";
                ?>
                  <div class="p2">
                    <a class="btn btn-primary btn-sm" href="{{ $newlinkSel }}"> @lang('Exportar seleccionado')</a>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive txt-white">

<?php

$DosCol = "col-xs-12 col-sm-12 col-md-6 col-lg-6 p-4 ";
$TresCol = "col-xs-12 col-sm-12 col-md-12 col-lg-4 p-4 ";

function IgualaDecimales($n1,$n2){

$ent1=$dec1=$ent2=$dec2="0";
$a = explode(".",$n1);
$b = explode(".",$n2);
if (count($a)>1) $dec1=$a[1];
if (count($b)>1) $dec2=$b[1];

$maxdec = max(strlen($dec1),strlen($dec2));
 $dec1 =  str_pad($dec1,$maxdec,"0",STR_PAD_RIGHT);
 $dec2 =  str_pad($dec2,$maxdec,"0",STR_PAD_RIGHT);
 $ent1 = $a[0];
 $ent2 = $b[0];

return $ent1.".".$dec1." &plusmn; ".$ent2.".".$dec2;
}

  if (empty($datos)){
    echo "Select trayectories to compare</div></div>";
  } else {

 ?>


<table id="tabla-busqueda-avanzada" class="table table-striped tableAnalisys">

<thead class="thead-light">
  <tr>

      <th rowspan=3  class=" VerticaDivision">@lang('ID')</th>
      <th  rowspan=3  class="Bilayer_thickness VerticaDivision" style="color:white;background-color: cornflowerblue;">
        <span class="ttCompare" >
        @lang('Bilayer thickness') (nm) </span><span class=" bi bi-info-circle" title="Difference between the average position of the lipid headgroups of each leaflet over the last microsecond."></span>

          <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Bilayer_thickness')" title="Hide column"></a>
      </th>
      <th rowspan=3 class="Peptide-depth VerticaDivision"  style="color:white;background-color: chocolate;">
        <span class="ttCompare" >
        @lang('Peptide depth') (nm)
      </span><span class=" bi bi-info-circle" title="Distance between the average Z-coordinates of the peptide backbone and of the lipid headgroups of the closest leaflet. Negative values correspond to relative positions with the peptide within the membrane."></span>

      <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Peptide-depth')" title="Hide column"></a>
      </th>
      <th  rowspan=3 class="Tilt VerticaDivision" style="color:white;background-color: cornflowerblue;">
        <span class="ttCompare" >
        @lang('Tilt') (&deg)
      </span><span class=" bi bi-info-circle" title="Peptide tilt angle evolution, defined as the angle between the peptide helical axis and the bilayer normal."></span>
      <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Tilt')" title="Hide column"></a>
      </th>
      <th class="Z-coord VerticaDivision" colspan="6" style="color:white;background-color: chocolate;">
       <span class="ttCompare" >
         @lang('Z-coord') (nm)
       </span>
       <span class=" bi bi-info-circle" title="Z-coordinate, averaged for the different parts of the system: peptide, membrane, first and last backbone (BB) residue and upper or lower lipid headgroups (HG)."></span>
       <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Z-coord')" title="Hide column"></a>
      </th>
      <th class="Area VerticaDivision" colspan="3" style="color:white;background-color: cornflowerblue;">
        <span class="ttCompare" >@lang('Area per lipid')</span> (nm<sup>2</sup>) <span class=" bi bi-info-circle" title="Average area per lipid, per leaflet, along the trajectory."></span>
        <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Area')" title="Hide column"></a>
      </th>

      <th class="Contacts VerticaDivision" colspan="4" style="color:white;background-color: chocolate;"
      class="ttCompare">
      @lang('Contacts')
      <span class=" bi bi-info-circle" title="Number of contacts between the peptide and the water or the lipids separated by lipid headgroups (HG) or lipid tails (headgroups and tailgroups)."></span>
      <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('Contacts')" title="Hide column"></a>
      </th>


      <th class="PepDF" colspan="4" style="color:white;background-color: cornflowerblue;">
        @lang('PepDF')
      <span class=" bi bi-info-circle" title="Lateral displacement vs Rotational Displacement along the trajectory, for different time windows."></span>
      <a class="bi bi-eye-slash btn-sm" type="button" onclick="hidecol('PepDF')" title="Hide column"></a>
    </th>


  </tr>
  <tr>



      <th class="Z-coord" style="color:white;background-color: chocolate;" colspan="3" class="VerticaDivision">@lang('Peptide')</th>

      <th class="Z-coord VerticaDivision" style="color:white;background-color: chocolate;" colspan="3">@lang('Lipids') </th>


      <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;">@lang('Total')</th>
      <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;">@lang('Upper leaflet')</th>
      <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;">@lang('Lower leaflet')</th>

      <th class="Contacts VerticaDivision" style="color:white;background-color: chocolate;" class="VerticaDivision" colspan="3">@lang('Peptide-Lipids')</th>
      <th class="Contacts VerticaDivision" style="color:white;background-color: chocolate;" >@lang('Peptide Solvent')</th>

      <th class="PepDF" style="color:white;background-color: cornflowerblue;">@lang('5 (ns)')</th>
      <th class="PepDF" style="color:white;background-color: cornflowerblue;">@lang('50 (ns)')</th>
      <th class="PepDF" style="color:white;background-color: cornflowerblue;">@lang('100 (ns)')</th>
      <th class="PepDF" style="color:white;background-color: cornflowerblue;">@lang('200 (ns)')</th>
  </tr>
    <tr>



        <th class="Z-coord" style="color:white;background-color: chocolate;">@lang('Total')</th>
        <th class="Z-coord" style="color:white;background-color: chocolate;">@lang('BB first')</th>
        <th class="Z-coord VerticaDivision" style="color:white;background-color: chocolate;" >@lang('BB last')</th>
        <th class="Z-coord" style="color:white;background-color: chocolate;">@lang('Total')</th>
        <th class="Z-coord" style="color:white;background-color: chocolate;">@lang('Upper HG')</th>
        <th class="Z-coord VerticaDivision" style="color:white;background-color: chocolate;">@lang('Lower HG')</th>

        <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;"></th>
        <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;"></th>
        <th class="Area VerticaDivision" style="color:white;background-color: cornflowerblue;"></th>

        <th  class="Contacts  " style="color:white;background-color: chocolate;">@lang('Total')</th>
        <th  class="Contacts" style="color:white;background-color: chocolate;">@lang('Peptide-lipid HGs')</th>
        <th  class="Contacts VerticaDivision" style="color:white;background-color: chocolate;">@lang('Peptide-lipid tails')</th>
        <th  class="Contacts VerticaDivision" style="color:white;background-color: chocolate;"> </th>

        <th class="PepDF" style="color:white;background-color: cornflowerblue;"></th>
        <th class="PepDF" style="color:white;background-color: cornflowerblue;"></th>
        <th class="PepDF" style="color:white;background-color: cornflowerblue;"></th>
        <th class="PepDF" style="color:white;background-color: cornflowerblue;"></th>
    </tr>
</thead>
<tbody>



<?php

function countInRange($numbers,$lowest,$highest){
  //bounds are included, for this example
      return count(array_filter($numbers,function($number) use ($lowest,$highest){
    return ($lowest<=$number && $number <=$highest);
    }));
}

function recalcDataChart($values){

  sort($values,SORT_NUMERIC);

  $minval = min($values);
  $maxval = max($values);

  $interval =  round(sqrt(count($values)));

  $m1 = array();
  $m1_labels = array();

  //echo($minval." >> ".$maxval."<br>");
  $step = ($maxval-$minval)/$interval;
  //echo($step."<br>");
  for ($i=0; $i <= $interval ; $i++) {
    $ini = $minval+($step*$i);

    $dataNum[]=countInRange($values,$ini,$ini+$step);
    $labels[]=$ini+($step*0.5);//.">".round(($ini+$step),2);
    //echo($ini." :: ".($ini+$step)."<br>");
  }
  //var_dump($dataNum);

  $datas = array();
  $datas[]= $labels;
  $datas[]= $dataNum;
  $datas[]= $step;
  $datas[]= $minval;
  $datas[]= $maxval;
//die();
  return $datas;
}

$mem_model_name = array();
$mem_model_value = array();

$listaCampos[] = array("id"=>"Bilayer_thickness","label"=>"Bilayer_thickness","labelx"=>"Thickness (nm)","tooltip"=>"Difference between the average position of the lipid headgroups of each leaflet over the last microsecond.");

$listaCampos[] = array("id"=>"Protein_depthness","label"=>"Protein_depthness","labelx"=>"Depth (nm)","tooltip"=>"Distance between the average Z-coordinates of the peptide backbone and of the lipid headgroups of the closest leaflet. Negative values correspond to relative positions with the peptide within the membrane.");
$listaCampos[] = array("id"=>"Tilt","label"=>"Tilt","labelx"=>"Tilt (º)","tooltip"=>"Peptide tilt angle evolution, defined as the angle between the peptide helical axis and the bilayer normal.");

$listaCampos[] = array("id"=>"COG_of_protein","label"=>"COG_of_protein","labelx"=>"z-coord (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"COG_of_membrane","label"=>"COG_of_membrane","labelx"=>"z-coord (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"COG_BB_first","label"=>"COG_BB_first","labelx"=>"z-coord (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"COG_BB_last","label"=>"COG_BB_last","labelx"=>"z-coord (nm)","tooltip"=>"");

$listaCampos[] = array("id"=>"COG_headgroups_upper_leaflet","label"=>"COG_headgroups_upper_leaflet","labelx"=>"z-coord (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"COG_headgroups_lower_leaflet","label"=>"COG_headgroups_lower_leaflet","labelx"=>"z-coord (nm)","tooltip"=>"");



$listaCampos[] = array("id"=>"Area_per_lipid","label"=>"Area_per_lipid","labelx"=>"Area (nm2)","tooltip"=>"");
$listaCampos[] = array("id"=>"Area_per_lipid_upper_leaflet","label"=>"Area_per_lipid_upper_leaflet","labelx"=>"Area (nm2)","tooltip"=>"");
$listaCampos[] = array("id"=>"Area_per_lipid_lower_leaflet","label"=>"Area_per_lipid_lower_leaflet","labelx"=>"Area (nm2)","tooltip"=>"");

$listaCampos[] = array("id"=>"Contacts_Protein-lipids","label"=>"Contacts_Protein-lipids","labelx"=>"Contacts","tooltip"=>"");
$listaCampos[] = array("id"=>"Contacts_Protein-solvent","label"=>"Contacts_Protein-solvent","labelx"=>"Contacts","tooltip"=>"");
$listaCampos[] = array("id"=>"Contacts_Protein-headgroups","label"=>"Contacts_Protein-headgroups","labelx"=>"Contacts","tooltip"=>"");
$listaCampos[] = array("id"=>"Contacts_Protein-tailgroups","label"=>"Contacts_Protein-tailgroups","labelx"=>"Contacts","tooltip"=>"");


$listaCampos[] = array("id"=>"PepDF_5_distance","label"=>"PepDF_5_distance","labelx"=>"PepDF 5 (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"PepDF_5_angle","label"=>"PepDF_5_angle","labelx"=>"PepDF 5 (º)","tooltip"=>"");

$listaCampos[] = array("id"=>"PepDF_50_distance","label"=>"PepDF_50_distance","labelx"=>"PepDF 50 (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"PepDF_50_angle","label"=>"PepDF_50_angle","labelx"=>"PepDF 50 (º)","tooltip"=>"");

$listaCampos[] = array("id"=>"PepDF_100_distance","label"=>"PepDF_100_distance","labelx"=>"PepDF 100 (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"PepDF_100_angle","label"=>"PepDF_100_angle","labelx"=>"PepDF 100 (º)","tooltip"=>"");

$listaCampos[] = array("id"=>"PepDF_200_distance","label"=>"PepDF_200_distance","labelx"=>"PepDF 200 (nm)","tooltip"=>"");
$listaCampos[] = array("id"=>"PepDF_200_angle","label"=>"PepDF_200_angle","labelx"=>"PepDF 200 (º)","tooltip"=>"");


  foreach ($datos as $key => $value) {
    echo("<tr>");
    /*foreach ($value as $key2 => $value2) {
      echo("<td>");
      echo($value2);
      echo("</div>");
    }*/

    //$mem_model_name[]=$value->Bilayer_thickness;
    for ($i=0; $i < count($listaCampos); $i++) {
        try{
            $mem_model_value[$i][]=$value->{$listaCampos[$i]['id']};
        } catch(Exception $e) {
	           //echo 'Message: ' . $e->getMessage();
        }
    }


    ?>
    <td>

    <a class="btn btn-primary btn-sm" href="{{ route('trayectorias.show', $value->trajectory_id) }}">SP{{$value->trajectory_id}}</a>
    </td>
        <td class="Bilayer_thickness VerticaDivision" style="color:white;background-color: cornflowerblue;">
        <?php
        //echo (IgualaDecimales($value->Bilayer_thickness,$value->Bilayer_thickness_std));
        ?>
        </td>

        <td class="Peptide-depth VerticaDivision" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->Protein_depthness,$value->Protein_depthness_std));
        ?>
        </td>

        <td class="Tilt VerticaDivision" style="color:white;background-color: cornflowerblue;">
        <?php
        //echo (IgualaDecimales($value->Tilt,$value->Tilt_std));
        ?>
        </td>

        <td class="Z-coord" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->COG_of_protein,$value->COG_of_protein_std));
        ?>
        </td>

        <td class="Z-coord" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->COG_BB_first,$value->COG_BB_first_std));
        ?>
        </td >
        <td class="Z-coord" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->COG_BB_last,$value->COG_BB_last_std));
        ?>
        </td>
        <td class="Z-coord" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->COG_of_membrane,$value->COG_of_membrane_std));
        ?>
        </td >

        <td class="Z-coord" style="color:white;background-color: chocolate;">
        <?php
        //echo (IgualaDecimales($value->COG_headgroups_upper_leaflet,$value->COG_headgroups_upper_leaflet_std));
        ?>
        </td>
        <td class="Z-coord VerticaDivision" style="color:white;background-color: chocolate;">
          <?php
          //echo (IgualaDecimales($value->COG_headgroups_lower_leaflet,$value->COG_headgroups_lower_leaflet_std));
          ?>

        </td>



        <td class="Area VerticaDivision" style="background-color: cornflowerblue;">
          <?php
          //echo (IgualaDecimales($value->Area_per_lipid,$value->Area_per_lipid_std));

          ?>
        </td>

        <td class="Area VerticaDivision" style="background-color: cornflowerblue;">
        <?php
        //echo (IgualaDecimales($value->Area_per_lipid_upper_leaflet,$value->Area_per_lipid_upper_leaflet_std));
        ?>
        </td>

        <td class="Area VerticaDivision" style="background-color: cornflowerblue;">
        <?php
        //echo (IgualaDecimales($value->Area_per_lipid_lower_leaflet,$value->Area_per_lipid_lower_leaflet_std));
        ?>

        </td>

        <td  class="Contacts" style="background-color: chocolate;">
        <?php
        //echo(IgualaDecimales($value->{'Contacts_Protein-lipids'},$value->{'Contacts_Protein-lipids_std'}));
         ?>
        </td>
        <td  class="Contacts" style="background-color: chocolate;">
        <?php
          //echo (IgualaDecimales($value->{'Contacts_Protein-headgroups'},$value->{'Contacts_Protein-headgroups_std'}));
        ?>
        </td>
        <td  class="Contacts VerticaDivision" style="background-color: chocolate;">
        <?php
         //echo (IgualaDecimales($value->{'Contacts_Protein-tailgroups'},$value->{'Contacts_Protein-tailgroups_std'}));
        ?>
        </td>
        <td  class="Contacts VerticaDivision" style="background-color: chocolate;">
        <?php
        //echo(IgualaDecimales($value->{'Contacts_Protein-solvent'},$value->{'Contacts_Protein-solvent_std'}));
        ?>
        </td>


        <td class="PepDF" style="color:white;background-color: cornflowerblue;">
        <span class="DistanceCol">Dist (nm):
          <?php
          //echo (IgualaDecimales($value->PepDF_5_distance,$value->PepDF_5_distance_std));
          ?>
          </span>
         <br>
        <span class="angleCol">Angle (&deg;):

          <?php
          //echo (IgualaDecimales($value->PepDF_5_angle,$value->PepDF_5_angle_std));
          ?>

        </span>
        </td>

        <td class="PepDF" style="color:white;background-color: cornflowerblue;">
        <span class="DistanceCol">
         <?php
         //echo (IgualaDecimales($value->PepDF_50_distance,$value->PepDF_50_distance_std));
         ?>
         </span>
        <br>
        <span class="angleCol">
          <?php
          //echo (IgualaDecimales($value->PepDF_50_angle,$value->PepDF_50_angle_std));
          ?>
        </span>
        </td>

        <td class="PepDF" style="color:white;background-color: cornflowerblue;">
        <span class="DistanceCol">
          <?php
          //echo (IgualaDecimales($value->PepDF_100_distance,$value->PepDF_100_distance_std));
          ?>
          </span>
        <br>
        <span class="angleCol">

          <?php
          //echo (IgualaDecimales($value->PepDF_100_angle,$value->PepDF_100_angle_std));
          ?>
          </span>
        </td>

        <td class="PepDF" style="color:white;background-color: cornflowerblue;">
        <span class="DistanceCol">
          <?php
          //echo (IgualaDecimales($value->PepDF_200_distance,$value->PepDF_200_distance_std));
          ?>
          </span>
        <br>
        <span class="angleCol">
          <?php
          //echo (IgualaDecimales($value->PepDF_200_angle,$value->PepDF_200_angle_std));
          ?>
          </span>
        </td>



</tr>

<?php
} // Fin bucle pintar datos
   ?>

</table>



<?php
    // Preparando los datos para las graficas
    $listDatas = array();
    for ($i=0; $i <count($mem_model_value) ; $i++) {
      $listDatas[] = recalcDataChart($mem_model_value[$i]);
    }

?>
   </div>
</div>
<div class="container p-4 p-lg-5 h-100" style="background-Color:white;">

<h3> Statistics</h3>

  <div class="row p-4">

      <div class="{{$TresCol}} ">
            <div class="pt-4 titulochart" style="text-align:center" >
               @lang($listaCampos[0]['label'])
                 <span class=" bi bi-info-circle" title="<?=$listaCampos[0]['tooltip']?>"></span>
            </div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[0]['id']?>" ></canvas>

      </div>
      <div class="{{$TresCol}}  ">
            <div class="pt-4 titulochart" style="text-align:center" >
               @lang($listaCampos[1]['label'])
                 <span class=" bi bi-info-circle"title="<?=$listaCampos[1]['tooltip']?>"></span>
            </div>
            <canvas class="pb-4  chartStatCenter" id="<?=$listaCampos[1]['id']?>" ></canvas>

      </div>
      <div class="{{$TresCol}}  ">
            <div class="pt-4 titulochart" style="text-align:center" >
               @lang($listaCampos[2]['label'])
                 <span class=" bi bi-info-circle" title="<?=$listaCampos[2]['tooltip']?>"></span>
            </div>
            <canvas class="pb-4  chartStatCenter" id="<?=$listaCampos[2]['id']?>"  ></canvas>

      </div>

 </div>
  <div class="row p-4">
    <div>
      <hr style="height:2px;border-width:0;color:gray;background-color:gray">
      <div class="ttCompare text-center pt-4 titulochart" >@lang('Z-coord') (nm)
      <span class=" bi bi-info-circle" title="Z-coordinate, averaged for the different parts of the system: peptide, membrane, first and last backbone (BB) residue and upper or lower lipid headgroups (HG)."></span>
      </div>
    </div>
  </div>

  <div class="row">
    <div>
      <div class="ttCompare text-center pt-4 subtitulochart" >@lang('Peptide')   </div>
    </div>
  </div>

  <div class="row pb-4 pt-2">

      <div class="c{{$TresCol}} ">
            <div class="pt-4" style="text-align:center" >Peptide</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[3]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}}">
            <div class="pt-4" style="text-align:center" >Peptide first BB</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[5]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}}">
            <div class="pt-4" style="text-align:center" >Peptide last BB</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[6]['id']?>"></canvas>

      </div>

  </div>

  <div class="row pt-4">
    <div>
      <div class="ttCompare text-center pt-4 subtitulochart" >@lang('Lipids')</div>
    </div>
  </div>

  <div class="row p-2">

      <div class="{{$TresCol}} ">
            <div class="pt-4" style="text-align:center" >Lipids</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[4]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}}">
            <div class="pt-4" style="text-align:center" >Lipids upper HGs</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[7]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}} ">
            <div class="pt-4" style="text-align:center" >Lipids lower HGs</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[8]['id']?>"></canvas>

      </div>

  </div>

  <div class="row p-4">
    <div>
      <hr style="height:2px;border-width:0;color:gray;background-color:gray">
      <div class="ttCompare text-center pt-4 titulochart" >@lang('Area per lipid') (nm<sup>2</sup>)
      <span class=" bi bi-info-circle" title="Average area per lipid, per leaflet, along the trajectory."></span>
      </div>
    </div>
  </div>

  <div class="row p-2">

      <div class="{{$TresCol}} ">
            <div class="pt-4" style="text-align:center" >Total</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[9]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}}">
            <div class="pt-4" style="text-align:center" >Upper leaflet</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[10]['id']?>"></canvas>
      </div>
      <div class="{{$TresCol}}">
            <div class="pt-4" style="text-align:center" >Lower leaflet</div>
            <canvas class="pb-4 chartStatCenter" id="<?=$listaCampos[11]['id']?>"></canvas>

      </div>

  </div>

  <div class="row p-4">
    <div>
      <hr style="height:2px;border-width:0;color:gray;background-color:gray">
      <div class="ttCompare text-center pt-4 titulochart" >@lang('Contacts') (nm)
      <span class=" bi bi-info-circle" title="Number of contacts between the peptide and the water or the lipids (headgroups and tailgroups)."></span>
      </div>
    </div>
  </div>

  <div class="row p-2">

      <div class="{{$DosCol}}">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[12]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[12]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}}">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[13]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[13]['id']?>"></canvas>
      </div>
          <div class="{{$DosCol}}">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[14]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[14]['id']?>"></canvas>

      </div>
          <div class="{{$DosCol}}">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[15]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[15]['id']?>"></canvas>

      </div>

  </div>


  <div class="row p-4">
    <div>
      <hr style="height:2px;border-width:0;color:gray;background-color:gray">
      <div class="ttCompare text-center pt-4 titulochart" >@lang('PepDF') (nm)
      <span class=" bi bi-info-circle" title="Lateral displacement vs Rotational Displacement along the trajectory, for different time windows."></span>
      </div>
    </div>
  </div>

  <div class="row p-2">

      <div class=" {{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[16]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[16]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[17]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[17]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[18]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[18]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[19]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;"  id="<?=$listaCampos[19]['id']?>"></canvas>
      </div>

      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[20]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;"  id="<?=$listaCampos[20]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[21]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[21]['id']?>"></canvas>
      </div>

      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[22]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;"  id="<?=$listaCampos[22]['id']?>"></canvas>
      </div>
      <div class="{{$DosCol}} ">
            <div class="pt-4" style="text-align:center" > @lang($listaCampos[23]['label'])</div>
            <canvas class="pb-4 chartStatCenter" style="padding: 0;margin: auto;display: block;" id="<?=$listaCampos[23]['id']?>"></canvas>
      </div>

  </div>



</div>

 <!--  El pie tiene que estar aqui-->
<div style="padding-top: 50px;">
 @include('layouts.foot')
</div>
</div>


<script>

function hidecol(name) {
  $("."+name).hide();
}
  $.dragScroll = function(options) {
    var settings = $.extend({
      scrollVertical: true,
      scrollHorizontal: true,
      cursor: null
    }, options);

    var clicked = false,
      clickY, clickX;

    var getCursor = function() {
      if (settings.cursor) return settings.cursor;
      if (settings.scrollVertical && settings.scrollHorizontal) return 'move';
      if (settings.scrollVertical) return 'row-resize';
      if (settings.scrollHorizontal) return 'col-resize';
    }

    var updateScrollPos = function(e, el) {
      $('html').css('cursor', getCursor());
      var $el = $(el);
    //  console.log($el.scrollLeft() + " :: " + (clickX - e.pageX));

      settings.scrollVertical && $el.scrollTop($el.scrollTop() + (clickY - e.pageY));
      settings.scrollHorizontal && $el.scrollLeft($el.scrollLeft() + (clickX - e.pageX)*0.1);
      //$( "#table-responsive" ).scrollLeft( 300 );
      //$el.scrollLeft($el.scrollLeft() + (clickX - e.pageX));
    }


    $(".table-responsive").on({
      'mousemove': function(e) {
        clicked && updateScrollPos(e, this);
      },
      'mousedown': function(e) {
        clicked = true;
        clickY = e.pageY;
        clickX = e.pageX;
      },
      'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
      }
    });
  }

  $( "#tabla-busqueda-avanzada" ).scrollLeft( 300 );

$.dragScroll();


$(document).ready(function(){
   $(".ttCompare").tooltip();

   $("#app").addClass('expandCompare');

});

  /*$( function() {
    $( document ).tooltip({
      track: true
    });
  } );*/
  </script>

<script>
function DrawChart(canvasId,names,data,step,chartType,title,labelx,labely,minlim,maxlim,responsive) {

 var labels1 =  names;
 var ArrayTop = data;
 var coorData = new Array();

 var colorList = ['#FF9AA2','#C7CEEA','#FFB7B2','#B5EAD7','#FFDAC1','#E2F0CB',];
 var borderCol =  'rgb(128, 128, 128)';
 var textCol =  '#ffffff';

for (var i = 0; i < data.length; i++) {
  let da = {"x":names[i],"y":data[i]};

  coorData.push(da);
}

//console.log(coorData);
//console.log(step);

//console.log();
 var dataTop = {
   //labels: labels1,

   datasets: [{
     label: title,
     backgroundColor: colorList,
     borderColor: borderCol,
     data: coorData,
     barPercentage :1,
     categoryPercentage:1,
   }]
 };

//console.log(minlim+ " " + maxlim );
 var options = {
   maintainAspectRatio: true,
   responsive: responsive,
   scales:{
     x:{
       bounds:"ticks",
       suggestedMin: minlim,
       suggestedMax: maxlim,
       min:minlim,
       max :maxlim + step,

       type: 'linear',
       offset: false,

       title:{
           display:true,
           text:labelx,
       },

       grid :{
           offset: false,
       },

       ticks:{
         stepSize: step,
         beginAtZero:false,
         sampleSize:step,
         callback: function(value, index, values) {
               return  Number(value).toFixed(2).toLocaleString('en');
           }
       },
     },
     y:{
       title:{
         display:true,
         text:labely,
       },
     },
   },
   plugins:{
     title:{
       display:false,
       text:title,
     },
     legend :{
       display:false,
     },
     tooltip:{
       callbacks:{
         title: (items) => {
           if(!items.length){
             return '';
           }
           const item = items[0];
           const x= item.parsed.x;
           const y= item.parsed.y;
           return `${y}`;
         },
         label: (items)=>{
           return ``;
         },
       },
     },
   },

 };


 var config1 = {
   type: chartType, //'doughnut',
   data : dataTop,
   options: options,
 };


 var ctx1 = document.getElementById(canvasId);

 var myChart1 = new Chart(ctx1,config1);

 //var size = '200px';
 var size = '90%';

 myChart1.canvas.parentNode.style.height = size;
 myChart1.canvas.parentNode.style.width = size;
}

<?php
  for ($i=0; $i < count($listaCampos);$i++) {

/*
 DrawChart('{{ $listaCampos[$i]['id'] }}'
            ,{{json_encode($listDatas[$i][0])}}
            ,{{ json_encode($listDatas[$i][1]) }}
            ,{{ $listDatas[$i][2] }}
            ,'bar'
            ,'@lang($listaCampos[$i]['label'])'
            ,'@lang($listaCampos[$i]['labelx'])'
            ,'# trajectories'
            ,{{$listDatas[$i][3]}}
            ,{{$listDatas[$i][4]}}
            ,false);
*/

}
?>

</script>


 <?php
 }
  ?>

 @endsection
