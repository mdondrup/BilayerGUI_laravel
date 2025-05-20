<?php

namespace App\Filtros;

use App\AppModel;
use App\Trayectoria;

class TrayectoriaFiltro extends Filtro
{
    public function __construct()
    {
        $this->codigo = 'trayectoria';
        $this->label = __('Trayectoria');
        $this->tooltip = 'PW';
        $this->table = 'trajectories';
        $this->fields = 'id';
        $this->columna = 'id';
        $this->modelo = new Trayectoria();
        $this->visible = true;
        $this->join_count = "";
        $this->where = "";
        $this->join = "";
    }
}
