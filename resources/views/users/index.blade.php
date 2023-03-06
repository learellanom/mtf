@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE USUARIOS <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

    <div class="row">
         
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">USUARIOS</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example" class="table table-bordered table-striped">
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
                                            <td class="text-center"><button class="btn btn-danger"><i class='fas fa-trash'></i></button></td>
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