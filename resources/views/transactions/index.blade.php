@extends('adminlte::page')

@section('title', 'Transferencias')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE MOVIMIENTOS <i class="fas fa-people-arrows"></i> </h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}


@php


    # code...


$heads = [
    ['label' =>'Agente', 'width' => 10],
    ['label' => 'Cliente', 'width' => 15],
    ['label' => 'Caja usada', 'no-export' => true, 'width' => 10],
    ['label' => 'Tipo de transacción', 'no-export' => true, 'width' => 20],
    ['label' => 'Porcentaje %', 'no-export' => true, 'width' => 20],
    ['label' => 'Monto Total', 'width' => 50],
    ['label' => 'Fecha del movimiento', 'width' => 50],
    ['label' => 'Editar', 'no-export' => true, 'width' => 5],
    ['label' => 'Activar/Inactivar', 'no-export' => true, 'width' => 5],
];




$config = [

    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];


@endphp

<a class="btn btn-dark" title="Crear cliente" href={{ route('transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Añadir</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Transferencia</span>
</a>
<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Transferencias|Movimientos</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($transferencia as $transferencias)
        <tr>

            <td class="font-weight-bold">{!! $transferencias->user->name !!}</td>
            <td>{!! $transferencias->client->name !!}</td>
            <td>{!! $transferencias->wallet->name !!}</td>
            <td>{!! $transferencias->type_transaction->name !!}</td>
            <td class="font-weight-bold">{!! $transferencias->percentage !!}%</td>
            <td class="font-weight-bold">{!! $transferencias->amount_total !!} $</td>

            <td class="font-weight-bold">{!! $transferencias->transaction_date !!}</td>

            <td class="text-center">
                <a href="{{ route('transactions.edit', $transferencias->id) }}" class="btn btn-xl text-primary mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-edit"></i></a>
            </td>
            <td class="text-center">
                <form method="post" action="{{ route('transactions.destroy', $transferencias->id) }}">
                    @csrf
                    @method('delete')
                <button class="btn btn-xl text-danger mx-1 shadow text-center" type="submit" title="Borrar">
                    <i class="fa fa-lg fa-fw fas fa-times"></i>
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
