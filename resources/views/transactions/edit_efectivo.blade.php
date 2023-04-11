@extends('adminlte::page')



@section('title', 'Transacción Efectivo')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVA TRANSACCIÓN EN EFECTIVO <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-7" style="min-height: 500px !important; max-height:1000px; height:1400px;">
  <div class="card-body">

    {!! Form::model($transactions, ['route' => ['transactions.update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data']) !!}




            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Movimiento</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Referencias</button>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}

                    <div class="form-row">
                        <div class="form-group col-md-4">
                        {!! Form::Label('type_transaction_id', "Tipo de Movimiento:") !!}
                        <div class="input-group-text col-md-12">
                            <i class="fa-fw fas fa-random"></i>
                        {!! Form::select('type_transaction_id',$type_transaction, null, ['class' => 'form-control typetrasnferencia', 'required' => true, 'id'=>'typetrasnferencia', 'readonly' => false]) !!}
                        </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('wallet_id', "Tipo de caja:") !!}
                            <div class="input-group-text col-md-12">
                                <i class="fa-fw fas fa-random"></i>
                            {!! Form::select('wallet_id', $wallet, null, ['class' => 'form-control wallet', 'required' => true, 'id'=>'wallet', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::Label('group_id', "Cliente:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                            {!! Form::select('group_id',$group, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        {!! Form::Label('type_coin_id', "Tipo de moneda:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                        {!! Form::select('type_coin_id',$type_coin, null, ['class' => 'form-control typecoin', 'required' => true, 'id' => 'typecoin', 'readonly' => false]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::Label('exchange_rate', "Tasa:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-random mr-2"></i>
                        {!! Form::number('exchange_rate',null, ['class' => 'form-control', 'required' => true, 'id' => 'tasa', 'min' => 0, 'readonly' => true]) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        {!! Form::Label('amount_foreign_currency', "Monto en moneda extranjera:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_foreign_currency',null, ['class' => 'form-control', 'required' => true, 'id' => 'monto', 'min' => 0, 'readonly' => true]) !!}
                        </div>

                    </div>

                </div>

                <div class="form-group col-md-4">
                    {!! Form::Label('amount', "Monto en dolares:") !!}
                    <div class="input-group-text">
                        <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                    {!! Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'monto_dolares', 'min' => 0, 'readonly' => true]) !!}
                    </div>
                </div>


                <h4 class="text-uppercase font-weight-bold text-center comisiones">Comisiones</h4>
                <hr class="bg-dark comisiones" style="height:1px;">

                <div class="form-row comisiones">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage', 'required' => true, 'min' => 0, 'id' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('amount_commission', "Monto Comisión:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_commission',null, ['class' => 'form-control comision', 'required' => true, 'min' => 0, 'readonly' => true, 'id' => 'comision']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-row comisiones">

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
                        {!! Form::number('amount_commission_base',null, ['class' => 'form-control comision_ganancia', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto comisiones" for="radio1">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'class' => 'exonerar', 'required' => true,]) !!}
                        Exonerar comisión
                    </label>

                    <label class="form-check-label mx-auto comisiones" for="radio3">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'class' => 'incluir','required' => true,]) !!}
                        Incluir comisión
                    </label>


                    <label class="form-check-label mx-auto comisiones" for="radio2">
                        Descontar comisión
                        {!! Form::radio('exonerate',3, null, ['id' => 'radio2', 'class' => 'descontar', 'required' => true,]) !!}
                    </label>

                </div>




                <hr class="bg-dark comisiones" style="height:1px;">


                <div class="form-row">
                    <div class="form-group col-md-6 comisiones">
                    {!! Form::Label('amount_total', "Monto Total:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_total',null, ['class' => 'form-control montototal', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}
                        </div>
                    </div>


                            <div class="form-group col-md-6">
                                {!! Form::Label('transaction_date', "Fecha:") !!}
                                <div class="input-group-text">
                                    <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                                {!! Form::date('transaction_date', null, ['class' => 'form-control', 'required' => true, 'id' => 'fecha']) !!}
                                </div>
                            </div>



                        </div>







                        {!! Form::hidden('status', 'Activo', null, ['class' => 'form-control']) !!}




        <br>

                <div class="form-group">
                    {!! Form::Label('description', "Descripción:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::textarea('description',null, ['rows' => 1, 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                </div>

                {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;" , 'id' => 'publish']) !!}

                </div>


                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <div class="form-group">
                        <div class="custom-file col-md-12">
                        {!! Form::label('file', 'Referencia:') !!}




                        {{-- {!! Form::file('file[]', ['class' => 'form-file-input clone', 'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file']) !!} --}}


                      {{-- <img id="imagenPrevisualizacion"> --}}



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


</style>
@endsection

@section('js')
<script>
$(".clientes").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
  notEmpty: false,
  allowClear: true,
  clearing: true
});


$(".typecoin").select2({
  placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true
});

$(".status").select2({
  placeholder: "Seleccionar estatus",
  theme: 'bootstrap4',
  search: false
});

$(".wallet").select2({
  placeholder: "Seleccionar Caja | Wallet",
  theme: 'bootstrap4',
  search: false,
  allowClear: true
});


$(".typetrasnferencia").select2({
  placeholder: "Seleccionar tipo de movimiento",
  theme: 'bootstrap4',
  allowClear: true
});

$(document).ready(function() {
  //$('#monto_dolares').toFixed(2);

  $('.typecoin').change(function(e) {

      $('#tasa').val(""); // LIMPIAR TASA DE CAMBIO
      $('#monto').val(""); // LIMPIAR MONTO DE MONEDA EXTRANJERA

      $('#comision').val(""); // LIMPIAR COMISION
      $('#percentage').val("");  // LIMPIAR PORCENTAJE
      $('#monto_dolares').val(""); // LIMPIAR MONTO EN DOLARES
      $('#montototal').val("");

    if ($(this).val() == 1) {
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').attr("readonly", false);

            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");


            onmousemove = function(){
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                }
        }
    }
    else if ($(this).val() == null)
    {
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').prop('readonly', true);

      $('#tasa').val("");
      $('#monto').val("");
      $('#monto_dolares').val("");

    }
    else {
        $('#tasa').prop("readonly", false);
        $('#monto').prop("readonly", false);
        $('#monto_dolares').prop('readonly', true);


            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");

            monto_dolares = document.getElementById("monto_dolares");
            const log = document.getElementById("montototal");

            onmousemove = function(){
                if(tasa.value > 0 && monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
                    log.value =  monto_total.toFixed(2);
                }
                else if(monto_dolares.value == NaN){
                    monto_dolares.value = 'Por favor use punto en vez de coma.'

                }else{
                    monto_dolares.value = 'Por favor llene el campo tasa.'
                }

            };

            onchange = function(){
            if(tasa.value!="" && monto.value!=""){
                monto_total = (monto.value / tasa.value);
                monto_dolares.value =  monto_total.toFixed(2);
            }

        };



     }
  })

  $('.percentage').change(function(e) {

      $('#comision').prop('readonly', true);
      $('#montototal').prop('readonly', true);

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");

            exonerar = document.getElementById("radio1");
            descontar = document.getElementById("radio2");
            incluir = document.getElementById("radio3");




            monto_real = document.getElementById("montototal");
            onmousemove = function(){
                if(porcentage.value > 0){
                    montottotal = (montototal.value * porcentage.value / 100);
                    comision.value =  montottotal.toFixed(2);
                 }

                }



        exonerar.click = function (){

              monto_real.value =  parseFloat(montototal.value);
        }
        incluir.click = function (){

                    montoreal = (parseFloat(montototal.value) + parseFloat(comision.value));
                    monto_real.value =  montoreal;

        }
        descontar.click = function (){

              montottotal = (parseFloat(montototal.value) - parseFloat(comision.value));
              monto_real.value = montottotal;

        }



             })

    })//CIERRE DEL READY









$('.percentage_base').change(function(e) {

$('#comision_base').prop('readonly', true);
$('#montototal').prop('readonly', true);

      comision = document.getElementById("comision_base");
      porcentage = document.getElementById("percentage_base");
      montototal = document.getElementById("monto_dolares");

      onmousemove = function(){
          if(porcentage.value > 0){
              montottotal = (montototal.value * porcentage.value / 100);
              comision.value =  montottotal.toFixed(2);

          }

       }



});


 $('.exonerar').click(function() {

      exonerar = document.getElementById("radio1");
      descontar = document.getElementById("radio2");
      incluir = document.getElementById("radio3");

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");

            monto_real = document.getElementById("montototal");

       exonerar.click(function (){
          if(exonerar.click()){
              return;

          }
       })

   })

   $('.incluir').click(function() {

    exonerar = document.getElementById("radio1");
    descontar = document.getElementById("radio2");
    incluir = document.getElementById("radio3");

        comision = document.getElementById("comision");
        porcentage = document.getElementById("percentage");
        montototal = document.getElementById("monto_dolares");

        monto_real = document.getElementById("montototal");

    incluir.click(function (){
        if(incluir.click()){
           return;

        }
      })

    })

    $('.descontar').click(function() {

        exonerar = document.getElementById("radio1");
        descontar = document.getElementById("radio2");
        incluir = document.getElementById("radio3");

            comision = document.getElementById("comision");
            porcentage = document.getElementById("percentage");
            montototal = document.getElementById("monto_dolares");

            monto_real = document.getElementById("montototal");

        descontar.click(function (){
            if(descontar.click()){
             return;

            }
        })

        })


            $("#typetrasnferencia").on("change", function() {
            // Get the selected value
            var selectedValue = this.value;

            // Perform the desired action based on the selected value
            if (selectedValue === '3') {

                $('.comisiones').hide();

                $('#radio1').attr("required", false);
                $('#radio2').attr("required", false);
                $('#radio3').attr("required", false);
                $('#percentage').attr("required", false);


                const input = document.getElementById("monto_dolares");
                const log = document.getElementById("montototal");

                input.addEventListener("input", updateValue);

                function updateValue(e) {
                log.value = e.target.value;
                }

            } else if (selectedValue === '2') {
                $('.comisiones').show();
            }
        });















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





</script>



@endsection
