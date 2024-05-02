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
                    {!! Form::hidden('amount',0, null, ['class' => 'form-control', 'required' => true]) !!}

                    <div class="form-row">
                        {{--
                        <div class="form-group col-md-4 col-xl-4">
                            {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia myForm', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                            </div>
                        </div>
                        --}}
                        <div class="form-group col-xl-4">
                            {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12" style="height:3.3rem;">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::Label($transactions->type_transaction_name ) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-4 esconder">
                            {!! Form::Label('wallet', "Caja:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-box-open mr-2"></i>
                            {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet myForm', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-xl-4">
                            {!! Form::Label('clientes', "Grupo:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                            {!! Form::select('group_id',$group, null,['class' => 'form-control clientes myForm', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                            </div>
                        </div>
                    </div>


                </div>
                <hr class="bg-dark escoder" style="height:1px;">   

                <div class="form-row">
                    <div class="form-group col-xl-3">
                        {!! Form::Label('type_material_id', "Tipo de material:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                        {!! Form::select('type_material_id',$type_material, null, ['class' => 'form-control type_material_id myForm', 'required' => true, 'id' => 'type_material_id', 'readonly' => false]) !!}
                        </div>
                    </div>
                </div>
                <hr class="bg-dark escoder" style="height:1px;">   

                @php 
                            
                @endphp

                <div class="form-row col-lg-12 justify-content-center align-items-center">        
                    <p>Tipo de Adquisicion  :</p>
                </div>

                <div class="form-row  col-lg-12 justify-content-center align-items-center">
                    <div class="col-sm-12 col-md-4">
                        <input class="myForm" type="radio" id="material_type_adquisicion1" name="material_type_adquisicion" value="1">
                        <label for="material_type_adquisicion1">Kilos</label>
                    </div>
                    <div class="col-sm-12 col-md-4">

                        <input class="myForm" type="radio" id="material_type_adquisicion2" name="material_type_adquisicion" value="2">
                        <label for="material_type_adquisicion2">Gramos</label>
                    </div>

                    <div class="col-sm-12 col-md-4">

                        <input class="myForm" type="radio" id="material_type_adquisicion3" name="material_type_adquisicion" value="3">
                        <label for="material_type_adquisicion3">Cantidad</label>
                    </div>
                </div>

                <hr class="bg-dark esconder" style="height:1px;">
                

                <div class="form-row">
                    <div class="form-group col-lg-4">
                        {!! Form::Label('material_amount_kilos', "kilos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_kilos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_kilos']) !!}
                        </div>

                        {!! Form::Label('material_amount_gramos', "Gramos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_gramos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_gramos', 'readonly' => 'true']) !!}
                        </div>

                        {!! Form::Label('material_amount_cantidad', "Cantidad:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_cantidad',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_cantidad', 'readonly' => 'true']) !!}
                        </div>

                    </div>



                    <div class="form-group col-lg-4">
                            {!! Form::Label('material_price', "Precio/U Kilos:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::text('material_price_kilos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_price_kilos', 'minlength' => 9]) !!}
                            
                            </div>

                            {!! Form::Label('material_price', "Precio/U Gramos:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::text('material_price_gramos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_price_gramos', 'minlength' => 9, 'readonly' => true,]) !!}
                            
                            </div>


                            {!! Form::Label('material_price', "Precio/U Cantidad:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::text('material_price_cantidad',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_price_cantidad', 'minlength' => 9, 'readonly' => true,]) !!}
                            
                            </div>

                    </div>

                

                    <div class="form-group col-lg-4">
                        {!! Form::Label('material_amount_total', "Monto Total $ Kilos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                            {!! Form::text('material_amount_total_kilos', null, ['class' => 'form-control  general', 'required' => true, 'id' => 'material_amount_total_kilos', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                        </div>

                        {!! Form::Label('material_amount_total', "Monto Total $ Gramos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                            {!! Form::text('material_amount_total_gramos', null, ['class' => 'form-control general', 'required' => true, 'id' => 'material_amount_total_gramos', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
                        </div>
                        
                        {!! Form::Label('material_amount_total', "Monto Total $ Cantidad:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                            {!! Form::text('material_amount_total_cantidad', null, ['class' => 'form-control general', 'required' => true, 'id' => 'material_amount_total_cantidad', 'readonly' => true, 'data-mask-clearifnotmatch' => true]) !!}
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


    $(".typetrasnferencia").select2({
        placeholder: "Seleccionar ...",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });

    $("#type_material_id").select2({
        placeholder: "Seleccionar ...",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });


    

    $(document).ready(function() {


        buscaTipoAdquisicion();

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



        let material_amount_kilos       = ($('#material_amount_kilos').val())           ? parseFloat($('#material_amount_kilos').val())     : 0;
        let material_amount_gramos      = ($('#material_amount_gramos').val())          ? parseFloat($('#material_amount_gramos').val())    : 0;
        let material_amount_cantidad    = ($('#material_amount_cantidad').val())        ? parseFloat($('#material_amount_cantidad').val())  : 0;
        
        let material_price_kilos        = ($('#material_price_kilos').val())        ? parseFloat($('#material_price_kilos').val())      : 0;
        let material_price_gramos       = ($('#material_price_gramos').val())       ? parseFloat($('#material_price_gramos').val())     : 0;
        let material_price_cantidad     = ($('#material_price_cantidad').val())     ? parseFloat($('#material_price_cantidad').val())   : 0;

        let material_type_adquisicion1  = $('#material_type_adquisicion1').is(':checked');
        let material_type_adquisicion2  = $('#material_type_adquisicion2').is(':checked');
        let material_type_adquisicion3  = $('#material_type_adquisicion3').is(':checked');

        let material_type_adquisicion   = 0;

        let my_material_amount          = 0;



        if (material_type_adquisicion1){
            material_type_adquisicion = 1;

            $('#material_amount_kilos').prop('readonly',false);
            $('#material_price_kilos').prop('readonly',false);


            $('#material_amount_gramos').prop('readonly',true);
            $('#material_price_gramos').prop('readonly',true);

            $('#material_amount_cantidad').prop('readonly',true);
            $('#material_price_cantidad').prop('readonly',true);


            // alert($('#material_amount_kilos').val());

            $('#material_amount_gramos').val("");
            $('#material_price_gramos').val("");
            $('#material_amount_total_gramos').val("");

            $('#material_amount_cantidad').val("");
            $('#material_price_cantidad').val("");
            $('#material_amount_total_cantidad').val("");



        }else if(material_type_adquisicion2){
            material_type_adquisicion = 2; // gramos
            $('#material_amount_kilos').prop('readonly',true);
            $('#material_amount_gramos').prop('readonly',false);
            $('#material_amount_cantidad').prop('readonly',true);

            $('#material_price_kilos').prop('readonly',true);
            $('#material_price_gramos').prop('readonly',false);
            $('#material_price_cantidad').prop('readonly',true);


            $('#material_amount_kilos').val("");
            $('#material_price_kilos').val("");
            $('#material_amount_total_kilos').val("");
            
            $('#material_amount_cantidad').val("");
            $('#material_price_cantidad').val("");
            $('#material_amount_total_cantidad').val("");

        }else if(material_type_adquisicion3){
            material_type_adquisicion = 3; // cantidad
            $('#material_amount_kilos').prop('readonly',true);
            $('#material_amount_gramos').prop('readonly',true);
            $('#material_amount_cantidad').prop('readonly',false);

            $('#material_price_kilos').prop('readonly',true);
            $('#material_price_gramos').prop('readonly',true);
            $('#material_price_cantidad').prop('readonly',false);


            $('#material_amount_kilos').val("");
            $('#material_price_kilos').val("");
            $('#material_amount_total_kilos').val("");

            $('#material_amount_gramos').val("");
            $('#material_price_gramos').val("");
            $('#material_amount_total_gramos').val("");

        }
        // alert('material_type_adquisicion ->' + material_type_adquisicion);



        // console.log('pasa updateMontoreal');
        // console.log('pasa updateMontoreal con exchange_rate                 -> ' + exchange_rate);
        // console.log('pasa updateMontoreal con amount_foreign_currency       -> ' + amount_foreign_currency);
        // console.log('pasa updateMontoreal con amount                        -> ' + amount);
        // console.log('pasa updateMontoreal con amount_total                  -> ' + amount_total);
        //console.log('pasa updateMontoreal con material_price                -> ' + material_price_kilos);
        //console.log('pasa updateMontoreal con material_amount               -> ' + material_amount_kilos);

        switch (material_type_adquisicion){
            case 1: // Kilos
                if (material_price_kilos > 0){
                    material_amount_total_kilos = material_price_kilos * material_amount_kilos;
                    $('#material_amount_total_kilos').val(material_amount_total_kilos); 

                    material_amount_gramos           = material_amount_kilos * 1000;
                    material_price_gramos            = material_price_kilos / 1000;
                    material_amount_total_gramos     = material_price_gramos  * material_amount_gramos;

                    $('#material_amount_gramos').val(material_amount_gramos);
                    $('#material_amount_total_gramos').val(material_amount_total_gramos);
                    $('#material_price_gramos').val(material_price_gramos);

                }        
               
                
                break;      
            case 2: // Gramos

                if (material_price_gramos > 0){

                    material_amount_total_gramos    = material_price_gramos * material_amount_gramos;

                    material_amount_kilos           = material_amount_gramos / 1000;
                    material_price_kilos            = material_price_gramos * 1000;
                    material_amount_total_kilos     = material_price_kilos  * material_amount_kilos;

                    $('#material_amount_kilos').val(material_amount_kilos);
                    $('#material_amount_total_kilos').val(material_amount_total_kilos);
                    $('#material_price_kilos').val(material_price_kilos);

                    $('#material_amount_total_gramos').val(material_amount_total_gramos);
                    
                }
                
                break;
            case 3: // Cantidad
                if (material_price_cantidad > 0){

                    material_amount_total_cantidad = material_price_cantidad * material_amount_cantidad;
                    // alert(material_amount_cantidad);
                    $('#material_amount_total_cantidad').val(material_amount_total_cantidad); 
                }

                


                break;
            default:
        }
    




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

    function buscaTipoAdquisicion(){

        let myTypeAdquisicion = {{ $transactions->material_type_adquisicion ?? 0}};



        $('#material_amount_kilos').prop('readonly',true);
        $('#material_price_kilos').prop('readonly',true);
        $('#material_amount_total_kilos').prop('readonly',true);

        $('#material_amount_gramos').prop('readonly',true);
        $('#material_price_gramos').prop('readonly',true);
        $('#material_amount_total_gramos').prop('readonly',true);

        $('#material_amount_cantidad').prop('readonly',true);
        $('#material_price_cantidad').prop('readonly',true);
        $('#material_amount_total_cantidad').prop('readonly',true);

        switch (myTypeAdquisicion){
            case 1:
                $('#material_type_adquisicion1').prop('checked',true);

                $('#material_amount_kilos').prop('readonly',false);
                $('#material_price_kilos').prop('readonly',false);
                $('#material_amount_total_kilos').prop('readonly',false);

                $('#material_amount_kilos').focus();
                console.log('aqui');
                break;
            case 2:
                $('#material_type_adquisicion2').prop('checked',true);

                $('#material_amount_gramos').prop('readonly',false);
                $('#material_price_gramos').prop('readonly',false);
                $('#material_amount_total_gramos').prop('readonly',false);

                break;
            case 3:
                $('#material_type_adquisicion3').prop('checked',true);

                $('#material_amount_cantidad').prop('readonly',false);
                $('#material_price_cantidad').prop('readonly',false);
                $('#material_amount_total_cantidad').prop('readonly',true);

                break;
        }

    }


</script>



@endsection
