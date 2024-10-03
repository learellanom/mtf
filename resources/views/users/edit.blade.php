@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR USUARIO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
 <div class="card col-md-4">
    <div class="card-body">
        {!! Form::model($user,['route' => ['users.update_users', $user], 'method' => 'put', 'autocomplete' => 'off', 'files' => true , 'id' => 'entre']) !!}


        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        <div class="form-group">
            {!! Form::Label('name', "Nombre:") !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            {!! Form::Label('email', "Correo Electronico:") !!}
            {!! Form::text('email', null, ['class' => 'form-control', 'required' => true]) !!}


            @error('email')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>
        {{--
        @foreach($roles as $role)
            <div>
                <label>
                    {!! Form::checkbox('roles[]', $role->id, null, ['class'=>'mr-1']) !!}
                    {{$role->name}}

                </label>
            </div>
        @endforeach
        --}}








                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="border-bottom: 1px solid">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab"     data-toggle="pill" data-target="#pills-home"    type="button" role="tab" aria-controls="pills-home"     aria-selected="true">Administrativo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link"        id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile"  type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Externo</button>
                    </li>
                </ul>
                
                <br>
                <br>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active"  id="pills-home"       role="tabpanel" aria-labelledby="pills-home-tab">


                        @foreach($roles as $role)

                            {{-- Si no es 1: externo el rol --}}
                            
                                <div>
                                    <label>
                                        {!! Form::checkbox('roles[]', $role->id, null, ['class'=>'mr-1 myCheckBox', 'id' => 'theRole']) !!}
                                         {{$role->name}}

                                    </label>
                                </div>

                        @endforeach

                    </div>  

                    <div class="tab-pane fade"              id="pills-profile"    role="tabpanel" aria-labelledby="pills-profile-tab">
                        {{--
                        <label>
                            <input class="mr-1" name="roles[]" type="checkbox" value="1" checked id="myCheckExterno">
                            Externo
                        </label>         
                        --}}
                        <div class="row card-deck mt-4 justify-content-center">
                            <div class="card mb-4 col-12 col-sm-6">
                                <div class="card-header">   
                                    <h3 class="card-title text-uppercase font-weight-bold">Wallet</h3>
                                </div>
                                <div class="card-body">  

                                    <div class="row justify-content-center text-center align-items-center">
                                        <select multiple="multiple" id="myselect" name="myselect[]" readonly>
                                        </select>
                                    </div>     
                                    <br>
                                    <br>

                                </div>
                            </div>

                        </div>

                        <div class="row card-deck justify-content-center">
                            <div class="card mb-4 col-12 col-sm-6 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Grupos</h3>
                                </div>
                                <div class="card-body">    

                                    <div class="row justify-content-center text-center align-items-center">
                                        <select multiple="multiple" id="myselect2" name="myselect2[]">
                                        </select>   
                                    </div>     
                                    <br>
                                    <br>

                                </div>
                            </div>
                        </div> 

                    </div>
                </div>

                {!! Form::hidden('type',null, ['class' => 'form-control general', 'min' => 0, 'readonly' => true, 'id' => 'type']) !!}


            {!! Form::close() !!}

    </div>
  </div>
</div>

@endsection

@section('js')
<script>



    
$(document).ready(function () {

    InicializaMultiselects();
    cargaGrupos();
    cargaWallets();
    leeWallets();
    leeGroups();

    {{-- dd($user->type); --}}
    $('#type').val({{ $user->type ?? 1}});

    
    $("input:checkbox[name='roles[]']").each(function(){

        let value   = $(this).val();
        let myCheck = $(this).prop("checked");

        // console.log('si es externo ->' + value + ' checked ->' + $(this).prop("checked"));
        if (value ==1){
            if (myCheck == false){
                //console.log('deshabilita');
                $('#pills-profile-tab').prop("disabled",true);
            }else{
                //console.log('habilita');
                $('#pills-profile-tab').prop("disabled",false);
            }
        }
        // $(this).prop( "checked", true );
    }); 


    // console.log('type -> ' + $('#type').val());

    $('.myCheckBox').on('click', function (){
        $("input:checkbox[name='roles[]']").each(function(){

            let value   = $(this).val();
            let myCheck = $(this).prop("checked");

            // console.log('si es externo ->' + value + ' checked ->' + $(this).prop("checked"));
            if (value ==1){
                if (myCheck == false){
                    //console.log('deshabilita');
                    $('#pills-profile-tab').prop("disabled",true);
                    $('#type').val('1');
                }else{
                    //console.log('habilita');
                    $('#pills-profile-tab').prop("disabled",false);
                    $('#type').val('2');
                }
            }




            }); 
            //
            //
            // SI no es Externo el rol borra el wallet o grupo seleccionado 
            //
            //
            let myExterno = 0;
            $("input:checkbox[name='roles[]']:checked").each(function(){
                let value = $(this).val()
                if (value == 1) myExterno = 1;
            });
            if (myExterno == 1){
                $('#type').val('2');
            }else{
                $("#myselect option").each(function(){
                    $('#myselect').multiSelect('deselect', $(this).val());
                }); 
                
                $("#myselect2 option").each(function(){
                    $('#myselect2').multiSelect('deselect', $(this).val());
                });             
                $('#type').val('1');
            }            
                // $(this).prop( "checked", true );
    });
    
    //
    // Roles
    //
    $('#pills-home-tab').on('click', function (){

        let myExterno = 0;
        $("input:checkbox[name='roles[]']:checked").each(function(){
            let value = $(this).val()
            if (value == 1) myExterno = 1;
        });
        if (myExterno == 1){
            $('#type').val('2');
        }else{
            $("#myselect option").each(function(){
                $('#myselect').multiSelect('deselect', $(this).val());
            }); 
            
            $("#myselect2 option").each(function(){
                $('#myselect2').multiSelect('deselect', $(this).val());
            });             
            $('#type').val('1');
        }

        /*

        */
    });
    //
    // Wa;;ets y grupos de usuario externo
    //
    $('#pills-profile-tab').on('click', function (){
        // alert('paso 2');  
        // InicializaRoles();
        $('#type').val('2');

        // console.log('pasa por marcado -> ' +   $("input:checkbox[name='roles[]']").val());

        // $('#myCheckExterno').prop("checked",true);
        /*
        console.log('Valida cuales estan marcados en 2 - Inicio');
        $("input:checkbox[name='roles[]']:checked").each(function(){
            let value = $(this).val()
            console.log("por marcado  2 " + value)
           
        });
        console.log('Valida cuales estan marcados en 2 - Fin');
        */
    });



    $('#entre').on('submit', function() {

        /* Validar que se slecciono por lo menos 1 rol para el usuario */
        let Cant        = 0;
        let myExterno   = 0;
        $("input:checkbox[name='roles[]']:checked").each(function(){
            Cant++;
            let value = $(this).val()
            
            // $(this).prop( "checked", true );
            if(value == 1){
                myExterno = 1;
            }
        });
        // alert("cantidad -> " + Cant);
        if (Cant == 0){
            Swal.fire({
                position: 'left',
                type: 'error',
                title: 'Seleccione  Rol de usuario.',
                showConfirmButton: true
            });
            return false;
        }
        if (myExterno ==1){
            if (Cant > 1){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Si el usuario tiene rol Externo no puede tener otros roles. Debe tener solo Externo como rol',
                    showConfirmButton: true
                });
                return false;
            }
        }

        let myType = $('#type').val();
        // alert('paso - type -> ' + myType);
        if (myType == '2'){

            
            let myDataWallet    = buscaFiltrosWallet('myselect');
            let myDataGroup     = buscaFiltrosGroup('myselect2');

            // alert('myDataWallet ' + myDataWallet.length);

            let Cant2 = 0;
            $("#myselect option:selected").each(function(){
                Cant2++;
            });

            let Cant3 = 0;
            $("#myselect2 option:selected").each(function(){
                Cant3++;
            });

            if(Cant2 ==0 && Cant3 ==0){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Seleccione un Wallet o un Grupo por lo menos.',
                    showConfirmButton: true
                });
                return false;
            }



            if(Cant2 >= 1 && Cant3 >= 1){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Debe seleccionar solo (1) un Wallet o (1) un Grupo.',
                    showConfirmButton: true
                });
                return false;
            }

            if(Cant2 > 1){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Debe seleccionar solo (1) un Wallet.',
                    showConfirmButton: true
                });
                return false;
            }


            if(Cant3 > 1){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Debe seleccionar solo (1) un Grupo.',
                    showConfirmButton: true
                });
                return false;
            }



            /*
            if (Cant3 ==0){
                Swal.fire({
                    position: 'left',
                    type: 'error',
                    title: 'Seleccione un Grupo.',
                    showConfirmButton: true
                });
                return false;
            }
            alert('Cant3 -> ' + Cant3);
            */
        }

    });


});


function InicializaMultiselects(){
    $('#myselect').multiSelect({
        disabledClass: 'diabled',
        selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                Por asignar    
                                <br><br> 
                                <div>
                                    <i class='fas fa-circle' style='color: red;'></i>
                                </div>
                            </div>`,
        selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                Asignados
                                <br>
                                <br> 
                                <div>
                                    <i class='fas fa-circle' style='color: green;'>  </i>
                                </div>
                            </div>`
    });

    $('#myselect2').multiSelect({
        selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                Por Asignar
                                <br>
                                <br> 
                                <div>
                                    <i class='fas fa-circle' style='color: red;'>  </i>
                                </div>                                    
                            </div>`,
        selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                Asignados
                                <br><br> 
                                <div>
                                    <i class='fas fa-circle' style='color: green;'></i>
                                </div>                                    
                            </div>`
    });
              
}


	
function cargaGrupos(){
    @foreach($group as $key => $group2)
        // console.log('el grupo con key {!! $key !!} es {!! $group2 !!}');
        $('#myselect2').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
    @endforeach
}

function cargaWallets(){
    @foreach($wallet as $key => $wallet2)
        // console.log('el grupo con key {!! $key !!} es {!! $wallet2 !!}');
        $('#myselect').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $wallet2 !!}' });
    @endforeach
}


function leeWallets(){
    @foreach($userWallets as $myWallets)
        $("#myselect option").each(function(){
            // console.log( 'leam - el valor -> ' +  $(this).val() + ' mi valor -> ' + {{ $myWallets->GroupID }});
            if($(this).val() == {{ $myWallets->GroupID }}){
                // console.log('leam - encontro');
                $('#myselect').multiSelect('select', $(this).val());
            }
        }); 
    @endforeach             
}

function leeGroups(){
    
    @foreach($userGroups as $myWallets)
        $("#myselect2 option").each(function(){
            // console.log( 'leam - el valor -> ' +  $(this).val() + ' mi valor -> ' + {{ $myWallets->GroupID }});
            if($(this).val() == {{ $myWallets->GroupID }}){
                // console.log('leam - encontro');
                $('#myselect2').multiSelect('select', $(this).val());
            }
        }); 
    @endforeach
                 
}



function InicializaRoles(Cant = 0){
    // alert('viene' + $('.myCheckBox').val());
   //console.log('Inicializa roles');
    if (Cant ==0){
        $("input:checkbox[name='roles[]']:checked").each(function(){
            let value = $(this).val()
            // console.log(value)
            $(this).prop( "checked", false );
        });
    }else{
        // console.log('pasa por 1 ');
        $("input:checkbox[name='roles[1]']:checked").each(function(){
            let value = $(this).val()
            // console.log("por 1 " + value)
            $(this).prop( "checked", false );
        });
            
    }
}


	
function buscaFiltrosWallet(myMultiSelect = ""){

    // alert("myMultiSelect ->" + myMultiSelect);

    if (myMultiSelect == "") return;

    let filtrosSeleccionado = [];
    filtrosSeleccionado.push(0);
    $("#" + myMultiSelect + " option:selected").each(function(){
        filtrosSeleccionado.push($(this).attr('value'));
    });
    // alert ("filtros de wallet ->" + filtrosSeleccionado.toString());
    return filtrosSeleccionado;
}

function buscaFiltrosGroup(myMultiSelect = ""){
    let filtrosSeleccionado = [];
    filtrosSeleccionado.push(0);
    $("#" + myMultiSelect + " option:selected").each(function(){
        filtrosSeleccionado.push($(this).attr('value'));
    });  
    // alert ("filtros de grupos ->" + filtrosSeleccionado.toString());
    return  filtrosSeleccionado;
}




</script>

@endsection

