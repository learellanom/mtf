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
    <div class="card col-md-8" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
        <div class="card-body">

            {!! Form::open(['route' => 'PagoClientes.update', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre', 'method' => 'PUT']) !!}



            <div class="form-row">                  
                <div class="form-group col-md-12">
                    
                    
                    <label for="nroTransferencia">Nro Transferencia:</label>
                    <div class="input-group-text"  >
                        <label id="nroTransferencia" name="nroTransferencia" style="border-color: #007bff">{{ $nroTransferencia }}</label>
                        <input type="hidden" id="nroTransferencia" name="nroTransferencia" readonly value="{{ $nroTransferencia }}">
                    </div>
                </div>      
                     
            </div>  

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form-row">                
                        <div class="form-group col-xl-6">
                            <label for="type_transaction_id">Tipo de Movimiento Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                <select id="type_transaction_id" name="type_transaction_id" class='form-control' required>
                                    @foreach($type_transaction_debit as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>      
                        <div class="form-group col-xl-6">
                            
                            <label for="type_transaction_id2">Tipo de Movimiento Destino:</label>
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('type_transaction_id2',$type_transaction_credit, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'type_transaction_id2', 'readonly' => false]) !!}
                            </div>
                        </div>                        
                    </div>  

                    <div class="form-row">

                        <div class="form-group col-xl-6">
                            
                            <label for="group_id">Cliente de origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::select('group_id', $group, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'group_id', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-6">
                            
                            <label for="group2_id">Cliente destino:</label>
                            <div class="input-group-text">
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
                                <input class="form-control general" name="amount_foreign_currency" required id="amount_foreign_currency" type="text" inputmode="decimal">
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-xl-6">
                            <label for="transaction_date">Fecha:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                                <input class="form-control"  id="transaction_date" name="transaction_date" type="datetime-local" >
                            </div>
                        </div>                        
                    </div>
                    {{-- Comision Origen --}}


                    <hr class="bg-dark esconder comi" style="height:1px;">
                    <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Origen  </h4>
                    <div class="form-row esconder comi">

                        <div class="col-12 col-xl-7 mt-4 mb-2 d-flex">

                            <label class="form-check-label mt-4 esconder comi" for="radioComision1">
                                <input type="radio" name="tipoComision" id="radioComision1" class="exonerar_base2" value="1">
                                Porcentaje
                            </label>
                            
                            <div class="input-group-text ml-2 mt-2 col-6 d-flex" style="height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="percentage" name="percentage" class="form-control percentage rateMasks" min="0">
                            </div>   



                        </div>

                        <div class="form-group col-xl-4">
                            <label for="commission">Monto Comisión Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text"  name="commission" id="commission" class="form-control comision_base general" min="0" readonly> </input>
                            </div>

                        </div>



                    </div>

                    <div class="form-row form-group">
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
                            <label for="amount">Monto:</label>
                            <div class="input-group-text" >
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="amount" name="amount" class="form-control comision_base general" min="0" readonly> </input>
                            </div>
                        </div>                          
                    </div>

                    <div class="form-row esconder comi mt-4">

                        <div class="form-group col-xl-7">

                        </div>
                        <div class="form-group col-xl-4 ">
                            {{-- Monto total Origen --}}
                            <label for="amount_total">Monto total Origen:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total" id="amount_total" class="form-control general" readonly></input>
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
                                Porcentaje Destino:
                            </label>
                            
                            <div class="input-group-text ml-2 mt-2 col-6 d-flex" style="height: 3rem">
                                <i class="fa-fw fas fa-percentage mr-2"></i>
                                <input type="text" id="percentage2" name="percentage2" class="form-control percentage rateMasks" min="0">
                            </div>                        

                        </div>


                        
                        <div class="form-group col-xl-4">

                            <label for="commission2">Monto Comisión Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" name="commission2" id="commission2" readonly min="0" class="form-control general"></input>
                            </div>

                        </div>

                        {{-- Monto total Destino --}}



                    </div>

                    <div class="form-row">
                        <div class="col-12 col-xl-7 mt-2 d-flex">
                        </div>
                        <div class="form-group col-xl-4">
                            <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio1_base2">
                                        <input type="radio" name="exonerate2" id="radio1_base2" class="exonerar_base" value="2">                                
                                        Exonerar comisión destino
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio3_base2">
                                        <input type="radio" name="exonerate2" id="radio3_base2" class="incluir_base" value="1">
                                        Incluir comisión destino
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label class="form-check-label mx-auto esconder comi" for="radio2_base2">
                                        <input type="radio" name="exonerate2" id="radio2_base2" class="descontar_base" value="3">
                                        Descontar comisión destino
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
                            <label for="amount2">Monto:</label>
                            <div class="input-group-text" >
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                <input type="text" id="amount2" name="amount2" class="form-control comision_base general" min="0" readonly> </input>
                            </div>
                        </div>                          
                    </div>



                    <div class="form-row esconder comi">

                        <div class="form-group col-xl-7">
                        </div>

                        {{-- Monto total Destino --}}

                        <div class="form-group col-xl-4">
                            <label for="amount_total2">Monto total Destino:</label>
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-coins mr-2"></i>
                                <input type="text" name="amount_total2" id="amount_total2" readonly class='form-control general'></input>
                            </div>
                        </div>

                    </div>


                    <input type="hidden" id="amount_commission_profit"  name="amount_commission_profit"  value="">
                    <input type="hidden" id="amount_commission_profit2" name="amount_commission_profit2" value="">

                    <hr class="bg-dark esconder comi" style="height:1px;">
                    {{--
                    <div class="form-group">
                        
                        <label for="observacion">Observaciones:</label>
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                            <input type="text" name="observacion" id="observacion" class="form-control"></input>
                        </div>
                    </div>
                    --}}
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

    $("#group_id").select2({
        placeholder: "Selecciona cliente origen",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $("#group2_id").select2({
        placeholder: "Selecciona cliente destino",
        theme: 'bootstrap4',
        search: false,
        width: '100%',
        allowClear: true,
    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
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

    // $("#type_transaction_id").val("")
    // $("#type_transaction_id").trigger("change");
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

        //
        // valida selecciona de tipo de moneda
        //
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
        //
        //
        //
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
                if ($('#percentage').val() <= 0) {
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

            if ($('#percentage2').val() <= 0) {
                Swal.fire('Porcentage destino, no puede ser cero o menor a cero. :(');
                return false;
            }

            let exonerar_base2     = $('#radio1_base2').is(':checked');
            let descontar_base2    = $('#radio2_base2').is(':checked');
            let incluir_base2      = $('#radio3_base2').is(':checked');

            if(!exonerar_base2 && !descontar_base2 && !incluir_base2){
                Swal.fire('Error: Marcar si comision destino esta exonerada, incluida o descontada');
                return false;            
            }
        }
        if (radioComisionDestino2){
            if ($('#exchange2').val() <= 0) {
                Swal.fire('Tasa de cambio destino, no puede ser cero o menor a cero.');
                return false;
            }            
        }

        if ($('#amount').val().length == 0) {
            Swal.fire('Monto en dolares, no puede estar vacio');
            return false;
        }

        if ($('#amount').val() <= 0) {
            Swal.fire('Monto en dolares, no puede ser cero o menor a cero. :(');
            return false;
        }

        //  return false; // no envia submit


    });

    $('#radioComision1').on('click', function() {
        $('#exchange').val('');
        $('#exchange').attr('readonly',true);

        $('#percentage').attr('readonly',false);
        $('#radio1_base').attr('readonly',false);
        $('#radio2_base').attr('readonly',false);
        $('#radio3_base').attr('readonly',false);

        $('#radio3_base').prop('checked',true);

        $('#comision').val('');

        $('#amount').val($('#amount_foreign_currency').val());
        $('#amount_total').val($('#amount_foreign_currency').val());
    }
    );

    $('#radioComision2').on('click', function() {

        $('#percentage').val('');
        $('#percentage').attr('readonly',true);

        $('#commission').val('');

        $('#radioComision1').prop('checked',false);
        $('#radio1_base').prop('checked',false);
        $('#radio2_base').prop('checked',false);
        $('#radio3_base').prop('checked',false);


        $('#radio1_base').attr('readonly',true);
        $('#radio2_base').attr('readonly',true);
        $('#radio3_base').attr('readonly',true);

        $('#exchange').attr('readonly',false);

        $('#amount').val($('#amount_foreign_currency').val());
        $('#amount_total').val($('#amount_foreign_currency').val());

    }
    );
    //
    //
    //
    $('#radioComisionDestino1').on('click', function() {
        $('#exchange2').val('');
        $('#exchange2').attr('readonly',true);

        $('#percentage2').attr('readonly',false);
        $('#radio1_base2').attr('readonly',false);
        $('#radio2_base2').attr('readonly',false);
        $('#radio3_base2').attr('readonly',false);
        
        $('#radio3_base2').prop('checked',true);

        $('#comision2').val('');

        $('#amount2').val($('#amount_foreign_currency').val());
        $('#amount_total2').val($('#amount_foreign_currency').val());
    }
    );

    $('#radioComisionDestino2').on('click', function() {
        $('#percentage2').val('');
        $('#percentage2').attr('readonly',true);

        $('#commission2').val('');
        $('#radioComisionDestino1').prop('checked',false);

        $('#radio1_base2').prop('checked',false);
        $('#radio2_base2').prop('checked',false);
        $('#radio3_base2').prop('checked',false);


        $('#radio1_base2').attr('readonly',true);
        $('#radio2_base2').attr('readonly',true);
        $('#radio3_base2').attr('readonly',true);

        $('#exchange2').attr('readonly',false);

        $('#amount2').val($('#amount_foreign_currency').val());
        $('#amount_total2').val($('#amount_foreign_currency').val());
        
    }
    );

    $('#amount_foreign_currency, #percentage, #percentage2, #exchange, #exchange2').on('input', function() {
        
         updateMontorealBase();
    });

    $('#radio1_base, #radio2_base, #radio3_base, #radio1_base2, #radio2_base2, #radio3_base2').on('click', function() {
        updateMontorealBase();
    });

    $("#type_transaction_id, #group_id, #type_transaction_id2, #group2_id").change(function() {
        updateTransactionClient();
    });

    function updateMontorealBase() {

        let amount_foreign_currency     = $('#amount_foreign_currency').val() == ""         ? 0 : parseFloat($('#amount_foreign_currency').val());

        let amount                      = 0;
        let amount2                     = 0;

        let commission         = $('#commission').val() == ""     ? 0 : parseFloat($('#commission').val());
        let percentage         = $('#percentage').val() == ""     ? 0 : parseFloat($('#percentage').val());

        let exonerar           = $('#radio1_base').is(':checked');
        let descontar          = $('#radio2_base').is(':checked');
        let incluir            = $('#radio3_base').is(':checked');

        let exchange            = $('#exchange').val() == ""     ? 0 : parseFloat($('#exchange').val());

        let commission2        = $('#commission2').val() == ""     ? 0 : parseFloat($('#commission2').val());
        let percentage2        = $('#percentage2').val() == ""     ? 0 : parseFloat($('#percentage2').val());

        let exonerar2          = $('#radio1_base2').is(':checked');
        let descontar2         = $('#radio2_base2').is(':checked');
        let incluir2           = $('#radio3_base2').is(':checked');

        let exchange2          = $('#exchange2').val() == ""     ? 0 : parseFloat($('#exchange2').val());

        let amount_commission_profit    = 0;
        let amount_commission_profit2   = 0;
        let amount_total                = 0;
        let amount_total2               = 0;
        
        amount = amount_foreign_currency;
        amount_total = amount_foreign_currency;

        if(percentage > 0){
            commission = (amount_foreign_currency * (percentage / 100));
            $('#commission').val(commission);
        

            if (commission == 0) {
                amount_commission_profit = 0;
            }else{
                amount_commission_profit = commission;
            }

            // calcula el total
            amount = amount_foreign_currency;
            amount_total = amount_foreign_currency;

            if(!exonerar) {
                if(incluir) {
                    amount_total = (amount_foreign_currency  + commission).toFixed(2);
                    $('#amount_total').val(amount_total);
                    //alert(montoreal);
                } else if(descontar) {
                    amount_total = (amount_foreign_currency - commission).toFixed(2);
                    $('#amount_total').val(amount_total);
                }
            }
            else {
                $('#percentage').val('');
                $('#commission').val(''); 
                commission = 0;
                
                amount_total = amount_foreign_currency.toFixed(2);
                $('#amount_total').val(amount_total);
            }
        }

        if (exchange > 0) {
            amount = amount_foreign_currency / exchange;
            amount_total  = amount;
            $('#amount_total').val(amount_total);
        }

        // comision destino

        amount2 = amount_foreign_currency;
        amount_total2 = amount_foreign_currency;

        if(percentage2 > 0){
            
            commission2 = (amount_foreign_currency * (percentage2 / 100));
            $('#commission2').val(commission2);
            //alert(comision);
        

            if (commission2 == 0) {
                amount_commission_profit2 = 0;
            }else{
                amount_commission_profit2 = commission2;
            }


 
            if(!exonerar2) {
                if(incluir2) {
                    amount_total2 = (amount_foreign_currency + commission2).toFixed(2);
                    amount2 = amount_foreign_currency;
                    $('#amount_total2').val(amount_total2);
                    //alert(montoreal);
                } else if(descontar2) {
                    amount_total2 = (amount_foreign_currency - commission2).toFixed(2);
                    amount2 = amount_foreign_currency;
                    $('#amount_total2').val(amount_total2);
                }
            }
            else {

                $('#percentage2').val('');
                $('#commission2').val('');
                
                commission2 = 0;

                amount_total2 = amount_foreign_currency.toFixed(2);
                amount2 = amount_foreign_currency.toFixed(2);
                $('#amount_total2').val(amount_total2);
            }
            
        }

        if (exchange2 > 0) {
            amount2        = amount_foreign_currency / exchange2;
            amount_total2  = amount2;
            $('#amount2').val(amount2);
            $('#amount_total2').val(amount_total2);
        }

        // comision destino

        $('#amount_commission_profit').val(amount_commission_profit);
        $('#amount_commission_profit2').val(amount_commission_profit2);

        if (commission == 0){
            $('#commission').val('');
        }else{
            $('#commission').val(commission);
        }

        $('#amount').val(amount);
        $('#amount_total').val(amount_total);
        
        $('#commission2').val(commission2);
        $('#amount2').val(amount2);
        $('#amount_total2').val(amount_total2);
        
    }


    function cargaData(){

         $('#amount_foreign_currency').val({{$transactionOrigen->AmountForeignCurrency}});
         $('#amount').val({{$transactionOrigen->Amount}});
         $('#amount2').val({{$transactionDestino->Amount}});
        // $('#amount').val("{{number_format($transactionOrigen->Amount,2)}}");

        $('#transaction_date').val('{{$transactionOrigen->TransactionDate}}');
        

        //$('#transaction_date').val('{{$fecha}}');
        //
        

        //
        // Origen
        //

        $('#percentage').val({{$transactionOrigen->Porcentage}});
        $('#commission').val({{$transactionOrigen->AmountCommission}});
        $('#amount_total').val({{$transactionOrigen->AmountTotal}});

        myExonerate = {{$transactionOrigen->Exonerate ?? 0}};
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

        $('#exchange').val('{{$transactionOrigen->Exchange}}');


        if ($('#percentage').val() != ''){
            $('#radioComision1').prop('checked',  true);
        }
        if ($('#exchange').val() != ''){
            $('#radioComision2').prop('checked',  true);
        }
        //
        // Destino
        //
        
        $('#percentage2').val({{$transactionDestino->Porcentage}});
        $('#commission2').val({{$transactionDestino->AmountCommission}});
        $('#amount_total2').val({{$transactionDestino->AmountTotal}});
        
        myExonerate2 = {{$transactionDestino->Exonerate ?? 0}};
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
        {{-- dd($transactionDestino)--}}
        $('#exchange2').val('{{$transactionDestino->Exchange}}');

        if ($('#percentage2').val() != ''){
            $('#radioComisionDestino1').prop('checked',  true);
        }
        if ($('#exchange2').val() != ''){
            $('#radioComisionDestino2').prop('checked',  true);
        }


        //
        //
        //
        $('#observacion').val('');

        $('#description').val('{{$transactionOrigen->Description}}');

        $('#description2').val('{{$transactionDestino->Description}}');


        let type_transaction_id     = '{{$transactionOrigen->TypeTransactionId}}';
        let type_transaction_id2    = '{{$transactionDestino->TypeTransactionId}}';

        let group_id                = '{{$transactionOrigen->GroupIdOrigen}}';
        let group2_id               = '{{$transactionDestino->GroupIdOrigen}}';

        let type_coin_id            = '{{$transactionOrigen->TypeCoinId}}';


        BuscaElemento('group_id', group_id);
        BuscaElemento('group2_id', group2_id);
        BuscaElemento('type_transaction_id', type_transaction_id);
        BuscaElemento('type_transaction_id2', type_transaction_id2);
        BuscaElemento('type_coin_id', type_coin_id);

        $("#group_id").trigger("change");
        $("#group2_id").trigger("change");
        $("#type_transaction_id").trigger("change");
        $("#type_transaction_id2").trigger("change");
        $("#type_coin_id").trigger("change");

    }


    function BuscaElemento(myControl, myElement){
        // console.log('llega ->' + myControl + ' con el elemento -> ' + myElement);
        let mySelect = myControl;
        let myValue  = myElement;

        $('#' + mySelect).each( function(index, element){
            $(this).children("option").each(function(){

                // console.log ("Busca-> " + myValue + ' con ' + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));

                // alert();
                if ($(this).val() === myValue.toString()){
                    // console.log('encontro -> ' + $(this).val());
                     $("#" + mySelect + " option[value='"+ myValue +"']").attr("selected",true);
                }
            });
        });
        //
    }


    function  updateTransactionClient(){

        var type_transaction_id     = $("#type_transaction_id").val();                      // Capturamos el valor del select
        var type_transaction_name   = $("#type_transaction_id option:selected").text();     // Capturamos el texto del option seleccionado
       
        var type_transaction_id2    = $("#type_transaction_id2").val();                     // Capturamos el valor del select
        var type_transaction_name2  = $("#type_transaction_id2 option:selected").text();    // Capturamos el texto del option seleccionado

        var group_id                = $('#group_id').val();                                 // Capturamos el valor del select
        var group_name              = $("#group_id option:selected").text(); // Capturamos el texto del option seleccionado

        var group2_id               = $('#group2_id').val(); // Capturamos el valor del select
        var group2_name             = $("#group2_id option:selected").text(); // Capturamos el texto del option seleccionado

        // alert(type_transaction_name );
        //$("#description2").val('Recibido de cliente ' + group_name + "/" + type_transaction_name);

        $("#description").val('Entregado a ' + group2_name + '/' + type_transaction_name2);
        $("#description2").val('Recibido de cliente ' + group_name + "/" + type_transaction_name);
    }
</script>



@endsection

