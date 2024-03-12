@extends('adminlte::page')
@section('title', 'Transacciones')
@section('content_header')

<h1 class="text-center text-dark font-weight-bold">MODIFICAR ADQUISICION MATERIAL<i class="fas fa-coins"></i> </h1></a>

@stop


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-10" style="min-height:500px; !important; max-height:100%; height:100%; widht:100%">
        <div class="card-body">

            {!! Form::model($transactions, ['route' => ['materials.adquisicion_update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'myForm']) !!}



            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Movimiento') }}</button>
                </li>

                <div class="col-md-4 justify-content-start float-right">
                    <span class="badge badge-primary text-lg text-uppercase">
                        <h6 class="font-weight-bold text-uppercase"> Transacción numero # - {{ $transactions->id }}</h6>
                    </span>
                </div>

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


                    <div class="form-row">
                        <div class="form-group  col-12 mt-4 mb-4">
                            <label class="form-check-label mx-auto  col-md-3">
                                {!! Form::Label('', "Orientacion del Cambio:") !!}
                            </label>

                            <label class="form-check-label mx-auto col-md-4" for="exchange_rate_orientation2_radio1">
                                {!! Form::radio('exchange_rate_orientation',1, 1, ['id' => 'exchange_rate_orientation2_radio1', 'class' => 'myForm','required' => true,]) !!}
                                De tipo Moneda Balance -> Tipo de Moneda
                            </label>
                            <label class="form-check-label mx-auto esconder comi col-md-4" for="exchange_rate_orientation2_radio2">
                                {!! Form::radio('exchange_rate_orientation',2, null, ['id' => 'exchange_rate_orientation2_radio2', 'class' => 'myForm', 'required' => true,]) !!}
                                De tipo Moneda  -> Tipo de Moneda Balance
                            </label>
                            <!--
                            <label class="form-check-label mx-auto esconder comi col-md-2">
                            </label>
                            -->
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
                                {!! Form::text('amount', null, ['class' => 'form-control dolar general myForm', 'required' => true, 'id' => 'amount', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                            </div>
                        </div>

                    </div>




                    
                    
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
                        {!! Form::Label('material_price', "Precio/U:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::text('material_price',null, ['class' => 'form-control rateMasks myForm', 'required' => true, 'id' => 'material_price', 'minlength' => 9]) !!}
                        
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount', "Cantidad:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount_total', "Monto Total Material:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                            {!! Form::text('material_amount_total', null, ['class' => 'form-control dolar general', 'required' => true, 'id' => 'material_amount_total', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                        </div>
                    </div>
                </div>

                <hr class="bg-dark esconder" style="height:1px;">    

                <div class="form-row">
                        <div class="form-group col-xl-4">
                            {!! Form::Label('fecha', "Fecha:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                            {!! Form::datetimeLocal('transaction_date', $transactions->transaction_date, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
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
</div>


@endsection


@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">



<style>
.form-control{
    width: 100%;
}
.input-group-text{
    width: 100%;
}
.file-preview-thumbnails{
    overflow-y: scroll;
    height: 650px;
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



</style>
@endsection

@section('js')
<script>

    $('.general').inputmask({
        alias: 'decimal',
        allowMinus: false,
        autoUnmask:true,
        removeMaskOnSubmit:true,
        rightAlign: true,
        groupSeparator:".",
        undoOnEscape:true,
        //insertMode:false,
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
        utoUnmask: true,
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

        // alert(" " + {{ $transactions->type_transaction_id}});
        if ({{ $transactions->type_coin_id}} == 1) {
            // $('#tasa').attr("readonly", true);
            // $('#monto').attr("readonly", true);
        }
        else {
            
            // $('#tasa').prop("readonly", false);
            // $('#monto').prop("readonly", false);
        }
        $('#myForm').on('input', function (){
            // alert('cambio');
            calcula();
        });        

        $('#myForm').on('submit', function() {
            // alert($('#percentage').val());
            // percentage_base

            if ($('#tasa').val() == "" || $('#tasa').val() == 0){
                Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Introduzca la Tasa de Cambio',
                        showConfirmButton: true
                    }
                );  
                return false;
            }

            // Valida
            if ($('#radio3').is(':checked') || $('#radio2').is(':checked')){
                if ($('#percentage').val() == "" || $('#percentage').val() == 0){

                    Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Porcentaje de Comision en Blanco',
                            showConfirmButton: true
                        }
                    );  
                    $('#percentage').focus();
                    return false;
                    
                }
            }

            if ($('#description').val() == ""){
                Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Descripción no puede estar en blanco',
                        showConfirmButton: true
                    }
                );  
                return false;
            }


            if ($('#radio3_base').is(':checked') || $('#radio2_base').is(':checked')){
                if ($('#percentage_base').val() == "" || $('#percentage_base').val() == 0){

                    Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Porcentaje de Comision Base en Blanco',
                            showConfirmButton: true
                        }
                    );  
                    $('#percentage').focus();
                    return false;
                    
                }
            }


        });


    });
    
    function calcula(){
        // alert('calcula ----');
        
        let type_coin_id                = {{ $transactions->type_coin_id}} ;
        let exchange_rate               = $('#exchange_rate').val()                 != "" ? parseFloat($('#exchange_rate').val())           : 0;
        let amount_foreign_currency     = $('#monamount_foreign_currencyto').val()  != "" ? parseFloat($('#amount_foreign_currency').val()) : 0;  // amount_foreign_currency - monto moneda extranjera
        let amount                      = $('#amount').val()                        != "" ? parseFloat($('#amount').val())                  : 0;

        let exchange_rate_orientation;
        let exchange_rate_orientation1  = $('#exchange_rate_orientation2_radio1').is(':checked');
        let exchange_rate_orientation2  = $('#exchange_rate_orientation2_radio2').is(':checked');
        
        let material_price              = $('#material_price').val()             != "" ? parseFloat($('#material_price').val())             : 0;
        let material_amount             = $('#material_amount').val()            != "" ? parseFloat($('#material_amount').val())             : 0;

        if (exchange_rate_orientation1){
            exchange_rate_orientation = 1;
        }else{
            exchange_rate_orientation = 2;
        }
        // console.log('leam - ' + exchange_rate_orientation);
        if (exchange_rate > 0){
            switch(exchange_rate_orientation){
                case 1:
                    amount = amount_foreign_currency / exchange_rate;
                    break;
                case 2:
                    amount = amount_foreign_currency * exchange_rate;
                    break;
            }
        }else{
            //amount = 0;
            //amount_foreign_currency = 0;
        }

        let material_amount_total;
        if (material_price > 0){
            if (material_amount > 0){
                material_amount_total = material_price * material_amount;
            }
        }

        $('#amount').val(amount);
        $('#material_amount_total').val(material_amount_total);
        // $('#montototal').val(amount_total);
        // $('#monto_base').val(amount_total_base);
    }

</script>



@endsection
