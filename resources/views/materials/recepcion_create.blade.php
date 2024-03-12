@extends('adminlte::page')



@section('title', 'Recepción')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Nueva Recepción') }} <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-10 movi" style="min-height: 500px !important; max-height:100%; height:100%; widht:100%"">
        <div class="card-body">

            {!! Form::open(['route' => 'materials.recepcion_store', 'autocomplete' => 'on', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Movimiento') }}</button>
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
                    <!--
                    <hr class="bg-dark esconder" style="height:1px;">    
                    <div class="form-row esconder">
                        <div class="form-group col-md-4">
                            {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                            {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true, 'id' => 'type_coin_id', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('exchange_rate', "Tasa:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate',null, ['class' => 'form-control rateMasks myForm', 'required' => true, 'id' => 'exchange_rate', 'minlength' => 9]) !!}
                            
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('amount_foreign_currency', "Monto en moneda extranjera:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'amount_foreign_currency']) !!}
                            </div>
                        </div>



                    </div>
                    -->            
                    
                </div>

                <hr class="bg-dark escoder" style="height:1px;">   
                <div class="form-row">
                           
                    <div class="form-group col-md-3">
                        {!! Form::Label('type_material_id', "Tipo de material:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                        {!! Form::select('type_material_id',$type_material, null, ['class' => 'form-control type_material_id myForm', 'required' => true, 'id' => 'type_material_id', 'readonly' => false]) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount', "Cantidad:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">

                    </div>
                </div>

                <hr class="bg-dark esconder" style="height:1px;">    

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

    $("#type_coin_id").select2({
        placeholder: "Seleccionar Moneda",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
    $("#type_coin_id").val("")
    $("#type_coin_id").trigger("change");

    $("#type_coin_balance_id").select2({
        placeholder: "Seleccionar Moneda",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
    // $("#type_coin_balance_id").val("")
    // $("#type_coin_balance_id").trigger("change");



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

    
    BuscaMyElement('type_coin_balance_id',1);
    
    $(document).ready(function() {


        // submit del form 

        $('#entre').on('submit', function() {
         
            let myDate      = new Date($('#fecha').val());
            let myDateNow   = new Date();

            // valida cuantos dias hacia atras se permite cargar una transaccion

            let myDays;
            myDays = 4;
            myDays = 30;
            // myDays = 240;

            let myDateBefore = new Date();
                myDateBefore.setDate(myDateBefore.getDate() - myDays);

            if (myDate <= myDateBefore){
                Swal.fire({
                        position: 'left',
                        type: 'error',
                        title: `Error: Fecha de transacción no puede ser menor a ${myDays} dias anteriores a la fecha`,
                        showConfirmButton: true
                    });
                return false;
            }


            if (myDate > myDateNow){
                Swal.fire({
                        position: 'left',
                        type: 'error',
                        title: 'Error: Fecha de transacción no puede ser mayor a la fecha',
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
            $('#wallet').prop("required", true);

    });
    



    /*
    *
    *
    * updateMontoreal
    * 
    * 
    */
    function updateMontoreal() {

        console.log('pasa updateMontoreal');

    }

    function BuscaMyElement(myControl = "", myElement = ""){
        // alert("BuscaTypeMaterial - myTypeMaterial -> " + myTypeMaterial);

        let mySelect = myControl;
        let myValue  = myElement;

        // console.log('leam - busca en select ->' + mySelect);
        // console.log('leam - busca myValue   ->' + myValue);

        $('#' + mySelect).each( function(index, element){
            // alert ("BuscaMaterial -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myValue.toString()){
                    // alert('Busca Material - encontro');
                    // console.log('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }


</script>



@endsection

