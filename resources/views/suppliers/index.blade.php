@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE PROVEEDORES') }} <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    'Nombre',
    ['label' => 'Observación', 'width' => 40],
    ['label' => 'Dirección', 'width' => 40],
    ['label' => 'Opciones', 'no-export' => true, 'width' => 5],
    ['label' => 'Eliminar', 'no-export' => true, 'width' => 5],
];




$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear Proveedor" href={{ route('suppliers.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Proveedor') }}</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">{{ __('PROVEEDORES') }} <i class="fas fa-people-carry"></i></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<table class="table table-bordered table-responsive-lg" id="proveedores">
    <thead>

        <tr>
            <th>Nombre</th>
            <th>Telefono</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Elimnar</th>

        </tr>



    </thead>
    @foreach($proveedor as $proveedores)
        <tr>

            <td>{!! $proveedores->name !!}</td>
            <td>{!! $proveedores->phone !!}</td>

            <td class="text-center">

            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('suppliers.edit', $proveedores) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td class="text-center">
                <form method="post" action="{{ route('suppliers.destroy', $proveedores->id) }}">
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
$('#proveedores').DataTable({

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
