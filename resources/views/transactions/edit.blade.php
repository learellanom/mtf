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
                        {!! Form::text('percentage',null, ['class' => 'form-control percentage rateMask', 'min' => 0, 'id' => 'percentage']) !!}
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
                @else

                @endif

                <div class="form-row esconder comi">

                    @if($transactions->exchange_rate_base == NULL)
                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base rateMask',  'min' => 0, 'id' => 'percentage_base']) !!}
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
                        {!! Form::radio('exonerate_base',2, null, ['id' => 'radio1_base', 'required' => true, 'class' => 'exonerar_base']) !!}
                        Exonerar comisión base
                    </label>

                    <label class="form-check-label mx-auto esconder comi" for="radio3_base">
                        {!! Form::radio('exonerate_base',1, null, ['id' => 'radio3_base', 'required' => true, 'class' => 'incluir_base']) !!}
                        Incluir comisión base
                    </label>


                    <label class="form-check-label mx-auto esconder comi" for="radio2_base">
                        Descontar comisión base
                        {!! Form::radio('exonerate_base',3, null, ['id' => 'radio2_base', 'required' => true, 'class' => 'descontar_base']) !!}
                    </label>

                </div>
                @else
                @endif



                <hr class="bg-dark" style="height:1px;">


                        {!! Form::Label('montototal', "Monto total:") !!}
                        {!! Form::text('amount_total',null, ['class' => 'form-control montototal general font-weight-bold h1', 'required' => true, 'min' => 0, 'id' => 'montototal', 'readonly' => true]) !!}


                        {!! Form::Label('montototal', "Monto total base:") !!}
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
			//insertMode:false,
			clearIncomplete:true,
			digits: 2,
            autoClear: true,
			insertMode:true, });


       $(".rateMask").attr("minlength","5");
	   $(".rateMask").attr("maxlength","5");
	   $(".rateMask").inputmask({
			alias: 'decimal',
			allowMinus: false,
			autoUnmask:true,
			removeMaskOnSubmit:true,
			rightAlign: true,
            autoClear: true,
			groupSeparator:".",
			undoOnEscape:true,
			insertMode: true,
			clearIncomplete:true,
			digits: 2,
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


            tasa = document.getElementById("tasa");
            monto = document.getElementById("monto");

            monto_dolares = document.getElementById("monto_dolares");
            const log = document.getElementById("montototal");



            $('#tasa').on('input', function(){
                if(tasa.value > 0 && monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
                    log.value =  monto_total.toFixed(2);
                }
                else if(monto_dolares.value == NaN){
                    monto_dolares.value = 'Por favor use punto en vez de coma.'

                }else{

                    log.value = monto_dolares.toFixed(2);
                }

            });

            keyup = function(){
            if(tasa.value!="" && monto.value!=""){
                monto_total = (monto.value / tasa.value);
                monto_dolares.value =  monto_total.toFixed(2);

            }

        };



     } //CIERRE DE CONDICION QUE CALCULA TIPO DE CAMBIO
  }) //CIERRE DE .READY



        $('#tasa_base').on('input',function() { //FUNCION DE PORCENTAJE

                var dolares = $('#monto_dolares').val();

                $('#percentage').prop('required', false);
                $('#montototal').val(dolares);

                tasa_b = document.getElementById("tasa_base");
                monto_b = document.getElementById("monto_extranjera_base");
                monto = document.getElementById("monto");
                monto_dolares = document.getElementById("monto_dolares");
                comision_base = document.getElementById("comision_base");
                monto_base_comision = document.getElementById("monto_base");



            oninput = function(){
                if(tasa_b.value > 0 || monto.value > 0){

                    monto_final = (monto.value / tasa_b.value);

                    monto_b.value =  monto_final.toFixed(2);

                    comision_base.value =   (parseFloat(monto_dolares.value) - parseFloat(monto_b.value)).toFixed(2);

                    monto_base_comision.value = monto_final.toFixed(2);
                }
          }

        });



  $('.percentage').on('input', function() {

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

              }
              if(exonerar.checked){
                  montoreal.value = parseFloat(montototal.value).toFixed(2);
               }

       })

        if($("#percentage_base").length == 0) {


        }
        else{
         $('#percentage_base').on('input', function() {

        $('#comision_base').prop('readonly', true);
        $('#montototal').prop('readonly', true);

            comision_base = document.getElementById("comision_base");
            porcentage_base = document.getElementById("percentage_base");
            montototal = document.getElementById("monto_dolares");
            montoreal_base =  document.getElementById("monto_base");

            exonerar_base = document.getElementById("radio1_base");
            descontar_base = document.getElementById("radio2_base");
            incluir_base = document.getElementById("radio3_base");


                if(porcentage_base.value > 0){
                  montottotal_base = (montototal.value * porcentage_base.value / 100);
                 comision_base.value =  montottotal_base.toFixed(2);

                    if(incluir_base.checked){
                        montoreal_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);
                    }
                    else if(descontar_base.checked){
                        montoreal_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
                    }
                }
                if(exonerar_base.checked)
                {
                    montoreal_base.value = parseFloat(montototal.value).toFixed(2);
                }


          })
        }

    comision = document.getElementById("comision");
    porcentage = document.getElementById("percentage");
    montototal = document.getElementById("monto_dolares");
    monto_real = document.getElementById("montototal");

    exonerar = document.getElementById("radio1");
    descontar = document.getElementById("radio2");
    incluir = document.getElementById("radio3");

if($("#radio1").length == 0) {


}
else{
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
}

if($("#radio3").length == 0) {


}
else{
incluir.click = function (){
      //var selectedValue = this.value;

      $('#percentage').attr("required", true);
      $('#percentage').attr("readonly", false);
      $('#percentage_base').attr("readonly", false);

      monto_real.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision').val())).toFixed(2);
    }
}
if($("#radio2").length == 0) {


}
else{
    descontar.click = function (){
        //$('.comi').show();
        $('#percentage').attr("required", true);
        $('#percentage').attr("readonly", false);
        $('#percentage_base').attr("readonly", false);

        monto_real.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision').val())).toFixed(2);
    }
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


 /* LLAMADO DE CALCULO DE COMISIONES BASE */
    comision_base = document.getElementById("comision_base");
    porcentage_base = document.getElementById("percentage_base");
    montototal_base = document.getElementById("monto_dolares");
    monto_real_base = document.getElementById("monto_base");

    exonerar_base = document.getElementById("radio1_base");
    descontar_base = document.getElementById("radio2_base");
    incluir_base = document.getElementById("radio3_base");

    if($("#radio1_base").length == 0) {


    }
    else{
    exonerar_base.click = function (){

    $('#percentage_base').val("");  // LIMPIAR PORCENTAJE
    $('#comision_base').val("");  // LIMPIAR PORCENTAJE

    //$('#percentage').attr("readonly", true);
    $('#percentage_base').attr("readonly", true);
    $('#comision_base').attr("readonly", true);
    montottotal = (montototal_base.value);
    monto_real_base.value = parseFloat(montototal_base.value).toFixed(2);

    }
    }
    if($("#radio3_base").length == 0) {


    }
    else{
    incluir_base.click = function (){
    //var selectedValue = this.value;

    $('#percentage_base').attr("required", true);
    //$('#percentage').attr("readonly", false);
    $('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) + parseFloat($('#comision_base').val())).toFixed(2);

    }
    }
    if($("#radio2_base").length == 0) {


    }
    else{
    descontar_base.click = function (){
    //$('.comi').show();
    $('#percentage_base').attr("required", true);
    $('#percentage_base').attr("readonly", false);
    //$('#percentage_base').attr("readonly", false);

    monto_real_base.value = (parseFloat($('#monto_dolares').val()) - parseFloat($('#comision_base').val())).toFixed(2);
    }
    }


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
