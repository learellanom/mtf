@extends('adminlte::page')

@section('title', 'MTF| Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR SOLICITUD <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            {!! Form::open(['route' => 'transaction_requests.store', 'autocomplete' => 'off', 'files' => true]) !!}

            
            <input type="hidden" id="user_id"       name="user_id">

            <div class="form-group">
                {!! Form::Label('name', "Tipo de solicitud:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>

            <div class="form-group col-md-4">
                <label for="amount">Monto:</label>
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                    <input class="form-control general" type="text" id="amount" name="amount" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-xl-4">
                    <!-- {!! Form::Label('transaction_date', "Fecha:") !!} -->
                    <label for="transaction_date">Fecha:</label>
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                        <!-- {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'transaction_date']) !!} -->
                        <input type="datetime-local" id="transaction_date" value="2014-11-16T15:25:33">

                    </div>
                </div>                    
            </div>

            <div class="form-group">
                <label for="userName">Usuario:</label>
                <label class= "form-control" id="userName" name="userName" value='{{$user->name ?? ""}}'></label>
            </div>

            <div class="form-group">
                <label for="groupName">Grupo:</label>
                <input class="form-control" type="text" id="groupName" name="groupName">             

            </div>

            <div class="form-group">
                <label for="note">Notas:</label>
                <input class="form-control" type="text" id="note" name="note">             


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
