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


            {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}


            <div class="form-row">
                <div class="form-group col-md-6">
                {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}
                <div class="input-group-text col-md-12">
                    <i class="fa-fw fas fa-random"></i>
                {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true]) !!}
                </div>
            </div>
                <div class="form-group col-md-6">
                    {!! Form::Label('client_id', "Cliente:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                    {!! Form::select('client_id',$client, null, ['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes']) !!}
                    </div>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::Label('exchange_rate', "Tasa:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-random mr-2"></i>
                {!! Form::number('exchange_rate',null, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>

            <div class="form-group col-md-4">

                {!! Form::Label('amount_foreign_currency', "Monto:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_foreign_currency',null, ['class' => 'form-control', 'required' => true]) !!}
                </div>

            </div>

        </div>



        <div class="form-group col-md-14">
                {!! Form::Label('amount', "Monto en dolares:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                {!! Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'readonly' => true]) !!}
                </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::Label('percentage', "Porcentaje:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-percentage mr-2"></i>
                {!! Form::text('percentage',null, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>

            <div class="form-group col-md-6">

                {!! Form::Label('amount_commission', "Monto Comisión:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_commission',null, ['class' => 'form-control', 'required' => true]) !!}
                </div>

            </div>
        </div>

<hr>
        <div class="form-group col-md-12 d-flex justify-content-center">

                <label class="form-check-label mx-auto" for="radio1">
                    {!! Form::radio('exonerate',false, null, ['id' => 'radio1', 'name'=>'optradio']) !!}
                    Exonerar comisión
                </label>

                <label class="form-check-label mx-auto" for="radio3">
                    {!! Form::radio('exonerate',true, null, ['id' => 'radio3', 'name'=>'optradio']) !!}
                    Incluir comisión
                </label>


                <label class="form-check-label mx-auto" for="radio2">
                    Descontar comisión
                    {!! Form::radio('discount',true, null, ['id' => 'radio2', 'name'=>'optradio']) !!}
                </label>

        </div>
        <hr>


        <div class="form-group">
            {!! Form::Label('amount_total', "Monto Total:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_total',null, ['class' => 'form-control', 'required' => true]) !!}
                </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::Label('status', "Estatus:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-stream mr-2"></i>
                {!! Form::select('status',[1=>'Activo',2=>'Anulado'], null, ['class' => 'form-control status', 'required' => true]) !!}

                </div>
            </div>

            <div class="form-group col-md-6">
                {!! Form::Label('transaction_date', "Fecha:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                {!! Form::date('transaction_date', null, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                </div>
            </div>
        </div>



        <div class="form-group">
            {!! Form::Label('description', "Descripción:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-text-width mr-2"></i>
                {!! Form::textarea('description',null, ['rows' => 1, 'class' => 'form-control', 'required' => true]) !!}
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

$(".status").select2({
  placeholder: "Seleccionar estatus",
  theme: 'bootstrap4',
  search: false
});

$(".typetrasnferencia").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
});

</script>



@endsection
