@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE CLIENTES <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php




$heads = [
    'ID',
    'Nombre del Cliente',
    ['label' => 'Telefono', 'width' => 40],
    ['label' => 'Opciones', 'no-export' => true, 'width' => 5],
];



$btnEdit = '<button class="btn btn-xl text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button class="btn btn-xl text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xl text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        [22, 'John Bender', '+58 424275899', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, 'Sophia Clemens', '+1 555-555888', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3, 'Peter Sousa', '+1 552 5558 88', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

<a class="btn btn-dark" title="Crear cliente" href={{ route('clients.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block">Crear</span>
    <span class="d-none d-md-inline-block">Cliente</span>
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
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light" :config="$config"
    striped hoverable bordered compressed/>
   </div>
  </div>
 </div>
</div>
@endsection 