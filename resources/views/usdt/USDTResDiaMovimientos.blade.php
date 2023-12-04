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
        <h4>Cuadro de Movimientos USDT</h4>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">

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
                {{--
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
                --}}
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
            {{--
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
            --}}
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
                    
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Filtros


        <div class="card mb-4">
                <div class="card-header" style="background-color: #2874A6; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Entradas USDT</h3>
                </div>
                <div class="card-body">    

                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Grupo</label>
                                <input type="text" id="entrada1" size=20/>
                            </div>
                            <select multiple="multiple" id="my-select1" name="my-select[]">
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


            <div class="card mb-4">
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo A </h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Grupo</label>
                                <input type="text" id="salida1" size=20/>
                            </div>                            
                            <select multiple="multiple" id="my-select2" name="my-select[]">
                            </select>   
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
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo B </h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Grupo</label>
                                <input type="text" id="salida2" size=20/>
                            </div>                            
                            <select multiple="multiple" id="my-select3" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     
                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar3" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar3" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo C </h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Grupo</label>
                                <input type="text" id="salida3" size=20/>
                            </div>                            
                            <select multiple="multiple" id="my-select4" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     
                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar4" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar4" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
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

        InicializaMultiselects();
        leeFiltros();  
        // grabaFiltros();

        // cargaTransacciones();

        if (miWallet !=0 ){

            calculoCuadroGeneral();

            calculaEntradaHeader();
            calculoRecargas();
            
            calculoTransacciones();
            calculaEntradaFooter();
            
            calculaSalidaHeader();
            calculoTransaccionesSalida();
            calculoTransaccionesSalidaOperaciones();
            calculoTransaccionesSalidaGastos();
            calculaSalidaFooter();

            @if(count($transaccionesGrupoComision))
                toggleBotones();
            @endif
        }else{
            pantallaInicial();
        }


        // aplicaFiltros();      


        $('#myDrClearButton').on('click', function (){
            const wallet       = $('#wallet2').val() == "" ? 0 : $('#wallet2').val();
            theRoute(wallet);       
        });





        $('#myButtonLimpiar').on('click', function (){
            
            $('#my-select1').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar2').on('click', function (){

            $('#my-select2').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar3').on('click', function (){

            $('#my-select3').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar4').on('click', function (){

            $('#my-select4').multiSelect('deselect_all');

        });

        $('#myButtonAplicar, #myButtonAplicar2, #myButtonAplicar3, #myButtonAplicar4').on('click', function (){
            
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
                timerProgressBar: true,
                timer: 3000
                });

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

    });
    
    $( document ).ready(function() {

    });
    


    
    function InicializaMultiselects(){
        $('#my-select1').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'></i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles 
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'>  </i>
                                    </div>
                                </div>`
        });

        $('#my-select2').multiSelect({
            selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>                                    
                                </div>`,
            selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>                                    
                                </div>`
        });
        $('#my-select3').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'></i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles 
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'>  </i>
                                    </div>
                                </div>`
        });

        $('#my-select4').multiSelect({
            selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>                                    
                                </div>`,
            selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>                                    
                                </div>`
        });      

        @foreach($grupo as $key => $group2)
            // console.log('el grupo con key {!! $key !!} es {!! $group2 !!}');
            $('#my-select1').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select2').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select3').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select4').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });

        @endforeach

    }


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
    *   calculoCuadroGeneral
    *   resumen general por wallet
    *   muestra recargas
    * 
    */
   
    function calculoCuadroGeneral(myFechaDesde = "", myFechaHasta =""){
        
        @php
        
        $entradasUSDTCant       = 0;
        $entradasUSDTMonto      = 0;

        $comisionUSDTCant       = 0;
        $comisionUSDTMonto      = 0;

        $totalEntradasUSDTCant  = 0;
        $totalEntradasUSDTMonto = 0;

        $salidasUSDTCant        = 0;
        $salidasUSDTMonto       = 0;

        $operacionesUSDTCant    = 0;
        $operacionesUSDTMonto   = 0;

        $variosUSDTCant         = 0;
        $variosUSDTMonto        = 0;

        $totalSalidasUSDTCant  = 0;
        $totalSalidasUSDTMonto = 0;


        
        foreach($RecargasWallet as $wallet2){
            $entradasUSDTCant       += $wallet2->Cant;
            $entradasUSDTMonto      += $wallet2->Amount;

            $totalEntradasUSDTCant  += $wallet2->Cant;
            $totalEntradasUSDTMonto += $wallet2->Amount;            
        }

        foreach($transaccionesGrupoComision as $wallet2){
            $comisionUSDTCant       += $wallet2->Cant;
            $comisionUSDTMonto      += $wallet2->Amount;

            $totalEntradasUSDTCant  += $wallet2->Cant;
            $totalEntradasUSDTMonto += $wallet2->Amount;            
        }


        foreach($transaccionesGrupoSalida as $wallet2){
            $salidasUSDTCant       += $wallet2->Cant;
            $salidasUSDTMonto      += $wallet2->Amount;

            $totalSalidasUSDTCant  += $wallet2->Cant;
            $totalSalidasUSDTMonto += $wallet2->Amount;            
        }

        foreach($transaccionesGrupoSalida2 as $wallet2){
            $operacionesUSDTCant       += $wallet2->Cant;
            $operacionesUSDTMonto      += $wallet2->Amount;

            $totalSalidasUSDTCant  += $wallet2->Cant;
            $totalSalidasUSDTMonto += $wallet2->Amount;            
        }

        foreach($transaccionesGrupoSalida3 as $wallet2){
            $variosUSDTCant       += $wallet2->Cant;
            $variosUSDTMonto      += $wallet2->Amount;

            $totalSalidasUSDTCant  += $wallet2->Cant;
            $totalSalidasUSDTMonto += $wallet2->Amount;            
        }

        // $totalSalidasUSDTCant  += $wallet2->Cant;
        $totalPendienteUSDTMonto  = ($balanceBefore + $totalEntradasUSDTMonto) - $totalSalidasUSDTMonto;

        @endphp

        let myTitleEntrada = $('#entrada1').val();
        let myTitleSalida1 = $('#salida1').val();
        let myTitleSalida2 = $('#salida2').val();
        let myTitleSalida3 = $('#salida3').val();

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
  
            <div class ="row" style="background-color: white; margin-bottom: 6.5rem !important" data-wallet="">
                <div class="col-12 text-center">
                    <h3>Cuadro Movimiento General  USDT</h3>
                </div>            
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">

                        <tr style="height: 30px; background-color: black; color: white;">
                            <td>Saldo Anterior</td>
                            <td></td>
                            <td>{{ number_format($balanceBefore ,2) }}</td>
                        </tr>

                        <tr style="height: 30px;">
                        </tr>

                        <tr class="myTr" style="background-color: silver; color: black;">
                            <td>Entradas USDT</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr class="myTr">
                            <td>Entradas USDT  </td>
                            <td>{{ number_format($entradasUSDTCant) }}</td>
                            <td>{{ number_format($entradasUSDTMonto ,2) }}</td>
                        </tr>

                        <tr class="myTr">
                            <td>${myTitleEntrada}</td>
                            <td>{{ number_format($comisionUSDTCant) }}</td>
                            <td>{{ number_format($comisionUSDTMonto ,2) }}</td>
                        </tr>

                        <tr class="myTr" style="background-color: silver; color: black;">
                            <td>Total Entradas USDT</td>
                            <td>{{ number_format($totalEntradasUSDTCant) }}</td>
                            <td>{{ number_format($totalEntradasUSDTMonto ,2) }}</td>
                        </tr>




                        <tr style="height: 30px;">
                        </tr>

                        <tr class="myTr" style="background-color: silver; color: black;">
                            <td>Salidas USDT</td>
                            <td></td>
                            <td></td>
                        </tr>



                        <tr class="myTr">
                            <td>${myTitleSalida1}</td>
                            <td>{{ number_format($salidasUSDTCant) }}</td>
                            <td>{{ number_format($salidasUSDTMonto ,2) }}</td>
                        </tr>

                        <tr class="myTr">
                            <td>${myTitleSalida2}</td>
                            <td>{{ number_format($operacionesUSDTCant) }}</td>
                            <td>{{ number_format($operacionesUSDTMonto ,2) }}</td>
                        </tr>

                        <tr class="myTr">
                            <td>${myTitleSalida3}</td>
                            <td>{{ number_format($variosUSDTCant) }}</td>
                            <td>{{ number_format($variosUSDTMonto ,2) }}</td>
                        </tr>

                        <tr class="myTr" style="background-color: silver; color: black;">
                            <td>Total Salidas USDT</td>
                            <td>{{ number_format($totalSalidasUSDTCant) }}</td>
                            <td>{{ number_format($totalSalidasUSDTMonto ,2) }}</td>
                        </tr>

                        <tr style="height: 30px;">
                        </tr>

                        <tr style="height: 30px; background-color: black; color: white;">
                            <td>Saldo Pendiente</td>
                            <td></td>
                            <td>{{ number_format($totalPendienteUSDTMonto ,2) }}</td>
                        </tr>

                    </table>
                </div>

            </div>
        `;


        $("#myCanvasGeneral").append(myElement);
        // $("#myCanvasGeneralRecarga").append(myElement);
        
    }
	
	    

    function calculaEntradaHeader(){


        myElement =
        `

        <div class ="row mb-4" style="background-color: white;" data-wallet="">
            <div class="col-12 text-center" style="background-color: #2874A6; color: white">
                <h3>Entradas USDT</h3>
            </div>
        </div>
        `;

        $("#myCanvasGeneral").append(myElement);
    }

    function calculaEntradaFooter(){
        
        @php
            foreach($RecargasWallet as $wallet2){
                $entradaCant    += $wallet2->Cant;
                $entradaMonto   += $wallet2->Amount;
            }
            foreach($transaccionesGrupoComision as $wallet2){
                $entradaCant    += $wallet2->Cant;
                $entradaMonto   += $wallet2->Amount;
            }            
        @endphp

        myElement =
        `
        <div class ="row" style="margin-bottom: 6.5rem !important;">
            <div class="col-12 text-center" style="background-color: #2874A6; color: white">
                <table class="table">
                    <tr style="background-color: #2874A6; color: white">
                        <td style="width: 20% !important;"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2 text-left">{{number_format($entradaCant)}}</td>                                    
                        <td class="myWidth2 text-left" style="padding-left: 0;">{{number_format($entradaMonto)}}</td>
                        <td class="myWidth2"></td>                                
                    </tr>
                </table>
            </div>
        </div>
        `;



        $("#myCanvasGeneral").append(myElement);
    }

    function calculaSalidaHeader(){
        myElement =
        `

        <div class ="row mb-4" style="background-color: white;" data-wallet="">
            <div class="col-12 text-center" style="background-color: #BB8FCE; color: white">
                <h3>Salidas USDT</h3>
            </div>
        </div>
        `;

        $("#myCanvasGeneral").append(myElement);
    }


    function calculaSalidaFooter(){
        
        @php
            foreach($RecargasWallet as $wallet2){
                $entradaCant    += $wallet2->Cant;
                $entradaMonto   += $wallet2->Amount;
            }
            foreach($transaccionesGrupoComision as $wallet2){
                $entradaCant    += $wallet2->Cant;
                $entradaMonto   += $wallet2->Amount;
            }            
        @endphp

        myElement =
        `
        <div class ="row mb-4">
            <div class="col-12 text-center" style="background-color: #BB8FCE; color: white">
                <table class="table">
                    <tr style="background-color: #BB8FCE; color: white">
                        <td style="width: 20% !important;"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2"></td>
                        <td class="myWidth2 text-left">{{number_format($entradaCant)}}</td>                                    
                        <td class="myWidth2 text-left" style="padding-left: 0;">{{number_format($entradaMonto)}}</td>
                        <td class="myWidth2"></td>                                
                    </tr>
                </table>
            </div>
        </div>
        `;



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
                <div class="col-12 text-center">
                    <h3>Entradas USDT</h3>
                </div>            
                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th class=""          style="width: 25% !important;">Wallet</th>
                                <th class="myWidth2"                                >Grupo ID</th>                                
                                <th class="myWidth2"                                >Grupo</th>
                                <th class="myWidth2"                                >Transaccion</th>                                
                                <th class="myWidth2"                                >Cant</th>
                                <th class="myWidth2"                                >Monto</th>
                                <th></th>
                            </tr>
                        </thead>
                        @php
                            $cant                    = 0;
                            $total                   = 0;

                            $myFechaDesdeDate = Date($myFechaDesde);
                            $myFechaHastaDate = Date($myFechaHasta);

                            $entradaCant    = 0;
                            $entradaMonto   = 0;

                        @endphp
                        @if(count($RecargasWallet)>0)
                            @foreach($RecargasWallet as $wallet2)
                                
                                <tr class="myTr">

                                    @php
                                        
                                        
                                        $total                          = 0;
                                        $cant                           = 0;
                                        $myCantGeneral                  = 0;
                                        $myTotaslGeneral                = 0;

                                        $myContinue                     = 1;
    
                                        $entradaCant    += $wallet2->Cant;
                                        $entradaMonto   += $wallet2->Amount ;

                                    @endphp
                                    @if($myContinue == 0)
                                    @continue;
                                    @endif
                                    <td>{{ $wallet2->WalletName}}</td>
                                    <td>{{ $wallet2->GroupId}}</td>
                                    <td>{{ $wallet2->GroupName}}</td>
                                    <td>{{ $wallet2->TypeTransactionName}}</td>
                                    <td>{{ number_format($wallet2->Cant) }}</td>                                    
                                    <td>{{ number_format($wallet2->Amount ,2) }}</td>
                                    <td>
                                    </td>                                
                                </tr>

                            @endforeach

                            <tr style="background-color: black; color:white;">
                                <td                     ></td>
                                <td                     ></td>
                                <td                     ></td>
                                <td                     ></td>
                                <td                     >{{ number_format($entradaCant) }}</td>
                                <td                     >{{ number_format($entradaMonto ,2) }}</td>
                                <td                     ></td>
                            </tr>
                        @else
                            <tr class="myTr"">
                                <td colspan="7">
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
        // $("#myCanvasGeneralRecarga").append(myElement);
        
    }

    
    /*
    *
    *
    *  calculoTransacciones
    *  resumen general por wallet
    *
    */
    function calculoTransacciones(){
 
        let myTitleEntrada = $('#entrada1').val();
        let myTitleSalida1 = $('#salida1').val();
        let myTitleSalida2 = $('#salida2').val();
        let myTitleSalida3 = $('#salida3').val();

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
            <div class="col-12 text-center">
                <h3>${myTitleEntrada}</h3>
            </div>
            <div class="col-12 col-md-12">
                <table class="table thead-light" style="background-color: white;">
                    <thead class="thead-dark">
                        <tr>
                            <th class=""   style="width: 25% !important;"          >Wallet</th>
                            <th class="myWidth22"             >Grupo ID</th>                            
                            <th class="myWidth22"             >Grupo</th>
                            <th class=" myWidth22"  >Transaccion</th>
                            <th class=" myWidth22"  >Cant</th>
                            <th class=" myWidth22"  >Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $cant                       = 0;

                        $totalAmount                = 0;
                        $myTotalAmount              = 0;

                        $myFechaDesdeDate = Date($myFechaDesde);
                        $myFechaHastaDate = Date($myFechaHasta);

                         // dd($myFechaDesdeDate);
                         // dd($myFechaHastaDate);
                        $entradaCant    = 0;
                        $entradaMonto   = 0;
                    @endphp
                    
                    @if(count($transaccionesGrupoComision)>0)
                        @foreach($transaccionesGrupoComision as $wallet2)
                            @php 


                                    // dd($myDate);
                                    $entradaCant    += $wallet2->Cant;
                                    $entradaMonto   += $wallet2->Amount ;
                                    //
                                    // filtra
                                    //
                                    $myContinue = 1;
                            @endphp
                            @if($myContinue == 0)
                                    @continue
                            @endif
                            <tr class="myTr">
                                @php

                                    $totalAmount                    =  $wallet2->Amount;

                                    $cant                           += 1;
                                @endphp

                                <td class="myWidth22"   >{{ $wallet2->WalletName}}</td>                               
                                <td class="myWidth22"   >{{ $wallet2->GroupId}}</td>
                                <td class="myWidth22"   >{{ $wallet2->GroupName}}</td>
                                <td class="myWidth22"   >{{ $wallet2->TypeTransactionName}}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Cant) }}</td>                                
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount,2) }}</td>
                                <td></td>
                            </tr>
                            

                        @endforeach
                        @php
                           // $myTotalCommission  +=  $totalComision;
                            $myTotalAmount      +=  $totalAmount ;
                            // $totalComision      =   0;               
                            $totalAmount        =   0; 
                        @endphp
                        <tr style="background-color: black; color:white;">
                            <td                     ></td>                    
                            <td                     ></td>     
                            <td                     ></td>
                            <td class=""  ></td>
                            <td class=""  >{{ number_format($entradaCant) }}</td>
                            <td class=""  >{{ number_format($entradaMonto,2) }}</td>     
                            <td class=""  ></td>     
                        </tr>

                    
                        @if($cant == 0)
                            <tr class="myTr"">
                                <td colspan="6">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>                    
                        @endif

                    @else
                        <tr class="myTr"">
                            <td colspan="6">
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

     
    /*
    *
    *
    *  calculoTransaccionesSalida
    *  resumen general por wallet
    *
    */
    function calculoTransaccionesSalida(){

        let myTitleEntrada = $('#entrada1').val();
        let myTitleSalida1 = $('#salida1').val();
        let myTitleSalida2 = $('#salida2').val();
        let myTitleSalida3 = $('#salida3').val();

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
            <div class="col-12 text-center">
                <h3>${myTitleSalida1}</h3>
            </div>
            <div class="col-12 col-md-12">
                <table class="table thead-light" style="background-color: white;">
                    <thead class="thead-dark">
                        <tr>
                            <th class=""   style="width: 25% !important;"          >Wallet</th>
                            <th class="myWidth22"             >Grupo Id</th>
                            <th class="myWidth22"             >Grupo</th>
                            <th class=" myWidth22"  >Transaccion</th>
                            <th class=" myWidth22"  >Cant</th>
                            <th class=" myWidth22"  >Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $cant                       = 0;

                        $totalAmount                = 0;
                        $totalCant                  = 0;

                        $myTotalAmount              = 0;
                        $myTotalCant                = 0;

                        $myFechaDesdeDate = Date($myFechaDesde);
                        $myFechaHastaDate = Date($myFechaHasta);

                        // dd($myFechaDesdeDate);
                        // dd($myFechaHastaDate);
                        
                    @endphp
                    
                    @if(count($transaccionesGrupoSalida)>0)
                        @foreach($transaccionesGrupoSalida as $wallet2)
                            @php 


                                    // dd($myDate);
                                    //
                                    // filtra
                                    //
                                    $myContinue = 1;
                            @endphp
                            @if($myContinue == 0)
                                    @continue
                            @endif
                            <tr class="myTr">
                                @php

                                    $totalAmount                    += $wallet2->Amount;
                                    $totalCant                      += $wallet2->Cant;

                                @endphp

                                <td class="myWidth22"   >{{ $wallet2->WalletName}}</td>                               
                                <td class="myWidth22"   >{{ $wallet2->GroupId}}</td>                                
                                <td class="myWidth22"   >{{ $wallet2->GroupName}}</td>
                                <td class="myWidth22"   >{{ $wallet2->TypeTransactionName}}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Cant) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount,2) }}</td>
                                <td></td>
                            </tr>
                            

                        @endforeach
                        @php

                        @endphp
                        <tr style="background-color: black; color:white;">
                            <td           ></td>
                            <td           ></td>
                            <td           ></td>
                            <td class=""  ></td>
                            <td class=""  >{{ number_format($totalCant) }}</td>
                            <td class=""  >{{ number_format($totalAmount,2) }}</td>
                            <td class=""  ></td>     
                        </tr>

                    
                        @if($totalCant == 0)
                            <tr class="myTr"">
                                <td colspan="7">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>                    
                        @endif

                    @else
                        <tr class="myTr"">
                            <td colspan="7">
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

    
    
    /*
    *
    *
    *   calculoTransaccionesSalidaOperaciones
    *   resumen general por wallet
    *   operaciones
    * 
    */
    function calculoTransaccionesSalidaOperaciones(){

        let myTitleEntrada = $('#entrada1').val();
        let myTitleSalida1 = $('#salida1').val();
        let myTitleSalida2 = $('#salida2').val();
        let myTitleSalida3 = $('#salida3').val();

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
            <div class="col-12 text-center">
                <h3>${myTitleSalida2}</h3>
            </div>
            <div class="col-12 col-md-12">
                <table class="table thead-light" style="background-color: white;">
                    <thead class="thead-dark">
                        <tr>
                            <th class=""   style="width: 25% !important;">Wallet</th>
                            <th class="myWidth22">Grupo Id</th>
                            <th class="myWidth22">Grupo</th>
                            <th class="myWidth22">Transaccion</th>
                            <th class="myWidth22">Cant</th>
                            <th class="myWidth22">Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $totalCant                  = 0;
                        $totalAmount                = 0;

                        $myFechaDesdeDate = Date($myFechaDesde);
                        $myFechaHastaDate = Date($myFechaHasta);

                        // dd($myFechaDesdeDate);
                        // dd($myFechaHastaDate);
                        
                    @endphp
                    
                    @if(count($transaccionesGrupoSalida2)>0)
                        @foreach($transaccionesGrupoSalida2 as $wallet2)
                            @php 


                                    // dd($myDate);

                                    //
                                    // filtra
                                    //
                                    $myContinue = 1;
                            @endphp
                            @if($myContinue == 0)
                                    @continue
                            @endif
                            <tr class="myTr">
                                @php

                                    $totalAmount                    += $wallet2->Amount;
                                    $totalCant                      += $wallet2->Cant;
                                @endphp

                                <td class="myWidth22"   >{{ $wallet2->WalletName}}</td>                               
                                <td class="myWidth22"   >{{ $wallet2->GroupId}}</td>
                                <td class="myWidth22"   >{{ $wallet2->GroupName}}</td>
                                <td class="myWidth22"   >{{ $wallet2->TypeTransactionName}}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Cant) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount,2) }}</td>
                                <td></td>
                            </tr>
                            

                        @endforeach
                        @php
                            // $myTotalCommission  +=  $totalComision;
                            // $myTotalAmount      +=  $totalAmount ;
                            // $totalComision      =   0;               
                            // $totalAmount            +=   $wallet2->Amount; 
                        @endphp
                        <tr style="background-color: black; color:white;">
                            <td                     ></td>                    
                            <td                     ></td>   
                            <td                     ></td>
                            <td class=""  ></td>
                            <td class=""  >{{ number_format($totalCant) }}</td>
                            <td class=""  >{{ number_format($totalAmount,2) }}</td>     
                            <td class=""  ></td>     
                        </tr>

                    
                        @if($totalCant == 0)
                            <tr class="myTr"">
                                <td colspan="7">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>                    
                        @endif

                    @else
                        <tr class="myTr"">
                            <td colspan="7">
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

     
    /*
    *
    *
    *   calculoTransaccionesSalidaOperaciones
    *   resumen general por wallet
    *   operaciones
    * 
    */
    function calculoTransaccionesSalidaGastos(){

        let myTitleEntrada = $('#entrada1').val();
        let myTitleSalida1 = $('#salida1').val();
        let myTitleSalida2 = $('#salida2').val();
        let myTitleSalida3 = $('#salida3').val();

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
            <div class="col-12 text-center">
                <h3>${myTitleSalida3}</h3>
            </div>
            <div class="col-12 col-md-12">
                <table class="table thead-light" style="background-color: white;">
                    <thead class="thead-dark">
                        <tr>
                            <th class=""   style="width: 25% !important;"          >Wallet</th>
                            <th class="myWidth22"             >Grupo Id</th>
                            <th class="myWidth22"             >Grupo</th>
                            <th class=" myWidth22"  >Transaccion</th>
                            <th class=" myWidth22"  >Cant</th>
                            <th class=" myWidth22"  >Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $totalCant                  = 0;
                        $totalAmount                = 0;

                        $myFechaDesdeDate = Date($myFechaDesde);
                        $myFechaHastaDate = Date($myFechaHasta);

                        // dd($myFechaDesdeDate);
                        // dd($myFechaHastaDate);
                        
                    @endphp
                    
                    @if(count($transaccionesGrupoSalida3)>0)
                        @foreach($transaccionesGrupoSalida3 as $wallet2)
                            @php 


                                    // dd($myDate);

                                    //
                                    // filtra
                                    //
                                    $myContinue = 1;
                            @endphp
                            @if($myContinue == 0)
                                    @continue
                            @endif
                            <tr class="myTr">
                                @php
                                    $totalAmount    += $wallet2->Amount;
                                    $totalCant      += $wallet2->Cant;
                                @endphp

                                <td class="myWidth22"   >{{ $wallet2->WalletName}}</td>                               
                                <td class="myWidth22"   >{{ $wallet2->GroupId}}</td>
                                <td class="myWidth22"   >{{ $wallet2->GroupName}}</td>
                                <td class="myWidth22"   >{{ $wallet2->TypeTransactionName}}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Cant) }}</td>
                                <td class="myWidth22"   >{{ number_format($wallet2->Amount,2) }}</td>
                                <td></td>
                            </tr>
                            

                        @endforeach
                        @php


                        @endphp
                        <tr style="background-color: black; color:white;">
                            <td                     ></td>
                            <td                     ></td>
                            <td                     ></td>
                            <td class=""  ></td>
                            <td class=""  >{{ number_format($totalCant) }}</td>
                            <td class=""  >{{ number_format($totalAmount,2) }}</td>
                            <td class=""  ></td>
                        </tr>

                    
                        @if($totalCant == 0)
                            <tr class="myTr"">
                                <td colspan="7">
                                    <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                                        <h3>Sin transacciones registradas</h3>
                                    </div>
                                </td>
                            </tr>           
                        @endif

                    @else
                        <tr class="myTr"">
                            <td colspan="7">
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

        myRoute = "{{ route('USDTResumenDiario', ['wallet' => 'wallet2' , 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('grupo2',grupo);
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

        
        console.log('myArray ->' + myArray + ' length ->' + myArray.length);
        

        if (myArray.length > 5){
            FechaDesde = myArray[5];
            FechaHasta = myArray[6];
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

        let myDataTransactions          = buscaFiltros("my-select1");
        let ocultarresumengeneral       = $('#ResumenGeneral').prop("checked");
        let ocultarresumentransaccion   = $('#ResumenTransaccion').prop("checked");
        
        let entrada1        = $('#entrada1').val();
        let gruposEntrada1  = buscaFiltros("my-select1");

        let salida1         = $('#salida1').val();
        let gruposSalida1   = buscaFiltros("my-select2");
        
        let salida2         = $('#salida2').val();
        let gruposSalida2   = buscaFiltros("my-select3");
        
        let salida3         = $('#salida3').val();
        let gruposSalida3   = buscaFiltros("my-select4");

        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "{{route('filtroUSDTResDiaMovimientosGraba')}}",
                async: false,
                data: {
                        data: { 
                            entrada1: entrada1,
                            groupsEntrada1: gruposEntrada1,
                            salida1: salida1,
                            groupsSalida1: gruposSalida1,
                            salida2: salida2,
                            groupsSalida2: gruposSalida2,
                            salida3: salida3,
                            groupsSalida3: gruposSalida3,
                    }
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
        
        return  filtrosSeleccionado;
    }


    function leeFiltros(){

        $.ajax(
            {
                url: "{{route('filtroUSDTResDiaMovimientosLee')}}",
                async: false,
            }
        ).done (function(myData) {
            
            myData2 = myData.data;

        });

        // console.log('leam - leefiltros ->' + JSON.stringify(myData2));
        // console.log('leam - leefiltros ->' + myData2.entrada1);
        // console.log('leam - leefiltros ->' + myData2.groupsEntrada1);

        $('#entrada1').val(myData2.entrada1);
        $('#salida1').val(myData2.salida1);
        $('#salida2').val(myData2.salida2);
        $('#salida3').val(myData2.salida3);

        myData2.groupsEntrada1.map( function (valor) {
            $("#my-select1 option").each(function(){
                
                if (valor == $(this).attr('value')){
                    $('#my-select1').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida1.map( function (valor) {
            $("#my-select2 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select2').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida2.map( function (valor) {
            $("#my-select3 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select3').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida3.map( function (valor) {
            $("#my-select4 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select4').multiSelect('select', valor.toString());
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
