@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">EDITAR GRUPO <i class="fab fa-whatsapp-square"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::model($group,['route' => ['groups.update',$group], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}


            <div class="form-group">
                {!! Form::Label('name', "Nombre del grupo:") !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror


            <div class="form-group">
                {!! Form::Label('phone', "Telefono del administrador:") !!}
                {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}


                @error('phone')

                <span class="text-danger">{{$message}}</span>

                @enderror
            </div>
            </div>

        {{--     <div class="form-group">

                {!! Form::Label('client_id', "Cliente:") !!}
                {!! Form::select('client_id', $clients, null, ['class' => 'form-control client']) !!}

                @error('client_id')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div> --}}

            <div class="form-group">

                {!! Form::Label('user[]', "Agente:") !!}
                {!! Form::select('user[]', $users, null, ['class' => 'form-control user', 'multiple' => 'multiple']) !!}

                @error('user[]')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::Label('description', "Observación:") !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true]) !!}

            @error('description')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


            {!! Form::Submit('MODIFICAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        $(".user").select2({
            allowClear: true,
            empty: true,
            placeholder: "Seleccionar Agente",
            theme: 'bootstrap4',
            maximumSelectionLength: 5
        });

          $(".client").select2({
            allowClear: true,
            empty: true,
            placeholder: "Seleccionar Cliente",
            theme: 'bootstrap4',
            maximumSelectionLength: 5

          });
    </script>
    @endsection
