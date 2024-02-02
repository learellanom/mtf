@extends('adminlte::page')
@section('title', 'Estadisticas por agentes')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Transaccion',
    'Cant',
    'Monto transacciones',
    'Monto comision',
    'Monto total',
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
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false]]
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
<h1 class="text-center text-dark font-weight-bold">Resumen de Movimiento por Transacción Proveedor</h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12">

        <!--
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
                        
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$Type_transactions" empty-option="Selecciona una Transaccion .."/>
            </x-adminlte-select2>
        </div>
        -->

        <div class ="col-12 col-sm-3">
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

                <x-adminlte-options :options="$supplier" empty-option="Selecciona un Proveedor.."/>
            </x-adminlte-select2>
        </div>

        <!--
        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>
        -->

        <div class ="col-12 col-sm-2">
        </div>

    </div>

</div>


<br>
<br>


{{-- Minimal example / fill data using the component slot --}}


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Estadisticas| Resumen por Transacción</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-datatable id="table3" :heads="$heads" class="table table-bordered table-responsive-lg">
                            @foreach($Transacciones as $row)
                                <tr>
                                    <td>{!! $row->TipoTransaccion !!}</td>
                                    <td>{!! $row->cant_transactions !!}</td>
                                    <td>{!! $row->total_amount !!}</td>
                                    <td>{!! $row->total_commission !!}</td>
                                    <td>{!! $row->total !!}</td>



                                    <td class="text-center">
                                        <a      
                                            href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{$row->IdSupplier}})"
                                        >
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>

                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>



    const miSupplier = {!! $mySupplier !!};
    
    BuscaProveedor(miSupplier);

    $(() => {

        $('#supplier').on('change', function (){

            const proveedor = $('#supplier').val();
            theRoute(proveedor);

        });
        
        $('#transaccion').on('change', function (){

            const usuario = $('#userole').val();
            const cliente = $('#cliente').val();
            const wallet = $('#wallet').val();
            const transaccion = $('#transaccion').val();
            theRoute(transaccion, usuario,cliente,wallet);

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
            const transaccion = 0;
            theRoute(transaccion,usuario,cliente,wallet,myFechaDesde,myFechaHasta);
        });


    })

    function theRoute(proveedor = 0, fechaDesde = 0, fechaHasta = 0){
        // alert(' el proveedor -> ' + proveedor)
        if (proveedor   === "") proveedor  = 0;

        let myRoute = "";
        myRoute = "{{ route('estadisticasResumenProveedorTransaccion', ['proveedor' => 'proveedor2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        
        location.href = myRoute;

    }

    function theRoute3(proveedor = 0, fechaDesde = 0, fechaHasta = 0){
        // alert(' el proveedor -> ' + proveedor)
        if (proveedor   === "") proveedor  = 0;

        let myRoute = "";
        myRoute = "{{ route('estadisticasDetalleProveedor', ['supplier' => 'proveedor2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        
        location.href = myRoute;

    }

    function theRoute2(proveedor = 0, wallet = 0, type_transactions = 0, fechaDesde = 0, fechaHasta = 0){
        // alert(' el proveedor -> ' + proveedor)
        if (proveedor   === "") proveedor  = 0;

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalleProveedor', ['supplier' => 'proveedor2','wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',type_transactions);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        location.href = myRoute;

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


</script>

@endsection
