<html>
<body>
@php



$myClass = new app\Http\Controllers\statisticsController;

 // dd('myTypeTransaction -> ' . $myTypeTransaction);


$myData = $myClass->filtrosLeeEstadisticas();

$myWalletDes = $myClass->getWalletDetail($myWallet);


// dd($myWalletDes->name);

$myocultarresumengeneral        = $myData['ocultarresumengeneral'];
$myocultarresumentransaccion    = $myData['ocultarresumentransaccion'];
$mytransactions                 = $myData['transactions'];
// dd($myData);

$myocultarresumengeneral        = (!$myocultarresumengeneral) ? 0 : $myocultarresumengeneral;
$myocultarresumentransaccion    = (!$myocultarresumentransaccion) ? 0 : $myocultarresumentransaccion;


  // dd(' fecha desde -> ' . $myFechaDesde . ' fecha hasta -> ' . $myFechaHasta);

@endphp

<style>
    @page {
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        margin-bottom: 1.5cm;
    }
    h3{
        text-align: center;
        text-transform: uppercase;
    }
    /*
    html{
        font-size: 12px;
        margin: 50pt 50pt 50pt 50pt;
    }
    */
    body {
        margin-top: 2.5cm;
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 2cm;
    }            
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1.5cm;

        text-align: center;
        line-height: 1cm;
    }
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 0.5cm;

        text-align: center;
        line-height: 0.5cm;
    }
    .page-break {
        page-break-after: always;
    }       
    .pagenum:before {
        content: counter(page);
    }   
    thead{ 
        background-color: black; 
        color: white;
    }
</style>

<header style="font-size: 9px;">
    <img src="{{asset('./img/AdminLTELogo.png')}}" width="50" height="50" style="float: left;">
    MTF
    <span style="float: right;">{{date("d-m-Y H:i:s")}}</span>
    <hr>
</header>

<footer>
    <hr>            
    <span class="pagenum"></span>
</footer>

<main>
<div class="container" id="content">
    @php
        $myStyle = "";
        if($myocultarresumengeneral){
            $myStyle = "display: none";
        }
    @endphp
    @if($myWallet != 0)
        <div id="myCanvasGeneral" style=" text-align: center; margin-left: 0px; {{$myStyle }}">

            <div class="row" data-wallet="{{$myWallet}}">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                                <p class="text-center text-uppercase font-weight-bold">
                                    {{$myWalletDes->name}}
                                    <br>
                                    @if($myFechaDesde == "2001-01-01")
                                        al {{date("d-m-Y")}}
                                    @else
                                    del {{ date('d-m-Y',strtotime($myFechaDesde))}}
                                    al  {{ date('d-m-Y',strtotime($myFechaHasta))}}
                                    @endif
                                </p>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <style>
                .myTr {
                    cursor: pointer;
                }
                .myTr:hover{
                    background-color: #D7DBDD  !important;
                }
            </style>

            {{-- dd('balance-> ' . $balance . ' --- ' . $balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}

            <div class ="row mb-4" style="background-color: white; font-size:10px;" data-wallet="{{$myWallet}}">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark" style="background-color: black; color:white;">
                            <tr>
                                <th style="width:200px;">Saldo Total</th>
                                <th style="width:120px;">{{ number_format($balance,2) }}</th>
                                <th style="width:120px;"></th>
                                <th style="width:120px;">Saldo al corte</th>
                                <th style="width:120px;">{{ number_format($balanceDetail,2) }}</th>
                            </tr>
                            <tr>
                                <th style="width:200px;">Transacción</th>
                                <th style="width:120px;">Cant transacción</th>
                                <th style="width:120px;">Entradas</th>
                                <th style="width:120px;">Salidas</th>
                                <th style="width:120px;">Saldo</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalCreditos  = 0;
                            $totalDebitos   = 0;

                            $saldo = 0;
                        @endphp
                        {{-- dd($wallet_summary) --}}
                        @foreach($wallet_summary as $wallet2)

                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{$wallet2->WalletId}}, {{$wallet2->TypeTransactionId}})">


                                @php
                                    $myTransaction  = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")
                                        
                                        <td>{{ $wallet2->TypeTransaccionName}}</td>
                                        <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td>{{ ' ' }}</td>
                                        <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        <td>{{ ' ' }}</td>                                    
                                        @php
                                            $cantDebitos ++;
                                            $totalDebitos += $wallet2->total_amount;                                        
                                        @endphp
                                        @break

                                    //
                                    // credito
                                    // suma
                                    //
                                    @case("Credito")
                                        @php
                                            $cantCreditos ++;
                                            $totalCreditos += $wallet2->total_amount;
                                        @endphp                                                
                                        
                                        <td>{{ $wallet2->TypeTransaccionName}}</td>
                                        <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        <td>{{ ' ' }}</td>
                                        <td>{{ ' ' }}</td>

                                        @break
                                @endswitch

                            </tr>
                        @endforeach
                        @php
                            $myBalance = $balanceDetail + ($totalCreditos - $totalDebitos);
                        @endphp

                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ number_format($totalCreditos,2) }}</td>
                            <td >{{ number_format($totalDebitos,2)}}</td>
                            <td>{{  number_format($totalCreditos - $totalDebitos,2) }}</td>
                        </tr>
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ 'Saldo al dia '}}</td>
                            <td>{{  number_format($myBalance,2) }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    @else
        <div id="myCanvasGeneral" style=" text-align: center; margin-left: 10px; {{$myStyle }}">
            <div class="row" data-wallet="{{$myWallet}}">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                            <canvas id="myChartDoughnut"></canvas>
                        </div>
                    </div>
                </div>
            </div>    
            <div class ="row mb-4" style="background-color: white;">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead style="background-color: black; color:white;">
                            <tr>
                                <th style="width:160px;">Transacciónnnnn</th>
                                <th style="width:160px;">Cant transacción</th>
                                <th style="width:160px;">Entradas</th>
                                <th style="width:160px;">Salidas</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalCreditos  = 0;
                            $totalDebitos   = 0;
                        @endphp
                        @foreach($transaction_summary as $wallet2)
                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">
                                @php
                                    $myTransaction  = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")
                                        
                                        @if($wallet2->TypeTransactionId == $myTypeTransaction )
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{  ' ' }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                        @else
                                            <td                                                 >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td                                                 >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td                                                 >{{  ' ' }}</td>
                                            <td class="font-weight-bold" style="color: green;"  >{{ number_format($wallet2->total_amount,2)}}</td>
                                        @endif
                                        @php
                                            $cantDebitos ++;
                                            $totalDebitos += $wallet2->total_amount;
                                        @endphp
                                        @break
                                    
                                    @case("Credito")
                                        @if($wallet2->TypeTransactionId == $myTypeTransaction )
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ ' ' }}</td>
                                        @else
                                            <td                                                 >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td                                                 >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td                                                 >{{ number_format($wallet2->total_amount,2)}}</td>
                                            <td class="font-weight-bold" style="color: green;"  >{{ ' ' }}</td>
                                        @endif
                                        @php
                                            $cantCreditos ++;
                                            $totalCreditos += $wallet2->total_amount;
                                        @endphp
                                        @break
                                @endswitch
                            </tr>
                        @endforeach
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ number_format($totalCreditos,2) }}</td>
                            <td >{{ number_format($totalDebitos,2)}}</td>
                        </tr>
                    </table>
                </div>
            </div>  
        </div>
    @endif
    <br>
    <br>
    <br>

    {{-- por transaccion --}}

    @php
        $myStyle = "";
        if($myocultarresumentransaccion){
            $myStyle = "display: none";
        }
    @endphp
    @if($myWallet != 0)
        <div id="myCanvas" style="font-size: 10px; margin-left: 10px; {{$myStyle}}">
            
            @foreach($wallet_summary as $wallet)
                <!-- mytransactions -->
                @php
                    $indMuestra = 1;

                    if ($myTypeTransaction !=0){
                        if($myTypeTransaction != $wallet->TypeTransactionId){
                            $indMuestra = 0;
                        }
                    }else{
                        foreach($mytransactions as $value){
                            if($value == $wallet->TypeTransactionId){
                                $indMuestra = 0;
                            }
                        }
                    }

                @endphp
                @if($indMuestra==0) 
                    @continue
                @endif
                
                    <div class="page-break">
                    </div>
                
                <div class ="" style="background-color: white;" data-id="">
                    <h3>{{ $wallet->TypeTransaccionName}}</h3>            
                    <div style="float:left;">
                        <table class="table thead-light" style="background-color: white;">
                            <thead class="thead-dark" style="background-color: black; color: white;">
                                <tr>
                                    <td colspan="3">
                                        <h3>
                                            {{$myWalletDes->name}}
                                            <br>
                                            @if($myFechaDesde == "2001-01-01")
                                                al {{date("d-m-Y")}}
                                            @else
                                                del {{ date('d-m-Y',strtotime($myFechaDesde))}}
                                                al  {{ date('d-m-Y',strtotime($myFechaHasta))}}
                                            @endif
                                        </h3>
                                    </td>
                                </tr>  
                                {{--
                                <tr>
                                    <td colspan="3">
                                    <h3>{{ $wallet->TypeTransaccionName}}</h3>  
                                    </td>
                                </tr>    
                                --}}                        
                                <tr>
                                    <th style="width:100px;">Transacción</th>
                                    <th style="width:100px;">Cant transacción</th>
                                    <th style="width:100px;">Monto Transaccion</th>
                                </tr>
                            </thead>
                            @foreach($wallet_summary as $wallet2)
                                <tr class="myTr">
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

                    <div class="" style="float: right;"> 
                        <table class="table thead-light" style="background-color: white;">
                            <thead class="thead-dark" style="background-color: black; color: white;">
                                <tr>
                                    <td colspan="3">

                                    <h3>
                                            {{$myWalletDes->name}}
                                            <br>
                                            @if($myFechaDesde == "2001-01-01")
                                                al {{date("d-m-Y")}}
                                            @else
                                                del {{ date('d-m-Y',strtotime($myFechaDesde))}}
                                                al  {{ date('d-m-Y',strtotime($myFechaHasta))}}
                                            @endif
                                        </h3>                                     
                                    </td>
                                </tr>          
                                {{--                   
                                <tr>
                                    <td colspan="3">
                                    <h3>{{ $wallet->TypeTransaccionName}}</h3>  
                                   
                                    </td>
                                </tr>
                                --}}
                                <tr>
                                    <th style="width:100px;">Grupo</th>
                                    <th style="width:100px;">Cant transacción</th>
                                    <th style="width:100px;">Monto Transaccion</th>
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
                
                <div style="clear: both"></div>
                <br>
                <br>
                <br>
            @endforeach
        </div>
    @else
        <div id="myCanvas" style="font-size: 10px; margin-left: 10px; {{$myStyle}}">

            @foreach($transaction_summary as $wallet)
                <!-- mytransactions -->
                @php
                    
                    $indMuestra = 1;
                    foreach($mytransactions as $value){
                        if ($myTypeTransaction !=0){
                            if($myTypeTransaction != $wallet->TypeTransactionId){
                                $indMuestra = 0;
                            }
                        }else{
                            if($value == $wallet->TypeTransactionId){
                                $indMuestra = 0;
                            }
                        }
                        // echo 'aqui2->' . $wallet->TypeTransactionId . ' ' . $wallet->TypeTransaccionName . ' value->' . $value;
                        // echo '<br>';
                    }
                    // dd('termina con muestra ->' . $indMuestra);
                @endphp
                    
                @if($indMuestra==0) 
                    @continue
                @endif
                @if($myWallet == 0)
                    <div class="page-break">
                    </div>
                @endif
                <div class ="row mb-4" style="background-color: white;  data-id="{{$wallet->TypeTransactionId}}">
                    <h3>{{ $wallet->TypeTransaccionName}}</h3>      
                    <div class="col-12 col-md-6" style="float:left;">
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

                    <!-- <div class="col-12 col-md-6" style="position: fixed; left: 350px; max-height: 100px; height: 100px"> -->
                    <div class="" style="float: right;">                    
                        <table class="table thead-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="3">
                                        {{ $wallet->TypeTransaccionName}}
                                    </th>
                                </tr>
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
            @endforeach
        </div>           
    @endif
</div>


@section('js')


<script>

    const miWallet = {{ $myWallet }};

    // BuscaWallet(miWallet);

    const miTypeTransaction= {!! $myTypeTransaction !!};

    // BuscaTransaccion(miTypeTransaction);

    @php

        


        // dd(' myocultarresumengeneral -> ' . $myocultarresumengeneral . ' myocultarresumentransaccion -> ' . $myocultarresumentransaccion . ' mytransactions -> ' . print_r($mytransactions,true) );
        // dd(json_encode($myocultarresumentransaccion));
        //dd(json_encode($myocultarresumengeneral));
        //dd(json_encode($mytransactions));
        
    @endphp
    
    // alert('aqui');
    
    $(() => {

        let  myFechaDesde   = {!! $myFechaDesde !!};
        
        const myFechaHasta  = {!! $myFechaHasta !!};

        
        if (!miWallet){
            // alert ('aqui');
            calculoGeneral3();
            calculos3();
        }else{
            calculoGeneral2();
            calculos2();
        }
        
        aplicaFiltros();

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
                    <div class ="row mb-4" style="background-color: white;" data-id="{{$wallet->TypeTransactionId}}">
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
                            <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
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

            {{-- dd($balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}

            <div class ="row mb-4" style="background-color: white;" data-wallet="{{$wallet2->WalletId}}">
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:1%;">Saldo Total</th>
                                <th style="width:1%;">{{ number_format($balance,2) }}</th>
                                <th style="width:1%;"></th>
                                <th style="width:1%;">Saldo al corte</th>
                                <th style="width:1%;">{{ number_format($balanceDetail,2) }}</th>
                            </tr>
                            <tr>
                                <th style="width:1%;">Transacción</th>
                                <th style="width:1%;">Cant transacción</th>
                                <th style="width:1%;">Entradas</th>
                                <th style="width:1%;">Salidas</th>
                                <th style="width:1%;">Saldo</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalCreditos  = 0;
                            $totalDebitos   = 0;

                            $saldo = 0;
                        @endphp
                        {{-- dd($wallet_summary) --}}
                        @foreach($wallet_summary as $wallet2)

                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{$wallet2->WalletId}}, {{$wallet2->TypeTransactionId}})">


                                @php
                                    $myTransaction  = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")
                                        
                                        <td>{{ $wallet2->TypeTransaccionName}}</td>
                                        <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td>{{ ' ' }}</td>
                                        <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        <td>{{ ' ' }}</td>                                    
                                        @php
                                            $cantDebitos ++;
                                            $totalDebitos += $wallet2->total_amount;                                        
                                        @endphp
                                        @break

                                    //
                                    // credito
                                    // suma
                                    //
                                    @case("Credito")
                                        @php
                                            $cantCreditos ++;
                                            $totalCreditos += $wallet2->total_amount;
                                        @endphp                                                
                                        
                                        <td>{{ $wallet2->TypeTransaccionName}}</td>
                                        <td>{{ number_format($wallet2->cant_transactions) }}</td>
                                        <td>{{ number_format($wallet2->total_amount,2)}}</td>
                                        <td>{{ ' ' }}</td>
                                        <td>{{ ' ' }}</td>

                                        @break
                                @endswitch

                            </tr>
                        @endforeach
                        @php
                            $myBalance = $balanceDetail + ($totalCreditos - $totalDebitos);
                        @endphp
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ number_format($totalCreditos,2) }}</td>
                            <td >{{ number_format($totalDebitos,2)}}</td>
                            <td>{{  number_format($totalCreditos - $totalDebitos,2) }}</td>
                        </tr>
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ 'Saldo al dia '}}</td>
                            <td>{{  number_format($myBalance,2) }}</td>
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
                                <th style="width:1%;">Entradas</th>
                                <th style="width:1%;">Salidas</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalCreditos  = 0;
                            $totalDebitos   = 0;
                        @endphp
                        @foreach($transaction_summary as $wallet2)
                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{0}}, {{$wallet2->TypeTransactionId}})">




                                @php
                                    $myTransaction  = $myClass->getCreditDebitWallet($wallet2->TypeTransactionId);
                                @endphp

                                @switch($myTransaction)
                                    //
                                    // debito
                                    // resta
                                    //
                                    @case("Debito")
                                        
                                        @if($wallet2->TypeTransactionId == $myTypeTransaction )
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{  ' ' }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                        @else
                                            <td                                                 >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td                                                 >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td                                                 >{{  ' ' }}</td>
                                            <td class="font-weight-bold" style="color: green;"  >{{ number_format($wallet2->total_amount,2)}}</td>
                                        @endif
                                        @php
                                            $cantDebitos ++;
                                            $totalDebitos += $wallet2->total_amount;
                                        @endphp
                                        @break
                                    
                                    @case("Credito")
                                        @if($wallet2->TypeTransactionId == $myTypeTransaction )
                                            <td class="font-weight-bold" style="color: green;">{{ $wallet2->TypeTransaccionName}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ number_format($wallet2->total_amount,2)}}</td>
                                            <td class="font-weight-bold" style="color: green;">{{ ' ' }}</td>
                                        @else
                                            <td                                                 >{{ $wallet2->TypeTransaccionName}}</td>
                                            <td                                                 >{{ number_format($wallet2->cant_transactions) }}</td>
                                            <td                                                 >{{ number_format($wallet2->total_amount,2)}}</td>
                                            <td class="font-weight-bold" style="color: green;"  >{{ ' ' }}</td>
                                        @endif
                                        @php
                                            $cantCreditos ++;
                                            $totalCreditos += $wallet2->total_amount;
                                        @endphp
                                        @break
                                @endswitch


                            </tr>
                        @endforeach
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ ' ' }}</td>
                            <td >{{ number_format($totalCreditos,2) }}</td>
                            <td >{{ number_format($totalDebitos,2)}}</td>
                        </tr>
                    </table>
                </div>


            </div>
        `;
        $("#myCanvasGeneral").append(myElement);

    }



    function aplicaFiltros(){


        $myocultarresumengeneral        = $myData['ocultarresumengeneral'];
        $myocultarresumentransaccion    = $myData['ocultarresumentransaccion'];
        $mytransactions                 = $myData['transactions'];



        $('#myCanvasGeneral').attr("hidden",false);
        $('#myCanvas').attr("hidden",false);



        @if($myocultarresumengeneral)
            
            $('#myCanvasGeneral').attr("hidden",true);
            
        @endif

        @if($myocultarresumentransaccion)
            $('#myCanvas').attr("hidden",true);
        @endif

            
        // alert('aqui');
        $("#myCanvas div").each(function(){
            $(this).removeAttr("hidden");
        });

        @foreach($mytransactions as $value)
                
            seleccionado = "{{$value}}";

            $("#myCanvas div").each(function(){
                if($(this).data("id")){
                                            
                    if ($(this).data("id") == seleccionado){
                        
                        $(this).attr("hidden",true);
                    }
                }
            });

        @endforeach

    }


</script>

@endsection
</main>
</body>
</html>