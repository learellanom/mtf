@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVO ROLE') }} <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="card col-md-4">
    <div class="card-body">
<form action={{ route('roles.store')}} method="POST">
@csrf
<ul class="nav nav-pills">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">{{ __('Nombre del rol') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1">{{ __('Permisos') }}</a>
    </li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane container active" id="home">
        <br>
        <div class="form-group">
            <label for="">Nombre del Role/Perfil: </label>
            <input required type="text" name="name" id="name" class="form-control">


            @error('name')

             <span class="text-danger">{{$message}}</span>

            @enderror

        </div>
    </div>


    <div class="tab-pane container fade" id="menu1">

        <br>
        <h4 class="font-weight-bold">{{ __('PERMISOS:') }}</h4>
        <hr>
        @foreach($permisos as $permission)
        <div class="list-group">

            <label class="list-group-item list-group-item-action">

                {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> '', 'id' => $permission->id ]) !!}
                {{$permission->description}}

            </label>
            <hr>
        </div>

        @endforeach


    </div>




  </div>









            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

       </form>
         </div>
    </div>
</div>
@endsection
