<?php

use App\Trayectoria;
use \Illuminate\Filesystem\Filesystem;


/**
 * @var Trayectoria $trayectoria
 */
 /**@php
 *  var_dump($trayectoria);
 *  @endphp
   */
?>
@extends('layouts.app')


@section('content')


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

//   echo($minval." >> ".$maxval." :: ".count($values)."<br>");
  $step = ($maxval-$minval)/$interval;
//  echo($step."<br>");
  for ($i=0; $i < $interval ; $i++) {
     $ini = $minval+($step*$i);
     $con = countInRange($values,$ini,$ini+$step);
    $dataNum[]=$con;
    $labels[]=$ini+($step*0.5);//.">".round(($ini+$step),2);

  }

  $datas = array();
  $datas[]= $labels;
  $datas[]= $dataNum;
  $datas[]= $step;
  $datas[]= $minval;
  $datas[]= $maxval;

  //var_dump($dataNum);
//echo("<br>");
  return $datas;
}


// Datos de Membrana
//echo('Membrane model <hr>');
$mem_model_name = array();
$mem_model_value = array();
  foreach ($membranas as $key => $value) {
   //echo $value->name.':'.$value->total.'<br>';
     $mem_model_name[] = ucfirst($value->name);
     $mem_model_value[] = $value->total;
 }

// echo('<br><br>Peptide Activity <hr>');
$PeptideActivity_name = array();
$PeptideActivity_value = array();
  foreach ($PeptideActivity as $key => $value) {
    //echo $value->activity.':'.$value->total.'<br>';
    $PeptideActivity_name[] = ucfirst($value->activity);
    $PeptideActivity_value[] = $value->total;
  }

$PeptideLength_name = array();
$PeptideLength_value = array();
 //echo('<br><br>Peptide Length <hr>');
  foreach ($PeptideLength as $key => $value) {
    //echo $value->length.':'.$value->total.'<br>';
    $PeptideLength_name[] = ucfirst($value->length);
    $PeptideLength_value[] = $value->total;

  }


  //echo('<br><br>Peptide Total Charge <hr>');
$PeptideCharge_name = array();
$PeptideCharge_value = array();
  foreach ($PeptideCharge as $key => $value) {
    //echo $value->total_charge.':'.$value->total.'<br>';
    $PeptideCharge_name[] = ucfirst($value->total_charge);
    $PeptideCharge_value[] = $value->total;
  }


//echo('<br><br>PeptideElectrostatic_dipolar_moment <hr>');
$Electrostatic_dipolar_moment_name = array();
$Electrostatic_dipolar_moment_value = array();
foreach ($Electrostatic_dipolar_moment_values as $key => $value) {
  //echo $value->electrostatic_dipolar_moment.':'.$value->total.'<br>';
  $Electrostatic_dipolar_moment_value[] = $value->total;
  $Electrostatic_dipolar_moment_name[] = $value->electrostatic_dipolar_moment;
}
//echo ("Electrostatic_dipolar_moment"." :: ".count($Electrostatic_dipolar_moment) );
// Hay que procesar los datos para que funcione en modo histograma
$Electrostatic_dipolar_moment_value_process = recalcDataChart($Electrostatic_dipolar_moment_name);
//var_dump($Electrostatic_dipolar_moment_value_process);
//echo('<br><br>Hydrophobic dipolar moment <hr>');
$Hydrophobic_dipolar_moment_name = array();
$Hydrophobic_dipolar_moment_value = array();
foreach ($Hydrophobic_dipolar_moment_values as $key => $value) {
  //echo $value->hydrophobic_dipolar_moment.':'.$value->total.'<br>';
  $Hydrophobic_dipolar_moment_value[] =  $value->total;
  $Hydrophobic_dipolar_moment_name[] = $value->hydrophobic_dipolar_moment;
}

// Hay que procesar los datos para que funcione en modo histograma
$Hydrophobic_dipolar_moment_value_process = recalcDataChart($Hydrophobic_dipolar_moment_name);


?>

      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-12">

                  <div class="row m-2 p-4" style="background-color:#e4e4e46b;">
                    <div>
                      <div class="row">
                        <div class="col">
                        <h5>Total Trajectories :  {{$totalTrayectorias}}</h5>
                        </div>
                        <div class="col">
                        <h5>Total Membranes :  {{$totalMembranas}}</h5>
                      </div>
                      </div>
                    </div>
                  </div>

                  <div class="row m-xs-0 m-sm-2  pt-xs-0 pt-sm-2 " style="background-color:#e4e4e46b;">
                    <div>
                      <div class="row pt-xs-0 pt-sm-2 ">
                        <div class="col-sm-12 col-md-6  chart-containes text-center">
                            <canvas id="PeptideModelChart" style=" margin: 0 auto;" > </canvas>
                          </div>
                          <div class="col-sm-12 col-md-6 chart-containes text-center">
                            <canvas id="PeptideActivity" style=" margin: 0 auto;" > </canvas>
                          </div>
                        </div>
                        <div class="row  pt-xs-0 pt-sm-2 ">
                          <div class="col-sm-12 col-md-6 chart-containes text-center">
                            <canvas id="PeptideLength"  > </canvas>
                          </div>
                          <div class="col-sm-12 col-md-6 chart-containes text-center">
                            <canvas id="PeptideCharge"  > </canvas>
                          </div>
                        </div>

                        <div class="row  pt-xs-0 pt-sm-2 ">

                          <div class="col-sm-12 col-md-6 chart-containes text-center">
                            <canvas id="Electrostatic_dipolar_moment" > </canvas>
                          </div>
                          <div class="col-sm-12 col-md-6 chart-containes text-center">
                            <canvas id="Hydrophobic_dipolar_moment"  > </canvas>
                        </div>
                      </div>
                    </div>

                  </div>

    </div>
  </div>
</div>



    <script>
     // === include 'setup' then 'config' above ===

function DrawChart(canvasId,names,data,step,chartType,title,labelX,labelY,gridOn,responsive) {

    var labels1 =  names;
    var ArrayTop = data;

    var colorList = ['#FF9AA2','#C7CEEA','#FFB7B2','#B5EAD7','#FFDAC1','#E2F0CB',];
    var borderCol =  'rgb(128, 128, 128)';
    var textCol =  '#ffffff';

    var dataTop = {
      labels: labels1,

      datasets: [{
        label: title,
        backgroundColor: colorList,
        borderColor: borderCol,
        data: ArrayTop,
      }]
    };

    var options = {
      maintainAspectRatio: true,
      responsive: responsive,
      plugins: {
          title:{
            display:true,
            text:title,
          },
          legend: {
            display:false,
            position: 'top',
            labels: {
              display : true,
              color: 'rgb(0, 255, 255)'
                  },
            title :{
              display : true,
              text : title,
              color: 'rgb(255, 255, 255)'
            },

          },
          tooltip: {
            callbacks:{
              title: (items) =>{
                const item = items[0].parsed;
                  return items[0].label+` : ` + items[0].parsed;
              },
               label: (items)=>{
                return ``;
              },
            },
          },
        },
        scales: {
            x: {
              //type: 'linear',
              grid: {
                        display: gridOn,
                        drawBorder: gridOn,
                        drawOnChartArea: gridOn,
                        drawTicks: gridOn,
                      },
              display: true,
              title: {
                      display: true,
                      text: labelX,
                    },
              ticks:{
                    display:gridOn,
                    stepSize: step,
                    beginAtZero:true,
              },
            },
            y: {
              //  type: 'linear',
              grid: {
                        display: gridOn,
                        drawBorder: gridOn,
                        drawOnChartArea: gridOn,
                        drawTicks: gridOn,
                      },
              display: true,
              title: {
                display: true,
                text: labelY,
              },
              ticks:{
                  display: gridOn,

              },
            }
          }

    };

    var config1 = {
      type: chartType, //'doughnut',
      data : dataTop,
      options: options,
    };


    var ctx1 = document.getElementById(canvasId);

    var myChart1 = new Chart(ctx1,config1);

    //var size = '350px';
    var size = '90%';

    myChart1.canvas.parentNode.style.height = size;
    myChart1.canvas.parentNode.style.width = size;
}


function DrawChartHistogram(canvasId,names,data,step,chartType,title,labelX,labelY,minlim,maxlim,responsive) {


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

   var dataTop = {
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
         min: minlim,
         max: maxlim,

         type: 'linear',
         offset: false,

         title:{
           display:true,
           text:labelX,
         },

         grid :{
           offset: false, // false para tene la raya vertical en el numero

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
           text: labelY,
         },
       },
     },
     plugins:{
       title:{
         display:true,
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

   var size = '90%';

   myChart1.canvas.parentNode.style.height = size;
   myChart1.canvas.parentNode.style.width = size;
}


    </script>


    <script>
    DrawChart("PeptideModelChart",<?php echo(json_encode($mem_model_name)) ?>,<?php echo(json_encode($mem_model_value)) ?>,1,'doughnut','Membrane model','','',false,false);
    DrawChart("PeptideActivity",<?php echo(json_encode($PeptideActivity_name)) ?>,<?php echo(json_encode($PeptideActivity_value)) ?>,1,'doughnut','Peptide activity','','',false,false);

    DrawChart("PeptideLength",<?php echo(json_encode($PeptideLength_name)) ?>,<?php echo(json_encode($PeptideLength_value)) ?>,1,'bar','Peptide length','Length (nm)','# trajectories',true,true);
    DrawChart("PeptideCharge",<?php echo(json_encode($PeptideCharge_name)) ?>,<?php echo(json_encode($PeptideCharge_value)) ?>,1,'bar','Peptide charge','Charge (e)','# trajectories',true,true);

    DrawChartHistogram("Electrostatic_dipolar_moment",
                        {{ json_encode($Electrostatic_dipolar_moment_value_process[0]) }},
                        {{ json_encode($Electrostatic_dipolar_moment_value_process[1]) }},
                        {{ $Electrostatic_dipolar_moment_value_process[2] }},
                        'bar',
                        'Peptide Electrostatic Dipolar Moment',
                        'Electrostatic Dipolar Moment (e nm)'
                        ,'# trajectories',
                        {{ $Electrostatic_dipolar_moment_value_process[3] }},
                        {{ $Electrostatic_dipolar_moment_value_process[4] }},
                        true);
    DrawChartHistogram("Hydrophobic_dipolar_moment",
                        {{ json_encode($Hydrophobic_dipolar_moment_value_process[0]) }},
                        {{ json_encode($Hydrophobic_dipolar_moment_value_process[1]) }} ,
                        {{ $Hydrophobic_dipolar_moment_value_process[2] }},
                        'bar',
                        'Peptide Hydrophobic Dipolar Moment',
                        'Hydrophobic Dipolar Moment (nm)',
                        '# trajectories',
                        {{ $Hydrophobic_dipolar_moment_value_process[3] }},
                        {{ $Hydrophobic_dipolar_moment_value_process[4] }},
                        true);


    </script>
@endsection
