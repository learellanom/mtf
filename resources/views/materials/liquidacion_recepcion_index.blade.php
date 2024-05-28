@extends('adminlte::page')

@section('title', 'Liquidacion Recepcion')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Liquidacion Recepcion de Material') }} <i class="fas fa-people-arrows"></i> </h1></a>

@stop
@php
    $config1 =
    [
        "allowClear" => true,
    ];

    $config2 =
    [
        "allowClear" => true,
    ];

    $config3 = [
        "locale" => ["format" => "DD-MM-YYYY"],
        "allowClear" => true,
    ];

    $myClass	        = new app\Http\Controllers\TransactionController;
    $myAdministrator    = $myClass->isAdministrator();

@endphp 


@section('content')



<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}


        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <p class="text-uppercase font-weight-bold col-12 col-lg-4">
                        Liquidacion Recepcion
                    </p>
                    <p class="text-uppercase font-weight-bold col-12 col-lg-4">
                        Numero Liquidacion : {{ $myLiquidationNumber ?? ''}}
                        - Fecha Liquidacion : {{ $myLiquidationDate ?? ''}}

                    </p>                    
                </div>
                <div class="row">
                    {{--
                    <div class ="col-12 col-lg-2 float-right" >
                        <x-adminlte-date-range
                            id="drCustomRanges"
                            name="drCustomRanges"
                            enable-default-ranges="Last 30 Days"
                            style="height: 30px;"
                            :config="$config3">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-dark">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-date-range>
                    </div>
                    --}}

                    <div class ="col-12 col-sm-2">
                        <x-adminlte-select2 id="wallet"
                                            name="optionsCliente"
                                            igroup-size="sm"
                                            label-class="text-lightblue"
                                            data-placeholder="Wallet ..."
                                            :config="$config1"
                                            disabled
                                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-dark">
                                    <!-- <i class="fas fa-car-side"></i> -->
                                    <i class="fas fa-box"></i>
                                </div>
                            </x-slot>

                            <x-adminlte-options :options="$wallet" empty-option="Selecciona un Wallet.."/>
                        </x-adminlte-select2>
                    </div>

                    <div class ="col-12 col-sm-2">
                        <x-adminlte-select2 id="group"
                                            name="optionsGroup"
                                            igroup-size="sm"
                                            label-class="text-lightblue"
                                            data-placeholder="Grupo ..."
                                            :config="$config2"
                                            disabled
                                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-dark">
                                    <!-- <i class="fas fa-car-side"></i> -->
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </x-slot>

                            <x-adminlte-options :options="$group" empty-option="Selecciona un Grupo.."/>
                        </x-adminlte-select2>
                    </div>

                    {{--
                    @if($myAdministrator == true)
                        <div class ="col-12 col-lg-2">
                            <x-adminlte-select2 id="usuario"
                                                name="optionsUsuario"
                                                igroup-size="sm"
                                                label-class="text-lightblue"
                                                data-placeholder="Usuario ..."
                                                :config="$config2"
                                                >
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-dark">
                                        <!-- <i class="fas fa-car-side"></i> -->
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                </x-slot>

                                <x-adminlte-options :options="$user" empty-option="Selecciona un Usuario.."/>
                            </x-adminlte-select2>
                        </div>
                    @endif
                    --}}

                    {{--
                    <div class ="col-12 col-lg-2">
                        <x-adminlte-select2 id="type_material_id"
                                            name="type_material_id"
                                            igroup-size="sm"
                                            label-class="text-lightblue"
                                            data-placeholder="Material ..."
                                            :config="$config1"
                                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-dark">
                                    <!-- <i class="fas fa-car-side"></i> -->
                                    <!-- <i class="fas fa-user-tie"></i> -->
                                    <i class="fas fa-solid fa-dollar-sign"></i>                        
                                </div>
                                
                            </x-slot>

                            <x-adminlte-options :options="$Type_material" empty-option="Selecciona un material.."/>

                        </x-adminlte-select2>
                    </div>
                    --}}

                </div>


            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%;"   >Nro Liquidacion</th> 
                                    <th style="width:1%;"   >Nro</th>
                                    <th style="width:8%;"   >Caja</th>
                                    <th style="width:8%;"   >Grupo</th>
                                    <th style="width:8%;"   >Fecha</th>
                                    <th style="width:8%;"   >Fecha Creacion</th>
                                    <th                     >Descripción</th>
                                    <th                     >Material</th>
                                    
                                    <th style="width:8%;"   >Cantidad</th>
                                    <th style="width:8%;"   >Tipo Adquisicion</th>

                                    <th class="no-exportar" >Agente</th>
                                    <th style="width:10%;"  >Tipo de Movimiento</th>

                                    
                                    <th style="width:1%;" class="no-exportar">Ver <i class="fas fa-search"></i></th>
                                    
                                    @can('materials.recepcion_audit')
                                        <th style="width:1%;" class="no-exportar">Historico</th>
                                    @endcan
                                    
                                </tr>
                            </thead>
                            
                                @foreach($movimientos as $movimiento)
                                    @php 
                                        $myDesTypeAdquisicion   = $myClass->getDesTyperAdquisicion($movimiento->material_type_adquisicion);
                                        switch($movimiento->material_type_adquisicion){
                                            case 1:

                                                $myMaterialAmount       = $movimiento->material_amount_kilos;
                                                break;
                                            case 2:
                                                $myMaterialAmount       = $movimiento->material_amount_gramos;
                                                break;
                                            case 3:
                                                $myMaterialAmount       = $movimiento->material_amount_cantidad;
                                                break;
                                            default:
                                                $myMaterialAmount       = 0;

                                        }

                                    @endphp
                                    
                                    
                                    <tr>
                                        <td class="font-weight-bold">{{ $movimiento->liquidation_number }}</td>
                                        <td class="font-weight-bold">{{ $movimiento->id }}</td>
                                        <td class="font-weight-bold">{{ $movimiento->wallet->name ?? "" }}</td>                                    
                                        <td class="font-weight-bold">{{ $movimiento->group->name ?? "" }}</td>
                                        <td class="font-weight-bold" style="min-width: 80px;">{!! $movimiento->transaction_date !!}</td>
                                        <td class="font-weight-bold" style="min-width: 80px;">{!! $movimiento->created_at !!}</td>
                                        <td class="font-weight-bold">
                                            <div style='width:60px; height:60px; overflow:hidden;'>{!!  $movimiento->description !!}</div>
                                        </td>
                                        <td >{!! $movimiento->type_material->name ?? '' !!}</td>


                                        <td>{!! number_format($myMaterialAmount,2) ?? '' !!}</td>
                                        <td>{!! $myDesTypeAdquisicion ?? '' !!}</td>
                                        <td class="font-weight-bold">{!! $movimiento->user->name ?? '' !!}</td>
                                        <td>{!! $movimiento->type_transaction->name !!}</td>

                                        <td>

                                            <a href="{{ route('transactions.show', $movimiento->id) }}"
                                            
                                                class="btn btn-xl text-dark mx-1 shadow text-center">
                                                <i class="fa fa-lg fa-fw fas fa-search"></i>
                                            </a>
                                        </td>
                                        @can('materials.recepcion_audit')
                                            <td>
                                                <a  href="{{ route('materials.recepcion_audit', $movimiento) }}"  
                                                    class="btn btn-xl text-dark mx-1 shadow text-center">
                                                    <i class="fa fa-lg fa-fw fas fa-solid fa-list"></i>        
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>

                                @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('css')

@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#table').DataTable( {

            language: {
            "decimal": "",
            "emptyTable": "Sin transacciones registradas, seleccione un criterio de busqueda.",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "order": [[ 3, 'desc' ]],
        'dom' : 'Bfrtip',
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [ 1, 2, 3,4,5,6,7,8,9 ] },
                text:    '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',
                "excelStyles": [
                    {
                        "template": ["title_medium", 'blue_gray_medium']
                    },

                    {
                        "cells": "2",
                        "style": {
                            "font": {
                                "size": "18",
                                "color": "FFFFFF"
                            },
                            "fill": {
                                "pattern": {
                                    "type": "solid",
                                    "color": "002B5B"
                                }
                            },

                        }
                    },
                    {
                        "cells": "1",
                        "style": {
                            "font": {
                                "size": "20",
                                "color": "FFFFFF"
                            },
                            "fill": {
                                "pattern": {
                                    "size": "25",
                                    "type": "solid",
                                    "color": "0B2447",
                                }
                            }
                        }
                    },
                    {
                        'cells': "sC",
                        'template': "date_long",
                    },
                    {
                        "cells": "A",
                        "width": "25",
                    },                    
                    {
                        "cells": "B",
                        "width": "25",
                    },
                    {
                        "cells": "D",
                        "width": "20",
                    },                    
                    {
                        "cells": "E",
                        "width": "25",
                    },
                    {
                        "cells": "F",
                        "width": "40",
                    },   
                    {
                        "cells": "G",
                        "width": "15",
                    },
                    {
                        "cells": "H",
                        "width": "19.15",
                    },
                    {
                        "cells": "I",
                        "width": "30",
                    }
                ]

            },
            {
                extend:  'pdfHtml5',
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'MTF | LISTA DE ADQUISICIONES',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',

                exportOptions: {
                columns: ":not(.no-exportar)" //exportar toda columna que no tenga la clase no-exportar
                },
                customize: function ( doc ) {
                    doc.styles.tableHeader = {
                        fillColor:'#525659',
                        color:'#FFF',
                        fontSize: '8',
                        alignment: 'left',
                        bold: true
                    },

                    doc.content.splice(1, 0, {
                        columns: [ {
                            margin: [40, 30],
                            text: 'MTF |LISTA DE TRANSACCIÓNES',
                            fontSize: 30,
                            bold: true
                        }]
                    }),
                    doc.defaultStyle.fontSize = 10;
                    doc.pageMargins = [50,50,30,30];
                    doc.content[1].margin = [ 5, 0, 0, 5];
                    doc.styles.title = {
                            color: 'dark',
                            fontSize: '1',
                            alignment: 'center'
                        }
                    doc.styles['td:nth-child(2)'] = {
                        width: '100px',
                        'max-width': '100px'
                    }
                    doc.styles.tableHeader = {
                        fillColor:'#0B2447',
                        color:'white'
                    }
                },

            },
        ]
        });
    });
    
    const myUsuario = {{ $myUser }};
    BuscaElemento('usuario', myUsuario);

    const myTypeMaterial = {!! $myTypeMaterial !!};
    BuscaElemento('type_material_id', myTypeMaterial);

    const myWallet = {!! $myWallet !!};
    BuscaElemento('wallet', myWallet);

    const myGroup = {!! $myGroup !!};
    BuscaElemento('group', myGroup);

    $(() => {

        BuscaFechas();
        
        $('#drCustomRanges, #wallet, #group').on('change', function () {
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });        

        $('#usuario').on('change', function () {
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        
		$('#type_material_id').on('change', function (){
            theRoute();   
        })            
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
     
    });



    function theRoute(user = 0, fechaDesde = 0, fechaHasta = 0, coin = 0, material = 0){

        user        = $('#usuario').val() == "" ? 0 : $('#usuario').val();
        wallet      = $('#wallet').val() == ""  ? 0 : $('#wallet').val();
        group       = $('#group').val() == ""   ? 0 : $('#group').val();

        fechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                    '-' +
                    ($('#drCustomRanges').val()).substr(3,2) +
                    '-' +
                    ($('#drCustomRanges').val()).substr(0,2)
                    ;

        fechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                    '-' +
                    ($('#drCustomRanges').val()).substr(16,2) +
                    '-' +
                    ($('#drCustomRanges').val()).substr(13,2)
                    ;
        type_material = ($('#type_material_id').val()) ? $('#type_material_id').val() : 0;


        // let user = "";
        let Route ="";

        myRoute = "";
        myRoute = "{{ route('materials.recepcion_index', ['user' => 'user2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'type_material' => 'type_material2', 'group' => 'group2', 'wallet' => 'wallet2']) }}"; 
        // console.log('myRoute ->' + myRoute);
        myRoute = myRoute.replace('user2',user);
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('group2',group);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        myRoute = myRoute.replace('type_material2',type_material);
        myRoute = myRoute.replaceAll('amp;','');

        // alert(myRoute);
        

        // alert('la ruta ->' + myRoute);
        location.href = myRoute;

    }

    function BuscaFechas(){
        
        //console.log('fechaDesde ->' + '{{$fechaDesde}}');
        //console.log('fechaHasta ->' + '{{$fechaHasta}}');
         $('#drCustomRanges').data('daterangepicker').setStartDate('{{$fechaDesde}}');
         $('#drCustomRanges').data('daterangepicker').setEndDate('{{$fechaHasta}}');

    };

    function BuscaUsuario(){



        if ({{ $myUser }} == "") {
            return;
        }
        if ({{ $myUser }} == 0) {
            return;
        }        
        const miUsuario = {{ $myUser }};
        
        $('#usuario').each( function(index, element){ 
            $(this).children("option").each(function(){
                
                if ($(this).val() === miUsuario.toString()){
                
                    $("#usuario option[value="+ miUsuario +"]").attr("selected",true);              
                    
                }
            });
        });
    }
    function noEditar(){
        Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar transacción anulada',
                showConfirmButton: true
        }
        );          
    }



    function BuscaTypeMaterial(myTypeMaterial){
        // alert("BuscaTypeMaterial - myTypeMaterial -> " + myTypeMaterial);

        let mySelect = "type_material_id";
        let myValue  = myTypeMaterial;

        $('#' + mySelect).each( function(index, element){
            // alert ("BuscaMaterial -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myValue.toString()){
                    // alert('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }


    function BuscaElemento(myControl, myElement){

        let mySelect = myControl;
        let myValue  = myElement;

        $('#' + mySelect).each( function(index, element){
            // alert ("BuscaMaterial -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myValue.toString()){
                    // alert('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }


</script>
@endsection

