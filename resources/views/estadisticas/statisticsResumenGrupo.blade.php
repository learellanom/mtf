@extends('adminlte::page')
@section('title', 'Estadisticas por Grupo')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    ['label' => 'Grupo',        'no-export' => true, 'width' => 15],
    ['label' => 'Monto total',  'no-export' => true, 'width' => 15],
    ['label' => 'Actions',      'no-export' => true, 'width' => 5],
];

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        [22, '07-03-2023', 'John Bender',    '4,00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, '07-03-2023', 'Sophia Clemens', '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3,  '07-03-2023', 'Peter Sousa',    '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null,  ['orderable' => false]]
];


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
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

@endphp

<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Resumen de Movimiento por Grupo') }} <i class="fas fa-users"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row">
        <!-- Grupo -->
        <div class ="col-sm-3">
            <x-adminlte-select2 id="grupo"
                                name="optionsGroup"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Grupo ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$groups" empty-option="Selecciona un Grupo.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-sm-3">
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

        <div class ="col-sm-3">
            <x-adminlte-select2 id="coin"
                                name="optionsCoin"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="MonedaGrupo ..."
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

    </div>

</div>

<br>
<br>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">

    <button 
        class="nav-link active" 
        id="nav-home-tab" 
        data-toggle="tab" 
        data-target="#nav-home" 
        type="button" 
        role="tab" 
        aria-controls="nav-home" 
        aria-selected="true">
        Estadistica
    </button>

    <button 
        class="nav-link" 
        id="nav-profile-tab" 
        data-toggle="tab" 
        data-target="#nav-profile" 
        type="button" 
        role="tab" 
        aria-controls="nav-profile"             
        aria-selected="false">
        Filtros
    </button>

  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-uppercase font-weight-bold">{{ __('Estadisticas| Resumen por Grupo') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive-lg" id="table" style="width:100%;">
                                    <thead>

                                    <tr>
                                            <th style="width:1%; display: none;">Id</th>
                                            <th style="width:10%;">Cliente</th>
                                            <th style="width:10%;">Cant</th>
                                            <th style="width:10%;">Monto Creditos</th>
                                            <th style="width:10%;">Monto Debitos</th>                                            
                                            <th style="width:10%;">Saldo Total</th>
                                            <th style="width:1%;" class="no-exportar">Ver <i class="fas fa-search"></i></th>

                                        </tr>
                                    </thead>
                                    @foreach($Transacciones as $row)
                                        <tr>
                                            <td style="display: none;">{!! $row->IdGrupo !!}</td>                                        
                                            <td>{!! $row->NombreGrupo !!}</td>
                                            <td>{!! number_format($row->Cant,0,".") !!}</td>
                                            <td>{!! number_format($row->Creditos,2,".") !!}</td>
                                            <td>{!! number_format($row->Debitos,2,".") !!}</td>                                       
                                            <td>{!! number_format($row->Total,2,".") !!}</td>
                                            <td class="text-center" class="no-exportar">
                                                <a href="#"
                                                    title="Detalles"
                                                    class="btn btn-xl text-primary mx-1 shadow text-center"
                                                    onClick="theRoute2({{0}},{{$row->IdGrupo}})">
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
    </div>

    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">Filtros</h3>
            </div>
            <div class="card-body">    
                <div class="row justify-content-center text-center align-items-center">
                    <div class="col-12 col-md-2">
                    </div>
                    <div class="col-12 col-md-3">
                        <select multiple="multiple" id="my-select" name="my-select[]">
                            <option value='elem_1'>elem 1</option>
                            <option value='elem_2'>elem 2</option>
                            <option value='elem_3'>elem 3</option>
                            <option value='elem_4'>elem 4</option>
                            <option value='elem_100'>elem 100</option>
                        </select>   
                    </div>

                    <div class="col-12 col-md-3">
                        <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>
                        <br>
                        <br>
                        <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                    </div>
                    <div class="col-12 col-md-2">
                    </div>
 
                </div>     

            </div>
        </div>
    </div>

</div>


@endsection

@section('js')

<script>

$(document).ready(function () {


    // multiseleccion

    $('#my-select').multiSelect({
        selectableHeader: "<div class='custom-header' style='background-color: black; color:white'>Visibles</div>",
        selectionHeader:  "<div class='custom-header' style='background-color: black; color:white'>No VIsibles</div>"
    });
    /*
    $('.ms-container').css("width","67rem");

    $('.ms-container .ms-selectable .ms-list').css("height","20rem");
    $('.ms-container .ms-selectable .ms-list').css("width","30rem");

    $('.ms-container .ms-selection .ms-list').css("height","20rem");
    $('.ms-container .ms-selection .ms-list').css("width","30rem");
    */
    @foreach($groups as $key => $group)
        // console.log('el grupo con key {!! $key !!} es {!! $group !!}');
        $('#my-select').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group !!}' });        
    @endforeach

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
                exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
                title: "Resumen de Movimiento por Grupo",
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
                    "width": "10",
                },
                {
                    "cells": "B",
                    "width": "32",
                },
                {
                    "cells": "C",
                    "width": "10",
                },
                {
                    "cells": "D",
                    "width": "25",
                },         
                {
                    "cells": "E",
                    "width": "25",
                }, 
                {
                    "cells": "F",
                    "width": "25",
                },                                        
            ]

            },
            {
                extend:  'pdfHtml5',
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'MTF | Resumen por grupo',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ":not(.no-exportar)" //exportar toda columna que no tenga la clase no-exportar
                },
                customize: function ( doc ) {
                    doc.styles.tableHeader = {
                            fillColor:'#525659',
                            color:'#FFF',
                            fontSize: '13',
                            alignment: 'center',
                            bold: true
                    },
                    doc.content.splice(1, 0, {
                        columns: [
                            {
                                margin: [5, 70, 30],
                                text: 'RESUMEN POR GRUPO',
                                fontSize: 27,
                                bold: true
                            }
                        ]
                    }),
                    doc.defaultStyle.fontSize = 25;
                    doc.pageMargins = [250,5,120,200];
                    doc.content[1].margin = [ 5, 10, 15, 5];
                    doc.styles.title = {
                            color: 'dark',
                            fontSize: '15',
                            alignment: 'center'
                        }
                        doc.styles['td:nth-child(2)'] = {
                            width: '900px',
                            'max-width': '900px'
                        }
                        doc.styles.tableHeader = {
                            fillColor:'#0B2447',
                            color:'white',
                            alignment: 'center'
                        }

                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyEven.alignment = 'center';
                    

                },

            },

        ]
    });

    // funcion para permitir el filtrado

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            //do stuff
            let userTypeColumnData = data[0] || 0;
            let muestra = true;
            $("#my-select option:selected").each(function(){
                if (userTypeColumnData==($(this).attr('value'))) {
                    // alert('opcion '+$(this).text()+' valor '+ $(this).attr('value') + ' lo que ve ' + userTypeColumnData);
                    muestra = false;
                }
            }); 
            // lert('sigue -> ' + userTypeColumnData + ' lo muestra -> ' + muestra);
            return muestra;
        }
    );


    
    $('#myButtonLimpiar').on('click', function (){
        $('#my-select').multiSelect('deselect_all');
        $('#table').DataTable().draw();
        
    });

    $('#myButtonAplicar').on('click', function (){
        
        $('#table').DataTable().draw();

        
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Filtro aplicado satisfactoriamente',
            showConfirmButton: false,
            timer: 1500
            });             
        
    });

});


    const miGrupo           = {!! $myGroup !!};
    const myTypeCoinBalance = {!! $myTypeCoinBalance !!};

    BuscaGrupo(miGrupo);
    BuscaMoneda(myTypeCoinBalance);

    $(() => {

        const myFechaDesde = {!! isset($myFechaDesde) ?? 0 !!};
        const myFechaHasta = {!! isset($myFechaHasta) ?? 0 !!};
        
        // BuscaFechas(myFechaDesde, myFechaHasta);
        BuscaFechasBlade();
        



        $('#grupo').on('change', function (){

            const usuario   = $('#userole').val();
            const cliente   = $('#cliente').val();
            const wallet    = $('#wallet').val();
            const grupo     = $('#grupo').val();
            const coin      = $('#coin').val();

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

            theRoute(grupo,myFechaDesde,myFechaHasta,coin);



            // theRoute(grupo,cliente,wallet);

        }).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
        });


        $('#coin').on('change', function (){
            const grupo     = $('#grupo').val();
            const coin      = $('#coin').val();

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

            theRoute(grupo,myFechaDesde,myFechaHasta,coin);

        }
        ).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
        });

        $('#drCustomRanges').on('change', function () {
            // alert('ggggg ' + $('#drCustomRanges').val());
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

            // alert('Fecha Desde ' + myFechaDesde + ' Fecha Hasta ' + myFechaHasta);
            const usuario   = $('#userole').val();
            const cliente   = $('#cliente').val();
            const wallet    = $('#wallet').val();
            const grupo     = $('#grupo').val();
            theRoute(grupo,myFechaDesde,myFechaHasta);
        });

        $('#myButtonLimpiar').on('click', function (){
            $('#my-select').multiSelect('deselect_all');
            $('#table').DataTable().draw();
            
        });

        $('#myButtonAplicar').on('click', function (){
            
            $('#table').DataTable().draw();

            
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Filtro aplicado satisfactoriamente',
                showConfirmButton: false,
                timer: 1500
                });             
            
        });
        
    });

    function theRoute(grupo = 0, fechaDesde = 0, fechaHasta = 0, coin = 0){

        // alert('Grupo -> ' + grupo + ' Fecha desde -> ' + fechaDesde + ' Fecha Hasta -> ' + fechaHasta);

        if (grupo   === "") grupo  = 0;

        let myRoute = "";

        myRoute = "{{ route('estadisticasResumenGrupo', ['grupo' => 'grupo2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'coin' => 'coin2']) }}";
        myRoute = myRoute.replace('grupo2',grupo);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        myRoute = myRoute.replace('coin2',coin);
        myRoute = myRoute.replaceAll('amp;','');
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }


    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){


        if (grupo   === "") grupo = 0;
        if (wallet  === "") wallet  = 0;
        //                      'estadisticasDetalle/{usuario}/{grupo?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}'

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

        
        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);
            myRoute = myRoute.replace('fechaDesde2',myFechaDesde);
            myRoute = myRoute.replace('fechaHasta2',myFechaHasta);
        console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }

    function BuscaGrupo(miGrupo){
        //alert("BuscaGrupo - miGrupo -> " + miGrupo);
        $('#grupo').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miGrupo.toString()){
                    //alert('Buscagrupo - encontro');
                    $("#grupo option[value="+ miGrupo +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function BuscaMoneda(myTypeCoinBalance){
        //alert("BuscaGrupo - miGrupo -> " + miGrupo);
        $('#coin').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myTypeCoinBalance.toString()){
                    //alert('Buscagrupo - encontro');
                    $("#coin option[value="+ myTypeCoinBalance +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function BuscaFechas(FechaDesde = 0, FechaHasta = 0){

        myLocation  = window.location.toString();

        myArray     = myLocation.split("/");
    
        if (myArray.length > 4){
            FechaDesde = myArray[5];
            FechaHasta = myArray[6];
        }else{
            FechaDesde = 0;
            FechaHasta = 0;       
        }

        // alert("fecha desde -> " + FechaDesde + " Fecha hasta -> " + FechaHasta);

        if (FechaDesde == 0) return;


        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);

    }

    function BuscaFechasBlade(){

        let myFechaAnio  = {{ substr($myFechaDesde,0,4) }};
        let myFechaMes   = {{ substr($myFechaDesde,5,2) }};
        let myFechaDia   = {{ substr($myFechaDesde,8,2) }};

        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaDesde2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio)

        myFechaAnio  = {{ substr($myFechaHasta,0,4) }};
        myFechaMes   = {{ substr($myFechaHasta,5,2) }};
        myFechaDia   = {{ substr($myFechaHasta,8,2) }};

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
