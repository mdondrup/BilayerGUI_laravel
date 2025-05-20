<?php
use App\Filtros\TrayectoriasFiltros
?>


<div class="form-group row">
    <label class="col-sm-2 col-lg-1 col-form-label-sm" for=""> {{ $filtro->label }} :</label>
    <div class="col-sm-2">
        <select class="form-control form-control-sm">
            @php $i = 0 @endphp
            @foreach(\App\Filtros\Filtros::filtrosTrayectoria() as $filtroTrayectoria)
                @if($i == 0)
                    @php
                        $primerFiltro = $filtroTrayectoria;
                        $i++;
                    @endphp
                @endif
                <option value="{{ $filtroTrayectoria->codigo }}">{{ $filtroTrayectoria->label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-2">
        <input id="filtro_trayectoria" class="filtro form-control form-control-sm" name="{{ $primerFiltro->codigo }}" type="text" value="{{  $filtro->valor }}">
    </div>
    <div class="col-sm-2">
        <a class="btn btn-danger btn-sm eliminar_filtro" style="color: #FFF"><i class="fas fa-trash-alt"></i></a>
    </div>
</div>

<script>
    $('select').change(function () {
        $('#filtro_trayectoria').attr('name', $(this).find('option:selected').val())
    })
</script>
