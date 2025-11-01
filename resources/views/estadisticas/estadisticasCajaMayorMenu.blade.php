@extends('adminlte::page')

@section('title', 'Estadisticas Caja Mayor')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Estadisticas Caja Mayor') }} <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')



{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-6 container">
        <div class="card mb-4 shadow">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">{{ __('Estaditica Caja Mayor') }} <i class="fab fa-bitcoin"></i></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <style>
                            .myLink {
                                text-decoration: none;
                                color: black;
                                font-size: 1rem
                            }
                            .myLink:hover{
                                color:gray;
                            }
                            .myRow:hover {
                                
                                background-color: black;
                            }
                            </style>
                            <ul class="list-group" style="list-style-type: none">
                                <li class="mt-4">
                                        <a class="myLink" href="{{ route('balancePagosCobros') }}">
                                            <p>
                                                <i class="fas fa-fw fas fa-chart-bar "></i>
                                                Detalle de movimientos
                                            </p>
                                        </a>
                                </li>
                                <li class="mt-4">
                                        <a class="myLink" href="{{ route('cajaMayorCuadroMovimientos') }}">
                                            <p>
                                                <i class="fas fa-fw fas fa-chart-bar "></i>
                                                Cuadro de Movimientos
                                            </p>
                                        </a>                                    
                                </li>
                            </ul>
                            {{--
                        <table class="table table-responsive-lg" id="moneda" style="border: none">
                            <thead>
                            </thead>
                            <tbody>
                                <tr >
                                    <td>
                                        <a class="myLink" href="{{ route('balancePagosCobros') }}">
                                            <p>
                                                <i class="fas fa-fw fas fa-chart-bar "></i>
                                                Detalle de movimientos
                                            </p>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="myLink" href="{{ route('cajaMayorCuadroMovimientos') }}">
                                            <p>
                                                <i class="fas fa-fw fas fa-chart-bar "></i>
                                                Cuadro de Movimientos
                                            </p>
                                        </a>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
$(document).ready( function () {
    $('#monedaa').DataTable({

        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });

} );
</script>
@endsection
