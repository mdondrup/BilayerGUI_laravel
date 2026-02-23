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
    DrawChart('membraneModel',mem_model_name,$mem_model_value,1,'bar','Membrane model distribution','Membrane model','Count',true,true);
    </script>
@endsection
