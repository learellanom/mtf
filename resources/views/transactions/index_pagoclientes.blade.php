@extends('adminlte::page')
@php 
$config2 =
[
    "allowClear" => true,
];

$config3 = [
    "locale" => ["format" => "DD-MM-YYYY"],
    "allowClear" => true,
    "showDropdowns:" => "true",
];


@endphp

@section('title', 'Pago entre clientes')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('LISTA DE PAGOS ENTRE CLIENTES') }} <i class="fas fa-box"></i> </h1></a>


@stop

@section('content')

@can('transactions.create')
<a class="btn btn-dark" title="Crear transaccion" href={{ route('transactions.create_pagoclientes') }}>
    <i class="fas fa-plus-circle"></i>
    <span class="d-none d-lg-inline-block text-uppercase font-weight-bold">{{ __('Crear') }}</span>
    <span class="d-none d-md-inline-block text-uppercase font-weight-bold">{{ __('Pago') }}</span>
</a>
@endcan

<br><br>

<div class="row">

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Pago entre clientes') }}</h3>
            </div>
            <div class="row">
            <div class ="col-12 col-md-4 col-xl-3">
                <x-adminlte-date-range
                    name="drCustomRanges"
                    enable-default-ranges="Last 30 Days"
                    
                    :config="$config3">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-light">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button 
                            id="myDrClearButton"
                            label="X" 
                            icon="fas  fa-x"/>
                    </x-slot>
                </x-adminlte-date-range>


            </div>

            <div class ="col-12 col-md-4 col-xl-3">
                <x-adminlte-select2 id="group"
                                    name="group"

                                    label-class="text-lightblue"
                                    data-placeholder="Grupo ..."
                                    :config="$config2"
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
            <div class ="col-xl-2 col-sm-6">
            <x-adminlte-select2 id="user"
                                class="mySelect"
                                name="optionsUsers"
                                label-class="text-lightblue"
                                data-placeholder="Agente..."
                                :config="$config2"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$user" empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>            
            </div>
        {{--
        <select name="group2" id="group2">

            @foreach( $group as $key => $item)
                <option value="{{$key}}">{{$item}}</option>
            @endforeach

        </select>
        --}}
        {{-- 
        <select name="group3" id="group3">

            @foreach( $group as $key => $item)
                <option value="{{$key}}">{{$item}}</option>
            @endforeach

        </select>
        --}}
    </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%;">Nro transferencia</th>
                                    <th style="width:5%;">Fecha</th>
                                    <th style="width:5%;">Creada</th>
                                    <th>Descripción</th>
                                    <th style="width:10%;">Monto Total</th>
                                    <th style="width:5%;">% Base</th>
                                    <th style="width:10%;">Comisión Base</th>
                                    <th style="width:10%;">Monto Total Base</th>
                                    <th class="no-exportar">Agente</th>
                                    <th style="width:10%;">Caja <i class="fas fa-box"></i></th>
                                    <th>Tipo de Movimiento</th>
                                    <th style="width:10%;">Cliente </th>
                                    @can('transactions.update_status')
                                    <th style="width:1%;">Activo <br> /Anulado</th>
                                    @endcan
                                    <th style="width:1%;" class="no-exportar">Comisión</th>
                                    <th style="width:1%;" class="no-exportar">Ver <i class="fas fa-search"></i></th>

                                </tr>
                            </thead>

                            @foreach($transactiones as $transferencias)

                                <tr>
                                    <td class="font-weight-bold">{{ $transferencias->TransferNumber }}</td>


                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->TransactionDate !!}</td>
                                    <td class="font-weight-bold" style="min-width: 80px;">{!! $transferencias->TransactionCreated !!}</td>
                                    <td class="font-weight-bold"><div style='width:60px; height:60px; overflow:hidden;'>{!!  $transferencias->Description !!}</div></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->Amount) !!} <i class="fas fa-dollar-sign"></i></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->PorcentageBase) !!}</td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->ComisionBase) !!} <i class="fas fa-dollar-sign"></i></td>

                                    <td class="font-weight-bold">{!! number_format($transferencias->TotalBase) !!} <i class="fas fa-dollar-sign"></i></td>



                                    <td class="font-weight-bold">{!! $transferencias->Agente !!}</td>
                                    <td>{!! $transferencias->WalletNameOrigen !!}</td>
                                    <td>{!! $transferencias->TransferType !!}</td>
                                    <td>{!! $transferencias->GroupNameOrigen !!}</td>
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

let myGroup = '{{$myGroup}}';
const miUsuario             = {{ $myUser ?? 0}};

buscaGrupo(myGroup);
BuscaUsuario(miUsuario);



$(document).ready(function () {

        const myFechaDesde = '{{ $myFechaDesde }}';
    const myFechaHasta = '{{ $myFechaHasta }}';

    BuscaFechasBlade(myFechaDesde, myFechaHasta);
    @php
        // dd(json_decode(json_encode($group)));
    @endphp
    // console.log(@json($group));
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
    "order": [],
    'dom' : '<"row" <"col-12 col-md-6" B> <"col-12 col-md-6 text-align-right" f> >ti <"row" <"col-12 col-md-6" l> <"col-12 col-md-6" p>>',          
    // 'dom' : 'Bfrtilp',
    'buttons':[
        {
            extend:  'excelHtml5',
            exportOptions: { columns: [ 0, 1, 2, 3,4,5,6,7, 8,9,10,11, 12 ] },
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
                "cells": "A",
                "width": "30",
            },
            {
                "cells": "B",
                "width": "23",
            },
            {
                "cells": "C",
                "width": "23",
            },
            {
                "cells": "D",
                "width": "50",
            },
            {
                "cells": "E",
                "width": "23",
            },
            {
                "cells": "F",
                "width": "12",
                "style": {
                    "numFmt": "#,##0;(#,##0)"
                }
            },
            {
                "cells": "G",
                "width": "24",
            },
            {
                "cells": "H",
                "width": "30",
            },
            {
                "cells": "I",
                "width": "30",
                "style": {
                    "font": {                 // Style the font
                            "b": true,
                            "size" : "14"
                            },
                    },

            },
            ]
        },
        {
            extend:  'pdfHtml5',
            text:    '<i class="fas fa-file-pdf"></i>',
            orientation: 'landscape',
            title: 'MTF_Pago entre clientes',
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
                    columns: [{
                        margin: 14,
                        alignment: 'left',
                        image: '',
                        width: 70,
                        height: 70
                    }, {
                        margin: [40, 30],
                        text: 'MTF |PAGOS ENTRE CLIENTES',
                        fontSize: 30,
                        bold: true
                    }]
                    }),
                    doc.defaultStyle.fontSize = 10;
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


    
    $('#group').on('change', function (){
        const fechaDesde = '{{$myFechaDesde ?? null}}';
        const fechaHasta = '{{$myFechaHasta ?? null}}';
        const grupo             = $('#group').val();
        const user       = $('#user').val() == "" ? null : $('#user').val();
        theRoute(grupo, fechaDesde, fechaHasta, user);


    })
    .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    }); 


    $('#group2').select2({
        placeholder: 'Select an option',
        allowClear: true,
        theme: "classic"
    });


    
    $('#drCustomRanges').on('change', function () {
        
        let myFechaDesde, myFechaHasta;
        myFechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(3,2) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(0,2)
                        ;

        myFechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(16,2) +
                        '-' +
                        ($('#drCustomRanges').val()).substr(13,2)
                        ;

            
            const grupo         = $('#group').val()     == "" ? 0 : $('#group').val();
            theRoute(grupo, myFechaDesde,myFechaHasta);

    });

    $('#myDrClearButton').on('click', function () {

        const fechaDesde = null;
        const fechaHasta = null;
        const grupo      = $('#group').val()  =="" ? null  : $('#group').val();
        const user       = $('#user').val()   == "" ? null : $('#user').val();

        // $('#drCustomRanges').data('daterangepicker').setStartDate(null);
        // $('#drCustomRanges').data('daterangepicker').setEndDate(null);


        theRoute(grupo, fechaDesde, fechaHasta, user);
    });

    $('#user').on('change', function (){

        const user           = $('#user').val() == "" ? null : $('#user').val();
        const grupo         = $('#group').val()     == "" ? null : $('#group').val();       
        const fechaDesde    = '{{$myFechaDesde ?? null}}';
        const fechaHasta = '{{$myFechaHasta ?? null}}';
   
        theRoute(grupo, fechaDesde, fechaHasta, user);

    })
        .on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });        


});


function theRoute(grupo = 0, fechaDesde = null, fechaHasta = null, user = null){

    // if (!grupo) return;

    let myRoute = "";
    let indVacio = false;
    myRoute = "{{ route('transactions.index_pagoclientes', ['grupo' => 'grupo2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2','user' => 'user2']) }}";
    // alert(myRoute);
    if (grupo && grupo != 0){
        myRoute = myRoute.replace('grupo2',grupo);
    }else{
        myRoute = myRoute.replace('grupo=grupo2&amp;','');

    }
    //alert('Grupo -> ' + myRoute);
    if ((fechaDesde) && fechaDesde != "") {
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
    }else{

        myRoute = myRoute.replace('&amp;fechaDesde=fechaDesde2','');
        myRoute = myRoute.replace('fechaDesde=fechaDesde2','');
    }
    //alert('fecha desde =-> ' + myRoute);
    if (fechaHasta) {
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
    }else{

        myRoute = myRoute.replace('&amp;fechaHasta=fechaHasta2','');
        myRoute = myRoute.replace('fechaHasta=fechaHasta2','');
    }
    //alert(myRoute);
    if (user) {
        myRoute = myRoute.replace('user2',user);
    }else{
        myRoute = myRoute.replace('&amp;user=user2','');
    }

    myRoute = myRoute.replaceAll('amp;','');
    
    if(grupo == 0){
        
        if (!fechaDesde){

            if (!fechaHasta){

                if (!user){
                    myRoute = myRoute.replaceAll('?',''); 
                }

            } 

        }

    }
    

    location.href = myRoute;

}

function buscaGrupo(myGroup){
        // alert("BuscaGrupo - miGrupo -> " + myGroup);
        $('#group').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myGroup.toString()){
                    //alert('Buscagrupo - encontro');
                // $("#group option[value="+ $(this).val() +"]").attr("selected",true);
                    $(this).attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
}


function BuscaUsuario(miUsuario){
        if (miUsuario===0){
            return;
        }
        if (miUsuario===null){
            return;
        }

        $('#user').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miUsuario.toString()){
                    $("#user option[value="+ miUsuario +"]").attr("selected",true);
                }
            });
        });
    }


    function BuscaFechasBlade(){

        let myFechaDesdeInicial = "{{ $myFechaDesde }}";
        let myFechaHastaInicial = "{{ $myFechaHasta }}";
        // console.log('leam - aqui ' + "{{ $myFechaDesde }}");
        if (myFechaDesdeInicial == "2001-01-01"){
            return;
        }
        if (myFechaDesdeInicial == ""){
            return;
        }

        if (myFechaDesdeInicial == null){
            return;
        }




        let myFechaAnio  = myFechaDesdeInicial.substring(0,4);
        let myFechaMes   = myFechaDesdeInicial.substring(5,7);
        let myFechaDia   = myFechaDesdeInicial.substring(8,10);


        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaDesde2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio)



        myFechaAnio  = myFechaHastaInicial.substring(0,4);
        myFechaMes   = myFechaHastaInicial.substring(5,7);
        myFechaDia   = myFechaHastaInicial.substring(8,10);

        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaHasta2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio);


        console.log('myFechaDesde2 ->' + myFechaDesde2);
        console.log('myFechaHasta2 ->' + myFechaHasta2);

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde2);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta2);
    }


</script>
@endsection

