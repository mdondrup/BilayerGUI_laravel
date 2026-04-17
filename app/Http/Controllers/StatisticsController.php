<?php

namespace App\Http\Controllers;

use App\Agua;
use App\Ion;
use App\Lipido;
use App\Molecula;
use App\Trayectoria;
use App\TrayectoriaAnalisis;
use App\Membrana;
use App\Experiments;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
      $totals = Cache::remember('statistics.totals', now()->addHours(6), function () {
          return [
              'totalTrayectorias' => Trayectoria::select('id')->count(),
              'totalMembranas' => Membrana::select('id')->count(),
              'totalExperiments' => Experiments::select('id')->count(),
              'lastUpdate' => DB::table('update_record')->latest('updated_at')->first()
          ];
      });

      $lastUpdate = $totals['lastUpdate'];
      if ($lastUpdate && $lastUpdate->updated_at) {
          $lastUpdate->updated_at = Carbon::parse($lastUpdate->updated_at, 'UTC')
              ->setTimezone(config('app.timezone'));
      }

      return view('statistics.totals', [
          'totalTrayectorias' => $totals['totalTrayectorias'],
          'totalMembranas' => $totals['totalMembranas'],
          'totalExperiments' => $totals['totalExperiments'],
          'lastUpdate' => $lastUpdate
        ]);
    }


}
