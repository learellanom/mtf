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
                <div class="form-group col-md-4">
                {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}
                <div class="input-group-text col-md-12">
                    <i class="fa-fw fas fa-random"></i>
                {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia']) !!}
                </div>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('wallet_id', "Tipo de caja:") !!}
                    <div class="input-group-text col-md-12">
                        <i class="fa-fw fas fa-random"></i>
                    {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'wallet']) !!}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('client_id', "Cliente:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                    {!! Form::select('client_id',$client, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes' ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true, 'id' => 'typecoin']) !!}
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::Label('exchange_rate', "Tasa:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-random mr-2"></i>
                {!! Form::number('exchange_rate',null, ['class' => 'form-control', 'required' => true, 'id' => 'tasa', 'min' => 0, 'disabled' => true]) !!}
                </div>
            </div>

            <div class="form-group col-md-4">

                {!! Form::Label('amount_foreign_currency', "Monto:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_foreign_currency',null, ['class' => 'form-control', 'required' => true, 'id' => 'monto', 'min' => 0, 'disabled' => true]) !!}
                </div>

            </div>

        </div>





        <div class="form-row">

            <div class="form-group col-md-4">
                {!! Form::Label('amount', "Monto en dolares:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                {!! Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'monto_dolares', 'min' => 0, 'disabled' => true]) !!}
                </div>
            </div>

            <div class="form-group col-md-4">
                {!! Form::Label('percentage', "Porcentaje:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-percentage mr-2"></i>
                {!! Form::number('percentage',null, ['class' => 'form-control percentage', 'required' => true, 'min' => 0, 'id' => 'percentage']) !!}
                </div>
            </div>

            <div class="form-group col-md-4">

                {!! Form::Label('amount_commission', "Monto Comisión:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_commission',null, ['class' => 'form-control comision', 'required' => true, 'min' => 0, 'disabled' => true, 'id' => 'comision']) !!}
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
                {!! Form::number('amount_total',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal']) !!}
                </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::Label('status', "Estatus:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-stream mr-2"></i>
                {!! Form::select('status',['Activo'=>'Activo','Anulado'=>'Anulado'], null, ['class' => 'form-control status', 'required' => true]) !!}

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
  notEmpty: false,
  allowClear: true,
  clearing: true
});
$("#clientes").val("")
$("#clientes").trigger("change");

$(".typecoin").select2({
  placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true
});
$("#typecoin").val("")
$("#typecoin").trigger("change");

$(".status").select2({
  placeholder: "Seleccionar estatus",
  theme: 'bootstrap4',
  search: false
});

$(".wallet").select2({
  placeholder: "Seleccionar Caja | Wallet",
  theme: 'bootstrap4',
  search: false
});

$(".typetrasnferencia").select2({
  placeholder: "Seleccionar tipo de movimiento",
  theme: 'bootstrap4',
  allowClear: true
});
$("#typetrasnferencia").val("")
$("#typetrasnferencia").trigger("change");

$(document).ready(function() {
  //$('#monto_dolares').toFixed(2);

  $('.typecoin').change(function(e) {
    if ($(this).val() == 1) {
      $('#tasa').prop("disabled", true);
      $('#monto').prop("disabled", true);
      $('#monto_dolares').prop("disabled", false);

      $('#tasa').val("");
      $('#monto').val("");

            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");

            onmousemove = function(){
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                }
        }
    }
    else if ($(this).val() == null)
    {
      $('#tasa').prop("disabled", true);
      $('#monto').prop("disabled", true);
      $('#monto_dolares').prop("disabled", true);

      $('#tasa').val("");
      $('#monto').val("");
      $('#monto_dolares').val("");




    }
    else {
        $('#tasa').prop("disabled", false);
        $('#monto').prop("disabled", false);
        $('#monto_dolares').prop("disabled", true);


            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");

            monto_dolares = document.getElementById("monto_dolares");


            onmousemove = function(){
                if(tasa.value > 0 && monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
                }
                else if(monto_dolares.value == NaN){
                    monto_dolares.value = 'Por favor use punto en vez de coma.'

                }else{
                    monto_dolares.value = 'Por favor llene el campo tasa.'
                }

            };

            onchange = function(){
            if(tasa.value!="" && monto.value!=""){
                monto_total = (monto.value / tasa.value);
                monto_dolares.value =  monto_total.toFixed(2);
            }

        };



     }
  })

  $('.percentage').change(function(e) {

      $('#comision').prop("disabled", false);
      $('#monto').prop("disabled", true);
      //$('#montodolares').prop("disabled", true);

      $('#tasa').val("");
      $('#monto').val("");

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");

            onmousemove = function(){
                if(porcentage.value > 0){
                    montottotal = (montotototal * porcentage);
                    montototal.value =  montottotal.toFixed(2);
                }
        }
     })



});


</script>



@endsection
