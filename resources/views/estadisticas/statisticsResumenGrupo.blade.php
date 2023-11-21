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
        "order": [[ 2, 'desc' ]],
        'dom' : 'Bfrtilp',
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [ 0, 1 ] },
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
                        "width": "35",
                    },
                    {
                        "cells": "B",
                        "width": "32",
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
                    columns: [{
                        margin: 10,
                        alignment: 'right',
                        image: 'data:image/png;base64,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',
                        width: 100,
                        height: 100
                    }, {
                        margin: [5, 80, 30],
                        text: 'RESUMEN POR GRUPO',
                        fontSize: 27,
                        bold: true
                    }]
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


    const miGrupo = {!! $myGroup !!};

    BuscaGrupo(miGrupo);

    $(() => {

        const myFechaDesde = {!! isset($myFechaDesde) ?? 0 !!};
        const myFechaHasta = {!! isset($myFechaHasta) ?? 0 !!};
        
        // BuscaFechas(myFechaDesde, myFechaHasta);
        BuscaFechasBlade();
        



        $('#grupo').on('change', function (){

            const usuario = $('#userole').val();
            const cliente = $('#cliente').val();
            const wallet = $('#wallet').val();
            const grupo = $('#grupo').val();

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

            theRoute(grupo,myFechaDesde,myFechaHasta);



            // theRoute(grupo,cliente,wallet);

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

            //alert('Fecha Desde ' + myFechaDesde + 'Fecha Hasta ' + myFechaHasta);
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

    function theRoute(grupo = 0, fechaDesde = 0, fechaHasta = 0){

        // alert('Grupo -> ' + grupo + ' Fecha desde -> ' + fechaDesde + ' Fecha Hasta -> ' + fechaHasta);

        if (grupo   === "") grupo  = 0;

        let myRoute = "";

            myRoute = "{{ route('estadisticasResumenGrupo', ['grupo' => 'grupo2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
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

    function BuscaUsuario(miUsuario){
        if (miUsuario===0){
            return;
        }
        // alert("BuscaUsuario - miUsuario -> " + miUsuario);
        $('#userole').each( function(index, element){
            // alert ("BuscaUsuario -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miUsuario.toString()){
                    // alert('BuscaUsuario - encontro');
                    $("#userole option[value="+ miUsuario +"]").attr("selected",true);
                }
                // alert("BuscaUsuario aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function BuscaCliente(miCliente){
        //alert("BuscaCliente - miCliente -> " + miCliente);
        $('#cliente').each( function(index, element){
            //alert ("Buscacliente -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === miCliente.toString()){
                    //alert('BUscaCliente - encontro');
                    $("#cliente option[value="+ miCliente +"]").attr("selected",true);
                }
                //alert("BuscaClienteaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
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
