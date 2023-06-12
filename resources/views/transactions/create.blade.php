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
                            {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random"></i>
                            {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4 esconder">
                            {!! Form::Label('wallet', "Tipo de caja:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random"></i>
                            {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('clientes', "Cliente:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                            {!! Form::select('group_id',$group, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row esconder">
                    <div class="form-group col-md-4">
                        {!! Form::Label('typecoin', "Tipo de moneda:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                        {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true, 'id' => 'typecoin', 'readonly' => false]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::Label('tasa', "Tasa:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::text('exchange_rate',null, ['class' => 'form-control rateMask', 'required' => true, 'id' => 'tasa', 'min' => 0, 'readonly' => true]) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-4">

                        {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto', 'readonly' => true]) !!}
                        </div>

                    </div>

                </div>
                <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::Label('monto_dolares', "Monto en dolares:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                    {!! Form::text('amount', null, ['class' => 'form-control dolar general', 'required' => true, 'id' => 'monto_dolares', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    {!! Form::Label('fecha', "Fecha:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                    {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                    </div>
                </div>
                </div>

                <div class="paginate text-right">
                    </div>

                      <div class="btn-group botones" data-toggle="buttons">
                        <label class="btn btn-primary" [ngClass]="{'active': s}">
                          <input type="radio" name="options" id="c_porcentaje" class="c_porcentaje" autocomplete="off" (click)="s=true; blah();" value="1"> COMISIÓN PORCENTAJE
                        </label>
                        <label class="btn btn-primary" [ngClass]="{'active': !s}">
                          <input type="radio" name="options" id="c_tasa" class="c_tasa" autocomplete="off"(click)="s=false; blah();" value="2"> COMISIÓN TASA
                        </label>
                      </div>
                      <br>
                <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisiones  </h4>

                <hr class="bg-dark esconder" style="height:1px;">

                <div class="form-row esconder comi">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMask', 'required' => true, 'id' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('comision', "Monto Comisión:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_commission',null, ['class' => 'form-control comision general', 'required' => true, 'readonly' => true, 'id' => 'comision']) !!}
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
                    {!! Form::Label('montototal', "Monto Total:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general', 'required' => true, 'id' => 'montototal', 'readonly' => true]) !!}
                        </div>
                    </div>


                <hr class="bg-dark esconder" style="height:1px;">


                <h4 class="text-uppercase font-weight-bold text-center esconder comisionbase">Comisión Base  </h4>
                <h4 class="text-uppercase font-weight-bold text-center tasa_basee" style="display:none;">Tasa Base  </h4>

                <hr class="bg-dark esconder" style="height:1px;">
                <div class="form-row esconder">

                    <div class="form-group col-md-12 tasa">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base rateMask', 'id' => 'percentage_base']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12 base" style="display:none;">
                        {!! Form::Label('tasa_base', "Tasa base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::text('exchange_rate_base',null, ['class' => 'form-control rateMask', 'required' => true, 'id' => 'tasa_base', 'min' => 0]) !!}
                        </div>
                    </div>

                        {!! Form::hidden('amount_base',null, ['class' => 'form-control general', 'min' => 0, 'readonly' => true, 'id' => 'monto_extranjera_base']) !!}


                </div>

                <div class="form-group col-md-12 d-flex justify-content-center base">

                    <label class="form-check-label mx-auto esconder comi comi_base" for="radio1_base">
                        {!! Form::radio('exonerate_base',2, null, ['id' => 'radio1_base', 'required' => true, 'class' => 'exonerar_base']) !!}
                        Exonerar comisión base
                    </label>

                    <label class="form-check-label mx-auto esconder comi comi_base" for="radio3_base">
                        {!! Form::radio('exonerate_base',1, null, ['id' => 'radio3_base', 'required' => true, 'class' => 'incluir_base']) !!}
                        Incluir comisión base
                    </label>


                    <label class="form-check-label mx-auto esconder comi comi_base" for="radio2_base">
                        Descontar comisión base
                        {!! Form::radio('exonerate_base',3, null, ['id' => 'radio2_base', 'required' => true, 'class' => 'descontar_base']) !!}
                    </label>

                </div>
                <div class="form-row esconder">


                    <div class="form-group col-md-6">

                        {!! Form::Label('comision_base', "Monto Comisión Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_commission_base',null, ['class' => 'form-control comision_base general', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>

                      <div class="form-group col-md esconder">
                        {!! Form::Label('montototal_base', "Monto total Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-coins mr-2"></i>
                        {!! Form::text('amount_total_base', null, ['class' => 'form-control general','id' => 'montototal_base', 'readonly' => true ]) !!}
                        </div>
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

    $('#monto_dolares').keyup(function() {
        var input1Value = $('#monto_dolares').val();
        $('#montototal').val(input1Value);
        $('#montototal_base').val(input1Value);
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
    });


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


    $('.general').inputmask({
        alias: 'decimal',
        allowMinus: false,
        autoUnmask:true,
        removeMaskOnSubmit:true,
        rightAlign: true,
        groupSeparator:".",
        undoOnEscape:true,
        insertMode:false,
        clearIncomplete:true,
        digits: 2,
        autoClear: true,
        insertMode:true, });


       $(".rateMask").attr("minlength","5");
	   $(".rateMask").attr("maxlength","5");
	   $(".rateMask").inputmask({
			alias: 'decimal',
			repeat: 4,
			allowMinus: false,
			autoUnmask:true,
			removeMaskOnSubmit:true,
			rightAlign: true,
            autoClear: true,
			groupSeparator:".",
			undoOnEscape:true,
			insertMode: false,
			clearIncomplete:true,
			digits: 2,
			insertMode:true,
		});




$(document).ready(function() {
    //$('#monto_dolares').toFixed(2);

    $('.typecoin').on('change', function() {

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
            $('.botones').hide();


            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");

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
            $('.botones').show();

            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");

            monto_dolares = document.getElementById("monto_dolares");
            const total = document.getElementById("montototal");
            const total_base = document.getElementById("montototal_base");

            $('#monto').keyup(function(){
                //if(tasa.value > 0 || monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
                    total.value =  monto_total.toFixed(2);
                    //total_base.value = monto_total.toFixed(2);
               // }

            });

        } //CIERRE DE CONDICION QUE CALCULA TIPO DE CAMBIO
    }); //CIERRE DE .READY




    $('#c_porcentaje').on('change', function() { //FUNCION DE PORCENTAJE
        //$('.boton').show();
        //$('.esconder').show();
        //if(this.checked) {
        var dolares = $('#monto_dolares').val();
        var exonerar        = document.getElementById("radio1");
        var exonerar_base   = document.getElementById("radio1_base");

        $('.tasa').show();
        $('.base').hide();
        $('.comisionbase').show();
        $('.tasa_basee').hide();
        $('.comi_base').show();
        $('.monto_extranjera_base').hide();
        $('.comi').show();
        $('#percentage').prop('required', true);
        $('#radio1_base').prop('required', true);
        $('#radio2_base').prop('required', true);
        $('#radio3_base').prop('required', true);
        $('#radio1').prop('required', true);
        $('#radio2').prop('required', true);
        $('#radio3').prop('required', true);
        $('#tasa_base').prop('required', false);
        $('#monto_extranjera_base').prop('required', false);
        $('#tasa_base').val('');
        $('#monto_extranjera_base').val('');
        $('#comision_base').val('');
        $('#percentage_base').val('');
        $('#montototal_base').val(dolares);

        exonerar.removeAttribute('checked');
        exonerar_base.removeAttribute('checked');

       // }// THIS CHEKED
    });


    $('#c_tasa').on('change', function() { //FUNCION DE PORCENTAJE


        var dolares = $('#monto_dolares').val();
        var exonerar = document.getElementById("radio1");
        var exonerar_base = document.getElementById("radio1_base");

        $('#comision_base').prop('required', false);
        $('#percentage_base').prop('required', false);
        $('#percentage').prop('required', false);
        $('#radio1_base').prop('required', false);
        $('#radio2_base').prop('required', false);
        $('#radio3_base').prop('required', false);
        $('#radio1').prop('required', false);
        $('#radio2').prop('required', false);
        $('#radio3').prop('required', false);

        $('.base').show();
        $('.tasa_basee').show();
        $('.comisionbase').hide();
        $('.tasa').hide();
        $('.comi_base').hide();
        $('.monto_extranjera_base').show();
        $('.comi').hide();
        $('#comision').val('');

        $('#percentage').val('');
        $('#percentage_base').val('');
        $('#comision_base').val('');
        $('#montototal_base').val(dolares);
        $('#montototal').val(dolares);

        exonerar.setAttribute('checked', 2);
        exonerar_base.setAttribute('checked', 2);

        tasa_b              = document.getElementById("tasa_base");
        monto_b             = document.getElementById("monto_extranjera_base");
        monto               = document.getElementById("monto");
        tasa                = document.getElementById("tasa");
        monto_dolares       = document.getElementById("monto_dolares");
        comision_base       = document.getElementById("comision_base");
        monto_base_comision = document.getElementById("montototal_base");

        $('#tasa_base').on('input', function(){
            if(tasa_b.value > 0 && monto.value > 0){

                monto_final = (monto.value / tasa_b.value);

                monto_b.value =  monto_final.toFixed(2);

                comision_base.value =   (parseFloat(monto_dolares.value) - parseFloat(monto_b.value)).toFixed(2);

                monto_base_comision.value = monto_final.toFixed(2);
            }
        })

        });


    $('#percentage').on('input',function() { //FUNCION DE PORCENTAJE

        $('#comision').prop('readonly', true);
        $('#montototal').prop('readonly', true);

        comision    = document.getElementById("comision");
        porcentage  = document.getElementById("percentage");
        montototal  = document.getElementById("monto_dolares");
        montoreal   =  document.getElementById("montototal");

        exonerar    = document.getElementById("radio1");
        descontar   = document.getElementById("radio2");
        incluir     = document.getElementById("radio3");

        //monto_real = document.getElementById("montototal");

        if(porcentage.value > 0){
            montottotal = (montototal.value * porcentage.value / 100);
            comision.value =  montottotal.toFixed(2);

            if(incluir.checked){
                montoreal.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);
            }

            if(descontar.checked){
                montoreal.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
            }

        }
        if(exonerar.checked){
          montoreal.value = parseFloat($('#monto_dolares').val()).toFixed(2);
         }



    }) //CIERRE DE PORCENTAJE


    $('#percentage_base').on('input', function() { //FUNCION DE PORCENTAJE BASE

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
            base = (montototal_base.value * porcentage_base.value / 100);
            comision_base.value =  base.toFixed(2).toString();

            if(incluir_base.checked){
                montoreal_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);
            }

            if(descontar_base.checked){
                montoreal_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
            }

        }
            if(exonerar_base.checked){
                montoreal_base.value = parseFloat($('#monto_dolares').val()).toFixed(2);
            }


    }) // CIERRE DE PORCENTAJE BASE





})//CIERRE DEL READY

     /* LLAMADO DE CALCULO DE COMISIONES */
    comision    = document.getElementById("comision");
    porcentage  = document.getElementById("percentage");
    montototal  = document.getElementById("monto_dolares");
    monto_real  = document.getElementById("montototal");

    exonerar    = document.getElementById("radio1");
    descontar   = document.getElementById("radio2");
    incluir     = document.getElementById("radio3");


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
    $('#comision_base').attr("readonly", true);

    monto_real_base.value = parseFloat($('#monto_dolares').val()).toFixed(2);
    }

    incluir_base.click = function (){

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


 $('.percentage_base').on('input', function() {

$('#comision_base').prop('readonly', true);
//$('#montototal_base').prop('readonly', true);

      comision_base = document.getElementById("comision_base");
      porcentage_base = document.getElementById("percentage_base");
      monto_dolares = document.getElementById("monto_dolares");


          if(porcentage_base.value > 0){
              mto = (monto_dolares.value * porcentage_base.value / 100);
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
            $('#radio1_base').click(function() {
                exonerar_base.click(function (){
                if(exonerar_base.click()){
                    return;
                }
             })
           });

            $('#radio3_base').click(function() {
                incluir_base.click(function (){
                if(incluir_base.click()){
                    return;
                }
              })
            });

           $('#radio2_base').click(function() {
            descontar_base.click(function (){
                if(descontar_base.click()){
                return;
                }
             })
            });
        /* PORCENTAJE BASE */






        $("#typetrasnferencia").on("change", function() {
            // Capturar dato seleccionado
            var selectedValue = this.value;
            var option = $("#typetrasnferencia option:selected").text();
            // Realizar la acción deseada en función del valor seleccionado
            if (option === 'Nota de debito' || option === 'Nota de credito') {

                $('.boton').hide();


                $('#c_tasa').prop("disabled", true);
                $('#c_porcentaje').prop("disabled", true);
                $('#radio1').prop("required", false);
                $('#radio2').prop("required", false);
                $('#radio3').prop("required", false);


                $('#radio1').prop("disabled", true);
                $('#radio2').prop("disabled", true);
                $('#radio3').prop("disabled", true);

                $('#radio1_base').prop("required", false);
                $('#radio2_base').prop("required", false);
                $('#radio3_base').prop("required", false);

                $('#percentage').prop("required", false);
                $('#tasa_base').prop("required", false);
                $('#tasa_base').prop("readonly", true);
                $('#radio1_base').prop("disabled", true);
                $('#radio2_base').prop("disabled", true);
                $('#radio3_base').prop("disabled", true);
                $('#percentage').prop("readonly", true);
                $('#percentage_base').prop("readonly", true);
                $('#comision_base').prop("readonly", true);
                $('#wallet').prop("disabled", true);
                $('#typecoin').prop("disabled", true);

                $("#typecoin").val(1);
                $("#typecoin").trigger("change");

                $("#wallet").val('');
                $("#wallet").trigger("change");

                $('#monto').val('');
                $('#typecoin').val('');
                $('#percentage_base').val('');
                $('#percentage').val('');
                $('#comision_base').val('');
                $('#wallet').prop("required", false);
                $('#typecoin').prop("required", false);
                $('#monto_dolares').attr("readonly", false);

                $('.movi').attr("class", 'card col-md-7 h-100');

            }else if (selectedValue) {
                $('.menos').show();
                //$('.botones').show();

                $('#c_tasa').prop("disabled", false);
                $('#c_porcentaje').prop("disabled", false);

                $('#radio1').prop("required", true);
                $('#radio2').prop("required", true);
                $('#radio3').prop("required", true);

                $('#radio1').prop("disabled", false);
                $('#radio2').prop("disabled", false);
                $('#radio3').prop("disabled", false);

                $('#radio1_base').prop("required", true);
                $('#radio2_base').prop("required", true);
                $('#radio3_base').prop("required", true);
                //$('#percentage').prop("required", true);
                $('#tasa_base').prop("required", false);
                $('#tasa_base').prop("readonly", false);
                $('#radio1_base').prop("disabled", false);
                $('#radio2_base').prop("disabled", false);
                $('#radio3_base').prop("disabled", false);
                $('#percentage').prop("readonly", false);
                $('#percentage_base').prop("readonly", false);
                $('#comision_base').prop("readonly", true);
                $('#wallet').prop("disabled", false);
                $('#typecoin').prop("disabled", false);
                $('#wallet').prop("required", true);
                $('#typecoin').prop("required", true);


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
