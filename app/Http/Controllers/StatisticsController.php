<?php

namespace App\Http\Controllers;

use App\Agua;
use App\Ion;
use App\Lipido;
use App\Molecula;
use App\Trayectoria;
use App\TrayectoriaAnalisis;
use App\Membrana;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function results(Request $request)
    {

        DB::enableQueryLog();

        $TotalTrayectorias = Trayectoria::select('id')->count();
        $TotalMembranas = Membrana::select('id')->count();
        $CountMembranas = Membrana::groupBy('id')->select('id', DB::raw('count(*) as total'))->get();
       
        $CountMembraneForcefield = Membrana::groupBy('forcefields.name')->join('forcefields','membranes.forcefield_id','=','forcefields.id')->select('forcefields.name', DB::raw('count(*) as total'))->get();

        
        return view('statistics.results', [
            'totalTrayectorias' => $TotalTrayectorias,
            'totalMembranas'=>$TotalMembranas,
            'membranas' => $CountMembranas,
            'Forcefields' => $CountMembraneForcefield
        ]);
    }

    static function totals()
    {
      $TotalTrayectorias = Trayectoria::select('id')->count();
      $TotalMembranas = Membrana::select('id')->count();

      return view('statistics.totals', [
          'totalTrayectorias' => $TotalTrayectorias,
          'totalMembranas'=>$TotalMembranas
        ]);
    }


}
