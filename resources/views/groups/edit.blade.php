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


            <div class="form-group">

                {!! Form::Label('user[]', "Agente:") !!}
                {!! Form::select('user[]', $users, null, ['class' => 'form-control user', 'multiple' => 'multiple']) !!}

                @error('user[]')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <hr>

            <div class="custom-control custom-radio custom-control-inline">
              {!! Form::radio('type','1', null, ['id' => 'radio1', 'class' => 'custom-control-input cliente', 'required' => true]) !!}
              <label class="custom-control-label" for="radio1">Tipo cliente</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              {!! Form::radio('type','2', null, ['id' => 'radio2', 'class' => 'custom-control-input caja', 'required' => true]) !!}
              <label class="custom-control-label" for="radio2">Tipo Caja</label>
            </div>


            <div class="custom-control custom-radio custom-control-inline" id="radio3">
              {!! Form::radio('type_wallet','Efectivo', null, ['id' => 'radio5', 'class' => 'custom-control-input', 'required' => true,]) !!}
              <label class="custom-control-label" for="radio5">Efectivo</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline" id="radio4">
              {!! Form::radio('type_wallet','Transacciones', null, ['id' => 'radio6', 'class' => 'custom-control-input', 'required' => true]) !!}
              <label class="custom-control-label" for="radio6">Transferencias</label>
            </div>

          <hr>

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
            maximumSelectionLength: 5,
            width:'100%',
        });

        const cliente = document.getElementById('radio1');
        const caja = document.getElementById('radio2');

        const efectivo = document.getElementById('radio3');
        const transferencias = document.getElementById('radio4');

        const efectivo_radio = document.getElementById('radio5');
        const transferencias_radio = document.getElementById('radio6');

        caja.addEventListener('change', () => {
        if (caja.checked) {
            efectivo.style.display = 'block';
            transferencias.style.display = 'block';
        }
        });
        if (caja.checked) {
            efectivo.style.display = 'block';
            transferencias.style.display = 'block';
        }
        cliente.addEventListener('change', () => {
        if (cliente.checked) {
            efectivo.style.display = 'none';
            transferencias.style.display = 'none';
            efectivo_radio.checked = false;
            transferencias_radio.checked = false;
         }
        });
        if (cliente.checked) {
            efectivo.style.display = 'none';
            transferencias.style.display = 'none';
            efectivo_radio.checked = false;
            transferencias_radio.checked = false;
         }
    </script>
    @endsection
