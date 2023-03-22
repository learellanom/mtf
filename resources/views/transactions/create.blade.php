@extends('adminlte::page')

@section('title', 'Movimientos')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO MOVIMIENTO <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-6" style="min-height: 800px !important;">
  <div class="card-body">

    {!! Form::open(['route' => 'transactions.store', 'autocomplete' => 'off', 'files' => true, 'enctype' =>'multipart/form-data']) !!}




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
                            {!! Form::Label('client_id', "Cliente:") !!}
                            <div class="input-group-text">
                                <i class="fa-fw fas fas fa-user-friends mr-2"></i>
                            {!! Form::select('client_id',$client, null,['class' => 'form-control clientes', 'required' => true, 'id' => 'clientes', 'readonly' => false]) !!}
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





                <div class="form-row">

                    <div class="form-group col-md-4">
                        {!! Form::Label('amount', "Monto en dolares:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fas fa-funnel-dollar mr-2"></i>
                        {!! Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'monto_dolares', 'min' => 0, 'readonly' => true]) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::Label('percentage', "Porcentaje:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::number('percentage',null, ['class' => 'form-control percentage', 'required' => true, 'min' => 0, 'id' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        {!! Form::Label('amount_commission', "Monto Comisión:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_commission',null, ['class' => 'form-control comision', 'required' => true, 'min' => 0, 'readonly' => true, 'id' => 'comision']) !!}
                        </div>

                    </div>
                </div>

        <hr>
                <div class="form-group col-md-12 d-flex justify-content-center">

                        <label class="form-check-label mx-auto" for="radio1">
                            {!! Form::radio('exonerate',false, null, ['id' => 'radio1', 'name'=>'optradio']) !!}
                            Exonerar comisión
                        </label>

                        <label class="form-check-label mx-auto" for="radio3">
                            {!! Form::radio('exonerate',true, null, ['id' => 'radio3', 'name'=>'optradio']) !!}
                            Incluir comisión
                        </label>


                        <label class="form-check-label mx-auto" for="radio2">
                            Descontar comisión
                            {!! Form::radio('discount',true, null, ['id' => 'radio2', 'name'=>'optradio']) !!}
                        </label>

                </div>
                <hr>


                <div class="form-row">
                    <div class="form-group col-md-6">
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







                        {!! Form::hidden('status', null, ['class' => 'form-control', 'value' => 'Activo']) !!}




        <br>

                <div class="form-group">
                    {!! Form::Label('description', "Descripción:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-text-width mr-2"></i>
                        {!! Form::textarea('description',null, ['rows' => 1, 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                </div>



                </div>


                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <div class="form-group">
                        <div class="custom-file col-md-12">
                        {!! Form::label('file', 'Referencia:') !!}

                      <div class="input-group-text content-icon-camera">
                        <i class="fa-fw fas fa-file-image mr-2"></i>
                        {!! Form::file('file[]', ['class' => 'form-file-input clone', 'accept' => 'image/*', 'multiple' => 'multiple', 'id' => 'file']) !!}

                    </div>



                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror

                    <div class="card">
                    <div class="card-header" id="preview-images" style="max-height: 400px;">
                        {{-- @foreach($transaction->image as $imagen) --}}
                            <div class="image-wrapper" style="max-height: 400px;">
                                 {{-- <img id="random" src="/MTF/public/storage/image/interrogacion.jpg" style="height:50px; width:50px;"> --}}

                            </div>



                        {{-- @endforeach --}}
                      </div>
                    </div>


                    </div>


                </div>

              </div>




                {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

                {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection


@section('css')

<style>

.image-wrapper{
position: relative !important;
padding-bottom: 56.25%;
}
.image-wrapper img{
position: absolute;
object-fit: cover;
width: 300%;
height: 300%;

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
$("#clientes").val("")
$("#clientes").trigger("change");

$(".typecoin").select2({
  placeholder: "Seleccionar Moneda",
  theme: 'bootstrap4',
  allowClear: true
});
$("#typecoin").val("")
$("#typecoin").trigger("change");

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
$("#wallet").val("")
$("#wallet").trigger("change");

$(".typetrasnferencia").select2({
  placeholder: "Seleccionar tipo de movimiento",
  theme: 'bootstrap4',
  allowClear: true
});
$("#typetrasnferencia").val("")
$("#typetrasnferencia").trigger("change");

$(document).ready(function() {
  //$('#monto_dolares').toFixed(2);

  $('.typecoin').change(function(e) {

      $('#tasa').val(""); // LIMPIAR TASA DE CAMBIO
      $('#monto').val(""); // LIMPIAR MONTO DE MONEDA EXTRANJERA

      $('#comision').val(""); // LIMPIAR COMISION
      $('#percentage').val("");  // LIMPIAR PORCENTAJE
      $('#monto_dolares').val(""); // LIMPIAR MONTO EN DOLARES

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


            onmousemove = function(){
                if(tasa.value > 0 && monto.value > 0){
                    monto_total = (monto.value / tasa.value);
                    monto_dolares.value =  monto_total.toFixed(2);
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

            monto_real = document.getElementById("montototal");
            onmousemove = function(){
                if(porcentage.value > 0){
                    montottotal = (montototal.value * porcentage.value / 100);
                    comision.value =  montottotal.toFixed(2);

                     if(montototal.value > 0 && comision.value > 0 ){
                        montoreal = (parseFloat(montototal.value) + parseFloat(comision.value));
                        monto_real.value =  montoreal;
                    }

                }/* else if(montototal.value > 0 && comision.value > 0 ){
                    montoreal = (montototal.value + comision.value);
                    monto_real.value =  montoreal;
                } */
             }

         })



});


//CAMBIO DE IMAGEN
document.getElementById('file').addEventListener('change', cambiarimagen);
function cambiarimagen(event){
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = (event) => {
        document.getElementById("random").setAttribute('src', event.target.result);
    };
    reader.readAsDataURL(file);
}
//CAMBIO DE IMAGEN



(function () {

'use strict'

var file = document.getElementById('file');
var preload = document.querySelector('.preload');
var publish = document.getElementById('publish');
var formData = new FormData();

file.addEventListener('change', function (e) {

    for ( var i = 0; i < file.files.length; i++ ) {
        var thumbnail_id = Math.floor( Math.random() * 30000 ) + '_' + Date.now();
        createThumbnail(file, i, thumbnail_id);
        formData.append(thumbnail_id, file.files[i]);
    }

    e.target.value = '';

});

var createThumbnail = function (file, iterator, thumbnail_id) {
    var thumbnail = document.createElement('div');
    thumbnail.classList.add('thumbnail', thumbnail_id);
    thumbnail.dataset.id = thumbnail_id;

    thumbnail.setAttribute('style', `height:400px; width:400px; max-width: 100%; background-image: url(${ URL.createObjectURL( file.files[iterator] ) })`);
    //thumbnail.setAttribute();
    document.getElementById('preview-images').appendChild(thumbnail);
    createCloseButton(thumbnail_id);
}

var createCloseButton = function (thumbnail_id) {
    var closeButton = document.createElement('div');
    closeButton.classList.add('close-button');
    closeButton.innerText = 'x';
    document.getElementsByClassName(thumbnail_id)[0].appendChild(closeButton);
}

var clearFormDataAndThumbnails = function () {
    for ( var key of formData.keys() ) {
        formData.delete(key);
    }

    document.querySelectorAll('.thumbnail').forEach(function (thumbnail) {
        thumbnail.remove();
    });
}

document.body.addEventListener('click', function (e) {
    if ( e.target.classList.contains('close-button') ) {
        e.target.parentNode.remove();
        formData.delete(e.target.parentNode.dataset.id);
    }
});

})();












</script>



@endsection
