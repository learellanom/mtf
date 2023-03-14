@extends('adminlte::page')

@section('title', 'Movimientos')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO MOVIMIENTO <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-6">
  <div class="card-body">

    {!! Form::open(['route' => 'transactions.store', 'autocomplete' => 'off', 'files' => true]) !!}

    <div class="form-row">
        {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}

        {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true]) !!}
    <div class="form-group col-md-6">
        {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}


        {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true]) !!}
    </div>

    <div class="form-group col-md-6">

            {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}


            {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true]) !!}


    </div>
</div>





<div class="form-row">
    <div class="form-group col-md-6">
        {!! Form::Label('percentage', "Tasa:") !!}
        <div class="input-group-text">
            <i class="fa-fw fas fa-dollar-sign"></i>
        {!! Form::text('percentage',null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
    </div>

    <div class="form-group col-md-6">

        {!! Form::Label('amount', "Monto:") !!}
        <div class="input-group-text">
            <i class="fa-fw fas fa-coins"></i>
        {!! Form::text('amount',null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

    </div>
</div>






<hr>
<div class="form-group col-md-12">

        <label class="form-check-label" for="radio1">
            {!! Form::radio('exonerate',true, null, ['id' => 'radio1', 'name'=>'optradio']) !!}
            Exonerar comisión
        </label>


        <label class="float-right" for="radio2">
            Descontar comisión
            {!! Form::radio('discount',true, null, ['id' => 'radio2', 'name'=>'optradio']) !!}
        </label>

</div>
<hr>

<div class="form-group col-md-14">
    <x-adminlte-input name="iUser" label="Equivalancia al dolar" label-class="text-lightblue">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

    <div class="form-row">
    <div class="form-group col-md-6">
        <x-adminlte-input name="iUser" label="Porcentaje" label-class="text-lightblue">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-percentage"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="form-group col-md-6">
        <x-adminlte-input name="iUser" label="Monto de comision" placeholder="" label-class="text-lightblue" type='number'>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
  </div>





  <div class="form-group">
    <x-adminlte-input name="iUser" label="Monto" placeholder="" label-class="text-lightblue" type='number'>
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
  </div>
  <div class="form-group">
    <x-adminlte-textarea name="iUser" label="Descripcion" placeholder="" label-class="text-lightblue" type='textarea'>
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="far fa-sticky-note text-lightblue"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
        <x-adminlte-input name="iUser" label="Suift" placeholder="" label-class="text-lightblue" type='number'>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-sort-numeric-up-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="form-group col-md-4">
        {!! Form::Label('client_id', "Cliente:") !!}
        {!! Form::select('client_id',$client, null, ['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes']) !!}
    </div>

    <div class="form-group col-md-4">
        <x-adminlte-input name="iUser" label="Saldo" placeholder="" label-class="text-lightblue" type="number">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-dollar-sign text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
  </div>

        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

        {!! Form::close() !!}
       </div>
      </div>
    </div>

@endsection
@section('js')

<script>
$(".clientes").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
});
$(".typecoin").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
});
$(".typetrasnferencia").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
});

</script>



@endsection
