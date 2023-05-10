@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE USUARIOS') }} <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

@can('users.create')
<a class="btn btn-dark" title="Crear usuarios" href={{ route('users.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Usuario') }}</span>
</a>
@endcan

<br><br>
    <div class="row">

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">{{ __('USUARIOS') }} <i class="fas fa-users"></i></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table id="usuarios" class="table table-bordered table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>E-mail</th>
                                        @can('users.password')
                                        <th class="text-center">Contraseña</th>
                                        @endcan
                                        @can('users.edit')
                                        <th class="text-center">Editar</th>
                                        @endcan
                                        @can('users.destroy')
                                        <th class="text-center">Eliminar</th>
                                        @endcan
                                    </tr>
                                </thead>

                                    @foreach ($users as $usuario)
                                    <tbody>
                                        <tr>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            @can('users.password')
                                            <td class="text-center"><a class="btn btn-primary" href={{route('users.password', $usuario)}}><i class='fas fa-lock'></i></a></td>
                                            @endcan
                                            @can('users.edit')
                                            <td class="text-center"><a class="btn btn-primary" href={{route('users.edit', $usuario)}}><i class='fas fa-edit'></i></a></td>
                                            @endcan

                                            @can('users.destroy')
                                            <td class="text-center">
                                            <form method="post" action="{{ route('users.destroy', $usuario->id) }}" class="p-6">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger borrar_users" type="submit"><i class='fas fa-trash'></i></button>
                                            </form>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    </div>

  </div>
</div>


@endsection



@section('js')

@if (session('destroy') == 'ok')
    <script>
        Swal.fire
        ({
            title = 'Eliminado',
            text = 'Usuario eliminado',
            type = "success",
            allowOutsideClick = false,
            allowEscapeKey = false,
            allowEnterKey = false,
            width = "300",
            icon = "success"
        })
    </script>
@endif

<script type="text/javascript">
$(document).ready(function () {
  $('.borrar_users').submit(function (e) {
            e.preventDefault();
            //e.stopImmediatePropagation();
            swal.fire({
                title: "¿Desea eliminar al usuario?",
                text: "Una vez eliminado/a, no se podra recuperar a este usuario.",
                icon: "warning",
                confirmButtonText: 'Si, eliminar',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',

            }).then((result) => {
                    if (result.value) {


                        this.submit();

                    }else{

                            swal.fire(
                            'Cancelado',
                            'La eliminación del usuario ha sido cancelada.',
                            'error'
                        )

                    }
                });
        });
    });
$(document).ready( function () {
$('#usuarios').DataTable({
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

});
</script>
@endsection
