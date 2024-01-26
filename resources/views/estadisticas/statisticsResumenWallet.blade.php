@extends('adminlte::page')
@section('title', 'Estadistica por cajas')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Wallet',
    'Cant',    
    'Monto',    
    'Comision',
    'Comision Base',
    'Ganancia comision',
    'Monto Creditos',
    'Monto Debitos',
    'Saldo Total',
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
    'columns' => [null, null, null, null, ['orderable' => false]]
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
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Resumen de Movimiento por Caja') }} <i class="fas fa-w fa-box"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12 d-flex">

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="wallet"
                                name="optionsCliente"
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

                <x-adminlte-options :options="$wallets" empty-option="Selecciona un Wallet.."/>
            </x-adminlte-select2>
        </div>


        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>

        <div class ="col-sm-3">
            <x-adminlte-select2 id="coin"
                                name="optionsCoin"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="MonedaGrupo ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <!-- <i class="fas fa-user-tie"></i> -->
                        <i class="fas fa-solid fa-dollar-sign"></i>                        
                    </div>
                    
                </x-slot>

                <x-adminlte-options :options="$Type_coin_balance" empty-option="Selecciona una moneda.."/>

            </x-adminlte-select2>
        </div>

    </div>

</div>


<br>
<br>



<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Estadisticas| Resumen por Caja') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-datatable id="table3" :heads="$heads" class="table table-bordered table-responsive-lg">
                            @foreach($Transacciones as $row)
                                <tr>
                                    <td>{!! $row->NombreWallet !!}</td>
                                    <td>{!! number_format($row->Cant) !!}</td>
                                    <td>{!! number_format($row->Monto,2) !!}</td>
                                    <td class="text-right">{!! number_format($row->Comision,2,",",".") !!}</td>
                                    <td class="text-right">{!! number_format($row->ComisionBase,2,",",".") !!}</td>
                                    <td class="text-right">{!! number_format($row->ComisionGanancia,2,",",".") !!}</td>

                                    <td class="text-right">{!! number_format($row->Creditos,2,",",".") !!}</td>
                                    <td class="text-right">{!! number_format($row->Debitos,2,",",".") !!}</td>
                                    <td class="text-right">{!! number_format($row->Total,2,",",".") !!}</td>

                                    <!-- <td class="text-center">
                                        <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </button>
                                    </td> -->
                                    <td class="text-center">
                                        <a
                                            href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{0}}, {{0}}, {{$row->IdWallet}})"
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


    const miWallet = {!! $myWallet !!};
    const myTypeCoinBalance = {!! $myTypeCoinBalance !!};

    BuscaWallet(miWallet);
    BuscaMoneda(myTypeCoinBalance);

    $(() => {

        InicializaFechas();
        BuscaFechas();

        $('#wallet').on('change', function (){

            const wallet = $('#wallet').val();
            const coin      = $('#coin').val();

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

            theRoute(wallet,myFechaDesde,myFechaHasta,coin);

        }).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
        });        
        

        $('#drCustomRanges').on('change', function () {

            const wallet = $('#wallet').val();
            const coin      = $('#coin').val();

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

            
            theRoute(wallet,myFechaDesde,myFechaHasta,coin);
        });


        $('#coin').on('change', function (){

            const wallet    = $('#wallet').val();
            const coin      = ($('#coin').val()) ? $('#coin').val() : 1;

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

            theRoute(wallet,myFechaDesde,myFechaHasta,coin);

        }
        ).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
        });

    })

    function theRoute(wallet = 0, fechaDesde = 0, fechaHasta = 0, coin = 1){

        if (wallet  === "") wallet  = 0;

        let myRoute = "";
            myRoute = "{{ route('estadisticasResumenWallet', ['wallet' => 'wallet2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'coin' => 'coin2']) }}";
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
            myRoute = myRoute.replace('coin2',coin);
            myRoute = myRoute.replaceAll('amp;','');
        // console.log(myRoute);
         // alert(myRoute);
        location.href = myRoute;

    }

    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0){

        if (usuario === "") usuario = 0;
        if (grupo   === "") grupo = 0;
        if (wallet  === "") wallet  = 0;

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

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);            
            myRoute = myRoute.replace('fechaDesde2',myFechaDesde);
            myRoute = myRoute.replace('fechaHasta2',myFechaHasta);
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


    function BuscaFechas(FechaDesde = 0, FechaHasta = 0){

        myLocation  = window.location.toString();

        myArray     = myLocation.split("/");

        if (myArray.length > 4){
            FechaDesde = myArray[5];
            FechaHasta = myArray[6];
        }else{
            FechaDesde = 0;
            FechaHasta = 0;       
        }

        // alert("fecha desde -> " + FechaDesde + " Fecha hasta -> " + FechaHasta);

        if (FechaDesde == 0) return;


        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);

    }


    function BuscaMoneda(myTypeCoinBalance){
        //alert("BuscaGrupo - miGrupo -> " + miGrupo);
        $('#coin').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myTypeCoinBalance.toString()){
                    //alert('Buscagrupo - encontro');
                    $("#coin option[value="+ myTypeCoinBalance +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function InicializaFechas(){
        $('#drCustomRanges').data('daterangepicker').setStartDate('01-01-2001');

    }

</script>

@endsection
