@extends('adminlte::page')
@section('title', 'Estadistica Master por transacciones')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    ['label' => 'Fecha',                'no-export' => false, 'width' => 8],
    ['label' => 'Transacción',          'no-export' => true, 'width' => 5],
    ['label' => 'Descripción',          'no-export' => true, 'width' => 5],
    ['label' => 'Moneda',               'no-export' => true, 'width' => 2],
    ['label' => 'MontoMoneda',          'no-export' => true, 'width' => 5],
    ['label' => 'Tasa',                 'no-export' => true, 'width' => 5],
    ['label' => 'Monto $',              'no-export' => true, 'width' => 7],
    ['label' => '%',                    'no-export' => true, 'width' => 1],
    ['label' => 'Comision $',           'no-export' => true, 'width' => 8],
    ['label' => 'Monto Total $',        'no-export' => true, 'width' => 7],
    ['label' => 'Saldo $',              'no-export' => true, 'width' => 5],
    ['label' => 'Cliente',              'no-export' => true, 'width' => 5],
    ['label' => 'Agente',               'no-export' => true, 'width' => 8],
    ['label' => 'Caja',                 'no-export' => true, 'width' => 5],
    ['label' => 'Ver',                  'no-export' => true, 'width' => 3],
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
    'data' => $Transacciones,
    'order' => [[1, 'desc']],
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false]],
];

$config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';



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


$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

$myTotal = 0;
if (isset($balance->Total)){
    //echo "ajua";
    //var_dump($balance);
    $myTotal = $balance->Total;
}

@endphp


<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Detalles de Transacciones Master') }}<i class="fas fa-chart-pie fa-spin"></i></h1>
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
                <x-adminlte-options
                    :options="$userole"
                    empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="group"
                                name="optionsGroup"
                                igroup-size="sm"
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

        <div class ="col-12 col-sm-2">
        </div>

        <div class ="col-12 col-sm-2">
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
                    <div class="card-title col-md-12">
                        <div class="card-body">

                        <div class= "row">
                            <div class="col-md-4">
                                <h4 class="text-uppercase font-weight-bold">{{ __('Detalles|Movimientos') }} <i class="fas fa-info-circle"></i></h4>
                            </div>
                            <div class="col-md-4">

                                @if($myTotal< 0)
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo A favor' )}}: {{ number_format(abs($myTotal),2,",",".") }} $</h4>
                                @else
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo A favor' )}}: {{ number_format(0,2,",",".") }} $</h4>
                                @endif

                            </div>
                            <div class="col-md-4">

                                @if($myTotal< 0)
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo Pendiente' )}}: {{ number_format(0,2,",",".") }} $</h4>
                                @else
                                <h4 class='text-uppercase font-weight-bold'>{{__('Saldo Pendiente' )}}: {{ number_format($myTotal,2,",",".") }} $</h4>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $myTotal = 0;
                            @endphp
                            <x-adminlte-datatable
                                id="table3"
                                :heads="$heads"

                                striped
                                with-buttons

                                class="table table-bordered table-responsive-lg bg-white">
                                @foreach($config['data'] as $row)
                                    <tr>

                                        <td>{!! $row->FechaTransaccion !!}</td>
                                        <td>{!! $row->TipoTransaccion !!}</td>
                                        <td>{!! $row->Descripcion !!}</td>
                                        <td>{!! $row->TipoMoneda !!}</td>
                                        <td class="text-right">{!! number_format($row->MontoMoneda,2,",",".") !!}</td>
                                        <td class="text-left">{!! $row->TasaCambio !!}</td>
                                        <td class="text-right">{!! number_format($row->Monto,2,",",".") !!}</td>
                                        <td class="text-left">{!! $row->PorcentajeComision !!}</td>
                                        <td class="text-right">{!! number_format($row->MontoComision,2,",",".") !!}</td>
                                        <td class="text-right">{!! number_format($row->MontoTotal,2,",",".") !!}</td>

                                        @php
                                            switch  ($row->TransactionId){
                                                case 1:
                                                case 3:
                                                case 5:
                                                case 7:
                                                case 9:
                                                    $myTotal = $myTotal + ($row->MontoTotal * -1);
                                                    break;
                                                case 4:
                                                case 8:
                                                case 2:
                                                case 6:
                                                    $myTotal = ($myTotal) + ($row->MontoTotal);
                                                    break;
                                                default:
                                                    $myTotal = 0;
                                                    break;
                                            }
                                        @endphp
                                        <td class="text-right">{!! number_format($myTotal,2,",",".") !!}</td>


                                        <td>{!! $row->ClientName !!}</td>
                                        <td>{!! $row->AgenteName !!}</td>
                                        <td>{!! $row->WalletName !!}</td>

                                        <td class="text-center">
                                            <!-- <a
                                                href="{{ route('transactions.show', ['movimiento'=> $row->Id]) }}"
                                                title="Detalles"
                                                class="btn btn-xl text-primary mx-1 shadow text-center"

                                            >
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </a>    -->
                                            <a
                                                href="{{ route('transactions.show', ['movimiento'=> $row->Id]) }}"
                                                title="Detalles"
                                                class="btn btn-xl text-dark mx-1 shadow text-center"

                                            >
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </a>
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

                var URLactual = window.location;
                // alert(URLactual);

                theRoute(usuario,grupo,wallet);


            });

            $('#wallet').on('change', function (){

                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
                const wallet = $('#wallet').val();
                // alert('***** wallet ' +  wallet);
                 theRoute(usuario,grupo,wallet);

             });

            $('#drCustomRanges').on('change', function () {
                alert('Fechas rnagos -> ' + $('#drCustomRanges').val());
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

                alert('Fecha Desde -> ' + myFechaDesde + ' Fecha Hasta -> ' + myFechaHasta);
                const usuario = $('#userole').val();
                const grupo   = $('#group').val();
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
