@extends('adminlte::page')



@section('title', 'Transacción')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVA TRANSACCION') }} <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-7 movi" style="min-height: 500px !important; max-height:100%; height:100%; widht:100%"">
  <div class="card-body">

    {!! Form::open(['route' => 'transactions.store', 'autocomplete' => 'on', 'files' => true, 'enctype' =>'multipart/form-data']) !!}




            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Movimiento') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Referencias') }}</button>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random"></i>
                            {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4 esconder">
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
                            {!! Form::select('group_id',$group, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row esconder">
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
                        {!! Form::text('exchange_rate',null, ['class' => 'form-control', 'required' => true, 'id' => 'tasa', 'min' => 0, 'readonly' => true]) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        {!! Form::Label('amount_foreign_currency', "Monto en moneda extranjera:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control', 'required' => true, 'id' => 'monto', 'readonly' => true]) !!}
                        </div>

                    </div>

                </div>
                <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::Label('amount', "Monto en dolares:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                    {!! Form::text('amount', null, ['class' => 'form-control dolar', 'required' => true, 'id' => 'monto_dolares', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('transaction_date', "Fecha:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                    {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                    </div>
                </div>
            </div>

                <div class="paginate text-right">
                    <button class="btn btn-primary mas boton" id="mas" type="button" style="display: none;"><i class="fas fa-plus"></i></button> <button class="btn btn-danger menos boton" id="menos" type="button"><i class="fas fa-minus"></i></button>
                    </div>
                <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisiones  </h4>

                <hr class="bg-dark esconder" style="height:1px;">

                <div class="form-row esconder comi">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage', 'required' => true, 'id' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('amount_commission', "Monto Comisión:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_commission',null, ['class' => 'form-control comision', 'required' => true, 'readonly' => true, 'id' => 'comision']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto esconder comi" for="radio1">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true,]) !!}
                        Exonerar comisión
                    </label>

                    <label class="form-check-label mx-auto esconder comi" for="radio3">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'class' => 'incluir','required' => true,]) !!}
                        Incluir comisión
                    </label>


                    <label class="form-check-label mx-auto esconder comi" for="radio2">
                        Descontar comisión
                        {!! Form::radio('exonerate',3, null, ['id' => 'radio2', 'class' => 'descontar', 'required' => true,]) !!}
                    </label>

                </div>

                 <div class="form-group col-md esconder">
                    {!! Form::Label('amount_total', "Monto Total:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_total',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}
                        </div>
                    </div>


                <hr class="bg-dark esconder comi" style="height:1px;">


                <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Base  </h4>

                <hr class="bg-dark esconder comi" style="height:1px;">
                <div class="form-row esconder comi">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base',  'min' => 0, 'id' => 'percentage_base']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('amount_commission_base', "Monto Comisión Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_commission_base',null, ['class' => 'form-control comision_base', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto esconder comi" for="radio1_base">
                        {!! Form::radio('exonerate_base',2, null, ['id' => 'radio1_base', 'required' => true, 'class' => 'exonerar_base']) !!}
                        Exonerar comisión base
                    </label>

                    <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                        {!! Form::radio('exonerate_base',1, null, ['id' => 'radio3_base', 'required' => true, 'class' => 'incluir_base']) !!}
                        Incluir comisión base
                    </label>


                    <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                        Descontar comisión base
                        {!! Form::radio('exonerate_base',3, null, ['id' => 'radio2_base', 'required' => true, 'class' => 'descontar_base']) !!}
                    </label>

                </div>
                <div class="form-group col-md esconder">
                    {!! Form::Label('amount_total_base', "Monto total Base:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-coins mr-2"></i>
                    {!! Form::number('amount_total_base', null, ['class' => 'form-control','id' => 'montototal_base', 'readonly' => true ]) !!}
                    </div>
                </div>



                <hr class="bg-dark esconder comi" style="height:1px;">




                        {!! Form::hidden('status', 'Activo', null, ['class' => 'form-control']) !!}




                <div class="form-group">
                    {!! Form::Label('description', "Descripción:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::textarea('description',null, ['rows' => 1, 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                </div>

                {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;" , 'id' => 'publish']) !!}

                </div>


                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <div class="form-group">
                        <div class="custom-file col-md-12">
                        {!! Form::label('file', 'Referencia:') !!}





                      <div class="file-loading">
                            {!! Form::file('file[]', ['class' => 'form-file-input file', 'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file', 'data-allowed-file-extensions' => '["pdf","jpg","jpeg","png","gif"]']) !!}
                      </div>

                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror


                </div>
            </div>



                    {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;" , 'id' => 'publish']) !!}
                </div>

              </div>







                {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection


@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">



<style>
.file-preview-thumbnails{
    overflow-y: scroll;
    height: 550px;
	width: 870px;
}
@media screen and (max-width: 1880px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:500px;
  }
}


@media screen and (max-width: 1780px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:500px;
  }
}


@media screen and (max-width: 1680px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:500px;
  }
}


@media screen and (max-width: 1580px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:400px;
  }
}

@media screen and (max-width: 1280px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:400px;
  }
}
@media screen and (max-width: 800px) {
  .file-preview {
    min-width: 290px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:400px;
  }
}
@media screen and (max-width: 480px) {
  .file-preview {
    min-width: 350px;
    min-height: 450px;
  }
  .file-preview-thumbnails {
    width:200px;
  }
}
@media screen and (max-height: 280px) {
  .file-preview {
    min-width: 350px;
    min-height: 300px;
  }
  .file-preview-thumbnails {
    width:400px;
  }
}
.form-group > .select2-container {
    width: 100% !important;
}
.card{
    width: 100% !important;
    height: 100% !important;
}

</style>
@endsection

@section('js')
<script>
$('#monto_dolares').mask('###0.00', {reverse: true});
$('#monto').mask('###0.00', { reverse: true });
$('#tasa').mask('###0.00', { reverse: true });
$('#montototal').mask('#.##0.00', { reverse: true });
$('#percentage').mask('00.0', { reverse: true });
$('#comision').mask('###0.00', { reverse: true });




     $('#monto_dolares').on('input', function() {
        var input1Value = $('#monto_dolares').val();
        $('#montototal').val(input1Value);
        //$('#montototal_base').val(input1Value);
     });

     $( function() {
    var availableTags = [
      "cash",
      "CASH",
      "Saldo anterior",
      "suift",
      "abono",
      "Abono en cash",
      "Cash enviado",
      "Ali",
      "Abu",
      "Cash Dubai",
      "abono en Valencia",
      "abono cash",
      "cash libano",
      "cash la yaguara",
      "la yaguara",
      "suift (preforman)",
      "cash turquia",
      "libano",
      "Turquia",
      "Turkia",
      "Banesco",
      "Banesco Panama",
      "Mercantil",
      "BDV",
      "pago bolivares",
      "cash recibido",
      "pasaje de",
      "pasajes",
      "boletos",
      "Abonado",
      "recibido para",
      "USDT",
      "Token"
    ];
    $("#description").autocomplete({
      source: availableTags
    });
  } );


$(".clientes").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
  notEmpty: false,
  allowClear: true,
  clearing: true,
  width: '100%'
});
$("#clientes").val("")
$("#clientes").trigger("change");

$(".typecoin").select2({
  placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true,
  width: '100%'
});
$("#typecoin").val("")
$("#typecoin").trigger("change");

$(".status").select2({
  placeholder: "Seleccionar estatus",
  theme: 'bootstrap4',
  search: false,
  width: '100%'
});

$(".wallet").select2({
  placeholder: "Seleccionar Caja | Wallet",
  theme: 'bootstrap4',
  search: false,
  allowClear: true,
  width: '100%'
});
$("#wallet").val("")
$("#wallet").trigger("change");

$(".typetrasnferencia").select2({
  placeholder: "Seleccionar tipo de movimiento",
  theme: 'bootstrap4',
  allowClear: true,
  width: '100%'
});
$("#typetrasnferencia").val("")
$("#typetrasnferencia").trigger("change");

$(document).ready(function() {
  //$('#monto_dolares').toFixed(2);

  $('.typecoin').change(function(e) {

      $('#tasa').val(""); // LIMPIAR TASA DE CAMBIO
      $('#monto').val(""); // LIMPIAR MONTO DE MONEDA EXTRANJERA

      $('#comision').val(""); // LIMPIAR COMISION
      $('#percentage').val("");  // LIMPIAR PORCENTAJE
      $('#monto_dolares').val(""); // LIMPIAR MONTO EN DOLARES
      $('#montototal').val(""); //LIMPIAR MONTO TOTAL
      $('#montototal_base').val(""); //LIMPIAR MONTO TOTAL BASE


    if ($(this).val() == 1) {
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').attr("readonly", false);

            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");
            //const log = document.getElementById("montototal");

            onkeyup = function(){
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                    //log.value =  monto_total.toFixed(2);
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
            const log = document.getElementById("montototal");



            onkeyup = function(){
                if(tasa.value > 0 && monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
                    log.value =  monto_total.toFixed(2);
                }
                else if(monto_dolares.value == NaN){
                    monto_dolares.value = 'Por favor use punto en vez de coma.'

                }else{

                    log.value = monto_dolares.toFixed(2);
                }

            };

            onkeyup = function(){
            if(tasa.value!="" && monto.value!=""){
                monto_total = (monto.value / tasa.value);
                monto_dolares.value =  monto_total.toFixed(2);

            }

        };



     } //CIERRE DE CONDICION QUE CALCULA TIPO DE CAMBIO
  }) //CIERRE DE .READY

  $('.percentage').keyup(function(e) { //FUNCION DE PORCENTAJE

      $('#comision').prop('readonly', true);
      $('#montototal').prop('readonly', true);

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");
            montoreal =  document.getElementById("montototal");

            exonerar = document.getElementById("radio1");
            descontar = document.getElementById("radio2");
            incluir = document.getElementById("radio3");




            //monto_real = document.getElementById("montototal");

            if(porcentage.value > 0){
                    montottotal = (montototal.value * porcentage.value / 100);
                    comision.value =  montottotal.toFixed(2).toString();

                    if(incluir.checked){
                     montoreal.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);

                     }

                     if(descontar.checked){
                        montoreal.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
                     }

                }else if(is_null(porcentage.value)){
                      if(exonerar.checked){
                        monto_real.value = parseFloat(montototal.value).toFixed(2);
                     }
                }

             }) //CIERRE DE PORCENTAJE


             $('.percentage_base').keyup(function(e) { //FUNCION DE PORCENTAJE BASE

            $('#comision_base').prop('readonly', true);
            $('#montototal_base').prop('readonly', true);

                comision_base = document.getElementById("comision_base");
                porcentage_base = document.getElementById("percentage_base");
                montototal_base = document.getElementById("monto_dolares");
                montoreal_base =  document.getElementById("montototal_base");

                exonerar_base = document.getElementById("radio1_base");
                descontar_base = document.getElementById("radio2_base");
                incluir_base = document.getElementById("radio3_base");




            if(porcentage_base.value > 0){
                    montottotal = (montototal_base.value * porcentage_base.value / 100);
                    comision_base.value =  montottotal.toFixed(2).toString();

                    if(incluir_base.checked){
                    montoreal_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);

                    }

                    if(descontar_base.checked){
                        montoreal_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
                    }

                }else if(is_null(porcentage_base.value)){
                        if(exonerar_base.checked){
                        monto_real.value = parseFloat(montototal_base.value).toFixed(2);
                    }
                }

            }) // CIERRE DE PORCENTAJE BASE





    })//CIERRE DEL READY

     /* LLAMADO DE CALCULO DE COMISIONES */
    comision = document.getElementById("comision");
    porcentage = document.getElementById("percentage");
    montototal = document.getElementById("monto_dolares");
    monto_real = document.getElementById("montototal");

    exonerar = document.getElementById("radio1");
    descontar = document.getElementById("radio2");
    incluir = document.getElementById("radio3");


    exonerar.click = function (){

    $('#comision').val(""); // LIMPIAR COMISION
    $('#percentage').val("");  // LIMPIAR PORCENTAJE
    //$('#percentage_base').val("");  // LIMPIAR PORCENTAJE
    //$('#comision_base').val("");  // LIMPIAR PORCENTAJE

    $('#percentage').attr("readonly", true);
    //$('#percentage_base').attr("readonly", true);
    montottotal = (montototal.value);
    monto_real.value = parseFloat(montototal.value).toFixed(2);

    }
    incluir.click = function (){
    //var selectedValue = this.value;

    $('#percentage').attr("required", true);
    $('#percentage').attr("readonly", false);
    //$('#percentage_base').attr("readonly", false);

    monto_real.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);

    }
    descontar.click = function (){
    //$('.comi').show();
    $('#percentage').attr("required", true);
    $('#percentage').attr("readonly", false);
    //$('#percentage_base').attr("readonly", false);

    monto_real.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
    }



    /* LLAMADO DE CALCULO DE COMISIONES BASE */
    comision_base = document.getElementById("comision_base");
    porcentage_base = document.getElementById("percentage_base");
    montototal_base = document.getElementById("monto_dolares");
    monto_real_base = document.getElementById("montototal_base");

    exonerar_base = document.getElementById("radio1_base");
    descontar_base = document.getElementById("radio2_base");
    incluir_base = document.getElementById("radio3_base");


    exonerar_base.click = function (){

    $('#percentage_base').val("");  // LIMPIAR PORCENTAJE
    $('#comision_base').val("");  // LIMPIAR PORCENTAJE

    //$('#percentage').attr("readonly", true);
    $('#percentage_base').attr("readonly", true);
    montottotal = (montototal_base.value);
    monto_real_base.value = parseFloat(montototal_base.value).toFixed(2);

    }
    incluir_base.click = function (){
    //var selectedValue = this.value;

    $('#percentage_base').attr("required", true);
    //$('#percentage').attr("readonly", false);
    $('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);

    }
    descontar_base.click = function (){
    //$('.comi').show();
    $('#percentage_base').attr("required", true);
    $('#percentage_base').attr("readonly", false);
    //$('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
    }














mas = document.getElementById("mas");
menos = document.getElementById("menos");

$('.mas').click(function(e){

    $('.comi').show();
    $('.menos').show();
    $('.mas').hide();

})
$('.menos').click(function(e){

$('.comi').hide();
$('.menos').hide();
$('.mas').show();
$('#percentage').attr("required", false); //QUITAR COMO REQUERIDO EL INPUT
    $('#comision').val(""); // LIMPIAR COMISION
    $('#percentage').val("");  // LIMPIAR PORCENTAJE

    $('.movi').attr("class", 'card col-md-7 h-100');


})




$('.percentage_base').keyup(function(e) {

$('#comision_base').prop('readonly', true);
//$('#montototal_base').prop('readonly', true);

      comision_base = document.getElementById("comision_base");
      porcentage_base = document.getElementById("percentage_base");
      montototal_base = document.getElementById("monto_dolares");


          if(porcentage_base.value > 0){
              mto = (montototal_base.value * porcentage_base.value / 100);
              comision_base.value =  mto.toFixed(2);

           }



});

                /* PORCENTAJE  */
            $('.exonerar').click(function() {

                exonerar.click(function (){
                    if(exonerar.click()){
                        return;
                    }
                })

            })

            $('.incluir').click(function() {

                incluir.click(function (){
                    if(incluir.click()){
                    return;
                    }
                })

                })

                $('.descontar').click(function() {

                    descontar.click(function (){
                        if(descontar.click()){
                        return;
                        }
                    })
                })
            /* PORCENTAJE  */

                /* PORCENTAJE BASE */
            $('.exonerar_base').click(function() {

            exonerar_base.click(function (){
            if(exonerar_base.click()){
                return;
            }
        })

        })

        $('.incluir_base').click(function() {

            incluir_base.click(function (){
            if(incluir_base.click()){
                return;
            }
        })

        })

        $('.descontar_base').click(function() {

            descontar_base.click(function (){
                if(descontar_base.click()){
                return;
                }
            })
        })
        /* PORCENTAJE BASE */






        $("#typetrasnferencia").on("change", function() {
            // Capturar dato seleccionado
            var selectedValue = this.value;
            var option = $("#typetrasnferencia option:selected").text();
            // Realizar la acción deseada en función del valor seleccionado
            if (option === 'Nota de debito' || option === 'Nota de credito') {


                $('.boton').hide();
                $('.esconder').hide();
                $('#radio1').prop("required", false);
                $('#radio2').prop("required", false);
                $('#radio3').prop("required", false);
                $('#radio1_base').prop("required", false);
                $('#radio2_base').prop("required", false);
                $('#radio3_base').prop("required", false);
                $('#percentage').prop("required", false);
                $('#wallet').prop("required", false);
                $('#typecoin').prop("required", false);
                $('#monto_dolares').attr("readonly", false);
                $('.movi').attr("class", 'card col-md-7 h-100');
                const input = document.getElementById("monto_dolares");
                const log = document.getElementById("montototal");
                const log2 = document.getElementById("montototal_base");
                input.addEventListener("input", updateValue);

                function updateValue(e) {
                log.value = e.target.value;
                log2.value = e.target.value;
                }

            } else if (selectedValue) {
                $('.esconder').show();
                $('.menos').show();
            }
        });













     $("#file").fileinput({
        uploadUrl: '{{ route('transactions.store') }}'
        , language: 'es'
        , showUpload: false
        , dropZoneEnabled: false
        , theme:"fas"
        , mainClass: "input-group-md"
        , overwriteInitial: false
        , fileActionSettings: {
            showRemove: true,
            showUpload: false,
            showZoom: true,
            showDrag: false,
        }
        , initialPreviewAsData: true
        , allowedPreviewTypes: ['text', 'image']
        , uploadExtraData: function () {  // callback example

            var documentos = [];

            $.each($(this)[0].filenames, function (i, v) {
                var nombre = v;
                //Busco la extension
                var lastPoint = nombre.lastIndexOf(".");
                var extension = nombre.substring(lastPoint + 1);

                var b;

                switch (extension.toUpperCase()) {
                    case "ZIP":
                    case "RAR":
                    case "JPG":
                    case "PNG":
                    case "JPEG":
                        b = {
                            'id': i + 1,
                            'nombre': nombre,
                            'mensaje': '',
                            'tipo': extension.toUpperCase(),
                            'procesado': false
                        };
                        documentos.push(b);
                        break;

                    case "PDF":
                        b = {
                            'id': i + 1,
                            'nombre': nombre,
                            'mensaje': '',
                            'tipo': extension.toUpperCase(),
                            'procesado': false
                        };
                        pdf.push(b);
                        documentos.push(b);
                        break;
                    case "XML":
                        b = {
                            'id': i + 1,
                            'nombre': nombre,
                            'mensaje': '',
                            'tipo': extension.toUpperCase(),
                            'procesado': false
                        };
                        xml.push(b);
                        documentos.push(b);
                        break;
                    default:
                        b = {
                            'id': i + 1,
                            'nombre': nombre,
                            'mensaje': msgWrongFileType,
                            'tipo': extension.toUpperCase(),
                            'procesado': false
                        };
                        documentos.push(b);
                        break;
                }
            });

            //Recorro todos los xmls y pdfs, los que no tenga par se marcaran como bad
            $.each(xml, function (i, v) {
                if (v.tienePar == false) {
                    v.mensaje = msgNoPdf;
                    //bad.push(v);
                }
            });


            var data = {
                Documentos: documentos
                , DatoExtra: "Información EXTRA"
            }

            alert(JSON.stringify(data));
            return { datos: JSON.stringify(data) }; //Este objeto mandarias al SERVER al presionar upload
          }
        });



$('#file').on('filebatchpreupload', function (event, data) {
    //Si quieres que haga algo antes de enviar la informacion
    $("#divResult").text("Enviando...");
});

//Para procesar los archivos despues de haberlos subido
$('#file').on('filebatchuploadsuccess', function (event, data) {
    var response = data.response;
    $("#divResult").text("Procesados...");
    //Despues de procesar la informacion el servidor respondera con esto... puedes decidir que hacer.. ya se mostrar un mensaje al usuairo
});

$('#file').on('filecleared', function () {
    //Si queires que haga algo al limpiar los archivos
    //alert('0 archivos');
    Swal.fire(
    'Cancelada la subida de archivos',
    '',
    'error'
    )

});





</script>



@endsection
