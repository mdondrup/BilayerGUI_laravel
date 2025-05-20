<?php

namespace App\Filtros;

use App\AppModel;
use App\Trayectoria;

class TrayectoriaPcoupling extends Filtro
{
    public function __construct()
    {
        $this->codigo = 'pressure_coupling';
        $this->label = __('Press. coupling ');
        $this->tooltip = 'Pressure coupling';
        $this->table = 'trajectories';
        $this->fields = 'pressure_coupling';
        $this->columna = 'pressure_coupling';
        $this->modelo = new Trayectoria();
        $this->visible = false;
        $this->join_count = " COUNT(CASE WHEN trajectories.pressure_coupling = '%s' THEN 1 ELSE NULL END) AS '%s' ";
        $this->where = " pressure_coupling.%s = 1 ";
        $this->join = "INNER JOIN
                      ( SELECT pressure_coupling.id
                        FROM (SELECT
                                trajectories.id AS id,
                                %s
                        FROM `trajectories`
                        WHERE 1
                        GROUP BY trajectories.id
                        ) pressure_coupling
                        WHERE %s
                        ) pressure_coupling_select ON trajectories.id = pressure_coupling_select.id";
    }
}
