@extends('adminlte::page')

@section('title', 'Tipo de Moneda')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('TIPO DE MONEDA') }} <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')


<a class="btn btn-dark" title="Crear Tipo de Moneda" href={{ route('type_coins.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Tipo de Moneda') }}</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">{{ __('TIPO DE MONEDA') }} <i class="fab fa-bitcoin"></i></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                <table class="table table-bordered table-responsive-lg" id="moneda">
                    <thead>
                        <tr>

                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>


                        </tr>



                    </thead>



    @foreach($types_coin as $coin)
        <tr>

            <td>{!! $coin->name !!}</td>
            <td>{!! $coin->description !!}</td>

            <td class="text-center">

            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('type_coins.edit', $coin) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td class="text-center">
                <form method="post" action="{{ route('type_coins.destroy', $coin->id) }}">
                    @csrf
                    @method('delete')
                <button class="btn btn-xl text-danger mx-1 shadow" type="submit" title="Borrar">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                </form>
            </td>

        </tr>
    @endforeach
    </table>
   </div>
  </div>
 </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready( function () {
$('#moneda').DataTable({

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
