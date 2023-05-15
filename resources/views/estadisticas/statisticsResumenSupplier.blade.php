@extends('adminlte::page')
@section('title', 'Estadisticas por Grupo')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    ['label' => 'Proveedor', 'no-export' => true, 'width' => 15],
    ['label' => 'Monto total', 'no-export' => true, 'width' => 15],
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

<script>


</script>
<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">Resumen de Movimiento por Proveedor <i class="fas fa-users"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container">
    <div class="row col-12 d-flex justify-content-center">
        <!-- Grupo -->
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
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$suppliers" empty-option="Selecciona un Proveedor.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>
        <!-- Fechas -->
        <!--
        <div class ="col-12 col-sm-3">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
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
<!-- <x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable> -->

{{-- Compressed with style options / fill data using the plugin config --}}
<!-- <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
    striped hoverable bordered compressed/> -->

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Estadisticas| Resumen por Proveedor</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-datatable 
                            id="table3" 
                            :heads="$heads" 
                            class="table table-bordered table-responsive-lg"
                            striped
                            hoverable
                            with-buttons                        
                        >
                            @foreach($Transacciones as $row)

                                <!-- \
                                [IdGrupo] => 3
                                [NombreGrupo] => Cobranzas de boletos
                                [Creditos] => 1567619
                                [Debitos] => 1384688.5
                                [Total] => 182930.5 
                                -->
                                 
                                <tr>
                                    <td>{!! $row->NombreSupplier !!}</td>

                                    <td>{!! number_format($row->Total,2,",",".") !!}</td>

                                    <td class="text-center">
                                        <a      
                                            href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute({{$row->IdSupplier}})"
                                        >
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


    const miSupplier = {!! $mySupplier !!};
    
    BuscaProveedor(miSupplier);

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
            theRoute(proveedor,myFechaDesde,myFechaHasta);
        });

    })
    /*
    *
    *
    *       theRoute
    * 
    * 
    */
    function theRoute(proveedor = 0, wallet = 0, type_transactions = 0, fechaDesde = 0, fechaHasta = 0){
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
