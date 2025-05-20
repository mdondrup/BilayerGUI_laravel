<?php
use App\Filtros\Filtro;
/**
 * @var Filtro[] $filtros_principales
 */
?>

@extends('layouts.app')

@section('content')

<?php
$numero_id =0;
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form id="formulario-busqueda-avanzada" action="{{ route('nueva_busqueda_avanzada.resultado') }}" method="get">

                    <div class=" ">
                        <div class="card-header" > <!-- style="display: flex; justify-content: space-between" -->
                            <div class="row">
                            <div class="col-xs-12 col-sm-6">
                              <span class="titulo"> @lang('Búsqueda avanzada')<span>
                            </div>
                            <div class="col-xs-12 col-sm-6 text-right" style="display: flex; align-items: aplicar_evento_eliminar_filtro">
                                <select id="selector-filtros" class="form-control btn-sm" name="" id="" style="width: inherit; margin-right: 20px">
                                    <option value="0">@lang('Agregar filtro')</option>
                                    @foreach($filtros_posibles as $filtro)
                                        <option value="{{ $filtro->codigo }}">{{ $filtro->label }}</option>
                                    @endforeach
                                </select>

                              <button type="button" class="btn btn-primary" style="font-size:8pt;width:100px" onclick="DeleteAll()">Delete Filters</button>
                              <input type="submit" class="btn btn-primary btn-light ml-4"  value="@lang('Buscar')">
                            </div>
                          </div>
                        </div>

                            <div class="search_result" style="padding-top: 0">

                              <div id="filtros-entidades" class="row align-items-start p-4">
                                <span class="titulo">By Component</span>
                                @foreach($filtros_principales as $filtro)
                                  <?php
                                  //  $numero_id++;
                                  if (isset($filtro->visible) && ($filtro->visible)) {
                                      $ocultarDiv = "";
                                  } else {
                                      $ocultarDiv = "display:none;";
                                  }

                                  ?>
                                   <div class="col-xs-12 col-md-6 align grupo-filtros p-2"  style="{{ $ocultarDiv }}" data-codigo="{{ $filtro->codigo }}" >
                                      {{ $filtro->html_busqueda_avanzada_selects() }}
                                   </div>

                                @endforeach

                              </div>

                              <div class=" pl-3">
                                 <span class="titulo">By MD simulations set-up</span>
                              </div>
                              <div id="filtros-propiedades" class="row align-items-start p-4">

                              @foreach($filtros_trayectorias as $filtro)
                              <?php
                                if (isset($filtro->visible) && ($filtro->visible)) {
                                  $ocultarDiv = "";
                                }else {
                                  $ocultarDiv = "display:none;";
                                }
                               ?>
                                  <div class="col-xs-12 col-md-6 align grupo-filtros p-2" style="{{ $ocultarDiv }}" data-codigo="{{ $filtro->codigo }}">
                                      {{ $filtro->html_busqueda_avanzada_selects() }}
                                  </div>

                                  <?php

                                   ?>
                              @endforeach
                              </div>

                                <div class="col-xs-12 col-lg-12 containerSlider">
                                  <span class="titulo">By MD-based quantitative descriptors </span><div class="tooltip-2 bi bi-info-circle">
                                      <span class="tooltiptext">Average and Standard deviations, calculated for the last microsecond of the trajectory, using the block averaging method.</span>
                                  </div>
                                  <hr>

                                  <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                      <div class="titulo">Area per lipid <div class="tooltip-2 bi bi-info-circle">
                                          <span class="tooltiptext">Average area per lipid, per leaflet, along the trajectory.</span>
                                      </div></div>

                                              <div class="col txt-titulo">Membrane (nm<sup>2</sup>): </div>
                                              <div id="slide_1" class="col multi-range" data-initvalue="{{$Area_per_lipid[0]->Area_per_lipidStart}}" data-endvalue="{{$Area_per_lipid[0]->Area_per_lipidEnd}}" data-prec= "2" data-namefield="Area_per_lipid"></div>

                                              <div class="col txt-titulo"> - Upper leaflet (nm<sup>2</sup>):</div>
                                              <div id="slide_2" class="col multi-range " data-initvalue="{{$Area_per_lipid_upper_leaflet[0]->Area_per_lipid_upper_leafletStart}}" data-endvalue="{{$Area_per_lipid_upper_leaflet[0]->Area_per_lipid_upper_leafletEnd}}" data-prec= "2" data-namefield="Area_per_lipid_upper_leaflet"></div>

                                              <div class="col txt-titulo"> - Lower leaflet (nm<sup>2</sup>):</div>
                                              <div id="slide_3" class="col multi-range" data-initvalue="{{$Area_per_lipid_lower_leaflet[0]->Area_per_lipid_lower_leafletStart}}" data-endvalue="{{$Area_per_lipid_lower_leaflet[0]->Area_per_lipid_lower_leafletEnd}}" data-prec= "2" data-namefield="Area_per_lipid_lower_leaflet"></div>


                                              <div class="titulo">Contacts <div class="tooltip-2 bi bi-info-circle">
                                                  <span class="tooltiptext">Number of contacts between the peptide and the water or the lipids (headgroups and tailgroups).</span>
                                              </div></div>

                                              <div class="col txt-titulo">Backbone - Water: </div>
                                              <div class="col multi-range" id="slide_12" data-initvalue="{{$Contacts_Protein_solvent[0]->Contacts_Protein_solventStart}}" data-endvalue="{{$Contacts_Protein_solvent[0]->Contacts_Protein_solventEnd}}" data-prec= "1" data-namefield="Contacts_Protein-solvent"></div>


                                              <div class="col txt-titulo">Backbone - Head groups: </div>
                                              <div class="col multi-range" id="slide_13" data-initvalue="{{$Contacts_Protein_headgroups[0]->Contacts_Protein_headgroupsStart}}" data-endvalue="{{$Contacts_Protein_headgroups[0]->Contacts_Protein_headgroupsEnd}}" data-prec= "1" data-namefield="Contacts_Protein-headgroups"></div>


                                              <div class="col txt-titulo">Backbone - Tail groups: </div>
                                              <div class="col multi-range" id="slide_14" data-initvalue="{{$Contacts_Protein_tailgroups[0]->Contacts_Protein_tailgroupsStart}}" data-endvalue="{{$Contacts_Protein_tailgroups[0]->Contacts_Protein_tailgroupsEnd}}" data-prec= "1" data-namefield="Contacts_Protein-tailgroups"></div>
                                              <hr>
                                              <div class="col titulo">Tilt (&deg;): <div class="tooltip-2 bi bi-info-circle">
                                                  <span class="tooltiptext">Peptide tilt angle evolution, defined as the angle between the peptide helical axis and the bilayer normal.</span>
                                              </div></div>
                                              <div class="col multi-range" id="slide_15" data-initvalue="{{$Tilt[0]->TiltStart}}" data-endvalue="{{$Tilt[0]->TiltEnd}}" data-prec= "0" data-namefield="Tilt"></div>



                                            </div>
                                            <div class="col-xs-12 col-md-6">


                                              <div class="titulo">Average Z coordinate <div class="tooltip-2 bi bi-info-circle">
                                                  <span class="tooltiptext">Z-coordinate (nm), averaged for the different parts of the system: peptide, membrane, first and last backbone (BB) residue and upper or lower lipid headgroups (HG).</span>
                                              </div></div>


                                              <div class="col txt-titulo">Peptide (nm):</div>
                                              <div id="slide_4" class="col multi-range" data-initvalue="{{$COG_of_protein[0]->COG_of_proteinStart}}" data-endvalue="{{$COG_of_protein[0]->COG_of_proteinEnd}}" data-prec= "1" data-namefield="COG_of_protein"></div>

                                              <div class="col txt-titulo"> - First Residue (nm):</div>
                                              <div id="slide_5" class="col multi-range" data-initvalue="{{$COG_BB_first[0]->COG_BB_firstStart}}" data-endvalue="{{$COG_BB_first[0]->COG_BB_firstEnd}}" data-prec= "1" data-namefield="COG_BB_first"></div>


                                              <div class="col txt-titulo"> - Last Residue (nm):</div>
                                              <div id="slide_6" class="col multi-range" data-initvalue="{{$COG_BB_last[0]->COG_BB_lastStart}}" data-endvalue="{{$COG_BB_last[0]->COG_BB_lastEnd}}" data-prec= "1" data-namefield="COG_BB_last"></div>


                                              <div class="col txt-titulo">Membrane (nm):</div>

                                              <div id="slide_7" class="col multi-range" data-initvalue="{{$COG_of_membrane[0]->COG_of_membraneStart}}" data-endvalue="{{$COG_of_membrane[0]->COG_of_membraneEnd}}" data-prec= "1" data-namefield="COG_of_membrane"></div>


                                              <div class="col txt-titulo"> - Upper leaflet Head Group (nm):</div>
                                              <div id="slide_8" class="col multi-range" data-initvalue="{{$COG_headgroups_upper_leaflet[0]->COG_headgroups_upper_leafletStart}}" data-endvalue="{{$COG_headgroups_upper_leaflet[0]->COG_headgroups_upper_leafletEnd}}" data-prec= "1" data-namefield="COG_headgroups_upper_leaflet"></div>


                                              <div class="col txt-titulo"> - Lower leaflet Head Group (nm):</div>
                                              <div id="slide_9" class="col multi-range" data-initvalue="{{$COG_headgroups_lower_leaflet[0]->COG_headgroups_lower_leafletStart}}" data-endvalue="{{$COG_headgroups_lower_leaflet[0]->COG_headgroups_lower_leafletEnd}}" data-prec= "1" data-namefield="COG_headgroups_lower_leaflet"></div>

                                              <hr>

                                              <div class="col titulo">Bilayer Thickness (nm): <div class="tooltip-2 bi bi-info-circle">
                                                  <span class="tooltiptext">Difference between the average position of the lipid headgroups of each leaflet over the last microsecond.</span>
                                              </div></div>


                                              <div class="col multi-range" id="slide_10" data-initvalue="{{$Bilayer_thickness[0]->Bilayer_thicknessStart}}" data-endvalue="{{$Bilayer_thickness[0]->Bilayer_thicknessEnd}}" data-prec= "1" data-namefield="Bilayer_thickness"></div>


                                              <div class="col titulo">Peptide depth (nm): <div class="tooltip-2 bi bi-info-circle">
                                                  <span class="tooltiptext">Distance between the average Z coordinates of the peptide backbone and of the lipid headgroups of the closest leaflet. Negative values correspond to relative positions with the peptide within the membrane.</span>
                                              </div></div>

                                              <div class="col multi-range" id="slide_11" data-initvalue="{{$Protein_depthness[0]->Protein_depthnessStart}}" data-endvalue="{{$Protein_depthness[0]->Protein_depthnessEnd}}" data-prec= "2" data-namefield="Protein_depthness"></div>


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


    <form id="formulario-busqueda-avanzada-submit" action="{{ route('nueva_busqueda_avanzada.resultado') }}" method="get" >

    </form>

@endsection

@section('js')

    <script>



        let url_html_busqueda_avanzada = "{{ route('filtros.html_busqueda_avanzada_selects', [':codigo', ':numero']) }}";

        $('input[type="text"]').change(function () {
            if($(this).val() == "") {
                $(this).closest('.form-row').find('input[type=radio]').prop('checked', false);
            }
        })

        aplicar_evento_duplicar_filtro();

        function aplicar_evento_duplicar_filtro() {
            $('[data-action=duplicate-filter]').off().click(function ()
            {
                let contenedor_filtro = $(this).closest('.contenedor-filtro-busqueda-avanzada');
                let grupo_filtros = contenedor_filtro.closest('.grupo-filtros');
                let numero_filtros = grupo_filtros.find('.contenedor-filtro-busqueda-avanzada').length;
                let actual_url_html_busqueda_avanzada = '';
                actual_url_html_busqueda_avanzada = url_html_busqueda_avanzada.replace(':codigo', grupo_filtros.data('codigo'));
                actual_url_html_busqueda_avanzada = actual_url_html_busqueda_avanzada.replace(':numero', numero_filtros);
                //console.log(contenedor_filtro);
                //console.log(grupo_filtros.data);
                //console.log(numero_filtros);
              //  $('.contenedor-filtro-busqueda-avanzada').closest('.grupo-filtros').show();
                $.ajax({
                    url: actual_url_html_busqueda_avanzada,
                    success: function (response) {
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
            $('[data-action=delete-filter]').off().click(function ()
            {
                $(this).closest('.contenedor-filtro-busqueda-avanzada').remove();
            })
        }

        aplicar_eventos_filtro();

        function aplicar_eventos_filtro() {
            $('.filtro-busqueda-avanzada').off().hover(function () {
                $(this).find('.acciones-filtro').show();
            }, function () {
                $(this).find('.acciones-filtro').hide();
            })
        }

        newSliderSelector();

        function newSliderSelector(){
          // Seleccionamos el formulario de envio de consulta
          var container = document.getElementById("formulario-busqueda-avanzada-submit");

          $(".multi-range").each(function( index ) {
              //  console.log( index + ": " + $( this ).text() );
                var newslider = this;
                var init = parseFloat(this.getAttribute('data-initvalue'));
                var end = parseFloat(this.getAttribute('data-endvalue'));
                var fieldName = this.getAttribute('data-namefield');
                var Precision = this.getAttribute('data-prec');

                noUiSlider.create(newslider, {
                    start: [init,end],
                    tooltips:[wNumb({decimals: Precision}),wNumb({decimals: Precision})],
                    connect: [false, true,false],
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
                a.name = fieldName+"-start";
                a.value = "";
                var b = document.createElement('input');
                b.type = "hidden";
                b.name = fieldName+'-end';
                b.value = "";
              var startInputSlide = container.appendChild(a);
              var endInputSlide =  container.appendChild(b);
              var inputs = [startInputSlide, endInputSlide];
              // Evento cambia los valores
              newslider.noUiSlider.on('slide', function (values, handle) {
                      //console.log(inputs[handle].name);
                      //inputs[handle].value = values[handle];
                      if (! $('input[name="'+inputs[handle].name+'"]').length) {
                        //Your code when inputName does not exist!
                      //  console.log('no existe');
                          $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="' + inputs[0].name +'" value="' + values[0] +'" />');
                          $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="' + inputs[1].name +'" value="' + values[1] +'" />');

                      } else{
                        // Parche si vuelve a la pagina.. lo mejor seria forzar la recarga
                        $('input[name="'+inputs[handle].name+'"]').val(values[handle]);
                        inputs[0].value = values[0];
                        inputs[1].value = values[1];
                      }


              });
          });

        }

        function DeleteAll() {
          $(".contenedor-filtro-busqueda-avanzada").remove();
          //$(".grupo-filtros").hide();
        }

        $('#formulario-busqueda-avanzada').submit(function () {

           //$('#formulario-busqueda-avanzada-submit').html(''); // initialize Form! be carrefull

           // Cualquier hidden con valor 0 es borrado para no mandarlos por el sumbit
           /*$("input:hidden").each(function (){
             if ($(this).val()==0) $(this).remove();
           })*/


            $('input').each(function ()
            {
                if($(this).attr('type') && $(this).prop('checked')) {
                    $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="' + $(this).attr('name') +'" value="' + $(this).val() +'" />');
                }
                // para el input text de la secuencia de aminoacidos

                //console.log($(this).attr('type'));
                if ($(this).attr('type')=="text"){
                    $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="' + $(this).attr('name') +'" value="' + $(this).val() +'" />');
                }
                //console.log($(this).attr('type') +" _ "+ $(this).val() + " _ " +$(this).attr('name'));
                if ( ($(this).val() == '')){
                  if ($(this).attr('type')!="text") $(this).remove();
                }
            })

            $('select').each(function ()
            {
                if($(this).is('select')){
                 if  ($(this).val() !== '') {
                    $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="' + $(this).attr('name') +'" value="' + $(this).val() +'" />');
                  } else {
                    // Clean select with nothing selected
                    var nameCut =$(this).attr('name').slice(0,-3) + "_operador";
                    $('input[name^="' + nameCut + '"]').each(function (){
                      if ($(this).attr('type')!="radio") $(this).remove();

                    })

                  }
                }
            })
            // HACK
            $('#formulario-busqueda-avanzada-submit').append('<input type="hidden" name="nothinghere" value="1" />');

            $('#formulario-busqueda-avanzada-submit').submit();

            return false;

        });

        $('#selector-filtros').change(function ()
        {
            let codigo = $(this).find('option:selected').val();
            if(codigo) {
                let contenedor_filtros = $('[data-codigo=' + codigo + ']');
                if (window.getComputedStyle($('[data-codigo=' + codigo + ']').get(0)).display === "none") {
                      contenedor_filtros.show();
                } else {

                let numero_filtros = $('[data-codigo=' + codigo + ']').find('.contenedor-filtro-busqueda-avanzada').length;
                //console.log( $('[data-codigo=' + codigo + ']').find('.contenedor-filtro-busqueda-avanzada'));
                //console.log(numero_filtros);
                let actual_url_html_busqueda_avanzada = '';
                actual_url_html_busqueda_avanzada = url_html_busqueda_avanzada.replace(':codigo', codigo);
                actual_url_html_busqueda_avanzada = actual_url_html_busqueda_avanzada.replace(':numero', numero_filtros);
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
