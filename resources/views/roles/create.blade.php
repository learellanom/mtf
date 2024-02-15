@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVO ROLE') }} <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-8">
        <div class="card-body">




            <form action={{ route('roles.store')}} method="POST">
                @csrf

                
                <div class="row">
                    <div class="col-xl-8 mb-4">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#home">Nombre del rol</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#menu1">Permisos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-2 mb-4 justify-content-end">
                        <button class="btn btn-primary font-weight-bold btn-block" type="submit">Guardar</button>
                    </div>
                </div>
                <br>
                <div class="form-group">

                    <label for="">Nombre del Role/Perfil: </label>
                    <input required type="text" name="name" id="name" class="form-control">

                    @error('name')

                    <span class="text-danger">{{$message}}</span>

                    @enderror

                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-permisos-tab"   data-toggle="tab" data-target="#nav-permisos"   type="button" role="tab" aria-controls="nav-permisos"  aria-selected="true"><h4>Permisos</h4></button>
                        <button class="nav-link"        id="nav-grupos-tab"     data-toggle="tab" data-target="#nav-grupos"     type="button" role="tab" aria-controls="nav-grupos"    aria-selected="false"><h4>Cajas y Grupos</h4></button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent" style="height: 205rem;">
                    <div class="tab-pane fade show active" id="nav-permisos" role="tabpanel" aria-labelledby="nav-permisos-tab">
                        <!--
                        <br>
                        <h4 class="font-weight-bold">{{ __('PERMISOS:') }}</h4>
                        <hr>
                        -->
                        {{--
                        @foreach($permisos as $permission)
                            <div class="list-group">
                                <label class="list-group-item list-group-item-action">

                                    {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> '', 'id' => $permission->id ]) !!}
                                    {{$permission->description}}

                                </label>
                                <hr>
                            </div>
                        @endforeach
                        --}}
                        <table id="myTable" class="table table-bordered table-responsive-lg mt-4">   
                            <thead>
                                <tr>
                                    <th style="width: 80%;">Nombre</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permisos as $permission)
                                    <tr>
                                        <td>{{$permission->description}}</td>
                                        <td>{!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> '', 'id' => $permission->id ]) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show active" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
                        {{-- With multiple slots and multiple options --}}

                        <div class="row card-deck mt-4 justify-content-center">
                            <div class="card mb-4 col-12 col-sm-6">
                                <div class="card-header">   
                                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Wallet</h3>
                                </div>
                                <div class="card-body">  
                                    
                                        <div class="row justify-content-center text-center align-items-center mt-4 mb-4"> 
                                            <input type="checkbox" id="all_wallets" name="all_wallets" value="1">
                                            <label for="all_wallets" style="margin-top: 0.4rem; margin-left: 0.4rem;">Todas las Cajas</label><br>
                                        </div>                                
                                         
                                    <div class="row justify-content-center text-center align-items-center">
                                        <select multiple="multiple" id="myselect" name="myselect[]" readonly>
                                        </select>
                                    </div>     
                                    <br>
                                    <br>
                                    <div class="row justify-content-center text-center align-items-center">
                                        <div class="col-12 col-sm-3 mt-2">
                                            <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                                        </div>
                                        <div class="col-12 col-sm-3 mt-2">
                                            <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                                        </div>                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row card-deck justify-content-center">
                            <div class="card mb-4 col-12 col-sm-6 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Grupos</h3>
                                </div>
                                <div class="card-body">    

                                    <div class="row justify-content-center text-center align-items-center mt-4 mb-4"> 
                                        <input type="checkbox" id="all_groups" name="all_groups" value="1">
                                        <label for="all_groups" style="margin-top: 0.4rem; margin-left: 0.4rem;">Todos los Grupos</label><br>

                                    </div>
                                    <div class="row justify-content-center text-center align-items-center">
                                        <select multiple="multiple" id="myselect2" name="myselect2[]">
                                        </select>   
                                    </div>     
                                    <br>
                                    <br>
                                    <div class="row justify-content-center text-center align-items-center">
                                        <div class="col-12 col-sm-3 mt-2">
                                            <button id="myButtonAplicar2" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                                        </div>
                                        <div class="col-12 col-sm-3 mt-2">
                                            <button id="myButtonLimpiar2" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>                        
                                        </div>                
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    
     $(document).ready(function () {
         $('#myTable2').DataTable({
            "pageLength": 100
         }); 

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
            $('#my-select2').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            

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
        let myDataGroup     = buscaFiltrosGroup('my-select2');

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