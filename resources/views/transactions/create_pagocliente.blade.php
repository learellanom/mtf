@extends('adminlte::page')



@section('title', 'Pagos entre clientes')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('PAGOS ENTRE CLIENTES') }}<i class="fas fa-donate"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
  <div class="card col-md-5" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
    <div class="card-body">

        {!! Form::open(['route' => 'transactions.store_pagocliente', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'entre']) !!}


        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-uppercase font-weight-bold" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('PAGOS') }}</button>
        </li>

        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

          

                <div class="form-row">

                    <div class="form-group col-md-6">
                        {!! Form::Label('group_id', "Cliente de origen:") !!}
                        <div class="input-group-text col-md-12">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::select('group_id', $group, null, ['class' => 'form-control wallet muestra', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::Label('group2_id', "Cliente destino:") !!}
                        <div class="input-group-text col-md-12">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::select('group2_id', $group, null, ['class' => 'form-control wallet2 oculta', 'required' => true, 'id'=>'wallet2', 'readonly' => false]) !!}
                        </div>
                    </div>

                </div>
                @foreach($wallet as $wallet2)
                    {!! Form::hidden('wallet_id', $wallet2, null, ['class' => 'form-control transaccion']) !!}
                    {!! Form::hidden('wallet2_id', $wallet2, null, ['class' => 'form-control transaccion']) !!}
                @endforeach

                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::Label('amount', "Monto en dolares:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                        {!! Form::text('amount', null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto_dolares']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::Label('transaction_date', "Fecha:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                        {!! Form::datetimeLocal('transaction_date', $fecha, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                        </div>
                    </div>
                </div>

                {!! Form::hidden('amount_total_2',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal2']) !!}

                {!! Form::hidden('status', 'Activo', null, ['class' => 'form-control']) !!}


                @foreach($type_transaction as $type)
                    {!! Form::hidden('type_transaction_id', $type, null, ['class' => 'form-control transaccion']) !!}
                @endforeach


                @foreach($type_transaction2 as $type2)
                    {!! Form::hidden('type_transaction2_id', $type2, null, ['class' => 'form-control transaccion']) !!}
                @endforeach


                <div class="form-group">
                    {{-- {!! Form::hidden('pay_number', $number,['class' => 'form-control', 'required' => true, 'readonly' => true]) !!} --}}
                </div>

                <hr class="bg-dark esconder comi" style="height:1px;">
                <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Origen  </h4>
                <div class="form-row esconder comi">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Origen:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMasks',  'min' => 0, 'id' => 'percentage_base']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('comision_base', "Monto Comisión Origen:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('commission',null, ['class' => 'form-control comision_base general', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto esconder comi" for="radio1_base">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1_base', 'class' => 'exonerar_base']) !!}
                        Exonerar comisión origen
                    </label>

                    <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3_base', 'class' => 'incluir_base']) !!}
                        Incluir comisión origen
                    </label>


                    <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                        Descontar comisión origen
                        {!! Form::radio('exonerate',3, null, ['id' => 'radio2_base', 'class' => 'descontar_base']) !!}
                    </label>

                </div>

                <div class="form-group col-md">
                    {!! Form::Label('montototal', "Monto total:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-coins mr-2"></i>
                    {!! Form::text('amount_total', null, ['class' => 'form-control general', 'id' => 'monto_base', 'readonly' => true ]) !!}
                    </div>
                </div>

                {!! Form::hidden('amount_commission_profit', 0, ['class' => 'form-control general', 'id' => 'amount_commission_profit', 'readonly' => true ]) !!}
                {!! Form::hidden('amount_commission_profit2', 0, ['class' => 'form-control general', 'id' => 'amount_commission_profit2', 'readonly' => true ]) !!}

                <hr class="bg-dark esconder comi" style="height:1px;">

                <div class="form-group">
                    {!! Form::Label('description', "Descripción origen:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::text('description','Entregado a cliente', ['id' => 'descripcion', 'class' => 'form-control', 'readonly' => true, 'required' => true, 'value' => 'Recibido de cliente']) !!}
                        </div>
                </div>
                <div class="form-group">
                    {!! Form::Label('description2', "Descripción destino:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::text('description2','Recibido de cliente', ['id' => 'descripcion2','class' => 'form-control', 'readonly' => true, 'required' => true]) !!}
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
  });
  $("#typetransaccion").val("")
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



  $('#monto_dolares').on('input', function() {
      var dolar = $('#monto_dolares').val();
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

      $('#montototal').val(dolar);
  });

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
    $('.oculta').select2({
        'theme':'bootstrap4',
        search: false,
        allowClear: true,
        placeholder: "Seleccionar cliente",
        width:'100%'
    });
    $(".oculta").val("")
    $(".oculta").trigger("change");

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
            Swal.fire('Porcentage origen, no puede ser cero o menor a cero. :(');
            return false;
            }
        }

        // console.log($('#amount_commission_profit').val());

        // return false; // no envia submit

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
    monto_dolares = document.getElementById("monto_dolares");
    //const log = document.getElementById("montototal");
    $('#radio1_base, #radio2_base, #radio3_base').on('click', function() {
        
        let comision_base   = $('#comision_base').val() != "" ? parseFloat($('#comision_base').val()) : 0;
        let porcentage_base = $('#percentage_base').val() != "" ? parseFloat($('#percentage_base').val()) : 0;
        let montoreal_base  = $('#monto_base').val() != "" ? parseFloat($('#monto_base').val()) : 0;

        let exonerar_base   = $('#radio1_base').is(':checked');
        let descontar_base  = $('#radio2_base').is(':checked');
        let incluir_base    = $('#radio3_base').is(':checked');

        updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
              
    });

    $('#monto_dolares, #percentage_base').on('input', function() {

        let comision_base = $('#comision_base').val() != "" ? parseFloat($('#comision_base').val()) : 0;
        
        let porcentage_base = parseFloat($('#percentage_base').val());
        let montoreal_base = parseFloat($('#monto_base').val());

        let exonerar_base = $('#radio1_base').is(':checked');
        let descontar_base = $('#radio2_base').is(':checked');
        let incluir_base = $('#radio3_base').is(':checked');

        updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);

    });

    function updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base) {
             
        let monto_dolares = parseFloat($('#monto_dolares').val());
        let amount_commission_profit    = 0;
        
        if(porcentage_base > 0){
            $('#comision_base').val((monto_dolares * (porcentage_base / 100)));
            comision_base = (monto_dolares * (porcentage_base / 100));
            //alert(comision);
        }
        
        if (comision_base == 0) {
            amount_commission_profit = 0;
        }else{
            amount_commission_profit = comision_base;
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

        $('#amount_commission_profit').val(amount_commission_profit);

    }
    



    $("#typetransaccion").on("change", function() {
        // Capturar dato seleccionado
        var selectedValue = this.value;
        var option = $("#typetransaccion option:selected").text();
        // Realizar la acción deseada en función del valor seleccionado
        if (option == 'Pago Efectivo')
        {
            $('#typetransaccion2').val(6);

        }
        else
        {
            $('#typetransaccion2').val(7);
        }
    });

    $("#wallet, #typetransaccion").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $("#wallet option:selected").text(); // Capturamos el texto del option seleccionado
        var texto2 = $("#typetransaccion option:selected").text(); //Capturamos el texto del option tipo transacción seleccionado

        $("#descripcion2").val('Recibido de  ' +texto +'/' + texto2);
    });

    $("#wallet2, #typetransaccion").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $("#wallet2 option:selected").text(); // Capturamos el texto del option seleccionado

        var texto2 = $("#typetransaccion option:selected").text(); //Capturamos el texto del option tipo transacción seleccionado

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


    $("#wallet").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado

        $("#descripcion2").val('Recibido de cliente ' +texto);
    });

    $("#wallet2").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado

        $("#descripcion").val('Entregado a cliente ' +texto);

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

            alert(JSON.stringify(data));
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

</script>



@endsection

