<?php

use App\Trayectoria;

/**
 * @var Trayectoria[] $trayectorias
 */

$DataStr = [];
$DataValue = [];
$DataError = '';
$maxValue = -INF;
$minValue = INF;

function randomcolor()
{
    return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
}

function IgualaDecimales($n1, $n2)
{
    $ent1 = $dec1 = $ent2 = $dec2 = '0';
    $a = explode('.', $n1);
    $b = explode('.', $n2);
    if (count($a) > 1) {
        $dec1 = $a[1];
    }
    if (count($b) > 1) {
        $dec2 = $b[1];
    }

    $maxdec = max(strlen($dec1), strlen($dec2));
    $dec1 = str_pad($dec1, $maxdec, '0', STR_PAD_RIGHT);
    $dec2 = str_pad($dec2, $maxdec, '0', STR_PAD_RIGHT);
    $ent1 = $a[0];
    $ent2 = $b[0];

    return $ent1 . '.' . $dec1 . ' &plusmn; ' . $ent2 . '.' . $dec2;
}

function countInRange($numbers, $lowest, $highest)
{
    //bounds are included, for this example
    return count(
        array_filter($numbers, function ($number) use ($lowest, $highest) {
            return $lowest <= $number && $number <= $highest;
        }),
    );
}

function recalcDataChart($values)
{
    sort($values, SORT_NUMERIC);

    $minval = min($values);
    $maxval = max($values);

    $interval = round(sqrt(count($values)));

    $m1 = [];
    $m1_labels = [];

    //echo($minval." >> ".$maxval."<br>");
    $step = ($maxval - $minval) / $interval;
    //echo($step."<br>");
    for ($i = 0; $i <= $interval; $i++) {
        $ini = $minval + $step * $i;

        $dataNum[] = countInRange($values, $ini, $ini + $step);
        $labels[] = $ini + $step * 0.5; //.">".round(($ini+$step),2);
        //echo($ini." :: ".($ini+$step)."<br>");
    }
    //var_dump($dataNum);

    $datas = [];
    $datas[] = $labels;
    $datas[] = $dataNum;
    $datas[] = $step;
    $datas[] = $minval;
    $datas[] = $maxval;

    return $datas;
}

function urlFileExist($file)
{
    $file_headers = @get_headers($file);
    if (!$file_headers || str_contains($file_headers[0], '400') || str_contains($file_headers[0], '404')) {
        $exists = false;
    } else {
        $exists = true;
    }

    return $exists;
}

function urlFileExist2($file)
{
    $file_headers = @get_headers($file);
    if ($file_headers && strpos($file_headers[0], '200')) {
        $exists = true;
    } else {
        $exists = false;
    }

    return $exists;
}

function CleanLabel($label)
{
    $label = str_replace('M_', '', $label);
    $label = str_replace('_M', '', $label);
    $labelExpl = explode(' ', $label);

    return $labelExpl[1];
}

// No todo los json tiene el mismo formato,
function genData2($GitHubURL, $FileUrl, &$labelData, &$data, &$maxData, &$minData, $mult)
{

    $jsonFileUrl = $GitHubURL . $FileUrl; //10    

    if (!urlFileExist2($jsonFileUrl)) {
        return false;
    } // salimos si no existe el fichero

    $jsonFile = file_get_contents($jsonFileUrl);
    $jsonFileData = json_decode($jsonFile);

    $labelData = '';
    $data = '';
    $maxData = -INF;
    $minData = INF;

    if ($mult == 0) {
        $fact = 1;
    } else {
        $fact = $mult;
    }

    foreach ($jsonFileData as $Values) {
        if ($minData > $Values[1]) {
            $minData = $Values[1];
        }
        if ($maxData < $Values[1]) {
            $maxData = $Values[1];
        }

        $labelData = $labelData . "'" . $Values[0] . "',";
        $normal = $Values[1] * $fact;
        $data = $data . "'" . $normal . "',";
    }

    $minData = round($minData - 0.5);
    $maxData = round($maxData + 0.5);

    return true;
}



function genDataParamOrde($GitHubURL, $FileUrl, &$labelData, &$data, &$dataerror, &$maxData, &$minData, $Grupo, $DataSetId, $ff)
{
    //    $jsonFileUrl = $GitHubURL.substr($FileUrl,31);//10

    $jsonFileUrl = $GitHubURL . $FileUrl; //10

    /*
    echo("--> ". $jsonFileUrl);
    echo("--> ". $FileUrl);
    die();
    */
    $jsonFile = file_get_contents($jsonFileUrl);
    $jsonFileData = json_decode($jsonFile);

    foreach ($jsonFileData as $label => $Values) {
        if (is_numeric($Values[0][0]) && is_numeric($Values[0][2])) {
            $Values[0][0] = $Values[0][0] * -1.0;

            if (str_contains($label, $Grupo)) {
                $labelCleaned = CleanLabel($label); // save al labels to create a unique array
                if ($labelCleaned == 'G1H1' || $labelCleaned == 'G1H2' || $labelCleaned == 'G2H1') {
                    // HACK THIS LABEL IS GONNA GOT TO HEAD GROUP
                } else {
                    $labelData[] = $labelCleaned;

                    // Create a asociative array with a molecule name with id and value
                    $data2 = [];
                    $data2['trajectory_id'] = $DataSetId;
                    $data2['value'] = $Values[0][0];
                    $data2['ff'] = $ff;

                    $data[CleanLabel($label)][] = $data2;
                }
                /*
                    $ymax = $Values[0][0]+$Values[0][2];
                    $ymin = $Values[0][0]-$Values[0][2];
                    $dataerror = $dataerror."{y:".$Values[0][0].", yMin:".$ymax.",yMax:".$ymin."},";
                */
            } else {
                //
                $labelCleaned = CleanLabel($label); // save al labels to create a unique array
                if ($labelCleaned == 'G1H1' || $labelCleaned == 'G1H2' || $labelCleaned == 'G2H1') {
                    if ($Grupo == 'G3') {
                        $labelData[] = $labelCleaned;

                        // Create a asociative array with a molecule name with id and value
                        $data2 = [];
                        $data2['trajectory_id'] = $DataSetId;
                        $data2['value'] = $Values[0][0];
                        $data2['ff'] = $ff;

                        $data[CleanLabel($label)][] = $data2;
                    }
                }
            }
        }
    }
}

?>



<script>
    function DrawChart(canvasId, names, data, data2, step, chartType, title, labelX, labelY, borde, radio, gridOn,
        responsive, AutoSkiping) {

        var labels1 = names;
        var ArrayTop = data;

        var colorList = ['#FF9AA2', '#C7CEEA', '#FFB7B2', '#B5EAD7', '#FFDAC1', '#E2F0CB', ];
        var borderCol = 'rgb(255, 255, 255)';
        var textCol = '#ffffff';

        var dataTop = {
            labels: labels1,

            datasets: [{
                label: title,
                backgroundColor: colorList,
                borderColor: borderCol,
                data: ArrayTop,
                radius: radio,
                borderWidth: borde,
            }]
        };

        var dataTop2 = {
            labels: labels1,
            datasets: data2
        };

        //if (data2 != '')

        dataTop = dataTop2;

        var options = {
            maintainAspectRatio: false,
            responsive: responsive,
            errorBarColor: {
                v: ['#ff0000', '#ff0000']
            },
            errorBarWhiskerColor: '#ff0000',
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: '#ffffff',

                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        display: true,
                        color: 'rgb(255, 255, 255)'
                    },
                    title: {
                        display: true,
                        text: title,
                        color: 'rgb(255, 255, 255)'
                    },
                },
                tooltip: {
                    callbacks: {
                        title: (items) => {
                            const item = items[0].parsed;
                            return items[0].label + ` : ` + items[0].parsed;
                        },
                        label: (items) => {
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
                        color: '#74C3D8'
                    },
                    display: true,
                    title: {
                        display: true,
                        text: labelX,
                        color: '#ffffff'
                    },
                    ticks: {
                        display: gridOn,
                        autoSkip: AutoSkiping,
                        stepSize: step,
                        beginAtZero: true,
                        color: '#eeeeee'
                    },
                },
                y: {
                    //  type: 'linear',
                    grid: {
                        display: gridOn,
                        drawBorder: gridOn,
                        drawOnChartArea: gridOn,
                        drawTicks: gridOn,
                        color: '#74C3D8'
                    },
                    display: true,
                    title: {
                        display: true,
                        text: labelY,
                        color: '#ffffff'
                    },
                    ticks: {
                        display: gridOn,
                        color: '#eeeeee'

                    },
                }
            }

        };

        var config1 = {
            type: chartType, //'doughnut',
            data: dataTop,
            options: options,
        };


        var ctx1 = document.getElementById(canvasId);

        var myChart1 = new Chart(ctx1, config1);

        //var size = '1024px';
        var size = '90%';

        myChart1.canvas.parentNode.style.width = size;
        myChart1.canvas.parentNode.style.height = size * 1;

    }


    function DrawChartHistogram(canvasId, names, data, step, chartType, title, labelX, labelY, minlim, maxlim,
        responsive) {


        var labels1 = names;
        var ArrayTop = data;
        var coorData = new Array();

        var colorList = ['#FF9AA2', '#C7CEEA', '#FFB7B2', '#B5EAD7', '#FFDAC1', '#E2F0CB', ];
        var borderCol = 'rgb(128, 128, 128)';
        var textCol = '#ffffff';

        for (var i = 0; i < data.length; i++) {
            let da = {
                "x": names[i],
                "y": data[i]
            };

            coorData.push(da);
        }

        var dataTop = {
            datasets: [{
                label: title,
                backgroundColor: colorList,
                borderColor: borderCol,
                data: coorData,
                barPercentage: 1,
                categoryPercentage: 1,

            }]
        };


        var options = {
            maintainAspectRatio: true,
            responsive: responsive,
            scales: {

                x: {
                    bounds: "ticks",
                    suggestedMin: minlim,
                    suggestedMax: maxlim,
                    min: minlim,
                    max: maxlim,

                    type: 'linear',
                    offset: false,

                    title: {
                        display: true,
                        text: labelX,
                        color: '#ffffff',
                    },

                    grid: {
                        offset: true, // false para tene la raya vertical en el numero
                        color: '#74C3D8'
                    },

                    ticks: {
                        color: '#ffffff',
                        stepSize: step,
                        beginAtZero: false,
                        sampleSize: step,
                        callback: function(value, index, values) {
                            return Number(value).toFixed(2).toLocaleString('en');
                        }

                    },
                },
                y: {

                    title: {
                        display: true,
                        text: labelY,
                        color: '#ffffff',
                    },
                    grid: {
                        color: '#74C3D8'
                    },
                    ticks: {
                        display: true,
                        color: '#ffffff',

                    },
                },
            },
            plugins: {
                title: {
                    display: false,
                    text: title,
                },
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        title: (items) => {
                            if (!items.length) {
                                return '';
                            }
                            const item = items[0];
                            const x = item.parsed.x;
                            const y = item.parsed.y;
                            return `${y}`;
                        },
                        label: (items) => {
                            return ``;
                        },
                    },
                },
            },

        };


        var config1 = {
            type: chartType, //'doughnut',
            data: dataTop,
            options: options,
        };


        var ctx1 = document.getElementById(canvasId);

        var myChart1 = new Chart(ctx1, config1);

        var size = '90%';

        myChart1.canvas.parentNode.style.width = size;
        myChart1.canvas.parentNode.style.height = size * 0.8;

    }
</script>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-right">
        <div class="col-md-12">
            <div class="txt-white ">
                <div class="d-flex p-4 justify-content-begin">
                    <?php
                    // Divido la URL para poder mandar los mismos parametros al exportador
                    $newlinkSel = 'exportcompare?selected=1';
                    ?>
                    <div class="p2">
                        <!--<a class="btn btn-primary btn-sm" href="<?php echo e($newlinkSel); ?>"> <?php echo app('translator')->get('Exportar seleccionado'); ?></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-body ">
    <div class="table-responsive txt-white">

        <?php

        $DosCol = "col-xs-12 col-sm-12 col-md-6 col-lg-6 p-4 ";
        $TresCol = "col-xs-12 col-sm-12 col-md-12 col-lg-4 p-4 ";

        //var_dump($datos);die();

        if (empty($datos)) {
            echo "Select trayectories to compare</div></div>";
        } else {
            //var_dump($datos);
            //die();
        ?>
    </div>
</div>

<div class="container" style="background-Color:#51515126;">
    <!--  p-4 p-lg-5 h-100 -->


    <div class="ttCompare text-center" style="color:white">
        <h1> Statistics</h1>
    </div>



    <?php

            $lista = array(); // Contiene el ID de trayectoria y el fichero
            $listaColores  = array();
            $chartData = array();
            //Quality
            $qualityTotal = array();
            $quality_headgroups = array();
            $quality_tails = array();

            $bilayer_thickness = array();
            $area_per_lipid = array();
            //$GitHubURL = "https://raw.githubusercontent.com/NMRLipids/Databank/main/";


            // Old version
            //$GitHubURL = "https://raw.githubusercontent.com/NMRLipids/Databank/main/Data/Simulations/";
            // New path
            $GitHubURL = 'https://raw.githubusercontent.com/NMRLipids/Databank/main/Data/';
            //https://raw.githubusercontent.com/NMRLipids/Databank/main/Data/Simulations/

            //var_dump($datos);die();
            // ---- FILE LIST ----
            // LISTA ID:: Fichero
            foreach ($datos as $key => $value) {
                //dd($value);

                // HACK!!!!!  ESTO NO SE PUEDE HACER, POR QUE SE CARGA LAS GRAFICAS
                //if ($value->quality_total != 0 && $value->quality_headgroups != 0 && $value->quality_tails) {

                $lista2 = array(); // array temporal
                $lista2['trajectory_id'] = $value->trajectory_id; // This is for the dataset
                $lista2['order'] = $value->order_parameters_file;
                $lista2['ff'] = $value->name;
                $lista2['temperature'] = $value->temperature;
                $lista2['quality_total'] = $value->quality_total;
                $lista2['quality_headgroups'] = $value->quality_headgroups;
                $lista2['quality_tails'] = $value->quality_tails;


                $qualityTotal[] = $value->quality_total; // for histogram of qualitygg
                $quality_headgroups[] = $value->quality_headgroups; // for histogram of qualitygg
                $quality_tails[] = $value->quality_tails; // for histogram of qualitygg
                // Nuevo
                $bilayer_thickness[] = $value->bilayer_thickness; // for histogram of qualitygg
                $area_per_lipid[] = $value->area_per_lipid; // for histogram of qualitygg

                $listaColores[$value->trajectory_id] = randomcolor();
                $lista[$value->molecule][] = $lista2;
                //  }
            }



            $qualityTotal_value_process = array();

            //if (is_array($qualityTotal) && count($qualityTotal) > 0)
            $qualityTotal_value_process = recalcDataChart($qualityTotal);

            // NUEVO
            $bilayer_thickness_value_process = array();
            //if (is_array($bilayer_thickness) && count($bilayer_thickness) > 0)
            $bilayer_thickness_value_process = recalcDataChart($bilayer_thickness);

            $area_per_lipid_value_process = array();
            //if (is_array($area_per_lipid) && count($area_per_lipid) > 0) 
            $area_per_lipid_value_process = recalcDataChart($area_per_lipid);


            // Tabla de comparacion de Quality

            $indices = array();
            $maxrows = 0;
            $maxcols = count($lista);
            $linea[] = array();
            $Nothing2Show = true;
            foreach ($lista as $key => $value) {
                //echo (count($value)."<br>");
                //echo ($key."<br>");
                if (count($value) > $maxrows) $maxrows = count($value);

                foreach ($value as $key2 => $value2) {
                    if ($value2["quality_total"] != 0 || $value2["quality_headgroups"] != 0 || $value2["quality_tails"] != 0) {
                        $Nothing2Show = false;
                    }
                    if (!in_array($value2["trajectory_id"], $indices))  $indices[] = $value2["trajectory_id"];
                }
                //$indices[] = $value["trajectory_id"];
                //var_Dump($value);
            }
            //var_dump($indices);
            //echo $maxrows."<br>".$maxcols;
            //die();
            for ($n = 0; $n < $maxrows; $n++) {
                // code...
                $mmm = array();
                for ($m = 0; $m < $maxcols; $m++) {
                    $mmm[] = "<td></td><td></td><td></td>";
                }
                $linea[$indices[$n]] = $mmm;
            }


            //var_dump($linea);
            //die();

            if ($Nothing2Show == false) {
                echo ('<table class="tableComp">');

                // CABECERA
                echo ("<th>ID</th>");
                //echo ("<th colspan=3>Quality</th>");

                foreach ($lista as $key2 => $value2) {
                    echo ('<th colspan=3 > ' . $key2 . ' Quality </th>');
                }

                echo ("<tr>");
                echo ("<td></td>");


                foreach ($lista as $key2 => $value2) {
                    echo ("<td>Total</td>");
                    echo ("<td>Headgroups</td>");
                    echo ("<td>Tails</td>");
                }
                echo ("</tr>");
                /*
                var_dump($datos);
                die();
            */


                // DATOS TABLA
                $volteo = array();

                $pos = 0;

                foreach ($lista as $key => $value) {


                    $pos2 = 0;

                    foreach ($value as $key2 => $value2) {


                        if (!isset($volteo[$pos2])) {
                            $volteo[$pos2] = "<tr>" . "<td>" . $value[$pos2]["trajectory_id"] . "</td>";
                            //$indices[] = $value[$pos2]["trajectory_id"];
                        }

                        // code...
                        //.$value[$pos2]["trajectory_id"]."->".$key."->"
                        $textcomp = "<td>" . round($value2["quality_total"], 2) . "</td>" . "<td>" . round($value2["quality_headgroups"], 2) . "</td>" . "<td>" . round($value2["quality_tails"], 2) . "</td>";

                        $volteo[$pos2] = $volteo[$pos2] . $textcomp;

                        $linea[$value[$pos2]["trajectory_id"]][$pos] = $textcomp;

                        if ($pos == (count($lista) - 1))
                            $volteo[$pos2] = $volteo[$pos2] . "</tr>";

                        $pos2 = $pos2 + 1;
                    }

                    $pos2 = 0;
                    $pos = $pos + 1;
                }


                foreach ($linea as $key => $value) {
                    if ($key != '0') {
                        $vale = 0;

                        foreach ($value as $key2 => $value2) {
                            if ($value2 == "<td></td><td></td><td></td>" || $value2 == "<td>0</td><td>0</td><td>0</td>") {
                                $vale = $vale + 1;
                            }
                        }
                        if ($vale != count($value)) {
                            echo ("<tr><td>" . $key . "</td>");
                            foreach ($value as $key2 => $value2) {
                                echo ($value2);
                            }
                            echo ("</tr>");
                        }
                    }
                }

                echo ("</table>");
            }
            /// ---- fin de la tabla de quality
            /*
        <div class="pt-4" style="text-align:center;">
            <h2>Form factor</h2>
        </div>
        <canvas id="formfactor"></canvas>
    </div>
    */


            echo ('<div class="row p-4"><div><div class="ttCompare text-center"><h2>Lipids</h2></div></div></div>');

            //  Creamos las solapas de cada peptido
            echo ('<div role="tabpanel" class="pt-4"><ul class="nav nav-tabs nav-tabs-conf" role="tablist">');
            $firstActive = 'active';
            foreach ($lista as $key2 => $value2) {
                echo ('<li role="presentation"  class="nav-item ">
    <a href="#home' . $key2 . '" class="nav-link ' . $firstActive . '" aria-controls="home' . $key2 . '" role="tab" data-toggle="tab">' . $key2 . '</a>
  </li>');
                $firstActive = '';
            }


            echo ('</ul>');


            // inicialiazo
            $labelData = "";
            $data = "";
            $dataerror = "";
            $maxData = -INF;
            $minData = INF;
            $DataStr = array();
            $DataValue = array();
            $dataSet = array();

            // ---- READ FILE ----
            // Procession la LISTA para Extraer los datos de los FICHEROS
            echo ('<div class="tab-content">');
            $firstActive = 'active';
            foreach ($lista as $key2 => $value2) {

                echo ('<div role="tabpanel" class="tab-pane bg-solapa card-datos ' . $firstActive . '" id="home' . $key2 . '" >');
                echo ("<div class='pt-4' style='text-align:center;'><h3>Order parameters</h3></div>");
                echo ("<span style='position: relative;left: 30px;top: 32px;'><h2>" . $key2 . "</h2></span><br>");
                $LipidName = $key2;
                $firstActive = '';
    ?>

        <div class="row p-2">
            <div class="chart-container" style=" margin-bottom:25px">
                <div class="pt-4" style="text-align:center;">
                    <h3>Tail S1</h3>
                </div>
                <canvas id="<?php echo $LipidName; ?>temp1"></canvas>
            </div>
            <div class="chart-container" style=" margin-bottom:25px">
                <div class="pt-4" style="text-align:center;">
                    <h3>Tail S2</h3>
                </div>
                <canvas id="<?php echo $LipidName; ?>temp2"></canvas>
            </div>
            <div class="chart-container" style=" margin-bottom:55px">
                <div class="pt-4" style="text-align:center;">
                    <h3>Headgroup</h3>
                </div>
                <canvas id="<?php echo $LipidName; ?>temp3"></canvas>
            </div>
        </div>

    <?php


                for ($i = 1; $i <= 3; $i++) {
                    // code...
                    $DataStr = array();
                    $DataValue = array();
                    $DataStrAdd = array();

                    //var_Dump($value2);die();
                    // Por cada LIPIDO abro todos los ficheros
                    foreach ($value2 as $key3 => $value3) {
                        //echo($value3['id']." --> ".$value3['order']."<br>");
                        if (urlFileExist2($GitHubURL . $value3['order'])) {
                            genDataParamOrde($GitHubURL, $value3['order'], $DataStr, $DataValue, $DataError, $maxValue, $minValue, "G" . $i, $value3['trajectory_id'], $value3['ff']);
                            // necesitamos datos adicionales que salgan en la grafica junto al id de trajectoria
                            $tempdataAdd = array();
                            $tempdataAdd['ff'] =   $value3['ff'];
                            $tempdataAdd['temp'] = $value3['temperature'];
                            $DataStrAdd[$value3['trajectory_id']] = $tempdataAdd;
                        }
                    }

                    // ------ 

                    $DataStr = array_values(array_unique($DataStr)); // el array unique borra los repetidos pero no reindexa con array values si.
                    $NumLabels = count($DataStr);
                    //var_dump($DataStr);die();
                    // los separamos en Datasets
                    //echo("Numero de labels en X : ".count($DataStr));
                    $nInxLabel = 0;
                    foreach ($DataStr as $LabelInx) {
                        //$datasetStr = $datasetStr . "{label : ".$datasetStr.$DataValue[$keyVal]['trajectory_id'].",data:[";

                        foreach ($DataValue[$LabelInx] as $keyid => $valueid) {
                            $nInxLabel = array_search($LabelInx, $DataStr);
                            $dataSet[$valueid['trajectory_id']][$nInxLabel] = $valueid['value'];
                        }
                    }

                    /*foreach ($DataStr as $key => $value) {
                        echo($key."->".$value."<br>");
                    }*/
                    $datasetStr = "[";
                    foreach ($dataSet as $key => $value) {
                        //echo($key."<br>");
                        $DataLabelExtra = "";
                        if (isset($DataStrAdd[$key]['ff']))
                            $DataLabelExtra .= ", " . $DataStrAdd[$key]['ff'];
                        if (isset($DataStrAdd[$key]['temp']))
                            $DataLabelExtra .= ", T= " . $DataStrAdd[$key]['temp'] . "K";

                        $datasetStr .= "{label:'" . $key . $DataLabelExtra . "', data: [";

                        $dataFloats = array();
                        foreach ($value as $key4 => $value4) {
                            //  echo($key2."->".$value2."<br>");
                            $dataFloats[] = $value4;
                        }
                        $datasetStr .= implode(",", $dataFloats) . "],type : 'scatter',borderColor: '#aaaaaa',backgroundColor: '" . $listaColores[$key] . "' },";
                    }

                    $datasetStr .= "]";

                    $dataXjs = "['" . implode("','", $DataStr) . "']";

                    echo ('<script>');
                    echo ('DrawChart("' . $LipidName . 'temp' . $i . '",' . $dataXjs . ',"",' . $datasetStr . ',1,"line","","","-SCH",1,5,true,true,false);');
                    echo ('</script>');
                }
                echo ('</div>');
            }

            /*
            if (!is_null($trayectoria->analisis)) {

                if (urlFileExist2($GitHubURL . $trayectoria->analisis->form_factor_file)) {
                    if (!is_null($trayectoria->analisis->form_factor_experiment)) {
                        if (genData2('https://www.databank.nmrlipids.fi/storage/', $trayectoria->analisis->form_factor_experiment . '/FormFactor.json', $DataExpStr, $DataExpValue, $maxValue, $minValue, $trayectoria->analisis->form_factor_scaling)) {
                        }
                    }

                    if (genData2($GitHubURL, $trayectoria->analisis->form_factor_file, $DataStr, $DataValue, $maxValue, $minValue, 1)) {
                        echo 'DrawChart("formfactor",[' . $DataStr . '],[' . $DataValue . '],[' . $DataExpValue . '],1,"line","Normalized Form factor","Qz (\u{212B}\u{AF}\u{B9}) ","Normalized |F(qz)|  (theta/\u{212B}\u{B2})",1,0,true,true,true,false);';
                    }
                }
            }
*/

    ?>
</div>
</div>
<?php if(is_array($qualityTotal) && count($qualityTotal) > 0 && array_sum($qualityTotal) != 0): ?>
<!-- Quality_Total -->
<div class="row p-2 bg-solapa " style="border-radius:25px;margin:3px;padding-bottom: 10%!important;">
    <div class="chart-container">
        <div class="pt-4" style="text-align:center;">
            <h3>Quality Total</h3>
        </div>
        <canvas class="pb-4  " id="Quality_Total"></canvas>
    </div>
</div>
<?php endif; ?>

<?php if(is_array($bilayer_thickness) && count($bilayer_thickness) > 0 && array_sum($bilayer_thickness) != 0): ?>
<!-- Bilayer thickness -->
<div class="row p-2 bg-solapa " style="border-radius:25px;margin:3px;padding-bottom: 10%!important;">
    <div class="chart-container">
        <div class="pt-4" style="text-align:center;">
            <h3>Bilayer thickness</h3>
        </div>
        <canvas class="pb-4  " id="Bilayer_thickness"></canvas>
    </div>
</div>
<?php endif; ?>

<?php if(is_array($area_per_lipid) && count($area_per_lipid) > 0 && array_sum($area_per_lipid) != 0): ?>
<!-- Area per lipid -->
<div class="row p-2 bg-solapa " style="border-radius:25px;margin:3px;padding-bottom: 10%!important;">
    <div class="chart-container">
        <div class="pt-4" style="text-align:center;">
            <h3>Area per lipid</h3>

        </div>
        <canvas class="pb-4  " id="Area_per_lipid"></canvas>
    </div>
</div>
<?php endif; ?>

<!--  El pie tiene que estar aqui-->
<div style="padding-top: 50px;">
    <?php echo $__env->make('layouts.foot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
</div>
<?php
            //if (is_array($qualityTotal) && count($qualityTotal) > 0 && is_array($bilayer_thickness) && count($bilayer_thickness) > 0 && is_array($area_per_lipid) && count($area_per_lipid) > 0) {
?>
<script>
    <?php
            if (is_array($qualityTotal) && count($qualityTotal) > 0 && array_sum($qualityTotal) != 0) {
    ?>
        DrawChartHistogram("Quality_Total",
            <?php echo json_encode($qualityTotal_value_process[0]); ?>,
            <?php echo json_encode($qualityTotal_value_process[1]); ?>,
            <?php echo $qualityTotal_value_process[2]; ?>,
            'bar',
            'Quality factor',
            'Quality factor',
            '# trajectories',
            <?php echo $qualityTotal_value_process[3]; ?>,
            <?php echo $qualityTotal_value_process[4]; ?>,
            true);
    <?php
            }
    ?>

    //if (!$bilayer_thickness_value_process.length === 0) {
    DrawChartHistogram("Bilayer_thickness",
        <?php echo json_encode($bilayer_thickness_value_process[0]); ?>,
        <?php echo json_encode($bilayer_thickness_value_process[1]); ?>,
        <?php echo $bilayer_thickness_value_process[2]; ?>,
        'bar',
        'Bilayer thickness',
        'Bilayer thickness', '# trajectories',
        <?php echo $bilayer_thickness_value_process[3]; ?>,
        <?php echo $bilayer_thickness_value_process[4]; ?>,
        true);

    //}
    //if (!$area_per_lipid_value_process.length === 0) {
    DrawChartHistogram("Area_per_lipid",
        <?php echo json_encode($area_per_lipid_value_process[0]); ?>,
        <?php echo json_encode($area_per_lipid_value_process[1]); ?>,
        <?php echo $area_per_lipid_value_process[2]; ?>,
        'bar',
        'Area per lipid',
        'Area per lipid', '# trajectories',
        <?php echo $area_per_lipid_value_process[3]; ?>,
        <?php echo $area_per_lipid_value_process[4]; ?>,
        true);
    //}
</script>

<?php
            // } // if hay datos
        }

?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.compare', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/new_advanced_search/compare.blade.php ENDPATH**/ ?>