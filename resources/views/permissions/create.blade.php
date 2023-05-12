@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVO PERMISO') }} <i class="fas fa-key"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="card col-md-4">
    <div class="card-body">
<form action={{ route('permissions.store')}} method="POST">
@csrf

  <div class="tab-content">
    <div class="form-group">
        <br>
        <div class="form-group">
            <label for="">Nombre del archivo: </label>
            <input required type="text" name="name" id="name" class="form-control" placeholder="Ejemplo: user.index">


            @error('name')

             <span class="text-danger">{{$message}}</span>

            @enderror

        </div>
     </div>


        <br>
        <div class="form-group">
            <label for="">Nombre del permiso: </label>
            <input required type="text" name="description" id="name" class="form-control" placeholder="Ejemplo: Lista de usuarios">


            @error('name')

             <span class="text-danger">{{$message}}</span>

            @enderror

        </div>

        <input required type="hidden" name="guard_name" value="web">


  </div>

            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

       </form>
         </div>
    </div>
</div>
@endsection
