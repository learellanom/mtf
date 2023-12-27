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
                              
        <div class="card-body">


            <div class="form-row  justify-content-center align-item-center mt-5">
                <div class="form-group col-md-4">
                    <label class="">Generado por</label>
                    
                    <div class="input-group-text">
                    <label class="col-md-3 col-12">Luis Arellano</label>
                    </div>
                </div>
            </div>

            <div class="form-row  justify-content-center align-item-center">
                <div class="form-group col-md-4">
                    <label class="">Fecha de Generacion</label>
                    
                    <div class="input-group-text">
                        <label class="col-md-3 col-12">22-12-2023 12:00</label>
                    </div>
                </div>
            </div>
            <div class="form-row  justify-content-center align-item-center mt-5">
                <div class="form-group col-md-1 col-3">
                    <button class="btn btn-xl text-primary mx-1 shadow text-center " 
                        title="Activo"
                        onclick="generaComision();"
                        >
                        <i class="fas fa-lg fa-fw fa-coins"></i><p style="display: block;">Generar</p>
                    </button>
                </div>
            </div>

        </div>
    </div>


</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem">
    <div class="modal-content mx-auto" style="width: 90%">

        <!--
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> 
        </div>
        -->
        <div class="modal-body">
            <h5 class="modal-title text-center" id="myModalLabel">
                <br>
                <p>Procesando transacciones</p>
                <br>
            </h5>
            <div class="row justify-content-center">
                <img class="img-fluid" src="{{asset('/img/Counterrotation.gif')}}">
                <!-- <img class="img-fluid" src="{{asset('/img/purplecircles.gif')}}"> -->
            </div>
        </div>
        <!--
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        -->
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem">
    <div class="modal-content mx-auto" style="width: 90%">

        <!--
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> 
        </div>
        -->
        <div class="modal-body">
            <h5 class="modal-title text-center" id="myModalLabel2">
                <br>
                <p>Procesando transacciones</p>
                <br>
            </h5>
            <div class="row justify-content-center">
                <h5 class="modal-title text-center" id="myModalLabel2">
                    <br>
                    <p>Comisiones Procesadas Exitosamente</p>
                    <br>
                </h5>
                <!-- <img class="img-fluid" src="{{asset('/img/purplecircles.gif')}}"> -->
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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



    function toggleBotones(){
        
        $('#myBtnImprimir').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
        $('#myBtnExcel').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
        $('#myBtnPDF').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)


    }

    function generaComision(){

        $('#myModal').modal('show');
        
        //alert('apiUpdateStatus');
        //return;
        // let data    = { id:  id };
        // let token   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{route('dashboardComisionesUSDTProcess')}}")
        .then(response => {
            return response.json()
        }).then(data =>{        

            // {"success":true,"result":"Processed","message":"Procesado con extito"}
            console.log('Genero ->' + JSON.stringify(data));

            if(data.success){
                if(data.result == "Procesadas"){
                    $('#myModal').modal('hide');
                    $('#myModal2').modal('show');
                    location.href = "{{route('dashboardComisionesUSDTGenera')}}";
                }
            // $('#myBtnAnular').attr('disabled',true);
            }else{
              console.log('no genero comisiones ->');
            }

        }).catch(error => console.error( 'Error en Fetch -> ' + error));
    }

</script>

@endsection
