@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

@php
$config1 =
[
    "allowClear" => true,
];


$config2 =
[
    "allowClear" => true,
];

$config3 = [
    "locale" => ["format" => "DD-MM-YYYY"],
    "allowClear" => true,
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];
@endphp

<div class="container">

    <div class="card">
    <div class="card-header">

        <div class="row">
            <div class="col">
                <x-adminlte-select2 id="typeTransactions"
                name="optionstypeTransactions"
                igroup-size="lg"
                label-class="text-lightblue"
                data-placeholder="Seleccione un tipo de transacción"

                :config="$config2"
                >
                <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-light">
                <i class="fas fa-user-tie"></i>
                </div>
                </x-slot>

                <x-adminlte-options :options="$typeTransactions" empty-option="Selecciona Transaccion.."/>
                </x-adminlte-select2>
            </div>
            <div class="col">
                <x-adminlte-select2 id="wallet"
                name="optionsWallets"
                igroup-size="lg"
                label-class="text-lightblue"
                data-placeholder="Seleccione una caja"

                :config="$config4"
                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-light">
                        <i class="fas fa-box"></i>
                    </div>
                </x-slot>
                <x-adminlte-options :options="$wallet" empty-option="Wallet.."/>
                </x-adminlte-select2>
            </div>
          </div>

     </div>
    </div>


    <div class="row">
      <div class="col-md-6">
          <div class="card">
            <div class="card-body">
                <h3 class="text-center text-uppercase font-weight-bold">Transacciones por caja</h3>
                <canvas id="myChartDoughnut"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
                <h3 class="text-center">Comparativo de Movimientos</h3>
                <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                  <h3 class="text-center text-uppercase font-weight-bold">PAGO EN TRANSFERENCIA</h3>
                  <canvas id="myChartDoughnut2"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                  <h3 class="text-center">Comparativo de Movimientos</h3>
                  <canvas id="myChart2"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                      <h3 class="text-center text-uppercase font-weight-bold">Cobro en Transferencia</h3>
                      <canvas id="myChartDoughnut3"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                      <h3 class="text-center">Comparativo de Movimientos</h3>
                      <canvas id="myChart3"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                          <h3 class="text-center text-uppercase font-weight-bold">Pago Efectivo</h3>
                          <canvas id="myChartDoughnut4"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                          <h3 class="text-center">Comparativo de Movimientos</h3>
                          <canvas id="myChart4"></canvas>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                              <h3 class="text-center text-uppercase font-weight-bold">Cobro en efectivo</h3>
                              <canvas id="myChartDoughnut5"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                              <h3 class="text-center">Comparativo de Movimientos</h3>
                              <canvas id="myChart5"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                              <div class="card-body">
                                  <h3 class="text-center text-uppercase font-weight-bold">Pago Mercancía</h3>
                                  <canvas id="myChartDoughnut6"></canvas>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-body">
                                  <h3 class="text-center">Comparativo de Movimientos</h3>
                                  <canvas id="myChart6"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                  <div class="card-body">
                                      <h3 class="text-center text-uppercase font-weight-bold">Nota de Credito a Caja de efectivo</h3>
                                      <canvas id="myChartDoughnut7"></canvas>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="card">
                                  <div class="card-body">
                                      <h3 class="text-center">Comparativo de Movimientos</h3>
                                      <canvas id="myChart7"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                      <div class="card-body">
                                          <h3 class="text-center text-uppercase font-weight-bold">Nota de credito</h3>
                                          <canvas id="myChartDoughnut8"></canvas>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="card">
                                      <div class="card-body">
                                          <h3 class="text-center">Comparativo de Movimientos</h3>
                                          <canvas id="myChart8"></canvas>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                          <div class="card-body">
                                              <h3 class="text-center text-uppercase font-weight-bold">Nota de debito</h3>
                                              <canvas id="myChartDoughnut9"></canvas>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="card">
                                          <div class="card-body">
                                              <h3 class="text-center">Comparativo de Movimientos</h3>
                                              <canvas id="myChart9"></canvas>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                              <div class="card-body">
                                                  <h3 class="text-center text-uppercase font-weight-bold">Swift</h3>
                                                  <canvas id="myChartDoughnut10"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="card">
                                              <div class="card-body">
                                                  <h3 class="text-center">Comparativo de Movimientos</h3>
                                                  <canvas id="myChart10"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                  <div class="card-body">
                                                      <h3 class="text-center text-uppercase font-weight-bold">Cobro Mercancia</h3>
                                                      <canvas id="myChartDoughnut11"></canvas>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="card">
                                                  <div class="card-body">
                                                      <h3 class="text-center">Comparativo de Movimientos</h3>
                                                      <canvas id="myChart11"></canvas>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card">
                                                      <div class="card-body">
                                                          <h3 class="text-center text-uppercase font-weight-bold">Pago USDT</h3>
                                                          <canvas id="myChartDoughnut12"></canvas>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <div class="card">
                                                      <div class="card-body">
                                                          <h3 class="text-center">Comparativo de Movimientos</h3>
                                                          <canvas id="myChart12"></canvas>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                          <div class="card-body">
                                                              <h3 class="text-center text-uppercase font-weight-bold">Nota de Debito a Caja de Efectivo</h3>
                                                              <canvas id="myChartDoughnut13"></canvas>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="card">
                                                          <div class="card-body">
                                                              <h3 class="text-center">Comparativo de Movimientos</h3>
                                                              <canvas id="myChart13"></canvas>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                              <div class="card-body">
                                                                  <h3 class="text-center text-uppercase font-weight-bold">Cobro USDT</h3>
                                                                  <canvas id="myChartDoughnut14"></canvas>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="card">
                                                              <div class="card-body">
                                                                  <h3 class="text-center">Comparativo de Movimientos</h3>
                                                                  <canvas id="myChart14"></canvas>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card">
                                                                  <div class="card-body">
                                                                      <h3 class="text-center text-uppercase font-weight-bold">Cobro USDT</h3>
                                                                      <canvas id="myChartDoughnut15"></canvas>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                <div class="card">
                                                                  <div class="card-body">
                                                                      <h3 class="text-center">Comparativo de Movimientos</h3>
                                                                      <canvas id="myChart15"></canvas>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>



</div>

@endsection
@section('js')


<script>

const miWallet = {!! $myWallet !!};

BuscaWallet(miWallet);

const miTypeTransaction= {!! $myTypeTransaction !!};

BuscaTransaccion(miTypeTransaction);

document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('myChart');
    //var total_amount = @foreach($wallet_summary as $wallet) {{ $wallet->total_amount. ',' }} @endforeach

    //alert(total_amount)
    const myChart = new Chart(ctx, {
        type: 'bar',
        options: {
        title: {
        display: true,
        text: 'TEST'
        },
        forceOverride: true,
        tooltips: {
            enabled: true,
            backgroundColor: 'rgb(0, 173, 181)'
            },
            colors: {
                enabled: true,
                forceOverride: true,

            }
        },
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) "{{$wallets->GroupName }}", @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) {{$wallets->total_amount. ',' }} @endforeach],
                backgroundColor: [
                    @foreach($wallet_summary as $wallet)
                    @if($wallet->TypeTransactionId == 1)
                    'rgb(0, 173, 181)',
                    @endif
                    @if($wallet->TypeTransactionId == 2)
                    'rgb(58, 16, 120)',
                    @endif
                    @if($wallet->TypeTransactionId == 3)
                    'rgb(255, 184, 76)',
                    @endif
                    @if($wallet->TypeTransactionId == 4)
                    'rgb(49, 225, 247)',
                    @endif
                    @if($wallet->TypeTransactionId == 5)
                    'rgb(8, 2, 2)',
                    @endif
                    @if($wallet->TypeTransactionId == 6)
                    'rgb(0, 129, 180)',
                    @endif
                    @if($wallet->TypeTransactionId == 7)
                    'rgb(7, 10, 82)',
                    @endif
                    @if($wallet->TypeTransactionId == 8)
                    'rgb(213, 206, 163)',
                    @endif
                    @if($wallet->TypeTransactionId == 9)
                    'rgb(60, 42, 33)',
                    @endif
                    @if($wallet->TypeTransactionId == 10)
                    'rgb(2, 89, 85)',
                    @endif
                    @if($wallet->TypeTransactionId == 11)
                    'rgb(255, 132, 0)',
                    @endif
                    @if($wallet->TypeTransactionId == 12)
                    'rgb(184, 98, 27)',
                    @endif
                    @if($wallet->TypeTransactionId == 13)
                    'rgb(114, 0, 27)',
                    @endif
                    @endforeach
                ],
                borderColor: [
                    @foreach($wallet_summary as $wallet)
                    @if($wallet->TypeTransactionId == 1)
                    'rgb(0, 173, 181)',
                    @endif
                    @if($wallet->TypeTransactionId == 2)
                    'rgb(58, 16, 120)',
                    @endif
                    @if($wallet->TypeTransactionId == 3)
                    'rgb(255, 184, 76)',
                    @endif
                    @if($wallet->TypeTransactionId == 4)
                    'rgb(49, 225, 247)',
                    @endif
                    @if($wallet->TypeTransactionId == 5)
                    'rgb(8, 2, 2)',
                    @endif
                    @if($wallet->TypeTransactionId == 6)
                    'rgb(0, 129, 180)',
                    @endif
                    @if($wallet->TypeTransactionId == 7)
                    'rgb(7, 10, 82)',
                    @endif
                    @if($wallet->TypeTransactionId == 8)
                    'rgb(213, 206, 163)',
                    @endif
                    @if($wallet->TypeTransactionId == 9)
                    'rgb(60, 42, 33)',
                    @endif
                    @if($wallet->TypeTransactionId == 10)
                    'rgb(2, 89, 85)',
                    @endif
                    @if($wallet->TypeTransactionId == 11)
                    'rgb(255, 132, 0)',
                    @endif
                    @if($wallet->TypeTransactionId == 12)
                    'rgb(184, 98, 27)',
                    @endif
                    @if($wallet->TypeTransactionId == 13)
                    'rgb(114, 0, 27)',
                    @endif
                    @endforeach

                ],
                borderWidth: 4

            }]
        }
    });





    const DATA_COUNT2 = 1600;
    const NUMBER_CFG = {count: DATA_COUNT2, min: 0, max: 1500};
    const ctx2 = document.getElementById('myChartDoughnut');
    const myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    @foreach($wallet_summary as $wallet)
                    @if($wallet->TypeTransactionId == 1)
                    'rgb(0, 173, 181)',
                    @endif
                    @if($wallet->TypeTransactionId == 2)
                    'rgb(58, 16, 120)',
                    @endif
                    @if($wallet->TypeTransactionId == 3)
                    'rgb(255, 184, 76)',
                    @endif
                    @if($wallet->TypeTransactionId == 4)
                    'rgb(49, 225, 247)',
                    @endif
                    @if($wallet->TypeTransactionId == 5)
                    'rgb(8, 2, 2)',
                    @endif
                    @if($wallet->TypeTransactionId == 6)
                    'rgb(0, 129, 180)',
                    @endif
                    @if($wallet->TypeTransactionId == 7)
                    'rgb(7, 10, 82)',
                    @endif
                    @if($wallet->TypeTransactionId == 8)
                    'rgb(213, 206, 163)',
                    @endif
                    @if($wallet->TypeTransactionId == 9)
                    'rgb(60, 42, 33)',
                    @endif
                    @if($wallet->TypeTransactionId == 10)
                    'rgb(2, 89, 85)',
                    @endif
                    @if($wallet->TypeTransactionId == 11)
                    'rgb(255, 132, 0)',
                    @endif
                    @if($wallet->TypeTransactionId == 12)
                    'rgb(184, 98, 27)',
                    @endif
                    @if($wallet->TypeTransactionId == 13)
                    'rgb(114, 0, 27)',
                    @endif
                    @endforeach
                ],
                hoverOffset: 4
            }]
        },

    });

/* PAGO EN TRANSFERENCIA */
    const DATA_COUNT = 1500;
    const NUMBER_CFG2 = {count: DATA_COUNT, min: 0, max: 1500};
    const ctx3 = document.getElementById('myChartDoughnut2');
    const myChart3 = new Chart(ctx3, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet) "{{$wallet->TypeTransaccionName }}", @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],

                backgroundColor: [
                    @foreach($wallet_summary as $wallet)
                    @if($wallet->TypeTransactionId == 1)
                    'rgb(0, 173, 181)',
                    @endif
                    @if($wallet->TypeTransactionId == 2)
                    'rgb(58, 16, 120)',
                    @endif
                    @if($wallet->TypeTransactionId == 3)
                    'rgb(255, 184, 76)',
                    @endif
                    @if($wallet->TypeTransactionId == 4)
                    'rgb(49, 225, 247)',
                    @endif
                    @if($wallet->TypeTransactionId == 5)
                    'rgb(8, 2, 2)',
                    @endif
                    @if($wallet->TypeTransactionId == 6)
                    'rgb(0, 129, 180)',
                    @endif
                    @if($wallet->TypeTransactionId == 7)
                    'rgb(7, 10, 82)',
                    @endif
                    @if($wallet->TypeTransactionId == 8)
                    'rgb(213, 206, 163)',
                    @endif
                    @if($wallet->TypeTransactionId == 9)
                    'rgb(60, 42, 33)',
                    @endif
                    @if($wallet->TypeTransactionId == 10)
                    'rgb(2, 89, 85)',
                    @endif
                    @if($wallet->TypeTransactionId == 11)
                    'rgb(255, 132, 0)',
                    @endif
                    @if($wallet->TypeTransactionId == 12)
                    'rgb(184, 98, 27)',
                    @endif
                    @if($wallet->TypeTransactionId == 13)
                    'rgb(114, 0, 27)',
                    @endif
                    @endforeach
                ],
                hoverOffset: 5
               }]
        },

    });

    const color = ['red', 'green', 'blue', 'dark', 'yellow'];
    const ctx4 = document.getElementById('myChart2');
    var myChart4 = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 1) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: '',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 1) {{$wallets->total_amount. ',' }}  @endif  @endforeach],
                backgroundColor: color,
                borderColor: color,
                borderWidth: 6
            }]
        }

    });
    myChart4.data.datasets.forEach((dataset) => {
             dataset.data = dataset.data.map((value) => value * 2);
        });
        myChart4.update();
/* PAGO EN TRANSFERENCIA */

/* COBRO EN TRANSFERENCIA */
    const DATA_COUNT3 = 1500;
    const NUMBER_CFG3 = {count: DATA_COUNT3, min: 0, max: 1500};
    const ctx5 = document.getElementById('myChartDoughnut3');
    const myChart5 = new Chart(ctx5, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });
/* COBRO EN TRANSFERENCIA */
    const ctx6 = document.getElementById('myChart3');
    const myChart6 = new Chart(ctx6, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 2) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 2) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(58, 16, 120)',
                ],
                borderColor: [
                    'rgb(58, 16, 120)',

                ],
                borderWidth: 6
            }]
        }
    });
/* COBRO EN TRANSFERENCIA */
/* PAGO EFECTIVO */
    const DATA_COUNT4 = 1500;
    const NUMBER_CFG4 = {count: DATA_COUNT4, min: 0, max: 1500};
    const ctx7 = document.getElementById('myChartDoughnut4');
    const myChart7 = new Chart(ctx7, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(255, 184, 76)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)'
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx8 = document.getElementById('myChart4');
    const myChart8 = new Chart(ctx8, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 3) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 3) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(255, 184, 76)',
                ],
                borderColor: [
                    'rgb(255, 184, 76)',

                ],
                borderWidth: 6
            }]
        }
    });
/* PAGO EFECTIVO */

/* COBRO EN EFECTIVO */
    const DATA_COUNT5 = 1500;
    const NUMBER_CFG5 = {count: DATA_COUNT5, min: 0, max: 1500};
    const ctx9 = document.getElementById('myChartDoughnut5');
    const myChart9 = new Chart(ctx9, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(49, 225, 247)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx10 = document.getElementById('myChart5');
    const myChart10 = new Chart(ctx10, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 4) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 4) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(49, 225, 247)',
                ],
                borderColor: [
                    'rgb(49, 225, 247)',

                ],
                borderWidth: 6
            }]
        }
    });
/* COBRO EN EFECTIVO */

/* PAGO MERCANCIA */
    const DATA_COUNT6 = 1500;
    const NUMBER_CFG6 = {count: DATA_COUNT6, min: 0, max: 1500};
    const ctx11 = document.getElementById('myChartDoughnut6');
    const myChart11 = new Chart(ctx11, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) "{{$wallet->TypeTransaccionName }}",   @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(8, 2, 2)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx12 = document.getElementById('myChart6');
    const myChart12 = new Chart(ctx12, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 5) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 5) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(8, 2, 2)',
                ],
                borderColor: [
                    'rgb(8, 2, 2)',

                ],
                borderWidth: 6
            }]
        }

    });
/* PAGO MERCANCIA */

/* NOTA DECREDITO A CAJA EN EFECTIVO */
    const DATA_COUNT7 = 1500;
    const NUMBER_CFG7 = {count: DATA_COUNT7, min: 0, max: 1500};
    const ctx13 = document.getElementById('myChartDoughnut7');
    const myChart13 = new Chart(ctx13, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(0, 129, 180)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx14 = document.getElementById('myChart7');
    const myChart14 = new Chart(ctx14, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 6) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 6) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 129, 180)',
                ],
                borderColor: [
                    'rgb(0, 129, 180)',

                ],
                borderWidth: 6
            }]
        }

    });

    const DATA_COUNT8 = 1500;
    const NUMBER_CFG8 = {count: DATA_COUNT8, min: 0, max: 1500};
    const ctx15 = document.getElementById('myChartDoughnut8');
    const myChart15 = new Chart(ctx15, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}",  @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(7, 10, 82)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                ],
                hoverOffset: 4
            }]
        },

    });
/* NOTA DECREDITO A CAJA EN EFECTIVO */

/* NOTA DE CREDITO  */
    const ctx16 = document.getElementById('myChart8');
    const myChart16 = new Chart(ctx16, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallet->TypeTransactionId == 7)  "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallet->TypeTransactionId == 7) {{$wallets->total_amount. ',' }}, @endif  @endforeach],
                backgroundColor: [
                    'rgb(7, 10, 82)',
                ],
                borderColor: [
                    'rgb(7, 10, 82)',

                ],
                borderWidth: 6
            }]
        }

    });

    const DATA_COUNT9 = 1500;
    const NUMBER_CFG9 = {count: DATA_COUNT9, min: 0, max: 1500};
    const ctx18 = document.getElementById('myChartDoughnut9');
    const myChart18 = new Chart(ctx18, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(213, 206, 163)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx19 = document.getElementById('myChart9');
    const myChart19 = new Chart(ctx19, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 8) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 8) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(213, 206, 163)',
                ],
                borderColor: [
                    'rgb(213, 206, 163)',

                ],
                borderWidth: 6
            }]
        }

    });
/* NOTA DE CREDITO  */

/* NOTA DE DEBITO  */
    const DATA_COUNT10 = 1500;
    const NUMBER_CFG10 = {count: DATA_COUNT10, min: 0, max: 1500};
    const ctx20 = document.getElementById('myChartDoughnut10');
    const myChart20 = new Chart(ctx20, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet)  "{{$wallet->TypeTransaccionName }}", @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet)  {{$wallet->cant_transactions. ',' }} @endforeach],
                backgroundColor: [
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(60, 42, 33)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',
                    'rgb(203, 203, 203)',

                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx21 = document.getElementById('myChart10');
    const myChart21 = new Chart(ctx21, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 9) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 9) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(60, 42, 33)',
                ],
                borderColor: [
                    'rgb(60, 42, 33)',

                ],
                borderWidth: 6
            }]
        }

    });
/* NOTA DE DEBITO  */

/* SWITF  */
    const DATA_COUNT11 = 1500;
    const NUMBER_CFG11 = {count: DATA_COUNT11, min: 0, max: 1500};
    const ctx22 = document.getElementById('myChartDoughnut11');
    const myChart22 = new Chart(ctx22, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 10) "{{$wallet->TypeTransaccionName }}",  @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 10) {{$wallet->cant_transactions. ',' }},  @endif @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx23 = document.getElementById('myChart11');
    const myChart23 = new Chart(ctx23, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 10) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 10) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                borderColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',

                ],
                borderWidth: 6
            }]
        }

    });
/* SWITF  */

/* COBRO EN MERCANCIA  */
    const DATA_COUNT12 = 1500;
    const NUMBER_CFG12 = {count: DATA_COUNT12, min: 0, max: 1500};
    const ctx24 = document.getElementById('myChartDoughnut12');
    const myChart24 = new Chart(ctx24, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 11) "{{$wallet->TypeTransaccionName }}",  @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 11) {{$wallet->cant_transactions. ',' }},  @endif @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx25 = document.getElementById('myChart12');
    const myChart25 = new Chart(ctx25, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 11) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 11) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                borderColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',

                ],
                borderWidth: 6
            }]
        }

    });
/* COBRO EN MERCANCIA  */

/* PAGO USDT  */
    const DATA_COUNT14 = 1500;
    const NUMBER_CFG14 = {count: DATA_COUNT14, min: 0, max: 1500};
    const ctx26 = document.getElementById('myChartDoughnut13');
    const myChart26 = new Chart(ctx26, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 12) "{{$wallet->TypeTransaccionName }}",  @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 12) {{$wallet->cant_transactions. ',' }},  @endif @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx27 = document.getElementById('myChart13');
    const myChart27 = new Chart(ctx27, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 12) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 12) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                borderColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',

                ],
                borderWidth: 6
            }]
        }

    });
/* PAGO USDT  */


/* NOTA DE DEBITO A CAJA DE EFECTIVO  */
const DATA_COUNT15 = 1500;
    const NUMBER_CFG15 = {count: DATA_COUNT15, min: 0, max: 1500};
    const ctx28 = document.getElementById('myChartDoughnut14');
    const myChart28 = new Chart(ctx28, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 13) "{{$wallet->TypeTransaccionName }}",  @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 13) {{$wallet->cant_transactions. ',' }},  @endif @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx29 = document.getElementById('myChart14');
    const myChart29 = new Chart(ctx29, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 13) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 13) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                borderColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',

                ],
                borderWidth: 6
            }]
        }

    });
/* NOTA DE DEBITO A CAJA DE EFECTIVO  */

/* COBRO USDT  */
const DATA_COUNT16 = 1500;
    const NUMBER_CFG16 = {count: DATA_COUNT16, min: 0, max: 1500};
    const ctx31 = document.getElementById('myChartDoughnut15');
    const myChart31 = new Chart(ctx31, {
        type: 'doughnut',
        data : {
            labels: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 14) "{{$wallet->TypeTransaccionName }}",  @endif @endforeach],
            datasets: [
                {
                label: 'Dataset 1',
                data: [@foreach($wallet_summary as $wallet) @if($wallet->TypeTransactionId == 14) {{$wallet->cant_transactions. ',' }},  @endif @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                hoverOffset: 4
            }]
        },

    });

    const ctx32 = document.getElementById('myChart15');
    const myChart32 = new Chart(ctx32, {
        type: 'bar',
        data: {
            labels: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 14) "{{$wallets->GroupName }}", @endif @endforeach],
            datasets: [{
                label: 'Monto total de las transacciones',
                data: [@foreach($wallet_groupsummary as $wallets) @if($wallets->TypeTransactionId == 14) {{$wallets->total_amount. ',' }},  @endif  @endforeach],
                backgroundColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',
                ],
                borderColor: [
                    'rgb(0, 173, 181)',
                    'rgb(58, 16, 120)',
                    'rgb(255, 184, 76)',
                    'rgb(49, 225, 247)',
                    'rgb(8, 2, 2)',
                    'rgb(0, 129, 180)',
                    'rgb(7, 10, 82)',
                    'rgb(213, 206, 163)',
                    'rgb(60, 42, 33)',
                    'rgb(2, 89, 85)',
                    'rgb(255, 132, 0)',
                    'rgb(184, 98, 27)',

                ],
                borderWidth: 6
            }]
        }

    });
/* COBRO USDT  */

 }, true);



 $(() => {

$('#wallet').on('change', function (){

const wallet        = $('#wallet').val();
const transaccion   = $('#typeTransactions').val();
theRoute(wallet, transaccion);

});

$('#typeTransactions').on('change', function (){

const wallet        = $('#wallet').val();
const transaccion   = $('#typeTransactions').val();

// alert('transaccion -> ' + transaccion)
theRoute(wallet, transaccion);

});


});


 function theRoute(wallet = 0, transaction = 0){


    if (wallet   === "") wallet  = 0;
    if (transaction   === "") transaction  = 0;

    let myRoute = "";

    myRoute = "{{ route('dashboardest', ['wallet' => 'wallet2' , 'transaction' => 'transaction2']) }}";
    myRoute = myRoute.replace('wallet2',wallet);
    myRoute = myRoute.replace('transaction2',transaction);
   /*  myRoute = myRoute.replace('fechaDesde2',fechaDesde);
    myRoute = myRoute.replace('fechaHasta2',fechaHasta); */

 //alert(myRoute);
location.href = myRoute;

}



function BuscaWallet(miWallet){
            if (miWallet===0){
                return;
            }
            // alert("BuscaWallet - miWallet -> " + miWallet);
            $('#wallet').each( function(index, element){
                // alert ("BuscaWallet -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miWallet.toString()){
                        // alert('BuscaWallet - encontro');
                        $("#wallet option[value="+ miWallet +"]").attr("selected",true);
                    }
                    // alert("BuscaWallet aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
    }

    function BuscaTransaccion(miTypeTransaction){
        if (miTypeTransaction===0){
            return;
        }
        // alert("BuscaWallet - miWallet -> " + miWallet);
        $('#typeTransactions').each( function(index, element){
            // alert ("BuscaWallet -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miTypeTransaction.toString()){
                    // alert('BuscaWallet - encontro');
                    $("#typeTransactions option[value="+ miTypeTransaction +"]").attr("selected",true);
                }
                // alert("BuscaWallet aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
    }

</script>

@endsection

