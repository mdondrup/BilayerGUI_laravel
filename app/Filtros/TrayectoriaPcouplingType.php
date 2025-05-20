<?php

namespace App\Filtros;

use App\AppModel;
use App\Trayectoria;

class TrayectoriaPcouplingType extends Filtro
{
    public function __construct()
    {
        $this->codigo = 'pressure_coupling_type';
        $this->label = __('Press. coupling type');
        $this->tooltip = 'Pressure coupling type';
        $this->table = 'trajectories';
        $this->fields = 'pressure_coupling_type';
        $this->columna = 'pressure_coupling_type';
        $this->modelo = new Trayectoria();
        $this->visible = false;
        $this->join_count = " COUNT(CASE WHEN trajectories.pressure_coupling_type = '%s' THEN 1 ELSE NULL END) AS '%s' ";
        $this->where = " pressure_coupling_type.%s = 1 ";
        $this->join = "INNER JOIN
                      ( SELECT pressure_coupling_type.id
                        FROM (SELECT
                                trajectories.id AS id,
                                %s
                        FROM `trajectories`
                        WHERE 1
                        GROUP BY trajectories.id
                        ) pressure_coupling_type
                        WHERE %s
                        ) pressure_coupling_type_select ON trajectories.id = pressure_coupling_type_select.id";
    }
}
