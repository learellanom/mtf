@extends('adminlte::page')

@section('title', 'Movimientos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE MOVIMIENTOS <i class="fas fa-exchange-alt"></i> </h1></a>


@stop



@section('content')

{{-- Setup data for datatables --}}


@php




$heads = [
    'ID',
    'Cliente',
    ['label' => 'Saldo', 'width' => 40],
    ['label' => 'Tipo de moneda', 'no-export' => true, 'width' => 5],
    ['label' => 'Tasa', 'no-export' => true, 'width' => 5],
    ['label' => 'Equivalente en $', 'no-export' => true, 'width' => 5],
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
        [22, 'John Bender', '100.000.00', 'EUR', '5,00', '110.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, 'Sophia Clemens', '200.000.00','EUR','6,00', '210.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3, 'Peter Sousa', '220.000.00','BRM','5,00', '120.000.000', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
];
@endphp

<a class="btn btn-dark" title="Agregar movimientos" href={{ route('transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Agregar</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Movimientos</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}
<x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
    striped hoverable bordered compressed/>

@endsection
