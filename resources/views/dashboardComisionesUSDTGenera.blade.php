@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

@php


    $myClass = new app\Http\Controllers\statisticsController;

@endphp
<style>

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
                    <label class="col-md-3 col-12">{{ $comisionesUSDT->name ?? ""}}</label>
                    </div>
                </div>
            </div>

            <div class="form-row  justify-content-center align-item-center">
                <div class="form-group col-md-4">
                    <label class="">Fecha de Generacion</label>
                    
                    <div class="input-group-text">
                        <label class="col-md-3 col-12">{{ $comisionesUSDT-> created_at2}}</label>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
   


    $(() => {


    });

    $( document ).ready(function() {

    });



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
                    
                }
            // $('#myBtnAnular').attr('disabled',true);
            }else{
              console.log('no genero comisiones ->');
            }

        }).catch(error => console.error( 'Error en Fetch -> ' + error));
    }

    $("#myModal2").on('hidden.bs.modal', function () {
        location.href = "{{route('dashboardComisionesUSDTGenera')}}";
    });

</script>

@endsection
