<?php
use App\Filtros\Filtro;
/**
 * @var Filtro[] $filtros_principales
 */
?>

@extends('layouts.app')

@section('content')
   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form id="formulario-busqueda-avanzada" action="{{ route('new_advanced_search.results') }}" method="get">

                    <div class=" ">
                        <div class="card-header">
                            <!-- style="display: flex; justify-content: space-between" -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <span class="titulo"> @lang('Advanced Search')<span>
                                </div>
                                <div class="col-xs-12 col-sm-6 text-right"
                                    style="display: flex; align-items: aplicar_evento_eliminar_filtro">
                                    <select id="selector-filtros" class="form-control btn-sm" name="" id=""
                                        style="width: inherit; margin-right: 20px">
                                        <option value="0">@lang('Add filter')</option>
                                        @foreach ($filtros_posibles as $filtro)
                                            <option value="{{ $filtro->codigo }}">{{ $filtro->label }}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-primary" style="font-size:8pt;width:100px"
                                        onclick="DeleteAll()">@lang('Delete Filters')</button>
                                    <input type="submit" class="btn btn-primary btn-light ml-4" value="@lang('Search')">
                                </div>
                            </div>
                        </div>

                        <div class="search_result" style="padding-top: 0">

                            <div id="filtros-entidades" class="row align-items-start p-4">
                                <span class="titulo">By Composition</span>
                                @foreach ($filtros_principales as $filtro)
                                    <?php
                                    //  $numero_id++;
                                    if (isset($filtro->visible) && $filtro->visible) {
                                        $ocultarDiv = '';
                                    } else {
                                        $ocultarDiv = 'display:none;';
                                    }

                                    ?>
                                    <div class="col-xs-12 col-md-6 align grupo-filtros p-2" style="{{ $ocultarDiv }}"
                                        data-codigo="{{ $filtro->codigo }}">
                                        {{ $filtro->html_busqueda_avanzada_selects() }}
                                    </div>
                                @endforeach

                            </div>

                            <div class=" pl-3">
                                <span class="titulo">By MD simulations set-up</span>
                            </div>
                            <div id="filtros-propiedades" class="row align-items-start p-4">

                                @foreach ($filtros_trayectorias as $filtro)
                                    <?php
                                    if (isset($filtro->visible) && $filtro->visible) {
                                        $ocultarDiv = '';
                                    } else {
                                        $ocultarDiv = 'display:none;';
                                    }
                                    ?>
                                    <div class="col-xs-12 col-md-6 align grupo-filtros p-2" style="{{ $ocultarDiv }}"
                                        data-codigo="{{ $filtro->codigo }}">
                                        {{ $filtro->html_busqueda_avanzada_selects() }}
                                    </div>

                                    <?php

                                    ?>
                                @endforeach
                            </div>

                            <div class="col-xs-12 col-lg-12 containerSlider">
                                <span class="titulo">By properties and quality</span>
                                <div class="tooltip-2 bi bi-info-circle">
                                    <span class="tooltiptext">Calculated from the trajectory and experimental data by FAIRMD Lipids scripts.</span>
                                </div>
                                

                                <hr>
                                <div class="row">

                                    <div class="col-xs-12 col-md-12">
                                        <div class="col titulo">Temperature (K)
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">Temperature</span>
                                            </div>
                                        </div>

                                        <div id="slide_temp" class="col multi-range"
                                            data-initvalue="{{ $temperature[0]->temperatureStart }}"
                                            data-endvalue="{{ $temperature[0]->temperatureEnd }}" data-prec="2"
                                            data-namefield="temperature"></div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xs-12 col-md-12">
                                        <div class="col titulo">Area per lipid (nm<sup>2</sup>)
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">Mean value over the trajectory.</span>
                                            </div>
                                        </div>

                                        <div id="slide_1" class="col multi-range"
                                            data-initvalue="{{ $Area_per_lipid[0]->Area_per_lipidStart }}"
                                            data-endvalue="{{ $Area_per_lipid[0]->Area_per_lipidEnd }}" data-prec="2"
                                            data-namefield="Area_per_lipid"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="col titulo">Total order parameter quality (P<sup>total</sup>):
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">See the definition in the NMRlipids databank
                                                    manuscript</span>
                                            </div>
                                        </div>
                                        <div class="col multi-range" id="slide_9"
                                            data-initvalue="{{ $QualityFactor[0]->quality_totalStart }}"
                                            data-endvalue="{{ $QualityFactor[0]->quality_totalEnd }}" data-prec="1"
                                            data-namefield="quality_total">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">

                                        <div class="col titulo">Headgroup order parameter quality (P<sup>headgroup</sup>):
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">See the definition in the NMRlipids databank
                                                    manuscript</span>
                                            </div>
                                        </div>
                                        <div class="col multi-range" id="slide_10"
                                            data-initvalue="{{ $Quality_HG[0]->quality_hgStart }}"
                                            data-endvalue="{{ $Quality_HG[0]->quality_hgEnd }}" data-prec="1"
                                            data-namefield="quality_hg">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">

                                        <div class="col titulo">Acyl chains order parameter quality (P<sup>tails</sup>):
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">See the definition in the NMRlipids databank
                                                    manuscript</span>
                                            </div>
                                        </div>
                                        <div class="col multi-range" id="slide_119"
                                            data-initvalue="{{ $Quality_Tails[0]->quality_tailsStart }}"
                                            data-endvalue="{{ $Quality_Tails[0]->quality_tailsEnd }}" data-prec="1"
                                            data-namefield="quality_tails">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="col titulo">Bilayer Thickness (nm):
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">Calculated from the intersections of lipid and
                                                    water electron densities.</span>
                                            </div>
                                        </div>
                                        <div class="col multi-range" id="slide_12"
                                            data-initvalue="{{ $Bilayer_thickness[0]->Bilayer_thicknessStart }}"
                                            data-endvalue="{{ $Bilayer_thickness[0]->Bilayer_thicknessEnd }}"
                                            data-prec="1" data-namefield="Bilayer_thickness">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="col titulo">Form factor quality:
                                            <div class="tooltip-2 bi bi-info-circle">
                                                <span class="tooltiptext">See the definition in the NMRlipids databank
                                                    manuscript</span>
                                            </div>
                                        </div>
                                        <div class="col multi-range" id="slide_12"
                                            data-initvalue="{{ $Form_factor_quality[0]->Form_factor_qualityStart }}"
                                            data-endvalue="{{ $Form_factor_quality[0]->Form_factor_qualityEnd }}"
                                            data-prec="1" data-namefield="Form_factor_quality">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary btn-light" value="@lang('Buscar')">
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>



@endsection

@section('js')
    <script>
        let url_html_busqueda_avanzada = "{{ route('filtros.html_busqueda_avanzada_selects', [':codigo', ':numero']) }}";

        $('input[type="text"]').change(function() {
            if ($(this).val() == "") {
                $(this).closest('.form-row').find('input[type=radio]').prop('checked', false);
            }
        })

        aplicar_evento_duplicar_filtro();

        function aplicar_evento_duplicar_filtro() {
            $('[data-action=duplicate-filter]').off().click(function() {
                let contenedor_filtro = $(this).closest('.contenedor-filtro-busqueda-avanzada');
                let grupo_filtros = contenedor_filtro.closest('.grupo-filtros');
                let numero_filtros = grupo_filtros.find('.contenedor-filtro-busqueda-avanzada').length;
                let actual_url_html_busqueda_avanzada = '';
                actual_url_html_busqueda_avanzada = url_html_busqueda_avanzada.replace(':codigo', grupo_filtros
                    .data('codigo'));
                actual_url_html_busqueda_avanzada = actual_url_html_busqueda_avanzada.replace(':numero',
                    numero_filtros);
                //console.log(contenedor_filtro);
                //console.log(grupo_filtros.data);
                //console.log(numero_filtros);
                //  $('.contenedor-filtro-busqueda-avanzada').closest('.grupo-filtros').show();
                $.ajax({
                    url: actual_url_html_busqueda_avanzada,
                    success: function(response) {
                        //console.log(response);
                        contenedor_filtro.after(response)
                        aplicar_eventos_filtro();
                        aplicar_evento_duplicar_filtro();
                        aplicar_evento_eliminar_filtro();
                    }
                })
            })
        }

        aplicar_evento_eliminar_filtro();

        function aplicar_evento_eliminar_filtro() {
            $('[data-action=delete-filter]').off().click(function() {
                $(this).closest('.contenedor-filtro-busqueda-avanzada').remove();
            })
        }

        aplicar_eventos_filtro();

        function aplicar_eventos_filtro() {
            $('.filtro-busqueda-avanzada').off().hover(function() {
                $(this).find('.acciones-filtro').show();
            }, function() {
                $(this).find('.acciones-filtro').hide();
            })
        }

        newSliderSelector();

        function newSliderSelector() {
            // Slider hidden inputs go directly into the main form
            var container = document.getElementById("formulario-busqueda-avanzada");

            $(".multi-range").each(function(index) {
                //  console.log( index + ": " + $( this ).text() );
                var newslider = this;
                var init = parseFloat(this.getAttribute('data-initvalue'));
                var end = parseFloat(this.getAttribute('data-endvalue'));
                var fieldName = this.getAttribute('data-namefield');
                var Precision = this.getAttribute('data-prec');

                noUiSlider.create(newslider, {
                    start: [init, end],
                    tooltips: [wNumb({
                        decimals: Precision
                    }), wNumb({
                        decimals: Precision
                    })],
                    connect: [false, true, false],
                    range: {
                        'min': [init],
                        'max': [end]
                    },
                    /*pips: {
                          mode: 'steps',
                          density: 5,
                          format: wNumb({
                                  decimals: 2,
                                  prefix: '',
                                  suffix: ''
                                  })
                        }*/
                });

                var a = document.createElement('input');
                a.type = "hidden";
                a.name = fieldName + "-start";
                a.value = "";
                var b = document.createElement('input');
                b.type = "hidden";
                b.name = fieldName + '-end';
                b.value = "";
                container.appendChild(a);
                container.appendChild(b);
                var inputs = [a, b];
                // Update hidden input values when slider moves
                newslider.noUiSlider.on('slide', function(values, handle) {
                    inputs[0].value = values[0];
                    inputs[1].value = values[1];
                });
            });

        }

        function DeleteAll() {
            $(".contenedor-filtro-busqueda-avanzada").remove();
            //$(".grupo-filtros").hide();
        }

        $('#formulario-busqueda-avanzada').submit(function() {
            var $form = $(this);

            // Disable empty datalist inputs and their operator radios
            $form.find('input[list]').each(function() {
                if ($(this).val() === '') {
                    $(this).prop('disabled', true);
                    // Disable matching operator radios: name "lipidos[0]" → "lipidos_operador[0]"
                    var name = $(this).attr('name');
                    var match = name.match(/^(.+)\[(\d+)\]$/);
                    if (match) {
                        var operadorName = match[1] + '_operador[' + match[2] + ']';
                        $form.find('input[name="' + operadorName + '"]').prop('disabled', true);
                    }
                }
            });

            // Disable empty selects and their operator radios (skip the filter selector dropdown)
            $form.find('select').each(function() {
                if ($(this).attr('id') === 'selector-filtros') return;
                if ($(this).val() === '') {
                    $(this).prop('disabled', true);
                    var name = $(this).attr('name');
                    var match = name.match(/^(.+)\[(\d+)\]$/);
                    if (match) {
                        var operadorName = match[1] + '_operador[' + match[2] + ']';
                        $form.find('input[name="' + operadorName + '"]').prop('disabled', true);
                    }
                }
            });

            // Disable slider hidden inputs that haven't been changed (empty values)
            $form.find('input[type="hidden"]').each(function() {
                if ($(this).val() === '') $(this).prop('disabled', true);
            });

            // Add nothinghere marker
            $form.append('<input type="hidden" name="nothinghere" value="1" />');

            // Submit the main form directly
            return true;
        });

        $('#selector-filtros').change(function() {
            let codigo = $(this).find('option:selected').val();
            if (codigo) {
                let contenedor_filtros = $('[data-codigo=' + codigo + ']');
                if (window.getComputedStyle($('[data-codigo=' + codigo + ']').get(0)).display === "none") {
                    contenedor_filtros.show();
                } else {

                    let numero_filtros = $('[data-codigo=' + codigo + ']').find(
                        '.contenedor-filtro-busqueda-avanzada').length;
                    //console.log( $('[data-codigo=' + codigo + ']').find('.contenedor-filtro-busqueda-avanzada'));
                    //console.log(numero_filtros);
                    let actual_url_html_busqueda_avanzada = '';
                    actual_url_html_busqueda_avanzada = url_html_busqueda_avanzada.replace(':codigo', codigo);
                    actual_url_html_busqueda_avanzada = actual_url_html_busqueda_avanzada.replace(':numero',
                        numero_filtros);
                    //console.log(actual_url_html_busqueda_avanzada);
                    $.ajax({
                        'url': actual_url_html_busqueda_avanzada,
                        'success': function(response) {
                            //console.log(response);
                            contenedor_filtros.append(response);
                            aplicar_eventos_filtro();
                            aplicar_evento_duplicar_filtro();
                            aplicar_evento_eliminar_filtro();
                        }
                    })

                } // IF visible
            }
            $('#selector-filtros').find('option[value=0]').prop('selected', true);
        })
    </script>
@endsection
