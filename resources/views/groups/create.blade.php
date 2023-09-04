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
                </div>

                
                <div class="form-group">
                    {!! Form::Label('phone', "Telefono del administrador:") !!}
                    {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}


                    @error('phone')

                    <span class="text-danger">{{$message}}</span>

                    @enderror
                </div>


            <div class="form-group">

                {!! Form::Label('user[]', "Agente:") !!}
                {!! Form::select('user[]', $users, null, ['class' => 'form-control user', 'multiple' => 'multiple']) !!}

                @error('user[]')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            
            <br>
            <div class="form-group col-12">
                <h5>Tipo</h5>
                <hr>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('type','1', null, ['id' => 'radio1', 'class' => 'custom-control-input cliente', 'required' => true]) !!}
                    <label class="custom-control-label" for="radio1">Grupo</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('type','2', null, ['id' => 'radio2', 'class' => 'custom-control-input caja', 'required' => true]) !!}
                    <label class="custom-control-label" for="radio2">Caja</label>
                </div>              
            </div>

            
            <hr>
            {{--
            *
            *
            * Proveedor
            *
            *
            *
            --}}
            <br>
            <div class="form-group col-12">
                

                <div class="custom-control custom-control-inline">
                    {!! Form::checkbox('provider','1', false, ['id' => 'proveedor', 'class' => 'custom-control-input cliente', 'required' => false]) !!}
                    <label class="custom-control-label" for="proveedor">Proveedor</label>
                </div>
            </div>

            <br>

            <h5>Uso de Caja</h5>
            <br><br>
            <div class="custom-control custom-radio custom-control-inline" id="radio3">
                {!! Form::radio('type_wallet','Efectivo', null, ['id' => 'radio5', 'class' => 'custom-control-input', 'required' => true,]) !!}
                <label class="custom-control-label" for="radio5">Efectivo</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline" id="radio4">
                {!! Form::radio('type_wallet','Transacciones', null, ['id' => 'radio6', 'class' => 'custom-control-input', 'required' => true]) !!}
                <label class="custom-control-label" for="radio6">Transferencias</label>
            </div>

            <br><br><br>

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
@endsection

@section('js')
<script>
    $(".user").select2({
        allowClear: true,
        placeholder: "Seleccionar Agentes",
        theme: 'bootstrap4',
        maximumSelectionLength: 10,
        width: '100%',

      });

      $('#radio1').on('click', function (){

          $("#proveedor").removeAttr("checked");
          $("#proveedor").attr("disabled","true");
          // $("#proveedor").attr("required",false);


          $("#radio5").attr("disabled","true");
          
          $("#radio6").attr("disabled","true");

          $('input[name=type_wallet]').prop('checked',false);

          
      });

      $('#radio2').on('click', function (){

          $('input[name=provider]').prop('checked',false); 
          $("#proveedor").attr("disabled",false);
          // $("#proveedor").attr("required",true);

          $("#radio5").attr("disabled",false);
          
          $("#radio6").attr("disabled",false);
          
          $('input[name=type_wallet]').prop('checked',false); 

          
      });


</script>
@endsection
