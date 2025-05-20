<?php
use App\Trayectoria;
/**
 * @var Trayectoria[] $trayectorias
 */
?>
@extends('layouts.app')

@section('content')



    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="txt-white ">
                    <div class="card-header  " style="display: flex; justify-content: space-between">
                        @lang('Búsqueda avanzada') - {{ $trayectorias->count() }} / {{ $trayectorias->total() }} @lang('Registros')
                        <?php
                          //var_dump($trayectorias);
                        ?>
                        <form action="{{ route('busqueda_avanzada.exportar') }}" method="post">
                            @csrf
                            @foreach(request()->all() as $codigo => $v)
                                @if(is_array($v))
                                    @foreach($v as $valor)
                                        <input type="hidden" name="{{ $codigo }}[]" value="{{ $valor }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $codigo }}" value="{{ $v }}">
                                @endif
                                @endforeach
                            <input type="submit" value="@lang('Exportar')" class="btn btn-primary btn-sm">
                        </form>

                    </div>


                    <div id="accordion" class ="  d-xl-none">
                      @foreach($trayectorias as $trayectoria)
                      <div class=" bg-mole my-2">
                        <div class="head-mole"   id="heading{{ $trayectoria->id }}">
                          <h5 class="mb-0">

                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $trayectoria->id }}" aria-expanded="true" aria-controls="collapse{{ $trayectoria->id }}">
                              @lang('ID') NL{{ $trayectoria->id }}
                            </button>
                            <span class="right"><a class="btn btn-primary" href="{{ route('trayectorias.show', $trayectoria->id) }}"><i class="fas fa-share"></i></a></span>
                          </h5>
                        </div>

                        <div id="collapse{{ $trayectoria->id }}" class="collapse show" aria-labelledby="heading{{ $trayectoria->id }}" data-parent="#accordion">
                          <div class="card-body">
                            <div class ="row">


                              <div class = "col-sm-12 col-md-4">

                                <!--  <p><span class="title">@lang('FF') (@lang('resolución'))</span><br>
                                   {{ none($trayectoria->campo_de_fuerza->name).' ('.none($trayectoria->campo_de_fuerza->resolution).')' }}
                                 </p>-->

                                  <p><span class="title">@lang('Lipidos')</span><br>
                                     @if(empty($trayectoria->lipidos)) None @endif
                                     @foreach($trayectoria->lipidos as $lipido)
                                         <span>
                                             {{ none($lipido->short_name) }} (<span title="leaflet_1">{{ none($lipido->pivot->leaflet_1) }}</span>:<span title="leaflet_2">{{ none($lipido->pivot->leaflet_2) }}</span>)
                                          <!--     <span title="membrane_model">{{ none($trayectoria->membrana->model) }}</span> -->
                                         </span>
                                         <br>
                                     @endforeach
                                   </p>


                            </div>


                            <div class="col-sm-12 col-md-4">

                               <p><span class="title">@lang('Heteromoléculas')</span><br>
                                 @if(empty($trayectoria->moleculas)) None @endif
                                 @foreach($trayectoria->moleculas as $molecula)
                                     <span style="white-space: nowrap">
                                         {{ none($molecula->short_name) }}
                                         (<span title="leaflet_1">{{ none($molecula->pivot->leaflet_1) }}</span>:<span title="leaflet_2">{{ none($molecula->pivot->leaflet_2) }}</span>|<span title="bulk">{{ none($molecula->pivot->bulk) }}</span>)
                                     </span>
                                     <br>
                                 @endforeach
                               </p>
                            </div>


                            <div class="col-sm-12 col-md-4">

                                <p><span class="title">@lang('Iones')</span><br>
                                  @if(empty($trayectoria->iones)) None @endif
                                  @foreach($trayectoria->iones as $ion)
                                      <span style="white-space: nowrap">
                                          {{ none($ion->short_name) }} (<span title="bulk">{{ none($ion->pivot->bulk) }}</span>)
                                      </span>
                                      <br>
                                  @endforeach
                                </p>
                                <p ><span class="title">@lang('Modelo de agua')</span><br>
                                  @if(empty($trayectoria->modelos_acuaticos)) None @endif
                                  @foreach($trayectoria->modelos_acuaticos as $agua)
                                      {{ none($agua->short_name) }}
                                  @endforeach
                                </p>
                          </div>

                        </div>

                          <div class="row">
                            <div class="col-12">
                            <p><span class="title">@lang('Parametros de simulación')</span><br>
                            </div>
                          </div>
                          <div class="row">
                                <div class="col-sm-6 col-md-4">
                              {{ c('longitud') }}: {{ none($trayectoria->length, 'ns') }}<br>
                              {{ c('campo_electrico') }}: {{ none($trayectoria->electric_field, 'V/nm') }}<br>
                              {{ c('temperatura') }}: {{ none($trayectoria->temperature, 'K') }}<br>

                            </div>

                            <div class="col-sm-6 col-md-4">
                                {{ c('presion') }}: {{ none($trayectoria->pressure, 'bar') }}<br>
                                {{ c('particulas') }}: {{ none($trayectoria->number_of_particles) }}<br>
                                {{ c('software') }}: {{ none($trayectoria->software_name) }}<br>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              {{ c('equipo') }}: {{ none($trayectoria->supercomputer) }}<br>
                              {{ c('rendimiento') }}: {{ none($trayectoria->performance, 'ns/day') }}<br>
                            </p>
                          </div>

                          </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      <?php // ->withQueryString()->links() La consulta se tiene que volver a pasar.  ?>
                      {{ $trayectorias->onEachSide(1)->withQueryString()->links() }}

                    </div>


                    <div class="card-body d-none   d-xl-block ">
                        <div class="table-responsive txt-white">
                        <table id="tabla-busqueda-avanzada" class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('FF') (@lang('resolución'))</th>
                                    <th>@lang('Lipidos')</th>
                                    <th>@lang('Peptidos')</th>
                                    <th>@lang('Heteromoléculas')</th>
                                    <th>@lang('Iones')</th>
                                    <th>@lang('Modelo de agua')</th>
                                    <th>@lang('Parametros de simulación')</th>
                                    <th>@lang('Analisis')</th>

                                </tr>
                            </thead>
                            <tbody>
                            @if($trayectorias->isEmpty())
                                <tr><td colspan="10" style="text-align: left">@lang('No se encontraron resultados')</td></tr>
                            @endif
                            @foreach($trayectorias as $trayectoria)
                                <tr>
                                    <td>NL{{ $trayectoria->id }}</td>
                                  <!--  <td>{{ none($trayectoria->campo_de_fuerza->name).' ('.none($trayectoria->campo_de_fuerza->resolution).')' }}</td>-->
                                    <td>
                                        @if(empty($trayectoria->lipidos)) None @endif
                                        @foreach($trayectoria->lipidos as $lipido)
                                            <span>
                                                {{ none($lipido->short_name) }} (<span title="leaflet_1">{{ none($lipido->pivot->leaflet_1) }}</span>:<span title="leaflet_2">{{ none($lipido->pivot->leaflet_2) }}</span>)
                                              <!--  <span title="membrane_model">{{ none($trayectoria->membrana->model) }}</span> -->
                                            </span>
                                            <br>
                                        @endforeach

                                    </td>
                                    <td>
                                        @if(empty($trayectoria->peptidos)) None @endif
                                        @foreach($trayectoria->peptidos as $peptido)
                                            <span>
                                                {{ none($peptido->name) }}
                                                <!--(<span title="membrane">{{ none($trayectoria->membrana->name) }}</span>:<span title="bulk">{{ none($peptido->pivot->bulk) }}</span>)-->
                                                <br>
                                                <?php $cut =  wordwrap($peptido->sequence,25,"...<br /> ",true);?>
                                                <span title="sequence"><?php echo $cut;?> </span><br>
                                                <span title="activity">{{ none($peptido->activity) }}</span>
                                            </span>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(empty($trayectoria->moleculas)) None @endif
                                        @foreach($trayectoria->moleculas as $molecula)
                                            <span style="white-space: nowrap">
                                                {{ none($molecula->short_name) }}
                                                (<span title="leaflet_1">{{ none($molecula->pivot->leaflet_1) }}</span>:<span title="leaflet_2">{{ none($molecula->pivot->leaflet_2) }}</span>|<span title="bulk">{{ none($molecula->pivot->bulk) }}</span>)
                                            </span>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(empty($trayectoria->iones)) None @endif
                                        @foreach($trayectoria->iones as $ion)
                                            <span style="white-space: nowrap">
                                                {{ none($ion->short_name) }} (<span title="bulk">{{ none($ion->pivot->bulk) }}</span>)
                                            </span>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(empty($trayectoria->modelos_acuaticos)) None @endif
                                        @foreach($trayectoria->modelos_acuaticos as $agua)
                                            {{ none($agua->short_name) }}
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ c('longitud') }}: {{ none($trayectoria->length, 'ns') }}<br>
                                        {{ c('campo_electrico') }}: {{ none($trayectoria->electric_field, 'V/nm') }}<br>
                                        {{ c('temperatura') }}: {{ none($trayectoria->temperature, 'K') }}<br>
                                        {{ c('presion') }}: {{ none($trayectoria->pressure, 'bar') }}<br>
                                        {{ c('particulas') }}: {{ none($trayectoria->number_of_particles) }}<br>
                                        {{ c('software') }}: {{ none($trayectoria->software_name) }}<br>
                                        {{ c('equipo') }}: {{ none($trayectoria->supercomputer) }}<br>
                                        {{ c('rendimiento') }}: {{ none($trayectoria->performance, 'ns/day') }}<br>
                                    </td>

                                    <td style="text-align: center"><a class="btn btn-primary" href="{{ route('trayectorias.show', $trayectoria->id) }}"><i class="fas fa-share"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $trayectorias->onEachSide(1)->withQueryString()->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        var url_filtros_html = "{{ route('filtros.html', ':filtro') }}";
        $('.mostrar_ocultar_filtros').click(function () {
            $('.contenedor-filtros').toggle();
            if($('.fa-chevron-left').length) {
                $('.fa-chevron-left').removeClass('fa-chevron-left').addClass('fa-chevron-down');
            } else {
                $('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-left');
            }
        })
        $('#selector-filtros').change(function () {
            $('.contenedor-filtros').show();
            let codigo = $(this).find('option:selected').val();
            if(codigo !== 'trayectoria') {
                $(this).find('option[value=' + codigo +']').hide();
            }
            if(codigo) {
                $.ajax({
                    'url': url_filtros_html.replace(':filtro', codigo),
                    'success': function(response) {
                        $('#filtros').prepend(response);
                        agregar_evento_eliminar_filtro();
                    }
                })

            }
            $('#selector-filtros').find('option[value=0]').prop('selected', true);
        })

        agregar_evento_eliminar_filtro();
        function agregar_evento_eliminar_filtro() {
            $('.eliminar_filtro').click(function () {
                let codigo = $(this).closest('.form-group').find('input').attr('name');
                $(this).closest('.form-group').remove();
                $('#selector-filtros').find('option[value=' + codigo +']').show();
            })
        }

    </script>
@endsection
