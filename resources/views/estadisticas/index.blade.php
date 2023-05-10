@extends('adminlte::page')
@section('title', 'Estadistica por transacciones')
@section('content')
{{-- Setup data for datatables --}}

@php


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
<h1 class="text-center text-dark font-weight-bold text-uppercase">Detalles de Transacciones <i class="fas fa-chart-pie fa-spin"></i></h1>
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
                                <h4 class="text-uppercase font-weight-bold">Detalles|Movimientos <i class="fas fa-info-circle"></i></h4>
                            </div>
                            <div class="col-md-4">
                                @php
                                    if ($myTotal < 0){
                                        echo "<h4 class='text-uppercase font-weight-bold'>Saldo A favor : " . number_format(abs($myTotal),2,",",".") . "</h4>";
                                    }else{
                                        echo "<h4 class='text-uppercase font-weight-bold'>Saldo A favor : " . number_format(0,2,",",".") . "</h4>";
                                    }
                                @endphp
                            </div>
                            <div class="col-md-4">
                                @php
                                    if ($myTotal < 0){
                                        echo "<h4 class='text-uppercase font-weight-bold'>Saldo Pendiente : " . number_format(0,2,",",".") . "</h4>";
                                    }else{
                                        echo "<h4 class='text-uppercase font-weight-bold'>Saldo Pendiente : " . number_format($myTotal,2,",",".") . "</h4>";
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @php
                            $myTotal = 0;
                        @endphp
                        <table 
                            class="table table-bordered table-responsive-lg" 
                            id="table" 
                            style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%;">Fecha</th>
                                    <th style="width:1%;">Transacción</th>
                                    <th>Descripción</th>
                                    <th style="width:1%;"><p style="display:none;">P - %</p>Moneda</th>
                                    <th style="width:15%;">Monto Moneda <i class="fas fa-globe-europe"></i> <p style="display:none;">Moneda Extranjera</p></th>
                                    <th style="width:1%;">Tasa</th>
                                    <th style="width:10%;">Monto $ <i class="fas fa-funnel-dollar"></i></th>
                                    <th style="width:10%;">%</th>
                                    <th>Comisión</th>
                                    <th>Monto total</th>
                                    <th style="width:1%;">Saldo <i class="fas fa-dolar"></i></th>
                                    <th style="width:1%;">Cliente</th>
                                    <th style="width:1%;">Agente</th>
                                    <th style="width:1%;">Caja <i class="fas fa-wallet"></i></th>
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>
                                </tr>
                            </thead>
                            @foreach($config['data'] as $row)
                                <tr>
                                    <td>{!! $row->FechaTransaccion !!}</td>
                                    <td>{!! $row->TipoTransaccion !!}</td>
                                    <td>{!! $row->Descripcion !!}</td>
                                    <td>{!! $row->TipoMoneda !!}</td>
                                    <td class="text-right">{!! number_format($row->MontoMoneda,2,",",".") !!}</td>
                                    <td class="text-left">{!! $row->TasaCambio !!}</td>
                                    <td class="text-right">{!! number_format($row->Monto,2,",",".") !!}</td>
                                    <td class="text-left">{!! $row->PorcentajeComision !!}</td>
                                    <td class="text-right">{!! number_format($row->MontoComision,2,",",".") !!}</td>
                                    <td class="text-right">{!! number_format($row->MontoTotal,2,",",".") !!}</td>

                                    @php
                                        switch  ($row->TransactionId){
                                            case 1:
                                            case 3:
                                            case 5:
                                            case 7:
                                            case 9:
                                                $myTotal = $myTotal + ($row->MontoTotal * -1);
                                                break;
                                            case 4:
                                            case 8:
                                            case 2:
                                            case 6:
                                                $myTotal = ($myTotal) + ($row->MontoTotal);
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
                exportOptions: { columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13 ] },
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

    const miGrupo   = {!! $myGroup !!};
    const miUsuario = {!! $myUser !!};
    const miWallet  = {!! $myWallet !!};

    // console.log(miCliente);

    // alert('miCLiente -> ' + miCliente);
    // alert('miUser    -> ' + miUsuario);
    // alert('miWallet  -> ' + miWallet);

    BuscaGrupo(miGrupo);
    // BuscaCliente(miCliente);
    BuscaUsuario(miUsuario);
    BuscaWallet(miWallet);

        $(() => {


            $('#userole').on('change', function (){

                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
                const wallet  = $('#wallet').val();
                theRoute(usuario,grupo,wallet);

            });

            $('#group').on('change', function (){

                const usuario = $('#userole').val();

                const grupo   = $('#group').val();
                const wallet = $('#wallet').val();
                const seleccionado = $('#group').prop('selectedIndex');
                // alert('***** cliente ' +  cliente + " --- selected index --- " + seleccionado);

                var URLactual = window.location;
                // alert(URLactual);

                theRoute(usuario,grupo,wallet);


            });

            $('#wallet').on('change', function (){

                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
                const wallet = $('#wallet').val();
                // alert('***** wallet ' +  wallet);
                 theRoute(usuario,grupo,wallet);

             });

            $('#drCustomRanges').on('change', function () {
                alert('Fechas rnagos -> ' + $('#drCustomRanges').val());
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

                alert('Fecha Desde -> ' + myFechaDesde + ' Fecha Hasta -> ' + myFechaHasta);
                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
                const wallet = $('#wallet').val();
                theRoute(usuario,grupo,wallet,myFechaDesde,myFechaHasta);
            });



        })


        function theRoute(usuario = 0, grupo = 0, wallet = 0, fechaDesde = 0, fechaHasta = 0){

            if (usuario === "") usuario = 0;
            if (grupo   === "") grupo = 0;
            if (wallet  === "") wallet  = 0;

            let myRoute = "";
                myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
                myRoute = myRoute.replace('grupo2',grupo);
                myRoute = myRoute.replace('usuario2',usuario);
                myRoute = myRoute.replace('wallet2',wallet);
                myRoute = myRoute.replace('fechaDesde2',fechaDesde);
                myRoute = myRoute.replace('fechaHasta2',fechaHasta);
            console.log(myRoute);
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

    </script>
@endsection
