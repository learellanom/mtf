@extends('adminlte::page')



@section('title', 'Transacciones')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR TASA|COMISIÓN <i class="fas fa-coins"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-6" style="min-height:400px; !important; max-height:100%; height:100%; widht:100%">
  <div class="card-body">


    {!! Form::model($transactions, ['route' => ['transactions.update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data']) !!}



      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Movimiento</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Referencias</button>
        </li>
        <span class="badge badge-primary text-lg text-uppercase">Transacción numero # - {{ $transactions->id }}</span>
      </ul>



              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}







                   {{--      <div class="form-group col-md-4">
                            {!! Form::Label('exchange_rate', "Tasa:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate',null, ['class' => 'form-control rateMask', 'required' => true, 'id' => 'tasa']) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            {!! Form::Label('amount_foreign_currency', "Monto en moneda extranjera:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto',]) !!}

                            </div>
                        </div> --}}



                            {!! Form::hidden('amount',null,['class' => 'form-control number general', 'required' => true, 'min' => 0, 'id' => 'monto_dolares' ]) !!}




                <br>
                <div class="form-row">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMask', 'min' => 0, 'id' => 'percentage']) !!}
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


                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto" for="radio1">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'name'=>'optradio', 'class' => 'exonerar']) !!}
                        Exonerar comisión
                    </label>

                    <label class="form-check-label mx-auto" for="radio3">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'name'=>'optradio', 'class' => 'incluir']) !!}
                        Incluir comisión
                    </label>

        <hr>

                    <label class="form-check-label mx-auto" for="radio2">
                        Descontar comisión
                        {!! Form::radio('discount',3, null, ['id' => 'radio2', 'name'=>'optradio', 'class' => 'descontar']) !!}
                    </label>

                </div>




                <hr class="bg-dark" style="height:1px;">


                        {!! Form::Label('montototal', "Monto total:") !!}
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general font-weight-bold h1', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}
                        {!! Form::hidden('amount_total_base',null, ['class' => 'form-control montototal general', 'required' => true, 'min' => 0, 'id' => 'monto_base', 'readonly' => true]) !!}


                    <br>



                        {!! Form::hidden('status', null, ['class' => 'form-control', 'value' => 'Activo']) !!}



                {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 300px;" , 'id' => 'publish']) !!}

            </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <div class="form-group">
                        <div class="custom-file col-md-12">
                        {!! Form::label('file', 'Referencia:') !!}








                      <div class="file-loading">
                    @foreach($imagen as $image)
                        @if($image->url == null)
                        {!! Form::file('file[]', ['class' => 'form-file-input file',  'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file_old', 'data-allowed-file-extensions' => '["pdf","jpg","jpeg","png","gif"]']) !!}
                         @else
                        {!! Form::file('file[]', ['class' => 'form-file-input file',  'value' => '$image->url',  'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file', 'data-allowed-file-extensions' => '["pdf","jpg","jpeg","png","gif"]']) !!}
                        @endif
                      @endforeach


                        {!! Form::file('file[]', ['class' => 'form-file-input file',  'value' => '$image->url',  'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file', 'data-allowed-file-extensions' => '["pdf","jpg","jpeg","png","gif"]']) !!}



                      </div>

                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror


                        </div>
                    </div>



                    {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold', 'style' => "max-height: 400px;" , 'id' => 'publish']) !!}

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


$('#monto_dolares').on('input', function() {
        var input1Value = $('#monto_dolares').val();
        $('#montototal').val(input1Value);
        $('#montototal_base').val(input1Value);
     });


$('.general').inputmask({
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
            autoClear: true,
			insertMode:true, });


       $(".rateMask").attr("minlength","5");
	   $(".rateMask").attr("maxlength","5");
	   $(".rateMask").inputmask({
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
			digits: 2,
			insertMode:true,
		});


$(".clientes").select2({
  placeholder: "Seleccionar cliente",
  theme: 'bootstrap4',
  notEmpty: false,
  allowClear: true,
  clearing: true,
  width: '100%'
});
//$("#clientes").val("")
//$("#clientes").trigger("change");

$(".typecoin").select2({
  //placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true,
  width: '100%'
});
//$("#typecoin").val("")
//$("#typecoin").trigger("change");

$(".status").select2({
  placeholder: "Seleccionar estatus",
  theme: 'bootstrap4',
  search: false,

});

$(".wallet").select2({
  placeholder: "Seleccionar Caja | Wallet",
  theme: 'bootstrap4',
  search: false,
  allowClear: true,
  width: '100%'
});
//$("#wallet").val("")
//$("#wallet").trigger("change");

$(".typetrasnferencia").select2({
  placeholder: "Seleccionar tipo de movimiento",
  theme: 'bootstrap4',
  allowClear: true,
  width: '100%'
});
//$("#typetrasnferencia").val("")
//$("#typetrasnferencia").trigger("change");

  $('.percentage').keyup(function(e) {

    $('#comision').prop('readonly', true);
    $('#montototal').prop('readonly', true);

      comision = document.getElementById("comision");
      porcentage = document.getElementById("percentage");
      montototal = document.getElementById("monto_dolares");
      montoreal =  document.getElementById("montototal");

      exonerar = document.getElementById("radio1");
      descontar = document.getElementById("radio2");
      incluir = document.getElementById("radio3");




          if(porcentage.value > 0){
              montottotal = (montototal.value * porcentage.value / 100);
              comision.value =  montottotal.toFixed(2).toString();

               if(incluir.checked){
                  montoreal.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);
               }
               else if(descontar.checked){
                  montoreal.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
               }
               else if(exonerar.checked){
                  monto_real.value = parseFloat(montototal.value).toFixed(2);
               }
              }

       })


         $('.percentage_base').on('input', function() {

        $('#comision_base').prop('readonly', true);
        $('#montototal').prop('readonly', true);

            comision = document.getElementById("comision_base");
            porcentage = document.getElementById("percentage_base");
            montototal = document.getElementById("monto_dolares");

            //monto_real = document.getElementById("comision_base");

            onkeyup = function(){
                if(porcentage.value > 0){
                    montottotal = (montototal.value * porcentage.value / 100);
                    comision.value =  montottotal.toFixed(2);

                }

            }

        })

comision = document.getElementById("comision");
    porcentage = document.getElementById("percentage");
    montototal = document.getElementById("monto_dolares");
    monto_real = document.getElementById("montototal");

    exonerar = document.getElementById("radio1");
    descontar = document.getElementById("radio2");
    incluir = document.getElementById("radio3");


exonerar.click = function (){

    $('#comision').val(""); // LIMPIAR COMISION
    $('#percentage').val("");  // LIMPIAR PORCENTAJE
    $('#percentage_base').val("");  // LIMPIAR PORCENTAJE
    $('#comision_base').val("");  // LIMPIAR PORCENTAJE

    $('#percentage').attr("readonly", true);
    $('#percentage_base').attr("readonly", true);
    montottotal = (montototal.value);
    monto_real.value = parseFloat(montototal.value).toFixed(2);

}
incluir.click = function (){
      //var selectedValue = this.value;

      $('#percentage').attr("required", true);
      $('#percentage').attr("readonly", false);
      $('#percentage_base').attr("readonly", false);

      monto_real.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);

}
descontar.click = function (){
    //$('.comi').show();
    $('#percentage').attr("required", true);
    $('#percentage').attr("readonly", false);
    $('#percentage_base').attr("readonly", false);

    monto_real.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
}



$('.exonerar').click(function() {

exonerar.click(function (){
   if(exonerar.click()){
       return;
   }
})

})

$('.incluir').click(function() {

incluir.click(function (){
 if(incluir.click()){
    return;
 }
})

})

$('.descontar').click(function() {

 descontar.click(function (){
     if(descontar.click()){
      return;
     }
 })
})








     $("#file").fileinput({

        uploadUrl: '{{ route('transactions.update', $transactions) }}'
        , language: 'es'
        , showUpload: false
        , showRemove: false
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
        , deleteExtraData:{'_token': "{{csrf_token()}}",'_method':'delete'}
        , initialPreview: [

                @foreach($imagen as $img)

                    "{{asset('../storage/app/'.$img->url)}}",

                @endforeach

        ]
        ,initialPreviewAsData: true
        ,initialPreviewFileType: 'image'
        ,initialPreviewConfig: [
                @foreach($imagen as $img)
                    {url: "{{ url('movimientos/eliminar',$img->id) }}" },

                @endforeach
        ]
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
    $('#file').val('');

});

$('#file').on('filepredelete',  function(jqXHR) {

/*     var abort = true;
    if (confirm("¿Está seguro de que desea eliminar esta imagen?")) {
        abort = false;
    }
    return abort; */

});

$("#file_old").fileinput({

uploadUrl: '{{ route('transactions.update', $transactions) }}'
, language: 'es'
, showUpload: false
, showRemove: false
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

});



</script>



@endsection
