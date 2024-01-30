@extends('adminlte::page')



@section('title', 'Pagos del Proveedor')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Transferencia entre cajas - otras operaciones v2') }}<i class="fas fa-donate"></i> </h1></a>


@stop

@php
    
    $fecha = now();

    //echo $fecha;
    //die();

@endphp 

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-lg-12" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
        <div class="card-body">

            {!! Form::open(['route' => 'transactions.transfer_walletop', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}


            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active text-uppercase font-weight-bold"
                      id="pills-home-tab"
                      data-toggle="pill"
                      data-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true">{{ __('Pagos') }}</button>
                </li>

            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form-row">

                        <div class="form-group col-xl-4">
                            {!! Form::Label('type_transaction_id', "Tipo de transacción:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fa fas fa-exchange-alt mr-2"></i>
                                {!! Form::select('type_transaction_id', $type_transaction, null, ['class' => 'form-control transaccion', 'required' => true, 'id' => 'typetransaccion']) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-4" >
                            {!! Form::Label('wallet_id', "Caja de origen (Proveedor):") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet muestra', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-4">
                            {!! Form::Label('wallet2_id', "Caja destino:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('wallet2_id', $wallet2, null, ['class' => 'form-control wallet2 oculta', 'required' => true, 'id'=>'wallet2', 'readonly' => false]) !!}
                            </div>
                        </div>

                    </div>
                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Transaccion Origen</h4>

                    <div class="form-row ">
                        <div class="form-group col-xl-4">
                            {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                                {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control', 'required' => true, 'id' => 'type_coin_id', 'readonly' => false]) !!}
                            </div>
                        </div>
                        <div class="form-group col-xl-4">
                            {!! Form::Label('tasa', "Tasa:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::text('exchange_rate',null, ['class' => 'form-control percentage rateMasks', 'required' => true, 'id' => 'tasa', 'readonly' => true, 'minlength' => 9]) !!}
                            
                            </div>
                        </div>


                        <div class="form-group col-xl-4">

                            {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto', 'readonly' => true]) !!}
                            </div>

                        </div>

                    </div>



                    <div class="form-group row d-flex mt-4 mb-4">

                        <label class="form-check-label mx-auto  col-md-2">
                            {!! Form::Label('', "Orientacion del Cambio:") !!}
                        </label>

                        <label class="form-check-label mx-auto esconder comi col-md-3" for="exchange_rate_orientation_radio1">
                            {!! Form::radio('exchange_rate_orientation',1, null, ['id' => 'exchange_rate_orientation_radio1', 'class' => 'incluir','required' => true,]) !!}
                            De tipo Moneda Balance -> Tipo de Moneda
                        </label>
                        <label class="form-check-label mx-auto esconder comi col-md-3" for="exchange_rate_orientation_radio2">
                            {!! Form::radio('exchange_rate_orientation',2, null, ['id' => 'exchange_rate_orientation_radio2', 'class' => 'exonerar', 'required' => true,]) !!}
                            De tipo Moneda  -> Tipo de Moneda Balance
                        </label>
                        <label class="form-check-label mx-auto esconder comi col-md-2">
                        </label>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-xl-4">
                            {!! Form::Label('typecoin', "Tipo de moneda Balance:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                            {!! Form::select('type_coin_balance_id',$type_coin, null, ['class' => 'form-control', 'required' => true, 'id' => 'typecoinbalance', 'readonly' => false]) !!}
                            </div>
                        </div>
                        <div class="form-group col-xl-8">
                            {!! Form::Label('amount', "Monto en monda Balance:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                                {!! Form::text('amount', null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto_dolares']) !!}
                            </div>
                        </div>
                    </div>

                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center ">Transaccion Destino</h4>


                    <div class="form-row ">
                        <div class="form-group col-xl-4">
                            {!! Form::Label('type_coin_id2', "Tipo de moneda:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                                {!! Form::select('type_coin_id2',$type_coin, null, ['class' => 'form-control', 'required' => true, 'id' => 'type_coin_id2', 'readonly' => false]) !!}
                            </div>
                        </div>
                        <div class="form-group col-xl-4">
                            {!! Form::Label('exchange_rate2', "Tasa:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate2',null, ['class' => 'form-control percentage rateMasks', 'required' => true, 'id' => 'exchange_rate2', 'readonly' => true, 'minlength' => 9]) !!}
                            
                            </div>
                        </div>


                        <div class="form-group col-xl-4">

                            {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto', 'readonly' => true]) !!}
                            </div>

                        </div>

                    </div>

                    <div class="form-group row d-flex mt-4 mb-4">

                        <label class="form-check-label mx-auto  col-md-2">
                            {!! Form::Label('', "Orientacion del Cambio:") !!}
                        </label>

                        <label class="form-check-label mx-auto esconder comi col-md-3" for="exchange_rate_orientation2_radio1">
                            {!! Form::radio('exchange_rate_orientation2',1, null, ['id' => 'exchange_rate_orientation2_radio1', 'class' => 'incluir','required' => true,]) !!}
                            De tipo Moneda Balance -> Tipo de Moneda
                        </label>
                        <label class="form-check-label mx-auto esconder comi col-md-3" for="exchange_rate_orientation2_radio2">
                            {!! Form::radio('exchange_rate_orientation2',2, null, ['id' => 'exchange_rate_orientation2_radio2', 'class' => 'exonerar', 'required' => true,]) !!}
                            De tipo Moneda  -> Tipo de Moneda Balance
                        </label>
                        <label class="form-check-label mx-auto esconder comi col-md-2">
                        </label>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-xl-4">
                            {!! Form::Label('typecoin', "Tipo de moneda Balance:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                            {!! Form::select('type_coin_balance_id',$type_coin, null, ['class' => 'form-control', 'required' => true, 'id' => 'typecoinbalance', 'readonly' => false]) !!}
                            </div>
                        </div>
                        <div class="form-group col-xl-8">
                            {!! Form::Label('amount', "Monto en monda Balance:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                                {!! Form::text('amount', null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto_dolares']) !!}
                            </div>
                        </div>

                    </div>



                    <hr class="bg-dark esconder comi" style="height:1px;">

                    {!! Form::hidden('status', 'Activo', null, ['class' => 'form-control']) !!}

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            {!! Form::Label('token', "Token:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-lock mr-2"></i>
                                {!! Form::text('token',null, ['class' => 'form-control', 'placeholder' => 'Numero del Token']) !!}
                            </div>
                            <small class="form-text text-muted mr-4 text-right">Token no es obligatorio.</small>

                        </div>


                            <div class="form-group col-md-6">
                                {!! Form::Label('transaction_date', "Fecha:") !!}
                                <div class="input-group-text col-md-12 ">
                                    <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                                    {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                                </div>
                            </div>
                            {!! Form::hidden('type_transaction2_id', null, ['class' => 'form-control transaccion','required' => true, 'id' => 'typetransaccion2']) !!}
                        </div>
                    </div>

                    </div>

                    <div class="form-group">

                        {{--  {!! Form::hidden('pay_number', $number,['class' => 'form-control', 'required' => true, 'readonly' => true]) !!} --}}

                    </div>


                    {{-- Comision --}}


                    <br>
                    <hr class="bg-dark esconder" style="height:1px;">                
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisiones  </h4>

                    <div class="form-row esconder comi">


                        {{-- Porcentaje --}}

                    
                        <div class="form-group col-md-6">
                            {!! Form::Label('percentage', "Porcentaje:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                            {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMasks', 'required' => true, 'id' => 'percentage']) !!}
                            </div>
                        </div>


                        {{-- Comision --}}


                        <div class="form-group col-md-6">

                            {!! Form::Label('comision', "Monto Comisión:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('amount_commission',null, ['class' => 'form-control comision general', 'required' => true, 'readonly' => true, 'id' => 'comision']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="form-group row d-flex justify-content-center">

                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio1">
                            {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true,]) !!}
                            Exonerar comisión
                        </label>

                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio3">
                            {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'class' => 'incluir','required' => true,]) !!}
                            Incluir comisión
                        </label>


                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio2">
                            {!! Form::radio('exonerate',3, null, ['id' => 'radio2', 'class' => 'descontar', 'required' => true,]) !!}
                            Descontar comisión
                        </label>

                    </div>

                    <div class="form-group col-md esconder">
                        {!! Form::Label('montototal', "Monto Total:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general', 'required' => true, "minlength" => "3", 'id' => 'montototal', 'readonly' => true]) !!}
                        </div>
                    </div>





                    {{-- Comision Base --}}

                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Base  </h4>
                    <div class="form-row esconder comi">

                        <div class="form-group col-md-6">
                            {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base rateMasks',  'min' => 0, 'id' => 'percentage_base']) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">

                            {!! Form::Label('amount_commission_base', "Monto Comisión Base:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount_commission_base',null, ['class' => 'form-control comision_base general', 'readonly' => true, 'id' => 'comision_base']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row d-flex justify-content-center">
                        
                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio1_base">
                            {!! Form::radio('exonerate_base',2, null, ['id' => 'radio1_base', 'required' => true, 'class' => 'exonerar_base']) !!}
                            Exonerar comisión base
                        </label>
                        
                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio3_base">
                            {!! Form::radio('exonerate_base',1, null, ['id' => 'radio3_base', 'required' => true, 'class' => 'incluir_base']) !!}
                            Incluir comisión base
                        </label>


                        <label class="form-check-label mx-auto esconder comi col-md-4" for="radio2_base">
                            {!! Form::radio('exonerate_base',3, null, ['id' => 'radio2_base', 'required' => true, 'class' => 'descontar_base']) !!}
                            Descontar comisión base
                        </label>

                    </div>
                    
                    {{-- Monto total base --}}

                    <div class="form-group col-md">
                        {!! Form::Label('monto_base', "Monto total Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-coins mr-2"></i>
                            {!! Form::text('amount_total_base', null, ['class' => 'form-control general', 'id' => 'monto_base', 'readonly' => true]) !!}
                        </div>
                    </div>

                    <hr class="bg-dark esconder comi" style="height:1px;">



                    {!! Form::hidden('amount_commission_profit', null, ['class' => 'form-control', 'required' => true, 'id' => 'amount_commission_profit','readonly']) !!}



                    <div class="form-group">
                        {!! Form::Label('description', "Descripción origen:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            {!! Form::text('description','Transferido a caja', ['id' => 'descripcion', 'class' => 'form-control', 'readonly' => false, 'required' => true, 'value' => 'Recibido de cliente']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        {!! Form::Label('description2', "Descripción destino:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            {!! Form::text('description2','Transferido de la caja', ['id' => 'descripcion2', 'class' => 'form-control', 'readonly' => false, 'required' => true]) !!}
                        </div>
                    </div>

                    {{--
                    <div class="row justify-content-center">
                        {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px; max-width: 130px;" , 'id' => 'publish']) !!}
                    </div>
                    --}}

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
    height: 350px;
	width: 750px;

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





</style>
@endsection

@section('js')
<script>


    $(document).ready(function() {

        $(".typecoin").select2({
            placeholder: "Seleccionar Moneda",
            theme: 'bootstrap4',
            allowClear: true   
        });

        $("#typecoin").val("");
        $("#typecoin").trigger("change");
        $('#typecoin').on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });


        $("#typetransaccion").select2({
            placeholder: "Selecciona..",
            theme: 'bootstrap4',
            allowClear: true               
        });
         $('#typetransaccion').on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });
        $("#typetransaccion").val("");
        $("#typetransaccion").trigger("change");



        
        $('.general').inputmask({
            alias: 'decimal',
            allowMinus: true,
            autoUnmask:true,
            removeMaskOnSubmit:true,
            rightAlign: true,
            groupSeparator:".",
            undoOnEscape:true,
            insertMode:false,
            clearIncomplete:true,
            digits: 2,
            autoClear: true,
            insertMode:true, 
        });


        $(".rateMasks").attr("minlength","8");
        $(".rateMasks").attr("maxlength","8");
        $(".rateMasks").inputmask({
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
            digits: 7,
            insertMode:true,
        });


        // $('#monto_dolares').on('input', function() {
        //     var dolar = $('#monto_dolares').val();
        //     $('#montototal_base').val(dolar);

        //     $('#montototal').val(dolar);
        // });



        /* OCULTAR LA CAJA SELECCIONADA */
        $('.muestra').select2({
            'theme':'bootstrap4',
            search: false,
            allowClear: true,
            placeholder: "Seleccionar cliente",
            width:'100%'
        });
        $(".muestra").val("")
        $(".muestra").trigger("change");
        $('.muestra').on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });



        $('.oculta').select2({
            'theme':'bootstrap4',
            allowClear: true,
            placeholder: "Seleccionar cliente",
        });
        $(".oculta").val("")
        $(".oculta").trigger("change");
        $('.oculta').on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });


        $('#entre').on('submit', function() {

            var val1 = $('#wallet').val();
            var val2 = $('#wallet2').val();
            exonerar_base = $('#radio1_base').is(':checked');

            if (val1 == val2) {
                Swal.fire('Las cajas no pueden ser iguales')
                return false; //prevent form submission
            }

            if ($('#monto_dolares').val().length == 0) {
                Swal.fire('Monto en dolares, no puede estar vacio :(');
                return false;
            }

            if ($('#monto_dolares').val() <= 0) {
                Swal.fire('Monto en dolares, no puede ser cero o menor a cero. :(');
                return false;
            }

            if(!exonerar_base){
                if ($('#percentage_base').val() <= 0) {
                    Swal.fire('Porcentage base, no puede ser cero o menor a cero. :(');
                    return false;
                }
            }

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


        /* OCULTAR LA CAJA SELECCIONADA */


        tasa = document.getElementById("tasa");
        monto = document.getElementById("monto");
        // monto_dolares = document.getElementById("monto_dolares");
        //const log = document.getElementById("montototal");

        $('#monto_dolares, #percentage_base, #percentage, #radio1, #radio2, #radio3').on('input', function() {
            
            let comision_base   = parseFloat($('#comision_base').val());
            let porcentage_base = parseFloat($('#percentage_base').val());
            let montoreal_base  = parseFloat($('#monto_base').val());

            let exonerar_base   = $('#radio1_base').is(':checked');
            let descontar_base  = $('#radio2_base').is(':checked');
            let incluir_base    = $('#radio3_base').is(':checked');

            updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);

            $('#radio1_base, #radio2_base, #radio3_base').on('click', function() {
                
                let comision_base       = parseFloat($('#comision_base').val());
                let porcentage_base     = parseFloat($('#percentage_base').val());
                let montoreal_base      = parseFloat($('#monto_base').val());

                let exonerar_base       = $('#radio1_base').is(':checked');
                let descontar_base      = $('#radio2_base').is(':checked');
                let incluir_base        = $('#radio3_base').is(':checked');

                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
            });

        });
        
        $("#typetransaccion").on("change", function() {
            // Capturar dato seleccionado
            var selectedValue = this.value;
            var option = $("#typetransaccion option:selected").text();
            var optionId = $("#typetransaccion option:selected").val();
            // Realizar la acción deseada en función del valor seleccionado
            // if (option == 'Pago Efectivo')
            if (optionId == 3)            
            {
                $('#typetransaccion2').val(6); // Nota de Credito a Caja de efectivo
            }
            else
            {
                $('#typetransaccion2').val(7); // Nota de credito
            }
        });

        $("#wallet, #typetransaccion").change(function() {
            var valor   = $(this).val(); // Capturamos el valor del select
            var texto   = $("#wallet option:selected").text(); // Capturamos el texto del option seleccionado
            var texto2  = $("#typetransaccion option:selected").text(); //Capturamos el texto del option tipo transacción seleccionado

            $("#descripcion2").val('Transferido de la caja ' +texto +'/' + texto2);
        });

        $("#wallet2, #typetransaccion").change(function() {
            var valor   = $(this).val(); // Capturamos el valor del select
            var texto   = $("#wallet2 option:selected").text(); // Capturamos el texto del option seleccionado
            var texto2  = $("#typetransaccion option:selected").text(); //Capturamos el texto del option tipo transacción seleccionado

            $("#descripcion").val('Transferido a la caja ' + texto + '/' + texto2);
        });

        /* REFERENCIAS PARA RESPALDO DE MOVIMIENTO */
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

                // alert(JSON.stringify(data));
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

        /* REFERENCIAS PARA RESPALDO DE MOVIMIENTO */



    });

    
    let myWallet = {{ $myWallet ?? 0 }};
    
    if (myWallet > 0) {
        BuscaWallet(myWallet);
        BuscaWallet2(myWallet);
    }
    
    function updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base) {
        


        let monto_dolares               = parseFloat($('#monto_dolares').val());
            
        
        let percentage                  = $('#percentage').val() == "" ? 0 : parseFloat($('#percentage').val());
        let exonerar                    = $('#radio1').is(':checked');
        let descontar                   = $('#radio2').is(':checked');
        let incluir                     = $('#radio3').is(':checked');
        let amount_commission_profit    = 0;

        

        let amount_commission           = 0;
        if (percentage > 0) {

            amount_commission = monto_dolares * (percentage / 100);
        }

        

        let amount_total = 0;
        if (exonerar) {
            $('#percentage').val('');
            $('#percentage').attr('disabled',true);
            percentage = 0;
            amount_commission = 0;
            amount_total = monto_dolares;
        }else if(incluir){
            $('#percentage').prop('disabled',false);
            amount_total = monto_dolares + amount_commission;
        }else if (descontar){
            $('#percentage').prop('disabled',false);
            
            amount_total = monto_dolares - amount_commission;
        }else{
            amount_commission = 0;
            amount_total = monto_dolares;
        }
        
        

        comision_base = 0;
        if(porcentage_base > 0){
            $('#comision_base').val((monto_dolares * (porcentage_base / 100)));
            comision_base = (monto_dolares * (porcentage_base / 100));

        }
        
        if(!exonerar_base) {
            if(incluir_base) {
                montoreal_base = (monto_dolares + comision_base).toFixed(2);
                $('#monto_base').val((monto_dolares + comision_base));
                //alert(montoreal);

            } else if(descontar_base) {
                montoreal_base = (monto_dolares - comision_base).toFixed(2);
                $('#monto_base').val((monto_dolares - comision_base));
            }
        }
        else {
            $('#percentage_base').val('');
            $('#comision_base').val('');
            montoreal_base = monto_dolares.toFixed(2);   
            $('#monto_base').val(monto_dolares);
        }

        amount_commission_profit = amount_commission - comision_base;
        
        $('#montototal').val(amount_total.toFixed(2));
        $('#comision').val(amount_commission.toFixed(2));
        $('#amount_commission_profit').val(amount_commission_profit);

    }

    function BuscaWallet(miWallet = ""){

        if (miWallet == "") return;
        
        $('#wallet3 option').each( function(index, element){

                
                if ($(this).attr('val')  === miWallet.toString()){   

                    $("#wallet3 option[val="+ miWallet +"]").prop('selected',true);
                }

            
        });
    }

    function BuscaWallet2(miWallet){
        if (miWallet===0){
            return;
        }

        $('#wallet').each( function(index, element){

            $(this).children("option").each(function(){
                if ($(this).val() === miWallet.toString()){
                    
                    $("#wallet option[val="+ miWallet +"]").prop('selected',true);
                    $("#wallet").change();
                }

            });
        });
    }


</script>


@endsection
