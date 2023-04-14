@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE ROLES <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')

<a class="btn btn-dark" title="Crear Roles" href={{ route('roles.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Role</span>
</a>

<br><br>



    <div class="row">

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">ROLES</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="roles" class="table table-bordered table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>

                                            <td>{{ $role->name }}</td>
                                            <td class="text-center"><a class="btn btn-primary" href={{route('roles.edit', $role->id)}}><i class='fas fa-edit'></i></a></td>

                                            <form method="post" action="{{ route('roles.destroy', $role->id) }}" class="p-6">
                                                @csrf
                                                @method('delete')

                                             <td class="text-center">
                                                <button class="btn btn-danger borrar_role" type="submit"><i class='fas fa-trash'></i></button>
                                            </td>
                                            </form>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <div class="bg-white">

          </div>
    </div>

     </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready( function () {
$('#roles').DataTable({

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
