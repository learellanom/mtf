@extends('adminlte::page')

@section('title', 'MTF| Tipo de Transacción')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR TIPO MOVIMIENTO <i class="fas fa-chart-pie"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
             {!! Form::open(['route' => 'type_transactions.store', 'autocomplete' => 'off', 'files' => true]) !!}


        <div class="form-group">
            {!! Form::Label('name', "Nombre Movimiento:") !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror

        </div>

        <h6 class="font-weight-bold">Tipo de Transaccion del Movimiento: </h6>
        <hr>
        <div class="form-group col-md-12 d-flex justify-content-center">

            <label class="form-check-label mx-auto" for="radio1">
                {!! Form::radio('type_transaction','Transacciones', null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true]) !!}
                Transacciones
            </label>
            <label class="form-check-label mx-auto" for="radio2">
                {!! Form::radio('type_transaction','Efectivo', null, ['id' => 'radio2', 'class' => 'exonerar', 'required' => true]) !!}
                Efectivo
            </label>
            <label class="form-check-label mx-auto" for="radio2">
                {!! Form::radio('type_transaction','Credito', null, ['id' => 'radio2', 'class' => 'exonerar', 'required' => true]) !!}
                Notas de Credito
            </label>


            @error('type_wallet')
            <small class="text-danger">{{$message}}</small>
            @enderror
    </div>
    <hr>


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
</div>
@endsection
