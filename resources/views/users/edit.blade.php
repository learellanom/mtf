@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR USUARIO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="card">
    <div class="card-body">
<form action={{ route('users.update', $user)}} method="POST">
@method('PUT')
        <div class="form-group">
            <label for="">Nombre</label>
            <input required type="text" name="name" id="name" class="form-control" value={{old('name') }}>
            

            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Correo Electronico</label>
            <input required type="text" name="email" id="email" class="form-control" value={{ old('email') }}>
            

            @error('email')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>

        <div class="form-group">
            <label for="">Contraseña</label>
            <input required type="text" name="password" id="password" class="form-control" value={{ old('password') }}>
            

            @error('password')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        <div class="form-group">
            <label for="">Confirma Contraseña</label>
            <input required type="text" name="password" id="password" class="form-control" value={{ old('password') }}>
            

            @error('password')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>

            <button class="btn btn-primary">Actualizar</button> 

       </form>
    </div>
</div>
@endsection