@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE | PERFIL DE USUARIO <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')

<div class="d-flex justify-content-center">
    <div class="card col-md-8">
        <div class="card-body">
            {!! Form::model($roles,['route' => ['roles.update', $roles], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}
                <div class="row">
                    <div class="col-xl-8 mb-4">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#home">Nombre del rol</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#menu1">Permisos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-2 mb-4 justify-content-end">
                        <button class="btn btn-primary font-weight-bold btn-block" type="submit">Guardar</button>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for=""> </label>
                    {!! Form::Label('name', 'Nombre del Role/Perfil: ') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}


                    @error('name')

                    <span class="text-danger">{{$message}}</span>

                    @enderror

                </div>      

                <br>
                <h4 class="font-weight-bold">{{ __('PERMISOS:') }}</h4>
                <hr>

                <table id="myTable" class="table table-bordered table-responsive-lg">   
                    <thead>
                        <tr>
                            <th style="width: 80%;">Nombre</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $permission)
                            <tr>
                                <td>{{$permission->description}}</td>
                                <td>{!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> '', 'id' => $permission->id ]) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    
     $(document).ready(function () {
         $('#myTable2').DataTable({
            "pageLength": 100
         }); 
     });

</script>
@endsection
