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

<div class="container justify-content-center" style="display: contents;">

    <div class="row col-12 col-md-12 justify-content-center text-center align-items-center" style="min-height: 5rem !important">
        <h4>Detalle de comisiones USDT</h4>
    </div>
    
    <div class="card">
        <div class="card-header">
            <div class="row">
                {{--
                <div class="col-12 col-lg-3">
                    <x-adminlte-select2 id="wallet"
                    name="optionsWallets"
                    
                    label-class="text-lightblue"
                    data-placeholder="Seleccione una caja Proveedor"

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
                --}}

                <div class="col-12 col-lg-3">
                    <x-adminlte-select2 id="wallet2"
                    name="optionsWallets2"
                    
                    label-class="text-lightblue"
                    data-placeholder="Seleccione una caja USDT"

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

                <div class="col-12 col-lg-3">
                    <x-adminlte-select2 
                        id="grupo"
                        name="optionsGroups"
                        label-class="text-lightblue"
                        data-placeholder="Seleccione Grupo"
                        :config="$config4"
                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-light">
                            <i class="fas fa-box"></i>
                        </div>
                    </x-slot>
                    <x-adminlte-options :options="$grupo" empty-option="Grupo.."/>
                    </x-adminlte-select2>
                </div>

                {{--
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
                --}}


                <div class ="col-12 col-lg-3">
                    <x-adminlte-date-range
                        name="drCustomRanges"
                        enable-default-ranges="Last 30 Days"
                        
                        :config="$config3">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-light">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button 
                                id="myDrClearButton"
                                label="X" 
                                icon="fas  fa-x"/>
                        </x-slot>
                    </x-adminlte-date-range>


                </div>

                <div class ="col-12 col-lg-3">
                    <div class="row">
                        <button 
                            class="btn btn-primary"             
                            type="buttom"          
                            onclick="theRoute();" >
                            <i class="fas fa-broom"></i>
                        </button>
                        <button class="btn btn-primary imprimir"  id="myBtnImprimir"    type="buttom" disabled                                  ><i class="fas fa-print"></i></button>
                        <button class="btn btn-success"           id="myBtnExcel"       type="buttom" disabled onclick="exportaEstadisticas();" ><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-danger"            id="myBtnPDF"         type="buttom" disabled onclick="exportaEstadisticasPDF();"><i class="fas fa-file-pdf"></i></button>
                    </div>
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
                id="nav-recarga-tab" 
                data-toggle="tab" 
                data-target="#nav-recarga" 
                type="button" 
                role="tab" 
                aria-controls="nav-recarga" 
                aria-selected="true">
                Recarga
            </button>
                {{--
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
                    --}}
        </div>
    </nav>

    <br>
    <br>


    <div class="tab-content" id="nav-tabContent">

        {{-- Estadisticas --}}

        <div class="tab-pane fade show active" id="nav-home"    role="tabpanel"     aria-labelledby="nav-home-tab">

            <div id="myCanvasGeneral"></div>

            <div id="myCanvas"></div>

        </div>

        {{-- Recargas --}}

        <div class="tab-pane fade"              id="nav-recarga" role="tabpanel"    aria-labelledby="nav-recarga-tab">

            <div id="myCanvasGeneralRecarga"></div>

            <div id="myCanvasRecarga"></div>

        </div>
        {{-- Filtros --}}
                    {{--
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Filtros

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros  Generales</h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <label for="ResumenGeneral">Ocultar resumen general caja primaria:</label>
                            <input type="checkbox" id="ResumenGeneral" name="ResumenGeneral"><br><br>
                        </div>  

                    </div>     


                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <label for="ResumenTransaccion">Ocultar resumen por caja secundaria:</label>
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
        --}}
    </div>
</div>

@endsection
@section('js')


<script>
    
    const miWallet          = {!! $myWallet !!};
    const miGrupo           = {!! $myGrupo !!};

    BuscaWallet(miWallet);
    BuscaGrupo(miGrupo);

    @php

        $myData                         = $myClass->filtrosLeeComisionesGrupo();

        $myocultarresumengeneral        = $myData['ocultarresumengeneral'];
        $myocultarresumentransaccion    = $myData['ocultarresumentransaccion'];
        $mytransactions                 = $myData['transactions'];
        
        $myocultarresumengeneral        = (!$myocultarresumengeneral)       ? 0 : $myocultarresumengeneral;
        $myocultarresumentransaccion    = (!$myocultarresumentransaccion)   ? 0 : $myocultarresumentransaccion;

    @endphp


    $(() => {

        const myFechaDesde = {!! substr($myFechaDesde,0,4) !!} + '-' + {!! substr($myFechaDesde,5,2) !!} + '-' + {!! substr($myFechaDesde,8,2) !!} ;
        const myFechaHasta = {!! substr($myFechaHasta,0,4) !!} + '-' + {!! substr($myFechaHasta,5,2) !!} + '-' + {!! substr($myFechaHasta,8,2) !!} ;

        //
        
        console.log('myFechaDesde ->  {{ $myFechaDesde }}'); 
        console.log('myFechaDesde -> ' + myFechaDesde);
        console.log('myFechaHasta -> ' + myFechaHasta);

        InicializaFechas();

        BuscaFechas(myFechaDesde, myFechaHasta);

        $('#wallet2').on('change', function (){

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

            const wallet        = $('#wallet2').val()   == "" ? 0 : $('#wallet2').val();
            const grupo         = $('#grupo').val()     == "" ? 0 : $('#grupo').val();

             theRoute(wallet, grupo, myFechaDesde,myFechaHasta);

        });

        $('#grupo').on('change', function (){
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

            const wallet        = $('#wallet2').val()   == "" ? 0 : $('#wallet2').val();
            const grupo         = $('#grupo').val()     == "" ? 0 : $('#grupo').val();

             theRoute(wallet, grupo, myFechaDesde,myFechaHasta);

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

                
                const wallet       = $('#wallet2').val();
                const grupo         = $('#grupo').val()     == "" ? 0 : $('#grupo').val();
                const transaccion   = $('#typeTransactions').val();
                theRoute(wallet, grupo, myFechaDesde,myFechaHasta);

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

        // cargaTransacciones();

        if (miWallet !=0 ){
            calculoRecargas();
            calculoTransacciones();
            @if(count($Transacciones))
                toggleBotones();
            @endif
        }else{
            pantallaInicial();
        }
        leeFiltros();  
        aplicaFiltros();      


        $('#myDrClearButton').on('click', function (){
            const wallet       = $('#wallet2').val() == "" ? 0 : $('#wallet2').val();
            theRoute(wallet);       
        });

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


    function pantallaInicial(){
        let myElement =`
            <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                <h3>Seleccione criterio de busqueda</h3>
            </div>        
        `;
        $("#myCanvasGeneralRecarga").append(myElement);


        $("#myCanvasGeneral").append(myElement);

    }

    /*
    *
    *   calculoRecargas
    *   resumen general por wallet
    *   muestra recargas
    * 
    */
    function calculoRecargas(myFechaDesde = "", myFechaHasta =""){
        
        myElement =
        `
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
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th class=""  style="width: 25% !important;">Wallet</th>
                                <th class="myWidth2"  style="width: 5% !important;">Id</th>
                                <th class="myWidth2"                         >Transacción</th>
                                <th class="myWidth2"                         >Grupo</th>                                
                                <th class="myWidth2"                         >Monto</th>
                                <th class=""    style="width:30% !important;">Fecha</th>
                                <th class="myTdColor2 myWidth2" >Porcentaje comision base</th>
                                <th class="myTdColor3 myWidth2" >Monto comision base</th>
                                <th class="myTdColor6 myWidth2" >Totasl monto</th>
                                <th></th>
                            </tr>
                        </thead>
                        @php
                            $cant                    = 0;

                            $totalComision           = 0;
                            $totalComisionBase       = 0;
                            $totalComisionExchange   = 0;
                            $totalComisionGanancia   = 0;
                            $totalComisionGanancia2  = 0;


                            $myFechaDesdeDate = Date($myFechaDesde);
                            $myFechaHastaDate = Date($myFechaHasta);

                        @endphp
                        @if(count($Recargas)>0)
                        @foreach($Recargas as $wallet2)
                            


                            <tr class="myTr">

                                @php
                                    
                                    
                                    $totalComision                  +=  0;
                                    $totalComisionBase              +=  0;
                                    $totalComisionExchange          +=  0;
                                    $totalComisionGanancia          +=  0;
                                    $totalComisionGanancia2         +=  0;

                                    $cant                           += 0;

                                    $myCantGeneral                  += 0;
                                    $totalComisionGeneral           += 0;
                                    $totalComisionBaseGeneral       += 0;
                                    $totalComisionExchangeGeneral   += 0;
                                    $totalComisionGananciaGeneral   += 0;
                                    $totalComisionGanancia2General  += 0;  
                                    
                                    $myDate = date_create($wallet2->TransactionDate);

                                    $myDate2 = Date(substr($wallet2->TransactionDate,0,10));
                                    $myContinue = 0;
                                    // 
                                    // Filtra transacciones
                                    //
                                    foreach($Transacciones as $myTransaccion){

                                        $myDateTransaccion = Date(substr($myTransaccion->TransactionDate,0,10));
                                        
                                        
                                        if ($myDateTransaccion >= $myFechaDesdeDate && $myDateTransaccion <= $myFechaHastaDate) {                            
                                            // preguntar si la recarga esta en ese rango
                                            if ($myTransaccion->RecargaId == $wallet2->Id) {
                                                $myContinue = 1;
                                                break;
                                            }
                                        }
                                    
                                    };
                                   

                                @endphp
                                @if($myContinue == 0)
                                   @continue;
                                @endif
                                <td>{{ $wallet2->WalletName}}</td>                               
                                <td>{{ $wallet2->Id}}</td>       
                                <td>{{ $wallet2->TypeTransactionName}}</td>
                                <td>{{ $wallet2->GroupName}}</td>
                                <td>{{ number_format($wallet2->Amount ,2) }}</td>
                                <td>{{ date_format($myDate, "d/m/Y H:i:s") }}</td>
                                <td>{{ number_format($wallet2->PercentageBase ,2) }}</td>
                                <td>{{ number_format($wallet2->AmountCommissionBase,2) }}</td>
                                <td>{{ number_format($wallet2->AmountTotalBase,2) }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $wallet2->Id) }}" 
                                        class="btn btn-xs text-dark shadow text-center">
                                        <i class="fas fa-eye" style="color: green;"></i>
                                    </a>
                                </td>                                
                            </tr>
                        @endforeach

                        <tr style="background-color: black; color:white;">
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td class="myTdColor2"  ></td>
                            <td class="myTdColor3"  ></td>
                            <td class="myTdColor6"  ></td>                                
                            <td></td>
                        </tr>
                        @else
                            <tr class="myTr"">
                                <td colspan="16">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>  
                        @endif
                    </table>
                </div>

            </div>
        `;
    
        $("#myCanvasGeneralRecarga").append(myElement);

    }

    
    /*
    *
    *
    *  calculoTransacciones
    *  resumen general por wallet
    *
    */
    function calculoTransacciones(){
 
    myElement =
        `
        <style>
            .myTr {
                cursor: pointer;
            }
            .myTr:hover{
                background-color: #D7DBDD  !important;
            }
            .myWidth22{
                    width: 12%;
                    min-width: 12%;
                    max-width: 12%;
                }            
        </style>

        {{-- dd($balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}
                
        <div class ="row mb-4" style="background-color: white;" data-wallet="">
            <div class="col-12 col-md-12">
                <table class="table thead-light" style="background-color: white;">
                    <thead class="thead-dark">
                        <tr>
                            <th class="" style="width: 100px;">Id</th>                        
                            <th class="myWidth22"             >Wallet</th>
                            <th class="myWidth22"             >Transacción</th>
                            <th class="myWidth22"             >Grupo</th>                                
                            <th class="" style="width: 30%"   >Fecha</th>
                            <th class="myTdColor2 myWidth22"  >Monto</th>                            
                            <th class="myTdColor2 myWidth22"  >Monto 2</th>   
                            <th class="myTdColor2 "           >Porce Comision</th>
                            <th class="myTdColor2 myWidth22"  >Mto Comision</th>
                            <th class="myTdColor3 myWidth22"  >Porc Comision Base</th>
                            <th class="myTdColor3 myWidth22"  >Mto Comision Base</th>
                            <th class="myTdColor3 myWidth22"  >Comision Ganancia</th>                            
                            <th class="myTdColor5 myWidth22"  >Recarga ID</th>
                            <th class="myTdColor5 myWidth22"  >Recarga Monto</th>
                            <th class="myTdColor5 myWidth22"  >Porc Base</th>
                            <th class="myTdColor5 myWidth22"  >Recarga Saldo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $cant                    = 0;

                        $totalComision           = 0;
                        $totalComisionBase       = 0;
                        $totalComisionGanancia   = 0;
            
                        $myFechaDesdeDate = Date($myFechaDesde);
                        $myFechaHastaDate = Date($myFechaHasta);

                         // dd($myFechaDesdeDate);
                         // dd($myFechaHastaDate);
                         
                         $Recargas2= [];
                    @endphp
                    
                    @if(count($Transacciones)>0)
                        @foreach($Transacciones as $wallet2)
                            @php 
                                    $myDate = new DateTime($wallet2->TransactionDate);

                                    $myDate2 = Date(substr($wallet2->TransactionDate,0,10));

                                    // dd($myDate);

                                    //
                                    // filtra
                                    //
                                    $myContinue = 0;
                                    if ($myDate2 >= $myFechaDesdeDate && $myDate2 <= $myFechaHastaDate) {                                    
                                        $myContinue = 1;
                                        
                                        // \Log::info("leam - myDate -> " . print_r($myDate2, true) . " - myFechaDesdeDate -> " . print_r($myFechaDesdeDate,true) . " - myFechaHastaDate -> " . print_r($myFechaHastaDate,true) . " - continue ->" . $myContinue);

                                        if ($myGrupo == 0) {
                                            $myContinue = 1;
                                        }else{
                                            if ($myGrupo == $wallet2->GroupId){
                                                $myContinue = 1;
                                            }else{
                                                $myContinue = 0;
                                            }
                                        }
                                    }                                    
                            @endphp
                            @if($myContinue == 0)
                                    @continue
                            @endif
                            <tr class="myTr">
                                @php

                                    $my_total_commission_profit     =   0;

                                    $totalComision                  +=  $wallet2->AmountCommission ;
                                    $totalComisionBase              +=  $wallet2->AmountCommissionBase;
                                    $totalComisionGanancia          +=  $wallet2->AmountCommissionProfit;   

                                    $cant                           += 1;
                                @endphp

                                <td class="myWidth22"   >{{ $wallet2->Id}}</td>   
                                <td class="myWidth22"   >{{ $wallet2->WalletName}}</td>                               
                                <td class="myWidth22"   >{{ $wallet2->TypeTransactionName}}</td>
                                <td class="myWidth22"   >{{ $wallet2->GroupName}}</td>
                                <td class="myWidth22"   >{{ date_format($myDate, "d/m/Y H:i:s") }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount,2) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount2,2) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Percentage  ,2) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->AmountCommission ,2) }}</td>
                                <td                     >{{ number_format($wallet2->PercentageBase,2) }}</td> 
                                <td class="myWidth22"   >{{ number_format($wallet2->AmountCommissionBase,2) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->AmountCommissionProfit,2) }}</td>
                                <td class="myWidth22"   >{{ $wallet2->RecargaId }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->RecargaAmount,2) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->RecargaPercentageBase,2) }}</td>                                                                                    
                                <td class="myWidth22"   >{{ number_format($wallet2->RecargaSaldo,2) }}</td>    
                                <td>
                                    <a 
                                        href="{{ route('transactions.show', $wallet2->Id) }}" 
                                        class="btn btn-xs text-dark shadow text-center">
                                        <i class="fas fa-eye" style="color: blue;"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('transactions.show', $wallet2->RecargaId) }}" 
                                        class="btn btn-xs text-dark shadow text-center">
                                        <i class="fas fa-eye" style="color: green;"></i>
                                    </a>
                                </td>

                            </tr>
                            

                        @endforeach

                        <tr style="background-color: black; color:white;">
                            <td                     ></td>                    
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td class="myTdColor2"  ></td>
                            <td class="myTdColor2"  ></td>
                            <td class="myTdColor2"  ></td>
                            <td class="myTdColor2"  >{{ number_format($totalComision,2) }}</td>                            
                            <td class="myTdColor3"  ></td>                                
                            <td class="myTdColor3"  >{{ number_format($totalComisionBase,2) }}</td>                                
                            <td class="myTdColor3"  >{{ number_format($totalComisionGanancia,2) }}</td>                                
                            <td class="myTdColor5"  ></td>                                
                            <td class="myTdColor5"  ></td>                                
                            <td class="myTdColor5"  ></td>                                                                                                                                                        
                            <td class="myTdColor5"  ></td>        
                            <td class=""  ></td>     
                            <td class=""  ></td>     
                        </tr>

                    
                        @if($cant == 0)
                            <tr class="myTr"">
                                <td colspan="16">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>                    
                        @endif

                    @else
                        <tr class="myTr"">
                            <td colspan="16">
                                <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                    <h3>Sin transacciones registradas</h3>
                                </div>
                            </td>
                        </tr>
                    @endif

                </table>
            </div>
            
        </div>
        `;

        $("#myCanvasGeneral").append(myElement);

    }

    function theRoute(wallet = '', grupo = 0, fechaDesde = '', fechaHasta = ''){

        let myRoute = "";

        myRoute = "{{ route('dashboardComisionesGrupo2', ['wallet' => 'wallet2' , 'grupo' => 'grupo2' ,'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
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

    function BuscaWallet(miWallet){
        if (miWallet===0){
            return;
        }
        
        $('#wallet2').each( function(index, element){

            $(this).children("option").each(function(){
                
                if ($(this).val() === miWallet.toString()){

                    $("#wallet2 option[value="+ miWallet +"]").attr("selected",true);
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

        // alert(myArray);
        console.log('myArray ->' + myArray + ' length ->' + myArray.length);
        // alert('length ->' + myArray.length);

        if (myArray.length > 5){
            FechaDesde = myArray[6];
            FechaHasta = myArray[7];
        }else{
            FechaDesde = '2001-01-01';
            FechaHasta = '9999-12-31';
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
                url: "{{route('filtrosGrabaComisionesGrupo')}}",
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

        let myocultarresumengeneral     = "{{ ($myocultarresumengeneral) ? true : false  }}" ? true : false;
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

    function toggleBotones(){
        
        $('#myBtnImprimir').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
        $('#myBtnExcel').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
        $('#myBtnPDF').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)


    }
    function BuscaGrupo(miGrupo = ""){

        if (miGrupo == "") return;

        $('#grupo').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miGrupo.toString()){   
                    $("#grupo option[value="+ miGrupo +"]").attr("selected",true);
                }
            });
        });
    }

</script>

@endsection
