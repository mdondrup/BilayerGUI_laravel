<?php

use App\Trayectoria;
use Illuminate\Filesystem\Filesystem;

/**
 * @var Trayectoria $trayectoria
 */
/**@php
 *  var_dump($trayectoria);
 *  @endphp
 */

?>

<div class="row">
    <div class="col">
        <h5>Total trajectories</h5>
        <h4>{{ $totalTrayectorias }}</h4>
    </div>
    <div class="col">
        <h5>Total membranes</h5>
        <h4>{{ $totalMembranas }}</h4>
    </div>
</div>
