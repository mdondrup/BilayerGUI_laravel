<div class="form-group row">
    <label class="col-sm-2 col-lg-1 col-form-label-sm" for="">{{ $filtro->label }}:</label>
    <div class="col-sm-2">
        <input class="filtro form-control form-control-sm" name="{{ $filtro->codigo }}" type="text"
            value="{{ $filtro->valor }}">
    </div>
    <div class="col-sm-2">
        <a class="btn btn-danger btn-sm eliminar_filtro" style="color: #FFF"><i class="bi bi-trash"></i></a>
    </div>
</div>
