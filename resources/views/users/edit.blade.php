@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR USUARIO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="card">
    <div class="card-body">
<form method="post" action={{ route('users.update', $user)}} >
    @csrf
    @method('patch')
        
        <div class="form-group">
            <label for="">Nombre</label>
            <input required type="text" name="name" id="name" class="form-control" value={{ old('name', $user->name) }}>
            

            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Correo Electronico</label>
            <input required type="text" name="email" id="email" class="form-control" value={{ old('email', $user->email) }}>
            

            @error('email')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>
        

        <div class="form-group">
            <label for="">Nueva Contraseña</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            

            @error('password')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        <div class="form-group">
            <label for="">Confirma Contraseña</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            
        </div>

            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button> 

       </form>
       
    </div>
</div>
@endsection