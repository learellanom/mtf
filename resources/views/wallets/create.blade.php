@extends('adminlte::page')

@section('title', 'Cajas')

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
                {!! Form::Label('direction', "Dirección:") !!}
            {!! Form::text('direction', null, ['class' => 'form-control', 'required' => true]) !!}

            @error('direction')
               <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


            <div class="form-group">

                {!! Form::Label('user[]', "Agente:") !!}
                {!! Form::select('user[]', $users, null, ['class' => 'form-control user', 'multiple' => 'multiple']) !!}

                @error('user[]')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <h6 class="font-weight-bold">Tipo de caja: </h6>
            <hr>
            <div class="form-group col-md-12 d-flex justify-content-center">

                <label class="form-check-label mx-auto" for="radio1">
                    {!! Form::radio('type_wallet','Transacciones', null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true]) !!}
                    Para transacciones
                </label>
                <label class="form-check-label mx-auto" for="radio2">
                    {!! Form::radio('type_wallet','Efectivo', null, ['id' => 'radio2', 'class' => 'exonerar', 'required' => true]) !!}
                    Para efectivo
                </label>


                @error('type_wallet')
                <small class="text-danger">{{$message}}</small>
                @enderror
        </div>
        <hr>
        <div class="form-group">
            {!! Form::Label('description', "Observación:") !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true]) !!}

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
    maximumSelectionLength: 5,
    width: '100%'

  });
</script>
@endsection

