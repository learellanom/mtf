@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR USUARIO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::model($user,['route' => ['users.update', $user], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}

        <div class="form-group">
            <label for="">Nombre</label>
            <input required type="text" name="name" id="name" class="form-control" value={{ old('name', $user->name) }}>


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror


        <div class="form-group">
            <label for="">Correo Electronico</label>
            <input required type="text" name="email" id="email" class="form-control" value={{ old('email', $user->email) }} required>


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
@endsection
