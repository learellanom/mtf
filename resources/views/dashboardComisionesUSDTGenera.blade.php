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
        <h4>Generacion de comisiones USDT</h4>
    </div>
    
    <div class="card">
        <div class="card-header">
            <div class="row">
                    <label>Generado por</label>
                    <label>Luis Arellano</label>
                    <label>Fecha de Generacion</label>
                    <label>22-12-2023 12:00</label>
            </div>
        </div>
    </div>


</div>

@endsection
@section('js')


<script>
   

    @php
    @endphp


    $(() => {


    });

    $( document ).ready(function() {

    });


    function pantallaInicial(){
        let myElement =`
            <div class="row  justify-content-center text-center align-items-center" style="margin-top: 5rem; margin-bottom: 5rem;">
                <h3><p>
                Seleccione criterio de busqueda Basico
                <br>
                Caja y Grupo</p></h3>
            </div>        
        `;
        $("#myCanvasGeneralRecarga").append(myElement);


        $("#myCanvasGeneral").append(myElement);

    }



    function theRoute(wallet = '', grupo = 0, fechaDesde = '', fechaHasta = ''){

        let myRoute = "";

        myRoute = "{{ route('dashboardComisionesGrupo3', ['wallet' => 'wallet2' , 'grupo' => 'grupo2' ,'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
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
