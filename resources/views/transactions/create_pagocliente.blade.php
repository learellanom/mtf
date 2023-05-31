@extends('adminlte::page')



@section('title', 'Transferencias entre clientes')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('TRANSFERENCIAS ENTRE CLIENTES') }}<i class="fas fa-donate"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
  <div class="card col-md-5" style="min-height:500px !important; max-height:100%; height:100%; widht:100%;">
    <div class="card-body">

      {!! Form::open(['route' => 'transactions.store_pagocliente', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data']) !!}


              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Movimiento') }}</button>
                </li>

              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form-row">

                        <div class="form-group col-md-6" >
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
                        {!! Form::text('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'monto_dolares']) !!}
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

                        {!! Form::hidden('amount_total',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}

                        {!! Form::hidden('status', 'Activo', null, ['class' => 'form-control']) !!}


                        @foreach($type_transaction as $type)
                        {!! Form::hidden('type_transaction_id', $type, null, ['class' => 'form-control transaccion']) !!}
                        @endforeach


                         @foreach($type_transaction2 as $type2)
                        {!! Form::hidden('type_transaction2_id', $type2, null, ['class' => 'form-control transaccion']) !!}
                         @endforeach


                <div class="form-group">


                        {!! Form::hidden('pay_number', $number,['class' => 'form-control', 'required' => true, 'readonly' => true]) !!}

                </div>

                <hr class="bg-dark esconder comi" style="height:1px;">
                <h4 class="text-uppercase font-weight-bold text-center esconder comi">Comisión Base  </h4>
                <div class="form-row esconder comi">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base',  'min' => 0, 'id' => 'percentage_base']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('amount_commission_base', "Monto Comisión Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_commission_base',null, ['class' => 'form-control comision_base', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto esconder comi" for="radio1_base">
                        {!! Form::radio('exonerate_base',2, null, ['id' => 'radio1_base', 'class' => 'exonerar_base']) !!}
                        Exonerar comisión base
                    </label>

                    <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                        {!! Form::radio('exonerate_base',1, null, ['id' => 'radio3_base', 'class' => 'incluir_base']) !!}
                        Incluir comisión base
                    </label>


                    <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                        Descontar comisión base
                        {!! Form::radio('exonerate_base',3, null, ['id' => 'radio2_base', 'class' => 'descontar_base']) !!}
                    </label>

                </div>
                <div class="form-group col-md">
                    {!! Form::Label('amount_total_base', "Monto total Base:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-coins mr-2"></i>
                    {!! Form::number('amount_total_base', null, ['class' => 'form-control', 'id' => 'montototal_base', 'readonly' => true ]) !!}
                    </div>
                </div>






                <hr class="bg-dark esconder comi" style="height:1px;">

                <div class="form-group">
                    {!! Form::Label('description', "Descripción:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::textarea('description',null, ['rows' => 3, 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                </div>

                {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;" , 'id' => 'publish']) !!}

                </div>


         {{--        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

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
 --}}
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
$('#monto_dolares').mask('###0.00', { reverse: true });
$('#monto').mask('###0.00', { reverse: true });
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



      $('#monto_dolares').on('input', function() {
        var input1Value = $('#monto_dolares').val();
        $('#montototal').val(input1Value);
     });

     /* OCULTAR LA CAJA SELECCIONADA */
     $('.muestra,.oculta').select2({
        'theme':'bootstrap4',
        search: false,
        allowClear: true,
        placeholder: "Selecciona la caja",
        width:'100%'
     });
     $(".muestra,.oculta").val("")
     $(".muestra,.oculta").trigger("change");

     $('.muestra').change(function() {
        const opciones = $(this).val();

        [...$('.oculta option')].forEach(o => {

        o.disabled = (opciones.includes(o.value)) ? true : false;

        });

    });

    $('.oculta').change(function() {
        const opciones = $(this).val();

        [...$('.muestra option')].forEach(o => {

        o.disabled = (opciones.includes(o.value)) ? true : false;

        });

    });
    /* OCULTAR LA CAJA SELECCIONADA */


    $('.percentage_base').keyup(function(e) { //FUNCION DE PORCENTAJE BASE

    $('#comision_base').prop('readonly', true);
    $('#montototal_base').prop('readonly', true);

    comision_base = document.getElementById("comision_base");
    porcentage_base = document.getElementById("percentage_base");
    montototal_base = document.getElementById("monto_dolares");
    montoreal_base =  document.getElementById("montototal_base");

    exonerar_base = document.getElementById("radio1_base");
    descontar_base = document.getElementById("radio2_base");
    incluir_base = document.getElementById("radio3_base");




if(porcentage_base.value > 0){
        montottotal = (montototal_base.value * porcentage_base.value / 100);
        comision_base.value =  montottotal.toFixed(2).toString();

        if(incluir_base.checked){
        montoreal_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);

        }

        if(descontar_base.checked){
            montoreal_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
        }

    }else if(is_null(porcentage_base.value)){
            if(exonerar_base.checked){
            monto_real.value = parseFloat(montototal_base.value).toFixed(2);
        }
    }

}) // CIERRE DE PORCENTAJE BASE


/* LLAMADO DE CALCULO DE COMISIONES BASE */
comision_base = document.getElementById("comision_base");
    porcentage_base = document.getElementById("percentage_base");
    montototal_base = document.getElementById("monto_dolares");
    monto_real_base = document.getElementById("montototal_base");

    exonerar_base = document.getElementById("radio1_base");
    descontar_base = document.getElementById("radio2_base");
    incluir_base = document.getElementById("radio3_base");


    exonerar_base.click = function (){

    $('#percentage_base').val("");  // LIMPIAR PORCENTAJE
    $('#comision_base').val("");  // LIMPIAR PORCENTAJE

    //$('#percentage').attr("readonly", true);
    $('#percentage_base').attr("readonly", true);
    montottotal = (montototal_base.value);
    monto_real_base.value = parseFloat(montototal_base.value).toFixed(2);

    }
    incluir_base.click = function (){
    //var selectedValue = this.value;

    $('#percentage_base').attr("required", true);
    //$('#percentage').attr("readonly", false);
    $('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);

    }
    descontar_base.click = function (){
    //$('.comi').show();
    $('#percentage_base').attr("required", true);
    $('#percentage_base').attr("readonly", false);
    //$('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
    }
/* LLAMADO DE CALCULO DE COMISIONES BASE */


$('.percentage_base').keyup(function(e) {

$('#comision_base').prop('readonly', true);


      comision_base = document.getElementById("comision_base");
      porcentage_base = document.getElementById("percentage_base");
      montototal_base = document.getElementById("monto_dolares");


          if(porcentage_base.value > 0){
              mto = (montototal_base.value * porcentage_base.value / 100);
              comision_base.value =  mto.toFixed(2);

           }

});

         /* PORCENTAJE BASE */
         $('.exonerar_base').click(function() {

        exonerar_base.click(function (){
        if(exonerar_base.click()){
            return;
        }
        })

        })

        $('.incluir_base').click(function() {

        incluir_base.click(function (){
        if(incluir_base.click()){
            return;
        }
        })

        })

        $('.descontar_base').click(function() {

        descontar_base.click(function (){
            if(descontar_base.click()){
            return;
            }
        })
        })
/* PORCENTAJE BASE */



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

