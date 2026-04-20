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
    <div class="col hero-stats">
        <p>Total&nbsp;trajectories:<br>
        {{ $totalTrayectorias }}</p>
    </div>
    <div class="col hero-stats">
        <p>Total&nbsp;experiments:<br>
        {{ $totalExperiments }}</p>
    </div>
    <div class="col hero-stats">
        <p>Total&nbsp;membranes:<br>
        {{ $totalMembranas }}</p>
    </div>
    <div class="row text-white-75 mb-0 mt-2 text-center">
        <p title="API version: {{ $lastUpdate?->fairmd_version ?? '-' }} - Data version: {{ $lastUpdate?->bilayerdata_version ?? '-'  }}">
            <small style="font-size: 0.9rem;">Last&nbsp; DB update:
        {{ $lastUpdate ? $lastUpdate->updated_at->format('Y-m-d H:i:s T') : 'Unknown' }}</small></p>
</div>
