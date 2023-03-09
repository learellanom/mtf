@extends('adminlte::page')

@section('title', 'ROLES')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO ROLE <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="card col-md-3">
    <div class="card-body">
<form action={{ route('roles.store')}} method="POST">
@csrf
        <div class="form-group">
            <label for="">Nombre del rol</label>
            <input required type="text" name="name" id="name" class="form-control">
            

            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror

        </div>


            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button> 

       </form>
         </div>
    </div>
</div>
@endsection