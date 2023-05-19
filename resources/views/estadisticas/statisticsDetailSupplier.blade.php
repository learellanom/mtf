@extends('adminlte::page')
@section('title', 'Estadistica Proveedor por transacciones')
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
    ['label' => 'Proveedor',            'no-export' => true, 'width' => 5],
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
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Detalles de Transacciones Proveedor') }}<i class="fas fa-chart-pie fa-spin"></i></h1>
<br>
<br>
{{-- Disabled --}}


<div class="container-left">
    <div class="row col-12">

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="supplier"
                                name="optionsSupplier"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Supplier ..."
                                :config="$config2"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$supplier" empty-option="Selecciona un proveedor.."/>
            </x-adminlte-select2>
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
            <x-adminlte-select2 id="typeTransactions"
                                name="optionsTypeTransactions"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Tipo Transaccion..."
                                :config="$config4"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-box"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$Type_transactions" empty-option="Tipo Transaccion.."/>
            </x-adminlte-select2>
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



    </div>
</div>


<br>
<br>



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
                                            case 11:
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


                                    <td>{!! $row->SupplierName !!}</td>
                                    <td>{!! $row->AgenteName !!}</td>
                                    <td>{!! $row->WalletName !!}</td>

                                    <td class="text-center">
                                    <a                      
                                            href="{{ route('transactions_supplier.show', ['movimientos_proveedore'=> $row->Id]) }}"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"

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

    const miWallet              = {!! $myWallet !!};
    const miSupplier            = {!! $mySupplier !!};
    const miTypeTransactions    = {!! $myTypeTransactions !!};
    let  miFechaDesde           = {!! $myFechaDesde !!};
    let  miFechaHasta           = {!! $myFechaHasta !!};


    // alert('recibe las fechas : fecha dfesde -> ' + miFechaDesde + ' y la fecha hasta -> ' + miFechaHasta );

    BuscaSupplier(miSupplier);

    BuscaWallet(miWallet);

    BuscaTypeTransactions(miTypeTransactions);

    BuscaFechas(miFechaDesde, miFechaHasta);

    $(() => {


            $('#supplier').on('change', function (){

                const supplier      = $('#supplier').val();
                const wallet        = $('#wallet').val();

                const seleccionado  = $('#supplier').prop('selectedIndex');

                // alert('supplier -> ' + supplier);

                var URLactual = window.location;
                // alert(URLactual);

                theRoute(supplier,wallet);


            });

            $('#wallet').on('change', function (){

                const supplier      = $('#supplier').val();
                const wallet        = $('#wallet').val();
                const typeTransactions  = $('#typeTransactions').val();
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
                theRoute(supplier,wallet,typeTransactions,myFechaDesde,myFechaHasta);

             });

             $('#typeTransactions').on('change', function (){

                const supplier          = $('#supplier').val();
                const wallet            = $('#wallet').val();
                const typeTransactions  = $('#typeTransactions').val();
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

                theRoute(supplier,wallet,typeTransactions,myFechaDesde,myFechaHasta);

            });

            $('#drCustomRanges').on('change', function () {
                // alert('Fechas rangos -> ' + $('#drCustomRanges').val());
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

                // alert('Fecha Desde -> ' + myFechaDesde + ' Fecha Hasta -> ' + myFechaHasta);

                const supplier           = $('#supplier').val();
                const wallet            = $('#wallet').val();
                const typeTransactions  = $('#typeTransactions').val();   

                theRoute(supplier,wallet,typeTransactions,myFechaDesde,myFechaHasta);
            });



        })


        function theRoute(supplier = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){

            if (supplier   === "")          supplier    = 0;
            if (wallet  === "")             wallet      = 0;
            if (typeTransactions  === "")   typeTransactions = 0;

            let myRoute = "";
                myRoute = "{{ route('estadisticasDetalleProveedor', ['supplier' => 'supplier2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
                myRoute = myRoute.replace('supplier2',supplier);
                myRoute = myRoute.replace('wallet2',wallet);
                myRoute = myRoute.replace('typeTransactions2',typeTransactions);                
                myRoute = myRoute.replace('fechaDesde2',fechaDesde);
                myRoute = myRoute.replace('fechaHasta2',fechaHasta);
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

        function BuscaSupplier(miSupplier){
            if (miSupplier===0){
                return;
            }
            // alert("BuscaSupplier - miSupplier -> " + miSupplier);
            $('#supplier').each( function(index, element){
                // alert ("BuscaSupplier -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miSupplier.toString()){
                        // alert('BuscaSupplier - encontro');
                        $("#supplier option[value="+ miSupplier +"]").attr("selected",true);
                    }
                    // alert("BuscaSupplier aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }

        function BuscaTypeTransactions(miTypeTransactions){
            if (miTypeTransactions===0){
                return;
            }
            // alert("BuscaTypeTransactions - miSupplier -> " + miTypeTransactions);
            $('#typeTransactions').each( function(index, element){
                // alert ("BuscaTypeTransactions -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
                $(this).children("option").each(function(){
                    if ($(this).val() === miTypeTransactions.toString()){
                        // alert('BuscaTypeTransactions - encontro');
                        $("#typeTransactions option[value="+ miTypeTransactions +"]").attr("selected",true);
                    }
                    // alert("BuscaTypeTransactions aqui ->  the val " + $(this).val() + " text -> " + $(this).text());
                });
            });
            //
        }

        function BuscaFechas(FechaDesde = 0,FechaHasta = 0){
            
            myLocation  = window.location.toString();
            myArray     = myLocation.split("/");
            
            if (myArray.length > 4){
                FechaDesde = myArray[7];
                FechaHasta = myArray[8];
                
            }else{
                
                FechaDesde = 0;
                FechaHasta = 0;       
            }
            
            if (FechaDesde == 0) return;

            let myFechaDesde, myFechaHasta, myFecha;

            myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
            myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

            myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();
            // alert('myFecha -> ' + myFecha );
            $('#drCustomRanges').val(myFecha);

        }

    </script>
@endsection
