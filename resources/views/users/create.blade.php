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
        @foreach($role as $roles)
        <label class="">

            {!! Form::radio('roles[]', $roles->id, null, ['class'=>'mx-4', 'required' => true]) !!}
            {{$roles->name}}

        </label>
        @endforeach
        <hr>

            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

       </form>
      </div>
    </div>
</div>
@endsection
