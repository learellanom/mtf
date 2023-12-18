@extends('adminlte::page')

@section('title', 'Transacciones')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">VER MAS DE TRANSACCIÓN <i class="fas fa-exchange-alt"></i> </h1></a>
    <hr>

@stop

@php

    $myClass	        = new app\Http\Controllers\TransactionController;
    $myAdministrator    = $myClass->isAdministrator();

@endphp

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
         
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="card-title text-uppercase font-weight-bold">Transacción numero #{{ $transactions->id }}
                        @php
                            if($transactions->status == 'Activo') {
                                $myBadge = "badge badge-success";
                            }else{
                                $myBadge = "badge badge-danger";
                            }
                        @endphp
                        <span class="{{$myBadge}}" id="myBadge">{{ $transactions->status }}</span>

                        {{-- @if($transactions->status == 'Activo') <span class="badge badge-success" id="myBadge">{{ $transactions->status }}</span> @else <span class="badge badge-danger">{{ $transactions->status }}</span> @endif </h3> --}}
                    </div>  
                    
                    @php

                    @endphp
                    <div class="col-lg-8 justify-content-end align-items-right text-right">
                        
                        @can('transactions.update_status')            
                            @php
                                
                                $indMuestra = 1;
                                if ($myAdministrator == false){
                                    if ($transactions->user_id != auth()->id()){
                                        $indMuestra = 0;
                                    }
                                }
                                 
                                if ($transactions->status == 'Activo') {
                                    $myColor = "btn btn-xl text-success mx-1 shadow text-center";
                                    $myIcon = "fa fa-lg fa-fw fas fa-check";
                                    $myText = "Anular";                        
                                }else{
                                    $myColor = "btn btn-xl text-danger mx-1 shadow text-center";
                                    $myIcon = "fa fa-lg fa-fw fas fa-times ";
                                    $myText = "Activar";
                                }
                            @endphp 
                            @if($indMuestra == 1)
                                <button class="{{ $myColor }}" 
                                    id="myBtnAnular"
                                    onclick="apiUpdateStatus();"
                                    title="Activo">
                                    <i id="myIcon" class="{{$myIcon}}"></i><p id="myText" style="display: block;">{{ $myText }}</p>
                                </button>
                                
                                <button class="btn btn-xl text-success mx-1 shadow text-center " 
                                    title="Activo"
                                    onclick="editTransaction();"
                                    >
                                    <i class="fas fa-lg fa-fw fa-coins"></i><p style="display: block;">Editar</p>
                                </button>
                                
                            @else
                                <button class="{{ $myColor }}" 
                                    id="myBtnAnular"
                                    onclick=""
                                    title="Activo"
                                    disabled
                                    style="color: gray !important;"
                                    >
                                    <i id="myIcon" class="{{$myIcon}}"></i><p id="myText" style="display: block;">{{ $myText }}</p>
                                </button>
                                <button class="btn btn-xl text-success mx-1 shadow text-center " 
                                    title="Activo"
                                    onclick=""
                                    disabled
                                    style="color: gray !important;"
                                    >
                                    <i class="fas fa-lg fa-fw fa-coins"></i><p style="display: block;">Editarr</p>
                                </button>                            
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Transacción <i class="fas fa-trademark"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->type_transaction->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Agente <i class="fas fa-user"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Monto en dolar <i class="fas fa-dollar-sign"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ number_format(abs($transactions->amount),2,",",".") }}$</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Monto total <i class="fas fa-money-check-alt"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ number_format(abs($transactions->amount_total),2,",",".") }}$</span>
                                    </div>
                                </div>
                            </div>
                            {{--     
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Caja utilizada <i class="fas fa-box-open"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
                                    </div>
                                </div>
                            </div> 
                            --}}
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Tipo de moneda <i class="fas fa-funnel-dollar"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ $transactions->type_coin->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Tasa de cambio <i class="fas fa-sync"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                            {{ number_format($transactions->exchange_rate,2,",",".") }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">
                                            Moneda Extranjera <i class="fas fa-hryvnia"></i>
                                        </span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                            {{ number_format($transactions->amount_foreign_currency,2,",",".") ?? '0.00' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Token <i class="fas fa-lock"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->token ?? 'SIN TOKEN' }}</span>
                                    </div>
                                </div>
                            </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-12">

                        <div class="row">

                            @if($transactions->transfer_number)
                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Numero de transferencia <i class="fas fa-asterisk"></i></span>
                                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->transfer_number }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Estatus <i class="fas fa-exclamation-triangle"></i></span>
                                        @if($transactions->status == 'Activo')
                                            <span class="badge badge-success text-uppercase">{{ $transactions->status }} <i class="far fa-check-circle"></i></span>
                                        @else
                                            <span class="info-box-number text-center text-muted mb-0 text-danger">{{ $transactions->status }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($transactions->group_id == NULL)
                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Caja  <i class="fas fa-box"></i></span>
                                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($transactions->group_id && $transactions->wallet_id)
                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">@if($transactions->group->type == 2 && $transactions->group_id)   Caja Origen  @else Grupo @endif  <i class="fas fa-hand-holding-usd"></i></span>
                                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->group->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">@if($transactions->group->type == 2 && $transactions->wallet_id) Caja Destino @else Caja  @endif <i class="fas fa-box"></i></span>
                                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- fecha --}}

                            @php 
                                $myDate = date_create($transactions->transaction_date);
                                
                            @endphp 
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Fecha Transaccion <i class="fas fa-calendar"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-danger">{{ date_format($myDate,"d/m/Y H:i:s") }}</span>
                                    </div>
                                </div>
                            </div>                            


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Porcentaje Base <i class="fas fa-asterisk"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->percentage_base ?? 'SIN BASE' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Comision Base <i class="fas fa-exclamation-triangle"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                            {{ number_format($transactions->amount_commission_base,2,",",".") ?? '0,00' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Comisión Base <i class="fas fa-receipt"></i></span>
                                        @if($transactions->exonerate_base == 1)
                                            <span class="info-box-number mb-0 text-uppercase badge badge-success text-center">{{ 'Incluida' }} </span>
                                        @elseif($transactions->exonerate_base == 2)
                                            <span class="info-box-number mb-0 text-uppercase badge badge-warning text-center">{{ 'Exonerada' }} </span>
                                        @else
                                            <span class="info-box-number mb-0 text-uppercase badge badge-danger text-center">{{ 'Descontada' }} </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">
                                        Monto total (BASE) <i class="fas fa-funnel-dollar"></i>
                                        </span>
                                        <span class="info-box-number text-center text-muted mb-0">
                                            {{  number_format(abs($transactions->amount_total_base),2,",",".") ?? 'SIN BASE' }} $
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">

                    <div class="col-3 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tasa de cambio base <i class="fas fa-sync"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->exchange_rate_base,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-3 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                    Monto Base<i class="fas fa-exclamation-triangle"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->amount_base,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-12">
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Descripción <i class="fas fa-text-width"></i></span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->description ?? 'SIN DESCRIPCIÓN' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-2">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted"> <i class="fas fa-percentage"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->percentage ?? '-' }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Comisión <i class="fas fa-comment-dollar"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ number_format(abs($transactions->amount_commission),2,",",".") ?? 'Sin comisión' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-13 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Comisión <i class="fas fa-receipt"></i></span>
                                @if($transactions->exonerate == 1)
                                    <span class="info-box-number mb-0 text-uppercase badge badge-success text-center">{{ 'Incluida' }} </span>
                                @elseif($transactions->exonerate == 2)
                                    <span class="info-box-number mb-0 text-uppercase badge badge-warning text-center">{{ 'Exonerada' }} </span>
                                @else
                                    <span class="info-box-number mb-0 text-uppercase badge badge-danger text-center">{{ 'Descontada' }} </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="mt-5 text-muted text-uppercase font-weight-bold text-center">Captures de pantalla | Referencias <i class="fas fa-images"></i> </h5>
                <hr>

                <ul class="list-unstyled">
                    <li>
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Referencias</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($transactions->image as $transaction)
                                            <div class="col-sm-2">
                                                <a href="{{Storage::url($transaction->url)}}?text={{$transaction->id}}" data-toggle="lightbox" data-title="Transacciones">
                                                    <img class="img-fluid mb-2" style="width:100%;" alt="white sample" @if($transaction) src="{{Storage::url($transaction->url)}}"> @else <p>Sin imagenes</p> @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </li>
                </ul>

            </div>
                </div>
            </div>
                <!-- /.card-body -->
        </div>
                <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  @section('js')
  <script>
    /*
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    });
*/
  function apiUpdateStatus(id){
    //alert('apiUpdateStatus');
    //return;
    let data    = { id:  id };
    let token   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{route('transactions.update_status_api', $transactions->id )}}",{
        method:'POST',
        headers:{
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(response => {
        return response.json()
    }).then(data =>{        
        if(data.success){
           // console.log('actualizo ->' + JSON.stringify(data));

           // $('#myBtnAnular').attr('disabled',true);
           if(data.result == "anulada"){

                $myColor = "btn btn-xl text-danger mx-1 shadow text-center";

                $('#myBtnAnular').removeClass("btn btn-xl text-success mx-1 shadow text-center");
                $('#myBtnAnular').addClass("btn btn-xl text-danger mx-1 shadow text-center");

                $('#myBadge').removeClass('badge badge-success');
                $('#myBadge').addClass('badge badge-danger');
                $('#myBadge').text('Anulada');

                $('#myIcon').removeClass('fa fa-lg fa-fw fas fa-check');
                $('#myIcon').addClass('fa fa-lg fa-fw fas fa-times');

                $('#myText').text('Activar');

                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: 'Transaccion anulada satisfactoriamente',
                    showConfirmButton: true
                }).then( function () {
                        window.location.href = "{{redirect()->getUrlGenerator()->previous()}}";
                    }
                );  
                

        
           }else if(data.result == "activo"){

                $('#myBtnAnular').removeClass("btn btn-xl text-danger mx-1 shadow text-center");
                $('#myBtnAnular').addClass("btn btn-xl text-success mx-1 shadow text-center");

                $('#myBadge').removeClass('badge badge-danger');
                $('#myBadge').addClass('badge badge-success');
                $('#myBadge').text('Activo');      
              
                $('#myIcon').removeClass('fa fa-lg fa-fw fas fa-times');
                $('#myIcon').addClass('fa fa-lg fa-fw fas fa-check');

                $('#myText').text('Anular');

                Swal.fire({
                    position: 'center',
                    title: 'Transaccion Activada satisfactoriamente',
                    type: 'success',
                    showConfirmButton: true
                }).then( function (){
                        window.location.href = "{{redirect()->getUrlGenerator()->previous()}}";
                    }
                );
           }
        }else{
            // console.log('no actualizo ->');
        }

    }).catch(error => console.error( 'Error en Fetch -> ' + error));
  }


    function editTransaction(){
        
        let myVar               = "{{ $transactions->pay_number }}";
        let myStatus            = "{{$transactions->status}}";
        let myTransferNumber    = "{{$transactions->transfer_number}}";

        if (myStatus == "Anulado"){
            Swal.fire({
                position: 'center', 
                title: 'No se puede editar una transaccion Anulada',
                type: 'error',                
                showConfirmButton: true
            });            
            return;
        }

        if (myVar != ""){
            
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar un Pago del proveedor , debe anularse',
                showConfirmButton: true
            });             
            return;    
        }

        if (myTransferNumber != ""){
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar una Transferencia o Cobros entre Cajas, debe anularse',
                showConfirmButton: true
            });             
            return;    
        }


        let myRoute = "";

        myRoute = "{{route('transactions.edit2', $transactions->id)}}";
        location.href = myRoute;
        
    }



  </script>
  @endsection
