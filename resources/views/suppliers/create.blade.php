@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR PROVEEDORES <i class="fas fa-wallet"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::open(['route' => 'suppliers.store', 'autocomplete' => 'off', 'files' => true]) !!}

        <div class="form-group">
            <div class="form-group">
                {!! Form::Label('name', "Nombre:") !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}

            @error('name')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>







            <div class="form-group">
                {!! Form::Label('phone', "Telefono:") !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}

            @error('phone')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


         </div>


        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')


@endsection
