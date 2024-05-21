@extends('adminlte::page')
@section('title', 'Estadisticas')

@php


         
     // dd($materialsCierre);


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
    'order' => [
        [3, 'asc']
    ],
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];


@endphp
{{-- dd('aqui ->' . $Cierre) --}}

@section('content')

<style>

</style>

<div class="container justify-content-center" style="display: contents;">

    <div class="row col-12 col-md-12 justify-content-center text-center align-items-center" style="min-height: 5rem !important">
        <h4>Liquidacion Cuenta por Grupo</h4>
    </div>
    
    <div class="card">
                              
        <div class="card-body">

            <div class ="form-row justify-content-center align-item-center ">
                <div class="form-group col-md-4">
                    <x-adminlte-select2 id="wallet"
                                        name="optionsCliente"
                                        igroup-size="sm"                                        
                                        label-class="text-lightblue"
                                        data-placeholder="Wallet ..."
                                        :config="$config1"
                                        >
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-dark">
                                <!-- <i class="fas fa-car-side"></i> -->
                                <i class="fas fa-box"></i>
                            </div>
                        </x-slot>

                        <x-adminlte-options :options="$wallet" empty-option="Selecciona un Wallet.."/>
                    </x-adminlte-select2>
                </div>
            </div>
            
            <div class ="form-row justify-content-center align-item-center ">
            <div class="form-group col-md-4">
                <x-adminlte-select2 id="group"
                                    name="optionsGroup"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Grupo ..."
                                    :config="$config2"
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </x-slot>

                    <x-adminlte-options :options="$group" empty-option="Selecciona un Grupo.."/>
                </x-adminlte-select2>
            </div>
            </div>

            <div class ="form-row justify-content-center align-item-center ">
            <div class="form-group col-md-4">
                <x-adminlte-select2 id="type_material_id"
                                    name="type_material_id"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Material ..."
                                    :config="$config1"
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <!-- <i class="fas fa-user-tie"></i> -->
                            <i class="fas fa-solid fa-dollar-sign"></i>                        
                        </div>
                        
                    </x-slot>

                    <x-adminlte-options :options="$type_material" empty-option="Selecciona un material.."/>

                </x-adminlte-select2>
            </div>
            </div>

            <div class="form-row  justify-content-center align-item-center mt-5">
                <div class="form-group col-md-1 col-3">
                    <button class="btn btn-xl text-primary mx-1 shadow text-center " 
                        title="Activo"
                        onclick="generaCierre();"
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
                    <p>Liquidacion de cuenta por grupo Procesado Exitosamente</p>
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

        $('#wallet, #group, #type_material_id')
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });     

    });

    $( document ).ready(function() {

    });

    function generaCierre(){

        
        wallet              = $('#wallet').val();
        group               = $('#group').val();
        typeMaterial        = $('#type_material_id').val();
        salir               = 0;
        
        if (!wallet){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione la Caja.',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }
        if (!group){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione el grupo.',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }        
        if (!typeMaterial){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione el material',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }                
        if (salir == 1){
            return;
        }

        $('#myModal').modal('show');
        
        //alert('apiUpdateStatus');
        //return;
        // let data    = { id:  id };
        // let token   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        wallet              = $('#wallet').val();
        group               = $('#group').val();
        typeMaterial        = $('#type_material_id').val();
        
        myRoute = "{{route('materialsLiquidacionCuentaGrupoProcess', ['wallet' => 'wallet2', 'group' => 'group2', 'type_material' => 'type_material2'])}}";
        myRoute = myRoute.replace('group2',group);
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('type_material2',typeMaterial);
        myRoute = myRoute.replaceAll('amp;','');
        

        fetch(myRoute)
        .then(response => {
            return response.json()
        }).then(data =>{        

            // {"success":true,"result":"Processed","message":"Procesado con extito"}
            console.log('Genero ->' + JSON.stringify(data));

            if(data.success){
                if(data.result == "Procesado"){
                    $('#myModal').modal('hide');
                    $('#myModal2').modal('show');
                }
                // $('#myBtnAnular').attr('disabled',true);
            }else{
              console.log('no genero comisiones ->');
            }

        }).catch(error => console.log( 'Error en Fetch -> ' + error));
    }


    function generaCierre2(){


        wallet              = $('#wallet').val();
        group               = $('#group').val();
        typeMaterial        = $('#type_material_id').val();
        salir               = 0;

        if (!wallet){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione la Caja.',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }
        if (!group){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione el grupo.',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }        
        if (!typeMaterial){
            salir = 1
            Swal.fire({
                            position: 'left',
                            type: 'error',
                            title: 'Seleccione el material',
                            showConfirmButton: true
                        });

            // alert ('wallet ->' + wallet);
            return;
        }                
        if (salir == 1){
            return;
        }

        $('#myModal').modal('show');

        //alert('apiUpdateStatus');
        //return;
        // let data    = { id:  id };
        // let token   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        setTimeout( function () {
            $('#myModal').modal('hide');
            $('#myModal2').modal('show');            
        },5000);

    }


    $("#myModal2").on('hidden.bs.modal', function () {
        location.href = "{{route('materialsLiquidacionCuentaGrupo')}}";
    });

</script>

@endsection
