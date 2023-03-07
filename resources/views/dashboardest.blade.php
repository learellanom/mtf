@extends('adminlte::page')

@section('plugins.chartJs', true)
@section('content')

echo "Dashboard estadisticas";
<div class="box-body">
    <div class="chart">
        <canvas id="myChart1"></canvas>
    </div>
</div>


            
<script src="../public/vendor/chart.js/Chart.bundle.min.js" ></script>
<script>


    
    var myChart = new Chart();

</script>


@endsection

