<?php

namespace App\Http\Controllers;

use App\Exports\BusquedaAvanzadaExport;
use App\Filtros\Filtro;
use App\Filtros\Filtros;
use App\Trayectoria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BusquedaAvanzadaController extends Controller
{

  function resultado(Request $request)
  {


      $trayectorias = $this->getTrayectoriasConFiltroAplicados($request);
      $trayectorias = Trayectoria::whereIn('id', $trayectorias->pluck('id')->toArray())->paginate(10);

      return view('busqueda_avanzada.resultado', [
          'trayectorias' => $trayectorias,
      ]);
  }

    public function formulario(Request $request)
    {
        $filtros = array_merge(Filtros::filtrosEntidades(), Filtros::filtrosTrayectoria());
        $filtrosPrincipales = Filtros::filtrosEntidades();
        $filtroTrayectoria = Filtros::get('trayectoria');
        $filtrosTrayectorias = Filtros::filtrosTrayectoria();

        return view('busqueda_avanzada.formulario', [
            'filtros_principales' => $filtrosPrincipales,
            'filtro_trayectoria' => $filtroTrayectoria,
            'filtros_trayectorias' => $filtrosTrayectorias,
            'filtros_posibles' => $filtros
        ]);
    }


    public function exportar(Request $request)
    {
        $trayectorias = $this->getTrayectoriasConFiltroAplicados($request);

        foreach ($trayectorias as $k => $trayectoria)
        {
            $trayectorias[$k]['max_elementos'] = max(
                //count($trayectoria['peptidos']),
                count($trayectoria['lipidos']),
                count($trayectoria['iones']),
                count($trayectoria['moleculas']),
                count($trayectoria['modelos_acuaticos']),
                count($trayectoria['membranas']),
            );
        }

        $trayectoriasTratadas = [];
        foreach ($trayectorias as $trayectoria)
        {
            for($i = 0; $i < $trayectoria['max_elementos']; $i++)
            {
                $trayectoriaTratada = [
                    'trajectories.id' => $trayectoria['id'],
                    'trajectories.force_field' => $trayectoria['force_field'],
                    'trajectories.resolution' => $trayectoria['resolution'],
                    'trajectories.membrane_model' => $trayectoria['membrane_model'],
                    'trajectories.length' => $trayectoria['length'],
                    'trajectories.electric_field' => $trayectoria['electric_field'],
                    'trajectories.temperature' => $trayectoria['temperature'],
                    'trajectories.pressure' => $trayectoria['pressure'],
                    'trajectories.number_of_particles' => $trayectoria['number_of_particles'],
                    'trajectories.software_name' => $trayectoria['software_name'],
                    'trajectories.supercomputer' => $trayectoria['supercomputer'],
                    'trajectories.performance' => $trayectoria['performance'],
                    'lipids.short_name' => null,
                    'lipids.leaflet_1' => null,
                    'lipids.leaflet_2' => null,
                    //'peptides.name' => null,
                    //'peptides.sequence' => null,
                    //'peptides.activity' => null,
                    //'peptides.membrane' => null,
                    //'peptides.bulk' => null,
                    'ions.short_name' => null,
                  //  'ions.bulk' => null,
                    'heteromolecules.short_name' => null,
                    'heteromolecules.leaflet_1' => null,
                    'heteromolecules.leaflet_2' => null,
                    //'heteromolecules.bulk' => null,
                    'water_models.short_name' => null,
                    'membranes.name' => null,
                ];

                /*if(!empty($trayectoria['peptidos'][$i]))
                {
                    $trayectoriaTratada['peptides.name'] = $trayectoria['peptidos'][$i]['name'];
                    $trayectoriaTratada['peptides.sequence'] = $trayectoria['peptidos'][$i]['sequence'];
                    $trayectoriaTratada['peptides.activity'] = $trayectoria['peptidos'][$i]['activity'];
                    $trayectoriaTratada['peptides.membrane'] = $trayectoria['peptidos'][$i]['membrane'];
                    $trayectoriaTratada['peptides.bulk'] = $trayectoria['peptidos'][$i]['bulk'];
                }*/
                if(!empty($trayectoria['lipidos'][$i]))
                {
                    $trayectoriaTratada['lipids.short_name'] = $trayectoria['lipidos'][$i]['short_name'];
                    $trayectoriaTratada['lipids.leaflet_1'] = $trayectoria['lipidos'][$i]['leaflet_1'];
                    $trayectoriaTratada['lipids.leaflet_2'] = $trayectoria['lipidos'][$i]['leaflet_2'];
                }
                if(!empty($trayectoria['iones'][$i]))
                {
                    $trayectoriaTratada['ions.short_name'] = $trayectoria['iones'][$i]['short_name'];
                    //$trayectoriaTratada['ions.bulk'] = $trayectoria['iones'][$i]['bulk'];
                }
                if(!empty($trayectoria['moleculas'][$i]))
                {
                    $trayectoriaTratada['heteromolecules.short_name'] = $trayectoria['moleculas'][$i]['short_name'];
                    $trayectoriaTratada['heteromolecules.leaflet_1'] = $trayectoria['moleculas'][$i]['leaflet_1'];
                    $trayectoriaTratada['heteromolecules.leaflet_2'] = $trayectoria['moleculas'][$i]['leaflet_2'];
                    $trayectoriaTratada['heteromolecules.bulk'] = $trayectoria['moleculas'][$i]['bulk'];
                }

                if(!empty($trayectoria['modelos_acuaticos'][$i])) {
                    $trayectoriaTratada['water_models.short_name'] = $trayectoria['modelos_acuaticos'][$i]['short_name'];
                }

                $trayectoriasTratadas[] = $trayectoriaTratada;
            }
        }

        return Excel::download(new BusquedaAvanzadaExport($trayectoriasTratadas), 'resultado.csv');
    }

    private function aplicarFiltros(Request $request, Builder &$builder)
    {

        $filtros = Filtros::all();
        $datosFomulario = $request->all();

        $filtrosAplicados = [];
        foreach ($datosFomulario as $codigoFiltro => $valor) {
          if (strpos($valor, 'and') !== false) {
            // Do nothing
          } else {
            if(!empty($valor) && array_key_exists($codigoFiltro, $filtros)) {
                $operador = !empty($datosFomulario[$codigoFiltro.'_operador']) ? $datosFomulario[$codigoFiltro.'_operador'] : null;
                $filtros[$codigoFiltro]->aplicarFiltro($builder, $valor, $operador);
                $filtrosAplicados[$codigoFiltro] = $filtros[$codigoFiltro];
                $filtrosAplicados[$codigoFiltro]->valor = $valor;
            }
          }
        }

        // var_dump($filtrosAplicados);
        return $filtrosAplicados;
    }

    /**
     * @param Filtro[]|Collection $filtrosAplicables
     * @param Builder $builder
     */
    private function aplicarFiltrosBuilder($filtrosAplicables, Builder &$builder)
    {
        foreach ($filtrosAplicables as $filtro) {
            $filtro->aplicarFiltroJoin($builder);
        }
    }

    private function filtrosAplicables(Request $request)
    {
        $filtros = Filtros::all();
        $datosFomulario = $request->all();
        $filtrosAplicables = collect();

        //var_dump($datosFomulario);
        //die();

        foreach ($datosFomulario as $codigoFiltro => $valor) {

            if(is_array($valor)) {
                foreach ($valor as $k => $v) {
                      if(!empty($v) && array_key_exists($codigoFiltro, $filtros)) {
                          $operador = !empty($datosFomulario[$codigoFiltro.'_operador'][$k]) ? $datosFomulario[$codigoFiltro.'_operador'][$k] : null;
                          $filtro = $filtros[$codigoFiltro]; /** @var Filtro $filtro */
                          $filtro->valor = $v;
                          $filtro->operador = $operador;
                          $filtrosAplicables->push($filtro);
                      }
                }
            }
        }
 /*var_dump($filtrosAplicables);
die();*/
        return $filtrosAplicables;
    }

    /**
     * @param Request $request
     * @param Builder $builder
     * @param Filtro[] $filtrosAndOr
     * @return array
     */
    private function aplicarFiltrosOld(Request $request, Builder &$builder, $filtrosAndOr)
    {
        $filtros = Filtros::all('adv');
        $datosFomulario = $request->all('adv');

        foreach ($filtrosAndOr as $filtro) {
            $filtro->aplicarFiltroJoin($builder);
        }

    }

    /**
     * @return Builder
     */
    private function consultaBase()
    {
        $trayectorias = Trayectoria::select(
            // Trayectoria
            'trajectories.id', 'trajectories.force_field', 'trajectories.resolution', 'trajectories.membrane_model', 'trajectories.length', 'trajectories.electric_field', 'trajectories.temperature', 'trajectories.pressure', 'trajectories.number_of_particles', 'trajectories.software_name', 'trajectories.supercomputer', 'trajectories.performance',
            // Lipidos
            'lipids.id as lipids.id', 'lipids.name as lipids.name', 'trajectories_lipids.leaflet_1 as lipids.leaflet_1',
            'trajectories_lipids.leaflet_2 as lipids.leaflet_2',
            // Peptidos
            //'peptides.id as peptides.id', 'peptides.name as peptides.name', 'peptides.sequence as peptides.sequence', 'peptides.activity as peptides.activity',
            //'trajectories_peptides.membrane as peptides.membrane', 'trajectories_peptides.bulk as peptides.bulk',
            // Moleculas
            'heteromolecules.id as heteromolecules.id', 'heteromolecules.short_name as heteromolecules.short_name', 'trajectories_heteromolecules.leaflet_1 as heteromolecules.leaflet_1',
            'trajectories_heteromolecules.leaflet_2 as heteromolecules.leaflet_2',
            //'trajectories_heteromolecules.bulk as heteromolecules.bulk',
            // Iones
            'ions.id as ions.id', 'ions.short_name as ions.short_name',
            // 'trajectories_ions.bulk as ions.bulk',
            //Aguas
            'water_models.id as water_models.id', 'water_models.short_name as water_models.short_name',

            'membranes.id as membranes.id', 'membranes.name as membranes.name'
        )
            //->leftJoin('trajectories_peptides', 'trajectories.id', '=', 'trajectories_peptides.trajectory_id')
            //->leftJoin('peptides', 'peptides.id', '=', 'trajectories_peptides.peptide_id')

            ->leftJoin('trajectories_lipids', 'trajectories.id', '=', 'trajectories_lipids.trajectory_id')
            ->leftJoin('lipids', 'lipids.id', '=', 'trajectories_lipids.lipid_id')

            ->leftJoin('trajectories_water', 'trajectories.id', '=', 'trajectories_water.trajectory_id')
            ->leftJoin('water_models', 'water_models.id', '=', 'trajectories_water.water_id')

            ->leftJoin('trajectories_ions', 'trajectories.id', '=', 'trajectories_ions.trajectory_id')
            ->leftJoin('ions', 'ions.id', '=', 'trajectories_ions.ion_id')

            ->leftJoin('trajectories_heteromolecules', 'trajectories.id', '=', 'trajectories_heteromolecules.trajectory_id')
            ->leftJoin('heteromolecules', 'heteromolecules.id', '=', 'trajectories_heteromolecules.molecule_id')

            ->leftJoin('trajectories_membranes', 'trajectories.id', '=', 'trajectories_membranes.trajectory_id')
            ->leftJoin('membranes', 'membranes.id', '=', 'trajectories_membranes.membranes_id')


            ->orderBy('trajectories.id')
        ;

        return $trayectorias;
    }

    private function getTrayectoriasConFiltroAplicados($request)
    {

        //var_dump($request);

        DB::enableQueryLog();
        $filtrosAplicables = $this->filtrosAplicables($request);

        $filtrosNot = $filtrosAplicables->where('operador', OPERADOR_NOT); /** @var Filtro[] $filtrosNot */

        $trayectoriasDescartadasPorFiltroNot = [];
        foreach ($filtrosNot as $filtro)
        {

            $result = DB::table($filtro->getTablePivot())->select($filtro->getTablePivot().'.trajectory_id')
                ->join($filtro->modelo->getTable(), $filtro->modelo->getTable().'.id', $filtro->getTablePivot().'.'.$filtro->modelo->getForeignKey())
                ->where($filtro->modelo->getTable().'.'.$filtro->columna, 'LIKE', '%'.$filtro->valor.'%')
                ->get();

             $trayectoriasDescartadasPorFiltroNot = array_merge($trayectoriasDescartadasPorFiltroNot, $result->pluck('trajectory_id')->toArray());
        }


         $trayectorias = Trayectoria::select('trajectories.*')->orderBy('trajectories.id')
                ->with('lipidos', 'iones', 'modelos_acuaticos', 'moleculas' ,'membranas'  ) //,'membranas'  ->with('lipidos', 'peptidos', 'iones', 'modelos_acuaticos', 'moleculas' ,'membranas'  ) //,'membranas'
                ->whereNotIn('trajectories.id', $trayectoriasDescartadasPorFiltroNot)->get();
//var_dump($trayectoriasDescartadasPorFiltroNot);
//die();
//dd(DB::getQueryLog());

        $filtrosAnd = $filtrosAplicables->where('operador', OPERADOR_AND);
        $filtrosOr = $filtrosAplicables->where('operador', OPERADOR_OR);
//var_dump($filtrosOr);

        if($filtrosAnd->isEmpty() && $filtrosOr->isEmpty()) {
            $trayectoriasFiltradas = $trayectorias;
        } else {
            if(!$filtrosOr->isEmpty()) {
                $trayectoriasFiltradas = collect();

                foreach ($trayectorias as $k => $trayectoria)
                {
                    foreach ($filtrosOr as $filtro) {
                        $columna = $filtro->columna;

                        if($filtro->tipo == Filtro::TIPO_ENTIDAD) {
                            $propiedad = $filtro->codigo;
                            $entidades = $trayectoria->$propiedad;
                            if ($propiedad =="membranas"){
                              if (is_numeric($filtro->valor)){
                                $filtro->columna = "id";
                                 $columan = "id";
                              }else{
                                $filtro->columna = "name";
                                 $columan = "name";
                              }

                            }
//var_dump($trayectoria);
//var_dump($propiedad);
//var_dump($entidades);
//die();
                              foreach ($entidades as $entidad) {
                                  // OJO :: entidad->columan no es el campo para la sql
                                  if(preg_match("%$filtro->valor%i", $entidad->$columna)) {
                                      $trayectoriasFiltradas->push($trayectoria);
                                  }
                            }
                        }
                        if($filtro->tipo == Filtro::TIPO_PROPIEDAD) {
                            if(preg_match("%$filtro->valor%i", $trayectoria->$columna)) {
                                $trayectoriasFiltradas->push($trayectoria);
                            }
                        }
                    }
                }
            } else {
                $trayectoriasFiltradas = $trayectorias;
            }


            foreach ($trayectoriasFiltradas as $k => $trayectoria)
            {
                foreach ($filtrosAnd as $filtro) {
                    $columna = $filtro->columna;
                    if($filtro->tipo == Filtro::TIPO_ENTIDAD) {
                        $propiedad = $filtro->codigo;
                        $entidades = $trayectoria->$propiedad;
                        if ($propiedad =="membranas"){
                          if (is_numeric($filtro->valor)){
                            $filtro->columna = "id";
                             $columan = "id";
                          }else{
                            $filtro->columna = "name";
                             $columan = "name";
                          }
                        }

                        $esta = false;
                        foreach ($entidades as $entidad) {
                            if(preg_match("%$filtro->valor%i", $entidad->$columna)) {
                                $esta = true;
                            }
                        }
                        if(!$esta) {
                            unset($trayectoriasFiltradas[$k]);
                        }
                    }
                    if($filtro->tipo == Filtro::TIPO_PROPIEDAD) {
                        if(!preg_match("%$filtro->valor%i", $trayectoria->$columna)) {
                            unset($trayectoriasFiltradas[$k]);
                        }
                    }
                }
            }
        }



        return $trayectoriasFiltradas;
    }
}
