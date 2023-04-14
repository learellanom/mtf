@extends('adminlte::page')
@section('title', 'Estadisticas por agentes')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    ['label' => 'Fecha Transaccion', 'no-export' => true, 'width' => 5],
    ['label' => 'Transaccion', 'no-export' => true, 'width' => 5],
    ['label' => 'Tipo Moneda', 'no-export' => true, 'width' => 5],    
    ['label' => 'MontoMoneda', 'no-export' => true, 'width' => 5],        
    ['label' => 'Tasa Cambio', 'no-export' => true, 'width' => 5],            
    ['label' => 'Monto $', 'no-export' => true, 'width' => 5],    
    ['label' => '%', 'no-export' => true, 'width' => 5],        
    ['label' => 'Comision $', 'no-export' => true, 'width' => 5],        
    ['label' => 'Monto Total $', 'no-export' => true, 'width' => 5],
    ['label' => 'Cliente', 'no-export' => true, 'width' => 5],
    ['label' => 'Agente', 'no-export' => true, 'width' => 10],
    ['label' => 'Wallet', 'no-export' => true, 'width' => 5],    
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false]]
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

<script>


</script>
<br>
<br>
<h1 class="text-center text-dark font-weight-bold">Detalles de Movimiento</h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12">
        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="userole"
                                class="mySelect"
                                name="optionsUsers"
                                igroup-size="sm"
                                label-class="text-lightblue"

                                data-placeholder="Agente..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$userole" empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="group"
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

                <x-adminlte-options :options="$group" empty-option="Selecciona un Grupo.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="wallet"
                                name="optionsWallets"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Wallet..."
                                :config="$config4"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-box"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$wallet" empty-option="Wallet.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>

    </div>



</div>


<br>
<br>


{{-- Minimal example / fill data using the component slot --}}
<!-- <x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable> -->

{{-- Compressed with style options / fill data using the plugin config --}}
<!-- <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
    striped hoverable bordered compressed/> -->
    <div class="row">

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas| Movimientos por Agentes</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
<x-adminlte-datatable id="table3" :heads="$heads">
    @foreach($Transacciones as $row)
        <tr>

            <td>{!! $row->FechaTransaccion !!}</td>
            <td>{!! $row->TipoTransaccion !!}</td>
            <td>{!! $row->TipoMoneda !!}</td>
            <td>{!! $row->MontoMoneda !!}</td>            
            <td>{!! $row->TasaCambio !!}</td>                        
            <td>{!! $row->Monto !!}</td> 
            <td>{!! $row->PorcentajeComision !!}</td>            
            <td>{!! $row->MontoComision !!}</td>            
            <td>{!! $row->MontoTotal !!}</td>
            <td>{!! $row->ClientName !!}</td>
            <td>{!! $row->AgenteName !!}</td>
            <td>{!! $row->WalletName !!}</td>


            <td class="text-center">
                <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

@section('js')
    @routes
    <script>

    const miGrupo   = {!! $myGroup !!};
    const miUsuario = {!! $myUser !!};
    const miWallet  = {!! $myWallet !!};

    // console.log(miCliente);

    // alert('miCLiente -> ' + miCliente);
    // alert('miUser    -> ' + miUsuario);
    // alert('miWallet  -> ' + miWallet);

    BuscaGrupo(miGrupo);
    // BuscaCliente(miCliente);
    BuscaUsuario(miUsuario);
    BuscaWallet(miWallet);

        $(() => {


            $('#userole').on('change', function (){

                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
                const wallet  = $('#wallet').val();
                theRoute(usuario,grupo,wallet);

            });

            $('#group').on('change', function (){
                
                const usuario = $('#userole').val();
                
                const grupo   = $('#group').val();
                const wallet = $('#wallet').val();
                const seleccionado = $('#group').prop('selectedIndex');
                // alert('***** cliente ' +  cliente + " --- selected index --- " + seleccionado);
                theRoute(usuario,grupo,wallet);


            });

            $('#wallet').on('change', function (){

                const usuario = $('#userole').val();
                const cliente = $('#cliente').val();
                const wallet = $('#wallet').val();
                // alert('***** wallet ' +  wallet);
                 theRoute(usuario,grupo,wallet);

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
                const usuario = $('#userole').val();
                const cliente = $('#cliente').val();
                const wallet = $('#wallet').val();
                theRoute(usuario,grupo,wallet,myFechaDesde,myFechaHasta);
            });

        })

        function theRoute(usuario = 0, grupo = 0, wallet = 0, fechaDesde = 0, fechaHasta = 0){
            
            if (usuario === "") usuario = 0;
            if (grupo   === "") grupo = 0;
            if (wallet  === "") wallet  = 0;

            let myRoute = "";
                myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
                myRoute = myRoute.replace('grupo2',grupo);
                myRoute = myRoute.replace('usuario2',usuario);
                myRoute = myRoute.replace('wallet2',wallet);
                myRoute = myRoute.replace('fechaDesde2',fechaDesde);
                myRoute = myRoute.replace('fechaHasta2',fechaHasta);
            console.log(myRoute);
            // alert(myRoute);
            location.href = myRoute;

        }

        function BuscaGrupo(miGrupo){
            //alert("Busca grupo - miGrupo -> " + miGrupo);
            $('#group').each( function(index, element){
                //alert ("Busca Grupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miGrupo.toString()){
                        //alert('Busca Grupo - encontro');
                        $("#group option[value="+ miGrupo +"]").attr("selected",true);
                    }
                    
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
                    
                });
            });
            //
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

        function BuscaWallet(miWallet){
            if (miWallet===0){
                return;
            }
            // alert("BuscaWallet - miWallet -> " + miWallet);
            $('#wallet').each( function(index, element){
                // alert ("BuscaWallet -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miWallet.toString()){
                        // alert('BuscaWallet - encontro');
                        $("#wallet option[value="+ miWallet +"]").attr("selected",true);
                    }
                    // alert("BuscaWallet aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }

    </script>
@endsection
