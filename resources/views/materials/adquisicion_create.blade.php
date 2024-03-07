@extends('adminlte::page')



@section('title', 'Transacción')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('NUEVA ADQUISICION') }} <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-10 movi" style="min-height: 500px !important; max-height:100%; height:100%; widht:100%"">
        <div class="card-body">

            {!! Form::open(['route' => 'materials.adquisicion_store', 'autocomplete' => 'on', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Movimiento') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Referencias') }}</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">

                {{--   seccion A   --}}                

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}

                    <div class="form-row">

                        <div class="form-group col-md-4 col-xl-4">
                            {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia myForm', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4 col-xl-4 esconder">
                            {!! Form::Label('wallet', "Caja:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-box-open mr-2"></i>
                            {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet myForm', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4 col-xl-4">
                            {!! Form::Label('clientes', "Grupo:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                            {!! Form::select('group_id',$group, null,['class' => 'form-control clientes myForm', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            {!! Form::Label('type_material_id', "Tipo de material:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                            {!! Form::select('type_material_id',$type_material, null, ['class' => 'form-control type_material_id myForm', 'required' => true, 'id' => 'type_material_id', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('exchange_rate', "Precio/U:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate',null, ['class' => 'form-control rateMasks myForm', 'required' => true, 'id' => 'exchange_rate', 'minlength' => 9]) !!}
                            
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('amount_foreign_currency', "Cantidad:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'amount_foreign_currency']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-xl-4">
                            {!! Form::Label('type_coin_balance_id', "Tipo de moneda Balance:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                                {!! Form::select('type_coin_balance_id',$type_coin, null, ['class' => 'form-control myForm', 'required' => true, 'id' => 'type_coin_balance_id', 'readonly' => false]) !!}
                            </div>
                        </div>                    
                        <div class="form-group col-xl-8">
                            {!! Form::Label('monto_dolares', "Monto :") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                                {!! Form::text('amount', null, ['class' => 'form-control dolar general', 'required' => true, 'id' => 'amount', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-row">
                        <div class="form-group col-xl-4">
                            {!! Form::Label('fecha', "Fecha:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                            {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                            </div>
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

        </div>

        {!! Form::close() !!}

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
    });


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

    $("#type_coin_balance_id").select2({
        placeholder: "Seleccionar Moneda",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
    $("#type_coin_balance_id").val("")
    $("#type_coin_balance_id").trigger("change");



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
    $("#wallet").val(null)
    $("#wallet").trigger("change");

    $(".typetrasnferencia").select2({
        placeholder: "Seleccionar ...",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
    $("#typetrasnferencia").val("")
    $("#typetrasnferencia").trigger("change");



    // type_material
    $("#type_material_id").select2({
        placeholder: "Seleccionar ...",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
    $("#type_material_id").val("")
    $("#type_material_id").trigger("change");



    $('.general').inputmask({
        alias: 'decimal',
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

    /*
    $('#monto_dolares').on('input', function() {
        var input1Value = $('#monto_dolares').val();
        //$('#montototal').val(input1Value);
        $('#montototal_base').val(input1Value);
        //$('#monto_extranjera_base').val(input1Value);
    });
    */
    
    
    $(document).ready(function() {

        
        // submit del form 

        $('#entre').on('submit', function() {

            let exchange_rate           = $('#exchange_rate').val()          != "" ? parseFloat($('#exchange_rate').val())            : 0;
            if (!exchange_rate){
                Swal.fire({
                        position: 'left',
                        type: 'error',
                        title: 'Tasa de cambio es obligatoria',
                        showConfirmButton: true
                    });                    
                return false;
            }


            let amount_foreign_currency = $('#amount_foreign_currency').val() != "" ? parseFloat($('#amount_foreign_currency').val())            : 0;
            if (!amount_foreign_currency){
                Swal.fire({
                        position: 'left',
                        type: 'error',
                        title: 'Introduzca la Cantidad de Material',
                        showConfirmButton: true
                    });                    
                return false;
            }
            if (amount_foreign_currency <= 0){
                Swal.fire({
                        position: 'left',
                        type: 'error',
                        title: 'Cantidad de Material no puede ser menor o igual a Cero',
                        showConfirmButton: true
                    });                    
                return false;
            }            

        });

        /*
        *
        *
        *  formulario cambia (nueva implementacion)
        * 
        * 
        */
        $('.myForm').on('input', function (){
            console.log('leam - pasa input');
            updateMontoreal();
        }); 

    });

    $("#typetrasnferencia").on("change", function() {
        console.log('leam - typetransferencia pasa');
        // Capturar dato seleccionado
  
            

            $('#wallet').prop("disabled", false);
            $('#typecoin').prop("disabled", false);
            $('#wallet').prop("required", true);
            $('#typecoin').prop("required", true);

    });
    



    /*
    *
    *
    * updateMontoreal
    * 
    * 
    */
    function updateMontoreal() {



        let exchange_rate           = ($('#exchange_rate').val())   ? parseFloat($('#exchange_rate ').val())    : 0;
        let amount_foreign_currency = ($('#amount_foreign_currency').val())           ? parseFloat($('#amount_foreign_currency').val())             : 0;
        let amount                  = 0;
        let amount_total            = 0;

        console.log('pasa updateMontoreal');
        console.log('pasa updateMontoreal con exchange_rate                 -> ' + exchange_rate);
        console.log('pasa updateMontoreal con amount_foreign_currency       -> ' + amount_foreign_currency);
        console.log('pasa updateMontoreal con amount                        -> ' + amount);
        console.log('pasa updateMontoreal con amount_total                  -> ' + amount_total);


        if (exchange_rate > 0){
            amount          = amount_foreign_currency * exchange_rate;
            amount_total    = amount;
        }

        console.log('leam - amount ->' + amount);

        $('#amount').val(amount);
        $('#amount_total').val(amount_total);
    }


</script>



@endsection
