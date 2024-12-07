@extends('adminlte::page')

@section('title', 'Tipo de Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('OPERACIONES') }} <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')



{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                {{-- <h3 class="card-title font-weight-bold">{{ __('OPERACIONES') }} <i class="fab fa-bitcoin"></i></h3> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="moneda">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Descripción</th>
                                    <th>Name</th>
                                    <th class="text-center">Ver</th>
                                </tr>
                            </thead>
                            
                            @foreach($Transaction_request as $item)
                                <tr>

                                    <td>{!! $item->id!!}</td>
                                    <td>{!! $item->transaction_date!!}</td>
                                    <td>{!! $item->status!!}</td>
                                    <td class="text-right">{!! number_format($item->amount,2)!!}</td>
                                    <td>{!! $item->description !!}</td>
                                    <td>{!! $item->name !!}</td>
                                    <td class="text-center">
                                                                                                       
                                        <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('transaction_requests.show', $item) }}" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>

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
