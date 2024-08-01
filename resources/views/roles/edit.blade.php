@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE | PERFIL DE USUARIO <i class="fas fa-user-shield"></i> </h1></a>


@stop

@php

@endphp

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
                        <button class="nav-link active"     id="nav-permisos2-tab"      data-toggle="tab" data-target="#nav-permisos2"      type="button" role="tab" aria-controls="nav-permisos2"      aria-selected="true"><h4>Permisos</h4></button>
                        <button class="nav-link"            id="nav-grupos-tab"         data-toggle="tab" data-target="#nav-grupos"         type="button" role="tab" aria-controls="nav-grupos"         aria-selected="false"><h4>Cajas y Grupos</h4></button>

                    </div>
                </nav>
                <!--
                <br>
                <h4 class="font-weight-bold">{{ __('PERMISOS:') }}</h4>
                <hr>
                -->
                
                <div class="tab-content" id="nav-tabContent" style="min-height: 205rem;">

                                    <!--
                    *
                    *
                    * Permisos2
                    *
                    *
                    -->
                    
                    <div class="tab-pane fade active show" id="nav-permisos2" role="tabpanel" aria-labelledby="nav-permisos2-tab">

                    
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
                                        foreach($roles->permissions as $myPermission){
                                            if ($myPermission->id == $myKey){
                                                $myChecked      = 'checked=checked';
                                            }
                                        }

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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }

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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                            foreach($roles->permissions as $myPermission){
                                                                if ($myPermission->id == $myKey){
                                                                    $myChecked      = 'checked=checked';
                                                                }
                                                            }
                                                        
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
                                                            foreach($roles->permissions as $myPermission){
                                                                if ($myPermission->id == $myKey){
                                                                    $myChecked      = 'checked=checked';
                                                                }
                                                            }
                                                        
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
                                                    @endphp
                                                    <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                    <label for="fname">{{$myDescription}}</label>
                                                    <br><br>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Credito y Debito a Cajas</td>  
                                                <td>
                                                    @for($i = 103; $i <= 104; $i++)
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";

                                                            // inicio - solo para edicion

                                                            foreach($roles->permissions as $myPermission){
                                                                if ($myPermission->id == $myKey){
                                                                    $myChecked      = 'checked=checked';
                                                                }
                                                            }

                                                            // fin - solo para edicion
                                                            
                                                        @endphp
                                                        <input type="checkbox" id="{{$myId}}" name="permissions[]" value="{{$myId}}" {{$myChecked}}>
                                                        <label for="fname">{{$myDescription}}</label>
                                                        <br><br>
                                                    @endfor
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Materiales - Adquisicion</td>  
                                                <td>
                                                    @for($i = 159; $i <= 164; $i++)
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;

                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";

                                                            // inicio - solo para edicion

                                                            foreach($roles->permissions as $myPermission){
                                                                if ($myPermission->id == $myKey){
                                                                    $myChecked      = 'checked=checked';
                                                                }
                                                            }

                                                            // fin - solo para edicion

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
                                                    @for($i = 165; $i <= 170; $i++)
                                                        @php
                                                            $myKey          = $i;
                                                            $myDescription  = $permisos[$myKey]->description ?? 'Sin descripcion';
                                                            $myId           = $permisos[$myKey]->id ?? 0;


                                                            $myName         = "permissions[]";

                                                            $myChecked      = "";
                                                            
                                                            // inicio - solo para edicion

                                                            foreach($roles->permissions as $myPermission){
                                                                if ($myPermission->id == $myKey){
                                                                    $myChecked      = 'checked=checked';
                                                                }
                                                            }

                                                            // fin - solo para edicion

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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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
                                                        foreach($roles->permissions as $myPermission){
                                                            if ($myPermission->id == $myKey){
                                                                $myChecked      = 'checked=checked';
                                                            }
                                                        }
                                                    
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


                    <div class="tab-pane fade " id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">


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

    @php
        use App\Http\Controllers\RoleController;

        $myUserId = $myRole;

        // dd($myUserId);

        // $Group_roles = app(RoleController::class)->getRoleWallets($myUserId);
        // \Log::info('leam - role - edit - group_roles -> ' . print_r($Group_roles,true));

        // dd($Group_roles);
        //dd($roles->id);
    @endphp

     $(document).ready(function () {
         $('#myTable2').DataTable({
            "pageLength": 100
         }); 

         InicializaMultiselects();
         cargaGrupos();
         cargaWallets();
         leeGrupos();

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

    function leeGrupos(){
        
        let allWallets  = ({{$myRoleAllWallets}})    ? {{$myRoleAllWallets}} : "0";
        let allGroups   = ({{$myRoleAllGroups}})     ? {{$myRoleAllGroups}} : "0";

        if (allWallets == "1") {
            
            $('#all_wallets').prop('checked',true);
        }else{
        
            $('#all_wallets').prop('checked',false);
            
            @foreach($myRoleWallets as $myWallets)
                $("#myselect option").each(function(){
                    console.log( 'leam - el valor -> ' +  $(this).val() + ' mi valor -> ' + {{ $myWallets->WalletID }});
                    if($(this).val() == {{ $myWallets->WalletID }}){
                        console.log('leam - encontro');
                        $('#myselect').multiSelect('select', $(this).val());
                    }
                }); 
            @endforeach
             
        }


        if (allGroups == "1") {
            $('#all_groups').prop('checked',true);
        }else{
            $('#all_groups').prop('checked',false);
            @foreach($myRoleGroups  as $myGroups)
                $("#myselect2 option").each(function(){
                    if($(this).val() == {{ $myGroups->GroupID }}){
                        $('#myselect2').multiSelect('select', $(this).val());

                    }
                }); 
            @endforeach
        }

    }



</script>
@endsection
