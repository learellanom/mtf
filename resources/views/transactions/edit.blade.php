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
    </ul>




              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}


                                        <div class="d-flex justify-content-start">
                                            <span class="badge badge-primary text-lg text-uppercase"><h6 class="font-weight-bold text-uppercase"> Transacción numero # - {{ $transactions->id }}</h6></span>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                          <span class="badge badge-dark "><h6 class="font-weight-bold text-uppercase">Moneda| {{ $transactions->type_coin->name }} </h6></span>

                                        </div>

                    @if($transactions->type_transaction->name == 'Nota de debito' || $transactions->type_transaction->name == 'Nota de credito')



                                        <br>
                                        <h2 class="text-center font-weight-bold">NO SE PUEDEN MODIFICAR NOTAS DE DEBITO NI NOTAS DE CREDITO</h2>

                                        <button class="btn btn-danger font-weight-bold" onclick="history.back()" type="button">REGRESAR <i class="fas fa-history"></i></button>


                    @else

















                         @if($transactions->type_coin->name == 'USD')

                         <div class="form-group col">
                            {!! Form::Label('monto_dolares', "Monto en dolares:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount',null,['class' => 'form-control number general', 'required' => true, 'readonly' => true, 'min' => 0, 'id' => 'monto_dolares' ]) !!}
                                </div>
                         </div>

                         @else
                         <div class="form-group col">
                            {!! Form::Label('tasa', "Tasa:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-random mr-2"></i>
                            {!! Form::text('exchange_rate',null, ['class' => 'form-control rateMask', 'required' => true, 'id' => 'tasa']) !!}
                            </div>
                        </div>

                        <div class="form-group col">

                            {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                            {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true, 'id' => 'monto',]) !!}

                            </div>
                        </div>

                        <div class="form-group col">
                            {!! Form::Label('monto_dolares', "Monto en dolares:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fa-coins mr-2"></i>
                                {!! Form::text('amount',null,['class' => 'form-control number general', 'required' => true, 'readonly' => true, 'min' => 0, 'id' => 'monto_dolares' ]) !!}
                                </div>
                         </div>

                         @endif

                @if($transactions->exchange_rate_base == NULL)
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMasks', 'min' => 0, 'id' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('comision', "Monto Comisión:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_commission',null, ['class' => 'form-control comision general', 'required' => true, 'min' => 0, 'readonly' => true, 'id' => 'comision']) !!}
                        </div>

                    </div>
                </div>
                @else
                @endif

                @if($transactions->exchange_rate_base == NULL)
                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto" for="radio1">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'required' => true, 'class' => 'exonerar']) !!}
                        Exonerar comisión
                    </label>

                    <label class="form-check-label mx-auto" for="radio3">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'required' => true, 'class' => 'incluir']) !!}
                        Incluir comisión
                    </label>

        <hr>

                    <label class="form-check-label mx-auto" for="radio2">
                        Descontar comisión
                        {!! Form::radio('exonerate',3, null, ['id' => 'radio2', 'required' => true, 'class' => 'descontar']) !!}
                    </label>

                </div>
                @else

                @endif

                <div class="form-row esconder comi">

                    @if($transactions->exchange_rate_base == NULL)
                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base rateMasks',  'min' => 0, 'id' => 'percentage_base']) !!}
                        </div>
                    </div>

                    @else
                    <div class="form-group col-md-6">
                        {!! Form::Label('tasa_base', "Tasa base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('exchange_rate_base',null, ['class' => 'form-control percentage_base rateMask', 'id' => 'tasa_base']) !!}
                        </div>
                    </div>
                    {!! Form::hidden('amount_base',null, ['class' => 'form-control comision_base', 'min' => 0, 'readonly' => true, 'id' => 'monto_extranjera_base']) !!}
                    @endif

                    <div class="form-group col-md-6">

                        {!! Form::Label('comision_base', "Monto Comisión Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::text('amount_commission_base',null, ['class' => 'form-control comision_base general', 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>
                @if($transactions->exchange_rate_base == NULL)

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
                @else
                @endif



                <hr class="bg-dark" style="height:1px;">


                        {!! Form::Label('montototal', "Monto total:") !!}
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general font-weight-bold h1', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}


                        {!! Form::Label('monto_base', "Monto total base:") !!}
                        {!! Form::text('amount_total_base',null, ['class' => 'form-control montototal general font-weight-bold', 'required' => true, 'min' => 0, 'id' => 'monto_base', 'readonly' => true]) !!}


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
@endif

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
        $('#monto_base').val(input1Value);
     });
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
			insertMode:true, });


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


$(document).ready(function() {

    if ($(this).val() == 1) {
      $('#tasa').attr("readonly", true);
      $('#monto').attr("readonly", true);
      $('#monto_dolares').attr("readonly", false);

            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");
            monto_dolares = document.getElementById("monto_dolares");
            //const log = document.getElementById("montototal");

            oninput = function(){
                if(tasa.value == null && monto.value == null){
                    monto_total = monto_dolares;
                    monto_dolares.value =  monto_total.toFixed(2);
                    //log.value =  monto_total.toFixed(2);
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


                            $('#tasa, #monto, #percentage').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let monto = parseFloat($('#monto').val());


                                let comision = parseFloat($('#comision').val());
                                let porcentage = parseFloat($('#percentage').val());
                                let montoreal = parseFloat($('#montototal').val());

                                let exonerar = $('#radio1').is(':checked');
                                //alert(exonerar)
                                let descontar = $('#radio2').is(':checked');
                                let incluir = $('#radio3').is(':checked');
                                //alert(incluir)
                                if(tasa > 0 && monto > 0) {
                                    let monto_total = (monto / tasa).toFixed(2);
                                    $('#monto_dolares').val(monto_total);
                                }


                                updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);
                                });

                              $('#radio1, #radio2, #radio3').on('click', function() {
                                let comision = parseFloat($('#comision').val());
                                let porcentage = parseFloat($('#percentage').val());
                                let montoreal = parseFloat($('#montototal').val());

                                let exonerar = $('#radio1').is(':checked');
                                let descontar = $('#radio2').is(':checked');
                                let incluir = $('#radio3').is(':checked');
                                updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal);
                              });


                                function updateMontoreal(exonerar, descontar, incluir, comision, porcentage, montoreal) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());


                                if(porcentage > 0){
                                        $('#comision').val((monto_dolares * (porcentage / 100)).toFixed(2));
                                        comision = (monto_dolares * (porcentage / 100));
                                        //alert(comision);
                                }


                                if(!exonerar) {
                                        if(incluir) {
                                            $('#montototal').val((monto_dolares + comision).toFixed(2));

                                        } else if(descontar) {
                                            $('#montototal').val((monto_dolares - comision).toFixed(2));
                                        }
                                    }
                                else {
                                          $('#montototal').val(monto_dolares.toFixed(2));
                                     }


                              }


                            /* PORCENTAJE BASE */
                              $('#tasa, #monto, #percentage_base').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let monto = parseFloat($('#monto').val());

                                if(tasa > 0 && monto > 0) {
                                    let monto_total = (monto / tasa).toFixed(2);
                                    $('#monto_dolares').val(monto_total);
                                }

                                let comision_base = parseFloat($('#comision_base').val());
                                let porcentage_base = parseFloat($('#percentage_base').val());
                                let montoreal_base = parseFloat($('#monto_base').val());

                                let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                                let descontar_base = $('#radio2_base').is(':checked');
                                let incluir_base = $('#radio3_base').is(':checked');
                                //alert(incluir)

                                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
                                });

                              $('#radio1_base, #radio2_base, #radio3_base').on('click', function() {
                                let comision_base = parseFloat($('#comision_base').val());
                                let porcentage_base = parseFloat($('#percentage_base').val());
                                let montoreal_base = parseFloat($('#monto_base').val());

                                let exonerar_base = $('#radio1_base').is(':checked');
                                //alert(exonerar)
                                let descontar_base = $('#radio2_base').is(':checked');
                                let incluir_base = $('#radio3_base').is(':checked');

                                updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base);
                              });


                                function updateMontorealBase(exonerar_base, descontar_base, incluir_base, comision_base, porcentage_base, montoreal_base) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(porcentage_base > 0){
                                   $('#comision_base').val((monto_dolares * (porcentage_base / 100)).toFixed(2));
                                    comision_base = (monto_dolares * (porcentage_base / 100));
                                    //alert(comision);
                                }


                                if(!exonerar_base) {
                                    if(incluir_base) {
                                    $('#monto_base').val((monto_dolares + comision_base).toFixed(2));
                                    //alert(montoreal);

                                    } else if(descontar_base) {
                                    $('#monto_base').val((monto_dolares - comision_base).toFixed(2));
                                    }
                                }
                                else {
                                    $('#monto_base').val(monto_dolares.toFixed(2));
                                 }
                              }

                                /* TASA BASE */
                                $('#tasa, #monto, #tasa_base').on('input', function() {
                                let tasa = parseFloat($('#tasa').val());
                                let tasa_base = parseFloat($('#tasa_base').val());
                                let monto = parseFloat($('#monto').val());
                                let monto_b = parseFloat($('#monto_extranjera_base').val());

                                //$('#montototal').val($('#monto_dolares').val());

                                if(tasa_base > 0 && monto > 0){

                                    $('#monto_extranjera_base').val(parseFloat($('#monto').val()) / parseFloat($('#tasa_base').val()));

                                    $('#monto_base').val(parseFloat($('#monto').val()) / parseFloat($('#tasa_base').val()));
                                }

                                let comision_base = parseFloat($('#comision_base').val());
                                let montoreal_base = parseFloat($('#monto_base').val());


                                updateTasaBase(comision_base, tasa_base, montoreal_base);
                                });


                                function updateTasaBase(comision_base, tasa_base, montoreal_base) {
                                let monto_dolares = parseFloat($('#monto_dolares').val());

                                if(tasa_base > 0){
                                   $('#comision_base').val(parseFloat($('#monto_dolares').val()) - parseFloat($('#monto_extranjera_base').val()));
                                }

                              }




                         } //ELSE

                });





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
