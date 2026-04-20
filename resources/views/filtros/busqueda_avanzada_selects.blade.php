<div class="contenedor-filtro-busqueda-avanzada">

    <div class=" filtro-busqueda-avanzada " style="justify-content: space-between">

        <div class="row">
            <div class="col-5">
                <?php
                ?>
                <label class=" " for="{{ $filtro->codigo . $numero_id }}">{{ $filtro->label }} </label>
            </div>
            <div class="col-7">

               
                    <input list="{{ $filtro->codigo . '_list_' . $numero_id }}" 
                        name="{{ $filtro->codigo }}[{{ $numero_id }}]" 
                        class="form-control mb-2 mr-sm-2"
                        id="{{ $filtro->codigo . $numero_id }}"
                        placeholder="Type or select..."
                        autocomplete="off">
                    <datalist id="{{ $filtro->codigo . '_list_' . $numero_id }}">
                        @if ($filtro->codigo === 'iones')
                            <option value="is_missing" label="Missing value">
                        @endif
                        @foreach ($options as $opcion)
                            <option value="{{ $opcion }}">
                        @endforeach
                    </datalist>
               
            </div>
        </div>

        <div class="d-flex">
            <div class="form-group mb-3 opciones-busqueda-avanzada" style="padding-left: 10px;">

            @if (isset($filtro->logical) && $filtro->logical)
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
            @elseif (isset($filtro->string) && $filtro->string)
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_contains_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_CONTAINS }}"
                        class="custom-control-input" checked>
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_contains_' . $numero_id }}">Contains</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_starts_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_STARTS }}"
                        class="custom-control-input">
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_starts_' . $numero_id }}">Starts with</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_ends_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_ENDS }}"
                        class="custom-control-input">
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_ends_' . $numero_id }}">Ends with</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ $filtro->codigo . '_equals_' . $numero_id }}"
                        name="{{ $filtro->nameOperador() }}[{{ $numero_id }}]" value="{{ OPERADOR_EQUALS }}"
                        class="custom-control-input">
                    <label class="custom-control-label" for="{{ $filtro->codigo . '_equals_' . $numero_id }}">Equals</label>
                </div>
            @endif
                <div class="pl-3" style="display: flex;  ">
                    @if (isset($filtro->cardinality) && $filtro->cardinality > 1)
                    <div class="form-group mb-3 acciones-filtro" style="display: none;">
                        <i data-action="duplicate-filter" class="bi bi-plus-circle"
                            style="font-size: 1.8em; color: #3490dc; margin-right: 10px"></i>
                        <i data-action="delete-filter" class="bi bi-trash"
                            style="font-size: 1.8em; color: #e3342f;"></i>
                    </div>
                    @else
                    <div class="form-group mb-3 acciones-filtro" style="display: none;">
                        <i data-action="delete-filter" class="bi bi-trash"
                            style="font-size: 1.8em; color: #e3342f;"></i>    
                    </div>
                    @endif        
                </div>
            </div>
        </div>
    </div>
</div>
