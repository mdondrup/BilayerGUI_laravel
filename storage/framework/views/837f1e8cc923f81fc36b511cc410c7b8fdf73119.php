<?php

use App\Trayectoria;

/**
 * @var Trayectoria[] $trayectorias
 */

?>


<?php $__env->startSection('content'); ?>
    <?php
    function filtraValor($val)
    {
        if ($val == 0 || $val == 4242) {
            return 'N/A';
        } else {
            return $val;
        }
    }
    //var_dump($_GET);
    // Al entrar en el formulario borramos la seleccion de la session para empezar una nueva busqueda
    /*
                $listaIdsSesson = session()->all();
                // Borrramos los IDs que estaban en session

                foreach ($listaIdsSesson as $key => $value) {
                    if (gettype($value) != 'array' && strpos($key, 'CompareID') !== false) {
                        session()->forget($key);
                    }
                }*/
    ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php
            if (!empty($trayectorias)) {
            ?>
                <div class="txt-white ">
                    <div class="card-header  " style="display: flex; justify-content: space-between">
                        <?php echo app('translator')->get('Búsqueda avanzada'); ?>
                        <?php echo e(session('lifetime')); ?>

                        <?php if($trayectorias->hasPages()): ?>
                            -
                            <?php echo e($trayectorias->count()); ?> / <?php echo e($trayectorias->total()); ?>

                            <?php echo app('translator')->get('Registros'); ?>
                        <?php else: ?>
                            <?php echo e($trayectorias->count()); ?> <?php echo app('translator')->get('Registros'); ?>
                        <?php endif; ?>


                        <?php
                        // Divido la URL para poder mandar los mismos parametros al exportador
                        $newlink = '';
                        $newlinkSel = '';

                        $actual_link = "$_SERVER[REQUEST_URI]";
                        $actlink = explode('?', $actual_link);
                        if (isset($actlink[1])) {
                            $newlink = 'export?' . $actlink[1];
                            $newlinkSel = 'export?' . $actlink[1] . '&selected=1';
                        }

                        $allSession = Session::all();
                        $numSelected = 0;
                        foreach ($allSession as $key => $value) {
                            if (str_contains($key, 'CompareID') && $value == 1) {
                                $numSelected = $numSelected + 1;
                            }
                        }
                        //var_dump($allSession);
                        // die();
                        ?>


                    </div>

                    <div class="d-flex p-2" style="background-color:rgb(255 255 255 / 18%)">
                        <div class="mr-auto ">
                            <a class="btn btn-primary btn-sm" href="#" onclick="SelectAll(this)">Select page</buttom>
                                <a class="ml-lg-2 btn btn-primary btn-sm" href="<?php echo e(route('new_advanced_search.compare')); ?>">
                                    Compare selected </a>
                        </div>


                        <div class="p2">
                            <a class="btn btn-primary btn-sm" href="<?php echo e($newlinkSel); ?>"> <?php echo app('translator')->get('Exportar seleccionado'); ?></a>
                            <a class="ml-lg-2 btn btn-primary btn-sm" href="<?php echo e($newlink); ?>"> <?php echo app('translator')->get('Exportar todo'); ?></a>
                        </div>
                    </div>

                </div>
                <?php } ?>

                <div class="table-responsive txt-white">
                    <?php
                if (empty($trayectorias)) {
                ?>
                    <div class="p-4">
                        <h3>Data not found.</h3>
                    </div>

                    <?php
                } else {
                ?>

                    <div id="accordion" class="  d-xl-none">
                        <?php
                        $tempData = array();

                        foreach ($trayectorias as $trayectoria) {

                            foreach ($trayectoria->groupBy('id') as $key) {

                                $tempData = array();

                                foreach ($key as $key2 => $value2) {
                                    foreach ($value2 as $key3 => $value3) {
                                        if (isset($tempData[$key3])) {
                                            if (!in_array($value3, $tempData[$key3])) {
                                                $tempData[$key3][] = $value3;
                                            }
                                        } else {
                                            $tempData[$key3][] = $value3;
                                        }
                                    }
                                }
                                //var_dump($tempData);die();
                                $id = implode(', ', $tempData['id']); // Acorto ID

                        ?>
                        <div class=" bg-mole my-2">
                            <div class="head-mole" id="heading<?php echo e($id); ?>">
                                <h5 class="mb-0">

                                    <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapse<?php echo e($id); ?>" aria-expanded="true"
                                        aria-controls="collapse<?php echo e($id); ?>">
                                        <?php echo app('translator')->get('ID'); ?> <?php echo e($id); ?>

                                    </button>
                                    <?php
                                    $isChecked = Session::get('CompareID' . $tempData['id'][0], '0');
                                    $Cheked = '';
                                    if ($isChecked == '1') {
                                        $Cheked = 'Checked';
                                    }
                                    ?>
                                    <input type="checkbox" class="selectCompare a<?php echo e($tempData['id'][0]); ?>"
                                        name="<?php echo e($tempData['id'][0]); ?>" value="<?php echo e($tempData['id'][0]); ?>"
                                        onclick="PressCheck(this)" <?php echo e($Cheked); ?>>
                                    <span class="txt_dato" style="color:gray; font-size:10pt;"> Select for compare</span>

                                    <span class="right"><a class="btn btn-primary"
                                            href="<?php echo e(route('trayectorias.show', $id)); ?>"><i
                                                class="bi bi-arrow-right-circle-fill"></i></a></span>
                                </h5>
                            </div>

                            <div id="collapse<?php echo e($id); ?>" class="collapse show"
                                aria-labelledby="heading<?php echo e($id); ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-sm-12 col-md-4">

                                            <p>
                                                <span class="title"><?php echo app('translator')->get('Lipidos'); ?></span><br>
                                                <?php
                                                foreach ($key as $keyr => $valuer) {
                                                    echo $valuer->lipid_name . ' (' . $valuer->leaflet_1 . ':' . $valuer->leaflet_2 . ')<br>';
                                                }
                                                ?>
                                                <br>
                                            </p>

                                        </div>



                                        <div class="col-sm-12 col-md-4">

                                            <p><span class="title"><?php echo app('translator')->get('Iones'); ?></span><br>
                                                <?php
                                                //if (strlen(implode(', ',$tempData['ion_short_name']))>0){

                                                echo implode(', ', $tempData['ion_short_name']);

                                                //}

                                                ?>
                                            </p>
                                            
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <p><span class="title"><?php echo app('translator')->get('Parametros de simulación'); ?></span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <?php echo e(c('longitud')); ?> : <?php echo e(implode(', ', $tempData['trj_length'])); ?><br>
                                            Force field : <?php echo e(implode(', ', $tempData['ff_name'])); ?><br>
                                            <?php echo e(c('temperatura')); ?> : <?php echo e(implode(', ', $tempData['temperature'])); ?> K<br>
                                        </div>

                                        <div class="col-sm-6 col-md-4">

                                            <?php echo e(c('particulas')); ?> : <?php echo e(implode(', ', $tempData['number_of_atoms'])); ?><br>
                                            <?php echo e(c('software')); ?> : <?php echo e(implode(', ', $tempData['software'])); ?><br>
                                        </div>

                                        <div class="col-sm-6 col-md-4">
                                            <?php
                                            $expCount = implode(', ', $tempData['experimentdatacountFF']) + implode(', ', $tempData['experimentdatacountOP']);
                                            if ($expCount > 0) {
                                              echo 'Simulation and<br>Experimental data';
                                            } else {
                                              echo 'Simulation data';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } // FOREACH
                        ?>

                        <?php echo e($trayectorias->withQueryString()->links()); ?>


                    </div>

                    <div class="card-body d-none   d-xl-block ">
                        <div class="table-responsive txt-white">
                            <table id="tabla-busqueda-avanzada" class="table table-striped">

                                <thead class="thead-light">
                                    <tr>
                                        <th><?php echo app('translator')->get('Compare'); ?></th>
                                        <th>Order parameters quality</th>
                                        <th><?php echo app('translator')->get('ID'); ?></th>
                                        <!--<th><?php echo app('translator')->get('FF'); ?> (<?php echo app('translator')->get('resolución'); ?>)</th>-->
                                        <th><?php echo app('translator')->get('Lipidos'); ?></th>

                                        <!--<th><?php echo app('translator')->get('Heteromoléculas'); ?></th>-->
                                        <th><?php echo app('translator')->get('Iones'); ?></th>
                                        
                                        <th><?php echo app('translator')->get('Parametros de simulación'); ?></th>
                                        <th>Simulation/Experimental</th>
                                        <th><?php echo app('translator')->get('Analisis'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $trayectorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trayectoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php

                                        foreach ($trayectoria->groupBy('id') as $key) {

                                            $tempData = array();

                                            foreach ($key as $key2 => $value2) {
                                                foreach ($value2 as $key3 => $value3) {
                                                    if (isset($tempData[$key3])) {
                                                        if (!in_array($value3, $tempData[$key3])) {
                                                            $tempData[$key3][] = $value3;
                                                        }
                                                    } else {
                                                        $tempData[$key3][] = $value3;
                                                    }
                                                }
                                            }

                                        ?>
                                            <td>
                                                <?php

                                                $isChecked = Session::get('CompareID' . $tempData['id'][0], '0');
                                                $Cheked = '';
                                                if ($isChecked == '1') {
                                                    $Cheked = 'Checked';
                                                }
                                                ?>
                                                <input type="checkbox" class="selectCompare b<?php echo e($tempData['id'][0]); ?>"
                                                    name="<?php echo e($tempData['id'][0]); ?>" value="<?php echo e($tempData['id'][0]); ?>"
                                                    <?php echo e($Cheked); ?> onclick="PressCheck(this)">
                                            </td>

                                            <td>
                                                <?php
                                                if (implode(', ', $tempData['quality_total']) == 0 || implode(', ', $tempData['quality_total']) == '4242') {
                                                    echo 'N/A';
                                                } else {
                                                    echo round(implode(', ', $tempData['quality_total']), 2);
                                                }

                                                ?>

                                            </td>
                                            <td><?php echo e(implode(', ', $tempData['id'])); ?></td>

                                            <td>
                                                <?php
                                                $listCampos = [];
                                                foreach ($key as $keyr => $valuer) {
                                                    $listCampos[] = $valuer->lipid_name . ' (' . $valuer->leaflet_1 . ':' . $valuer->leaflet_2 . ')';
                                                    //echo $valuer->lipid_name." (".$valuer->leaflet_1.":".$valuer->leaflet_2.")<br>";
                                                }
                                                $listUnique = array_unique($listCampos);

                                                echo implode('<br>', $listUnique);
                                                echo '<br>';
                                                if (strlen(implode(', ', $tempData['hm_short_name'])) > 0) {
                                                    echo implode(', ', $tempData['hm_short_name']);
                                                    echo '(';
                                                    echo implode(', ', $tempData['hm_leaflet1']);
                                                    echo ':';
                                                    echo implode(', ', $tempData['hm_leaflet2']);
                                                    echo ')';
                                                }
                                                ?>
                                            </td>



                                            <td>
                                                <?php
                                                if (strlen(implode(', ', $tempData['ion_short_name'])) > 0) {
                                                    echo implode(', ', $tempData['ion_short_name']);
                                                    echo '(' . implode(', ', $tempData['number_ions']) . ')';
                                                }

                                                ?>
                                            </td>

                                            
                                            <td>
                                                <?php echo e(c('longitud')); ?> : <?php echo e(implode(', ', $tempData['trj_length'])); ?><br>
                                                Force field : <?php echo e(implode(', ', $tempData['ff_name'])); ?><br>
                                                <?php echo e(c('temperatura')); ?> : <?php echo e(implode(', ', $tempData['temperature'])); ?><br>

                                                <?php echo e(c('particulas')); ?> :
                                                <?php echo e(implode(', ', $tempData['number_of_atoms'])); ?><br>

                                                <?php echo e(c('software')); ?> : <?php echo e(implode(', ', $tempData['software'])); ?><br>


                                            </td>
                                            <td style="text-align: center">
                                                <p>
                                                    <?php
                                                    $expCount = implode(', ', $tempData['experimentdatacountFF']) + implode(', ', $tempData['experimentdatacountOP']);
                                                    if ($expCount > 0) {
                                                        echo 'Simulation and <br>Experimental data';
                                                    } else {
                                                        echo 'Simulation data';
                                                    }
                                                    ?>
                                                </p>
                                            </td>

                                            <td style="text-align: center">

                                              <?php
                                              if (implode(', ', $tempData['git_path'])!=""){
                                                ?>

                                                <a
                                                <?php

                                                $expCount = implode(', ', $tempData['experimentdatacountFF']) + implode(', ', $tempData['experimentdatacountOP']);
                                                if ($expCount > 0) {
                                                    echo 'class="btn btn-success"';
                                                } else {
                                                    echo 'class="btn btn-primary"';
                                                }
                                                ?>
                                                    href="<?php echo e(route('trayectorias.show', implode(', ', $tempData['id']))); ?>">
                                                    <i class="bi bi-arrow-right-circle"></i>
                                                </a>
                                                <?php
                                                }
                                                ?>
                                            </td>


                                            <?php
                                            /*
                                                // intento de monstar si tiene experimentos... peor esn
                                                if (implode(', ', $tempData['form_factor_experiment']) != '') {
                                                    echo 'class="btn btn-primary"';
                                                } else {
                                                    echo 'class="btn btn-success"';
                                                }
                                                */

                                        } // END IF
                                        ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            <?php echo e($trayectorias->withQueryString()->links()); ?>

                        </div>
                    </div>
                    <div class="d-flex p-2">
                        <div class="p2 ">
                            <a class="m-2 btn btn-primary btn-sm" onclick="SelectAll(this)">Unselect page</buttom>
                                <a class="m-2 btn btn-primary btn-sm" href="<?php echo e(route('new_advanced_search.compare')); ?>">
                                    Compare selected </a>
                        </div>
                    </div>

                    <form id="formulario-compare-submit" action="<?php echo e(route('new_advanced_search.updatecompare')); ?>"
                        method="post">

                        
                        <?php echo csrf_field(); ?>
                        <?php
                        foreach ($trayectorias as $trayectoria) {
                            foreach ($trayectoria->groupBy('id') as $key) {
                                $tempData = [];

                                foreach ($key as $key2 => $value2) {
                                    foreach ($value2 as $key3 => $value3) {
                                        if (isset($tempData[$key3])) {
                                            if (!in_array($value3, $tempData[$key3])) {
                                                $tempData[$key3][] = $value3;
                                            }
                                        } else {
                                            $tempData[$key3][] = $value3;
                                        }
                                    }
                                }

                                $id = $tempData['id'][0];
                                $valueSession = Session::get('CompareID' . $tempData['id'][0], '0');
                                echo '<input type="hidden" id="Check' . $id . '" name="CompareID' . $id . '" value="' . $valueSession . '" />';
                            }
                        }
                        ?>

                    </form>

                    <?php
                } // END IF
                ?>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
    <script>
        var url_filtros_html = "<?php echo e(route('filtros.html', ':filtro')); ?>";
        $('.mostrar_ocultar_filtros').click(function() {
            $('.contenedor-filtros').toggle();
            if ($('.fa-chevron-left').length) {
                $('.fa-chevron-left').removeClass('fa-chevron-left').addClass('fa-chevron-down');
            } else {
                $('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-left');
            }
        })
        $('#selector-filtros').change(function() {
            $('.contenedor-filtros').show();
            let codigo = $(this).find('option:selected').val();
            if (codigo !== 'trayectoria') {
                $(this).find('option[value=' + codigo + ']').hide();
            }
            if (codigo) {
                $.ajax({
                    'url': url_filtros_html.replace(':filtro', codigo),
                    'success': function(response) {
                        $('#filtros').prepend(response);
                        agregar_evento_eliminar_filtro();
                    }
                })

            }
            $('#selector-filtros').find('option[value=0]').prop('selected', true);
        })

        agregar_evento_eliminar_filtro();

        function agregar_evento_eliminar_filtro() {
            $('.eliminar_filtro').click(function() {
                let codigo = $(this).closest('.form-group').find('input').attr('name');
                $(this).closest('.form-group').remove();
                $('#selector-filtros').find('option[value=' + codigo + ']').show();
            })
        }

        function SelectAll(aa) {
            status = 0;
            // Se hace asi para que los selects gemelos tengan el mismo estado en las dos vistas
            if (aa.innerHTML == "Unselect page") {
                $('.selectCompare').prop('checked', false);
                aa.innerHTML = "Select page"
                status = 0;
            } else {
                $('.selectCompare').prop('checked', true);
                aa.innerHTML = "Unselect page"
                status = 1;
            }

            // Cambio es estado en los inputs ocultos para cambiar las variables de session.
            $("input[name*='CompareID']").val(status);
            // Mando el cambio de los inputs para actualizar las variables de session.
            $('#formulario-compare-submit').submit();
        }

        function InitializeInputs() {


        }

        // como son dos paginas en una con distintas formas de mostrarse hay inputs duplicados
        // pulsas uno y marca el estado del gemelo
        function PressCheck(aa) {

            //console.log(aa.value);
            valuecheck = aa.value;
            status = 0;
            // Esto es por algo visual, realmente cuando pulso tengo que pasarlo por una varible de sesion
            if (aa.checked) {
                $("input[value*=" + valuecheck + "]").prop('checked', true);
                status = 1;
            } else {
                $("input[value*=" + valuecheck + "]").prop('checked', false);
                status = 0;
            }
            if ($("#Check" + aa.name).length == 0) {
                $('#formulario-compare-submit').append('<input type="hidden" id="Check' + aa.name + '" name="CompareID' + aa
                    .name + '" value="' + status + '" />');
            } else {
                $("#Check" + aa.name).val(status);
            }
            // TESTEO
            $('#formulario-compare-submit').submit();

        }

        $('#formulario-compare-submit').submit(function() {

            //$('#formulario-compare-submit').html('');

            $.ajax({
                type: "POST",
                url: "<?php echo e(route('new_advanced_search.updatecompare')); ?>",
                data: $(this).serialize(),
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                complete: function(response) {
                    //console.log("complete"+ response);
                    // Do what you want to do when the session has been updated
                    console.log("complete> " + JSON.stringify(response) + " <");
                },
                success: function(response) {
                    console.log("success");
                    // Do what you want to do when the session has been updated
                    //console.log("success> "+ JSON.stringify(response)+" <");
                }
            });

            return false;

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/new_advanced_search/results.blade.php ENDPATH**/ ?>