@extends('adminlte::page')
@section('title', 'Inicio')

@section('content')

<div class="container">
    <div class="row justify-content-center  ">
            <img class="img-fluid" src="{{asset('logo.png')}}" alt="logo">
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
