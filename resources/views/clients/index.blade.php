@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE CLIENTES <i class="fas fa-user-tag"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    'Nombre',
    ['label' => 'Telefono', 'width' => 40],
    ['label' => 'Email', 'width' => 40],
    ['label' => 'Opciones', 'no-export' => true, 'width' => 5],
    ['label' => 'Eliminar', 'no-export' => true, 'width' => 5],
];




$config = [

    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear cliente" href={{ route('clients.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Cliente</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">CLIENTES</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($clients as $clientes)
        <tr>

            <td>{!! $clientes->name !!}</td>
            <td>{!! $clientes->phone !!}</td>
            <td>{!! $clientes->email !!}</td>

            <td class="pagination">
            <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
            </button>
            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('clients.edit', $clientes) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td>
                <form method="post" action="{{ route('clients.destroy', $clientes->id) }}">
                    @csrf
                    @method('delete')
                <button class="btn btn-xl text-danger mx-1 shadow" type="submit" title="Borrar">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                </form>
            </td>

        </tr>
    @endforeach
</x-adminlte-datatable>
   </div>
  </div>
 </div>
</div>
@endsection
