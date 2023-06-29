@extends('adminlte::page')



@section('title', 'Transacción')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVA TRANSACCION') }} <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-7 movi" style="min-height: 500px !important; max-height:100%; height:100%; widht:100%"">
  <div class="card-body">

    {!! Form::open(['route' => 'transactions.store', 'autocomplete' => 'on', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}




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
                    {{-- <button onclick="location.reload()" class="btn btn-primary font-weight-bold"> REFRESCAR <i class="fas fa-sync-alt"></i></button> --}}
                    </div>

                      <div class="btn-group botones" data-toggle="buttons">
                        <label class="btn btn-primary" [ngClass]="{'active': s}">
                          <input type="radio" name="options" id="c_porcentaje" class="c_porcentaje" autocomplete="off" (click)="s=true; blah();" value="1" checked> COMISIÓN PORCENTAJE
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
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general', 'required' => true, "minlength" => "3", 'id' => 'montototal', 'readonly' => true]) !!}
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


    $('#monto_dolares').on('input', function() {
        var input1Value = $('#monto_dolares').val();
        //$('#montototal').val(input1Value);
        $('#montototal_base').val(input1Value);
        //$('#monto_extranjera_base').val(input1Value);
     });

$(document).ready(function() {
    //$('#monto_dolares').toFixed(2);

    $('#entre').on('submit', function() {

        tasa = $('#c_tasa').is(':checked');
        porcentage = $('#c_porcentaje').is(':checked');
        exonerar = $('#radio1').is(':checked');
        exonerar_base = $('#radio1_base').is(':checked');
        transferencia = $("#typetrasnferencia option:selected").text();


        if (transferencia === 'Nota de debito' || transferencia === 'Nota de credito'){
                    if ($('#percentage').val() <= 0) {

                    return true;
                    }
           }else{
                    if(porcentage && !exonerar){
                        if ($('#percentage').val() <= 0) {
                        Swal.fire('Porcentage, no puede ser cero o menor a cero. :(');
                        return false;
                    }
                    }
                    if(porcentage && !exonerar_base){
                        if ($('#percentage_base').val() <= 0) {
                        Swal.fire('Porcentage base, no puede ser cero o menor a cero. :(');
                        return false;
                    }
                    }

                    if(tasa){
                    if ($('#tasa_base').val() <= 0) {
                        Swal.fire('Tasa base, no puede ser cero o menor a cero. :(');
                        return false;
                    }
                    }
               }
    });




        $('#radio1').on('click', function() {
        $('#percentage').val("");
        $('#comision').val("");
        $('#comision').attr("readonly", true);
        $('#percentage').attr("readonly", true);
    });

    $('#radio2').on('click', function() {

        $('#percentage').attr("readonly", false);
    });

    $('#radio3').on('click', function() {

        $('#percentage').attr("readonly", false);
    });

    $('#radio1_base').on('click', function() {
        $('#percentage_base').val("");
        $('#comision_base').val("");
        $('#comision_base').attr("readonly", true);
        $('#percentage_base').attr("readonly", true);
    });

    $('#radio2_base').on('click', function() {

        $('#percentage_base').attr("readonly", false);
    });

    $('#radio3_base').on('click', function() {

        $('#percentage_base').attr("readonly", false);
    });


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


            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");
            //const log = document.getElementById("montototal");

            $('#monto_dolares, #percentage').on('input', function() {
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                }
                    let comision = parseFloat($('#comision').val());
                    let porcentage = parseFloat($('#percentage').val());
                    let montoreal = parseFloat($('#montototal').val());

                    let exonerar = $('#radio1').is(':checked');
                    let descontar = $('#radio2').is(':checked');
                    let incluir = $('#radio3').is(':checked');

                    updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);

                $('#radio1, #radio2, #radio3').on('click', function() {
                            let comision = parseFloat($('#comision').val());
                            let porcentage = parseFloat($('#percentage').val());
                            let montoreal = parseFloat($('#montototal').val());

                            let exonerar = $('#radio1').is(':checked');
                            let descontar = $('#radio2').is(':checked');
                            let incluir = $('#radio3').is(':checked');
                            updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);
                 });

                 function updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal) {
                            let monto_dolares = parseFloat($('#monto_dolares').val());

                            if(porcentage > 0){
                               $('#comision').val((monto_dolares * (porcentage / 100)));
                                comision = (monto_dolares * (porcentage / 100));
                                //alert(comision);
                            }


                            if(!exonerar) {
                                if(incluir) {
                                 montoreal = (monto_dolares + comision).toFixed(2);
                                $('#montototal').val((monto_dolares + comision));
                                //alert(montoreal);

                                } else if(descontar) {
                                montoreal = (monto_dolares - comision).toFixed(2);
                                $('#montototal').val((monto_dolares - comision));
                                }
                            }
                            else {
                                //$('#percentage').prop('readonly', true);
                                //$('#comision').prop('readonly', true);
                                $('#percentage').val(0);
                                $('#comision').val(0);
                                montoreal = monto_dolares.toFixed(2);
                                $('#montototal').val(monto_dolares);
                             }
                          }

            });

            $('#monto_dolares, #percentage_base').on('input', function() {
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                }
                            let comision_base = parseFloat($('#comision_base').val());
                            let porcentage_base = parseFloat($('#percentage_base').val());
                            let montoreal_base = parseFloat($('#montototal_base').val());

                            let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                            let descontar_base = $('#radio2_base').is(':checked');
                            let incluir_base = $('#radio3_base').is(':checked');
                                //alert(incluir)

                      updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);

                      $('#radio1_base, #radio2_base, #radio3_base').on('click', function() {
                                let comision_base = parseFloat($('#comision_base').val());
                                let porcentage_base = parseFloat($('#percentage_base').val());
                                let montoreal_base = parseFloat($('#montototal_base').val());

                                let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                                let descontar_base = $('#radio2_base').is(':checked');
                                let incluir_base = $('#radio3_base').is(':checked');

                                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
                      });

                 function updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(porcentage_base > 0){
                                   $('#comision_base').val((monto_dolares * (porcentage_base / 100)));
                                    comision_base = (monto_dolares * (porcentage_base / 100));
                                    //alert(comision);
                                }


                                if(!exonerar_base) {
                                    if(incluir_base) {
                                    montoreal_base = (monto_dolares + comision_base).toFixed(2);
                                    $('#montototal_base').val((monto_dolares + comision_base));
                                    //alert(montoreal);

                                    } else if(descontar_base) {
                                    montoreal_base = (monto_dolares - comision_base).toFixed(2);
                                    $('#montototal_base').val((monto_dolares - comision_base));
                                    }
                                }
                                else {
                                    $('#percentage_base').val('');
                                    $('#comision_base').val('');
                                    montoreal_base = monto_dolares.toFixed(2);
                                    $('#montototal_base').val(monto_dolares);
                                 }
                              }

            });

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



                            $('#tasa, #monto, #percentage').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let monto = parseFloat($('#monto').val());

                                if(tasa > 0 && monto > 0) {
                                    let monto_total = (monto / tasa).toFixed(2);
                                    $('#monto_dolares').val(monto_total);
                                }

                                let comision = parseFloat($('#comision').val());
                                let porcentage = parseFloat($('#percentage').val());
                                let montoreal = parseFloat($('#montototal').val());

                                let exonerar = $('#radio1').is(':checked');
                                //alert(exonerar)
                                let descontar = $('#radio2').is(':checked');
                                let incluir = $('#radio3').is(':checked');
                                //alert(incluir)

                                updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);
                                });

                              $('#radio1, #radio2, #radio3').on('click', function() {
                                let comision = parseFloat($('#comision').val());
                                let porcentage = parseFloat($('#percentage').val());
                                let montoreal = parseFloat($('#montototal').val());

                                let exonerar = $('#radio1').is(':checked');
                                let descontar = $('#radio2').is(':checked');
                                let incluir = $('#radio3').is(':checked');
                                updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);
                              });


                                function updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(porcentage > 0){
                                   $('#comision').val((monto_dolares * (porcentage / 100)));
                                    comision = (monto_dolares * (porcentage / 100));
                                    //alert(comision);
                                }


                                if(!exonerar) {
                                    if(incluir) {
                                     montoreal = (monto_dolares + comision).toFixed(2);
                                    $('#montototal').val((monto_dolares + comision));
                                    //alert(montoreal);

                                    } else if(descontar) {
                                    montoreal = (monto_dolares - comision).toFixed(2);
                                    $('#montototal').val((monto_dolares - comision));
                                    }
                                }
                                else {
                                    $('#percentage').val(0);
                                    $('#comision').val('');
                                    montoreal = monto_dolares.toFixed(2);
                                    $('#montototal').val(monto_dolares);
                                 }
                              }


                            /* PORCENTAJE BASE */
                              $('#tasa, #monto, #percentage_base').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let monto = parseFloat($('#monto').val());

                                if(tasa > 0 && monto > 0) {
                                    let monto_total = (monto / tasa).toFixed(2);
                                    $('#monto_dolares').val(monto_total);
                                }

                                let comision_base = parseFloat($('#comision_base').val());
                                let porcentage_base = parseFloat($('#percentage_base').val());
                                let montoreal_base = parseFloat($('#montototal_base').val());

                                let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                                let descontar_base = $('#radio2_base').is(':checked');
                                let incluir_base = $('#radio3_base').is(':checked');
                                //alert(incluir)

                                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
                                });

                              $('#radio1_base, #radio2_base, #radio3_base').on('click', function() {
                                let comision_base = parseFloat($('#comision_base').val());
                                let porcentage_base = parseFloat($('#percentage_base').val());
                                let montoreal_base = parseFloat($('#montototal_base').val());

                                let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                                let descontar_base = $('#radio2_base').is(':checked');
                                let incluir_base = $('#radio3_base').is(':checked');

                                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
                              });


                                function updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(porcentage_base > 0){
                                   $('#comision_base').val((monto_dolares * (porcentage_base / 100)));
                                    comision_base = (monto_dolares * (porcentage_base / 100));
                                    //alert(comision);
                                }


                                if(!exonerar_base) {
                                    if(incluir_base) {
                                    montoreal_base = (monto_dolares + comision_base).toFixed(2);
                                    $('#montototal_base').val((monto_dolares + comision_base));
                                    //alert(montoreal);

                                    } else if(descontar_base) {
                                    montoreal_base = (monto_dolares - comision_base).toFixed(2);
                                    $('#montototal_base').val((monto_dolares - comision_base));
                                    }
                                }
                                else {
                                    $('#percentage_base').val('');
                                    $('#comision_base').val('');
                                    montoreal_base = monto_dolares.toFixed(2);
                                    $('#montototal_base').val(monto_dolares);
                                 }
                              }


                              /* TASA BASE */
                              $('#tasa, #monto, #tasa_base').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let tasa_base = parseFloat($('#tasa_base').val());
                                let monto = parseFloat($('#monto').val());
                                let monto_b = parseFloat($('#monto_extranjera_base').val());

                                $('#montototal').val($('#monto_dolares').val());

                                if(tasa_base > 0 && monto > 0){

                                    $('#monto_extranjera_base').val(parseFloat($('#monto').val()) / parseFloat($('#tasa_base').val()));

                                    $('#montototal_base').val(parseFloat($('#monto').val()) / parseFloat($('#tasa_base').val()));
                                }

                                let comision_base = parseFloat($('#comision_base').val());
                                let montoreal_base = parseFloat($('#montototal_base').val());


                                updateTasaBase(comision_base, tasa_base, montoreal_base);
                                });


                                function updateTasaBase(comision_base, tasa_base, montoreal_base) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(tasa_base > 0){
                                   $('#comision_base').val(parseFloat($('#monto_dolares').val()) - parseFloat($('#monto_extranjera_base').val()));
                                }

                              }









                         } //ELSE

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

        //exonerar.removeAttribute('checked');
        //exonerar_base.removeAttribute('checked');

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
        $('#montototal').val(dolares);



        });


})//CIERRE DEL READY


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
