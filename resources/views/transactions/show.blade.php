@extends('adminlte::page')



@section('title', 'Transacciones')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">VER MAS DE TRANSACCIÓN <i class="fas fa-exchange-alt"></i> </h1></a>
<hr>

@stop


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
        {{-- {{ dd($transactiones) }} --}}
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
              <h3 class="card-title text-uppercase font-weight-bold">Transacción numero #{{ $transactions->id }}
                @if($transactions->status == 'Activo') <span class="badge badge-success">{{ $transactions->status }}</span> @else <span class="badge badge-danger">{{ $transactions->status }}</span> @endif </h3>


              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                      <div class="row">
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
                              <span class="info-box-text text-center text-muted">Monto total <i class="fas fa-funnel-dollar"></i></span>
                              <span class="info-box-number text-center text-muted mb-0">{{ number_format(abs($transactions->amount_total),2,",",".") }}$</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                              <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Transacción <i class="fas fa-trademark"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->type_transaction->name }}</span>
                              </div>
                            </div>
                          </div>
                      {{--     <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                              <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Caja utilizada <i class="fas fa-box-open"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
                              </div>
                            </div>
                          </div> --}}
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
                                  <span class="info-box-text text-center text-muted">Tasa de cambio<i class="fas fa-sync"></i></span>
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
                                    Monto en Moneda Extranjera<i class="fas fa-exclamation-triangle"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                  {{ number_format($transactions->amount_foreign_currency,2,",",".") ?? '0.00' }}
                                </span>
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
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                  <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Token <i class="fas fa-mask"></i></span>
                                    <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->token ?? 'SIN TOKEN' }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                  <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Caja utilizada <i class="fas fa-box-open"></i></span>
                                    <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
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

                          <div class="col-3 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted">Tasa de cambio base <i class="fas fa-sync"></i></span>
                                  <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->exchange_rate_base,2,",",".") }}
                                  </span>
                                </div>
                              </div>
                            </div>

                          <div class="col-3 col-sm-2">
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
  })
  </script>
  @endsection
