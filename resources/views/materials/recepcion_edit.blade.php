@extends('adminlte::page')
@section('title', 'Recepcion')
@section('content_header')

<h1 class="text-center text-dark font-weight-bold">Modificar Recepcion Material<i class="fas fa-coins"></i> </h1></a>

@stop


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-10" style="min-height:500px; !important; max-height:100%; height:100%; widht:100%">
        <div class="card-body">

            {!! Form::model($transactions, ['route' => ['materials.recepcion_update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'myForm']) !!}



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

                        <div class="form-group col-md-4 col-xl-4" >
                            {!! Form::Label('typetrasnferencia', "Tipo de Movimiento:") !!}
                            <div class="input-group-text col-md-12" style="height: 3.3rem;">
                                <i class="fa-fw fas fa-random mr-2"></i>
                                {!! Form::Label($transactions->type_transaction_name) !!}
                            
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



                </div>

                <hr class="bg-dark esconder" style="height:1px;">   


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
                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount', "Kilos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_kilos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_kilos']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount', "Gramos:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_gramos',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_gramos']) !!}
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        {!! Form::Label('material_amount_cantidad', "Cantidad:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('material_amount_cantidad',null, ['class' => 'form-control general myForm', 'required' => true, 'id' => 'material_amount_cantidad']) !!}
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
</style>

@endsection

@section('js')
<script>

    $('.general').inputmask({
        alias: 'decimal',
        allowMinus: true,
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

    buscaTipoAdquisicion();

    $(document).ready(function() {

        $('#myForm').on('input', function (){
            // alert('cambio');
            calcula();
        });        

        $('#myForm').on('submit', function() {

         
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

            // alert($('#percentage').val());
            // percentage_base
            let material_amount = $('#material_amount').val() != "" ? parseFloat($('#material_amount').val()) : 0;
            if (material_amount  == 0){
                Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Cantidad no puede ser cero',
                        showConfirmButton: true
                    }
                );  
                return false;
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

        });


    });


    $(".typetrasnferencia").select2({
        placeholder: "Seleccionar Tipo de Movimiento",
        theme: 'bootstrap4',
        search: false,
        allowClear: true,
        width: '100%'
    });

    $(".wallet").select2({
        placeholder: "Seleccionar Caja | Wallet",
        theme: 'bootstrap4',
        search: false,
        allowClear: true,
        width: '100%'
    });

    // type_material
    $("#type_material_id").select2({
        placeholder: "Seleccionar ...",
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });

    $(".clientes").select2({
        placeholder: "Seleccionar cliente",
        theme: 'bootstrap4',
        notEmpty: false,
        allowClear: true,
        clearing: true,
        width: '100%'
    });


    $('#material_type_adquisicion1').on('click', function (){
        // alert('leam aqui 1');
        validaMaterialTypeAdquisicion();
    });
    $('#material_type_adquisicion2').on('click', function (){
        // alert('leam aqui 2');
        validaMaterialTypeAdquisicion();
    });
    $('#material_type_adquisicion3').on('click', function (){
        // alert('leam aqui 3');
        validaMaterialTypeAdquisicion();
    }); 


    BuscaMyElement('typetrasnferencia',  {{ $transactions->type_transaction_id }});
    BuscaMyElement('type_material_id',  {{ $transactions->type_material_id }});
    BuscaMyElement('wallet',            {{ $transactions->wallet_id }});
    BuscaMyElement('clientes',          {{ $transactions->group_id }});

    function calcula(){
        // alert('calcula ----');

        
        let material_amount_kilos       = ($('#material_amount_kilos').val())           ? parseFloat($('#material_amount_kilos').val())     : 0;
        let material_amount_gramos      = ($('#material_amount_gramos').val())          ? parseFloat($('#material_amount_gramos').val())    : 0;
        let material_amount_cantidad    = ($('#material_amount_cantidad').val())        ? parseFloat($('#material_amount_cantidad').val())  : 0;

        let material_type_adquisicion1  = $('#material_type_adquisicion1').is(':checked');
        let material_type_adquisicion2  = $('#material_type_adquisicion2').is(':checked');
        let material_type_adquisicion3  = $('#material_type_adquisicion3').is(':checked');

        let material_type_adquisicion   = 0;

        let my_material_amount          = 0;





        if (material_type_adquisicion1){
            material_type_adquisicion = 1;

            $('#material_amount_kilos').prop('readonly',false);

            $('#material_amount_gramos').prop('readonly',true);

            $('#material_amount_cantidad').prop('readonly',true);


            // alert($('#material_amount_kilos').val());

            $('#material_amount_gramos').val("");

            $('#material_amount_cantidad').val("");            

        }else if(material_type_adquisicion2){
            material_type_adquisicion = 2; // gramos
            $('#material_amount_kilos').prop('readonly',true);
            $('#material_amount_gramos').prop('readonly',false);
            $('#material_amount_cantidad').prop('readonly',true);

            $('#material_amount_kilos').val("");
            
            $('#material_amount_cantidad').val("");

        }else if(material_type_adquisicion3){
            material_type_adquisicion = 3; // cantidad
            $('#material_amount_kilos').prop('readonly',true);
            $('#material_amount_gramos').prop('readonly',true);
            $('#material_amount_cantidad').prop('readonly',false);

            $('#material_amount_kilos').val("");

            $('#material_amount_gramos').val("");

        }


        switch (material_type_adquisicion){
            case 1: // Kilos
                if (material_amount_kilos != 0){

                    material_amount_gramos           = material_amount_kilos * 1000;
                    
                    $('#material_amount_gramos').val(material_amount_gramos);

                }        

                break;      
            case 2: // Gramos

                if (material_amount_gramos != 0){


                    material_amount_kilos           = material_amount_gramos / 1000;

                    $('#material_amount_kilos').val(material_amount_kilos);
                    
                }
                
                break;
            case 3: // Cantidad
                if (material_amount_cantidad != 0){


                    $('#material_amount_cantidad').val(material_amount_cantidad); 
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


        $('#material_amount_gramos').prop('readonly',true);

        $('#material_amount_cantidad').prop('readonly',true);

        switch (myTypeAdquisicion){
            case 1:
                $('#material_type_adquisicion1').prop('checked',true);

                $('#material_amount_kilos').prop('readonly',false);

                $('#material_amount_kilos').focus();

                break;
            case 2:
                $('#material_type_adquisicion2').prop('checked',true);

                $('#material_amount_gramos').prop('readonly',false);

                break;
            case 3:
                $('#material_type_adquisicion3').prop('checked',true);

                $('#material_amount_cantidad').prop('readonly',false);

                break;
        }

        }


        function validaMaterialTypeAdquisicion(){

            // alert('pasa');

            let material_type_adquisicion1  = $('#material_type_adquisicion1').is(':checked');
            let material_type_adquisicion2  = $('#material_type_adquisicion2').is(':checked');
            let material_type_adquisicion3  = $('#material_type_adquisicion3').is(':checked');
            let material_type_adquisicion   = 0;

            let my_material_amount          = 0;

            if (material_type_adquisicion1){
                material_type_adquisicion = 1;

                $('#material_amount_kilos').prop('readonly',false);
                $('#material_amount_gramos').prop('readonly',true);
                $('#material_amount_cantidad').prop('readonly',true);


                $('#material_amount_kilos').focus();

                // alert($('#material_amount_kilos').val());

            }else if(material_type_adquisicion2){
                material_type_adquisicion = 2;
                $('#material_amount_kilos').prop('readonly',true);
                $('#material_amount_gramos').prop('readonly',false);
                $('#material_amount_cantidad').prop('readonly',true);

                $('#material_amount_gramos').focus();

            }else if(material_type_adquisicion3){
                material_type_adquisicion = 3;
                $('#material_amount_kilos').prop('readonly',true);
                $('#material_amount_gramos').prop('readonly',true);
                $('#material_amount_cantidad').prop('readonly',false);

                $('#material_amount_cantidad').focus();


            }
            // alert('material_type_adquisicion ->' + material_type_adquisicion);

            $('#material_amount_kilos').val("");
            $('#material_amount_gramos').val("");
            $('#material_amount_cantidad').val("");

        }

</script>



@endsection
