@extends('adminlte::page')

@section('title', 'Transferencias Proveedores')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE TRASANCCIONES | PROVEEDORES') }} <i class="fas fa-share"></i></h1></a>


@stop

@section('content')

{{-- Setup data for datatables --}}
@can('transactions_supplier.create')
<a class="btn btn-dark" title="Crear transacción a proveedor" href={{ route('transactions_supplier.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Transacción a proveedor') }}</span>
</a>
@endcan
<br><br>


<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Transacciones| Proveedores') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="transactions">
                            <thead>
                                <tr>
                                    <th>Agente</th>
                                    <th>Proveedor</th>
                                    <th>Tipo de transacción</th>
                                    <th>%</th>
                                    <th>Monto total</th>
                                    <th>Fecha de transacción</th>
                                    {{-- <th class="text-center">Editar</th> --}}
                                    @can('transactions_supplier.update_status')
                                    <th class="text-center">Activar/Anular</th>
                                    @endcan
                                    <th class="text-center">Ver</th>
                                </tr>
                            </thead>
                            @foreach($transferencia as $transferencias)
                                <tr>

                                    <td class="font-weight-bold">{!! $transferencias->user->name !!}</td>
                                    <td class="font-weight-bold">{!! $transferencias->supplier->name !!}</td>
                                    <td>{!! $transferencias->type_transaction->name !!}</td>
                                    <td class="font-weight-bold text-uppercase">{!! $transferencias->percentage ?? 'Transacción sin comisión' !!}</td>
                                    <td class="font-weight-bold">{!! $transferencias->amount_total !!} $</td>

                                    <td class="font-weight-bold">{!! $transferencias->transaction_date !!}</td>

                                    @can('transactions_supplier.update_status')
                                    <td class="text-center">
                                        {!! Form::model($transferencias->id, ['route' => ['transactions_supplier.update_status', $transferencias->id],'method' => 'put']) !!}

                                        @if($transferencias->status == 'Activo')
                                        <button class="btn btn-xl text-success mx-1 shadow text-center" title="Estatus">
                                            <i class="fa fa-lg fa-fw fas fa-check"></i>
                                        </button>

                                        @elseif($transferencias->status == 'Anulado')
                                        <button class="btn btn-xl text-danger mx-1 shadow text-center" title="Estatus">
                                            <i class="fa fa-lg fa-fw fas fa-times"></i>
                                        </button>
                                        @endif

                                        {!! Form::close() !!}
                                    </td>
                                    @endcan

                                     <td class="text-center">
                                        <a href="{{ route('transactions_supplier.show', $transferencias->id) }}" class="btn btn-xl text-dark mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-search"></i></a>
                                     </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function () {
    $('#transactions').DataTable( {

        language: {
        "decimal": "",
        "emptyTable": "No hay transacciones.",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
    "order": [[ 6, 'asc' ]],




    });
});
</script>
@endsection
