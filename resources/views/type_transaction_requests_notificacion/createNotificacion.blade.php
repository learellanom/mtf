@extends('adminlte::page')

@section('title', 'MTF| Tipo de Notificacion')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR TIPO DE NOTIFICACION <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            {!! Form::open(['route' => 'type_transaction_requests_notificacion_store', 'autocomplete' => 'off', 'files' => true]) !!}

            <input type="hidden" id="type_request" name="type_request" value="2">

            <div class="form-group">
                {!! Form::Label('name', "Tipo de solicitud:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>


            <div class="form-group">
                {!! Form::Label('description', "Observación:") !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true]) !!}

                @error('description')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}
        </div>
    </div>

</div>
@endsection
