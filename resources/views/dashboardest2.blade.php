@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

@php
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
@endphp

<div class="container">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-3">
                    <x-adminlte-select2 id="wallet"
                    name="optionsWallets"
                    igroup-size="lg"
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
                    igroup-size="lg"
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
                        igroup-size="lg"
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
                    <a class="btn btn-success" href={{route('exports.excel', $myWallet)}}><i class="fas fa-file-excel"></i></a>
                </div>

            </div>
        </div>
    </div>
    <div id="myCanvas"></div>

</div>

@endsection
@section('js')


<script>

    const miWallet = {!! $myWallet !!};

    BuscaWallet(miWallet);

    const miTypeTransaction= {!! $myTypeTransaction !!};

    BuscaTransaccion(miTypeTransaction);




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

        if (myLength == 4 || myLength == 8 && myArray[4] === '0') {
            // $('#typeTransactions, #drCustomRanges').prop('disabled', true);
            //$('#typeTransactions').prop('disabled', true);
        } else {
            // $('#typeTransactions, #drCustomRanges').prop('disabled', false);
           // $('#typeTransactions').prop('disabled', false);
        }


        let  myFechaDesde = {!! $myFechaDesde !!};
        // console.log({!! $myFechaDesde !!});
        const myFechaHasta = {!! $myFechaHasta !!};
        
        // alert('Fechas -> desde -> ' + myFechaDesde);

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

        if (!miWallet){
            // alert ('aqui');
            calculoGeneral3();
            calculos3();
        }else{
            calculoGeneral2();
            calculos2();
        }

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
                    <div class="row ">
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
                    <div class ="row mb-4" style="background-color: white;">
                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Transacción</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th style="width:1%;">Monto Transaccion</th>
                                    </tr>
                                </thead>
                                @foreach($transaction_summary as $wallet2)
                                    <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                        @else
                                            <td >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Grupo</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th style="width:1%;">Monto Transaccion</th>
                                    </tr>

                                </thead> 
                                
                                @foreach($wallet_groupsummary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        <tr class="myTr" onClick="theRoute2({{0}}, {{$wallet2->GroupId ?? 0 }}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->GroupName ?? "A cajas"}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions)}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
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
                    <div class="row ">
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
                    <div class ="row mb-4" style="background-color: white;">
                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Transacción</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th style="width:1%;">Monto Transaccion</th>
                                    </tr>
                                </thead>
                                @foreach($wallet_summary as $wallet2)
                                    <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                        @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                        @else
                                            <td >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="col-12 col-md-6">
                            <table class="table thead-light" style="background-color: white;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:1%;">Grupo</th>
                                        <th style="width:1%;">Cant transacción</th>
                                        <th style="width:1%;">Monto Transaccion</th>
                                    </tr>
                                </thead>
                                @foreach($wallet_groupsummary as $wallet2)
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)
                                        <tr class="myTr" onClick="theRoute2({{0}}, {{$wallet2->GroupId ?? 0 }}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->GroupName ?? "A cajas"}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions)}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
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


    function calculoGeneral2(){

         myElement = `
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        `;
        $("#myCanvas").append(myElement);

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

        const ctx = document.getElementById('myChart');

        const DATA_COUNT2 = 1600;
        const NUMBER_CFG = {count: DATA_COUNT2, min: 0, max: 1500};
        const ctx2 = document.getElementById('myChartDoughnut');
        const myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary->take(13) as $wallet) "{{$wallet->TypeTransaccionName }}", @endforeach ],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary->take(13) as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:COLORS.slice(0, DATA_COUNT2),

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
            <div class ="row mb-4" style="background-color: white;">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:1%;">Transacción</th>
                                <th style="width:1%;">Cant transacción</th>
                                <th style="width:1%;">Monto Transaccion</th>
                            </tr>
                        </thead>
                        @foreach($wallet_summary as $wallet2)
                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                <td>{{ $wallet2->TypeTransaccionName}}</td>
                                <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                <td>{{ number_format($wallet2->total_amount,2)}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        `;

        $("#myCanvas").append(myElement);

    }



    function calculoGeneral3(){

        let myElement;
 
        myElement = `
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $("#myCanvas").append(myElement);

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

        const ctx = document.getElementById('myChart');

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
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:COLORS.slice(0, DATA_COUNT2),

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
            <div class ="row mb-4" style="background-color: white;">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:1%;">Transacción</th>
                                <th style="width:1%;">Cant transacción</th>
                                <th style="width:1%;">Monto Transaccion</th>
                            </tr>
                        </thead>
                        @foreach($transaction_summary as $wallet2)
                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                    @if($wallet2->TypeTransactionId == $myTypeTransaction )
                                        <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                        <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                    @else
                                        <td >{{ $wallet2->TypeTransaccionName}}</td>
                                        <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                    @endif


                            </tr>
                        @endforeach
                    </table>
                </div>


            </div>
        `;
        $("#myCanvas").append(myElement);

    }




    function theRoute(wallet = 0, transaction = 0, fechaDesde = 0, fechaHasta = 0){


        if (wallet   === "") wallet  = 0;
        if (transaction   === "") transaction  = 0;

        let myRoute = "";

        myRoute = "{{ route('dashboardest', ['wallet' => 'wallet2' , 'transaction' => 'transaction2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
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

</script>

@endsection
