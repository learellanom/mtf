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
    <input type="text" class="form-control" name="name" placeholder="Nombre del usuario">

    @error('name')

    <span class="text-danger">{{$message}}</span>

    @enderror
</div>
    </form>
    </div>
</div>
@endsection