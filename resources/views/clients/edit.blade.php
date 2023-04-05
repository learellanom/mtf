@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR CLIENTE <i class="fas fa-user-tag"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
                {!! Form::model($clients,['route' => ['clients.update',$clients],'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}






                <div class="form-group">
                    {!! Form::Label('name', "Nombre:") !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


                    @error('name')

                    <span class="text-danger">{{$message}}</span>

                    @enderror

                <div class="form-group">
                    {!! Form::Label('email', "Correo Electronico:") !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true]) !!}


                    @error('email')

                    <span class="text-danger">{{$message}}</span>

                    @enderror
                </div>
                </div>

            <div class="form-group">
                {!! Form::Label('phone', "Telefono:") !!}
                {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}



                @error('phone')

                <span class="text-danger">{{$message}}</span>

                @enderror
            </div>

            {!! Form::Submit('ACTUALIZAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}


            </div>
        </div>
    </div>
</div>
@endsection
