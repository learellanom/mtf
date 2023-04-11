@extends('adminlte::page')

@section('title', 'MTF| Tipo de Moneda')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">EDITAR TIPO MONEDA <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
             {!! Form::model($type_coin, ['route' => ['type_coins.update', $type_coin],'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}


        <div class="form-group">
            {!! Form::Label('name', "Tipo de Moneda:") !!}
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


        {!! Form::Submit('ACTUALIZAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
