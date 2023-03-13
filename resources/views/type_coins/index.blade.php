@extends('adminlte::page')

@section('title', 'Tipo de Moneda')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">TIPO DE MONEDA <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    'Moneda',
    ['label' => 'Descripcion', 'width' => 40],
    ['label' => 'Editar', 'no-export' => true, 'width' => 5],
    ['label' => 'Eliminar', 'no-export' => true, 'width' => 5],
];




$config = [

    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear Tipo de Moneda" href={{ route('type_coins.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Tipo de Moneda</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">TIPOS DE MONEDA</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($types_coin as $coin)
        <tr>

            <td>{!! $coin->name !!}</td>
            <td>{!! $coin->description !!}</td>

            <td class="pagination">

            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('type_coins.edit', $coin) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td class="text-center">
                <form method="post" action="{{ route('type_coins.destroy', $coin->id) }}">
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
