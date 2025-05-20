

<div class="contenedor-filtro-busqueda-avanzada" >

        <div class=" filtro-busqueda-avanzada " style="justify-content: space-between">

            <div class="row">
                <div class="col-5">
                    <label class=" " for="{{ $filtro->codigo.$numero_id }}">{{ $filtro->label }}</label>
                </div>
                <div class="col-7">

                    <input name="{{ $filtro->codigo }}[{{ $numero_id }}]" type="text" class="form-control mb-2 mr-sm-2" id="{{ $filtro->codigo.$numero_id }}">

                </div>
            </div>


        <div class="d-flex" >
                <div class="form-group mb-3 opciones-busqueda-avanzada" style="padding-left: 10px;">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{ $filtro->codigo.'_and_'.$numero_id }}" name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_AND }}" class="custom-control-input" >
                        <label class="custom-control-label" for="{{ $filtro->codigo.'_and_'.$numero_id }}">And</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{ $filtro->codigo.'_or_'.$numero_id }}" name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_OR }}" class="custom-control-input" checked>
                        <label class="custom-control-label" for="{{ $filtro->codigo.'_or_'.$numero_id }}">Or</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="{{ $filtro->codigo.'_not_'.$numero_id }}" name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_NOT }}" class="custom-control-input">
                        <label class="custom-control-label" for="{{ $filtro->codigo.'_not_'.$numero_id }}">Not</label>

                    </div>
                    @if (isset($filtro->tooltip))
                    <div class="tooltip-2 bi bi-info-circle">
                        <span class="tooltiptext">{{ $filtro->tooltip }}</span>
                    </div>
                    @endif
                    <div class ="pl-3" style="display: flex;  ">
                       <div class="form-group mb-3 acciones-filtro" style="display: none;">
                          <i data-action="duplicate-filter" class="fas fa-plus-circle" style="font-size: 1.8em; color: #3490dc; margin-right: 10px"></i>
                          <i data-action="delete-filter" class="fas fa-trash-alt" style="font-size: 1.8em; color: #e3342f;"></i>
                       </div>
                    </div>

                </div>

        </div>




        </div>



</div>
