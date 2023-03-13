@extends('adminlte::page')

@section('title', 'Tipo de Transacción')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">TIPO DE TRANSACCIÓN <i class="fab fa-whatsapp-square"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    'Nombre',
    ['label' => 'Descripcion', 'width' => 40],
    ['label' => 'Editar', 'no-export' => true, 'width' => 5],
    ['label' => 'Eliminar', 'no-export' => true, 'width' => 5],
];




$config = [

    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear Tipo de transacción" href={{ route('type_transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Tipo de transacción</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">TIPOS DE TRANSACCIÓN</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($transactions as $transaction)
        <tr>

            <td>{!! $transaction->name !!}</td>
            <td>{!! $transaction->description !!}</td>

            <td class="pagination">

            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('type_transactions.edit', $transaction) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td class="text-center">
                <form method="post" action="{{ route('type_transactions.destroy', $transaction->id) }}">
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
