@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR USUARIO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
 <div class="card col-md-4">
    <div class="card-body">
        {!! Form::model($user,['route' => ['users.update_users', $user], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}

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

        @foreach($roles as $role)
            <div>
                <label>
                    {!! Form::checkbox('roles[]', $role->id, null, ['class'=>'mr-1']) !!}
                    {{$role->name}}

                </label>
            </div>
        @endforeach
            {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}

    </div>
  </div>
</div>

@endsection
