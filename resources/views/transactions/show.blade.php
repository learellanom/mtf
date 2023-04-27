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

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-uppercase font-weight-bold">Transacción numero #{{ $transactions->id }}</h3>

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
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Agente</span>
                      <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->user->name }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Monto en dolares ($)</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $transactions->amount }}$</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Monto total de la transacción</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $transactions->amount_total }}$</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h4>Recent Activity</h4>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                        <span class="description">Shared publicly - 7:45 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                      </p>
                    </div>

                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore.
                      </p>
                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                      </p>
                    </div>

                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                        <span class="description">Shared publicly - 5 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                      </p>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Porcentaje %</span>
                          <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->percentaje ?? 'Sin porcentaje' }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Comisión</span>
                          <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->amount_commission ?? 'Sin comisión' }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Caja utilizada</span>
                          <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->wallet->name }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
              <br>
              <div class="text-muted">
                <p class="text-sm">Cliente
                  <b class="d-block">{{ $transactions->group->name }}</b>
                </p>
                <p class="text-sm">Numero de telefono
                  <b class="d-block">{{ $transactions->group->phone }}</b>
                </p>
              </div>

              <h5 class="mt-5 text-muted">Captures de pantalla | Referencias </h5>
              <ul class="list-unstyled">
                <li>
                    <figure>

                        @foreach ($transactions->image as $transaction)
                          <img class="rounded d-block img-rounded" style="height:300px;" @if($transaction) src="{{Storage::url($transaction->url)}}" @else src='/storage/image/interrogacion.gif' @endif>
                        @endforeach

                    </figure>
                </li>
              </ul>
              <div class="text-center mt-5 mb-3">
                <a href="#" class="btn btn-sm btn-primary">Add files</a>
                <a href="#" class="btn btn-sm btn-warning">Report contact</a>
              </div>
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
