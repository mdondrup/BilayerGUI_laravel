<div class="contenedor-filtro-busqueda-avanzada">

    <div class=" filtro-busqueda-avanzada " style="justify-content: space-between">

        <div class="row">
            <div class="col-5">
                <?php
                //var_dump($filtro);
                ?>
                <label class=" " for="<?php echo e($filtro->codigo . $numero_id); ?>"><?php echo e($filtro->label); ?> </label>
            </div>
            <div class="col-7">

                <?php if($filtro->codigo == 'aminoacids'): ?>
                    <input type="text" name="<?php echo e($filtro->codigo); ?>[<?php echo e($numero_id); ?>]"
                        class="form-control mb-2 mr-sm-2" id="<?php echo e($filtro->codigo . $numero_id); ?>">
                <?php else: ?>
                    <select name="<?php echo e($filtro->codigo); ?>[<?php echo e($numero_id); ?>]" class="form-control mb-2 mr-sm-2"
                        id="<?php echo e($filtro->codigo . $numero_id); ?>">
                        <option value=""></option>

                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($opcion); ?>"><?php echo e($opcion); ?>

                                <?php
                                //if (isset($filtro->unidades)) echo ($filtro->unidades)
                                ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                <?php endif; ?>
            </div>
        </div>

        <?php
        
        //var_dump($options);
        //<option value="{{$option['label']}}">{{$option['label']}}</option>
        ?>


        <div class="d-flex">
            <div class="form-group mb-3 opciones-busqueda-avanzada" style="padding-left: 10px;">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="<?php echo e($filtro->codigo . '_and_' . $numero_id); ?>"
                        name="<?php echo e($filtro->nameOperador()); ?>[<?php echo e($numero_id); ?>]" value="<?php echo e(OPERADOR_AND); ?>"
                        class="custom-control-input" checked>
                    <label class="custom-control-label" for="<?php echo e($filtro->codigo . '_and_' . $numero_id); ?>">And</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="<?php echo e($filtro->codigo . '_or_' . $numero_id); ?>"
                        name="<?php echo e($filtro->nameOperador()); ?>[<?php echo e($numero_id); ?>]" value="<?php echo e(OPERADOR_OR); ?>"
                        class="custom-control-input">
                    <label class="custom-control-label" for="<?php echo e($filtro->codigo . '_or_' . $numero_id); ?>">Or</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="<?php echo e($filtro->codigo . '_not_' . $numero_id); ?>"
                        name="<?php echo e($filtro->nameOperador()); ?>[<?php echo e($numero_id); ?>]" value="<?php echo e(OPERADOR_NOT); ?>"
                        class="custom-control-input">
                    <label class="custom-control-label" for="<?php echo e($filtro->codigo . '_not_' . $numero_id); ?>">Not</label>
                </div>
                <?php if(isset($filtro->tooltip)): ?>
                    <!--<div class="tooltip-2 bi bi-info-circle">
                        <span class="tooltiptext"><?php echo e($filtro->tooltip); ?></span>
                    </div>-->
                <?php endif; ?>
                <div class="pl-3" style="display: flex;  ">
                    <div class="form-group mb-3 acciones-filtro" style="display: none;">
                        <i data-action="duplicate-filter" class="bi bi-plus-circle"
                            style="font-size: 1.8em; color: #3490dc; margin-right: 10px"></i>
                        <i data-action="delete-filter" class="bi bi-trash"
                            style="font-size: 1.8em; color: #e3342f;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/filtros/busqueda_avanzada_selects.blade.php ENDPATH**/ ?>