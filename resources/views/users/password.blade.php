@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CAMBIO DE CONTRASEÑA <i class="fas fa-user-lock"></i></h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
  <div class="card col-md-4">
    <div class="card-body">
        {!! Form::model($user,['route' => ['users.update_password', $user], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}


        <div class="form-group">
            <div class="form-group">
                <label for="">Nueva Contraseña</label>
                <input id="password" type="password" class="form-control"  name="password" autocomplete="new-password" placeholder="********">


                @error('password')

                <span class="text-danger">{{$message}}</span>

                @enderror
            </div>
            <div class="form-group">
                <label for="">Confirma Contraseña</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="********">

            </div>
        </div>


            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Actualizar</button>

            {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
