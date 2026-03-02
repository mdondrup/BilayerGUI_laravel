<?php

namespace App\Filtros;

use App\Lipido;
use Illuminate\Database\Eloquent\Builder;

class Lipidos extends Filtro
{
    use FiltrosTrait;

    public function __construct()
    {
        $this->codigo = 'lipidos';
        $this->label = __('Lipidos');
        $this->tooltip = 'POPC, POPG ...';
        $this->valor = '';
        $this->visible = true;
        $this->table = 'lipids';
        $this->fields = 'molecule';
        $this->logical = true; // Permit logical operators (AND/OR/NOT)
        $this->cardinality = 2; // Allow multiple selections for AND logic
        
        // COUNT/CASE pattern for AND logic support
        // Creates a boolean column for each selected lipid
        // First %s: molecule name, Second %s: column alias (e.g., "POPC1")
        $this->join_count = "COUNT(CASE WHEN l.molecule = '%s' THEN 1 END) AS %s";
        
        // HAVING condition: checks if the count column is > 0
        // %s: column alias from join_count
        $this->where = "%s > 0";
        
        // Join with GROUP BY for proper AND logic
        // First %s: comma-separated COUNT expressions
        // Second %s: HAVING conditions (combined with AND/OR by controller)
        $this->join = "INNER JOIN (
                          SELECT tl.trajectory_id AS id, %s
                          FROM trajectories_lipids AS tl
                          INNER JOIN lipids AS l ON tl.lipid_id = l.id
                          GROUP BY tl.trajectory_id
                          HAVING %s
                      ) AS lipid_filter ON trajectories.id = lipid_filter.id";
        
        $this->modelo = new Lipido();
    }
}
