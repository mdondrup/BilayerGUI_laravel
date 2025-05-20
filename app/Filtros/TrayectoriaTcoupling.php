<?php

namespace App\Filtros;

use App\AppModel;
use App\Trayectoria;

class TrayectoriaTcoupling extends Filtro
{
    public function __construct()
    {
        $this->codigo = 'trayectoria_coupling';
        $this->label = __('Temp. coupling ');
        $this->tooltip = 'Temperature Coupling';
        $this->table = 'trajectories';
        $this->fields = 'temperature_coupling';
        $this->columna = 'temperature_coupling';
        $this->modelo = new Trayectoria();
        $this->visible = false;
        $this->join_count = " COUNT(CASE WHEN trajectories.temperature_coupling = '%s' THEN 1 ELSE NULL END) AS '%s' ";
        $this->where = " temperature_coupling.%s = 1 ";
        $this->join = "INNER JOIN
                      ( SELECT temperature_coupling.id
                        FROM (SELECT
                                trajectories.id AS id,
                                %s
                        FROM `trajectories`
                        WHERE 1
                        GROUP BY trajectories.id
                        ) temperature_coupling
                        WHERE %s
                        ) temperature_coupling_select ON trajectories.id = temperature_coupling_select.id";
    }
}
