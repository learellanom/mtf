@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE | PERFIL DE USUARIO <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="card col-md-4">
    <div class="card-body">
        {!! Form::model($permisos,['route' => ['permissions.update', $permisos], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}

    <div class="tab-content">
        <div class="tab-pane container active" id="home">
            <br>
            <div class="form-group">
                <label for=""> </label>
                {!! Form::Label('name', 'Nombre del Permiso: ') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>

            <div class="form-group">
                <label for=""> </label>
                {!! Form::Label('description', 'Nombre descriptivo del permiso') !!}
                {!! Form::text('description', null, ['class' => 'form-control', 'required']) !!}


                @error('description')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>

            <input required type="hidden" name="guard_name" value="web">


        </div>







        </div>









            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

       </form>
         </div>
    </div>
</div>
@endsection
