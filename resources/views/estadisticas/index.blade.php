@extends('adminlte::page')
@section('title', 'Estadistica por transacciones')
@section('content')
{{-- Setup data for datatables --}}



@php

$myClass = new app\Http\Controllers\statisticsController;
$myCredits = $myClass->getCredits();
$myDebits  = $myClass->getDebits();

// dd($myCredits . ' - ' . $myDebits);

// $myCredits = app\Http\Controllers\statisticsController::getCredits();

$config = [
    'data' => $Transacciones,
    'order' => [[1, 'desc']],
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false]],
];

$config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';



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


$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

$myTotal = 0;
if (isset($balance->Total)){
    //echo "ajua";
    //var_dump($balance);
    $myTotal = $balance->Total;
}

@endphp


<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Detalles de Transacciones') }} <i class="fas fa-chart-pie fa-spin"></i></h1>
<br>
<br>
{{-- Disabled --}}


<div class="container-left">
    <div class="row col-12">
        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="userole"
                                class="mySelect"
                                name="optionsUsers"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Agente..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$userole" empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="group"
                                name="optionsGroup"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Grupo ..."
                                :config="$config2"
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

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="typeTransactions"
                                name="optionstypeTransactions"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Tipo Transaccion ..."
                                :config="$config2"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$typeTransactions" empty-option="Selecciona Transaccion.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>

        <div class ="col-12 col-sm-2">
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

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="wallet"
                                name="optionsWallets"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Wallet..."
                                :config="$config4"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-box"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$wallet" empty-option="Wallet.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>

    </div>
</div>


<br>
<br>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="card-title col-md-12">
                    <div class="card-body">
                        <div class= "row">
                            <div class="col-md-4">
                                <h4 class="text-uppercase font-weight-bold">{{ __('Detalles|Movimientos') }} <i class="fas fa-info-circle"></i></h4>
                            </div>
                            <div class="col-md-4">

                                @if($myTotal< 0)
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo A favor' )}}: {{ number_format(abs($myTotal),2,",",".") }} $</h4>
                                @else
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo A favor' )}}: {{ number_format(0,2,",",".") }} $</h4>
                                @endif

                            </div>
                            <div class="col-md-4">

                                @if($myTotal< 0)
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo Pendiente' )}}: {{ number_format(0,2,",",".") }} $</h4>
                                @else
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo Pendiente' )}}: {{ number_format($myTotal,2,",",".") }} $</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table
                            class="table table-bordered table-responsive-lg"
                            id="table"
                            style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:10%;">Fecha</th>
                                    <th style="width:1%;">Transacción</th>
                                    <th style="width:10%;">Descripción</th>
                                    <th style="width:7%;">Token</th>
                                    <th style="width:1%;"><p style="display:none;">P - %</p>Moneda</th>
                                    <th style="width:6%;">Monto Moneda </th>
                                    <th style="width:1%;">Tasa</th>
                                    <th style="width:1%;">Monto $ </th>
                                    <th style="width:1%;">%</th>
                                    <th style="width:1%;">Comisión</th>
                                    <th style="width:1%;">Monto total</th>
                                    <th style="width:1%;">Saldo <i class="fas fa-dolar"></i></th>
                                    <th style="width:1%;">Cliente</th>
                                    <th style="width:1%;">Agente</th>
                                    <th style="width:1%;">Caja</th>
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>
                                </tr>
                            </thead>
                            @php
                                $myTotal = 0;
                            @endphp
                            @foreach($config['data'] as $row)

                                @php
                                    if ($myWallet != 0){
                                         //       dd($myWallet);
                                        $myPorcentajeComision   = $row->PorcentajeComisionBase;
                                        $myMontoComision        = $row->MontoComisionBase;
                                        $myTotal2               = $row->MontoTotalBase;

                                        $TasaCambio             = $row->TasaCambioBase;
                                        $Monto                  = $row->MontoBase;
                                        $Monto                  = $row->Monto;
                                     

                                    }else{
                                        
                                        $myPorcentajeComision   = $row->PorcentajeComision;
                                        $myMontoComision        = $row->MontoComision;
                                        $myTotal2               = $row->MontoTotal;

                                        $TasaCambio             = $row->TasaCambio;                                        
                                        $Monto                  = $row->Monto;
                                    }
                                    // 'Transactions.amount_total_base         as MontoTotalBase',
                                    // 'Transactions.percentage_base           as PorcentajeComisionBase',
                                    // 'Transactions.amount_commission_base    as MontoComisionBase',

                                @endphp


                                <tr>
                                    <td>{!! $row->FechaTransaccion !!}</td>
                                    <td>{!! $row->TipoTransaccion !!}</td>
                                    <td>{!! $row->Descripcion !!}</td>
                                    <td>{!! $row->token !!}</td>
                                    <td>{!! $row->TipoMoneda !!}</td>
                                    <td class="text-right"  >{!! number_format($row->MontoMoneda,2,",",".") !!}</td>
                                    <td class="text-left"   >{!! number_format($TasaCambio,2,",",".") !!}</td>
                                    <td class="text-right"  >{!! number_format($Monto,2,",",".") !!}</td>
                                    <td class="text-left"   >{!! number_format($myPorcentajeComision,2,",",".") !!}</td>
                                    <td class="text-right"  >{!! number_format($myMontoComision,2,",",".") !!}</td>
                                    <td class="text-right"  >{!! number_format($myTotal2,2,",",".") !!}</td>

                                    @php
                                        switch  ($row->TransactionId){
                                            case 1:
                                            case 3:
                                            case 5:
                                            case 7:
                                            case 9:
                                            case 11:
                                            case 12:                                                
                                                // $myTotal = $myTotal + ($row->MontoTotal * -1);
                                                $myTotal = $myTotal + ($myTotal2 * -1);                                                
                                                break;
                                            case 2:
                                            case 4:
                                            case 6:                                                
                                            case 8:
                                            case 10:                                                                                                
                                            case 13:                                                
                                                // $myTotal = ($myTotal) + ($row->MontoTotal);
                                                $myTotal = ($myTotal) + ($myTotal2);                                                
                                                break;
                                            default:
                                                $myTotal = 0;
                                                break;
                                        }
                                    @endphp
                                    <td class="text-right">{!! number_format($myTotal,2,",",".") !!}</td>


                                    <td>{!! $row->ClientName !!}</td>
                                    <td>{!! $row->AgenteName !!}</td>
                                    <td>{!! $row->WalletName !!}</td>

                                    <td class="text-center">
                                        <a
                                            href="{{ route('transactions.show', ['movimiento'=> $row->Id]) }}"
                                            title="Detalles"
                                            class="btn btn-xl text-dark mx-1 shadow text-center">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')
    @routes
    <script>
    
    const miGrupo               = {!! $myGroup !!};
    const miUsuario             = {!! $myUser !!};
    const miWallet              = {!! $myWallet !!};
    const miTypeTransactions    = {!! $myTypeTransactions !!};
    const miTotal               = {!! $myTotal !!};   
     
    // alert ('myTotal ->' +);
    // console.log(miCliente);

    // alert('miCLiente -> ' + miCliente);
    // alert('miUser    -> ' + miUsuario);
    // alert('miWallet  -> ' + miWallet);

    const miGrupoDes = BuscaGrupo(miGrupo);

    // BuscaCliente(miCliente);
    BuscaUsuario(miUsuario);
    BuscaWallet(miWallet);
    BuscaTypeTransactions(miTypeTransactions); 
    
    $('#table').DataTable( {

        language: {
            "decimal": "",
            "emptyTable": "No hay transacciones.",
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
        "order": [[ 0, 'asc' ]],
        'dom' : 'Bfrtilp',
        'pageLength' : 7, 
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11] },
                text:    '<i class="fas fa-file-excel"></i>',
                title: `Detalle de Movimientos`,
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',
                "excelStyles": [
                    {
                        "template": ["title_medium", "gold_medium"]
                    },

                    {
                        "cells": "1",
                        "content": "prueba",
                        "height": 40,
                        "style": {
                            "font": {
                                "size": "40",
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

                    // {
                    //     "cells": "3",
                    //     "style": {
                    //         "font": {
                    //             "size": "18",
                    //             "color": "FFFFFF"
                    //         },
                    //         "fill": {
                    //             "pattern": {
                    //                 "size": "25",
                    //                 "type": "solid",
                    //                 "color": "0B2447",
                    //             }
                    //         }
                    //     }
                    // },     
                    {
                        "cells": "sA",
                        "width": 19
                    },                                        
                    {
                        "cells": "sC",
                        "width": 45
                    },     
                    {
                        "cells": "sD",
                        "width": 12
                    },                                     
                    {
                        "cells": "sE",
                        "width": 25,                        
                        "style": {
                            "alignment":{
                                "vertical": "right",
                                "horizontal" : "right"
                            }
                        }
                    },
                    {
                        "cells": "sF",
                        "width": 11,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "vertical": "right",
                                "horizontal" : "right"
                            }
                        }
                    },
                    {
                        "cells": "sG",
                        "width": 9,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "vertical": "right",
                                "horizontal" : "right"
                            }
                        }
                    }, 
                    {
                        "cells": "sH",
                        "width": 21,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "vertical": "right",
                                "horizontal" : "right"
                            }
                        }
                    },                     
                    {
                        "cells": "I",
                        "width": 20,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "vertical": "right",
                                "horizontal" : "right"
                            }
                        }
                    },
                    {
                        "cells": "sJ",
                        "width": 20,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "horizontal" : "right"
                            }
                        }
                    },
                    {
                        "cells": "K",
                        "width": 20,
                        "style": {
                            "numFmt": "#,##0;(#,##0)",
                            "alignment":{
                                "horizontal" : "right"
                            }
                        }
                    } ,
                    {
                        "cells": "l",
                        "width": 20,
                        "style": {
                            "alignment":{
                                "vertical": "left",                                
                                "horizontal" : "left"
                            }
                        }
                    }           
                ],
                // "insertCells": [
                //     {
                //         "cells": "A2:B2",
                //         "content": ["Cliente", `${miGrupoDes}`]
                //         ,
                //         "pushRow": true
                //     },
                //     {
                //         "cells": "A3:B3",
                //         "content": ["Saldo", `${miTotal}`]
                //         ,
                //         "pushRow": true
                //     }                    
                // ]                                                                                                                   
            },
            {
                extend:  'pdfHtml5',
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'MTF | LISTA DE TRANSACIÓNES',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',

            },
            {
                extend:  'print',
                text:    '<i class="fas fa-print"></i>',
                titleAttr: 'Capture de pantalla',
                className: 'btn btn-info'
            },
        ]
    });



    $(() => {

        const myFechaDesde = {!! isset($myFechaDesde) ?? 0 !!};
        const myFechaHasta = {!! isset($myFechaHasta) ?? 0 !!};
        
        BuscaFechas(myFechaDesde, myFechaHasta);


        $('#userole').on('change', function (){

            const usuario           = $('#userole').val();
            const grupo             = $('#group').val();
            const wallet            = $('#wallet').val();
            const typeTransactions  = $('#typeTransactions').val();
            theRoute(usuario,grupo,wallet, typeTransactions);

        });

        $('#group').on('change', function (){

            const usuario = $('#userole').val();

            const grupo   = $('#group').val();
            const wallet = $('#wallet').val();
            const seleccionado = $('#group').prop('selectedIndex');
            const typeTransactions  = $('#typeTransactions').val();
            // alert('***** cliente ' +  cliente + " --- selected index --- " + seleccionado);

            var URLactual = window.location;
            // alert(URLactual);

            theRoute(usuario,grupo,wallet, typeTransactions);


        });

        $('#wallet').on('change', function (){

            const usuario = $('#userole').val();
            const grupo   = $('#group').val();
            const wallet = $('#wallet').val();
            const typeTransactions  = $('#typeTransactions').val();
            // alert('***** wallet ' +  wallet);
                theRoute(usuario,grupo,wallet, typeTransactions);

        });

        $('#drCustomRanges').on('change', function () {
            // alert('Fechas rnagos -> ' + $('#drCustomRanges').val());
            let myFechaDesde, myFechaHasta;

            myFechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(3,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(0,2)
                            ;

            myFechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(16,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(13,2)
                            ;

            myFechaDesde = $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD');
            myFechaHasta = $('#drCustomRanges').data('daterangepicker').endDate.format('YYYY-MM-DD');

            // alert('Fecha Desde -> ' + myFechaDesde + ' Fecha Hasta -> ' + myFechaHasta);
            const usuario           = $('#userole').val();
            const grupo             = $('#group').val();
            const wallet            = $('#wallet').val();
            const typeTransactions  = $('#typeTransactions').val();
            theRoute(usuario,grupo,wallet,typeTransactions, myFechaDesde,myFechaHasta);
        });


        $('#typeTransactions').on('change', function (){

            const usuario           = $('#userole').val();
            const grupo             = $('#group').val();
            const wallet            = $('#wallet').val();
            const typeTransactions  = $('#typeTransactions').val();
            let myFechaDesde = 0, myFechaHasta;
            // alert('aqui -> ' + typeTransactions + ` fechaDesde ${myFechaDesde}`);
            // theRoute(usuario, grupo, wallet,typeTransactions,myFechaDesde,myFechaHasta);
            theRoute(usuario, grupo, wallet, typeTransactions, myFechaDesde, myFechaHasta);

            });

        });


        function theRoute(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){

            if (usuario === "") usuario = 0;
            if (grupo   === "") grupo = 0;
            if (wallet  === "") wallet  = 0;
            if (typeTransactions  === "") typeTransactions  = 0;
            
            /*
            alert(
                `
                Usuario - > ${usuario} 
                grupo   -> ${grupo} 
                wallet  -> ${wallet} 
                typeTransactions -> ${typeTransactions} 
                fechaDesde -> ${fechaDesde} 
                fechaHasta -> ${fechaHasta} 
                `
            );
            */

            let myRoute = "";
                myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2' , 'typeTransactions' => 'typeTransactions2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
                myRoute = myRoute.replace('grupo2',grupo);
                myRoute = myRoute.replace('usuario2',usuario);
                myRoute = myRoute.replace('wallet2',wallet);
                myRoute = myRoute.replace('typeTransactions2',typeTransactions);                
                myRoute = myRoute.replace('fechaDesde2',fechaDesde);
                myRoute = myRoute.replace('fechaHasta2',fechaHasta);

            // alert(myRoute);
            location.href = myRoute;

        }

        function BuscaGrupo(miGrupo){
            //alert("Busca grupo - miGrupo -> " + miGrupo);
            $('#group').each( function(index, element){
                //alert ("Busca Grupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miGrupo.toString()){
                        //alert('Busca Grupo - encontro');
                        $("#group option[value="+ miGrupo +"]").attr("selected",true);
                        
                    }

                });
            });
            return  $("#group option:selected").text().trim();
            //
        }

        function BuscaCliente(miCliente){
            //alert("BuscaCliente - miCliente -> " + miCliente);
            $('#cliente').each( function(index, element){
                //alert ("Buscacliente -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miCliente.toString()){
                        //alert('BUscaCliente - encontro');
                        $("#cliente option[value="+ miCliente +"]").attr("selected",true);
                    }

                });
            });
            //
        }

        function BuscaUsuario(miUsuario){
            if (miUsuario===0){
                return;
            }
            // alert("BuscaUsuario - miUsuario -> " + miUsuario);
            $('#userole').each( function(index, element){
                // alert ("BuscaUsuario -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miUsuario.toString()){
                        // alert('BuscaUsuario - encontro');
                        $("#userole option[value="+ miUsuario +"]").attr("selected",true);
                    }
                    // alert("BuscaUsuario aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }

        function BuscaWallet(miWallet){
            if (miWallet===0){
                return;
            }
            // alert("BuscaWallet - miWallet -> " + miWallet);
            $('#wallet').each( function(index, element){
                // alert ("BuscaWallet -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miWallet.toString()){
                        // alert('BuscaWallet - encontro');
                        $("#wallet option[value="+ miWallet +"]").attr("selected",true);
                    }
                    // alert("BuscaWallet aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }


        function BuscaTypeTransactions(miTypeTransactions){
            if (miTypeTransactions===0){
                return;
            }
            // alert("BuscaTypeTransactions - miSupplier -> " + miTypeTransactions);
            $('#typeTransactions').each( function(index, element){
                // alert ("BuscaTypeTransactions -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miTypeTransactions.toString()){
                        // alert('BuscaTypeTransactions - encontro');
                        $("#typeTransactions option[value="+ miTypeTransactions +"]").attr("selected",true);
                    }
                    // alert("BuscaTypeTransactions aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }

        function BuscaFechas(FechaDesde = 0,FechaHasta = 0){

            myLocation  = window.location.toString();

            // alert('myLocation -> ' + myLocation);
            // obtener fecha inicio
            // alert('ggggg ' + $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD'));

            myArray     = myLocation.split("/");
            if (myArray.length > 4){
                FechaDesde = myArray[8];
                FechaHasta = myArray[9];
            }else{
                FechaDesde = 0;
                FechaHasta = 0;       
            }

            if (FechaDesde == 0) return;


            let myFechaDesde, myFechaHasta, myFecha;

            myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
            myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

            myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();

            // $('#drCustomRanges').val(myFecha);
            // alert(' Mi Fecha desde -> ' + myFechaDesde);
            // alert('gggggsssss ' + $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD'));

            $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
            $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);

        }

    </script>
@endsection
