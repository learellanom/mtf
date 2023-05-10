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
                        <x-adminlte-datatable id="table3" :heads="$heads" class="table table-bordered table-responsive-lg">
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
                                    <td>{!! number_format($row->CantSupplier,0,",",".") !!}</td>
                                    <td>{!! number_format($row->TotalSupplier,2,",",".") !!}</td>
                                    <td>{!! $row->CantWallet!!}</td>
                                    <td>{!! number_format($row->MontoWallet,2,",",".") !!}</td>

                                    <td>{!! number_format($myTotal,2,",",".") !!}</td>

                                    <td class="text-center">
                                        <a href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{$row->SupplierId}})">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>                                        
                                    </td>
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

    function theRoute2(proveedor = 0, fechaDesde = 0, fechaHasta = 0 ){

        if (proveedor   === "") proveedor = 0;

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalleProveedor', ['supplier' => 'proveedor2',  'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('proveedor2',proveedor);
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


</script>

@endsection
