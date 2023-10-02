@extends('adminlte::page')
@section('title', 'Transacciones')
@section('content_header')

<h1 class="text-center text-dark font-weight-bold">MODIFICAR TASA|COMISIÓN<i class="fas fa-coins"></i> </h1></a>

@stop


@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-6" style="min-height:400px; !important; max-height:100%; height:100%; widht:100%">
        <div class="card-body">

            {!! Form::model($transactions, ['route' => ['transactions.update', $transactions],'method' => 'put', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data', 'id' => 'myForm']) !!}
            <div class="row">
                <div class="col-md-4">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button 
                                class="nav-link active" 
                                id="pills-home-tab" 
                                data-toggle="pill" 
                                data-target="#pills-home" 
                                type="button" 
                                role="tab" 
                                aria-controls="pills-home" 
                                aria-selected="true">
                                Movimiento
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" 
                                id="pills-profile-tab" 
                                data-toggle="pill" 
                                data-target="#pills-profile" 
                                type="button" 
                                role="tab" 
                                aria-controls="pills-profile" 
                                aria-selected="false">
                                Referencias
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 justify-content-start float-right">
                    <span class="badge badge-primary text-lg text-uppercase">
                        <h6 class="font-weight-bold text-uppercase"> Transacción numero # - {{ $transactions->id }}</h6>
                    </span>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    {!! Form::hidden('user_id',auth()->id(), null, ['class' => 'form-control', 'required' => true]) !!}


                    {{--
                    <div class="d-flex justify-content-end">
                        <span class="badge badge-dark "><h6 class="font-weight-bold text-uppercase">Moneda| {{ $transactions->type_coin->name }} </h6></span>
                    </div>
                    --}}
                    @if($transactions->type_transaction->name == 'Nota de debito' || $transactions->type_transaction->name == 'Nota de credito')

                        <br>
                        <h2 class="text-center font-weight-bold">NO SE PUEDEN MODIFICAR NOTAS DE DEBITO NI NOTAS DE CREDITO</h2>

                        <button class="btn btn-danger font-weight-bold" onclick="history.back()" type="button">
                          REGRESAR 
                          <i class="fas fa-history"></i>
                        </button>

                    @else
                      
                        <style>
                            .myStyle { background-color: #e9ecef; color: #495057; font-weight: 400 !important; height: 50px;}
                        </style>
                        <div class="form-row">
                            <div class="form-group col">

                                {!! Form::label('$transactionstype_transaction_name', 'Transaccion: '); !!}
                                {!! Form::label('$transactionstype_transaction_name', $transactions->type_transaction_name, ['class' => 'form-control myStyle']); !!}

                            </div>
                            <div class="form-group col">

                                {!! Form::label('wallet_name', 'Caja: '); !!}
                                {!! Form::label('wallet_name', $transactions->wallet_name, ['class' => 'form-control myStyle']); !!}

                            </div>
                            <div class="form-group col">

                                {!! Form::label('group_name', 'Grupo: '); !!}
                                {!! Form::label('group_name', $transactions->group_name, ['class' => 'form-control myStyle']); !!}

                            </div>
                                                 
                        </div>

                        <div class="row">
                            <div class="form-group col">

                            {!! Form::label('Tipo de Moneda', 'Tipo de Moneda: '); !!}
                            {!! Form::label('', $transactions->type_coin_name, ['class' => 'form-control myStyle']); !!}

                            </div>
                            @php
                              $myReadOnly         = false;
                              $myReadOnlyAmount   = true;
                              if ($transactions->type_coin->name == 'USD') {
                                  $myReadOnly       = true;
                                  $myReadOnlyAmount = true;
                              }
                            @endphp

                            {{-- Tasa de cambio --}}

                            @if(!$myReadOnly) 
                              <div class="form-group col">
                                  {!! Form::Label('tasa', "Tasa:") !!}
                                  <div class="input-group-text">
                                      <i class="fa-fw fas fa-random mr-2"></i>
                                      {!! Form::text('exchange_rate',null, ['class' => 'rateMasks form-control', 'required' => true, 'id' => 'tasa',]) !!}
                                  </div>
                              </div>
                            @else 
                              <div class="form-group col">
                                  {!! Form::Label('tasa', "Tasa:") !!}
                                  <div class="input-group-text">
                                      <i class="fa-fw fas fa-random mr-2"></i>
                                      {!! Form::text('exchange_rate',null, ['class' => 'rateMasks form-control', 'required' => true, 'readonly']) !!}
                                  </div>
                              </div>                                                     
                            @endif

                            {{-- Monto en moneda extranjera --}}
                            
                            @if(!$myReadOnly) 
                                <div class="form-group col">
                                    {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-coins mr-2"></i>
                                        {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true,  'id' => 'monto']) !!}
                                    </div>
                                </div>
                            @else
                                <div class="form-group col">
                                    {!! Form::Label('monto', "Monto en moneda extranjera:") !!}
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-coins mr-2"></i>
                                        {!! Form::text('amount_foreign_currency',null, ['class' => 'form-control general', 'required' => true,  'readonly']) !!}
                                    </div>
                                </div>                            
                            @endif
                        </div>

                        {{-- Monto --}}
                         
                        <div class="form-row">
                            @if(!$myReadOnlyAmount) 
                                
                                <div class="form-group col-md-4">
                                    {!! Form::Label('', "Monto en dolares:") !!} 
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-coins mr-2"></i>
                                       
                                        {!! Form::text('amount',null, ['class' => 'form-control general numeric', 'required', 'min' => 0, 'id' => 'my_monto_dorales']) !!}
                                    </div>
                                </div>
                            @else
                            
                                <div class="form-group col-md-4">
                                    {!! Form::Label('', "Monto en dolares:") !!} 
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-coins mr-2"></i>
                                        {!! Form::text('amount',null, ['class' => 'form-control general', 'required', 'readonly', 'min' => 0, 'id' => 'my_monto_dorales']) !!}
                                    </div>
                                </div>

                            @endif
                            <div class="form-group col-md-4">

                                {!! Form::label('transaction_date', 'Fecha: '); !!}
                                {!! Form::label('', date_format( date_create($transactions->transaction_date) , "d/m/Y H:i:s"), ['class' => 'form-control myStyle']); !!}

                            </div>   
                        </div>   


                        


                        @if($transactions->exchange_rate_base == NULL)
                            <br>
                            <div class="form-row">


                                {{-- Porcentaje --}}

                                
                                <div class="form-group col-md-6">
                                     {!! Form::Label('percentage', "Porcentaje:") !!} 
                                    {{-- <label>uno</label> --}}
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-percentage mr-2"></i>
                                        <!-- aqui -->
                                         {!! Form::text('percentage',null, ['class' => 'form-control  rateMasks', 'min' => 0]) !!}
                                         
                                         {{-- <input class="form-control  rateMasks" min="0" name="percentage" type="text" value="0" id="" minlength="8" inputmode="decimal" style="text-align: right;"> --}}
                                    </div>

                                </div>

                                <div class="form-group col-md-6">


                                    {{-- Comision --}}


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
                                  {!! Form::Label('', "Porcentaje Base:") !!}
                                  <div class="input-group-text">
                                      <i class="fa-fw fas fa-percentage mr-2"></i>                                                                     
                                      <!-- aqui -->
                                    {!! Form::text('percentage_base',null, ['class' => 'form-control percentage general rateMasks', 'id' => 'percentage_base']) !!}
                                    
                                  </div>
                              </div>
                            @else
                                <div class="form-group col-md-6">
                                    {!! Form::Label('tasa_base', "Tasa base:") !!}
                                    <div class="input-group-text">
                                        <i class="fa-fw fas fa-percentage mr-2"></i>
                                        {!! Form::text('exchange_rate_base',null, ['class' => 'form-control percentage_base rateMasks', 'id' => 'tasa_base']) !!}
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
                        <br>
                        <div class="form-group form-row">
                            <div class="input-group-text">
                                {!! Form::Label('description', "Descripcion:") !!}
                                {!! Form::text('description',null, ['class' => 'form-control', 'required' => false, 'id' => 'description', 'readonly' => false]) !!}
                            </div>
                        </div>

                        <br>

                        {!! Form::hidden('status', null, ['class' => 'form-control', 'value' => 'Activo']) !!}

                        {!! Form::hidden('amount_base',null, ['class' => 'form-control', 'id' => 'amount_base']) !!}

                        {!! Form::hidden('amount_commission_profit', null,  ['class' => 'form-control', 'id' => 'amount_commission_profit']) !!}


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
        // alert(" " + {{ $transactions->type_transaction_id}});
        if ({{ $transactions->type_coin_id}} == 1) {
            
            $('#tasa').attr("readonly", true);
            $('#monto').attr("readonly", true);
            $('#my_monto_dorales').attr("readonly", false);

        }
        else {
            
            $('#tasa').prop("readonly", false);
            $('#monto').prop("readonly", false);
            $('#monto_dolares').prop('readonly', true);

        }
        $('#myForm').on('input', function (){
            // alert('cambio');
            calcula();
        });        
    
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

            // alert(JSON.stringify(data));
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


    function calcula(){
        // alert('calcula ----');

        let type_coin_id                = {{ $transactions->type_coin_id}} ;
        let exchange_rate               = $('#tasa').val()              != "" ? parseFloat($('#tasa').val())                : 0;
        let amount_foreign_currency     = $('#monto').val()             != "" ? parseFloat($('#monto').val())               : 0;  // amount_foreign_currency - monto moneda extranjera
        let amount                      = $('#my_monto_dorales').val()  != "" ? parseFloat($('#my_monto_dorales').val())    : 0;

        let percentage                  = $('#percentage').val()        != "" ? parseFloat($('#percentage').val())          : 0;
        //    percentage                  = $('#mipercentage').val()        != "" ? parseFloat($('#mipercentage').val())          : 0;
        let percentage_base             = $('#percentage_base').val()   != "" ? parseFloat($('#percentage_base').val())     : 0;
        console.log('Porcentaje base : ' + percentage_base);
        let exchange_rate_base          = $('#tasa_base').val()         != "" ? parseFloat($('#tasa_base').val())           : 0;
        console.log('Porcentaje base : ' + exchange_rate_base);

        let exonerar                    = $('#radio1').is(':checked');
        let descontar                   = $('#radio2').is(':checked');
        let incluir                     = $('#radio3').is(':checked');

        let exonerar_base               = $('#radio1_base').is(':checked');
        let descontar_base              = $('#radio2_base').is(':checked');
        let incluir_base                = $('#radio3_base').is(':checked');   

        let amount_base                 = 0 ; 

        let amount_commission           = 0;        
        let amount_commission_base      = 0; 

        let amount_total                = 0;
        let amount_total_base           = 0;

        let amount_commission_profit    = 0;

         // alert('mi monto ->' + amount + ' type ' + {{ $transactions->type_coin_id}});
        // 1 incluir
        // 2 exonerar
        // 3 descontar

        //
        // si la transaccion no es en dorales recalcula el amount
        //
        if (type_coin_id != 1) {
            
            amount = amount_foreign_currency / exchange_rate;

        }
        //
        // determina el tipo de comision
        //
        let myTypeCommission = 1;

        if (percentage > 0 || percentage_base > 0){
            myTypeCommission = 1;
        }else{
            if (exchange_rate_base > 0){
                myTypeCommission = 2;
            }
        }
        console.log('myTypeCommission ' + myTypeCommission);
        //
        //
        //
        if (myTypeCommission == 1){
            //
            // Comision por porcentaje
            //
            console.log('porcentaje por comision');
            if (percentage > 0){
                amount_commission           = (amount * percentage ) / 100;
                amount_total                = amount + amount_commission;

                amount_commission_base      = (amount * percentage_base ) / 100;
                amount_commission_profit    = amount_commission - amount_commission_base;
            }else{
                amount_commission           = 0;
                amount_total                = amount + amount_commission;    
                
                  
                amount_commission_base      = (amount * percentage_base ) / 100;
                amount_commission_profit    = amount_commission - amount_commission_base;                
            }

            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission = 0;
            

            if (incluir) {
                myCommission = 1;
            }else if(exonerar) {
                myCommission = 2;
            }else{
                myCommission = 3;
            }

            
                switch(myCommission){
                    case 1: // incluir
                        amount_total = amount + amount_commission;
                        break;
                    case 2: // exonerar
                        amount_total = amount;
                        break;
                    case 3: // descontar
                        amount_total = amount - amount_commission;
                        break;
                    default:
                        break;
                }

            if (percentage_base > 0){
                amount_base                 = amount;
                amount_commission_base      = (amount * percentage_base ) / 100;
                amount_total_base           = amount + amount_commission_base;
                amount_commission_profit    = amount_commission - amount_commission_base;
            }else{
                amount_base                 = amount;
                amount_commission_base      = 0;
                amount_total_base           = amount;            
                amount_commission_profit    = amount_commission;
            }



            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission_base = 0;

            if (incluir_base) {
                myCommission_base = 1;
            }else if(exonerar_base) {
                myCommission_base = 2;
            }else{
                myCommission_base = 3;
            }

            switch(myCommission_base){
                case 1:
                    amount_total_base = amount_base + amount_commission_base;
                    break;
                case 2:
                    amount_total_base = amount_base;
                    break;
                case 3:
                    amount_total_base = amount_base - amount_commission_base;
                    break;
                default:
                    amount_total_base = amount_base;
                    break;
            }

             // exchange_rate = 0;
             // exchange_rate_base = 0;
        }




        if (myTypeCommission == 2){
            //
            // comision tasa
            //
            if (exchange_rate_base > 0){
                amount_base                 = amount_foreign_currency / exchange_rate_base;
                amount_commission_base      = 0;
                amount_total_base           = amount_base;
                amount_commission_profit    = amount - amount_base;    
            }else{
                amount_base                 = amount;
                amount_total_base           = amount;
                amount_commission_profit    = 0;
            }

            console.log('pasa');
                    amount_total = amount;

                    
            // 1 incluir
            // 2 exonerar
            // 3 descontar

            let myCommission_base = 0;

            if (incluir_base) {
                myCommission_base = 1;
            }else if(exonerar_base) {
                myCommission_base = 2;
            }else{
                myCommission_base = 3;
            }

            switch(myCommission_base){
                case 1:
                    amount_total_base = amount_base + amount_commission_base;
                    break;
                case 2:
                    amount_total_base = amount_base;
                    break;
                case 3:
                    amount_total_base = amount_base - amount_commission_base;
                    break;
                default:
                    amount_total_base = amount_base;
                    break;
            }

             percentage_base          = 0;
             percentage               = 0;
             amount_commission        = 0;
             amount_commission_base   = 0;
        }
        

        $('#my_monto_dorales').val(amount);
        $('#amount_base').val(amount_base);
        $('#comision').val(amount_commission);
        $('#comision_base').val(amount_commission_base);
        $('#montototal').val(amount_total);
        $('#monto_base').val(amount_total_base);
        $('#amount_commission_profit').val(amount_commission_profit);

         $('#tasa').val(exchange_rate);
         $('#tasa_base').val(exchange_rate_base );

         $('#percentage').val(percentage);
         $('#percentage_base').val(percentage_base);

        // alert('amount commission ->' + amount_commission_profit);

    }

</script>



@endsection
