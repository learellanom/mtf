@extends('adminlte::page')

@section('title', 'MTF|Clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR CLIENTE <i class="fas fa-user-tag"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
                {!! Form::model($clients,['route' => ['clients.update',$clients],'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}






        <div class="form-group">
            <label for="">Nombre</label>
            <input required type="text" name="name" id="name" class="form-control" value={{ old('name', $clients->name) }}>


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Correo Electronico</label>
            <input required type="text" name="email" id="email" class="form-control" value={{ old('email', $clients->email) }}>


            @error('email')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>

        <div class="form-group">
            <label for="">Telefono</label>
            <input required type="text" name="phone" id="phone" class="form-control" value={{ old('phone', $clients->phone) }}>


            @error('phone')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>

        <div class="form-group">
            {!! Form::Label('group_id', "Grupos:") !!}
            {!! Form::select('group_id', $group, null,['class' => 'form-control', 'value' => $group] )!!}


            @error('group_id')

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
