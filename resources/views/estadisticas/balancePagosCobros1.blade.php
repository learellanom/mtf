@extends('adminlte::page')

@section('title', 'Balance ed Pagos y Corbros')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Balance de Pagos y Cobros') }} <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')



{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                {{-- <h3 class="card-title font-weight-bold">{{ __('Balance de Pagos y Cobros') }} <i class="fab fa-bitcoin"></i></h3> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="moneda">
                            <thead>
                                <tr>                                
                                    <th>Id</th>
                                    <th>Grupo</th>
                                    <th>Monto</th>
                                    <th>Monto Cobrado</th>
                                    <th>Monto Deuda</th>
                                    {{--
                                    <th class="text-center">Ver</th>
                                    --}}
                                </tr>
                            </thead>
                            
                            @foreach($Transacciones as $item)
                                @php 
                                    $myAmountDeuda = 0;
                                    $myAmountDeuda  = $item->amount_total - $item->monto_cobro;
                                    $myRowColor     = $myAmountDeuda  > 0 ? "red" : "black";
                                @endphp
                                <tr style="color: {{$myRowColor}}">

                                    <td>{!! $item->group_id!!}</td>
                                    <td>{!! $item->name!!}</td>
                                    {{-- <td>{!! $item->type_transaction_name!!}</td> --}}
                                    <td class="text-left">{!! number_format($item->amount_total,2)!!}</td>

                                    <td class="text-left">{!! number_format($item->monto_cobro,2)!!}</td>
                                    <td class="text-left">{!! number_format(($item->amount_total - $item->monto_cobro),2)!!}</td>
                                    {{--
                                    <td class="text-center">
                                                                                                       
                                        <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('transaction_requests.show', $item->group_id) }}" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                        --}}
                                </tr>
                            @endforeach
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
$(document).ready( function () {
    $('#moneda').DataTable({

        language: {
            "decimal": "",
            "emptyTable": "No hay información",
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
    });

} );
</script>
@endsection
