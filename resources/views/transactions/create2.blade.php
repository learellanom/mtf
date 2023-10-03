@extends('adminlte::page')
@section('title', 'Transacción')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVA TRANSACCION 2     ') }} <i class="fas fa-exchange-alt"></i> </h1></a>


@endsection


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-7 movi" style="min-height: 500px !important; max-height:100%; height:100%; widht:100%"">
        <div class="card-body">

            {!! Form::open([
                    'route' => 'transactions.store', 
                    'autocomplete' => 'on', 
                    'files' => true, 
                    'enctype' => 'multipart/form-data', 
                    'id' => 'entre']) !!}

                {{-- Menu movimiento o referencias--}}                

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button 
                            class="nav-link active" 
                            id="pills-home-tab" 
                            data-toggle="pill" 
                            data-target="#pills-home" 
                            type="button" 
                            role="tab" 
                            aria-controls="pills-home" 
                            aria-selected="true">
                            {{ __('Movimiento') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button 
                            class="nav-link" 
                            id="pills-profile-tab" 
                            data-toggle="pill" 
                            data-target="#pills-profile" 
                            type="button" 
                            role="tab" 
                            aria-controls="pills-profile" 
                            aria-selected="false">
                            {{ __('Referencias') }}
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">

                    {{-- seccion A --}}                

                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                                <div class="input-group-text col-md-12">
                                    <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                                </div>
                            </div>

                            <div class="form-group col-md-4 esconder">
                                {!! Form::Label('wallet', "Tipo de caja:") !!}
                                <div class="input-group-text col-md-12">
                                    <i class="fa-fw fas fa-box-open mr-2"></i>
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
                                {!! Form::text('exchange_rate',null, ['class' => 'form-control percentage rateMasks', 'required' => true, 'id' => 'tasa', 'readonly' => true, 'minlength' => 9]) !!}
                                
                                </div>
                            </div>


                            {{-- Monto en moneda extranjera --}}


                            <div class="form-group col-md-4">

                                {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                                <div class="input-group-text">
                                    <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto', 'readonly' => true]) !!}
                                </div>

                            </div>


                        </div>


                        <div class="form-row">

                            {{-- Monto en dorales ajax --}}

                            <div class="form-group col-md-4">

                                {!! Form::Label('', "Monto en moneda extranjera:") !!}
                                <div class="input-group-text">
                                    <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount',null, ['class' => 'form-control general', 'required' => true, 'id' => 'mymonto_dorales']) !!}
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

                    </div>
                    
                    {{-- ***** seccion botones comision *****  --}}

                    <div class="btn-group botones" data-toggle="buttons">
                        <label class="btn btn-primary" [ngClass]="{'active': s}">
                            <input type="radio" name="options" id="c_porcentaje" class="c_porcentaje" autocomplete="off" (click)="s=true; blah();" value="1" checked> COMISIÓN PORCENTAJE
                        </label>
                        <label class="btn btn-primary" [ngClass]="{'active': !s}">
                            <input type="radio" name="options" id="c_tasa" class="c_tasa" autocomplete="off"(click)="s=false; blah();" value="2"> COMISIÓN TASA
                        </label>
                    </div>

                    <br>
                    <hr class="bg-dark esconder" style="height:1px;">                
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisiones  </h4>

                    <div class="form-row esconder comi">

                    
                        {{-- Porcentaje --}}
            
                        <div class="form-group col-md-6">
                            {!! Form::Label('', "Porcentaje:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                {!! Form::text('percentage',null, ['class' => 'form-control rateMasks', 'required' => 'true', 'id' => 'percentage']) !!}
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



                    {{-- ***** comision Base ***** --}}



                    <hr class="bg-dark esconder" style="height:1px;">


                    <h4 class="text-uppercase font-weight-bold text-center esconder comisionbase">Comisión Base  </h4>
                    <h4 class="text-uppercase font-weight-bold text-center tasa_basee" style="display:none;">Tasa Base  </h4>

                    {{-- <hr class="bg-dark esconder" style="height:1px;"> --}}

                    <div class="form-row esconder">


                        {{-- Porcentaje base --}}

                        <div class="form-group col-md-12 tasa">
                            {!! Form::Label('', "Porcentaje Base:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                            {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base rateMasks', 'id' => 'percentage_base']) !!}
                            </div>
                        </div>


                        {{-- --}}


                        <div class="form-group col-md-12 base" style="display:none;">
                            {!! Form::Label('tasa_base', "Tasa base:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate_base',null, ['class' => 'form-control rateMasks', 'required' => true, 'id' => 'tasa_base']) !!}
                            </div>
                        </div>

                        {!! Form::hidden('amount_base',null, ['class' => 'form-control general', 'min' => 0, 'readonly' => true, 'id' => 'monto_extranjera_base']) !!}

                    </div>



                    {{-- botones de exoneracion de comision Base --}}



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

                    {!! Form::hidden('status',                  'Activo', null, ['class' => 'form-control']) !!}

                    {{-- {!! Form::hidden('amount_commission_profit', null, ['class' => 'form-control', 'id' => 'amount_commission_profit']) !!} --}}

                    <div class="form-group">
                        {!! Form::Label('amount_commission_profit', "Monto Comision Ganancia:") !!}
                        <div class="input-group-text">
                            {!! Form::text('amount_commission_profit', null, ['class' => 'form-control general','id' => 'amount_commission_profit', 'readonly' => true, 'step' => 'any' ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::Label('description', "Descripción:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::textarea('description',null, ['rows' => 1, 'class' => 'form-control', 'required' => false]) !!}
                        </div>
                    </div>

                    {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;", 'id' => 'publish']) !!}

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

    $(".clientes").select2({
        placeholder: "Seleccionar cliente",
        theme: 'bootstrap4',
        notEmpty: false,
        allowClear: true,
        clearing: true,
        width: '100%'
    });

    $("#clientes").val(null)
    $("#clientes").trigger("change");

    $(".typecoin").select2({
        placeholder: "Seleccionar Moneda",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });

    //$("#typecoin").val("")
    //$("#typecoin").trigger("change");

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

    //$("#wallet").val(null)
    //$("#wallet").trigger("change");

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
        insertMode:true, });

    $(".rateMasks").attr("minlength","8");
    $(".rateMasks").attr("maxlength","8");
    $(".rateMasks").inputmask({
        alias: 'decimal',
        repeat: 4,
        allowMinus: true,
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



    $(document).ready(function() {

        inicializaDescripcion();

        // submit del form 

        $('#entre').on('submit', function() {

            tasa            = $('#c_tasa').is(':checked');
            porcentage      = $('#c_porcentaje').is(':checked');
            exonerar        = $('#radio1').is(':checked');
            exonerar_base   = $('#radio1_base').is(':checked');
            transferencia   = $("#typetrasnferencia option:selected").text();



            //
            //
            //
            console.log('amount_commission_profit antres de mandar -> ' + $('#amount_commission_profit').val());



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
             alert('submit de data interceptado');
             event.preventDefault();

        });

        /*
        *
        *
        *  formulario cambia (nueva implementacion)
        * 
        * 
        */
        $('#entre').on('input', function (){
            // alert('cambio form');
            // alert('amount con jquery ->' + $('#mymonto_dorales').val());
            // alert('amount atributo ->' + myVal);

            
             calcula();
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


        $('#typecoin').on('change', function() {
            // ajax
           //  alert('cambia typecoin -> ' + $('#typecoin').val() + ' ' + JSON.stringify($("#mymonto_dolares")));

            if ($('#typecoin').val() == 1) {
                // alert('aqui');

                //

                $('#tasa').prop("readonly", true);
                $('#monto').prop("readonly", true);
                $('#mymonto_dorales').prop('readonly',false);

                $('#mymonto_dorales').trigger('focus');

                //

                $('#tasa').val("");
                $('#monto').val("");
                //$('#mymonto_dorales').val("");

                //$('#monto_extranjera_base').val("");
                //$('#amount_commission_profit').val('0');

            } else if ($('#typecoin').val() == null)
            {
                // cuando el tipode moneda es null
                alert('es null el tipe coin');
                //$('#tasa').attr("readonly", true);
                //$('#monto').attr("readonly", true);
                //$('#mymonto_dorales').prop('readonly',false);                

                //$('#tasa').val("");
                //$('#monto').val("");
                

                //$('#monto_extranjera_base').val("");

                //$('#amount_commission_profit').val('0');
                


            }
            else {

                // cuando el tipo de moneda es distinta de usd y null
                // alert('no es ');
                $('#tasa').prop("readonly", false);
                $('#monto').prop("readonly", false);
                
                $('#mymonto_dorales').attr('readonly',true);
                


            }
        });







        $('#c_porcentaje').on('change', function() { //FUNCION DE PORCENTAJE
            //$('.boton').show();
            //$('.esconder').show();
            //if(this.checked) {
            var dolares         = $('#mymonto_dolares').val();
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
            alert('cambia');
            var dolares         = $('#mymonto_dolares').val() == "" ? 0 : $('#mymonto_dolares').val();
            var exonerar        = document.getElementById("radio1");
            var exonerar_base   = document.getElementById("radio1_base");

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


    }); //CIERRE DEL READY

    
    $("#typetrasnferencia").on("change", function() {
        // Capturar dato seleccionado

        var selectedValue           = this.value;
        var option                  = $("#typetrasnferencia option:selected").text();
        var radio_comision_tasa     = $('#c_tasa').is(':checked');


        

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
            $('#mymonto_dolares').attr("readonly", false);

            $('#mymonto_dolares').on('input', function() {
            var input1Value = $('#mymonto_dolares').val();
            $('#montototal').val(input1Value);
            //$('#montototal_base').val(input1Value);
            //$('#monto_extranjera_base').val(input1Value);
            });

            $('.movi').attr("class", 'card col-md-7 h-100');

        }else if (selectedValue) {
            $('.menos').show();

            {{--
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
            --}}
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
    
    function inicializaDescripcion(){
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
            "Token",
            "Nomina",
            "Pago nomina",
            "Cobro en USDT",
            "Nomina a",
            "Bono",
            "Pago a ",
            "Cobro a ",
            "Credito a ",
            "Pago por suift",
            "Transferencias bancaria",
            ];

        $("#description").autocomplete({
            source: availableTags
        });
    }

    function calcula(){

        let type_coin_id                = $('#typecoin').val()          != "" ? $('#typecoin').val()                        : 0; // tipo de moneda
        let exchange_rate               = $('#tasa').val()              == "" ? 0 : parseFloat($('#tasa').val());
        let amount_foreign_currency     = $('#monto').val()             == "" ? 0 : parseFloat($('#monto').val());  // amount_foreign_currency - monto moneda extranjera
        let amount                      = $('#mymonto_dorales').val()   == "" ? 0 : parseFloat($('#mymonto_dorales').val());
        let percentage                  = $('#percentage').val()        != "" ? parseFloat($('#percentage').val())          : 0;
        //    percentage                  = $('#mipercentage').val()        != "" ? parseFloat($('#mipercentage').val())          : 0;
       //  alert('percentage -> ' + percentage);
        let percentage_base             = $('#percentage_base').val()   != "" ? parseFloat($('#percentage_base').val())     : 0;
        
        let exchange_rate_base          = $('#tasa_base').val()         == "" ? 0 : parseFloat($('#tasa_base').val());
        
        let exonerar                    = $('#radio1').is(':checked');
        let descontar                   = $('#radio2').is(':checked');
        let incluir                     = $('#radio3').is(':checked');

        let exonerar_base               = $('#radio1_base').is(':checked');
        let descontar_base              = $('#radio2_base').is(':checked');
        let incluir_base                = $('#radio3_base').is(':checked');   

        let amount_base                 = 0 ; 

        let amount_commission           = 0;        
        let amount_commission_base      = 0; 

        let amount_total                = 0  
        let amount_total_base           = 0;

        let amount_commission_profit    = 0;
        // alert('amount en calcula ->' + amount);
        //console.log('porcentaje por comision - amount ' + amount);
        //
        //
        // validacion de entradas
        //
        //


        // alert('mi monto ->' + amount + ' type ' +  type_coin_id );
        // 1 incluir
        // 2 exonerar
        // 3 descontar

        //
        // si la transaccion no es en dorales recalcula el amount
        //
        if (type_coin_id == 0) {
            return;
        }
        if (type_coin_id != 1) {
            if (exchange_rate != 0){
                amount = amount_foreign_currency / exchange_rate;
            }
        }
        //
        // determina el tipo de comision
        //
        let myTypeCommission = 0;

        if (percentage > 0 || percentage_base > 0){
            myTypeCommission = 1;
        }else{
            if (exchange_rate_base > 0){
                myTypeCommission = 2;
            }
        }

        if (myTypeCommission == 0){
            amount_commission = 0;
            amount_total      = amount;
            amount_total_base = amount;
        }
        //
        //
        //
        if (myTypeCommission == 1){
            //
            // Comision por porcentaje
            //
            console.log('porcentaje por comision');
            console.log('porcentaje por comision - amount ' + amount);
            console.log('porcentaje por comision - percentage ' + percentage);
            console.log('porcentaje por comision - amount_commission_base ' + amount_commission_base);
            console.log('porcentaje por comision - incluir ' + incluir);

            if (percentage > 0){
                amount_commission           = (amount * percentage ) / 100;
                amount_total                = amount + amount_commission;

                amount_commission_base      = (amount * percentage_base ) / 100;
                
            }else{
                amount_commission           = 0;
                amount_total                = amount + amount_commission;    
                
                  
                amount_commission_base      = (amount * percentage_base ) / 100;
                              
            }

            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission = 0;
            

            if (incluir) {
                myCommission = 1;
            }else if(exonerar) {
                myCommission = 2;
            }else{
                myCommission = 3;
            }

            
            switch(myCommission){
                case 1: // incluir
                    amount_total = amount + amount_commission;
                    break;
                case 2: // exonerar
                    amount_total = amount;
                    break;
                case 3: // descontar
                    amount_total = amount - amount_commission;
                    break;
                default:
                    break;
            }

            if (percentage_base > 0){
                amount_base                 = amount;
                amount_commission_base      = (amount * percentage_base ) / 100;
                amount_total_base           = amount + amount_commission_base;
                
            }else{
                amount_base                 = amount;
                amount_commission_base      = 0;
                amount_total_base           = amount;            
                
            }

            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission_base = 0;

            if (incluir_base) {
                myCommission_base = 1;
            }else if(exonerar_base) {
                myCommission_base = 2;
            }else{
                myCommission_base = 3;
            }

            switch(myCommission_base){
                case 1:
                    amount_total_base = amount_base + amount_commission_base;
                    break;
                case 2:
                    amount_total_base = amount_base;
                    break;
                case 3:
                    amount_total_base = amount_base - amount_commission_base;
                    break;
                default:
                    amount_total_base = amount_base;
                    break;
            }

            amount_commission_profit    = amount_commission - amount_commission_base;
            // amount_commission_profit    = -22;
             // alert('la comision es ->' + amount_commission_profit);
             // alert('la comision tipo es ->' + typeof amount_commission_profit);


             // exchange_rate = 0;
             // exchange_rate_base = 0;
        }




        if (myTypeCommission == 2){
            //
            // comision tasa
            //
            if (exchange_rate_base > 0){
                amount_base                 = amount_foreign_currency / exchange_rate_base;
                amount_commission_base      = 0;
                amount_total_base           = amount_base;
                amount_commission_profit    = amount - amount_base;    
            }else{
                amount_base                 = amount;
                amount_total_base           = amount;
                amount_commission_profit    = 0;
            }

            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission_base = 0;

            if (incluir_base) {
                myCommission_base = 1;
            }else if(exonerar_base) {
                myCommission_base = 2;
            }else{
                myCommission_base = 3;
            }

            switch(myCommission_base){
                case 1:
                    amount_total_base = amount_base + amount_commission_base;
                    break;
                case 2:
                    amount_total_base = amount_base;
                    break;
                case 3:
                    amount_total_base = amount_base - amount_commission_base;
                    break;
                default:
                    amount_total_base = amount_base;
                    break;
            }

             percentage_base          = 0;
             percentage               = 0;
             amount_commission        = 0;
             amount_commission_base   = 0;
        }
        
        console.log('llega con amount commission ->' + amount_commission);
        console.log ('la comision es ->' + amount_commission_profit); 
        
        if (type_coin_id != 1) {
            $('#mymonto_dorales').val(parseFloat(amount));
        }

        $('#monto_extranjera_base').val(amount_base);
        
        $('#comision').val(amount_commission);
        $('#comision_base').val(amount_commission_base);
        $('#montototal').val(amount_total);
        $('#montototal_base').val(amount_total_base);
        $('#amount_commission_profit').val(amount_commission_profit);

         $('#tasa').val(exchange_rate);
         $('#tasa_base').val(exchange_rate_base );

         // $('#percentage').val(percentage);
         // $('#percentage_base').val(percentage_base);

         //alert('amount commission profit en $ ->' + $('#amount_commission_profit').val());
         //alert('calculo ->' + (1-4));

    }

    

</script>



@endsection
