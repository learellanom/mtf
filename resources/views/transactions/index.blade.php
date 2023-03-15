@extends('adminlte::page')

@section('title', 'Movimientos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE MOVIMIENTOS <i class="fas fa-exchange-alt"></i> </h1></a>


@stop



@section('content')

{{-- Setup data for datatables --}}


@php




$heads = [
    'Cliente',
    ['label' => 'Agente', 'width' => 20],
    ['label' => 'Tipo de moneda', 'no-export' => true, 'width' => 20],
    ['label' => 'Comision', 'no-export' => true, 'width' => 10],
    ['label' => 'Monto Total', 'no-export' => true, 'width' => 20],
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
        ['Grupo I', '100.000.00', 'EUR', '5,00', '110.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        ['Grupo II', '200.000.00','EUR','6,00', '210.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        ['Grupo III', '220.000.00','BRM','5,00', '120.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, ['orderable' => false]],
];
@endphp

<a class="btn btn-dark" title="Agregar movimientos" href={{ route('transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Agregar</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Movimientos</span>
</a>
<br><br>
<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">MOVIMIENTOS</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

<x-adminlte-datatable id="table2" :heads="$heads" head-theme="light" :config="$config"
    striped hoverable bordered compressed/>
            </div>
        </div>
    </div>
</div>

@endsection
