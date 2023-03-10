@extends('adminlte::page')

@section('title', 'MTF|Grupos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR GRUPOS <i class="fab fa-whatsapp-square"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::open(['route' => 'clients.store', 'autocomplete' => 'off', 'files' => true]) !!}





        <div class="form-group">
            <label for="">Nombre del grupo</label>
            <input required type="text" name="name" id="name" class="form-control">


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Telefono administrador</label>
            <input required type="text" name="phone" id="phone" class="form-control">


            @error('phone')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>


        <div class="form-group">
            {!! Form::Label('description', "Observación:") !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

        @error('description')
           <small class="text-danger">{{$message}}</small>
        @enderror
        </div>


        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
