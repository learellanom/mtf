@extends('adminlte::page')

@section('title', 'Transacciones')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE TRANSACCIONES <i class="fas fa-people-arrows"></i> </h1></a>


@stop

@section('content')

@php


    # code...


$heads = [
    ['label' => 'Cliente', 'width' => 10],
    ['label' =>'Fecha', 'width' => 10],
    ['label' => 'Descripción', 'width' => 15],
    ['label' => '%', 'no-export' => true, 'width' => 5],
    ['label' => 'Monto (Moneda Extranjera)', 'no-export' => true, 'width' => 20],
    ['label' => 'Comisión', 'no-export' => true, 'width' => 10],
    ['label' => 'Monto Dolar ($)', 'width' => 15],
    ['label' => 'Monto Total', 'width' => 60],
    ['label' => 'Agente', 'width' => 50],
    ['label' => 'Tipo de Movimiento', 'width' => 50],
    ['label' => 'Activar/Anular', 'no-export' => true, 'width' => 5],
];

$config = [

    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

@endphp

<a class="btn btn-dark" title="Crear transaccion" href={{ route('transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">Crear</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">Transacción</span>
</a>

<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">Transacciones</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
<x-adminlte-datatable id="table" :heads="$heads" head-theme="light"
    striped hoverable bordered compressed>

    @foreach($transferencia as $transferencias)
        <tr>

            <td>
                @if($transferencias->group == null && $transferencias->client == null)
                   <span class="font-weight-bold"> TRANSACCIÓN SIN CLIENTE </span>
                @elseif($transferencias->group)
                    {{ $transferencias->group->name }}
                @else
                    {{ $transferencias->client->name  }}
                @endif

            </td>
            <td class="font-weight-bold">{!! $transferencias->transaction_date !!}</td>

            <td class="font-weight-bold">{!! $transferencias->description !!}</td>

            <td class="font-weight-bold">{!! $transferencias->percentage ?? 'TRANSACCIÓN SIN PORCENTAJE'!!} </td>

            <td>{!! $transferencias->amount_foreign_currency ?? 'TRANSACCIÓN NO TIENE MONEDA EXTRANJERA' !!}</td>

            <td>{!! $transferencias->amount_commission ?? 'TRANSACCIÓN SIN COMISIÓN' !!} </td>





            <td class="font-weight-bold">{!! $transferencias->amount !!} $</td>
            <td class="font-weight-bold">{!! $transferencias->amount_total !!} $</td>


            <td class="font-weight-bold">{!! $transferencias->user->name !!}</td>
            <td>{!! $transferencias->type_transaction->name !!}</td>

          {{--   @if ($transferencias->type_transaction->name == 'Credito de efectivo')
            <td class="text-center">
                <a href="{{ route('transactions.credit_edit', $transferencias->id) }}" class="btn btn-xl text-primary mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-edit"></i></a>
            </td>
            @elseif($transferencias->wallet->type_wallet == 'Efectivo')
            <td class="text-center">
                <a href="{{ route('transactions.edit_efectivo', $transferencias->id) }}" class="btn btn-xl text-primary mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-edit"></i></a>
            </td>
            @else
            <td class="text-center">
                <a href="{{ route('transactions.edit', $transferencias->id) }}" class="btn btn-xl text-primary mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-edit"></i></a>
            </td>
            @endif --}}


            <td class="text-center">
                  {!! Form::model($transferencias->id, ['route' => ['transactions.update_status', $transferencias->id],'method' => 'put']) !!}

                    @if($transferencias->status == 'Activo')
                    <button class="btn btn-xl text-success mx-1 shadow text-center" title="Activo">
                        <i class="fa fa-lg fa-fw fas fa-check"></i><p style="display: none;">Activo</p>
                    </button>

                    @elseif($transferencias->status == 'Anulado')
                    <button class="btn btn-xl text-danger mx-1 shadow text-center" title="Anulado">
                        <i class="fa fa-lg fa-fw fas fa-times"></i><p style="display: none;">Anulado</p>
                    </button>
                    @endif
                {!! Form::close() !!}
            </td>


        </tr>
    @endforeach
</x-adminlte-datatable>
   </div>
  </div>
 </div>
</div>
@endsection
@section('css')
<style>
    .container {
      text-align: center;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgb(255, 255, 255);
    }

    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.7);
      color: rgb(223, 223, 223);
    }

    .thead-green {
      background-color: rgb(7, 39, 126);
      color: rgb(31, 0, 206);
    }

  </style>
@endsection
