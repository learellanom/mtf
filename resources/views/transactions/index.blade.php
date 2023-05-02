@extends('adminlte::page')

@section('title', 'Transacciones')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">LISTA DE TRANSACCIONES <i class="fas fa-people-arrows"></i> </h1></a>


@stop

@section('content')

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
                        <table class="table table-bordered table-responsive-lg" id="table">
                        <thead>
                            <tr>
                                <th style="width:1%;">Cliente</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th style="width:1%;"><i class="fas fa-percentage"></i></th>
                                <th style="width:1%;">Monto</th>
                                <th style="width:1%;">Comisión</th>
                                <th >Monto Dolar ($) <i class="fas fa-funnel-dollar"></i></th>
                                <th style="width:1%;">Monto Total</th>
                                <th>Agente</th>
                                <th>Tipo de Movimiento</th>
                                <th style="width:1%;">Activar/Anular</th>
                                <th style="width:1%;">Ver <i class="fas fa-search"></i></th>
                                <th style="width:1%; display:none;">Caja <i class="fas fa-search"></i></th>
                            </tr>
                        </thead>
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

            <td class="font-weight-bold"><div style='width:60px; height:60px; overflow:hidden;'>{!!  $transferencias->description !!}</div></td>

            <td class="font-weight-bold">{!! $transferencias->percentage ?? 'TRANSACCIÓN SIN PORCENTAJE'!!} </td>

            <td>{!! number_format($transferencias->amount_foreign_currency) ?? 'TRANSACCIÓN NO TIENE MONEDA EXTRANJERA' !!}</td>

            <td>{!! $transferencias->amount_commission ?? 'TRANSACCIÓN SIN COMISIÓN' !!} </td>





            <td class="font-weight-bold">{!! number_format($transferencias->amount) !!} <i class="fas fa-dollar-sign"></i></td>
            <td class="font-weight-bold">{!! number_format($transferencias->amount_total) !!} <i class="fas fa-dollar-sign"></i></td>


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


            <td>
               <a href="{{ route('transactions.show', $transferencias->id) }}" class="btn btn-xl text-dark mx-1 shadow text-center"><i class="fa fa-lg fa-fw fas fa-search"></i></a>
            </td>
            <td style="display: none;">{!! $transferencias->wallet->name !!}</td>

        </tr>
    @endforeach
    </table>
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
      background-color: rgb(47, 74, 150);
      color: rgb(31, 0, 206);
    }
    .table {
        width: 100%;
    }


  </style>
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
    "order": [[ 1, 'asc' ]],
    'dom' : 'Bfrtilp',
    'buttons':[
        {
            extend:  'excelHtml5',
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
                    "cells": "G",
                    "style": {
                        "numFmt": "#,##0.0000;(#,##0.0000)"
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
