@extends('adminlte::page')

@section('title', 'CAJAS')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR CAJA <i class="fas fa-wallet"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::open(['route' => 'wallets.store', 'autocomplete' => 'off', 'files' => true]) !!}





        <div class="form-group">
            <div class="form-group">
                {!! Form::Label('name', "Nombre:") !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}

            @error('name')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


            <div class="form-group">
                {!! Form::Label('base', "Base de la caja:") !!}
            {!! Form::number('base', null, ['class' => 'form-control', 'min' => 0]) !!}

            @error('base')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


            <div class="form-group">
                {!! Form::Label('direction', "Dirección:") !!}
            {!! Form::text('direction', null, ['class' => 'form-control']) !!}

            @error('direction')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>

            <div class="form-group">
                {!! Form::Label('user_id', "Agente:") !!}
                {!! Form::select('user_id', $user, null, ['class' => 'form-control user']) !!}

                @error('user_id')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

        <div class="form-group">
            {!! Form::Label('description', "Observación:") !!}
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

            @error('description')
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
<script>
$(".user").select2({
    allowClear: true,
    placeholder: "Seleccionar Agente",
    theme: 'bootstrap4',

  });
</script>
@endsection
