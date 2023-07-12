@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('CREAR GRUPOS') }} <i class="fab fa-whatsapp-square"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
        <div class="card col-md-4">
            <div class="card-body">
            {!! Form::open(['route' => 'groups.store', 'autocomplete' => 'off', 'files' => true]) !!}





        <div class="form-group">
            {!! Form::Label('name', "Nombre del grupo:") !!}
            {!! Form::text('name', null, ['class' => 'form-control','required' => true]) !!}


            @error('name')

            <span class="text-danger">{{$message}}</span>

            @enderror
            <div class="valid-feedback">
                Looks good!
            </div>

        <div class="form-group">
            {!! Form::Label('phone', "Telefono del administrador:") !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}


            @error('phone')

            <span class="text-danger">{{$message}}</span>

            @enderror
        </div>
        </div>

     {{--    <div class="form-group">

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

        <label class="form-check-label mx-auto" for="radio1">
            {!! Form::radio('type','1', null, ['id' => 'radio1', 'class' => 'form-radio cliente', 'required' => true]) !!}
             Tipo cliente
        </label>

        <label class="form-check-label mx-auto" for="radio2">
            {!! Form::radio('type','2', null, ['id' => 'radio2', 'class' => 'form-radio caja', 'required' => true]) !!}
            Tipo Caja
        </label>

        <label class="form-check-label mx-auto" for="radio3" style = 'display:none;' id="radio3">
            {!! Form::radio('type_wallet','Efectivo', null, ['id' => 'radio3', 'class' => 'form-radio', 'required' => true,]) !!}
             Efectivo
        </label>
        <label class="form-check-label mx-auto" for="radio4" style = 'display:none;' id="radio4">
            {!! Form::radio('type_wallet','Transferencias', null, ['id' => 'radio4', 'class' => 'form-radio', 'required' => true]) !!}
            Transferencias
        </label>

        <div class="form-group">
            {!! Form::Label('description', "Observación:") !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true]) !!}

        @error('description')
           <small class="text-danger">{{$message}}</small>
        @enderror
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
        placeholder: "Seleccionar Agentes",
        theme: 'bootstrap4',
        maximumSelectionLength: 5

      });

      $(".client").select2({
        allowClear: true,
        placeholder: "Seleccionar Cliente",
        theme: 'bootstrap4'
        //maximumSelectionLength: 5

      });
      $(".client").val("")
      $(".client").trigger("change");

const cliente = document.getElementById('radio1');
const caja = document.getElementById('radio2');

const efectivo = document.getElementById('radio3');
const transferencias = document.getElementById('radio4');

caja.addEventListener('change', () => {
  if (cliente.checked) {
    efectivo.style.display = 'none';
    transferencias.style.display = 'none';
  } else {
    efectivo.style.display = 'block';
    transferencias.style.display = 'block';
  }
});


</script>
@endsection
