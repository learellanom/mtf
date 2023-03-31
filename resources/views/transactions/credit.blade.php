@extends('adminlte::page')



@section('title', 'Movimientos')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO MOVIMIENTO <i class="fas fa-exchange-alt"></i> </h1></a>


@stop


@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-7" style="min-height: 500px !important; max-height:1000px; height:1400px;">
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


                <h4 class="text-uppercase font-weight-bold text-center">Comisiones</h4>
                <hr class="bg-dark" style="height:1px;">

                <div class="form-row">

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

                <div class="form-row">

                    <div class="form-group col-md-6">
                        {!! Form::Label('percentage_base', "Porcentaje Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-percentage mr-2"></i>
                        {!! Form::text('percentage_base',null, ['class' => 'form-control percentage_base', 'required' => true, 'min' => 0, 'id' => 'percentage_base']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::Label('amount_commission_base', "Monto Comisión Base:") !!}
                        <div class="input-group-text">
                            <i class="fa-fw fas fa-coins mr-2"></i>
                        {!! Form::number('amount_commission_base',null, ['class' => 'form-control comision_ganancia', 'required' => true, 'min' => 0, 'readonly' => true, 'id' => 'comision_base']) !!}
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <label class="form-check-label mx-auto" for="radio1">
                        {!! Form::radio('exonerate',2, null, ['id' => 'radio1', 'class' => 'exonerar']) !!}
                        Exonerar comisión
                    </label>

                    <label class="form-check-label mx-auto" for="radio3">
                        {!! Form::radio('exonerate',1, null, ['id' => 'radio3', 'class' => 'incluir']) !!}
                        Incluir comisión
                    </label>


                    <label class="form-check-label mx-auto" for="radio2">
                        Descontar comisión
                        {!! Form::radio('exonerate',3, null, ['id' => 'radio2', 'class' => 'descontar']) !!}
                    </label>

                </div>




                <hr class="bg-dark" style="height:1px;">


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
