@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE | PERFIL DE USUARIO <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-8">
        <div class="card-body">
            {!! Form::model($roles,['route' => ['roles.update', $roles], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}
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
                    <label for=""> </label>
                    {!! Form::Label('name', 'Nombre del Role/Perfil: ') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}


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
                <!--
                <br>
                <h4 class="font-weight-bold">{{ __('PERMISOS:') }}</h4>
                <hr>
                -->

                <div class="tab-content" id="nav-tabContent" style="height: 205rem;">
                    <div class="tab-pane fade show active" id="nav-permisos" role="tabpanel" aria-labelledby="nav-permisos-tab">

                        <table id="myTable" class="table table-bordered table-responsive-lg">   
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


                        <div class="row card-deck mt-4 justify-content-center">
                                <div class="card mb-4 col-12 col-sm-6">
                                    <div class="card-header">   
                                        <h3 class="card-title text-uppercase font-weight-bold">Wallet</h3>
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

</script>
@endsection
