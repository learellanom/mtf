@extends('adminlte::page')

@section('title', 'Transacciones')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE TRANSACCIONES') }} <i class="fas fa-people-arrows"></i> </h1></a>


@stop

@section('content')

@can('transactions.create')
<a class="btn btn-dark" title="Crear transaccion" href={{ route('transactions.create') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Transacción') }}</span>
</a>
@endcan

<br><br>
{{-- Compressed with style options / fill data using the plugin config --}}

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Transacciones') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%;">Nro transacción</th>
                                    <th style="width:1%;">Cliente</th>
                                    <th style="display:none;">Token</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th style="width:1%;"><p style="display:none;">P - %</p><i class="fas fa-percentage"></i></th>
                                    <th style="width:15%;">Monto <i class="fas fa-globe-europe"></i> <p style="display:none;">Moneda Extranjera</p></th>
                                    <th style="width:1%;">Comisión</th>
                                    <th style="width:10%;">Monto Dolar <i class="fas fa-funnel-dollar"></i></th>
                                    <th style="width:10%;">Monto Total</th>
                                    <th>Agente</th>
                                    <th>Tipo de Movimiento</th>
                                    <th style="width:1%; display:none;">Caja <i class="fas fa-search"></i></th>
                                    @can('transactions.update_status')
                                    <th style="width:1%;">Activo/Anulado</th>
                                    @endcan
                                    @can('transactions.edit')
                                    <th style="width:1%;">Tasa/Comisión</th>
                                    @endcan
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>

                                </tr>
                            </thead>
                            @foreach($transferencia as $transferencias)

                                <tr>
                                    <td class="font-weight-bold">{{ $transferencias->id }}</td>
                                    <td class="font-weight-bold">
                                            {{ $transferencias->group->name ?? ''}}
                                    </td>

                                    <td class="font-weight-bold" style="display:none;">{!! $transferencias->token !!}</td>

                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->transaction_date !!}</td>

                                    <td class="font-weight-bold"><div style='width:60px; height:60px; overflow:hidden;'>{!!  $transferencias->description !!}</div></td>

                                    <td class="font-weight-bold">{!! $transferencias->percentage ?? ''!!} </td>

                                    <td>{!! number_format(abs($transferencias->amount_foreign_currency),2,",",".") ?? '' !!}</td>

                                    <td>{!! number_format(abs($transferencias->amount_commission),2,",",".") ?? '' !!} </td>

                                    <td class="font-weight-bold">{!!  number_format(abs($transferencias->amount),2,",",".") !!} <i class="fas fa-dollar-sign"></i></td>
                                    <td class="font-weight-bold">{!! number_format(abs($transferencias->amount_total),2,",",".") !!} <i class="fas fa-dollar-sign"></i></td>


                                    <td class="font-weight-bold">{!! $transferencias->user->name !!}</td>
                                    <td>{!! $transferencias->type_transaction->name !!}</td>
                                    <td style="display: none;">{!! $transferencias->wallet->name !!}</td>
                                    @can('transactions.update_status')
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
                                    @endcan
                                    @can('transactions.edit')
                                        <td class="text-center">
                                            <a href="{{route('transactions.edit', $transferencias->id)}}" class="btn btn-xl text-dark mx-1 shadow text-center"><i class="fas fa-lg fa-fw fa-coins"></i></a>
                                        </td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('transactions.show', $transferencias->id) }}" class="btn btn-xl text-dark mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-search"></i></a>
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
    "order": [[ 2, 'desc' ]],
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
            title: 'MTF | LISTA DE TRANSACIÓNES',
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
