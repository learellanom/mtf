@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE USUARIOS <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

<a class="btn btn-dark" title="Crear usuarios" href={{ route('users.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block">Crear</span>
    <span class="d-none d-md-inline-block">Usuario</span>
</a>

<br><br>



    <div class="row">
         
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">USUARIOS</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="usuarios" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>E-mail</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Eliminar</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id }}</td>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td class="text-center"><a class="btn btn-primary" href={{route('users.edit', $usuario)}}><i class='fas fa-edit'></i></a></td>
                                            
                                            <form action={{route("users.destroy", $usuario)}} method="POST">
                                            @csrf
                                            @method('delete')
                                            <td class="text-center"><a class="btn btn-danger borrar_users" onclick="return confirm('Desea borrar?')" id='borrar_users'><i class='fas fa-trash'></i></a></td>
                                            </form>
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <div class="bg-white">
             {{$users->links()}}
          </div>
    </div>

     </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
 $(".borrar_users").attr("onclick", "").unbind("click"); //remove function onclick button

$(document).on('click', '.borrar_users', function () {
    let delete_form = $(this).parent().find();
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

                 swal.fire(
                    '¡Eliminado!',
                    'El usuario ha sido eliminado.',
                    'success'
                ) 
                delete_form.submit();

            }else{

                    swal.fire(
                    'Cancelado',
                    'La eliminación del usuario ha sido cancelada.',
                    'error'
                )

            }
        });
});
$(document).ready( function () {
$('#usuarios').DataTable();
    
} );
</script>
@endsection