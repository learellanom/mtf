@extends('adminlte::page')



@section('title', 'Pagos entre clientes')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Pagos entre clientes') }} <i class="fas fa-donate"></i> </h1></a>


@stop

@php
    $myDays = config('transactions.transaction_days',30);


    // $nroTransferencia = 0;
    // dd($transactionOrigen);
    

@endphp

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-5" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
        <div class="card-body">

            {!! Form::open(['route' => 'transactions.store_pagocliente2', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}


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
                        aria-selected="true">{{ __('PAGOS') }}</button>
                </li>
                <p>Numero Transferencia: {{ $nroTransferencia }}</p>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form-row">                
                        <div class="form-group col-md-6">
                            
                            
                            <label for="type_transaction_id">Tipo de Movimiento Origen:</label>
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('type_transaction_id',$type_transaction_debit, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'type_transaction_id', 'readonly' => false]) !!}
                            </div>
                        </div>      
                        <div class="form-group col-md-6">
                            
                            <label for="type_transaction_id2">Tipo de Movimiento Destino:</label>
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('type_transaction_id2',$type_transaction_credit, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'type_transaction_id2', 'readonly' => false]) !!}
                            </div>
                        </div>                        
                    </div>  

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            
                            <label for="group_id">Cliente de origen:</label>
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('group_id', $group, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'group_id', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            
                            <label for="group2_id">Cliente destino:</label>
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('group2_id', $group, null, ['class' => 'form-control wallet2', 'required' => true, 'id'=>'group2_id', 'readonly' => false]) !!}
                            </div>
                        </div>

                    </div>

                    @foreach($wallet as $wallet2)
                        <input type="hidden" name="wallet_id" id="{{$wallet2}}"  >
                        <input type="hidden" name="wallet2_id" id="{{$wallet2}}"  >
                    @endforeach

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="amount">Monto en dolares:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                                <input class="form-control general" name="amount" required id="amount" type="text" inputmode="decimal">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            
                            <label for="transaction_date">Fecha:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                                <input class="form-control" required id="transaction_date" name="transaction_date" type="datetime-local" value="{{ $fecha }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{-- {!! Form::hidden('pay_number', $number,['class' => 'form-control', 'required' => true, 'readonly' => true]) !!} --}}
                    </div>



                    {{-- Comision Origen --}}


                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Origen  </h4>
                    <div class="form-row esconder comi">

                        <div class="form-group col-md-4">
                            <label for="percentage">Porcentaje Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="percentage" name="percentage" class="form-control percentage rateMasks" min="0">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="commission">Monto Comisión Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text"  name="commission" id="commission" class="form-control comision_base general" min="0" readonly> </input>
                            </div>

                        </div>

                        <div class="form-group col-md-4 ">
                            {{-- Monto total Origen --}}
                            <label for="amount_total">Monto total Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total" id="amount_total" class="form-control general" readonly></input>
                            </div>
                        </div>

                    </div>
                    

                    <div class="form-group col-md-12 d-flex justify-content-center">

                        <label class="form-check-label mx-auto esconder comi" for="radio1_base">
                            <input type="radio" name="exonerate" id="radio1_base" class="exonerar_base" value="2">
                            Exonerar comisión origen
                        </label>

                        <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                            <input type="radio" name="exonerate" id="radio3_base" class="incluir_base" value="1">
                            Incluir comisión origen
                        </label>


                        <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                            <input type="radio" name="exonerate" id="radio2_base" class="descontar_base" value="3">
                            Descontar comisión origen
                        </label>

                    </div>






                    {{-- Comision destino --}}




                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Destino</h4>
                    <hr class="bg-dark esconder comi" style="height:1px;">

                    <div class="form-row esconder comi">

                        <div class="form-group col-md-4">

                            <label for="percentage2">Porcentaje Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" name="percentage2" id="percentage2" min="0" class="form-control  rateMasks"></input>
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <label for="commission2">Monto Comisión Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" name="commission2" id="commission2" readonly min="0" class="form-control general"></input>
                            </div>

                        </div>

                        {{-- Monto total Destino --}}

                        <div class="form-group col-md-4">
                            
                            <label for="amount_total2">Monto total Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total2" id="amount_total2" readonly class='form-control general'></input>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-md-12 d-flex justify-content-center">

                        <label class="form-check-label mx-auto esconder comi" for="radio1_base2">
                            <input type="radio" name="exonerate2" id="radio1_base2" class="exonerar_base2" value="2">
                            Exonerar comisión destino
                        </label>

                        <label class="form-check-label mx-auto esconder comi" for="radio3_base2">
                            <input type="radio" name="exonerate2" id="radio3_base2" class="incluir_base2" value="1">  
                            Incluir comisión destino
                        </label>


                        <label class="form-check-label mx-auto esconder comi" for="radio2_base2">
                            <input type="radio" name="exonerate2" id="radio2_base2" class="descontar_base" value="3">
                            Descontar comisión destino
                        </label>

                    </div>
                    <input type="hidden" id="amount_commission_profit"  name="amount_commission_profit"  value="">
                    <input type="hidden" id="amount_commission_profit2" name="amount_commission_profit2" value="">

                    <hr class="bg-dark esconder comi" style="height:1px;">

                    <div class="form-group">
                        
                        <label for="observacion">Observaciones:</label>
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input type="text" name="observacion" id="observacion" class="form-control"></input>
                        </div>
                    </div>

                    <div class="form-group">
                        
                        <label for="description">Descripción origen:</label>
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input id="description" class="form-control" readonly="" required="" value="Entregado a cliente" name="description" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <label for="description2">Descripción destino:</label>
                        <div class="input-group-text">
                                <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input id="description2" class="form-control" readonly="" required="" name="description2" type="text" value="Recibido de cliente"></input>
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

</style>

@endsection

@section('js')

<script>

    $(document).ready(function() {
        cargaData();
    });

    //$("#typetransaccion").val("")
    //$("#typetransaccion").trigger("change");

    $("#type_transaction_id").select2({
        placeholder: "Selecciona tipo transferencia Origen",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    // $("#type_transaction_id").val("")
    // $("#type_transaction_id").trigger("change");
    //
    // transaccion destino
    //
    $("#type_transaction_id2").select2({
        placeholder: "Selecciona tipo transferencia destino",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    // $("#type_transaction_id2").val("")
    // $("#type_transaction_id2").trigger("change");
    //
    //
    //
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

    $('#amount').on('input', function() {
        var dolar = $('#amount').val();
        $('#amount').val(dolar).inputmask({
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
                insertMode:true,
            });

        $('#amount').val(dolar);
    });

  
    $('#entre').on('submit', function() {

        let myDays = {{ $myDays ?? 0}};

        let myDate      = new Date($('#transaction_date').val());
        let myDateNow   = new Date();

        // valida cuantos dias hacia atras se permite cargar una transaccion

        //let myDays;
        //myDays = 4;
        //myDays = 30;
        // myDays = 240;

        // alert("myDays ->" + myDays);

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


        exonerar_base = $('#radio1_base').is(':checked');

        if ($('#amount').val().length == 0) {
            Swal.fire('Monto en dolares, no puede estar vacio');
            return false;
        }

        if ($('#amount').val() <= 0) {
            Swal.fire('Monto en dolares, no puede ser cero o menor a cero. :(');
            return false;
        }

        if(!exonerar_base){
            if ($('#percentage').val() <= 0) {
            Swal.fire('Porcentage origen, no puede ser cero o menor a cero. :(');
            return false;
            }
        }

        let exonerar     = $('#radio1_base').is(':checked');
        let descontar    = $('#radio2_base').is(':checked');
        let incluir      = $('#radio3_base').is(':checked');

        if(!exonerar && !descontar && !incluir){
            Swal.fire('Error: Marcar si comision origen esta exonerada, incluida o descontada');
            return false;            
        }

        let exonerar2     = $('#radio1_base2').is(':checked');
        let descontar2    = $('#radio2_base2').is(':checked');
        let incluir2      = $('#radio3_base2').is(':checked');


        if(!exonerar2 && !descontar2 && !incluir2){
            Swal.fire('Error: Marcar si comision origen esta exonerada, incluida o descontada');
            return false;            
        }

        //  return false; // no envia submit

    });

    //
    // comision origen exonerada
    //
    $('#radio1_base').on('click', function() {
        $('#percentage').val("");
        $('#commission').val("");

        $('#commission').attr("readonly", true);
        $('#percentage').attr("readonly", true);
    });
    //
    // comision origen descontar
    //
    $('#radio2_base').on('click', function() {

        $('#percentage').attr("readonly", false);
    });
    //
    // comision origen Incluir
    //
    $('#radio3_base').on('click', function() {
        $('#percentage').attr("readonly", false);
    });
    //
    //
    //
    //
    // comision destino
    //
    //
    //  Exonerar comision destino
    //
    $('#radio1_base2').on('click', function() {
        $('#percentage2').val("");
        $('#commission2').val("");

        $('#comision_base2').attr("readonly", true);
        $('#percentage2').attr("readonly", true);
    });
    //
    // descontar comision destino
    //
    $('#radio2_base2').on('click', function() {
        $('#percentage2').attr("readonly", false);
    });
    //
    // incluir comision destino
    //
    $('#radio3_base2').on('click', function() {

        $('#percentage2').attr("readonly", false);
    });





    $('#amount, #percentage, #percentage2').on('input', function() {

        updateMontorealBase();

    });

    $('#radio1_base, #radio2_base, #radio3_base, #radio1_base2, #radio2_base2, #radio3_base2').on('click', function() {

        updateMontorealBase();
    });

    $("#type_transaction_id, #group_id").change(function() {

        var type_transaction_id   = $(this).val(); // Capturamos el valor del select
        var type_transaction_name = $("#type_transaction_id option:selected").text(); // Capturamos el texto del option seleccionado

        var group_id   = $('#group_id').val(); // Capturamos el valor del select
        var group_name = $("#group_id option:selected").text(); // Capturamos el texto del option seleccionado

        var group2_id   = $('#group2_id').val(); // Capturamos el valor del select
        var group2_name = $("#group2_id option:selected").text(); // Capturamos el texto del option seleccionado


        //alert(tipo);

        $("#description").val('Entregado a ' + group2_name + '/' + type_trasnsaction_name);

    });


    $("#type_transaction_id2, #group2_id").change(function() {
        
        var type_transaction_id2    = $(this).val(); // Capturamos el valor del select
        var type_transaction_name2  = $("#type_transaction_id2 option:selected").text(); // Capturamos el texto del option seleccionado

        var group_id                = $('#group_id').val(); // Capturamos el valor del select
        var group_name              = $("#group_id option:selected").text(); // Capturamos el texto del option seleccionado

        var group2_id               = $('#group2_id').val(); // Capturamos el valor del select
        var group2_name             = $("#group2_id option:selected").text(); // Capturamos el texto del option seleccionado


        $("#descripcion2").val('Recibido de cliente ' + group2_name + "/" + type_transaction_name2);

    });

    function updateMontorealBase() {

        let amount             = $('#amount').val() == ""         ? 0 : parseFloat($('#amount').val());        

        let commission         = $('#commission').val() == ""     ? 0 : parseFloat($('#commission').val());
        let percentage         = $('#percentage').val() == ""     ? 0 : parseFloat($('#percentage').val());

        let exonerar           = $('#radio1_base').is(':checked');
        let descontar          = $('#radio2_base').is(':checked');
        let incluir            = $('#radio3_base').is(':checked');

        let commission2        = $('#commission2').val() == ""     ? 0 : parseFloat($('#commission2').val());
        let percentage2        = $('#percentage2').val() == ""     ? 0 : parseFloat($('#percentage2').val());

        let exonerar2          = $('#radio1_base2').is(':checked');
        let descontar2         = $('#radio2_base2').is(':checked');
        let incluir2           = $('#radio3_base2').is(':checked');


        let amount_commission_profit    = 0;
        let amount_commission_profit2   = 0;
        let amount_total  = 0;
        let amount_total2 = 0;

        if(percentage > 0){
            commission = (amount * (percentage / 100));
            $('#commission').val(commission);
        }

        if (commission == 0) {
            amount_commission_profit = 0;
        }else{
            amount_commission_profit = commission;
        }

        // calcula el total

        if(!exonerar) {
            if(incluir) {
                amount_total = (amount + commission).toFixed(2);
                $('#amount_total').val(amount_total);
                //alert(montoreal);
            } else if(descontar) {
                amount_total = (amount - commission).toFixed(2);
                $('#amount_total').val(amount_total);
            }
        }
        else {
            $('#percentage').val('');
            $('#commission').val('');
            amount_total = amount.toFixed(2);
            $('#amount_total').val(amount_total);
        }



        // comision destino



        if(percentage2 > 0){
            commission2 = (amount * (percentage2 / 100));
            $('#commission2').val(commission2);
            //alert(comision);
        }

        if (commission2 == 0) {
            amount_commission_profit2 = 0;
        }else{
            amount_commission_profit2 = commission2;
        }



        if(!exonerar2) {
            if(incluir2) {
                amount_total2 = (amount + commission2).toFixed(2);
                $('#amount_total2').val(amount_total2);
                //alert(montoreal);
            } else if(descontar2) {
                amount_total2 = (amount - commission2).toFixed(2);
                $('#amount_total2').val(amount_total2);
            }
        }
        else {
            $('#percentage2').val('');
            $('#commission2').val('');
            amount_total2 = amount.toFixed(2);
            $('#amount_total2').val(amount_total2);
        }

 

        // comision destino



        $('#amount_commission_profit').val(amount_commission_profit);
        $('#amount_commission_profit2').val(amount_commission_profit2);

    }


    function cargaData(){
        // console.log({{number_format($transactionOrigen->Amount,2)}});
        
        $('#amount').val( {{ number_format($transactionOrigen->Amount,2,",",".")  }});
        $('#transactoin_date').val('{{$fecha}}');

        //
        // Origen
        //

        $('#percentage').val({{$transactionOrigen->Porcentage}});
        $('#commission').val({{$transactionOrigen->AmountCommission}});
        $('#amount_total').val({{$transactionOrigen->AmountTotal}});

        myExonerate = {{$transactionOrigen->Exonerate}};
        $('#radio1_base').prop('checked',  false);
        $('#radio2_base').prop('checked',  false);
        $('#radio3_base').prop('checked',  false);

        switch (myExonerate){
            case 2:
                $('#radio1_base').prop('checked',  true);
                break;
            case 3:
                $('#radio2_base').prop('checked',  true);
                break;
            case 1:
                $('#radio3_base').prop('checked',  true);
                break;
        };

        //
        // Destino
        //

        $('#percentage2').val({{$transactionDestino->Porcentage}});
        $('#commission2').val({{$transactionDestino->AmountCommission}});
        $('#amount_total2').val({{$transactionDestino->AmountTotal}});

        myExonerate2 = {{$transactionDestino->Exonerate}};
        $('#radio1_base2').prop('checked',  false);
        $('#radio2_base2').prop('checked',  false);
        $('#radio3_base2').prop('checked',  false);

        switch (myExonerate2){
            case 2:
                $('#radio1_base2').prop('checked',  true);
                break;
            case 3:
                $('#radio2_base2').prop('checked',  true);
                break;
            case 1:
                $('#radio3_base2').prop('checked',  true);
                break;
        };

        $('#observacion').val('');

        $('#description').val('{{$transactionOrigen->Description}}');

        $('#description2').val('{{$transactionDestino->Description}}');


        let type_transaction_id     = '{{$transactionOrigen->TypeTransactionId}}';
        let type_transaction_id2    = '{{$transactionDestino->TypeTransactionId}}';

        let group_id                = '{{$transactionOrigen->GroupIdOrigen}}';
        let group2_id               = '{{$transactionDestino->GroupIdOrigen}}';

        


        BuscaElemento('group_id', group_id);
        BuscaElemento('group2_id', group2_id);
        BuscaElemento('type_transaction_id', type_transaction_id);
        BuscaElemento('type_transaction_id2', type_transaction_id2);


    }


    function BuscaElemento(myControl, myElement){
        console.log('llega ->' + myControl + ' con el elemento -> ' + myElement);
        let mySelect = myControl;
        let myValue  = myElement;

        $('#' + mySelect).each( function(index, element){
            $(this).children("option").each(function(){

                console.log ("Busca-> " + myValue + ' con ' + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));

                // alert();
                if ($(this).val() === myValue.toString()){
                    console.log('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }


</script>



@endsection

