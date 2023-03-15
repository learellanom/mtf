@extends('adminlte::page')

@section('title', 'MTF|Clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR CLIENTE <i class="fas fa-user-tag"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::open(['route' => 'clients.store', 'autocomplete' => 'off', 'files' => true]) !!}





        <div class="form-group">
            <label for="">Nombre</label>
            <input required type="text" name="name" id="name" class="form-control">


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Correo Electronico</label>
            <input required type="text" name="email" id="email" class="form-control">


            @error('email')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>

        <div class="form-group">
            <label for="">Telefono</label>
            <input required type="text" name="phone" id="phone" class="form-control">


            @error('phone')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>

        <div class="form-group">
            {!! Form::Label('user_id', "Agentes:") !!}
            {!! Form::select('user_id', $user, null,['class' => 'form-control'])!!}


            @error('user_id')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>


        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
