@extends('adminlte::page')
@section('title', 'Estadisticas por agentes')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Agente',
    'Cliente',
    'Monto Transaccion',
    'Fecha Transaccion',
    'Wallet',
    'Transaccion',
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
                    <div class="input-group-text bg-gradient-info">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$userole" empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="cliente"
                                name="optionsCliente"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Cliente ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$cliente" empty-option="Selecciona un Cliente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
        </div>
        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
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
                    <div class="input-group-text bg-gradient-info">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
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
            <td>{!! $row->AgenteName !!}</td>
            <td>{!! $row->ClientName !!}</td>
            <td>{!! $row->Monto !!}</td>
            <td>{!! $row->FechaTransaccion !!}</td>
            <td>{!! $row->WalletName !!}</td>
            <td>{!! $row->TipoTransaccion !!}</td>

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

    const miCliente = {!! $myCliente !!};
    const miUsuario = {!! $myUser !!};
    const miWallet  = {!! $myWallet !!};

    // console.log(miCliente);

    // alert('miCLiente -> ' + miCliente);
    // alert('miUser    -> ' + miUsuario);
    // alert('miWallet  -> ' + miWallet);

    BuscaCliente(miCliente);
    BuscaUsuario(miUsuario);
    BuscaWallet(miWallet);

        $(() => {


            $('#userole').on('change', function (){

                const usuario = $('#userole').val();
                const cliente = $('#cliente').val();
                const wallet = $('#wallet').val();
                 theRoute(usuario,cliente,wallet);

            });

            $('#cliente').on('change', function (){
                const usuario = $('#userole').val();
                const cliente = $('#cliente').val();
                const wallet = $('#wallet').val();
                const seleccionado = $('#cliente').prop('selectedIndex');
                // alert('***** cliente ' +  cliente + " --- selected index --- " + seleccionado);
                theRoute(usuario,cliente,wallet);


            });

            $('#wallet').on('change', function (){

                const usuario = $('#userole').val();
                const cliente = $('#cliente').val();
                const wallet = $('#wallet').val();
                // alert('***** wallet ' +  wallet);
                 theRoute(usuario,cliente,wallet);

             });

            $('#drCustomRanges').on('change', function () {
                alert('ggggg ' + $('#drCustomRanges').val());
            });

        })

        function theRoute(usuario = 0, cliente = 0, wallet = 0){

            if (usuario === "") usuario = 0;
            if (cliente === "") cliente = 0;
            if (wallet  === "") wallet  = 0;

            let myRoute = "";
                myRoute = "{{ route('agentes', ['usuario' => 'usuario2', 'cliente' => 'cliente2', 'wallet' => 'wallet2']) }}";
                myRoute = myRoute.replace('cliente2',cliente);
                myRoute = myRoute.replace('usuario2',usuario);
                myRoute = myRoute.replace('wallet2',wallet);
            console.log(myRoute);
            // alert(myRoute);
            location.href = myRoute;

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
