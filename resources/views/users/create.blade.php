@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVO USUARIO') }} <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            <form action={{ route('users.store')}} method="POST">
                @csrf
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

                <div class="form-group">
                    <label for="">Contraseña</label>
                    <input id="password" type="password" class="form-control"  name="password">
                </div>

                <div class="form-group">
                    <label for="">Confirma Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                </div>
                <h5 class="font-weight-bold text-center">{{ __('ROLES|PERFIL') }}</h5>
                <hr>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab"       data-toggle="tab" data-target="#nav-home"       type="button" role="tab" aria-controls="nav-home"       aria-selected="true">Administrativo</button>
                        <button class="nav-link"        id="nav-profile-tab"    data-toggle="tab" data-target="#nav-profile"    type="button" role="tab" aria-controls="nav-profile"    aria-selected="false">Externo</button>
                    </div>
                </nav>

                <br>
                <br>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active"  id="nav-home"       role="tabpanel" aria-labelledby="nav-home-tab">...

                        @foreach($role as $roles)
                            <div>
                                <label>
                                    {!! Form::checkbox('roles[]', $roles->id, null, ['class'=>'mr-1']) !!}
                                    {{$roles->name}}

                                </label>
                            </div>
                        @endforeach

                    </div>

                    <div class="tab-pane fade"              id="nav-profile"    role="tabpanel" aria-labelledby="nav-profile-tab">




                        <div class="row card-deck mt-4 justify-content-center">
                                <div class="card mb-4 col-12 col-sm-6">
                                    <div class="card-header">   
                                        <h3 class="card-title text-uppercase font-weight-bold">Wallet</h3>
                                    </div>
                                    <div class="card-body">  
                                        {{--
                                        <div class="row justify-content-center text-center align-items-center mt-4 mb-4"> 
                                            <input type="checkbox" id="all_wallets" name="all_wallets" value="1">
                                            <label for="all_wallets" style="margin-top: 0.4rem; margin-left: 0.4rem;">Todas las Cajas</label><br>
                                        </div>                                
                                        --}}
                                        <div class="row justify-content-center text-center align-items-center">
                                            <select multiple="multiple" id="myselect" name="myselect[]" readonly>
                                            </select>
                                        </div>     
                                        <br>
                                        <br>
                                        {{--
                                        <div class="row justify-content-center text-center align-items-center">
                                            <div class="col-12 col-sm-3 mt-2">
                                                <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                                            </div>
                                            <div class="col-12 col-sm-3 mt-2">
                                                <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                                            </div>                    
                                        </div>
                                        --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row card-deck justify-content-center">
                                <div class="card mb-4 col-12 col-sm-6 lm-2">
                                    <div class="card-header">
                                        <h3 class="card-title text-uppercase font-weight-bold">Grupos</h3>
                                    </div>
                                    <div class="card-body">    
                                        {{--
                                        <div class="row justify-content-center text-center align-items-center mt-4 mb-4"> 
                                            <input type="checkbox" id="all_groups" name="all_groups" value="1">
                                            <label for="all_groups" style="margin-top: 0.4rem; margin-left: 0.4rem;">Todos los Grupos</label><br>

                                        </div>
                                        --}}
                                        <div class="row justify-content-center text-center align-items-center">
                                            <select multiple="multiple" id="myselect2" name="myselect2[]">
                                            </select>   
                                        </div>     
                                        <br>
                                        <br>

                                        {{--
                                        <div class="row justify-content-center text-center align-items-center">
                                            <div class="col-12 col-sm-3 mt-2">
                                                <button id="myButtonAplicar2" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                                            </div>
                                            <div class="col-12 col-sm-3 mt-2">
                                                <button id="myButtonLimpiar2" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>                        
                                            </div>                
                                        </div>
                                        --}}
                                    </div>
                                </div>
                            </div>          

                        </div>
                    </div>
                </div>
                {{--
                @foreach($role as $roles)
                    <label class="">

                        {!! Form::radio('roles[]', $roles->id, null, ['class'=>'mx-4', 'required' => true]) !!}
                        {{$roles->name}}

                    </label>
                @endforeach
                --}}
        
        
                <hr>

                <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

            </form>
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
    inicializaFiltroWalllets();

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
        


        $('#myButtonLimpiar').on('click', function (){
            $('#myselect').multiSelect('deselect_all');
            
        });

        $('#myButtonAplicar').on('click', function (){

            $("#myTableWallet tr").each(function(){
                if($(this).data("id")){ 
                    $(this).removeAttr("hidden");
                }
            });

            $("#myselect option:selected").each(function(){
                
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
                timer: 2500
                });             
            // window.location.reload();
        });


        $('#myButtonLimpiar2').on('click', function (){
            $('#myselect2').multiSelect('deselect_all');
        });

        $('#myButtonAplicar2').on('click', function (){

            $("#myTableGroup tr").each(function(){
                if($(this).data("id")){
                    $(this).attr("hidden",true);
                }
            });     

            $("#myselect2 option:selected").each(function(){
                
                seleccionado = $(this).attr('value');
                // alert(" seleccionado : " + seleccionado); 
                $("#myTableGroup tr").each(function(){
                    if($(this).data("id")){
                                                
                        if ($(this).data("id") == seleccionado){
                            
                            $(this).attr("hidden",false);
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
                timer: 2500
            }); 
            // window.location.reload();
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
	
	
	
	
    function leeFiltros(){
        
        $.ajax(
            {
                url: "{{route('filtrosRolesWalletLee')}}",
                async: false,
            }
        ).done (function(myData) {
            
            myData2 = myData.data;

        });

        myData2.map( function (valor) {

            $("#myselect option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select').multiSelect('select', valor.toString());

                 }
            });

        });      

        
        
        $.ajax(
            {
                url: "{{route('filtrosRolesGroupsLee')}}",
                async: false,
            }
        ).done (function(myData) {
            
            myData2 = myData.data;

        });

        myData2.map( function (valor) {

            $("#my-select3 option").each(function(){
                 if (valor == $(this).attr('value')){
                    $('#my-select3').multiSelect('select', valor.toString());

                 }
            });

        });      
      




    }

    function grabaFiltros(){

        return;

        let myDataWallet    = buscaFiltrosWallet('myselect');
        let myDataGroup     = buscaFiltrosGroup('myselect2');

        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "{{route('filtrosRolesGraba')}}",
                async: false,
                data: {
                    myDataWallet: myDataWallet,
                    myDataGroup: myDataGroup,

                 },
            }
        ).done (function(myData) {

           // alert('vino');

        });
        return;
    }

    function inicializaFiltroWalllets(){
        $("#all_wallets").prop("checked",true);
        $("#all_groups").prop("checked",true);
        $("#myselect").prop("enable",false);
    }
</script>

@endsection
