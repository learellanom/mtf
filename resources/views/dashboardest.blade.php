@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

<br><br>

<div class="container">
    <div class="card">
        <h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Estadisticas') }}</h1>
        <hr>
        <div class="card-body">
    <div class="row justify-content-center">
        <div class="col col-sm-6">
            <h3 class="text-center">Comparativo de Movimientos</h3>
            <canvas id="myChart"></canvas>
        </div>
        <div class="col col-sm-6">
            <h3 class="text-center">Movimientos por Agente</h3>
            <canvas id="myChartDoughnut"></canvas>
        </div>
    </div>
</div>
<br>
<br>
<br>



<div class="container">
    <div class="row justify-content-center">
        <div class="col col-sm-6">
            <h3 class="text-center">Historico de Movimientos</h3>
            <canvas id="myChartLine"></canvas>
        </div>
    </div>
   </div>
  </div>
</div>
<br>
<br>
<br>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Comandas', 'Caja', 'Movimiento Comandas', 'Movimiento Caja'],
            datasets: [{
                label: 'Movimiento del dia',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 4
            }]
        }
    });


    const DATA_COUNT = 5;
    const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};
    const ctx2 = document.getElementById('myChartDoughnut');
    const myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data : {
            labels: ['Agente1', 'Agente2', 'Agente3'],
            datasets: [
                {
                label: 'Dataset 1',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        }
    });




        const ctx3 = document.getElementById('myChartLine');
        const myChart3 = new Chart(ctx3, {
            type: 'line',
            data : {
                labels: ['Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio'],
                datasets: [
                    {
                    label: 'Dataset 1',
                    data: [300, 90, 100, 76, 230, 270],
                    backgroundColor: [
                        'rgb(255, 99, 132)'
                    ]
                    }
                ]
            }
        });


 }, true);


</script>


@endsection

