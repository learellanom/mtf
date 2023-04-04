@extends('adminlte::page')

@section('title', 'CAJAS')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE CAJAS <i class="fas fa-wallet"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    'Nombre',
    ['label' => 'Observación', 'width' => 40],
    ['label' => 'Dirección', 'width' => 40],
    ['label' => 'Opciones', 'no-export' => true, 'width' => 5],
    ['label' => 'Eliminar', 'no-export' => true, 'width' => 5],
];




$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear Caja" href={{ route('wallets.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Caja</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">CAJAS | WALLETS</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($wallets as $wallet)
        <tr>

            <td>{!! $wallet->name !!}</td>
            <td>{!! $wallet->description !!}</td>
            <td>{!! $wallet->direction !!}</td>

            <td class="pagination">
            <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
            </button>
            <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('wallets.edit', $wallet) }}" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>

            </td>
            <td class="text-center">
                <form method="post" action="{{ route('wallets.destroy', $wallet->id) }}">
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
