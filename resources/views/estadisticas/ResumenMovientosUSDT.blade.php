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
            
            <div class ="col-12 col-lg-3 float-right" >
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
            
            <div class="col-lg-3 col-12">
                
                <div class='d-flex align-items-center'>

                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-box"></i>
                    </div>

                    <select id="wallet" name="wallet" class='form-control' required>
                        <option value="" disabled selected>Wallet...</option>
                        @foreach($wallet as $key => $item)
                            <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>

                </div>
                
            </div>   




        </div>
    </div>

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

            @can('USDTResumenDiarioFiltro')     
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
            @endcan

        </div>
    </nav>  

    <br>
    <br>
    <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home"    role="tabpanel"     aria-labelledby="nav-home-tab">
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
    @can('USDTResumenDiarioFiltro')     
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Filtros


            <div class="card mb-4">
                <div class="card-header" style="background-color: #2874A6; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Entradas USDT</h3>
                </div>
                <div class="card-body">    

                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Seccion</label>
                                <input type="text" id="entrada1" size=20/>
                            </div>

                            <style>
                                /*
                                *
                                * Centra los Multiselect
                                *
                                */
                                .ms-container {
                                    margin-left: auto;
                                    margin-right: auto;
                                }
                                #ms-my-select1 {
                                    margin-left: auto;
                                    margin-right: auto;
                                }
                            </style>

                            <select multiple="multiple" id="my-select1" name="my-select[]">
                            </select>   

                        </div>  

                    </div>     

                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
                    </div>
                </div>

            </div>


            <div class="card mb-4">
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo A </h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Seccion</label>
                                <input type="text" id="salida1" size=20/>
                            </div>                            
                            <select multiple="multiple" id="my-select2" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     
                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar2" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar2" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo B </h3>
                </div>
                <div class="card-body">    
                    <div class="row justify-content-center text-center align-items-center">

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Seccion</label>
                                <input type="text" id="salida2" size=20/>
                            </div>                            
                            <select multiple="multiple" id="my-select3" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     
                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar3" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar3" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header" style="background-color: #BB8FCE; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Filtros Salidas USDT Grupo C </h3>
                </div>
                <div class="card-body">    

                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Nombre Seccion</label>
                                <input type="text" id="salida3" size=20/>
                            </div>           
                            <label>Grupos de la seccion</label>                 
                            <select multiple="multiple" id="my-select4" name="my-select[]">
                            </select>   
                        </div>  

                    </div>     

                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Wallets de la seccion</label>
                            </div>                            
                            <select multiple="multiple" id="my-select5" name="my-select[]">
                            </select>   
                        </div>  

                    </div>  
                    <br>
                    <br>                  
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonAplicar4" type="button" class="btn btn-outline-primary btn-sm ">Aplicar</button>

                        </div>

                        <div class="col-12 col-sm-2 mt-2">
                            <button id="myButtonLimpiar4" type="button" class="btn btn-outline-primary btn-sm ">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header" style="background-color: red; color: white">
                    <h3 class="card-title text-uppercase font-weight-bold">Grupos con pagos USDT sin asignar en filtro</h3>
                </div>
                <div class="card-body">

                    <br>
                    <br>
                    <div class="row justify-content-center text-center align-items-center">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 justify-content-center text-center align-items-center">
                            <div class="mt-4 mb-4">
                                <label>Grupos con Pagos USDT sin asignar</label>
                            </div>                            
                            <select multiple="multiple" id="my-select6" name="" style="width:50%; height: 250px;"></select>
                        </div>  

                    </div>  
                    <br>
                    <br>

                </div>
            </div>

        </div>
    @endcan    
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
                text:    '<i class="fas fa-file-excel"></i>',
                className: 'btn btn-success',
                exportOptions: { columns: [ 1, 2, 3,4,5,6,7 ] },
                "excelStyles": {
                    "template": "blue_medium"
                }

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

    InicializaMultiselects();
    leeFiltros();

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

        $("#wallet").select2({
            placeholder: "Wallet",
            theme: 'bootstrap4',
            search: false,
            width: '100%',
            allowClear: true,
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });         


        $('#wallet, #group').on('change', function () {
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });        



        $('#wallet2').on('change', function () {
            // theRoute();
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

        



        $('#myButtonLimpiar').on('click', function (){
            
            $('#my-select1').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar2').on('click', function (){

            $('#my-select2').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar3').on('click', function (){

            $('#my-select3').multiSelect('deselect_all');

        });

        $('#myButtonLimpiar4').on('click', function (){

            $('#my-select4').multiSelect('deselect_all');

        });

        $('#myButtonAplicar, #myButtonAplicar2, #myButtonAplicar3, #myButtonAplicar4').on('click', function (){
            
            $("#myCanvas div").each(function(){
                $(this).removeAttr("hidden");
            });

            $("#my-select option:selected").each(function(){
                
                seleccionado = $(this).attr('value');

                $("#myCanvas div").each(function(){
                    if($(this).data("id")){
                                                
                        if ($(this).data("id") == seleccionado){
                            
                            $(this).attr("hidden",true);
                        }
                    }
                });


            });
            
            grabaFiltros();
            
            Swal.fire({
                position: 'center',
                type: 'success',
                title: 'Filtro aplicado satisfactoriamente',
                showConfirmButton: true,
                timerProgressBar: true,
                timer: 3000
            });



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

                
            const wallet       = $('#wallet2').val();
            const grupo         = $('#grupo').val()     == "" ? 0 : $('#grupo').val();
            const transaccion   = $('#typeTransactions').val();
            theRoute(wallet, grupo, myFechaDesde,myFechaHasta);



            
        });


    });








    function theRoute(fechaDesde = 0, fechaHasta = 0){

        let wallet  = ($('#wallet').val() == "" ||  $('#wallet').val() == null)  ? 0 : $('#wallet').val();

        alert('el wallet es -> ' + wallet);
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


    
    function InicializaMultiselects(){
        $('#my-select1').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'></i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles 
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'>  </i>
                                    </div>
                                </div>`
        });

        $('#my-select2').multiSelect({
            selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>                                    
                                </div>`,
            selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>                                    
                                </div>`
        });
        $('#my-select3').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'></i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles 
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'>  </i>
                                    </div>
                                </div>`
        });

        $('#my-select4').multiSelect({
            selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>                                    
                                </div>`,
            selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>                                    
                                </div>`
        });      

        $('#my-select5').multiSelect({
            selectableHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                    No Visibles
                                    <br>
                                    <br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>                                    
                                </div>`,
            selectionHeader:   `<div class='custom-header' style='background-color: black; color:white'>
                                    Visibles
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>                                    
                                </div>`
        }); 

        @foreach($grupo as $key => $group2)
            // console.log('el grupo con key {!! $key !!} es {!! $group2 !!}');
            $('#my-select1').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select2').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select3').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
            $('#my-select4').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $group2 !!}' });
        @endforeach

        @foreach($wallet2 as $key => $wallet22)
            $('#my-select5').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $wallet22 !!}' });
        @endforeach

        // $('#my-select6').append('<option>test...</option>');
    }



    function leeFiltros(){

        $.ajax(
            {
                url: "{{route('filtroUSDTResDiaMovimientosLee')}}",
                async: false,
            }
        ).done (function(myData) {
            
            myData2 = myData.data;

        });

        // console.log('leam - leefiltros ->' + JSON.stringify(myData2));
        // console.log('leam - leefiltros ->' + myData2.entrada1);
        // console.log('leam - leefiltros ->' + myData2.groupsEntrada1);

        $('#entrada1').val(myData2.entrada1);
        $('#salida1').val(myData2.salida1);
        $('#salida2').val(myData2.salida2);
        $('#salida3').val(myData2.salida3);

        myData2.groupsEntrada1.map( function (valor) {
            $("#my-select1 option").each(function(){
                
                if (valor == $(this).attr('value')){
                    $('#my-select1').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida1.map( function (valor) {
            $("#my-select2 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select2').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida2.map( function (valor) {
            $("#my-select3 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select3').multiSelect('select', valor.toString());
                }
            });
        });

        myData2.groupsSalida3.map( function (valor) {
            $("#my-select4 option").each(function(){
                if (valor == $(this).attr('value')){
                    $('#my-select4').multiSelect('select', valor.toString());
                }
            });
        });
        if (myData2.walletsSalida3){
            myData2.walletsSalida3.map( function (valor) {
                $("#my-select5 option").each(function(){
                    if (valor == $(this).attr('value')){
                        $('#my-select5').multiSelect('select', valor.toString());
                    }
                });
            });
        }
        
        let myGroup;
        @foreach($pagosUSDTGrupos as $group2)
            myGroup = {{ $group2->group_id }};


            indExiste = 0;
            for(let i = 1; i<= 5; i++){
                $("#my-select" + i + " option:selected").each(function(){
                    if (myGroup == $(this).attr('value')){
                        indExiste = 1;
                        return false;
                    }
                }); 
                if (indExiste == 1){
                    break;
                }
            }
            if (indExiste == 0){
                $('#my-select6').append($('<option>', {value: myGroup, text: '{{$group2->name}}'}));
            }

        @endforeach
    

    }


    function grabaFiltros(){

        let myDataTransactions          = buscaFiltros("my-select1");
        let ocultarresumengeneral       = $('#ResumenGeneral').prop("checked");
        let ocultarresumentransaccion   = $('#ResumenTransaccion').prop("checked");

        let entrada1        = $('#entrada1').val();
        let gruposEntrada1  = buscaFiltros("my-select1");

        let salida1         = $('#salida1').val();
        let gruposSalida1   = buscaFiltros("my-select2");

        let salida2         = $('#salida2').val();
        let gruposSalida2   = buscaFiltros("my-select3");

        let salida3         = $('#salida3').val();
        let gruposSalida3   = buscaFiltros("my-select4");
        let walletsSalida3  = buscaFiltros("my-select5");

        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "{{route('filtroUSDTResDiaMovimientosGraba')}}",
                async: false,
                data: {
                        data: { 
                            entrada1: entrada1,
                            groupsEntrada1: gruposEntrada1,
                            salida1: salida1,
                            groupsSalida1: gruposSalida1,
                            salida2: salida2,
                            groupsSalida2: gruposSalida2,
                            salida3: salida3,
                            groupsSalida3: gruposSalida3,
                            walletsSalida3: walletsSalida3,
                    }
                },
            }
        ).done (function(myData) {

            // alert('vino');

        });

        return;
    }



    function buscaFiltros(myFilter = ""){
        
        if (myFilter=="") return "";

        let filtrosSeleccionado = [];
        filtrosSeleccionado.push(0);
        $("#" + myFilter + " option:selected").each(function(){
            filtrosSeleccionado.push($(this).attr('value'));
        });  
        
        return  filtrosSeleccionado;
    }

</script>
@endsection

