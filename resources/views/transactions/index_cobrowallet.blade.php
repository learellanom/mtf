@extends('adminlte::page')

@section('title', 'Cobros del Proveedor')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Cobros del Proveedor') }} <i class="fas fa-box"></i> </h1></a>


@stop

@section('content')

@can('transactions.create_cobrowallet')
<a class="btn btn-dark" title="Crear transaccion" href={{ route('transactions.create_cobrowallet') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Cobros') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('al Proveedor') }}</span>
</a>
@endcan

<br><br>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Cobros del Proveedor') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%;">Nro transferencia</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th style="width:10%;">Monto Total</th>
                                    <th style="width:10%;">Porcentaje Base</th>
                                    <th style="width:10%;">Comisión Base</th>
                                    <th style="width:10%;">Monto Total Base</th>
                                    <th>Agente</th>
                                    <th>Tipo de Movimiento</th>
                                    <th style="width:10%;">Caja <i class="fas fa-box"></i></th>
                                    @can('transactions.update_status')
                                    <th style="width:1%;">Activo/Anulado</th>
                                    @endcan
                                    <th style="width:1%;">Comisión</th>
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>

                                </tr>
                            </thead>

                            @foreach($transactiones as $transferencias)

                                <tr>
                                    <td class="font-weight-bold">{{ $transferencias->TransferNumber }}</td>


                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->TransactionDate !!}</td>

                                    <td class="font-weight-bold"><div style='width:60px; height:60px; overflow:hidden;'>{!!  $transferencias->Description !!}</div></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->Amount) !!} <i class="fas fa-dollar-sign"></i></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->PorcentageBase,2) !!}</td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->ComisionBase,2) !!} <i class="fas fa-dollar-sign"></i></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->TotalBase) !!} <i class="fas fa-dollar-sign"></i></td>



                                    <td class="font-weight-bold">{!! $transferencias->Agente !!}</td>
                                    <td>{!! $transferencias->TransferType !!}</td>
                                    <td>{!! $transferencias->WalletNameOrigen !!}</td>
                                    @can('transactions.update_status')
                                        <td class="text-center">
                                            {!! Form::model($transferencias->TransactionId, ['route' => ['transactions.updatestatus_pago', $transferencias->TransactionId], 'method' => 'put']) !!}

                                                @if($transferencias->estatus == 'Activo')
                                                <button class="btn btn-xl text-success mx-1 shadow text-center" title="Activo">
                                                    <i class="fa fa-lg fa-fw fas fa-check"></i><p style="display: none;">Activo</p>
                                                </button>

                                                @elseif($transferencias->estatus == 'Anulado')
                                                <button class="btn btn-xl text-danger mx-1 shadow text-center" title="Anulado">
                                                    <i class="fa fa-lg fa-fw fas fa-times"></i><p style="display: none;">Anulado</p>
                                                </button>
                                                @endif
                                            {!! Form::close() !!}
                                        </td>
                                    @endcan


                                    <td>
                                        @if($transferencias->ExonerateBase == 1)
                                        <span class="badge badge-success text-uppercase h4">Incluida <i class="fa fa-check" aria-hidden="true"></i></span>
                                        @elseif($transferencias->ExonerateBase == 2)
                                        <span class="badge badge-primary text-uppercase h4">Exonerada<i class="fas fa-minus" aria-hidden="true"></i> </span>
                                        @else
                                        <span class="badge badge-warning text-uppercase h4">Descontada <i class="fa fa-arrow-alt-circle-down" aria-hidden="true"></i></span>
                                        @endif
                                    </td>



                                    <td>
                                        <a href="{{ route('transactions.show', $transferencias->TransactionId) }}" class="btn btn-xl text-dark mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-search"></i></a>
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
@section('css')

@endsection
@section('js')
<script>
$(document).ready(function () {
    $('#table').DataTable( {

        language: {
        "decimal": "",
        "emptyTable": "No hay transacciones.",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 de 0 Entradas",
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
    //"order": [[ 2, 'desc' ]],
    'dom' : 'Bfrtilp',
    'buttons':[
        {
            extend:  'excelHtml5',
            exportOptions: { columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12 ] },
            text:    '<i class="fas fa-file-excel"></i>',
            titleAttr: 'Exportar Excel',
            className: 'btn btn-success',
            "excelStyles": [
            {
                "template": ["title_medium", "gold_medium"]
            },

            {
                "cells": "2",
                "style": {
                    "font": {
                        "size": "18",
                        "color": "FFFFFF"
                    },
                    "fill": {
                        "pattern": {
                            "type": "solid",
                            "color": "002B5B"
                        }
                    },

                }
            },
            {
                "cells": "1",
                "style": {
                    "font": {
                        "size": "20",
                        "color": "FFFFFF"
                    },
                    "fill": {
                        "pattern": {
                            "size": "25",
                            "type": "solid",
                            "color": "0B2447",
                        }
                    }
                }
            },
            {
            "cells": "sF",
            "condition": {
                "type": "dataBar",
                "dataBar": {
                    "color": [
                        "0081B4"
                    ]
                }
              }
            },
             {
                "cells": "sE",
            "condition": {
                "type": "dataBar",
                "dataBar": {
                    "color": [
                        "0081B4"
                    ]
                  }
                 }
              },
                {
                    'cells': "sB",
                    'template': "date_long",
                },
                {
                    "cells": "F",
                    "style": {
                        "numFmt": "#,##0;(#,##0)"
                    }
                }
           ]

        },
        {
            extend:  'pdfHtml5',
            text:    '<i class="fas fa-file-pdf"></i>',
            orientation: 'landscape',
            title: 'MTF | Pagos del Proveedor',
            titleAttr: 'Exportar PDF',
            className: 'btn btn-danger',

        },
        {
            extend:  'print',
            text:    '<i class="fas fa-print"></i>',
            titleAttr: 'Capture de pantalla',
            className: 'btn btn-info'
        },
    ]



    });
});
</script>
@endsection
