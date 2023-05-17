@extends('adminlte::page')
@section('title', 'Conciliacion Proveedor')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Supplier',
    'Caja',
    'Transaccion',
    'Cant  Proveedor',
    'Monto Proveedor',
    'Cant  Operaciones',
    'Monto Operaciones',
    'Saldo',    
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
    'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]]
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

<script>


</script>
<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Concilacion por Proveedor') }} <i class="fas fa-users"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12 d-flex">

        <!-- Grupo -->
        
        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="supplier"
                                name="optionsSupplier"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Proveedor ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$suppliers" empty-option="Selecciona un Proveedor.."/>
            </x-adminlte-select2>
        </div>

        <!--
        <div class ="col-12 col-sm-2">
        </div>
        -->

        <!-- Fechas -->
        <!--
        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>



        <div class ="col-12 col-sm-2">
        </div>
        -->

    </div>

</div>


<br>
<br>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">{{ __('Conciliacion| Proveedor') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        


                        <!-- <x-adminlte-datatable id="table3" :heads="$heads" class="table table-bordered table-responsive-lg"> -->
                        <table 
                            class="table table-bordered table-responsive-lg" 
                            id="table" 
                            style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:15%;">Supplier</th>
                                    <th style="width:15%;">Caja</th>
                                    <th style="width:15%;">Transaccion</th>
                                    <th style="width:10%;">Cant Proveedor</th>
                                    <th style="width:10%;">Monto Proveedor</th>
                                    <th style="width:10%;">Cant Operaciones</th>
                                    <th style="width:10%;">Monto Operaciones</th>
                                    <th style="width:10%;">Saldo</th>
                                    <th style="width:1%;" >Proveedor sin Conciliar</th>                                    
                                    <th style="width:1%;" >Operaciones sin conciliar</th>                                         
                                </tr>
                            </thead>                            
                            @php
                                $myTotal = 0;
                            @endphp
                            @foreach($Transacciones as $row)
                                @php
                                    $myTotal = $row->TotalSupplier - $row->MontoWallet;
                                    
                                @endphp
                                <tr>
                                    <td>{!! $row->SupplierName !!}</td>
                                    <td>{!! $row->WalletName !!}</td>
                                    <td>{!! $row->TypeTransactionsName !!}</td>
                                    <td>{!! number_format($row->CantSupplier,0,",",".")  !!}</td>
                                    <td>{!! number_format($row->TotalSupplier,2,",",".") !!}</td>
                                    <td>{!! number_format($row->CantWallet,0,",",".")  !!}</td>
                                    <td>{!! number_format($row->MontoWallet,2,",",".")   !!}</td>

                                    <td>{!! number_format($myTotal,2,",",".") !!}</td>
                                    <!--
                                        supplier_id					as SupplierId,
                                        mtf.suppliers.name          as SupplierName,
                                        wallet_id					as WalletId,
                                        mtf.wallets.name			as WalletName,
                                        type_transaction_id 		as TypeTransactionId,
                                        mtf.type_transactions.name 	as TypeTransactionsName,
                                        count(supplier_id)			as CantSupplier,
                                        sum(amount_total) 			as TotalSupplier,
                                    -->
                                    <td class="text-center">
                                        <a href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{$row->SupplierId}},{{$row->WalletId}},{{$row->TypeTransactionId}})">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>                                        
                                    </td>

                                    <td class="text-center">
                                        <a href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute3({{$row->SupplierId}},{{$row->WalletId}},{{$row->TypeTransactionId}})">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>                                        
                                    </td>                                    
                                </tr>
                            @endforeach
                        <!-- </x-adminlte-datatable> -->
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

    const miProveedor = {!! $mySupplier !!};

    BuscaProveedor(miProveedor);

    $(() => {


        $('#supplier').on('change', function (){
            const proveedor = $('#supplier').val();
            theRoute(proveedor);
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
            const proveedor = $('#supplier').val();
            theRoute(proveedor);
        });

    })

    function theRoute(proveedor = 0, fechaDesde = 0, fechaHasta = 0){

        if (proveedor   === "") proveedor  = 0;

        let myRoute = "";
            myRoute = "{{ route('estadisticasResumenConciliacionProveedor', ['proveedor' => 'proveedor2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }

    function theRoute2(proveedor = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0 ){

        if (proveedor   === "")         proveedor           = 0;
        if (wallet === "")              wallet              = 0;
        if (typeTransactions === "")    typeTransactions    = 0;

        /*
        Route::get('estadisticasDetalleProveedorCon/{supplier?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}',
            [App\Http\Controllers\statisticsController::class, 'supplierDetailConciliation'])
        ->middleware('can:estadisticasDetalle.index')
        ->name('estadisticasDetalleProveedorCon');   
        */

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalleProveedorCon', ['supplier' => 'proveedor2',  'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }

    function theRoute3(proveedor = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0 ){

        if (proveedor   === "")         proveedor           = 0;
        if (wallet === "")              wallet              = 0;
        if (typeTransactions === "")    typeTransactions    = 0;

        let myRoute = "";
            //                 Route::get('estadisticasDetalleProveedorTran/{supplier?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}',        
            myRoute = "{{ route('estadisticasDetalleProveedorTran', ['supplier' => 'proveedor2',  'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }

    /*
    *
    *
    *       BuscaProveedor
    * 
    * 
    */
    function BuscaProveedor(miProveedor){
        // alert("BuscaProveedor - miProveedor -> " + miProveedor);
        $('#supplier').each( function(index, element){
            //alert ("BuscaProveedor -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miProveedor.toString()){
                    //alert('Buscaproveedor - encontro');
                    $("#supplier option[value="+ miProveedor +"]").attr("selected",true);
                }
                //alert("BuscaProveedoraqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

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
                    exportOptions: { columns: [ 0, 1, 2, 3,4,5,6,7] },
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
                    title: 'MTF | CONCILIACION PROVEEDOR',
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


    function BuscaFechas(FechaDesde = 0,FechaHasta = 0){

        myLocation  = window.location.toString();
        myArray     = myLocation.split("/");
        if (myArray.length > 3){
            FechaDesde = myArray[7];
            FechaHasta = myArray[8];
            // alert('recibe las fechas : fecha desde 33 -> ' +   myArray[7] + ' fecha Hasta 33 -> ' +   myArray[8]);
        }else{
            FechaDesde = 0;
            FechaHasta = 0;       
        }

        if (FechaDesde == 0) return;

        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();
        // alert('myFecha -> ' + myFecha );
        $('#drCustomRanges').val(myFecha);

    }

</script>

@endsection
