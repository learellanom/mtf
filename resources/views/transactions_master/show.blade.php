@extends('adminlte::page')



@section('title', 'Transacciones')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">VER MAS DE TRANSACCIÓN MASTER <i class="fas fa-exchange-alt"></i> </h1></a>
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
          <h3 class="card-title text-uppercase font-weight-bold">Transacción Master numero #{{ $transactions->id }}
            @if($transactions->status == 'Activo') <span class="badge badge-success">{{ $transactions->status }}</span> @else <span class="badge badge-danger">{{ $transactions->status }}</span> @endif </h3>
          <p class="card-title text-uppercase font-weight-bold" style="margin-left: 500px;">Cliente: {{ $transactions->group->name ?? 'SIN CLIENTE' }}</p>

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
                      <span class="info-box-number text-center text-muted mb-0">{{ number_format($transactions->amount) }}$</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Monto total <i class="fas fa-funnel-dollar"></i></span>
                      <span class="info-box-number text-center text-muted mb-0">{{ number_format($transactions->amount_total) }}$</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Transacción <i class="fas fa-trademark"></i></span>
                        <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->type_transaction->name }}</span>
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
              <div class="row">
                <div class="col-12">
                <hr>


                  @if($transactiones->count())
                  <h4 class="text-uppercase font-weight-bold text-center">Actividad reciente de {{ $transactions->group->name ?? 'Sin cliente' }}</h4>
                  @foreach ($transactiones as $transactione)
                   <div class="post">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="{{Storage::url('image/interrogacion.jpg')}}" alt="user image">
                      <span class="username">
                        <a href="#">{{ $transactione->group->name ?? 'Sin cliente' }}</a>
                      </span>
                      <span class="description">{{ $transactione->transaction_date }}</span>
                    </div>

                    <p>
                      <div class="row d-flex justify-content-center">

                          <div class="col-6 col-sm-3">
                            <div class="info-box bg-light">
                              <div class="info-box-content">
                                <span class="info-box-text text-center text-muted text-uppercase">Monto en dolares ($)</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ number_format($transactione->amount) }}$</span>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-sm-3">
                            <div class="info-box bg-light">
                              <div class="info-box-content">
                                <span class="info-box-text text-center text-muted text-uppercase">Monto total de la transacción</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ number_format($transactione->amount_total); }}$</span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted text-uppercase">Porcentaje <i class="fas fa-percentage"></i></span>
                                  <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactione->percentage ?? 'Sin porcentaje' }} </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted text-uppercase">Comisión <i class="fas fa-comment-dollar"></i></span>
                                  <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactione->amount_commission ?? 'Sin comisión' }}</span>
                                </div>
                              </div>
                            </div>
                                <div class="col-12 col-sm-2">
                                @if($transactione->status == 'Activo')
                                <div class="info-box bg-success">
                                    <div class="info-box-content">

                                    <span class="info-box-text text-center text-muted text-uppercase text-white"><i class="fas fa-check-circle fa-lg"></i> </span>
                                    <span class="info-box-number text-center text-muted mb-0 text-uppercase text-white">{{ 'Activa' ?? 'Sin comisión' }}</span>
                                    </div>
                                    @else
                                    <div class="info-box bg-danger">
                                    <div class="info-box-content">

                                        <span class="info-box-text text-center text-muted text-uppercase text-white"><i class="fas fa-ban fa-lg"></i> </span>
                                        <span class="info-box-number text-center text-muted mb-0 text-uppercase text-white">{{ 'Anulada' ?? 'Sin comisión' }}</span>
                                    </div>
                                    @endif
                                </div>
                                </div>
                            </div>
                          </p>

                    <p>
                      <a href="#" class="link-black text-sm"><i class="fas fa-user mr-1"></i> {{ $transactione->user->name }}</a>
                    </p>
                  </div>

                    @endforeach

                    @else

                    <p class="font-weight-bold text-center">SIN ACTIVIDAD PORQUE PROBLAMENTE ESTA TRANSACCIÓN NO TIENE UN CLIENTE</p>

                    <figure class="d-flex justify-content-center">
                    <img src="{{asset('img/AdminLTELogo.png') }}" alt="">
                    </figure>
                    @endif

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
                          <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->amount_commission ?? 'Sin comisión' }}</span>
                        </div>
                      </div>
                    </div>
                    @if($transactions->exchange_rate)
                    <div class="col-12 col-sm-3">
                        <div class="info-box bg-light">
                          <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Tasa <i class="fas fa-sync"></i></span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->exchange_rate }}</span>
                          </div>
                        </div>
                      </div>
                      @endif
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

              <div class="text-muted">
                <p class="text-sm">Cliente
                  <b class="d-block">{{ $transactions->group->name ?? 'Sin cliente' }}</b>
                </p>
                <p class="text-sm">Numero de telefono
                  <b class="d-block">{{ $transactions->group->phone ?? 'Sin cliente' }}</b>
                </p>
              </div>
              <hr>
              <h5 class="mt-5 text-muted text-uppercase font-weight-bold">Captures de pantalla | Referencias <i class="fas fa-images"></i> </h5>
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
