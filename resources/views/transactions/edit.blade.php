@extends('adminlte::page')

@section('title', 'Movimientos')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO MOVIMIENTO <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-6">
  <div class="card-body">

    {!! Form::model($transactions, ['route' => ['transactions.update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}


            {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}


            <div class="form-row">
                <div class="form-group col-md-4">
                {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}
                <div class="input-group-text col-md-12">
                    <i class="fa-fw fas fa-random"></i>
                {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                </div>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('wallet_id', "Tipo de caja:") !!}
                    <div class="input-group-text col-md-12">
                        <i class="fa-fw fas fa-random"></i>
                    {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('client_id', "Cliente:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                    {!! Form::select('client_id',$client, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                    </div>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true, 'id' => 'typecoin', 'readonly' => false]) !!}
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::Label('exchange_rate', "Tasa:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-random mr-2"></i>
                {!! Form::number('exchange_rate',null, ['class' => 'form-control', 'required' => true, 'id' => 'tasa', 'min' => 0, 'readonly' => true]) !!}
                </div>
            </div>

            <div class="form-group col-md-4">

                {!! Form::Label('amount_foreign_currency', "Monto en moneda extranjera:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fa-coins mr-2"></i>
                {!! Form::number('amount_foreign_currency',null, ['class' => 'form-control', 'required' => true, 'id' => 'monto', 'min' => 0, 'readonly' => true]) !!}
                </div>

            </div>

        </div>





        <div class="form-row">

            <div class="form-group col-md-4">
                {!! Form::Label('amount', "Monto en dolares:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                {!! Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'monto_dolares', 'min' => 0, 'readonly' => true]) !!}
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
                {!! Form::number('amount_commission',null, ['class' => 'form-control comision', 'required' => true, 'min' => 0, 'readonly' => true, 'id' => 'comision']) !!}
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
                {!! Form::number('amount_total',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}
                </div>
        </div>


                {!! Form::hidden('status', null, ['class' => 'form-control', 'value' => 'Activo']) !!}


        <div class="form-row">
            <div class="custom-file col-md-6">
                {!! Form::Label('transaction_date', "Fecha:") !!}
                <div class="input-group-text">
                    <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                {!! Form::date('transaction_date', null, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                </div>
            </div>


            <div class="form-group">
                <div class="custom-file col-md-12">
                {!! Form::label('file', 'Referencia') !!}

              <div class="input-group-text">
                <i class="fa-fw fas fa-file-image mr-2"></i>
                {!! Form::file('file', ['class' => 'form-file-input', 'accept' => 'image/*']) !!}
              </div>
            @error('file')
                <small class="text-danger">{{$message}}</small>
            @enderror
            </div>


            </div>
        </div>

<br>

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
/* $("#clientes").val("")
$("#clientes").trigger("change"); */

$(".typecoin").select2({
  placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true
});
/* $("#typecoin").val("")
$("#typecoin").trigger("change"); */

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
/* $("#typetrasnferencia").val("")
$("#typetrasnferencia").trigger("change"); */

$(document).ready(function() {
  //$('#monto_dolares').toFixed(2);

  $('.typecoin').change(function(e) {

      $('#tasa').val(""); // LIMPIAR TASA DE CAMBIO
      $('#monto').val(""); // LIMPIAR MONTO DE MONEDA EXTRANJERA

      $('#comision').val(""); // LIMPIAR COMISION
      $('#percentage').val("");  // LIMPIAR PORCENTAJE
      $('#monto_dolares').val(""); // LIMPIAR MONTO EN DOLARES

    if ($(this).val() == 1) {
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').attr("readonly", false);

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
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').prop('readonly', true);

      $('#tasa').val("");
      $('#monto').val("");
      $('#monto_dolares').val("");




    }
    else {
        $('#tasa').prop("readonly", false);
        $('#monto').prop("readonly", false);
        $('#monto_dolares').prop('readonly', true);


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

      $('#comision').prop('readonly', true);
      $('#montototal').prop('readonly', true);

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");

            monto_real = document.getElementById("montototal");
            onmousemove = function(){
                if(porcentage.value > 0){
                    montottotal = (montototal.value * porcentage.value / 100);
                    comision.value =  montottotal.toFixed(2);

                     if(montototal.value > 0 && comision.value > 0 ){
                        montoreal = (parseFloat(montototal.value) + parseFloat(comision.value));
                        monto_real.value =  montoreal;
                    }

                }/* else if(montototal.value > 0 && comision.value > 0 ){
                    montoreal = (montototal.value + comision.value);
                    monto_real.value =  montoreal;
                } */
             }

         })



});


</script>



@endsection
