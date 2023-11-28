@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

@php


$myClass = new app\Http\Controllers\statisticsController;

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
    "showDropdowns:" => "true",
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

// dd($wallet);


$myCantGeneral                  = 0;
$totalComisionGeneral           = 0;
$totalComisionBaseGeneral       = 0;
$totalComisionExchangeGeneral   = 0;
$totalComisionGananciaGeneral   = 0;
$totalComisionGanancia2General  = 0;

$entradaCant    = 0;
$entradaMonto   = 0;

$salidaCant     = 0;
$salidaMonto    = 0;

@endphp
<style>
    .myTr {
        cursor: pointer;
    }
    .myTr:hover{
        background-color: #D7DBDD  !important;
    }
    .myTdColorBlack{
            width:1%;
            background-color: black;
            color: white;
    }
    .myTdColor2{
            width:1%;
            background-color: silver !important;
            color: black !important;
    }
    .myTdColor3{
            width:1%;
            background-color: gray !important;
            color: white !important;
    }
    .myTdColor4{
        font-weight: bold !important;
        color: green !important;
    }
    .myTdColor5 {
        width:1%;
        background-color: #2874A6  !important;
        color: white !important;          
    }
    .myTdColor6 {
        width:1%;
        background-color: #BB8FCE   !important;
        color: white !important;          
    }
    .myTdHighlight {
        font-weight: 800;
        color: green !important;          
    }    
    .myWidth {
        width: 10rem;
        min-width: 10rem;
        max-width: 10rem;
    }
</style>

<!-- <div class="container justify-content-center" style="display: contents;"> -->
<div class="container justify-content-center">

    <div class="row col-12 col-md-12 justify-content-center text-center align-items-center" style="min-height: 5rem !important">
        <h4>Historicos de cambios por transaccion</h4>
    </div>


    <div class="row col-12 col-md-12">

            <style>
                .myTr {
                    cursor: pointer;
                }
                .myTr:hover{
                    background-color: #D7DBDD  !important;
                }
                .myTable th {
                    width: 20% !important;
                    min-wdth: 20% !important;
                    max-wdth: 20% !important;
                    background-color: orange !important;
                }
                .myWidth2{
                    width: 12%;
                    min-width: 12%;
                    max-width: 12%;
                }
            </style>

            {{-- dd($balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}
  
            <div class ="row mb-4" style="background-color: white;" data-wallet="">
                <div class="col-12 text-center">
                    <h3>Entradas USDT</h3>
                </div>            
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th class=""          style="width: 25% !important;">ID</th>
                                <th class="myWidth2"                                >Fecha</th>                                
                                <th class="myWidth2"                                >Usuario</th>
                                <th class="myWidth2"                                >Accion</th>
                                <th class="myWidth2"                                >Dastos</th>
                            </tr>
                        </thead>

                        @foreach($audits as $myAudit)
                            <tr class="myTr">
                                <td>{{ $myAudit->auditable_id}}</td>
                                <td>{{ $myAudit->user->name}}</td>
                                <td>{{ $myAudit->event }}</td>
                                <td>{{ $myAudit->created_at }}</td>
                                <td>
                                    <table>
                                        <tr>
                                            @foreach($value->new_values as  $key => $theValues)
                                                <td>
                                                    {{$key}}
                                                </td>
                                                <td>
                                                    {{$theValues}}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach

                        <tr style="background-color: black; color:white;">
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                        </tr>

                    </table>
                </div>

            </div>

    </div>

</div>

@endsection

@section('js')


<script>
    

    $(() => {


    });
    
    $( document ).ready(function() {

    });
    

    function theRoute(wallet = '', grupo = 0, fechaDesde = '', fechaHasta = ''){

        let myRoute = "";

        myRoute = "{{ route('USDTResumenDiario', ['wallet' => 'wallet2' , 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('grupo2',grupo);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // alert(myRoute);
        location.href = myRoute;

    }


    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){

        if (usuario  === "") usuario  = 0;
        if (grupo  === "") grupo  = 0;
        if (wallet  === "") wallet  = 0;
        if (typeTransactions  === "") typeTransactions  = 0;
        
        fechaDesde = $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD')
        fechaHasta = $('#drCustomRanges').data('daterangepicker').endDate.format('YYYY-MM-DD')

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

</script>

@endsection
