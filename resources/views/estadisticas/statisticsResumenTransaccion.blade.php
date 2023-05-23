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
<h1 class="text-center text-dark font-weight-bold">Resumen Grupo Transaccion</h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12">

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

        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
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
                                        <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </button>
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

// return view('estadisticas.statisticsResumenTransaction', compact('myTypeTransaction', 'Type_transactions', 'Transacciones'));

    const miTypeTransaction= {!! $myTypeTransaction !!};

    BuscaTransaccion(miTypeTransaction);

    $(() => {


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

    function theRoute(transaccion = 0, usuario = 0, cliente = 0, wallet = 0, fechaDesde = 0, fechaHasta = 0){

        if (usuario === "")      usuario = 0;
        if (cliente === "")      cliente = 0;
        if (wallet  === "")      wallet  = 0;
        if (transaccion  === "") transaccion  = 0;

        let myRoute = "";
            myRoute = "{{ route('estadisticasResumenTransaccion', ['type_transaction' => 'transaccion2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('transaccion2',transaccion);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
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

</script>

@endsection
