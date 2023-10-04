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
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

// dd($wallet);

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
</style>

<div class="container">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-3">
                    <x-adminlte-select2 id="wallet"
                    name="optionsWallets"
                    
                    label-class="text-lightblue"
                    data-placeholder="Seleccione una caja"

                    :config="$config4"
                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-light">
                            <i class="fas fa-box"></i>
                        </div>
                    </x-slot>
                    <x-adminlte-options :options="$wallet" empty-option="Wallet.."/>
                    </x-adminlte-select2>
                </div>
                <div class="col col-md-3">
                    <x-adminlte-select2 id="typeTransactions"
                    name="optionstypeTransactions"
                    
                    label-class="text-lightblue"
                    data-placeholder="Tipo de transacción"

                    :config="$config2"
                    >
                    <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-light">
                    <i class="fas fa-exchange-alt"></i>
                    </div>
                    </x-slot>

                    <x-adminlte-options :options="$typeTransactions" empty-option="Selecciona Transaccion.."/>
                    </x-adminlte-select2>
                </div>

                <div class ="col-12 col-md-3">
                    <x-adminlte-date-range
                        name="drCustomRanges"
                        enable-default-ranges="Last 30 Days"
                        
                        :config="$config3">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-light">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>


                </div>
                <div class ="col-12 col-md-3">
                    <a class="btn btn-primary imprimir"><i class="fas fa-print"></i></a>
                    <a class="btn btn-success"  onclick="exportaEstadisticas();"><i class="fas fa-file-excel"></i></a>
                    <a class="btn btn-danger"   onclick="exportaEstadisticasPDF();"><i class="fas fa-file-pdf"></i></a>
                    {{-- <a class="btn btn-success" href={{route('exports.excel', [$myWallet, $myFechaDesde, $myFechaHasta])}}><i class="fas fa-file-excel"></i></a> --}}
                </div>

            </div>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">

            <button 
                class="nav-link active" 
                id="nav-home-tab" 
                data-toggle="tab" 
                data-target="#nav-home" 
                type="button" 
                role="tab" 
                aria-controls="nav-home" 
                aria-selected="true">
                Estadistica
            </button>

            <button 
                class="nav-link" 
                id="nav-profile-tab" 
                data-toggle="tab" 
                data-target="#nav-profile" 
                type="button" 
                role="tab" 
                aria-controls="nav-profile"             
                aria-selected="false">
                Filtros
            </button>

        </div>
    </nav>

    <br>
    <br>


    <div class="tab-content" id="nav-tabContent">

        {{-- Estadisticas --}}

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div id="myCanvasGeneral"></div>

            <div id="myCanvas"></div>

        </div>

        {{-- Filtros --}}

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Filtros

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros  Generales</h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <label for="ResumenGeneral">Ocultar Resumen General:</label>
                            <input type="checkbox" id="ResumenGeneral" name="ResumenGeneral"><br><br>
                        </div>  

                    </div>     


                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <label for="ResumenTransaccion">Ocultar Resumen Transaccion:</label>
                            <input type="checkbox" id="ResumenTransaccion" name="ResumenTransaccion"><br><br>
                        </div>  

                    </div>   


                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar2" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar2" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Transacciones</h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <select multiple="multiple" id="my-select" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     
                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
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

    BuscaWallet(miWallet);

    const miTypeTransaction= {!! $myTypeTransaction !!};

    BuscaTransaccion(miTypeTransaction);

    @php

        
        $myData                         = $myClass->filtrosLeeComisiones();

        $myocultarresumengeneral        = $myData['ocultarresumengeneral'];
        $myocultarresumentransaccion    = $myData['ocultarresumentransaccion'];
        $mytransactions                 = $myData['transactions'];
        // dd($myData);
        
        $myocultarresumengeneral        = (!$myocultarresumengeneral)       ? 0 : $myocultarresumengeneral;
        $myocultarresumentransaccion    = (!$myocultarresumentransaccion)   ? 0 : $myocultarresumentransaccion;

        // dd(' myocultarresumengeneral -> ' . $myocultarresumengeneral . ' myocultarresumentransaccion -> ' . $myocultarresumentransaccion . ' mytransactions -> ' . print_r($mytransactions,true) );
        // dd(json_encode($myocultarresumentransaccion));
        //dd(json_encode($myocultarresumengeneral));
        //dd(json_encode($mytransactions));

    @endphp


    $(() => {

            // Valida y esconde

        let text        = window.location.href;
        const myArray   = text.split("/");
        const myLength  = myArray.length;

        if (window.location.href.indexOf("?") === -1) {
            $('.esconder').show();
        } else {
            $('.esconder').hide();
        }

        let     myFechaDesde = {!! $myFechaDesde !!};
        // console.log({!! $myFechaDesde !!});
        const   myFechaHasta = {!! $myFechaHasta !!};

        // alert('Fechas -> desde -> ' + myFechaDesde);

        InicializaFechas();

        BuscaFechas(myFechaDesde, myFechaHasta);

        $('#wallet').on('change', function (){

            const wallet        = $('#wallet').val();
            const transaccion   = $('#typeTransactions').val();
            
             theRoute(wallet, transaccion);

        });

        $('#typeTransactions').on('change', function (){

            const wallet        = $('#wallet').val();
            const transaccion   = $('#typeTransactions').val();

            theRoute(wallet, transaccion);

        });

        $('#drCustomRanges').on('change', function () {

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

                const wallet        = $('#wallet').val();
                const transaccion   = $('#typeTransactions').val();
                theRoute(wallet, transaccion, myFechaDesde,myFechaHasta);

        });

        $('#my-select').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles 
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>
                                </div>`
        });

        cargaTransacciones();


        if (!miWallet){
            // alert ('aqui');
            calculoGeneral3();
            calculos3();
        }else{
            calculoGeneral2();
            calculos2();
        }
        
        leeFiltros();  
        aplicaFiltros();      

        $('#myButtonLimpiar2').on('click', function (){

            // alert('El canvas general ->' + $('#ResumenGeneral').prop('checked'));
            // alert('El canvas general ->' + $('#ResumenGeneral').attr('checked'));
            // alert('El canvas general ->' + $('#ResumenGeneral').is(':checked'));

            $('#ResumenGeneral').prop("checked",false);
            $('#ResumenTransaccion').prop("checked",false);

        });

        $('#myButtonAplicar2').on('click', function (){
            
            $('#myCanvasGeneral').attr("hidden",false);
            $('#myCanvas').attr("hidden",false);

            if( $('#ResumenGeneral').is(':checked') ) {
                $('#myCanvasGeneral').attr("hidden",true);
                
            }

            if( $('#ResumenTransaccion').is(':checked') ) {
                $('#myCanvas').attr("hidden",true);
            }

            grabaFiltros();

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Filtro aplicado satisfactoriamente',
                showConfirmButton: false,
                timer: 1500
                });             

        });



        $('#myButtonLimpiar').on('click', function (){

            $('#my-select').multiSelect('deselect_all');


        });

        $('#myButtonAplicar').on('click', function (){
            // alert('aqui');
            $("#myCanvas div").each(function(){
                $(this).removeAttr("hidden");
            });

            $("#my-select option:selected").each(function(){
                
                seleccionado = $(this).attr('value');

                $("#myCanvas div").each(function(){
                    if($(this).data("id")){
                                                
                        if ($(this).data("id") == seleccionado){
                            
                            $(this).attr("hidden",true);
                        }
                    }
                });


            });
            
             grabaFiltros();
            
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Filtro aplicado satisfactoriamente',
                showConfirmButton: false,
                timer: 1500
                });             
            
        });

    });

    $( document ).ready(function() {

    });
    //
    // calculos - transaction sumarry general
    //
    function calculos3(){

        let ctx3, myId, myobj, myChart3, ctx4, myChart4;

        @foreach($transaction_summary as $wallet)

            myId                = "{{$wallet->TypeTransactionId }}";
            myobj               = document.getElementById(myId);
            theWallet           = {!! $myWallet !!};
            theTypeTransaction  = {!! $myTypeTransaction !!};
            myIndMuestra        = 1;

            // alert('$wallet->TypeTransactionId' + "{{$wallet->TypeTransactionId }}" + " myId-> " + myId + " myobj-> " + myobj + " thewallet -> " + theWallet + " theTypeTransaction -> " + theTypeTransaction);

            if (theTypeTransaction){
                if (theTypeTransaction != 0){
                    if (myId != theTypeTransaction){
                            myIndMuestra = 0;
                        }
                }
            }

            if (myIndMuestra == 1){


                let myElement;

                myElement = `
                    <div class="row " data-id="{{$wallet->TypeTransactionId}}">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center text-uppercase font-weight-bold">{{ $wallet->TypeTransaccionName }}</h3>
                                    <canvas id=M{{ $wallet->TypeTransactionId }}></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center text-uppercase font-weight-bold">{{ $wallet->TypeTransaccionName }}</h3>
                                    <canvas id=M{{ $wallet->TypeTransactionId. 'A' }}></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                `;


                $("#myCanvas").append(myElement);




                ctx3 = document.getElementById("M" + myId);

                myChart3 = new Chart(ctx3, {
                    type: 'doughnut',
                    data : {
                        labels: [
                            "{{$wallet->TypeTransaccionName }}",
                        ],
                        datasets: [
                            {
                            label: 'Otras transacciónes',
                            data: [
                                @foreach($transaction_summary as $wallet2)
                                    {{$wallet2->cant_transactions. ',' }}
                                @endforeach],
                            backgroundColor:[
                                @foreach($transaction_summary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        'rgb(0, 173, 181)',
                                    @else
                                        'rgb(203, 203, 203)',
                                    @endif
                                @endforeach],
                            hoverOffset: 6
                        }]
                    },

                });


                let myLabel             = [];
                let myData              = [];
                let myBackGroudColor    = [];
                let myBorderColor       = [];


                @foreach($wallet_groupsummary as $wallet2)

                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId )

                            // alert('Aqui -> ' + "{{$wallet2->GroupName}}" + " total amount -> " + "{{$wallet2->total_amount}}");

                            myLabel.push("{{$wallet2->GroupName ?? $wallet2->WalletName }}");
                            myData.push({{$wallet2->total_amount . ',' }});
                            myBackGroudColor.push('rgb(0, 173, 181)');
                            myBorderColor.push('rgb(0, 173, 181)');

                        @endif

                @endforeach

                ctx4 = document.getElementById(
                    "M{{$wallet->TypeTransactionId. 'A' }}",
                );

                myChart4 = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: myLabel,
                        datasets: [{
                            label: '',
                            data: myData,
                            backgroundColor: myBackGroudColor,
                            borderColor: myBorderColor,
                            borderWidth: 6
                        }]
                    }

                });
                                    

                myElement = `
                    <style>
                        .myTr {
                            cursor: pointer;
                        }
                        .myTr:hover{
                            background-color: #D7DBDD  !important;
                        }
                    </style>
                    <div class ="row mb-4" style="background-color: white;" data-id="{{$wallet->TypeTransactionId}}">

                        <!-- tabla izquierda -->

                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Transacción</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th class="myTdColor2" >Monto comisión</th>
                                        <th class="myTdColor3" >Monto comisión base</th>
                                        <th class="myTdColor6" >Monto comisión Exchange</th>
                                        <th class="myTdColor5">Monto comisión Ganancia</th>                                        
                                    </tr>
                                </thead>
                                @foreach($transaction_summary as $wallet2)
                                    <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                            <td class="myTdHighlight">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_amount_commission_base,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->exchange_profit,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission_profit,2)}}</td>
                                        @else
                                            <td >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td >{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td >{{ number_format($wallet2->total_amount_commission_base,2)}}</td>
                                            <td >{{ number_format($wallet2->exchange_profit,2)}}</td>
                                            <td >{{ number_format($wallet2->total_commission_profit,2)}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <!-- tabla derecha -->

                        <div class="col-12 col-md-6">

                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Grupo</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th class="myTdColor2"style="width:1%;">Monto comisión</th>
                                        <th class="myTdColor3"style="width:1%;">Monto comisión Base</th>
                                        <th class="myTdColor6"style="width:1%;">Monto comisión Exchange</th>
                                        <th class="myTdColor5"style="width:1%;">Monto comisión Ganancia</th>
                                    </tr>

                                </thead>
                                @php
                                    $cant_transactions              = 0;
                                    $total_commission               = 0;
                                    $total_amount_commission_base   = 0;
                                    $total_commission_profit        = 0;
                                    $total_exchange_profit          = 0;
                                @endphp
                                @foreach($wallet_groupsummary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        <tr class="myTr" onClick="theRoute2({{0}}, {{$wallet2->GroupId ?? 0 }}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                            <td class="myTdHighlight">{{ $wallet2->GroupName ?? "A cajas"}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->cant_transactions)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_amount_commission_base,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->exchange_profit,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission_profit,2)}}</td>                                            
                                        </tr>

                                        @php
                                            $cant_transactions              += $wallet2->cant_transactions;
                                            $total_commission               += $wallet2->total_commission;
                                            $total_amount_commission_base   += $wallet2->total_amount_commission_base;
                                            $total_commission_profit        += $wallet2->total_commission_profit;
                                            $total_exchange_profit          += $wallet2->exchange_profit;
                                        @endphp

                                    @endif
                                @endforeach
                                <tr style="background-color: black; color: white;">
                                    <td></td>
                                    <td>{{ number_format($cant_transactions)}}</td>
                                    <td class="myTdColor2">{{ number_format($total_commission,2)}}</td>
                                    <td class="myTdColor3">{{ number_format($total_amount_commission_base,2)}}</td>
                                    <td class="myTdColor6">{{ number_format($total_exchange_profit,2)}}</td>
                                    <td class="myTdColor5">{{ number_format($total_commission_profit,2)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `
                $("#myCanvas").append(myElement);

            }
        @endforeach
    }

    function calculos2 (){

        let ctx3, myId, myobj, myChart3, ctx4, myChart4;

        @foreach($wallet_summary as $wallet)

            myId                = "{{$wallet->TypeTransactionId }}";
            myobj               = document.getElementById(myId);
            theWallet           = {!! $myWallet !!};
            theTypeTransaction  = {!! $myTypeTransaction !!};
            myIndMuestra        = 1;

             // alert('$wallet->TypeTransactionId' + "{{$wallet->TypeTransactionId }}" + " myId-> " + myId + " myobj-> " + myobj + " thewallet -> " + theWallet + " theTypeTransaction -> " + theTypeTransaction);

             if (theTypeTransaction){
                 if (theTypeTransaction != 0){
                     if (myId != theTypeTransaction){
                            myIndMuestra = 0;
                        }
                 }
             }

            if (myIndMuestra == 1){


                let myElement;

                myElement = `
                    <div class="row " data-id="{{$wallet->TypeTransactionId}}" >
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center text-uppercase font-weight-bold">{{ $wallet->TypeTransaccionName }}</h3>
                                    <canvas id=M{{ $wallet->TypeTransactionId }}></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center text-uppercase font-weight-bold">{{ $wallet->TypeTransaccionName }}</h3>
                                    <canvas id=M{{ $wallet->TypeTransactionId. 'A' }}></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $("#myCanvas").append(myElement);

                ctx3 = document.getElementById("M" + myId);

                myChart3 = new Chart(ctx3, {
                    type: 'doughnut',
                    data : {
                        labels: [
                            "{{$wallet->TypeTransaccionName }}",
                        ],
                        datasets: [
                            {
                            label: 'Otras transacciónes',
                            data: [
                                @foreach($wallet_summary as $wallet2)
                                    {{$wallet2->cant_transactions. ',' }}
                                @endforeach],
                            backgroundColor:[
                                @foreach($wallet_summary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        'rgb(0, 173, 181)',
                                    @else
                                        'rgb(203, 203, 203)',
                                    @endif
                                @endforeach],
                            hoverOffset: 6
                        }]
                    },

                });


                let myLabel             = [];
                let myData              = [];
                let myBackGroudColor    = [];
                let myBorderColor       = [];

                {{-- dd ($wallet_groupsummary) --}}
                @foreach($wallet_groupsummary as $wallet2)

                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId )

                            // alert('Aqui -> ' + "{{$wallet2->GroupName}}" + " total amount -> " + "{{$wallet2->total_amount}}");

                            myLabel.push("{{$wallet2->GroupName ?? $wallet2->WalletName }}");
                            myData.push({{$wallet2->total_amount . ',' }});
                            myBackGroudColor.push('rgb(0, 173, 181)');
                            myBorderColor.push('rgb(0, 173, 181)');

                        @endif

                @endforeach

                ctx4 = document.getElementById(
                    "M{{$wallet->TypeTransactionId. 'A' }}",
                );

                myChart4 = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: myLabel,
                        datasets: [{
                            label: '',
                            data: myData,
                            backgroundColor: myBackGroudColor,
                            borderColor: myBorderColor,
                            borderWidth: 6
                        }]
                    }

                });

                myElement = `
                    <style>
                        .myTr {
                            cursor: pointer;
                        }
                        .myTr:hover{
                            background-color: #D7DBDD  !important;
                        }
                    </style>

                    <!-- Tabla de Izquierda -->

                    <div class ="row mb-4" style="background-color: white;" data-id="{{$wallet->TypeTransactionId}}">
                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Transacción</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th class="myTdColor2" style="width:1%;">Monto Comision</th>
                                        <th class="myTdColor3" style="width:1%;">Monto Comision Base</th>
                                        <th class="myTdColor6" style="width:1%;">Monto Comision Exchange</th>                                        
                                        <th class="myTdColor5" style="width:1%;">Monto Comision Ganancia</th>
                                    </tr>
                                </thead>
                                @foreach($wallet_summary as $wallet2) 
                                                                    
                                    <tr class="myTr" onClick="theRoute2({{0}}, {{$wallet2->GroupId > 0 ? $wallet2->GroupId : 0 }}, {{$wallet2->WalletId ?? 0}}, {{$wallet2->TypeTransactionId}})">
                                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                            <td class="myTdHighlight">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_amount_commission_base,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->exchange_profit,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission_profit,2)}}</td>
                                        @else
                                            <td >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td >{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td >{{ number_format($wallet2->total_amount_commission_base,2)}}</td>                                          
                                            <td >{{ number_format($wallet2->exchange_profit,2)}}</td>                                          
                                            <td >{{ number_format($wallet2->total_commission_profit,2)}}</td>                                              
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <!-- Tabla de Derecha -->

                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Grupo</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th class="myTdColor2" style="width:1%;">Monto Comision</th>
                                        <th class="myTdColor3" style="width:1%;">Monto Comision Base</th>
                                        <th class="myTdColor6" style="width:1%;">Monto Comision Exchange</th>                                           
                                        <th class="myTdColor5" style="width:1%;">Monto Comision Ganancia</th>                                        

                                    </tr>
                                </thead>
                                @foreach($wallet_groupsummary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        <tr class="myTr" onClick="theRoute2({{0}}, {{$wallet2->GroupId ?? 0 }}, {{$wallet2->WalletId ?? 0}}, {{$wallet2->TypeTransactionId}})">                                        
                                            <td class="myTdHighlight">{{ $wallet2->GroupName ?? "A cajas"}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->cant_transactions)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_amount_commission_base,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->exchange_profit,2)}}</td>
                                            <td class="myTdHighlight">{{ number_format($wallet2->total_commission_profit,2)}}</td>                                            
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                `
                $("#myCanvas").append(myElement);

            }
        @endforeach
    }

    /*
    *
    *
    *  calculoGeneral2
    *  resumen general por wallet
    *
    */
    function calculoGeneral2(){

         myElement = `
            <div class="row" data-wallet="{{$wallet2->WalletId}}">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Comisiones</h3>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        `;
        $("#myCanvasGeneral").append(myElement);

        const COLORS = [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                    'rgb(114, 0, 27)',
        ];

        const ctx2          = document.getElementById('myChartDoughnut');
        const myChart2      = new Chart(ctx2, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet) "{{$wallet->TypeTransaccionName }}", @endforeach ],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->total_commission_profit. ',' }} @endforeach],
                    backgroundColor:COLORS,
                    hoverOffset: 4
                }]
            },

        });

        myElement =
        `
            <style>
                .myTr {
                    cursor: pointer;
                }
                .myTr:hover{
                    background-color: #D7DBDD  !important;
                }
            </style>

            {{-- dd($balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}

            <div class ="row mb-4" style="background-color: white;" data-wallet="{{$wallet2->WalletId}}">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            {{--
                            <tr>
                                <th style="width:1%;">Saldo Total</th>
                                <th style="width:1%;">{{ number_format($balance,2) }}</th>
                                <th style="width:1%;"></th>
                                <th style="width:1%;">Saldo al corte</th>
                                <th style="width:1%;">{{ number_format($balanceDetail,2) }}</th>    
                            </tr>
                            --}}
                            <tr>
                                <th style="width:1%;">Transacción</th>
                                <th style="width:1%;">Cant transacción</th>
                                <th class="myTdColor2" style="width:1%;">Comision</th>
                                <th class="myTdColor3" style="width:1%;">Comision Base</th>
                                <th class="myTdColor6" style="width:1%;">Comision Exchange</th>
                                <th class="myTdColor5" style="width:1%;">Comision Ganancia</th>
                            </tr>
                        </thead>
                        @php
                            $cant                   = 0;

                            $totalComision          = 0;
                            $totalComisionBase      = 0;
                            $totalComisionExchange  = 0;
                            $totalComisionGanancia  = 0;

                        @endphp
                        {{-- dd($wallet_summary) --}}
                        @foreach($wallet_summary as $wallet2)

                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{$wallet2->WalletId}}, {{$wallet2->TypeTransactionId}})">

                                @php
                                    $myTransaction          = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                    
                                    $totalComision          +=  $wallet2->total_commission;
                                    $totalComisionBase      +=  $wallet2->total_amount_commission_base;
                                    $totalComisionExchange  +=  $wallet2->exchange_profit;
                                    $totalComisionGanancia  +=  $wallet2->total_commission_profit;  

                                    $cant                   += $wallet2->cant_transactions;
                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")

                                        @php
   
                                        @endphp
                                        @break

                                    //
                                    // credito
                                    // suma
                                    //
                                    @case("Credito")
                                        @php
                                            
                                        @endphp                                                
                                        @break
                                @endswitch

                                <td>{{ $wallet2->TypeTransaccionName}}</td>
                                <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                <td>{{ number_format($wallet2->total_commission ,2) }}</td>
                                <td>{{ number_format($wallet2->total_amount_commission_base ,2) }}</td>
                                <td>{{ number_format($wallet2->exchange_profit ,2) }}</td>
                                <td>{{ number_format($wallet2->total_commission_profit,2) }}</td>

                            </tr>
                        @endforeach

                        <tr style="background-color: black; color:white;">
                            <td ></td>
                            <td                   >{{ number_format($cant) }}</td>
                            <td class="myTdColor2">{{ number_format($totalComision,2) }}</td>
                            <td class="myTdColor3">{{ number_format($totalComisionBase,2) }}</td>
                            <td class="myTdColor6">{{ number_format($totalComisionExchange,2) }}</td>                            
                            <td class="myTdColor5">{{ number_format($totalComisionGanancia,2) }}</td>    
                        </tr>

                    </table>
                </div>

            </div>
        `;

        $("#myCanvasGeneral").append(myElement);

    }

    /*
    *
    *
    *   calculogeneral3
    *   sin wallet
    *
    */
    function calculoGeneral3(){

        let myElement;


        // grafico principal

        myElement = `
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Comisiones</h3>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $("#myCanvasGeneral").append(myElement);

        const COLORS = [
            'rgb(0, 173, 181)',
            'rgb(58, 16, 120)',
            'rgb(255, 184, 76)',
            'rgb(49, 225, 247)',
            'rgb(8, 2, 2)',
            'rgb(0, 129, 180)',
            'rgb(7, 10, 82)',
            'rgb(213, 206, 163)',
            'rgb(60, 42, 33)',
            'rgb(2, 89, 85)',
            'rgb(255, 132, 0)',
            'rgb(184, 98, 27)',
            'rgb(114, 0, 27)',
        ];


        const DATA_COUNT2 = 1600;
        const NUMBER_CFG = {count: DATA_COUNT2, min: 0, max: 1500};
        const ctx2 = document.getElementById('myChartDoughnut');
        const myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data : {
                labels: [@foreach($transaction_summary as $wallet) "{{$wallet->TypeTransaccionName }}", @endforeach ],
                datasets: [
                    {
                    label: 'Dataset 1',
                    // data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    data: [@foreach($transaction_summary  as $wallet) {{$wallet->total_commission_profit. ',' }} @endforeach],                    
                    backgroundColor:COLORS.slice(0, DATA_COUNT2),

                    hoverOffset: 4
                }]
            },

        });

        // grafico de barras general
        /*
        myElement = `
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Comisiones</h3>
                            <canvas id="myChartBar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        `;



        let myLabel             = [];
        let myData              = [];
        let myBackGroudColor    = [];
        let myBorderColor       = [];

        @foreach($transaction_summary as $wallet2)

                    myLabel.push("{{$wallet2->TypeTransaccionName }}");
                    myData.push("{{$wallet2->total_commission_profit}}");
                    myBackGroudColor.push('rgb(0, 173, 181)');
                    myBorderColor.push('rgb(0, 173, 181)');


        @endforeach
        
        let ctx444 = document.getElementById("myChartBar");

        //console.log(myLabel);
        //console.log(myData);
        */
        {{--
        let myChart444 = new Chart(ctx444, {
            type: 'bar',
            labels: myLabel,
            data: {
                datasets: [{
                    label: 'Mi grafico',
                    data: myData,
                }]
            }
        });
        --}}
        
        

        

       // $("#myCanvasGeneral").append(myElement);
        
        // tabla principal


        myElement =
        `
            <style>

            </style>

            <div class ="row mb-4" style="background-color: white;">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="myTdColorBlack"  >Transacción 2</th>
                                <th class="myTdColorBlack"  >Cant transacción</th>
                                <th class="myTdColor2"      >Comision</th>
                                <th class="myTdColor3"      >Comision Base</th>
                                <th class="myTdColor6"      >Comision Exchange</th>
                                <th class="myTdColor5"      >Comision Ganancia</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalCreditos  = 0;
                            $totalDebitos   = 0;

                            $totalComision  = 0;
                        @endphp
                        
                        @foreach($transaction_summary as $wallet2)
                        
                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">

                                @php
                                    $myTransaction   = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                    $totalComision  +=  $wallet2->total_commission;

                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")
                                  
                                        @php

                                            $total_amount_debit             = $wallet2->total_amount;
                                            $total_amount_credit            = 0;

                                            $total_amount_base_debit        = $wallet2->total_amount_base;    
                                            $total_amount_base_credit       = 0;    

                                            
                                            if ($wallet2->TypeTransactionId == $myTypeTransaction ) 
                                                $myStyle = "myTdColor4";
                                            else 
                                                $myStyle ="";

                                            $cantDebitos ++;
                                            $totalDebitos += $wallet2->total_amount;

                                        @endphp
                                        @break
                                    
                                    @case("Credito")
                                        @php

                                            $total_amount_debit              = 0;
                                            $total_amount_credit             = $wallet2->total_amount;     

                                            $total_amount_base_debit         = 0;
                                            $total_amount_base_credit        = $wallet2->total_amount_base;

                                            if ($wallet2->TypeTransactionId == $myTypeTransaction ) 
                                                $myStyle = "myTdColor4";
                                            else 
                                                $myStyle ="";

                                            $cantCreditos ++;
                                            $totalCreditos += $wallet2->total_amount;                                            

                                        @endphp
                                        @break
                                @endswitch

                                <td class="{{$myStyle}}" >{{ $wallet2->TypeTransaccionName}}</td>
                                <td class="{{$myStyle}}" >{{ number_format($wallet2->cant_transactions) }}</td>
                                

                                <td class="{{$myStyle}}" >{{ number_format($wallet2->total_commission ,2)               == 0 ? "" : number_format($wallet2->total_commission ,2)}}</td>
                                <td class="{{$myStyle}}" >{{ number_format($wallet2->total_amount_commission_base ,2)   == 0 ? "" : number_format($wallet2->total_amount_commission_base ,2)}}</td>
                                <td class="{{$myStyle}}" >{{ number_format($wallet2->exchange_profit ,2)                == 0 ? "" : number_format($wallet2->exchange_profit ,2)}}</td>
                                <!-- <td class="{{$myStyle}}" >{{ number_format($wallet2->total_commission_profit,2)        == 0 ? "" : number_format($wallet2->total_commission_profit ,2)}}</td> -->
                                <td class="{{$myStyle}}" >{{ number_format($wallet2->amount_commission_profit_2,2)        == 0 ? "" : number_format($wallet2->amount_commission_profit_2,2)}}</td> 
                            </tr>

                        @endforeach
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </div>


            </div>
        `;
        $("#myCanvasGeneral").append(myElement);

    }


    function theRoute(wallet = 0, transaction = 0, fechaDesde = 0, fechaHasta = 0){


        if (wallet   === "") wallet  = 0;
        if (transaction   === "") transaction  = 0;

        let myRoute = "";

        myRoute = "{{ route('dashboardComisiones', ['wallet' => 'wallet2' , 'transaction' => 'transaction2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('transaction2',transaction);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);

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

    function BuscaWallet(miWallet){
        if (miWallet===0){
            return;
        }

        $('#wallet').each( function(index, element){

            $(this).children("option").each(function(){
                if ($(this).val() === miWallet.toString()){

                    $("#wallet option[value="+ miWallet +"]").attr("selected",true);
                }

            });
        });
    }

    function BuscaTransaccion(miTypeTransaction){
        if (miTypeTransaction===0){
            return;
        }

        $('#typeTransactions').each( function(index, element){

            $(this).children("option").each(function(){
                if ($(this).val() === miTypeTransaction.toString()){

                    $("#typeTransactions option[value="+ miTypeTransaction +"]").attr("selected",true);
                }

            });
        });
    }
    function InicializaFechas(){
         $('#drCustomRanges').data('daterangepicker').setStartDate('01-01-2001');

    }
    function BuscaFechas(FechaDesde = 0,FechaHasta = 0){

        myLocation  = window.location.toString();

        myArray     = myLocation.split("/");
        if (myArray.length > 4){
            FechaDesde = myArray[6];
            FechaHasta = myArray[7];
        }else{
            FechaDesde = 0;
            FechaHasta = 0;
        }

        if (FechaDesde == 0) return;


        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();


        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);
    }

    document.querySelectorAll('.imprimir').forEach(function(element) {
        element.addEventListener('click', function() {
            print();
        });
    });


    function generarNuevoColor(){
        var simbolos, color;
        simbolos = "0123456789ABCDEF";
        color = "#";

        for(var i = 0; i < 6; i++){
            color = color + simbolos[Math.floor(Math.random() * 16)];
        }

        document.body.style.background = color;
    }

    function cargaTransacciones(){
        @foreach($typeTransactions as $key => $value)
            // console.log('el grupo con key {!! $key !!} es {!! $value !!}');
            $('#my-select').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $value !!}' });
        @endforeach
    }
    /*
    *
    *
    * grabaFiltros
    * graba los filtros generales
    * 
    * 
    */
    function grabaFiltros(){

        let myDataTransactions          = buscaFiltros("my-select");
        let ocultarresumengeneral       = $('#ResumenGeneral').prop("checked");
        let ocultarresumentransaccion   = $('#ResumenTransaccion').prop("checked");
        
        // alert('grabaFiltros : ocultarresumengeneral -> ' + ocultarresumengeneral + '  ocultarresumentransaccion -> ' + ocultarresumentransaccion + ' myDataTransactions -> ' + myDataTransactions);

        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "{{route('filtrosGrabaComisiones')}}",
                async: false,
                data: { 
                    ocultarresumengeneral: ocultarresumengeneral,
                    ocultarresumentransaccion: ocultarresumentransaccion,
                    transactions: myDataTransactions,      
                },
            }
        ).done (function(myData) {

         // alert('vino');

        });

        return;
    }
    


    function buscaFiltros(myFilter = ""){
        
        if (myFilter=="") return "";

        let filtrosSeleccionado = [];
        filtrosSeleccionado.push(0);
        $("#" + myFilter + " option:selected").each(function(){
            filtrosSeleccionado.push($(this).attr('value'));
        });  
        // alert ("filtros de grupos ->" + filtrosSeleccionado.toString());
        return  filtrosSeleccionado;
    }


    function leeFiltros(){

        let myocultarresumengeneral = "{{ ($myocultarresumengeneral) ? true : false  }}" ? true : false;
        let myocultarresumentransaccion = "{{ ($myocultarresumentransaccion) ? true : false  }}" ? true : false;

        if (myocultarresumengeneral){
            $('#ResumenGeneral').prop("checked",true);
        }else{
            $('#ResumenGeneral').prop("checked",false);
        }

        if (myocultarresumentransaccion){
            $('#ResumenTransaccion').prop("checked",true);
        }else{
            $('#ResumenTransaccion').prop("checked",false);
        }

        let myData2 = [];

        @foreach($mytransactions as $value)
            myData2.push({{$value}});
        @endforeach

        // alert(myData2);

        myData2.map( function (valor) {

            $("#my-select option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select').multiSelect('select', valor.toString());

                }
            });

        });          
    }


    function aplicaFiltros(){

        $('#myCanvasGeneral').attr("hidden",false);
        $('#myCanvas').attr("hidden",false);

        if( $('#ResumenGeneral').is(':checked') ) {
            $('#myCanvasGeneral').attr("hidden",true);
            
        }

        if( $('#ResumenTransaccion').is(':checked') ) {
            $('#myCanvas').attr("hidden",true);
        }

            
        // alert('aqui');
        $("#myCanvas div").each(function(){
            $(this).removeAttr("hidden");
        });

        $("#my-select option:selected").each(function(){
            
            seleccionado = $(this).attr('value');

            $("#myCanvas div").each(function(){
                if($(this).data("id")){
                                            
                    if ($(this).data("id") == seleccionado){
                        
                        $(this).attr("hidden",true);
                    }
                }
            });


        });


    }


    function exportaEstadisticas(myResumen = 0){
        
        let transactions                = buscaFiltros("my-select");
        let ocultarresumengeneral       = $('#ResumenGeneral').prop("checked");
        let ocultarresumentransaccion   = $('#ResumenTransaccion').prop("checked");

        let fechaDesde                  = "{{$myFechaDesde}}";
        let fechaHasta                  = "{{$myFechaHasta}}";
        let wallet                      = "{{$myWallet}}";
        
        let transaction                 = "{{$myTypeTransaction ?? 0}}"; 

        myRoute = "{{route('exportsComisiones.excel', ['wallet' => 'wallet2', 'transaction' => 'transaction2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'ocultarresumengeneral' => 'ocultarresumengeneral2', 'ocultarresumentransaccion' => 'ocultarresumentransaccion2', 'transactions' => 'transactions2'])}}"

        myRoute = myRoute.replace('wallet2',                        wallet);
        myRoute = myRoute.replace('transaction2',                   transaction);        
        myRoute = myRoute.replace('fechaDesde2',                    fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',                    fechaHasta);
        myRoute = myRoute.replace('ocultarresumengeneral2',         ocultarresumengeneral);
        myRoute = myRoute.replace('ocultarresumentransaccion2',     ocultarresumentransaccion);
        myRoute = myRoute.replace('transactions2',                  transactions);

        // alert(' myRoute ->' + myRoute);

        location.href = myRoute;
    }

    function exportaEstadisticasPDF(myResumen = 0){
        
        let transactions                = buscaFiltros("my-select");
        let ocultarresumengeneral       = $('#ResumenGeneral').prop("checked");
        let ocultarresumentransaccion   = $('#ResumenTransaccion').prop("checked");

        let fechaDesde                  = "{{$myFechaDesde}}";
        let fechaHasta                  = "{{$myFechaHasta}}";
        let wallet                      = "{{$myWallet}}";

        let transaction                 = "{{$myTypeTransaction}}"; 

        // href={{route('exports.excel', [$myWallet, $myFechaDesde, $myFechaHasta])}}

        myRoute = "{{route('exports.EstadisticaComisionesPDF', ['wallet' => 'wallet2', 'transaction' => 'transaction2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'ocultarresumengeneral' => 'ocultarresumengeneral2', 'ocultarresumentransaccion' => 'ocultarresumentransaccion2', 'transactions' => 'transactions2'])}}"
                            
        myRoute = myRoute.replace('wallet2',                        wallet);
        myRoute = myRoute.replace('transaction2',                   transaction);
        myRoute = myRoute.replace('fechaDesde2',                    fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',                    fechaHasta);
        myRoute = myRoute.replace('ocultarresumengeneral2',         ocultarresumengeneral);
        myRoute = myRoute.replace('ocultarresumentransaccion2',     ocultarresumentransaccion);
        myRoute = myRoute.replace('transactions2',                  transactions);

        // alert(' myRoute vvv->' + myRoute);

        location.href = myRoute;
    }

            
</script>

@endsection
