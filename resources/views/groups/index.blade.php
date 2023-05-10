@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE GRUPOS') }} <i class="fab fa-whatsapp-square"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}

<a class="btn btn-dark" title="Crear cliente" href={{ route('groups.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Grupo') }}</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">{{ __('GRUPOS') }} <i class="fas fa-user-friends"></i></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                <table id="grupo" class="table table-bordered table-responsive-lg">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Descripción</th>
                        <th class="text-center">Ver/Editar</th>
                        <th>Eliminar</th>
                    </tr>


                </thead>

                @foreach($groups as $group)
                    <tr>

                        <td>{!! $group->name !!}</td>
                        <td>{!! $group->phone !!}</td>
                        <td>{!! $group->description !!}</td>

                        <td class="pagination">
                        <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                        <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('groups.edit', $group) }}" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>

                        </td>
                        <td class="text-center">
                            <form method="post" action="{{ route('groups.destroy', $group->id) }}">
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
<script>
$(document).ready(function () {
    $('#grupo').DataTable( {

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
    "order": [[ 1, 'asc' ]],




    });
});
</script>
@endsection
