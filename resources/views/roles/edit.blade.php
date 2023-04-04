@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">MODIFICAR ROLE | PERFIL DE USUARIO <i class="fas fa-user-shield"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="card col-md-4">
    <div class="card-body">
        {!! Form::model($roles,['route' => ['roles.update', $roles], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}

<ul class="nav nav-pills">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">Nombre del rol</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1">Permisos</a>
    </li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane container active" id="home">
        <br>
        <div class="form-group">
            <label for=""> </label>
            {!! Form::Label('name', 'Nombre del Role/Perfil: ') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}


            @error('name')

             <span class="text-danger">{{$message}}</span>

            @enderror

        </div>
    </div>


    <div class="tab-pane container fade" id="menu1">

        <br>
        <h4 class="font-weight-bold">PERMISOS:</h4>
        <hr>
        @foreach($permisos as $permission)
        <div class="list-group">

            <label class="list-group-item list-group-item-action">

                {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> '', 'id' => $permission->id ]) !!}
                {{$permission->description}}

            </label>
            <hr>
        </div>

        @endforeach


    </div>




  </div>









            <button class="btn btn-primary text-uppercase font-weight-bold btn-block" type="submit">Guardar</button>

       </form>
         </div>
    </div>
</div>
@endsection
