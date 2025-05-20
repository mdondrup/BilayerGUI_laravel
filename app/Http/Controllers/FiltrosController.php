<?php

namespace App\Http\Controllers;

use App\Filtros\Filtros;
use Illuminate\Http\Request;

class FiltrosController extends Controller
{
    public function html($codigo) {
        $filtro = Filtros::get($codigo);
        return $filtro->html();
    }

    public function htmlBusquedaAvanzada($codigo, $numero) {
        $filtro = Filtros::get($codigo);
        $numero++;
        return $filtro->html_busqueda_avanzada($numero);
    }

    // Relleno de selects ?¿¿?
    public function htmlBusquedaAvanzadaSelects($codigo, $numero) {

        $filtro = Filtros::get($codigo);
        $numero++;
        return $filtro->html_busqueda_avanzada_selects($numero);
    }
}
