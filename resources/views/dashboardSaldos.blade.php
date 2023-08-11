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
    <div class="row col-12 col-md-12 justify-content-center text-center align-items-center" style="min-height: 5rem !important">
        <h4>Consolidado de Saldos</h4>
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

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        {{--

                        <!-- Seelect de Caja -->
                        
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

                        <!-- select de grupo -->

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
                        --}}
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
                            <a class="btn btn-success"  onclick="exportaSaldos();"><i class="fas fa-file-excel"></i></a>
                            {{--
                            <a class="btn btn-success" href={{route('exports.saldos', [$myFechaDesde, $myFechaHasta])}}><i class="fas fa-file-excel"></i></a>
                            --}}
                        </div>

                    </div>
                </div>
            </div>
            
            <div id="myCanvas"></div>
        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Filtros



        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">Filtros Wallet</h3>
            </div>
            <div class="card-body">    
                <div class="row justify-content-center text-center align-items-center">
                    <div class="col-12 col-md-2">
                    </div>
                    <div class="col-12 col-md-3">
                        <select multiple="multiple" id="my-select" name="my-select[]">

                        </select>   
                    </div>

                    <div class="col-12 col-md-3">
                        <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                        <br>
                        <br>
                        <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                    </div>
                    <div class="col-12 col-md-2">
                    </div>
 
                </div>     

            </div>
        </div>

  

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">Filtros Grupos</h3>
            </div>
            <div class="card-body">    
                <div class="row justify-content-center text-center align-items-center">
                    <div class="col-12 col-md-2">
                    </div>
                    <div class="col-12 col-md-3">
                        <select multiple="multiple" id="my-select2" name="my-select2[]">

                        </select>   
                    </div>

                    <div class="col-12 col-md-3">
                        <button id="myButtonAplicar2" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                        <br>
                        <br>
                        <button id="myButtonLimpiar2" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                    </div>
                    <div class="col-12 col-md-2">
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
        // dd( config('filtros.consolidado.wallets.0') );
        // dd( config('filtros.consolidado.wallets') );
        // dd( config('filtros') );
         
        $myArrayWallets = config('filtros.consolidado.wallets');
        $myArrayGroups  = config('filtros.consolidado.groups');
        // dd($myArray);
        // dd($myArrayGroups);
    @endphp

    let myArray = [];
    @foreach($myArrayWallets as $myValue)
        myArray.push({{$myValue}});
    @endforeach
    // alert(myArray);

    // myArray[0] = 99;

    

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

        //if (!miWallet){
            
        calculoGeneral3();  
        calculos3();



        //}else{
        //   calculoGeneral2();
        //    calculos2();
        //}

            // funcion para permitir el filtrado

        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                //do stuff
                let userTypeColumnData = data[0] || 0;
                let muestra = true;
                $("#my-select option:selected").each(function(){
                    if (userTypeColumnData==($(this).attr('value'))) {
                        // alert('opcion '+$(this).text()+' valor '+ $(this).attr('value') + ' lo que ve ' + userTypeColumnData);
                        muestra = false;
                    }
                }); 
                // alert('sigue -> ' + userTypeColumnData + ' lo muestra -> ' + muestra);
                return muestra;
            }
        );

        $('#my-select2').multiSelect({
            selectableHeader: "<div class='custom-header' style='background-color: black; color:white'>Visibles</div>",
            selectionHeader:  "<div class='custom-header' style='background-color: black; color:white'>No VIsibles</div>"
        });

        $('#my-select').multiSelect({
            selectableHeader: "<div class='custom-header' style='background-color: black; color:white'>Visibles</div>",
            selectionHeader:  "<div class='custom-header' style='background-color: black; color:white'>No VIsibles</div>"
        });

        cargaGrupos();
        cargaWallets();


            
        $('#myButtonLimpiar').on('click', function (){
            $('#my-select').multiSelect('deselect_all');
            
        });

        $('#myButtonAplicar').on('click', function (){
            $("#myTableWallet tr").each(function(){
                $(this).removeAttr("hidden");
            });

            $("#my-select option:selected").each(function(){
                
                seleccionado = $(this).attr('value');

                $("#myTableWallet tr").each(function(){
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


        $('#myButtonLimpiar2').on('click', function (){
            $('#my-select2').multiSelect('deselect_all');
            
            
        });

        $('#myButtonAplicar2').on('click', function (){
            $("#myTableGroup tr").each(function(){
                $(this).removeAttr("hidden");
            });     

            $("#my-select2 option:selected").each(function(){
                
                seleccionado = $(this).attr('value');
                // alert(" seleccionado : " + seleccionado);
                $("#myTableGroup tr").each(function(){
                    if($(this).data("id")){
                                                
                        if ($(this).data("id") == seleccionado){
                            
                            $(this).attr("hidden",true);
                        }
                    }
                });


            });  

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
        leeFiltros();
    });
    /*
    *
    * calculos3 - group summary
    * 
    */
    function calculos3(){

        let myElement;
        {{-- dd($group_summary) --}}

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

                <div class="col-12 col-md-12 justify-content-center text-center align-items-center mb-4 mt-4">
                    <h4>Resumen por Grupo</h4>
                </div>


                <div class="col-12 col-md-12">
                    <table class="table thead-light" style="background-color: white;" id="myTableGroup">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:1%;">Grupo</th>
                                <th style="width:1%;">Saldo Anterior</th>                                
                                <th style="width:1%;">Creditos</th>
                                <th style="width:1%;">Debitos</th>
                                <th style="width:1%;">Total</th>                                        
                            </tr>
                        </thead>
                        @foreach($group_summary as $group2)
                            @php
                                $indMuestra = 1;
                                foreach($myArrayGroups as $value){
                                    if ($value == $group2->IdGrupo){
                                        $indMuestra = 0;
                                    }
                                }

                                $myTotal = ($group2->BalanceAnterior + $group2->Creditos ) - $group2->Debitos; 
                            @endphp
                            @if($indMuestra == 0)
                                @continue
                            @endif
                            <tr class="myTr" onClick="theRoute2({{0}}, {{ $group2->IdGrupo }}, {{0}}, {{0}})" data-id="{{$group2->IdGrupo}}">
                                <td >{{ $group2->NombreGrupo}}</td>
                                <td >{{ number_format($group2->BalanceAnterior,2) }}</td>                                
                                <td >{{ number_format($group2->Creditos,2) }}</td>
                                <td >{{ number_format($group2->Debitos,2)}}</td>
                                <td >{{ number_format($myTotal ,2)}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        `
        $("#myCanvas").append(myElement);

            
     
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

         {{-- dd($wallet_summary) --}}

        theWallet = 89;
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


                <div class="col-12 col-md-12 justify-content-center text-center align-items-center mb-4 mt-4">
                    <h4>Resumen por Wallet</h4>
                </div>

                <div class="col-12 col-md-12">
                    <table id="myTableWallet" class="table thead-light" style="background-color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:1%; display: none;">Id</th>                            
                                <th style="width:1%;"               >Wallet</th>
                                <th style="width:1%;"               >Saldo Anterior</th>                                
                                <th style="width:1%;"               >Entrada</th>
                                <th style="width:1%;"               >Salidas</th>
                                <th style="width:1%;"               >Saldo</th>
                            </tr>
                        </thead>
                        @php
                            $cantCreditos  = 0;
                            $cantDebitos   = 0;

                            $totalSaldoAnterior  = 0;
                            $totalCreditos  = 0;
                            $totalDebitos   = 0;

                            $total = 0;
                        @endphp
                        
                        @foreach($wallet_summary as $wallet2)

                            <tr class="myTr" onClick="theRoute2({{0}}, {{0}}, {{$wallet2->IdWallet}}, {{0}})" data-id="{{$wallet2->IdWallet}}">
    
                                @php

                                    $indMuestra = 1;
                                    foreach($myArrayWallets as $value){
                                        if ($value == $wallet2->IdWallet){
                                            $indMuestra = 0;
                                        }
                                    }

                                    $cantCreditos ++;
                                    $totalCreditos += $wallet2->Creditos;
                                    $totalDebitos  += $wallet2->Debitos;

                                    $myTotal = ($wallet2->BalanceAnterior + $wallet2->Creditos ) - $wallet2->Debitos;
                                    $total  += $myTotal;                                    
                                @endphp
                                @if($indMuestra == 0)
                                    @continue
                                @endif

                                <td >{{ $wallet2->NombreWallet}}</td>
                                <td >{{ number_format($wallet2->BalanceAnterior,2)}}</td>                                
                                <td >{{ number_format($wallet2->Creditos,2)  }}</td>
                                <td >{{ number_format($wallet2->Debitos,2) }}</td>
                                <!-- <td >{{ number_format($wallet2->Total,2) }}</td> -->
                                <td >{{ number_format($myTotal,2) }}</td>                                
                            </tr>

                        @endforeach
                        <tr style="background-color: black; color:white;">
                            <td >{{ ' ' }}</td>
                            <td >{{ number_format($totalSaldoAnterior,2) }}</td>
                            <td >{{ number_format($totalCreditos,2) }}</td>
                            <td >{{ number_format($totalDebitos,2) }}</td>
                            <td >{{ number_format($total,2) }}</td>

                        </tr>
                    </table>
                </div>


            </div>
        `;

        // alert(myElement);
        
        console.log(myElement);

        $("#myCanvas").append(myElement);

    }




    function theRoute(wallet = 0, transaction = 0, fechaDesde = 0, fechaHasta = 0){



        let myRoute = "";

        myRoute = "{{ route('dashboardSaldos', ['fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
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
        // $('#drCustomRanges').data('daterangepicker').setStartDate('01-01-2001');

    }
    function BuscaFechas(FechaDesde = 0,FechaHasta = 0){

            myLocation  = window.location.toString();

            myArray     = myLocation.split("/");
            // alert('myArray ->' + myArray);
            if (myArray.length > 4){
                FechaDesde = myArray[4];
                FechaHasta = myArray[5];
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

    function cargaGrupos(){
        @foreach($group as $key => $group2)
            console.log('el grupo con key {!! $key !!} es {!! $group2 !!}');
            $('#my-select2').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
        @endforeach
    }

    function cargaWallets(){
        @foreach($wallet as $key => $wallet2)
            console.log('el grupo con key {!! $key !!} es {!! $wallet2 !!}');
            $('#my-select').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $wallet2 !!}' });
        @endforeach
    }

    function exportaSaldos(){
        let myFiltroWallet  = buscaFiltrosWallet();
        let myFiltroGroup   = buscaFiltrosGroup();

        let myRoute = "";
        let fechaDesde = "{{$myFechaDesde}}";
        let fechaHasta = "{{$myFechaHasta}}";

        myRoute = "{{route('exports.saldos', ['fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'filtroWallet' => 'filtroWallet2', 'filtroGroup' => 'filtroGroup2'])}}"

        myRoute = myRoute.replace('fechaDesde2',    fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',    fechaHasta);
        myRoute = myRoute.replace('filtroWallet2',  myFiltroWallet);
        myRoute = myRoute.replace('filtroGroup2',   myFiltroGroup);

        // alert(' myRoute ->' + myRoute);

        location.href = myRoute;
    }

    function buscaFiltrosWallet(){
        let filtrosSeleccionado = [];
        filtrosSeleccionado.push(0);
        $("#my-select option:selected").each(function(){
                
                filtrosSeleccionado.push($(this).attr('value'));

            });  
        // alert ("filtros de wallet ->" + filtrosSeleccionado.toString());
        return filtrosSeleccionado;
    }

    function buscaFiltrosGroup(){
        let filtrosSeleccionado = [];
        filtrosSeleccionado.push(0);
        $("#my-select2 option:selected").each(function(){
                
                filtrosSeleccionado.push($(this).attr('value'));

            });  
        // alert ("filtros de grupos ->" + filtrosSeleccionado.toString());
        return  filtrosSeleccionado;
    }

    
    function leeFiltros(){
        

        $.ajax(
            {
                url: "{{route('filtrosLeeWallet')}}",
                async: false,
            }
        ).done (function(myData) {
            // alert('myData ' + JSON.stringify(myData) )
            
            myData2 = myData.data;
            // alert("el tipo de data " + typeof JSON.stringify(myData2) + ' y la data  ' + myData2);


        });

        myData2.map( function (valor) {
            // alert ('mi valor es ' + valor);
            $("#my-select option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select').multiSelect('select', valor.toString());
                     // alert(JSON.stringify($(this).text()));
                 }
            });

        });      
        
        
        // grupos
        

        $.ajax(
            {
                url: "{{route('filtrosLeeGroup')}}",
                async: false,
            }
        ).done (function(myData) {
            // alert('myData group ' + JSON.stringify(myData) )
            myData2 = JSON.stringify(myData.data);
            myData2 = myData.data;
            // alert("el tipo de data group " + typeof JSON.stringify(myData2) + ' y la data  ' + myData2);


        });

        myData2.map( function (valor) {
            // alert ('mi valor es group ' + valor);
            $("#my-select2 option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select2').multiSelect('select', valor.toString());
                     // alert(JSON.stringify($(this).text()));
                 }
            });

        });            

    }

    function grabaFiltros(){


        let myDataWallet    = buscaFiltrosWallet();
        let myDataGroup     = buscaFiltrosGroup();
        // alert (myDataWallet + ' y el typeof es ' + Array.isArray(myDataWallet));        
        // alert (myDataGroup);
        

        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "{{route('filtrosGrabaWallet')}}",
                async: false,
                data: { myDataWallet: "1,2,3" },
            }
        ).done (function(myData) {
            // alert('myData ' + JSON.stringify(myData) )
            
           //  myData2 = myData.data;
            // alert("el tipo de data " + typeof JSON.stringify(myData2) + ' y la data  ' + myData2);
            alert('vino');

        });
        return;
        
        myData2.map( function (valor) {
            // alert ('mi valor es ' + valor);
            $("#my-select option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select').multiSelect('select', valor.toString());
                     // alert(JSON.stringify($(this).text()));
                 }
            });

        });      
        
        
        // grupos
        

        $.ajax(
            {
                url: "{{route('filtrosGrabaGroup')}}",
                async: false,
            }
        ).done (function(myData) {
            // alert('myData group ' + JSON.stringify(myData) )
            myData2 = JSON.stringify(myData.data);
            myData2 = myData.data;
            // alert("el tipo de data group " + typeof JSON.stringify(myData2) + ' y la data  ' + myData2);


        });

        myData2.map( function (valor) {
            // alert ('mi valor es group ' + valor);
            $("#my-select2 option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select2').multiSelect('select', valor.toString());
                     // alert(JSON.stringify($(this).text()));
                 }
            });

        });            

    }

</script>

@endsection
