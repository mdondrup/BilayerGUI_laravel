<div class="contenedor-filtro-busqueda-avanzada">

    <div class=" filtro-busqueda-avanzada " style="justify-content: space-between">

        <div class="row">
            <div class="col-5">
                <?php
                //var_dump($filtro);
                ?>
                <label class=" " for="{{ $filtro->codigo . $numero_id }}">{{ $filtro->label }} </label>
            </div>
            <div class="col-7">

                @if ($filtro->codigo == 'aminoacids')
                    <input type="text" name="{{ $filtro->codigo }}[{{ $numero_id }}]"
                        class="form-control mb-2 mr-sm-2" id="{{ $filtro->codigo . $numero_id }}">
                @else
                    <select name="{{ $filtro->codigo }}[{{ $numero_id }}]" class="form-control mb-2 mr-sm-2"
                        id="{{ $filtro->codigo . $numero_id }}">
                        <option value=""></option>

                        @foreach ($options as $opcion)
                            <option value="{{ $opcion }}">{{ $opcion }}
                                <?php
                                //if (isset($filtro->unidades)) echo ($filtro->unidades)
                                ?>

                            </option>
                        @endforeach

                    </select>
                @endif
            </div>
        </div>

        <?php
        
        //var_dump($options);
        //<option value="{{$option['label']}}">{{$option['label']}}</option>
        ?>


        <div class="d-flex">
            <div class="form-group mb-3 opciones-busqueda-avanzada" style="padding-left: 10px;">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_and_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_AND }}"
                        class="custom-control-input" checked>
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_and_' . $numero_id }}">And</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_or_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_OR }}"
                        class="custom-control-input">
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_or_' . $numero_id }}">Or</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_not_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_NOT }}"
                        class="custom-control-input">
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_not_' . $numero_id }}">Not</label>
                </div>
                @if (isset($filtro->tooltip))
                    <!--<div class="tooltip-2 bi bi-info-circle">
                        <span class="tooltiptext">{{ $filtro->tooltip }}</span>
                    </div>-->
                @endif
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
