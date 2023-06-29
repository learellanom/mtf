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
                <div class="col col-md-4">
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
                <div class="col col-md-4">
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

                <div class ="col-12 col-md-4">
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
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                    <canvas id="myChartDoughnut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Comparativo de Movimientos</h3>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

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
                    <tr>
                            <td>{{ $wallet2->TypeTransaccionName}}</td>                                    
                            <td>{{ number_format($wallet2->cant_transactions) }}</td>
                            <td>{{ number_format($wallet2->total_amount,2)}}</td>
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
                    <tr>
                            <td>{{ $wallet2->GroupName ?? $wallet2->TypeTransaccionName . ' ' . $wallet2->WalletName}}</td>                                    
                            <td>{{ number_format($wallet2->cant_transactions)}}</td>
                            <td>{{ number_format($wallet2->total_amount,2)}}</td>
                    </tr>                               
                @endforeach
            </table>                        
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

    // alert('miTypeTransaction -> ' + miTypeTransaction);


    document.addEventListener('DOMContentLoaded', function () {

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
        //var total_amount = @foreach($wallet_summary as $wallet) {{ $wallet->total_amount. ',' }} @endforeach

        //alert(total_amount)

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


        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallet)  "{{$wallet->GroupName }}", @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallet) {{$wallet->total_amount. ',' }} @endforeach],
                    backgroundColor:COLORS.slice(0, DATA_COUNT2),
                    borderColor:COLORS.slice(0, DATA_COUNT2),
                    borderWidth: 4

                }]
            }
        });

        // Valida y esconde

        let text = window.location.href;
        const myArray = text.split("/");
        const myLength = myArray.length;

        if (window.location.href.indexOf("?") === -1) {
            $('.esconder').show();
        } else {
            $('.esconder').hide();
        }

        if (myLength == 4 || myLength == 8 && myArray[4] === '0') {
            // $('#typeTransactions, #drCustomRanges').prop('disabled', true);
            $('#typeTransactions').prop('disabled', true);        
        } else {
            // $('#typeTransactions, #drCustomRanges').prop('disabled', false);
            $('#typeTransactions').prop('disabled', false);        
        }

        
        //  calculos();



    }, true);

    $(() => {
        
        const myFechaDesde = {!! $myFechaDesde !!};
        const myFechaHasta = {!! $myFechaHasta !!};

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

           calculos2();   
        // calculos();   
    });

    $( document ).ready(function() {
        // Handler for .ready() called.
        // ctx3 = "{{$wallet->TypeTransactionId }}";
        // alert('uno' + "{{$wallet->TypeTransactionId }}" + " ctx3 " + ctx3 + " --- " + document.getElementById(
        //                     ctx3
        //                 ));    
        // calculos2();   
    });

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
                                    <tr>
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
                                        <tr>
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

    function calculos(){
        
        @if($wallet_summary->count() <= 13)

        @foreach($wallet_summary as $wallet) 

            // alert('uno');

            @if($wallet->TypeTransactionId == 1)

                /* PAGO EN TRANSFERENCIA */

                const ctx3 = document.getElementById(
                        "{{$wallet->TypeTransactionId }}"
                    );

                const myChart3 = new Chart(ctx3, {
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
                                    @if($wallet2->TypeTransactionId == 1) 
                                        'rgb(0, 173, 181)', 
                                    @else 
                                        'rgb(203, 203, 203)', 
                                    @endif 
                                @endforeach],
                            hoverOffset: 6
                        }]
                    },

                });


                const ctx4 = document.getElementById(
                    "{{$wallet->TypeTransactionId. 'A' }}",             
                );

                var myChart4 = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: [
                            "{{$wallets->GroupName ?? $wallets->WalletName }}", 
                        ],
                        datasets: [{
                            label: '',
                            data: [
                                // {{$wallets->total_amount. ',' }}         
                                
                                @foreach($wallet_groupsummary as $wallet2) 
                                    @if($wallet2->TypeTransactionId == $wallet->TypeTransactionId)                                 
                                        {{$wallet2->total_amount. ',' }} 
                                    @endif
                                @endforeach],

                            ],
                            backgroundColor: [
                                'rgb(0, 173, 181)',                            
                            ],
                            borderColor: [
                                'rgb(0, 173, 181)',                            
                            ],
                            borderWidth: 6
                        }]
                    }

                });

            @else

            @endif

        @endforeach

        /* PAGO EN TRANSFERENCIA */

        @foreach($wallet_summary as $wallet) 

        // alert('dos');

        @if($wallet->TypeTransactionId == 2)
            /* COBRO EN TRANSFERENCIA */
            // const DATA_COUNT3 = 1500;
            // const NUMBER_CFG3 = {count: DATA_COUNT3, min: 0, max: 1500};

            const ctx5 = document.getElementById(
                @foreach($wallet_summary as $wallet) 
                    @if($wallet->TypeTransactionId == 2) 
                        "{{$wallet->TypeTransactionId  }}", 
                    @endif 
                @endforeach
            );

            const myChart5 = new Chart(ctx5, {
                type: 'doughnut',
                data : {
                    labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                    datasets: [
                        {
                        label: 'Dataset 1',
                        data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                        backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 2)  'rgb(58, 16, 120)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                        hoverOffset: 4
                    }]
                },
            });

            /* COBRO EN TRANSFERENCIA */
            const ctx6 = document.getElementById(
                @foreach($wallet_summary as $wallet) 
                    @if($wallet->TypeTransactionId == 2) 
                        "{{$wallet->TypeTransactionId. 'A' }}", 
                    @endif 
                @endforeach
            );
            const myChart6 = new Chart(ctx6, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($wallet_groupsummary as $wallets) 
                            @if($wallets->TypeTransactionId == 2) 
                                "{{$wallets->GroupName ?? $wallets->WalletName }}",  
                            @endif 
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Monto total de las transacciones',
                        data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 2) {{$wallets->total_amount. ',' }} @endif @endforeach],
                        backgroundColor: [
                            @if($wallet_summary->count())
                            @foreach($wallet_groupsummary as $wallet)
                            @if($wallet->TypeTransactionId == 2)
                            'rgb(58, 16, 120)',
                            @endif
                            @endforeach
                            @endif
                        ],
                        borderColor: [
                            @if($wallet_summary->count())
                            @foreach($wallet_groupsummary as $wallet)
                            @if($wallet->TypeTransactionId == 2)
                            'rgb(58, 16, 120)',
                            @endif
                            @endforeach
                            @endif
                        ],
                        borderWidth: 6
                    }]
                }
            });
        /* COBRO EN TRANSFERENCIA */
        @else

        @endif

        @endforeach

        @foreach($wallet_summary as $wallet) 

        // alert('tres');


        @if($wallet->TypeTransactionId == 3)
        /* PAGO EFECTIVO */
        const DATA_COUNT4 = 1500;
        const NUMBER_CFG4 = {count: DATA_COUNT4, min: 0, max: 1500};
        const ctx7 = document.getElementById(@if($wallet->TypeTransactionId == 3) "{{$wallet->TypeTransactionId}}", @endif);
        const myChart7 = new Chart(ctx7, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor: [
                        @foreach($wallet_summary as $wallet) 
                            @if($wallet->TypeTransactionId == 3)  'rgb(255, 184, 76)', 
                            @else 'rgb(203, 203, 203)', 
                            @endif 
                        @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx8 = document.getElementById(@if($wallet->TypeTransactionId == 3) "{{$wallet->TypeTransactionId. 'A' }}", @else '3A', @endif);
        const myChart8 = new Chart(ctx8, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 3) "{{$wallets->GroupName ?? $wallets->WalletName}}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 3) {{$wallets->total_amount. ',' }}@endif  @endforeach],
                    backgroundColo  : [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 3)
                        'rgb(255, 184, 76)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 3)
                        'rgb(255, 184, 76)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }
        });
        @else

        @endif
        @endforeach
        /* PAGO EFECTIVO */
        @foreach($wallet_summary as $wallet) 


        // alert('cuatro');

        @if($wallet->TypeTransactionId == 4)
        /* COBRO EN EFECTIVO */
        const DATA_COUNT5   = 1500;
        const NUMBER_CFG5   = {count: DATA_COUNT5, min: 0, max: 1500};
        const ctx9          = document.getElementById(@if($wallet->TypeTransactionId == 4) "{{$wallet->TypeTransactionId}}", @endif);
        const myChart9      = new Chart(ctx9, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 4)  'rgb(49, 225, 247)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx10 = document.getElementById(@if($wallet->TypeTransactionId == 4) "{{$wallet->TypeTransactionId. 'A' }}", @else '4A', @endif);
        const myChart10 = new Chart(ctx10, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 4) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 4) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 4)
                        'rgb(49, 225, 247)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 4)
                        'rgb(49, 225, 247)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }
        });
        /* COBRO EN EFECTIVO */
        @else

        @endif
        @endforeach


        @foreach($wallet_summary as $wallet) 

        // alert('cinco');


        @if($wallet->TypeTransactionId == 5)
        /* PAGO MERCANCIA */
        const DATA_COUNT6 = 1500;
        const NUMBER_CFG6 = {count: DATA_COUNT6, min: 0, max: 1500};
        const ctx11 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 5) "{{$wallet->TypeTransactionId }}", @endif @endforeach);
        const myChart11 = new Chart(ctx11, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet) "{{$wallet->TypeTransaccionName }}",   @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 5)  'rgb(8, 2, 2)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx12 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 5) "{{$wallet->TypeTransactionId. 'A' }}", @endif @endforeach);;
        const myChart12 = new Chart(ctx12, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 5) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 5) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 5)
                        'rgb(8, 2, 2)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 5)
                        'rgb(8, 2, 2)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* PAGO MERCANCIA */
        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 

        // alert('seis');


        @if($wallet->TypeTransactionId == 6)
        /* NOTA DECREDITO A CAJA EN EFECTIVO */
        const DATA_COUNT7 = 1500;
        const NUMBER_CFG7 = {count: DATA_COUNT7, min: 0, max: 1500};
        const ctx13 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 6) "{{$wallet->TypeTransactionId }}", @endif @endforeach);
        const myChart13 = new Chart(ctx13, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 6)  'rgb(0, 129, 180)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx14 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 6) "{{$wallet->TypeTransactionId. 'A' }}", @endif @endforeach);
        const myChart14 = new Chart(ctx14, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 6) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 6) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 6)
                        'rgb(0, 129, 180)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 6)
                        'rgb(0, 129, 180)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* NOTA DE CREDITO A CAJA EN EFECTIVO */
        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 

        // alert('siete');


        @if($wallet->TypeTransactionId == 7)
        /* NOTA DE CREDITO  */
        const DATA_COUNT8 = 1500;
        const NUMBER_CFG8 = {count: DATA_COUNT8, min: 0, max: 1500};
        const ctx15 = document.getElementById("{{$wallet->TypeTransactionId }}");
        const myChart15 = new Chart(ctx15, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 7)  'rgb(7, 10, 82)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });



        const ctx16 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 7) "{{$wallet->TypeTransactionId. 'A' }}", @endif @endforeach);
        const myChart16 = new Chart(ctx16, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 7)  "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 7) {{$wallets->total_amount. ',' }}, @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 7)
                        'rgb(7, 10, 82)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 7)
                        'rgb(7, 10, 82)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* NOTA DE CREDITO  */


        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 


        // alert('ocho');


        @if($wallet->TypeTransactionId == 8)
        /* NOTA DE DEBITO  */

        const DATA_COUNT9 = 1500;
        const NUMBER_CFG9 = {count: DATA_COUNT9, min: 0, max: 1500};
        const ctx18 = document.getElementById(@if($wallet->TypeTransactionId == 8) "{{$wallet->TypeTransactionId }}", @endif);
        const myChart18 = new Chart(ctx18, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 8)  'rgb(213, 206, 163)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]

            },

        });

        const ctx19 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 8) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart19 = new Chart(ctx19, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 8) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 8) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 8)
                        'rgb(213, 206, 163)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 8)
                        'rgb(213, 206, 163)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });

        /* NOTA DE DEBITO  */
        @else

        @endif
        @endforeach


        @foreach($wallet_summary as $wallet) 

        // alert('nueve');


        @if($wallet->TypeTransactionId == 9)
        /* SWITF  */
        const DATA_COUNT10 = 1500;
        const NUMBER_CFG10 = {count: DATA_COUNT10, min: 0, max: 1500};
        const ctx20 = document.getElementById("{{$wallet->TypeTransactionId }}");
        const myChart20 = new Chart(ctx20, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 9)  'rgb(60, 42, 33)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx21 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 9) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart21 = new Chart(ctx21, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 9) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 9) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 9)
                        'rgb(60, 42, 33)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 9)
                        'rgb(60, 42, 33)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* SWITF  */
        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 


        // alert('diez');


        @if($wallet->TypeTransactionId == 10)
        /* COBRO MERCANCIA */
        const DATA_COUNT11 = 1500;
        const NUMBER_CFG11 = {count: DATA_COUNT11, min: 0, max: 1500};
        const ctx22 = document.getElementById("{{$wallet->TypeTransactionId }}");
        const myChart22 = new Chart(ctx22, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 10)  'rgb(2, 89, 85)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx23 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 10) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart23 = new Chart(ctx23, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 10) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 10) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 10)
                        'rgb(2, 89, 85)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 10)
                        'rgb(2, 89, 85)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* COBRO MERCANCIA  */
        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 


        // alert('once');


        @if($wallet->TypeTransactionId == 11)
        /* PAGO USDT  */

        const DATA_COUNT12 = 1500;
        const NUMBER_CFG12 = {count: DATA_COUNT12, min: 0, max: 1500};
        const ctx24 = document.getElementById("{{$wallet->TypeTransactionId }}");
        const myChart24 = new Chart(ctx24, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 11)  'rgb(255, 132, 0)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx25 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 11) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart25 = new Chart(ctx25, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 11) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 11) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 11)
                        'rgb(255, 132, 0)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 11)
                        'rgb(255, 132, 0)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* PAGO USDT  */
        @else

        @endif
        @endforeach


        @foreach($wallet_summary as $wallet) 

        // alert('doce');


        @if($wallet->TypeTransactionId == 12)
        /*  NOTA DE DEBITO A CAJA DE EFECTIVO */
        const DATA_COUNT14 = 1500;
        const NUMBER_CFG14 = {count: DATA_COUNT14, min: 0, max: 1500};
        const ctx26 = document.getElementById("{{$wallet->TypeTransactionId}}");
        const myChart26 = new Chart(ctx26, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet) "{{$wallet->TypeTransaccionName }}",  @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor:[@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 12)  'rgb(184, 98, 27)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx27 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 12) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart27 = new Chart(ctx27, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 12) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 12) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 12)
                        'rgb(184, 98, 27)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 12)
                        'rgb(184, 98, 27)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* NOTA DE DEBITO A CAJA DE EFECTIVO  */
        @else

        @endif
        @endforeach

        @foreach($wallet_summary as $wallet) 

        // alert('trece');


        @if($wallet->TypeTransactionId == 13)
        /* COBRO USDT  */
        const DATA_COUNT15 = 1500;
        const NUMBER_CFG15 = {count: DATA_COUNT15, min: 0, max: 1500};
        const ctx28 = document.getElementById(@if($wallet->TypeTransactionId == 13) "{{$wallet->TypeTransactionId}}", @endif);
        const myChart28 = new Chart(ctx28, {
            type: 'doughnut',
            data : {
                labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}",  @endforeach],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                    backgroundColor: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 13)  'rgb(184, 500, 270)', @else 'rgb(203, 203, 203)', @endif @endforeach],
                    hoverOffset: 4
                }]
            },

        });

        const ctx29 = document.getElementById(@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 13) "{{$wallet->TypeTransactionId.'A' }}", @endif @endforeach);
        const myChart29 = new Chart(ctx29, {
            type: 'bar',
            data: {
                labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 13) "{{$wallets->GroupName ?? $wallets->WalletName }}", @endif @endforeach],
                datasets: [{
                    label: 'Monto total de las transacciones',
                    data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 13) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                    backgroundColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 13)
                        'rgb(184, 500, 270)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderColor: [
                        @if($wallet_summary->count())
                        @foreach($wallet_groupsummary as $wallet)
                        @if($wallet->TypeTransactionId == 13)
                        'rgb(184, 500, 270)',
                        @endif
                        @endforeach
                        @endif
                    ],
                    borderWidth: 6
                }]
            }

        });
        /* COBRO USDT  */
        @else


        @endif

        @endforeach

        @else


        @endif
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



</script>

@endsection