@extends('adminlte::page')
@section('title', 'Inicio')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Información general del sistema MTF') }}</div>
                <table class="table" id="card">
                    <thead>
                        <tr>
                            <th>CAJAS</th>
                        </tr>
                    </thead>
                    @foreach ($wallet as $wallets)
                  <tr>
                  <td>
                    <div class="card-body" id="cajas">


                        <x-adminlte-info-box title="{{ $wallets->NombreWallet }}" text="Saldo total: {{ number_format($wallets->Total) }} $" icon="fas fa-lg fa-box-open text-light"
                        theme="dark"
                        description="Saldo total: {{ number_format($wallets->Total) }} $"/>



                    </div>
                 </td>
                </tr>
                @endforeach
                </table>
                <div class="card-footer">

                </div>






                </div>

            </div>

         </div>


@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#card').DataTable( {

            language: {
            "decimal": "",
            "emptyTable": "No hay transacciones.",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 de 0 Entradas",
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
        info:false,
        });
    });
    </script>

@endsection
