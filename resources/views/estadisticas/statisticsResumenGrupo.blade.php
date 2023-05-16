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
        <!-- Grupo -->
        <div class ="col-12 col-sm-4">
            <x-adminlte-select2 id="grupo"
                                name="optionsGroup"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Grupo ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$groups" empty-option="Selecciona un Grupo.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
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
                                    <th style="width:10%;">Cliente</th>
                                    <th style="width:10%;">Monto total</th>
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>

                                </tr>
                            </thead>

                                @foreach($Transacciones as $row)

                                <tr>
                                    <td>{!! $row->NombreGrupo !!}</td>
                                    <td>{!! number_format($row->Total,2,",",".") !!}</td>
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


    const miGrupo = {!! $myGroup !!};

    BuscaGrupo(miGrupo);

    $(() => {


        $('#grupo').on('change', function (){

            const usuario = $('#userole').val();
            const cliente = $('#cliente').val();
            const wallet = $('#wallet').val();
            const grupo = $('#grupo').val();
            theRoute(grupo,cliente,wallet);

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

    function theRoute(grupo = 0, cliente = 0, wallet = 0, fechaDesde = 0, fechaHasta = 0){

        if (grupo   === "") grupo  = 0;

        let myRoute = "";

            myRoute = "{{ route('estadisticasResumenGrupo', ['grupo' => 'grupo2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }


    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){


        if (grupo   === "") grupo = 0;
        if (wallet  === "") wallet  = 0;
        //                      'estadisticasDetalle/{usuario}/{grupo?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}'
        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);            
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

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

    function BuscaCliente(miCliente){
        //alert("BuscaCliente - miCliente -> " + miCliente);
        $('#cliente').each( function(index, element){
            //alert ("Buscacliente -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miCliente.toString()){
                    //alert('BUscaCliente - encontro');
                    $("#cliente option[value="+ miCliente +"]").attr("selected",true);
                }
                //alert("BuscaClienteaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function BuscaGrupo(miGrupo){
        //alert("BuscaGrupo - miGrupo -> " + miGrupo);
        $('#grupo').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miGrupo.toString()){
                    //alert('Buscagrupo - encontro');
                    $("#grupo option[value="+ miGrupo +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
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
