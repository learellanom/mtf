@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="card">
    <div class="card-body">
<form action={{ route('roles.update', $roles)}} method="POST">
@csrf
@method('put')
        <div class="form-group">
            <label for="">Nombre del rol</label>
            <input required type="text" name="name" id="name" class="form-control" value="{{old('name', $roles->name)}}">
            

            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror

        </div>


            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Actualizar</button> 

       </form>
    </div>
</div>
@endsection