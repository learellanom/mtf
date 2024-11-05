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
                        {{-- <button class="nav-link " id="nav-permisos-tab"   data-toggle="tab" data-target="#nav-permisos"   type="button" role="tab" aria-controls="nav-permisos"  aria-selected="true"><h4>Permisos</h4></button> --}}
                        <button class="nav-link active"        id="nav-permisos2-tab"  data-toggle="tab" data-target="#nav-permisos2"  type="button" role="tab" aria-controls="nav-permisos2"  aria-selected="true"><h4>Permisos</h4></button>
                        <button class="nav-link"        id="nav-grupos-tab"     data-toggle="tab" data-target="#nav-grupos"     type="button" role="tab" aria-controls="nav-grupos"    aria-selected="false"><h4>Cajas y Grupos</h4></button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent" style="min-height: 205rem;">
                    {{--
                    <div class="tab-pane fade" id="nav-permisos" role="tabpanel" aria-labelledby="nav-permisos-tab">
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
                    --}}

                    <div class="tab-pane fade  show active" id="nav-permisos2" role="tabpanel" aria-labelledby="nav-permisos2-tab">

                    
                        <div class="row card-deck justify-content-center mt-4 mb-4">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Sesion</h3>
                                </div>
                                <div class="card-body">    

                                    @php
                                        $myKey          = 52;
                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                        $myId           = $permisos[$myKey]->id ?? 0;
                                        $myName         = "permissions[]";

                                        $myChecked      = "";
                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}

                                    @endphp
                                    <input type="checkbox" id="{{$myId}}" name="{{$myName}}" value="{{$myId}}" {{$myChecked}}>
                                    <label for="fname">{{$myDescription}}</label>
                                    <br><br>
                                </div>
                            </div>
                        </div>



                        <div class="row card-deck justify-content-center mt-4 mb-4">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Estadisticas</h3>
                                </div>
                                <div class="card-body">    

                                    <table id="myTable" class="table table-bordered table-responsive-lg">   

                                        <tbody>
                                            <tr>
                                                <td class="col-12 col-md-6" style="width: 30rem;">Estadisticas</td>
                                                <td class="col-12 col-md-6">
                                                    @php
                                                        $myKey          = 53;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;
                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}

                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Consolidado de Saldos</td>                                                    
                                                <td>
                                                    @php
                                                        $myKey          = 126;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;
                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 134;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;
                                                        $myName = ""
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Detalle de Movimientos</td>  
                                                <td>
                                                @php
                                                        $myKey          = 84;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;

                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Comisiones - Consolidado</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 128;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 137;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Comisiones - Grupos</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 129;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 139;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Comisiones - Detalle USDT</td>  
                                                <td>
                                                @php
                                                        $myKey          = 143;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Comisiones - Resumen Grupo USDT</td>  
                                                <td>
                                                @php
                                                        $myKey          = 144;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Comisiones - Genera Comisiones USDT</td>  
                                                <td>
                                                @php
                                                        $myKey          = 145;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>USDT</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 132;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 181;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>                                                    


                                                    @php
                                                        $myKey          = 133;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Resumen - Grupo</td>  
                                                <td>
                                                @php
                                                        $myKey          = 152;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Resumen - Caja</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 87;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>                                            

                                            <tr>
                                                <td>Resumen - Caja Transaccion</td>  
                                                <td>
                                                @php
                                                        $myKey          = 112;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>       

                                            <tr>
                                                <td>Resumen - Caja Transaccion Grupo</td>  
                                                <td>
                                                @php
                                                        $myKey          = 121;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>       

                                            <tr>
                                                <td>Resumen - Fecha Token</td>  
                                                <td>
                                                @php
                                                        $myKey          = 122;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>  

                                            <tr>
                                                <td>Consolidado de Movientos</td>  
                                                <td>
                                                @php
                                                        $myKey          = 153;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>  

                                            <tr>
                                                <td>Materiales Resumen</td>  
                                                <td>
                                                    @for($i = 176; $i <= 180; $i++)
                                                        @if($i == 177 || $i == 179)
                                                            @continue
                                                        @endif
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";
                                                            //foreach($roles->permissions as $myPermission){
                                                            //    if ($myPermission->id == $myKey){
                                                            //        $myChecked      = 'checked=checked';
                                                            //    }
                                                            //}
                                                        
                                                        @endphp
                                                        <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                        <label for="fname">{{$myDescription}}</label>
                                                        <br><br>
                                                    @endfor          
                                                    

                                                </td>

                                            </tr> 


                                            <tr>
                                                <td>Materiales Liquidacion y Cierre</td>  
                                                <td>
                                                    @for($i = 177; $i <= 179; $i++)
                                                        @if($i == 178)
                                                            @continue
                                                        @endif
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";
                                                            //foreach($roles->permissions as $myPermission){
                                                            //    if ($myPermission->id == $myKey){
                                                            //        $myChecked      = 'checked=checked';
                                                            //    }
                                                            //}
                                                        
                                                        @endphp
                                                        <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                        <label for="fname">{{$myDescription}}</label>
                                                        <br><br>
                                                    @endfor                                                    
                                                </td>

                                            </tr> 

                                        </tbody>
                                    </table>




                                </div>
                            </div>
                        </div> 


                        <div class="row card-deck justify-content-center mt-4 mb-4">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Operaciones</h3>
                                </div>
                                <div class="card-body">    

                                    <table id="myTable" class="table table-bordered table-responsive-lg">   

                                        <tbody>
                                            <tr>
                                                <td class="col-12 col-md-6" style="width: 30rem;">Transacciones</td>  
                                                <td class="col-12 col-md-6">
                                                    @php
                                                        $myKey          = 98;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 99;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 102;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 108;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Transacciones v2</td>                                                    
                                                <td>
                                                    @php
                                                        $myKey          = 148;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 149;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>


                                                    @php
                                                        $myKey          = 150;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    
                                                    
                                                    @php
                                                        $myKey          = 151;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>


                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Transacciones en Efectivo</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 100;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 101;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Transferencia entre Cajas - Efectivo</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 113;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 114;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Transferencia entre Cajas - Otras Operaciones</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 140;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>




                                                    @php
                                                        $myKey          = 141;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>


                                                    @php
                                                        $myKey          = 155;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Transaferencia entre Cajas Otras Operaciones v2</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 146;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 147;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>



                                                    @php
                                                        $myKey          = 151;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Pagos del Proveedor</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 115;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 116;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Cobros del Proveedor</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 119;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 120;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Pagos Entre Clientes</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 117;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 118;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Credito y Debito a Cajas</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 103;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 104;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Materiales - Adquisicion</td>  
                                                <td>
                                                    @for($i = 159; $i <= 163; $i++)
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";
                                                            //foreach($roles->permissions as $myPermission){
                                                            //    if ($myPermission->id == $myKey){
                                                            //        $myChecked      = 'checked=checked';
                                                            //    }
                                                            //}
                                                        
                                                        @endphp
                                                        <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                        <label for="fname">{{$myDescription}}</label>
                                                        <br><br>
                                                    @endfor
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Materiales - Recepcion</td>  
                                                <td>
                                                    @for($i = 164; $i <= 168; $i++)
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";
                                                            //foreach($roles->permissions as $myPermission){
                                                            //    if ($myPermission->id == $myKey){
                                                            //        $myChecked      = 'checked=checked';
                                                            //    }
                                                            //}
                                                        
                                                        @endphp
                                                        <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                        <label for="fname">{{$myDescription}}</label>
                                                        <br><br>
                                                    @endfor                                                    
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>




                                </div>
                            </div>
                        </div> 



                        <div class="row card-deck justify-content-center">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Configuracion</h3>
                                </div>
                                <div class="card-body">    


                                    <table id="myTable" class="table table-bordered table-responsive-lg">   

                                        <tbody>
                                            <tr>
                                                <td class="col-12 col-md-6" style="width: 30rem;">Usuarios</td>  
                                                <td class="col-12 col-md-6">
                                                    @php
                                                        $myKey          = 70;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 71;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 72;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 73;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 74;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Roles</td>                                                    
                                                <td>
                                                    @php
                                                        $myKey          = 54;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 55;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 56;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 57;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Permisos</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 111;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Grupos y Cajas</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 62;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 63;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 64;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                    @php
                                                        $myKey          = 65;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                        //    if ($myPermission->id == $myKey){
                                        //        $myChecked      = 'checked=checked';
                                        //    }
                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tipos de Movimiento</td>  
                                                <td>
                                                @php
                                                        $myKey          = 75;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 76;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 77;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tipo de Monedas</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 78;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 79;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 80;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tipo de Material</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 156;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 157;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                  
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>  

                                                    @php
                                                        $myKey          = 158;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>                                                    
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Tipo de Solicitud</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 183;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 184;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                    @php
                                                        $myKey          = 185;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;


                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>


                                            </tr>

                                        </tbody>
                                    </table>




                                </div>
                            </div>
                        </div>    

                        <div class="row card-deck justify-content-center">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Usuario Externos</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row card-deck justify-content-center">
                            <div class="card mb-4 col-12 col-sm-8 lm-2">
                                <div class="card-header">
                                    <h3 class="card-title text-uppercase font-weight-bold">Estadisticas</h3>
                                </div>
                                <div class="card-body">    

                                    <table id="myTable" class="table table-bordered table-responsive-lg">   

                                        <tbody>
                                            <tr>
                                                <td>Detalle de Movimientos</td>  
                                                <td>
                                                    @php
                                                        $myKey          = 182;
                                                        $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                        $myId           = $permisos[$myKey]->id ?? 0;

                                                        $myName         = "permissions[]";

                                                        $myChecked      = "";
                                                        //foreach($roles->permissions as $myPermission){
                                                        //    if ($myPermission->id == $myKey){
                                                        //        $myChecked      = 'checked=checked';
                                                        //    }
                                                        //}
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                       
                        
                    </div>




                    <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
                        {{-- With multiple slots and multiple options --}}

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
         @php
          //  $usuario = auth()->user()->id;
            


            // dd(auth()->user()->roles);

        //  foreach(auth()->user()->roles as $roles)
        //  {
        //     if($roles->name == 'Administrador' || $roles->name == 'Supervisor'){        
        //         dd($roles->id . ' ' . $roles->name);
        //          return true;
        //     }
        //  }

        //    dd($usuario) ;


        @endphp
         $('#all_wallets, #all_groups').on('click', function (){
            
            if ($('#all_wallets').prop('checked') ){
                $('#myselect').multiSelect('deselect_all');
                // alert('aqui');
            }
            if ($('#all_groups').prop('checked') ){
                $('#myselect2').multiSelect('deselect_all');
            }

        });

        $('#myselect, #myselect2').on('change', function (){


            let myCount;
            myCount = 0;
            $("#myselect option:selected").each(function(){
                myCount++
            });
            if (myCount > 0){
                $('#all_wallets').prop('checked',false);
            }else{
                $('#all_wallets').prop('checked',true);
            }

            myCount = 0;
            $("#myselect2 option:selected").each(function(){
                myCount++
            });
            if (myCount > 0){
                $('#all_groups').prop('checked',false);
            }else{
                $('#all_groups').prop('checked',true);
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