@extends('adminlte::page')

@section('title', 'MTF| Tipo de Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR TIPO DE SOLICITUD <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            {!! Form::open(['route' => 'type_transaction_requests.store', 'autocomplete' => 'off', 'files' => true]) !!}


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
