@extends('adminlte::page')
@section('title', 'Estadisticas por Grupo')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    ['label' => 'Grupo',        'no-export' => true, 'width' => 15],
    ['label' => 'Monto total',  'no-export' => true, 'width' => 15],
    ['label' => 'Actions',      'no-export' => true, 'width' => 5],
];

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        [22, '07-03-2023', 'John Bender',    '4,00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, '07-03-2023', 'Sophia Clemens', '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3,  '07-03-2023', 'Peter Sousa',    '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null,  ['orderable' => false]]
];


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
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

@endphp

<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Resumen de Movimiento por Grupo') }} <i class="fas fa-users"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container">
    <div class="row col-12">


        <!-- Wallet -->

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="wallet"
                                name="optionsWallet"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Wallet ..."
                                :config="$config1"
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

        <!-- Transaction -->

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="transaccion"
                                name="optionsTransaccion"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Transaccion ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$Type_transactions" empty-option="Selecciona una Transaccion .."/>
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
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Estadisticas| Resumen por Grupo') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:10%;">Caja</th>
                                    <th style="width:10%;">Transaccion</th>
                                    <th style="width:10%;">Cant</th>
                                    <th style="width:10%;">Monto</th>                                    
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>
                                </tr>
                            </thead>
                            @foreach($Transacciones as $row)

                                <tr>
                                    <td>{!! $row->WalletName !!}</td>
                                    <td>{!! $row->TypeTransaccionName !!}</td>                                    
                                    <td>{!! number_format($row->cant_transactions,2,",",".") !!}</td>                                    
                                    <td>{!! number_format($row->total_amount,2,",",".") !!}</td>
                                    <td class="text-center">
                                        <a href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{0}},{{$row->IdGrupo}})">
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

<script>
$(document).ready(function () {
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
    "order": [[ 2, 'desc' ]],
    'dom' : 'Bfrtilp',
    'buttons':[
        {
            extend:  'excelHtml5',
            exportOptions: { columns: [ 0, 1 ] },
            text:    '<i class="fas fa-file-excel"></i>',
            titleAttr: 'Exportar Excel',
            className: 'btn btn-success',
            "excelStyles": [
            {
                "template": ["title_medium", "gold_medium"]
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
            "cells": "sF",
            "condition": {
                "type": "dataBar",
                "dataBar": {
                    "color": [
                        "0081B4"
                    ]
                }
              }
            },
             {
                "cells": "sE",
            "condition": {
                "type": "dataBar",
                "dataBar": {
                    "color": [
                        "0081B4"
                    ]
                  }
                 }
              },
                {
                    'cells': "sB",
                    'template': "date_long",
                },
                {
                    "cells": "F",
                    "style": {
                        "numFmt": "#,##0;(#,##0)"
                    }
                }
           ]

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
});

    const miWallet = {!! $myWallet !!};

    BuscaWallet(miWallet);

    const miTypeTransaction= {!! $myTypeTransaction !!};

    BuscaTransaccion(miTypeTransaction);

    $(() => {


        $('#wallet').on('change', function (){

            const wallet        = $('#wallet').val();
            const transaccion   = $('#transaccion').val();
            theRoute(wallet, transaccion);

        });

        $('#transaccion').on('change', function (){

            const wallet        = $('#wallet').val();
            const transaccion   = $('#transaccion').val();
            theRoute(wallet, transaccion);

        });

        $('#drCustomRanges').on('change', function () {
            // alert('ggggg ' + $('#drCustomRanges').val());
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

            //alert('Fecha Desde ' + myFechaDesde + 'Fecha Hasta ' + myFechaHasta);
            const usuario = $('#userole').val();
            const cliente = $('#cliente').val();
            const wallet = $('#wallet').val();
            theRoute(usuario,cliente,wallet,myFechaDesde,myFechaHasta);
        });

    })

    function theRoute(wallet = 0, transaction = 0, fechaDesde = 0, fechaHasta = 0){

        if (wallet   === "") wallet  = 0;
        if (transaction   === "") transaction  = 0;

        let myRoute = "";

            myRoute = "{{ route('estadisticasResumenGrupoTran', ['wallet' => 'wallet2', 'transaction' => 'transaction2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('transaction2',transaction);            
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }


    function theRoute2(wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){


        if (wallet  === "") wallet  = 0;
        if (typeTransactions  === "") typeTransactions  = 0;

        //                      'estadisticasDetalle/{usuario}/{grupo?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}'
        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);            
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

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
    }

    function BuscaTransaccion(miTypeTransaction){
        if (miTypeTransaction===0){
            return;
        }
        // alert("BuscaWallet - miWallet -> " + miWallet);
        $('#transaccion').each( function(index, element){
            // alert ("BuscaWallet -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miTypeTransaction.toString()){
                    // alert('BuscaWallet - encontro');
                    $("#transaccion option[value="+ miTypeTransaction +"]").attr("selected",true);
                }
                // alert("BuscaWallet aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
    }

    $('#table3').DataTable({
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
        "order": [[ 2, 'desc' ]],
        'dom' : 'Bfrtilp',
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [ 0, 1] },
                text:    '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',
                "excelStyles": [
                    {
                        "template": ["title_medium", "gold_medium"]
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
                        "cells": "sF",
                        "condition": {
                            "type": "dataBar",
                            "dataBar": {
                                "color": [
                                    "0081B4"
                                ]
                            }
                        }
                    },
                    {
                        "cells": "sE",
                        "condition": {
                        "type": "dataBar",
                        "dataBar": {
                            "color": [
                                "0081B4"
                            ]
                        }
                        }
                    },
                    {
                        'cells': "sB",
                        'template': "date_long",
                    },
                    {
                        "cells": "F",
                        "style": {
                            "numFmt": "#,##0;(#,##0)"
                        }
                    }
                ]
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

</script>

@endsection
