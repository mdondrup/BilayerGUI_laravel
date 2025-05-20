<?php

use App\Peptido;
use App\Lipido;

/**
 * @var Peptido[] $peptidos
 * @var Lipido[] $lipidos
 */

// Al entrar en el formulario borramos la seleccion de la session para empezar una nueva busqueda
$listaIdsSesson = session()->all();
// Borrramos los IDs que estaban en session

foreach ($listaIdsSesson as $key => $value) {
    if (gettype($value) != 'array' && strpos($key, 'CompareID') !== false) {
        session()->forget($key);
    }
}
?>



<?php $__env->startSection('content'); ?>

    <div class="container" style="min-height: 100vh;">
        <div class="row justify-content-center" style="padding-top: 40px;">
            <div class="col-md-12">

                <form action="<?php echo e(route('search.results')); ?>" method="get">
                    <div class="input-group mb-3">
                        <input type="text" name="text" class="form-control" placeholder="Search..."
                            aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo e($texto); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </div>
                </form>

                <div class=" ">

                    <?php
                    //var_dump ($claves);
                    //var_dump ($cadregexp);
                    ?>

                    <div class="search_result" style="padding: 1rem">
                        <?php if(count($lipidos) == 0 and
                                count($iones) == 0 and
                                //count($moleculas) == 0 and
                                count($aguas) == 0 and
                                count($temperatures) == 0 and
                                count($membranas) == 0): ?>
                            Your query has returned no data. Simple search only works for lipids and/or ions. See <a target="_blank" href="https://nmrlipids.github.io/moleculesAndMapping.html">Molecules and Mapping</a> for a list of allowed molecules. For other parameters, try the Advanced Search.<br>
                        <?php endif; ?>


                        <?php if(count($lipidos) > 0): ?>
                            <h1 class="txt-white  mt-4"><?php echo app('translator')->get('Lípido'); ?></h1>
                            <div class="row m-1">
                                <?php $__currentLoopData = $lipidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lipido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-12 col-lg-2 p-1">
                                        <span class="badge badge-secondary"><?php echo app('translator')->get('Lípido'); ?> </span>
                                        <span>
                                            <a href="<?php echo e(route('new_advanced_search.results') . '?lipidos_operador[1]=or&lipidos[1]=' . $lipido->molecule); ?>"
                                                class=""><?php echo resaltar_texto($lipido->molecule, $texto); ?></a>
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($moleculas) > 0): ?>
                                    <?php $__currentLoopData = $moleculas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $molecula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-2 p-1">
                                            <span class="badge badge-secondary"><?php echo app('translator')->get('Lípido'); ?> </span>
                                            <span>
                                                <a href="<?php echo e(route('new_advanced_search.results') . '?moleculas_operador[1]=or&moleculas[1]=' . $molecula->molecule); ?>"
                                                    class="">
                                                    <?php echo resaltar_texto($molecula->molecule, $texto); ?></a>
                                            </span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>


                            </div>
                        <?php endif; ?>


                        <!-- ION -->
                        <?php if(count($iones) > 0): ?>
                            <h1 class="txt-white  mt-4"><?php echo app('translator')->get('Ion'); ?></h1>
                            <div class="row m-1">
                                <?php $__currentLoopData = $iones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-12 col-lg-2 p-1">
                                        <span class="badge badge-secondary"><?php echo app('translator')->get('Ion'); ?> </span>
                                        <span>
                                            <a href="<?php echo e(route('new_advanced_search.results') . '?iones_operador[1]=or&iones[1]=' . $ion->molecule); ?>"
                                                class=""><?php echo resaltar_texto($ion->molecule, $texto); ?></a>
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Modelo de Membrana -->
                        <?php if(count($membranas) > 0): ?>
                            <!-- Contador -->
                            <?php
                            $maxLipids = 0;
                            ?>
                            <?php $__currentLoopData = $membranas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membrana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(strlen($membrana->lipid_names_l1) > 0 && strlen($membrana->lipid_names_l2) > 0): ?>
                                    <?php
                                    $lipidsInMembrane = explode(':', $membrana->lipid_number_l1);
                                    $numLipids = count($lipidsInMembrane);
                                    $maxLipids = max($maxLipids, $numLipids);
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <h1 class="txt-white mt-4">Membranes</h1>
                            <div class="row m-1">
                                <div class="col">
                                    <p>Hide by number of lipids: </p>
                                    <?php
                                    for ($i = 1; $i <= $maxLipids; $i++) {
                                        echo '<label><input type="checkbox" class="b' . $i . '" name="' . $i . '" value="' . $i . '" onclick="PressCheck(this)">&nbsp;' . $i . ' lipid &nbsp;&nbsp;</label>';
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="row m-1">
                                <?php $__currentLoopData = $membranas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membrana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(strlen($membrana->lipid_names_l1) > 0 && strlen($membrana->lipid_names_l2) > 0): ?>
                                        <?php
                                        $lipidsInMembrane = explode(':', $membrana->lipid_number_l1);
                                        $numLipids = count($lipidsInMembrane);
                                        ?>

                                        <!--  <p class="d-flex justify-content-between"> -->
                                        <div class="col-12 p-1 num<?php echo e($numLipids); ?>">

                                            <span class="badge badge-secondary">Membrane </span>
                                            <span>
                                                <a href="<?php echo e(route('new_advanced_search.results') . '?membranas_operador[1]=or&membranas[1]=' . $membrana->id); ?>"
                                                    class=""> <?php echo resaltar_texto($membrana->lipid_names_l1, $texto); ?> <=> <?php echo resaltar_texto($membrana->lipid_names_l2, $texto); ?> =>
                                                        <?php echo resaltar_texto($membrana->lipid_number_l1, $texto); ?> <=> <?php echo resaltar_texto($membrana->lipid_number_l2, $texto); ?>

                                                </a>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>


                        <!-- Temperaturas -->
                        <?php if(count($temperatures) > 0): ?>
                            <h1 class="txt-white mt-4">Temperatures</h1>
                            <div class="row m-1">
                                <?php $__currentLoopData = $temperatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temperature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p class="d-flex justify-content-between">
                                    <div class="col-12 p-1">
                                        <span class="badge badge-secondary">Temperature </span>
                                        <span>
                                            <a href="<?php echo e(route('new_advanced_search.results') . '?trayectoria_temperature_operador[1]=and&trayectoria_temperature[1]=' . $temperature->temperature); ?>"
                                                class="">
                                                <?php echo resaltar_texto($temperature->temperature, $texto); ?>

                                            </a>
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // pulsas uno y marca el estado del gemelo
        function PressCheck(aa) {

            //console.log(aa.value);
            valuecheck = aa.value;
            status = 0;
            // Esto es por algo visual, realmente cuando pulso tengo que pasarlo por una varible de sesion
            if (aa.checked) {
                $("input[value*=" + valuecheck + "]").prop('checked', true);
                $(".num" + aa.name).attr("hidden", "true");
            } else {
                $("input[value*=" + valuecheck + "]").prop('checked', false);
                $(".num" + aa.name).removeAttr("hidden");

            }

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/search/results.blade.php ENDPATH**/ ?>