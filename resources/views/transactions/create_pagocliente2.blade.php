@extends('adminlte::page')



@section('title', 'Pagos entre clientes')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Pagos entre clientes') }} <i class="fas fa-donate"></i> </h1></a>


@stop

@php
    $myDays = config('transactions.transaction_days',30);
@endphp

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-8" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
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
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form-row">                
                        <div class="form-group col-xl-6">
                            <label for="typetrasnferencia2Debit">Tipo de Movimiento Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('type_transaction_id',$type_transaction_debit, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia2Debit', 'readonly' => false]) !!}
                            </div>

                        </div>      
                        <div class="form-group col-xl-6">
                            
                            <label for="typetrasnferencia2Credit">Tipo de Movimiento Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('type_transaction_id2',$type_transaction_credit, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia2Credit', 'readonly' => false]) !!}
                            </div>
                        </div>                        
                    </div>  

                    <div class="form-row">

                        <div class="form-group col-xl-6">
                            
                            <label for="group_id">Cliente de origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('group_id', $group, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-6">
                            
                            <label for="group2_id">Cliente destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('group2_id', $group, null, ['class' => 'form-control wallet2', 'required' => true, 'id'=>'wallet2', 'readonly' => false]) !!}
                            </div>
                        </div>

                    </div>

                    @foreach($wallet as $wallet2)
                        {!! Form::hidden('wallet_id', $wallet2, null, ['class' => 'form-control transaccion']) !!}
                        {!! Form::hidden('wallet2_id', $wallet2, null, ['class' => 'form-control transaccion']) !!}

                        
                    @endforeach

                    <div class="form-row">
                        <div class="form-group col-xl-6">
                            <label for="type_coin_id">Tipo de moneda:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                <select id="type_coin_id" name="type_coin_id" class='form-control' required>
                                    @foreach($type_coin as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>     

                        <div class="form-group col-xl-6">
                            <label for="amount">Monto:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                                <input class="form-control general" required id="amount_foreign_currency" name="amount_foreign_currency" type="text" inputmode="decimal">
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-xl-6">
                            <label for="transaction_date">Fecha:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                                <input class="form-control" required id="fecha" name="transaction_date" type="datetime-local" value="{{ $fecha }}">
                            </div>
                        </div>                        
                    </div>

                    
                    <input type="hidden" name="amount_total_2" id="montototal2"  >
                    <input type="hidden" name="status"         value="Activo">

                    {{-- Comision Origen --}}

                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Origen  </h4>

                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-4 mb-2 d-flex">
                            
                            <label class="form-check-label mt-4 esconder comi" for="radioComision1">
                                <input type="radio" name="tipoComision" id="radioComision1" class="exonerar_base2" value="1">
                                Porcentaje
                            </label>
                            
                            <div class="input-group-text ml-2 mt-2 col-6 d-flex" style="height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="percentage_base" name="percentage" class="form-control percentage rateMasks" min="0">
                            </div>                        

                        </div>
                        
                        <div class="form-group col-xl-4  mt-2">
                            <label for="comision_base">Monto Comisión Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="comision_base" name="commission" class="form-control comision_base general" min="0" readonly> </input>
                            </div>
                        </div>  
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-2 d-flex">
                        </div>
                        <div class="form-group col-xl-4">
                            <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio1_base">
                                        <input type="radio" name="exonerate" id="radio1_base" class="exonerar_base" value="2">                                
                                        Exonerar comisión origen
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                                        <input type="radio" name="exonerate" id="radio3_base" class="incluir_base" value="1">
                                        Incluir comisión origen
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                                        <input type="radio" name="exonerate" id="radio2_base" class="descontar_base" value="3">
                                        Descontar comisión origen
                                    </label>
                                </div>
                            </div>    
                        </div>                    
                    </div>

                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-2 d-flex">
                            
                            <label class="form-check-label mt2" for="radioComision2">
                                <input type="radio" name="tipoComision" id="radioComision2" class="incluir_base2" value="2">  
                                Tasa
                            </label>
                            
                            <div class="input-group-text col-6" style="margin-left: 3.5rem !important; height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="exchange" name="exchange" class="form-control percentage rateMasks" min="0">
                            </div>    

                        </div>
                        <div class="form-group col-xl-4  mt-2">
                            <label for="comision_base">Monto:</label>
                            <div class="input-group-text" >
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="monto_dolares" name="amount" class="form-control comision_base general" min="0" readonly> </input>
                            </div>
                        </div>                          
                    </div>
                    <div class="form-row esconder comi mt-4">

                        <div class="form-group col-xl-7">

                        </div>
                        <div class="form-group col-xl-4 ">
                            {{-- Monto total Origen --}}
                            <label for="montototal">Monto total Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total" id="monto_base" class="form-control general" readonly></input>
                            </div>
                        </div>

                    </div>
                    


                    {{-- Comision destino --}}



                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Destino</h4>
                    <hr class="bg-dark esconder comi" style="height:1px;">


                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-4 mb-2 d-flex">
                            
                            <label class="form-check-label mt-4 esconder comi" for="radioComisionDestino1">
                                <input type="radio" name="tipoComisionDestino" id="radioComisionDestino1" class="exonerar_base2" value="1">
                                Porcentaje
                            </label>
                            
                            <div class="input-group-text ml-2 mt-2 col-6 d-flex" style="height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="percentage_base2" name="percentage2" class="form-control percentage rateMasks" min="0">
                            </div>                        

                        </div>
                        
                        <div class="form-group col-xl-4  mt-2">
                            <label for="comision_base">Monto Comisión Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="comision_base2" name="commission2" class="form-control comision_base general" min="0" readonly> </input>
                            </div>


                        </div>  
                    </div>   

                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-2 d-flex">
                        </div>
                        <div class="form-group col-xl-4">
                            <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio1_base2">
                                        <input type="radio" name="exonerate2" id="radio1_base2" class="exonerar_base" value="2">                                
                                        Exonerar comisión origen
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio3_base2">
                                        <input type="radio" name="exonerate2" id="radio3_base2" class="incluir_base" value="1">
                                        Incluir comisión origen
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio2_base2">
                                        <input type="radio" name="exonerate2" id="radio2_base2" class="descontar_base" value="3">
                                        Descontar comisión origen
                                    </label>
                                </div>
                            </div>    
                        </div>                    
                    </div>


                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-2 d-flex">
                            
                            <label class="form-check-label mt2" for="radioComisionDestino2">
                                <input type="radio" name="tipoComisionDestino" id="radioComisionDestino2" class="incluir_base2" value="2">  
                                Tasa
                            </label>
                            
                            <div class="input-group-text col-6" style="margin-left: 3.5rem !important; height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="exchange2" name="exchange2" class="form-control percentage rateMasks" min="0">
                            </div>    

                        </div>
                        <div class="form-group col-xl-4  mt-2">
                            <label for="comision_base">Monto:</label>
                            <div class="input-group-text" >
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="monto_dolares2" name="amount2" class="form-control comision_base general" min="0" readonly> </input>
                            </div>
                        </div>                          
                    </div>
                    <div class="form-row esconder comi">

                        <div class="form-group col-xl-7">

                        </div>

                        {{-- Monto total Destino --}}

                        <div class="form-group col-xl-4">
                            <label for="monto_base2">Monto total Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total2" id="monto_base2" readonly class='form-control general'></input>
                            </div>
                        </div>

                    </div>

                    {{--
                    <div class="form-row  form-group ">
                        <div class="col-xl-4 mt-2">
                            <label class="form-check-label mx-auto esconder comi" for="radio1_base2">
                                <input type="radio" name="exonerate2" id="radio1_base2" class="exonerar_base2" value="2">                                
                                Exonerar comisión destino
                            </label>
                        </div>
                        <div class="col-xl-4 mt-2">
                            <label class="form-check-label mx-auto esconder comi" for="radio3_base2">
                                <input type="radio" name="exonerate2" id="radio3_base2" class="incluir_base2" value="1">  
                                Incluir comisión destino
                            </label>
                        </div>
                        <div class="col-xl-4 mt-2">
                            <label class="form-check-label mx-auto esconder comi" for="radio2_base2">
                                <input type="radio" name="exonerate2" id="radio2_base2" class="descontar_base" value="3">
                                Descontar comisión destino
                            </label>
                        </div>
                    </div>
                    --}}

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
                        
                        <label for="descripcion">Descripción origen:</label>
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input id="descripcion" class="form-control" readonly="" required="" value="Entregado a cliente" name="description" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <label for="descripcion2">Descripción destino:</label>
                        <div class="input-group-text">
                                <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input id="descripcion2" class="form-control" readonly="" required="" name="description2" type="text" value="Recibido de cliente"></input>
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

    inicializa();

    $(".typecoin").select2({
        placeholder: "Seleccionar Moneda",
        theme: 'bootstrap4',
        allowClear: true,
        width:'100%'
    });

    $("#typecoin").val("")
    $("#typecoin").trigger("change");

    $("#typetransaccion").select2({
        placeholder: "Selecciona tipo transferencia",
        theme: 'bootstrap4',
        search: false,
        width: '100%'
    })
    .on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
    });

  //$("#typetransaccion").val("")
  //$("#typetransaccion").trigger("change");


    $("#typetrasnferencia2Debit").select2({
        placeholder: "Transferencia Origen",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $("#typetrasnferencia2Debit").val("")
    $("#typetrasnferencia2Debit").trigger("change");

    $("#typetrasnferencia2Credit").select2({
        placeholder: "Transferencia Destino",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $("#typetrasnferencia2Credit").val("")
    $("#typetrasnferencia2Credit").trigger("change");


    $("#type_coin_id").select2({
        placeholder: "Moneda",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $("#type_coin_id").val("")
    $("#type_coin_id").trigger("change");


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

    $('#amount_foreign_currency').on('input', function() {
        var dolar = $('#amount_foreign_currency').val();
        $('#montototal').val(dolar).inputmask({
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

        $('#monto_base').val(dolar);
        $('#monto_dolares').val(dolar);
    });

  
    $('#wallet').select2({
        'theme':'bootstrap4',
        search: false,
        allowClear: true,
        placeholder: "Seleccionar cliente",
        width:'100%'
    })
    .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        })    
    ;
    $("#wallet").val("")
    $("#wallet").trigger("change");

    $('#wallet2').select2({
        'theme':'bootstrap4',
        search: false,
        allowClear: true,
        placeholder: "Seleccionar cliente",
        width:'100%'
    })
    .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        })    
    ;
    $("#wallet2").val("")
    $("#wallet2").trigger("change");


    $('#entre').on('submit', function() {

        let myDays = {{ $myDays ?? 0}};

        let myDate      = new Date($('#fecha').val());
        let myDateNow   = new Date();

        // valida cuantos dias hacia atras se permite cargar una transaccion

        //let myDays;
        //myDays = 4;
        //myDays = 30;
        // myDays = 240;

        // alert("myDays ->" + myDays);
        // alert($('#amount_foreign_currency').val());
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


        var val1 = $('#wallet').val();
        var val2 = $('#wallet2').val();

        exonerar_base = $('#radio1_base').is(':checked');

        if (val1 == val2) {
            Swal.fire('Las cajas no pueden ser iguales')
            return false; //prevent form submission
        }

        if ($('#monto_dolares').val().length == 0) {
            Swal.fire('Monto en dolares, no puede estar vacio');
            return false;
        }

        if ($('#monto_dolares').val() <= 0) {
            Swal.fire('Monto, no puede ser cero o menor a cero. :(');
            return false;
        }

        let radioComision1 = $('#radioComision1').is(':checked');
        let radioComision2 = $('#radioComision2').is(':checked');

        let radioComisionDestino1 = $('#radioComisionDestino1').is(':checked');
        let radioComisionDestino2 = $('#radioComisionDestino2').is(':checked');

        //
        // Valida 
        //   Porcentaje se permita solo a dolares
        //   Tasa solo se permita si no es dolares
        //
        let type_coin_id = $('#type_coin_id').val() == "" ? 0 : $('#type_coin_id').val();

        if (type_coin_id == 0){
            Swal.fire('Debe seleccionar el tipo de moneda');
            return false; 
        }

        if (radioComision1) {
            if (type_coin_id != 1){
                Swal.fire('Porcentage origen solo se permite sobre transacciones en dolares');
                return false;                
            }
        }
        if (radioComision2) {
            
            if (type_coin_id == 1){
                
                Swal.fire('Tasa origen solo se permite sobre transacciones que no sean dolares');
                return false;                
            }
        }

        if (radioComisionDestino1) {
            if (type_coin_id != 1){
                Swal.fire('Porcentage Destino solo se permite sobre transacciones en dolares');
                return false;                
            }
        }
        if (radioComisionDestino2) {
            
            if (type_coin_id == 1){
                
                Swal.fire('Tasa Destino solo se permite sobre transacciones que no sean en dolares');
                return false;                
            }
        }

        if (type_coin_id != 1){
            if(!radioComision2){
                Swal.fire('Debe Introducir Tasa origen  para transacciones en moneda que no sean en dolares');
                return false;
            }
 
            let exchange = $('#exchange').val() == "" ? 0 : $('#exchange').val();
            if(exchange == 0){
                Swal.fire('La Tasa origen no puedo ser cero o vacia para transacciones que no sean en dolares');
                return false;
            }

            if(!radioComisionDestino2){
                Swal.fire('Debe Introducir Tasa Destino  para transacciones en moneda que no sean en dolares');
                return false;
            }


            let exchange2 = $('#exchange2').val() == "" ? 0 : $('#exchange2').val();
            if(exchange2 == 0){
                Swal.fire('La Tasa Destino  no puedo ser cero o vacia para transacciones que no sean en dolares');
                return false;
            }
        }


        if (radioComision1) {

            let exonerar_base     = $('#radio1_base').is(':checked');
            let descontar_base    = $('#radio2_base').is(':checked');
            let incluir_base      = $('#radio3_base').is(':checked');

            if(!exonerar_base){
                if ($('#percentage_base').val() <= 0) {
                    Swal.fire('Porcentage origen, no puede ser cero o menor a cero. :(');
                    return false;
                }
            }

            if(!exonerar_base && !descontar_base && !incluir_base){
                Swal.fire('Error: Marcar si comision origen esta exonerada, incluida o descontada');
                return false;            
            }

        }
        if (radioComision2){
            
            if ($('#exchange').val() <= 0) {
                Swal.fire('Tasa de cambio origen, no puede ser cero o menor a cero.');
                return false;
            }
            
        }


        if (radioComisionDestino1){

            if ($('#percentage_base2').val() <= 0) {
                Swal.fire('Porcentage destino, no puede ser cero o menor a cero. :(');
                return false;
            }

            let exonerar_base2     = $('#radio1_base2').is(':checked');
            let descontar_base2    = $('#radio2_base2').is(':checked');
            let incluir_base2      = $('#radio3_base2').is(':checked');


            if(!exonerar_base2 && !descontar_base2 && !incluir_base2){
                Swal.fire('Error: Marcar si comision origen esta exonerada, incluida o descontada');
                return false;            
            }
        }
        if (radioComisionDestino2){
            if ($('#exchange2').val() <= 0) {
                Swal.fire('Tasa de cambio destino, no puede ser cero o menor a cero.');
                return false;
            }            
        }
         // return false; // no envia submit

    });

    //
    $('#radioComision1').on('click', function() {
        $('#exchange').val('');
        $('#exchange').attr('readonly',true);

        $('#percentage_base').attr('readonly',false);
        $('#radio1_base').attr('readonly',false);
        $('#radio2_base').attr('readonly',false);
        $('#radio3_base').attr('readonly',false);

        $('#comision_base').val('');

        $('#monto_dolares').val($('#amount_foreign_currency').val());
        $('#monto_base').val($('#amount_foreign_currency').val());
    }
    );

    $('#radioComision2').on('click', function() {
        $('#percentage_base').val('');
        $('#percentage_base').attr('readonly',true);

        $('#comision_base').val('');

        $('#radioComision1').prop('checked',false);
        $('#radio1_base').prop('checked',false);
        $('#radio2_base').prop('checked',false);
        $('#radio3_base').prop('checked',false);


        $('#radio1_base').attr('readonly',true);
        $('#radio2_base').attr('readonly',true);
        $('#radio3_base').attr('readonly',true);

        $('#exchange').attr('readonly',false);

        $('#monto_dolares').val($('#amount_foreign_currency').val());
        $('#monto_base').val($('#amount_foreign_currency').val());

    }
    );
    //
    //
    //
    $('#radioComisionDestino1').on('click', function() {
        $('#exchange2').val('');
        $('#exchange2').attr('readonly',true);

        $('#percentage_base2').attr('readonly',false);
        $('#radio1_base2').attr('readonly',false);
        $('#radio2_base2').attr('readonly',false);
        $('#radio3_base2').attr('readonly',false);

        $('#comision_base2').val('');

        $('#monto_dolares2').val($('#amount_foreign_currency').val());
        $('#monto_base2').val($('#amount_foreign_currency').val());
    }
    );

    $('#radioComisionDestino2').on('click', function() {
        $('#percentage_base2').val('');
        $('#percentage_base2').attr('readonly',true);

        $('#comision_base2').val('');
        $('#radioComisionDestino1').prop('checked',false);

        $('#radio1_base2').prop('checked',false);
        $('#radio2_base2').prop('checked',false);
        $('#radio3_base2').prop('checked',false);


        $('#radio1_base2').attr('readonly',true);
        $('#radio2_base2').attr('readonly',true);
        $('#radio3_base2').attr('readonly',true);

        $('#exchange2').attr('readonly',false);

        $('#monto_dolares2').val($('#amount_foreign_currency').val());
        $('#monto_base2').val($('#amount_foreign_currency').val());
        
    }
    );


    //
    //
    //
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
    //
    //
    //
    $('#radio1_base2').on('click', function() {
        $('#percentage_base2').val("");
        $('#comision_base2').val("");
        $('#comision_base2').attr("readonly", true);
        $('#percentage_base2').attr("readonly", true);
    });

    $('#radio2_base2').on('click', function() {

        $('#percentage_base2').attr("readonly", false);
    });

    $('#radio3_base2').on('click', function() {

        $('#percentage_base2').attr("readonly", false);
    });
    //
    //
    /* OCULTAR LA CAJA SELECCIONADA */
    //
    //
    // tasa            = document.getElementById("tasa");
    // monto           = document.getElementById("monto");
    // monto_dolares   = document.getElementById("monto_dolares");
    //const log = document.getElementById("montototal");

    $('#amount_foreign_currency, monto_dolares, #exchange, #exchange2, #percentage_base, #percentage_base2').on('input', function() {

        
        updateMontorealBase();



    });

    $('#radio1_base, #radio2_base, #radio3_base, #radio1_base2, #radio2_base2, #radio3_base2').on('click', function() {

        updateMontorealBase();
    });

    $("#type_coin_id").change(function() {
        if ($('#type_coin_id').val() == 1){
            // $('#amount_foreign_currency').val($('#monto_dolares').val());
        }
        actualizaTypeCoin();   
    });

    $("#wallet2, #typetrasnferencia2Debit").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $("#wallet2 option:selected").text(); // Capturamos el texto del option seleccionado

        var texto2 = $("#typetrasnferencia2Debit option:selected").text(); //Capturamos el texto del option tipo transacción seleccionado

        //alert(tipo);

        $("#descripcion").val('Entregado a ' + texto + '/' + texto2);

    });


    $("#typetransaccion").on("change", function() {
        // Capturar dato seleccionado
        var selectedValue = this.value;
        var option = $("#typetransaccion option:selected").text();
        // Realizar la acción deseada en función del valor seleccionado
        if (option == 'Pago Efectivo')
        {
            $('#typetransaccion2').val(10);
            //$('#typetransaccion2 option[value="8"]').attr('disabled', 'true');
        }
        else
        {
            $('#typetransaccion2').val(8);
        }
    });


    $("#wallet, #typetrasnferencia2Credit").change(function() {
        
        
        var texto = $("#wallet").find('option:selected').text(); // Capturamos el texto del option seleccionado
        var texto2 = $("#typetrasnferencia2Credit option:selected").text();

        $("#descripcion2").val('Recibido de cliente ' + texto + "/" + texto2);
    });

    function updateMontorealBase() {
        
        let monto_dolares           = 0;
        let monto_dolares2          = 0;

        let monto_base              = 0;
        let monto_base2             = 0;

        let amount_foreign_currency = 0;
        let type_coin_id = $('#type_coin_id').val() == "" ? 0 : $('#type_coin_id').val();

        amount_foreign_currency = $('#amount_foreign_currency').val() == "" ? 0 : parseFloat($('#amount_foreign_currency').val());

        monto_dolares           = parseFloat($('#amount_foreign_currency').val());
        monto_base              = parseFloat($('#amount_foreign_currency').val());

        monto_dolares2          = parseFloat($('#amount_foreign_currency').val());
        monto_base2             = parseFloat($('#amount_foreign_currency').val());
        

        $('#monto_dolares').val(amount_foreign_currency);
        $('#monto_dolares2').val(amount_foreign_currency);
        
        $('#monto_base').val(amount_foreign_currency);
        $('#monto_base2').val(amount_foreign_currency);

        let comision_base     = $('#comision_base').val() == ""     ? 0 : parseFloat($('#comision_base').val());
        let porcentage_base   = $('#percentage_base').val() == ""   ? 0 : parseFloat($('#percentage_base').val());
        

        let exonerar_base     = $('#radio1_base').is(':checked');
        let descontar_base    = $('#radio2_base').is(':checked');
        let incluir_base      = $('#radio3_base').is(':checked');

        let comision_base2     = $('#comision_base2').val() == ""     ? 0 : parseFloat($('#comision_base2').val());
        let porcentage_base2   = $('#percentage_base2').val() == ""   ? 0 : parseFloat($('#percentage_base2').val());
        

        let exonerar_base2     = $('#radio1_base2').is(':checked');
        let descontar_base2    = $('#radio2_base2').is(':checked');
        let incluir_base2      = $('#radio3_base2').is(':checked');


        
        let amount_commission_profit    = 0;
        let amount_commission_profit2   = 0;

        let radioComision1 = $('#radioComision1').is(':checked');
        let radioComision2 = $('#radioComision2').is(':checked');
        let myTypeComision = 0;

        let exchange = $('#exchange').val() == "" ? 0 : parseFloat($('#exchange').val());
        let exchange2 = $('#exchange2').val() == "" ? 0 : parseFloat($('#exchange2').val());

        if (radioComision1){
            myTypeComision = 1;
        }else if(radioComision2){
            myTypeComision = 2;
        }


        $('#monto_dolares').val(monto_dolares );
        $('#monto_dolares2').val(monto_dolares );
        
        $('#monto_base').val(monto_dolares );
        $('#monto_base2').val(monto_dolares );

        if(porcentage_base > 0){
            
            $('#comision_base').val((monto_dolares * (porcentage_base / 100)));
            comision_base = (monto_dolares * (porcentage_base / 100));
            // alert(comision);
        }


        if (comision_base == 0) {
            amount_commission_profit = 0;
        }else{
            amount_commission_profit = comision_base;
        }



        if(!exonerar_base) {
            if(incluir_base) {
                monto_base = (monto_dolares + comision_base);
                $('#monto_dolares').val((monto_base));
                $('#monto_base').val((monto_base));
                
            } else if(descontar_base) {
                monto_base = (monto_dolares - comision_base);
                $('#monto_base').val((monto_base));
                $('#monto_dolares').val((monto_base));
            }
        }
        else {
            $('#percentage_base').val('');
            $('#comision_base').val('');
            monto_base = monto_dolares;
            $('#monto_base').val(monto_base);
            $('#monto_dolares').val(monto_base);
        }

        if(exchange > 0){
            monto_dolares = amount_foreign_currency / exchange;

            $('#monto_dolares').val(monto_dolares);
            $('#monto_base').val(monto_dolares);
        }


        // comision destino



        if(porcentage_base2 > 0){
            $('#comision_base2').val((monto_dolares * (porcentage_base2 / 100)));
            comision_base2 = (monto_dolares * (porcentage_base2 / 100));
            //alert(comision);
        }

        if (comision_base2 == 0) {
            amount_commission_profit2 = 0;
        }else{
            amount_commission_profit2 = comision_base2;
        }



        if(!exonerar_base2) {
            if(incluir_base2) {
                monto_base2 = (monto_dolares + comision_base2).toFixed(2);
                $('#monto_dolares2').val(monto_base2);
                $('#monto_base2').val(monto_base2);
                //alert(montoreal);
            } else if(descontar_base2) {
                monto_base2 = (monto_dolares - comision_base2).toFixed(2);
                $('#monto_base2').val((monto_dolares - comision_base2));
                $('#monto_dolares2').val((monto_dolares - comision_base2));
            }
        }
        else {
            $('#percentage_base2').val('');
            $('#comision_base2').val('');
            monto_base2 = monto_dolares.toFixed(2);
            $('#monto_base2').val(monto_dolares);
            $('#monto_dolares2').val(monto_dolares);
        }



        if(exchange2 > 0){
            
            monto_base2 = amount_foreign_currency / exchange2;
            $('#monto_base2').val(monto_base2);
            $('#monto_dolares2').val(monto_base2);
            
        }

        // comision destino



        $('#amount_commission_profit').val(amount_commission_profit);
        $('#amount_commission_profit2').val(amount_commission_profit2);

    }

    function inicializa() {
        $('#radioComision1').prop('checked',false);
        $('#percentage_base').val('');
        $('#percentage_base').attr('readonly', true);
        $('#comision_base').val('');
        $('#radio1_base').prop('checked',false);
        $('#radio2_base').prop('checked',false);
        $('#radio3_base').prop('checked',false);

        $('#radioComision2').prop('checked',false);
        $('#echange').val('');
        $('#exchange').attr('readonly', true);

        $('#radioComisionDestino1').prop('checked',false);
        $('#percentage_base2').val('');
        $('#percentage_base2').attr('readonly', true);
        $('#comision_base2').val('');
        $('#radio1_base2').prop('checked',false);
        $('#radio2_base2').prop('checked',false);
        $('#radio3_base2').prop('checked',false);

        $('#radioComisionDestino2').prop('checked',false);
        $('#echange2').val('');
        $('#exchange2').attr('readonly', true);      
        
        actualizaTypeCoin();

    }


    function actualizaTypeCoin(){
        
        let type_coin_id = $('#type_coin_id').val() == "" ? 0 : $('#type_coin_id').val();

        if (type_coin_id == 0){
            $('#radioComision1').prop('checked',false);
            // $('#radioComision1').attr('readonly', true);
            $('#radioComision1').prop('disabled', 'disabled');

            $('#percentage_base').val('');
            $('#comision_base').val('');

            $('#radio1_base').prop('checked',false);
            $('#radio2_base').prop('checked',false);
            $('#radio3_base').prop('checked',false);
            
            $('#radio1_base').prop('readonly',true);
            $('#radio2_base').prop('readonly',true);
            $('#radio3_base').prop('readonly',true);


            $('#radioComision2').prop('checked',false);
            $('#radioComision2').attr('readonly', true);

            $('#echange').val('');
            $('#exchange').attr('readonly', true);

            //
            //
            //

            $('#radioComisionDestino1').prop('checked',false);
            $('#radioComisionDestino1').prop('readonly',true);

            $('#percentage_base2').val('');
            $('#comision_base2').val('');

            $('#radio1_base2').prop('checked',false);
            $('#radio2_base2').prop('checked',false);
            $('#radio3_base2').prop('checked',false);

            $('#radio1_base2').prop('readonly',true);
            $('#radio2_base2').prop('readonly',true);
            $('#radio3_base2').prop('readonly',true);


            $('#radioComisionDestino2').prop('checked',false);
            $('#radioComisionDestino2').prop('readonly',true);

            $('#echange2').val('');
            $('#exchange2').attr('readonly', true);  

            return;
        }

        if (type_coin_id = 1){
            $('#radioComision1').prop('checked',false);
            $('#radioComision1').attr('readonly', false);

            $('#percentage_base').val('');
            $('#comision_base').val('');

            $('#radio1_base').prop('checked',false);
            $('#radio2_base').prop('checked',false);
            $('#radio3_base').prop('checked',false);

            $('#radioComision2').prop('checked',false);
            $('#radioComision2').attr('readonly', true);

            $('#echange').val('');
            $('#exchange').attr('readonly', true);

            //
            //
            //

            $('#radioComisionDestino1').prop('checked',false);
            $('#radioComisionDestino1').prop('readonly',false);

            $('#percentage_base2').val('');
            $('#comision_base2').val('');

            $('#radio1_base2').prop('checked',false);
            $('#radio2_base2').prop('checked',false);
            $('#radio3_base2').prop('checked',false);

            $('#radioComisionDestino2').prop('checked',false);
            $('#radioComisionDestino2').prop('readonly',true);

            $('#echange2').val('');
            $('#exchange2').attr('readonly', true);        
        }else{
            $('#radioComision1').prop('checked',false);
            $('#radioComision1').attr('readonly', true);

            $('#percentage_base').val('');
            $('#comision_base').val('');

            $('#radio1_base').prop('checked',false);
            $('#radio2_base').prop('checked',false);
            $('#radio3_base').prop('checked',false);

            $('#radioComision2').prop('checked',false);
            $('#radioComision2').attr('readonly', false);

            $('#echange').val('');
            $('#exchange').attr('readonly', true);

            //
            //
            //

            $('#radioComisionDestino1').prop('checked',false);
            $('#radioComisionDestino1').prop('readonly',true);

            $('#percentage_base2').val('');
            $('#comision_base2').val('');

            $('#radio1_base2').prop('checked',false);
            $('#radio2_base2').prop('checked',false);
            $('#radio3_base2').prop('checked',false);
            
            $('#radio1_base2').prop('readonly',true);
            $('#radio2_base2').prop('readonly',true);
            $('#radio3_base2').prop('readonly',true);

            $('#radioComisionDestino2').prop('checked',false);
            $('#radioComisionDestino2').prop('readonly',false);

            $('#echange2').val('');
            $('#exchange2').attr('readonly', false);          
        }

    }

</script>



@endsection

