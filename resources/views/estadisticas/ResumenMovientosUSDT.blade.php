@extends('adminlte::page')

@section('title', 'RESUMEN USDT')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">Resumen Movientos USDT <i class="fas fa-people-arrows"></i> </h1></a>

@stop
@php
    $config1 =
    [
        "allowClear" => true,
    ];

    $config2 =
    [
        "allowClear" => true,
    ];

    $config3 = [
        "locale" => ["format" => "DD-MM-YYYY"],
        "allowClear" => true,
    ];

    
    $myClass	        = new App\Http\Controllers\TransactionController;
    $myAdministrator    = $myClass->isAdministrator();

@endphp 


@section('content')



<br>
<br>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <p class="text-uppercase font-weight-bold col-12 col-lg-4">
                Resumen de Movientos USDT
            </p>
        </div>
        <div class="row">
            
            <div class ="col-12 col-lg-2 float-right" >
                <x-adminlte-date-range
                    id="drCustomRanges"
                    name="drCustomRanges"
                    enable-default-ranges="Last 30 Days"
                    style="height: 30px;"
                    :config="$config3">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
            </div>
            

            <div class ="col-12 col-sm-2">
                <x-adminlte-select2 id="wallet"
                                    name="optionsCliente"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Wallet ..."
                                    :config="$config1"
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <i class="fas fa-box"></i>
                        </div>
                    </x-slot>

                    <x-adminlte-options :options="$wallet" empty-option="Selecciona un Wallet.."/>
                </x-adminlte-select2>
            </div>

            {{--
            <div class ="col-12 col-sm-2">
                <x-adminlte-select2 id="group"
                                    name="optionsGroup"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Grupo ..."
                                    :config="$config2"
                                    disabled
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </x-slot>

                    <x-adminlte-options :options="$group" empty-option="Selecciona un Grupo.."/>
                </x-adminlte-select2>
            </div>
            --}}

            {{--
            @if($myAdministrator == true)
                <div class ="col-12 col-lg-2">
                    <x-adminlte-select2 id="usuario"
                                        name="optionsUsuario"
                                        igroup-size="sm"
                                        label-class="text-lightblue"
                                        data-placeholder="Usuario ..."
                                        :config="$config2"
                                        >
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-dark">
                                <!-- <i class="fas fa-car-side"></i> -->
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </x-slot>

                        <x-adminlte-options :options="$user" empty-option="Selecciona un Usuario.."/>
                    </x-adminlte-select2>
                </div>
            @endif
            --}}

            {{--
            <div class ="col-lg-2">
                <x-adminlte-select2 id="coin"
                                    name="optionsCoin"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Moneda ..."
                                    :config="$config1"
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <!-- <i class="fas fa-user-tie"></i> -->
                            <i class="fas fa-solid fa-dollar-sign"></i>                        
                        </div>
                        
                    </x-slot>

                    <x-adminlte-options :options="$Type_coin_balance" empty-option="Selecciona una moneda.."/>

                </x-adminlte-select2>
            </div>
            --}}

            {{--
            <div class ="col-lg-2">
                <x-adminlte-select2 id="type_material_id"
                                    name="type_material_id"
                                    igroup-size="sm"
                                    label-class="text-lightblue"
                                    data-placeholder="Material ..."
                                    :config="$config1"
                                    >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-dark">
                            <!-- <i class="fas fa-car-side"></i> -->
                            <!-- <i class="fas fa-user-tie"></i> -->
                            <i class="fas fa-solid fa-dollar-sign"></i>                        
                        </div>
                        
                    </x-slot>

                    <x-adminlte-options :options="$Type_material" empty-option="Selecciona un material.."/>

                </x-adminlte-select2>
            </div>
            --}}
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive" id="table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:1%;"   >Id</th>
                            <th style="width:1%;"   >Wallet</th>
                            <th style="width:1%;"   >Saldo<br>Anterior</th>
                            <th style="width:1%;"   >Entrada <br> Cant</th>
                            <th style="width:1%;"   >Entrada <br> Monto</th>
                            <th style="width:1%;"   >Salida <br> Cant</th>
                            <th  style="width:1%;"  >Salida <br> Monto</th>
                            <th  style="width:1%;"  >Saldo</th>                          
                            <th style="width:1%;" class="no-exportar">Ver <i class="fas fa-search"></i></th>
                        </tr>
                    </thead>
                        @foreach($Transacciones as $movimiento)
                            <tr>
                                <td class="font-weight-bold">{{ $movimiento->WalletId }}</td>
                                <td class="font-weight-bold">{{ $movimiento->WalletName ?? "" }}</td>
                                <td>{!! number_format($movimiento->balanceBefore,2)       ?? '' !!}</td>
                                <td>{!! number_format($movimiento->EntradaCant)     ?? '' !!}</td>
                                <td>{!! number_format($movimiento->EntradaAmount,2)  ?? '' !!}</td>
                                <td>{!! number_format($movimiento->SalidaCant)      ?? '' !!}</td>
                                <td>{!! number_format($movimiento->SalidaAmount,2)   ?? '' !!}</td>
                                <td>{!! number_format($movimiento->totalPendienteUSDTMonto,2)       ?? '' !!}</td>
                                <td>
                                    <a href="{{ route('USDTResumenDiario', $movimiento->WalletId ) }}"
                                        class="btn btn-xl text-dark mx-1 shadow text-center">
                                        <i class="fa fa-lg fa-fw fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                </table>
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
            "emptyTable": "Sin transacciones registradas, seleccione un criterio de busqueda.",
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
        "order": [[ 3, 'desc' ]],
        'dom' : 'Bfrtip',
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [ 1, 2, 3,4,5,6,7,8,9,11,12 ] },
                text:    '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',
                "excelStyles": [
                {
                    "template": ["title_medium", 'blue_gray_medium']
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
                        'cells': "sC",
                        'template': "date_long",
                    },

                    {
                        "cells": "F",
                        "width": "40",
                    },
                    {
                        "cells": "B",
                        "width": "12",
                    },
                    {
                        "cells": "D",
                        "width": "17.5",
                    },
                    {
                        "cells": "I",
                        "width": "19.15",
                    },
                    {
                        "cells": "J",
                        "width": "35",
                    },
                    {
                        "cells": "H",
                        "width": "19.15",

                    },
                    {
                        "cells": "G",
                        "width": "15",
                    },
                    {
                        "cells": "K",
                        "width": "32",
                    },
                    {
                        "cells": "B",
                        "width": "11",
                    }
            ]

            },
            {
                extend:  'pdfHtml5',
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'MTF | RESUMEN DE MOVIENTOS USDT',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',

                exportOptions: {
                columns: ":not(.no-exportar)" //exportar toda columna que no tenga la clase no-exportar
                },
                customize: function ( doc ) {
                    doc.styles.tableHeader = {
                        fillColor:'#525659',
                        color:'#FFF',
                        fontSize: '8',
                        alignment: 'left',
                        bold: true
                    },

                    doc.content.splice(1, 0, {
                        columns: [ {
                            margin: [40, 30],
                            text: 'MTF |LISTA DE TRANSACCIÓNES',
                            fontSize: 30,
                            bold: true
                        }]
                    }),
                    doc.defaultStyle.fontSize = 10;
                    doc.pageMargins = [50,50,30,30];
                    doc.content[1].margin = [ 5, 0, 0, 5];
                    doc.styles.title = {
                            color: 'dark',
                            fontSize: '1',
                            alignment: 'center'
                        }
                    doc.styles['td:nth-child(2)'] = {
                        width: '100px',
                        'max-width': '100px'
                    }
                    doc.styles.tableHeader = {
                        fillColor:'#0B2447',
                        color:'white'
                    }
                },

            },
        ]
        });
    });

    const myWallet = {!! $myWallet !!};
    BuscaElemento('wallet',myWallet);

    $(() => {

        BuscaFechas();

        $('#drCustomRanges').on('change', function () {

            fechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(3,2) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(0,2)
                        ;

            fechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(16,2) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(13,2)
                        ;
            theRoute(fechasDesde, fechaHasta);

        });

        $('#wallet, #group').on('change', function () {
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });        

        $('#usuario').on('change', function () {
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });


		$('#type_material_id').on('change', function (){
            theRoute();   
        })            
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
     
    });



    function theRoute(fechaDesde = 0, fechaHasta = 0){

        let wallet  = $('#wallet').val() == ""  ? 0 : $('#wallet').val();


        // let user = "";
        let Route ="";

        myRoute = "";

        if (fechaDesde == 0){
            myRoute = "{{ route('USDTResumen', ['wallet' => 'wallet2']) }}"; 

        }else{
            myRoute = "{{ route('USDTResumen', ['fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'wallet' => 'wallet2']) }}"; 

        }


        // console.log('myRoute ->' + myRoute);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replaceAll('amp;','');

        // alert(myRoute);

        // alert('la ruta ->' + myRoute);
        location.href = myRoute;

    }

    function BuscaFechas(){
        
        // console.log('myFechaDesde ->' + '{{$myFechaDesde}}');

        let fechaDesde = {{$myFechaDesde}} ? '{{$myFechaDesde}}'  : "2001-01-01";
        if (fechaDesde == "2001-01-01"){
            return;
        }
        
        //console.log('fechaDesde ->' + '{{$myFechaDesde}}');
        //console.log('fechaHasta ->' + '{{$myFechaHasta}}');
         $('#drCustomRanges').data('daterangepicker').setStartDate('{{$myFechaDesde}}');
         $('#drCustomRanges').data('daterangepicker').setEndDate('{{$myFechaHasta}}');

    };

    function noEditar(){
        Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar transacción anulada',
                showConfirmButton: true
        }
        );          
    }


    function BuscaElemento(myControl, myElement){

        let mySelect = myControl;
        let myValue  = myElement;

        $('#' + mySelect).each( function(index, element){
            // alert ("BuscaMaterial -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myValue.toString()){
                    // alert('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }


</script>
@endsection

