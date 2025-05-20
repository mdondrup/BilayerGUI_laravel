<?php

namespace App\Filtros;

use App\Molecula;
use Illuminate\Database\Eloquent\Builder;

class Moleculas extends Filtro
{
    use FiltrosTrait;

    public function __construct()
    {
        $this->codigo = 'moleculas';
        $this->label = __('Heteromoléculas');
        $this->tooltip = 'CHOL ...';
        $this->table = 'heteromolecules';
        $this->fields = 'molecule';
        //$this->fields = 'name';
        $this->modelo = new Molecula();
        $this->valor = '';
        $this->visible = true;
        $this->join_count = "COUNT( CASE WHEN trajectories_heteromolecules.molecule_name = '%s' THEN 1 ELSE NULL END) AS %s";
        $this->where = "  heteromolecule.%s = 1 ";
        $this->join = "INNER JOIN(
                       SELECT heteromolecule.id
                       FROM (
                           SELECT trajectories_heteromolecules.trajectory_id AS id, %s
                           FROM trajectories_heteromolecules
                           WHERE 1
                           GROUP BY trajectories_heteromolecules.trajectory_id
                   		 ) heteromolecule
                       WHERE %s
                       ) heteromolecule_select
                      ON trajectories.id = heteromolecule_select.id";
    }
}
