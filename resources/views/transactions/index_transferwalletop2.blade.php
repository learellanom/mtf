@extends('adminlte::page')

@section('title', 'Transferencias')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('TRANSFERENCIAS ENTRE CAJAS - OTRAS OPERACIONES v2') }} <i class="fas fa-box"></i> </h1></a>


@stop

@section('content')

@can('transactions.create')
<a class="btn btn-dark" title="Crear transaccion" href={{ route('transactions.create_transferwalletop2') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Transferencias') }}</span>
</a>
@endcan

<br><br>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Transferencias entre cajas - otras operaciones') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th >Id</th>
                                    <th style="width:10%;">Nro transferencia</th>
                                    <th>Fecha</th>
                                    <th>Tranccion</th>
                                    <th>Descripción</th>
                                    <th style="width:10%;">Monto Total</th>
                                    <th>Moneda</th>
                                    <th class="no-exportar">Agente</th>
                                    <th>Tipo de Movimiento</th>
                                    <th style="width:10%;">Cajas </th>
                                    @can('transactions.update_status')
                                        <th style="width:1%;">Activo/Anulado</th>
                                    @endcan

                                    <th style="width:1%;" class="no-exportar">Ver <i class="fas fa-search"></i></th>

                                </tr>
                            </thead>
                            
                            @foreach($transactiones as $transferencias)

                                <tr>
                                    <td class="font-weight-bold">{{ $transferencias->TransactionId }}</td>
                                    <td class="font-weight-bold">{{ $transferencias->TransferNumber }}</td>
                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->TransactionDate !!}</td>
                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->TypeTransactionName !!}</td>
                                    <td class="font-weight-bold">
                                        <div style='height:60px; overflow:hidden;'>
                                            {!!  $transferencias->Description !!}
                                        </div>
                                    </td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->Amount) !!} <i class="fas fa-dollar-sign"></i></td>
                                    <td>{!! $transferencias->TypeCoinBalanceName !!}</td>
                                    <td class="font-weight-bold">{!! $transferencias->Agente !!}</td>
                                    <td>{!! $transferencias->TransferType !!}</td>
                                    <td>{!! $transferencias->WalletNameOrigen !!}</td>
                                    @can('transactions.update_status')
                                        <td class="text-center">
                                            {!! Form::model($transferencias->TransactionId, ['route' => ['transactions.update_statusop2', $transferencias->TransactionId], 'method' => 'put']) !!}

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
            "order": [[ 1, 'desc' ]],
            'dom' : 'Bfrtip',
            'buttons':[
                {
                    extend:  'excelHtml5',
                    exportOptions: {
                    columns: ":not(.no-exportar)" //exportar toda columna que no tenga la clase no-exportar
                    },
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
                            'cells': "sB",
                            'template': "date_long",
                        },
                        {
                            "cells": "F",
                            "width": "40",
                            "style": {
                                "numFmt": "#,##0;(#,##0)",
                            },

                        },
                        {
                            "cells": "A",
                            "width": "25.86",
                        },
                        {
                            "cells": "B",
                            "width": "19",
                        },
                        {
                            "cells": "C",
                            "width": "21.71",
                        },
                        {
                            "cells": "D",
                            "width": "21",
                        },
                        {
                            "cells": "E",
                            "width": "31.43",
                        },
                        {
                            "cells": "F",
                            "width": "20",
                        },
                        {
                            "cells": "G",
                            "width": "24",
                            "style": {
                                "font": {                 // Style the font
                                        "b": true,
                                        },
                            },
                        }
                    ]
                },
                {
                    extend:  'pdfHtml5',
                    text:    '<i class="fas fa-file-pdf"></i>',
                    orientation: 'landscape',
                    title: 'MTF | TRANSACCIONES ENTRE CAJAS',
                    titleAttr: 'Exportar PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ":not(.no-exportar)" //exportar toda columna que no tenga la clase no-exportar
                    },
                    customize: function ( doc ) {
                        doc.styles.tableHeader = {
                            fillColor:'#525659',
                            color:'#FFF',
                            fontSize: '10',
                            alignment: 'center',
                            bold: true
                        },
                        doc.content.splice(1, 0, {
                            columns: [ {
                                margin: [40, 30],
                                text: 'MTF |TRANSFERENCIAS ENTRE CAJAS',
                                fontSize: 30,
                                bold: true
                            }]
                        }),
                        doc.defaultStyle.fontSize = 13;
                        doc.pageMargins = [50,50,50,60];
                        doc.content[1].margin = [ 5, 0, 0, 0];
                        doc.styles.title = {
                            color: 'dark',
                            fontSize: '1',
                            alignment: 'left'
                        }
                        doc.styles['td:nth-child(2)'] = {
                            width: '200px',
                            'max-width': '200px',
                        }
                        doc.styles.tableHeader = {
                            fillColor:'#0B2447',
                            color:'white',
                            alignment: 'center',

                        }
                        doc.styles.tableBody = {
                            alignment: 'center'
                        }
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyEven.alignment = 'center';
                    },
                },
            ]    
        });
    });
    </script>
@endsection
