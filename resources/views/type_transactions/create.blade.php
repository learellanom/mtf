@extends('adminlte::page')

@section('title', 'MTF| Tipo de Transacción')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR TIPO MOVIMIENTO <i class="fas fa-chart-pie"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-8">
        <div class="card-body">
             {!! Form::open(['route' => 'type_transactions.store', 'autocomplete' => 'off', 'files' => true]) !!}


            <div class="form-group">
                {!! Form::Label('name', "Nombre Movimiento:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>
            
            <br>
            <h6 class="font-weight-bold">Tipo de Transaccion del Movimiento: </h6>
            <br>
            <div class="form-group col-12  justify-content-center">

                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio1">
                    {!! Form::radio('type_transaction','Transacciones', null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true]) !!}
                    Transacciones
                </label>
                <label class="form-check-label mx-auto  col-12 col-xl-3" for="radio2">
                    {!! Form::radio('type_transaction','Efectivo', null, ['id' => 'radio2', 'class' => 'exonerar', 'required' => true]) !!}
                    Efectivo
                </label>
                <label class="form-check-label mx-auto  col-12 col-xl-3" for="radio2">
                    {!! Form::radio('type_transaction','Credito', null, ['id' => 'radio2', 'class' => 'exonerar', 'required' => true]) !!}
                    Notas de Credito
                </label>

                @error('type_wallet')
                    <small class="text-danger">{{$message}}</small>
                @enderror

            </div>
            <br>
            <hr>       
            
            <h6 class="font-weight-bold">Tipo de Transaccion para Wallet: </h6>
                <br>            
            <div class="form-group col-12  justify-content-center">
                
                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio3">
                    
                    {!! Form::radio('type_transaction_wallet','0', true, ['id' => 'radio3', 'class' => '', 'required' => true]) !!}
                    Sin asignar
                </label>            
                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio3">
                    
                    {!! Form::radio('type_transaction_wallet','1', false, ['id' => 'radio4', 'class' => '', 'required' => true]) !!}
                    Credito
                </label>
                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio4">
                    
                    {!! Form::radio('type_transaction_wallet','2', false, ['id' => 'radio5', 'class' => '', 'required' => true]) !!}
                    Debito    
                </label>

                @error('type_wallet')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <br>

            <hr>
            <h6 class="font-weight-bold">Tipo de Transaccion para Grupo: </h6>
            <br>            
            <div class="form-group col-12  justify-content-center">

                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio3">
                    
                    {!! Form::radio('type_transaction_group','0', true, ['id' => 'radio3', 'class' => '', 'required' => true]) !!}
                    Sin asignar
                </label>            
                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio3">
                    
                    {!! Form::radio('type_transaction_group','1', false, ['id' => 'radio4', 'class' => '', 'required' => true]) !!}
                    Credito
                </label>
                <label class="form-check-label mx-auto col-12 col-xl-3" for="radio4">
                    
                    {!! Form::radio('type_transaction_group','2', false, ['id' => 'radio5', 'class' => '', 'required' => true]) !!}
                    Debito    
                </label>

                @error('type_wallet')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <br>

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
@endsection
