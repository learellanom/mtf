@extends('adminlte::page')
@section('title', 'Estadistica por transacciones')
@section('content')
{{-- Setup data for datatables --}}



@php

$myClass = new app\Http\Controllers\statisticsController;


$config = [
    'data' => $Transacciones,
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null],
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




$myTotal        = 0;
$myTotalBefore  = 0;
$Creditos       = 0;
$Debitos      = 0;
$saldoTotal  = 0;


$myTotalDolar   = 0;
$myTotalBeforeDolar = 0;
$CreditosDolar = 0;
$DebitosDolar = 0;
$saldoTotalDolar = 0;
//
// Moneda Origen ***********************************************
//

if (isset($balance[0]->Total)){


  // dd($balance);
  // dd($balanceBefore);

    $Creditos      = $balance[0]->Creditos;
    $Debitos       = $balance[0]->Debitos;
    $myTotal       = $balance[0]->Total;
    $myTotalBefore = $balanceBefore[0]->Total;
    $saldoTotal    = ($myTotalBefore     + $Creditos )  - $Debitos;

}

//
// Moneda Destino o dolar **************************************
//
if (isset($balance[0]->TotalDolar)){
    $CreditosDolar      = $balance[0]->MontoCreditosME;
    $DebitosDolar       = $balance[0]->MontoDebitosME;
    $myTotalDolar       = $balance[0]->TotalDolar;
    $myTotalBeforeDolar = $balanceBefore[0]->TotalDolar;
    $saldoTotalDolar    = ($myTotalBeforeDolar     + $CreditosDolar )  - $DebitosDolar;
}
// dd($balance);
// dd($myTotalDolar);

// dd($balanceBefore);
// dd($myTotalDolar);
// dd($myTotalDolarBefore);
// dd($balance);
 // dd($balanceBefore);
 // dd($saldoTotal);

@endphp


<br>
<br>
<h1 class="text-center text-dark font-weight-bold ">{{ __('Detalles de Movimientos Moneda Extranjera') }} <i class="fas fa-chart-pie fa-spin"></i></h1>
<br>
<br>
{{-- Disabled --}}


<div class="container-left">
    <div class="row col-12">

        {{-- dd($wallet) --}}
        <div class ="col-xl-2 col-sm-6">
            <x-adminlte-select2 
                id="wallet"
                name="optionsWallets"

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

        <div class ="col-xl-2 col-sm-6">
            <x-adminlte-select2 id="group"
                                name="optionsGroup"

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
            <x-adminlte-select2 id="typeTransactions"
                                name="optionstypeTransactions"

                                label-class="text-lightblue"
                                data-placeholder="Tipo Transaccion ..."
                                :config="$config2"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$typeTransactions" empty-option="Selecciona Transaccion.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-xl-2 col-sm-6">
            <x-adminlte-select2 id="userole"
                                class="mySelect"
                                name="optionsUsers"

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



        <div class ="col-xl-2 col-sm-6">
            <x-adminlte-date-range
                id="drCustomRanges"
                name="drCustomRanges"
                enable-default-ranges="Last 30 Days"
                style="height: 35px;"
                :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>
        
        <div class ="col-xl-2 col-sm-6">
			<x-adminlte-select2 id="coin"
								name="optionsCoin"

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

				<x-adminlte-options :options="$Type_coin" empty-option="Selecciona una moneda.."/>

			</x-adminlte-select2>
		</div>
        
        <!--
        <div class ="col-12 col-sm-2">
        </div>

        <div class ="col-12 col-sm-2">
        </div>
        -->
    </div>
</div>

<input type="hidden" name="theUser"                 id="theUser"        value="">
<input type="hidden" name="theWallet"               id="theWallet"      value="">
<input type="hidden" name="theGroup"                id="theGroup"       value="">
<input type="hidden" name="theFechaDesde"           id="theFechaDesde"  value="">
<input type="hidden" name="theFechaHasta"           id="theFechaHasta"  value="">
<input type="hidden" name="theTypeCoin"             id="theTypeCoin"    value="">
<input type="hidden" name="theTypeTransactions"     id="theTypeTransactions"    value="">

<div class="row">
    <div class="col-md-12">


    <div class="card-title col-md-12" style="">
              


        <div class="card mb-4">

            <div class="card-header ">

                <div class="rounded d-none d-xl-block" style="border: solid 1px black; padding: 5px">
                    <table class='table table-bordered'>
                        <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                Al corte <span id="myFecha"> {{$myFechadesdeInvertida}} </span> : 
                            </th>
                            <th>
                                Entrada
                            </th>
                            <th>
                                Salida
                            </th>
                            <th>
                                Saldo
                            </th>  
                            <th>
                                Saldo Total
                            </th>                                                        
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Saldo moneda Extranjera
                                </td>
                                <td>
                                    {{ number_format($myTotalBefore,2,",",".") }} 
                                </td>
                                <td>
                                    {{ number_format($Creditos ?? 0,2,",",".") }} 
                                </td>
                                <td>
                                    {{ number_format($Debitos ?? 0,2,",",".") }} 
                                </td>
                                <td>
                                    {{ number_format($myTotal,2,",",".") }} 
                                </td>
                                <td>
                                    {{ number_format($saldoTotal,2,",",".") }} 
                                </td>                                
                            </tr>
                            <tr>
                                <td>
                                    Saldo Dolares 
                                </td>
                                <td>
                                    {{ number_format($myTotalBeforeDolar,2,",",".") }} $
                                </td>
                                <td>
                                    {{ number_format($CreditosDolar ?? 0,2,",",".") }} $
                                </td>
                                <td>
                                    {{ number_format($DebitosDolar ?? 0,2,",",".") }} $
                                </td>
                                <td>
                                    {{ number_format($myTotalDolar,2,",",".") }} $
                                </td>
                                <td>
                                {{ number_format($saldoTotalDolar,2,",",".") }} $
                                </td>                                
                            </tr>                            
                        </tbody>
                    </table>
                </div>

                <div class="rounded d-xl-none d-block" style="border: solid 1px black; padding: 5px">
                    <table class='table table-bordered'>

                        <tbody>
                            <tr>

                                <td>
                                    <b>Saldo moneda Extranjera</b>
                                    <br><br>
                                    <b>Saldo Anterior : </b>
                                    {{ number_format($myTotalBefore,2,",",".") }} 
                                    <br><br>
                                    <b>Entrada : </b>
                                    {{ number_format($Creditos ?? 0,2,",",".") }} 
                                    <br><br>
                                    <b>Salida:</b>
                                    {{ number_format($Debitos?? 0,2,",",".") }} 
                                    <br><br>
                                    <b>Saldo:</b>
                                    {{ number_format($myTotal,2,",",".") }} 
                                    <br><br>
                                    <b>Saldo total:</b>
                                    {{ number_format($saldoTotal,2,",",".") }} 
                                </td>
                             
                            </tr>
                            <tr>

                                <td>
                                    <b>Saldo moneda Extranjera</b>
                                    <br><br>
                                    <b>Saldo Anterior:</b> 
                                    {{ number_format($myTotalBeforeDolar,2,",",".") }} $
                                    <br><br>
                                    <b>Entrada:</b> 
                                    {{ number_format($CreditosDolar?? 0,2,",",".") }} $
                                    <br><br>
                                    <b>Salida:</b> 
                                    {{ number_format($DebitosDolar ?? 0,2,",",".") }} $
                                    <br><br>
                                    <b>Saldo:</b> 
                                    {{ number_format($myTotalDolar,2,",",".") }} $
                                    <br><br>
                                    <b>Saldo total:</b> 
                                    {{ number_format($saldoTotalDolar,2,",",".") }} $
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table
                            class="table table-bordered table-responsive"
                            id="table"
                            style="width:100%;">
                            <thead>
                                <tr>
                                    {{-- <th class="dtr-control arrow-right" style="display: none;"></th> --}}
                                    {{-- <th style="width:10%; display: none">Id</th> --}}
                                    <th style="width:7%;">Fecha</th>
                                    <th style="width:1%;">Transacción</th>
                                    <th style="width:8%;">Descripción</th>
                                    <th style="width:1%;">Moneda</th>
                                    <th style="width:3%;">Monto Moneda </th>
                                    <th style="width:1%;">Tasa</th>
                                    <th style="width:1%;">Moneda Balance</th>
                                    <th style="width:1%;">Monto $ </th>
                                    {{-- <th style="width:1%;">Saldo <i class="fas fa-dolar"></i></th> --}}
                                    <th style="width:4%;">Grupo</th>
                                    <th style="width:1%;">Agente</th>
                                    <th style="width:4%;">Caja</th>
                                    <th style="width:1%;">Ver <i class="fas fa-search"></i></th>
                                    <th style="width:1%;" class="no-exportar">Historico</th>

                                </tr>
                            </thead>
                            @php
                                $myTotal = 0;
                                $myTotal = $balanceBefore->Total ?? 0; // asigna el saldo al corte para que calcule desde ahi
                                // \Log::info('leam - balanceBefore->Total -> ' . $balanceBefore->Total);
                            @endphp
                          
                            @foreach($config['data'] as $row)
                            
                                @php
                                    if ($myWallet != 0){
                                  
                                        // valida si viene con filtro por algun tipo de transaccion

                                        if ($myTypeTransactions == 0){
                                            
                                             // dd(' MONTO TOTAL' . ' ' . $row->MontoTotalBase); 
                                            //       dd($myWallet);
                                            $myPorcentajeComision   = $row->PorcentajeComisionBase;
                                            $myMontoComision        = $row->MontoComisionBase;
                                            $myTotal2               = $row->MontoTotalBase;

                                            $TasaCambio             = $row->TasaCambio;
                                            $Monto                  = $row->MontoBase;
                                            // $Monto                  = $row->Monto;
                                        }else{
                                            
                                            $myPorcentajeComision   = $row->PorcentajeComision;
                                            $myMontoComision        = $row->MontoComision;
                                            $myTotal2               = $row->MontoTotal;

                                            $TasaCambio             = $row->TasaCambio;                                        
                                            $Monto                  = $row->Monto;                                            
                                        }

                                    }else{
                                        
                                        $myPorcentajeComision   = $row->PorcentajeComision;
                                        $myMontoComision        = $row->MontoComision;
                                        $myTotal2               = $row->MontoTotal;

                                        $TasaCambio             = $row->TasaCambio;                                        
                                        $Monto                  = $row->Monto;
                                    }
                                    // 'Transactions.amount_total_base         as MontoTotalBase',
                                    // 'Transactions.percentage_base           as PorcentajeComisionBase',
                                    // 'Transactions.amount_commission_base    as MontoComisionBase',

                                    $indWallet = 0;
                                    if ($myWallet != "0"){
                                        if ($myGroup == "0"){
                                              $indWallet = 1;
                                            // show();
                                        }
                                    }
                                    
                                    if ($indWallet == 0){
                                        
                                        $myTransaction  = $myClass->getCreditDebitGroup($row->TransactionId);
                                        switch  ($myTransaction){
                                            //
                                            // resta
                                            //
                                            case "Debito":                                     
                                                // $myTotal = $myTotal + ($row->MontoTotal * -1);
                                                $myTotal = $myTotal + ($myTotal2 * -1);                                                
                                                break;
                                            //
                                            // suma
                                            //
                                            case "Credito":                                            
                                                // $myTotal = ($myTotal) + ($row->MontoTotal);
                                                $myTotal = ($myTotal) + ($myTotal2);                                                
                                                break;
                                            default:
                                                $myTotal = 0;
                                                break;
                                        }
                                    }else{

                                        $myTransaction  = $myClass->getCreditDebitWallet($row->TransactionId);
                                        
                                        
                                        //     \Log::info(' row -> ' . print_r($row,true) );
                                        //     \Log::info(' myTotal -> ' . $myTotal);
                                        
                                        
                                        // echo "myTransaction  $row->TransactionId -- $myTransaction";
                                        // dd($myTransaction . ' ' . $myTotal2 . ' y total es ' . $myTotal);
                                        switch  ($myTransaction){
                                            //
                                            // debito
                                            // resta
                                            //
                                            case "Debito":
                                                // $myTotal = $myTotal + ($row->MontoTotal * -1);
                                                $myTotal = $myTotal + ($myTotal2 * -1);                                                
                                                break;

                                            //
                                            // credito
                                            // suma
                                            //
                                            case "Credito":
                                                // $myTotal = ($myTotal) + ($row->MontoTotal);
                                                $myTotal = ($myTotal) + ($myTotal2);                                                
                                                break;
                                            default:
                                                $myTotal = 0;
                                                break;
                                        }
                                        
                                    }
                                @endphp

                                {{-- dd($row)--}}
                                
                                <tr>
                                    
                                    {{-- <td><i class="fas fa-plus"></i></td> --}}
                                    {{-- <td style="display: none;">{!! $row->Id !!}</td> --}}
                                    <td>
                                        {{ substr($row->FechaTransaccion,0,10) }}
                                        <br>
                                        {{ substr($row->FechaTransaccion,11) }}

                                    </td>
                                    <td>{!! $row->TipoTransaccion !!}</td>
                                    <td>{!! $row->Descripcion !!}</td>
                                    <td>{!! $row->TipoMoneda !!}</td>
                                    <td class="text-right"  >{!! number_format($row->MontoMoneda,2) !!}</td>
                                    <td class="text-left"   >{!! number_format($TasaCambio,2) !!}</td>
                                    <td class="text-left"   >{!! $row->TipoMonedaBalance!!} </td>
                                    <td class="text-right"  >{!! number_format($Monto,2) !!}</td>

                                    {{-- <td class="text-right">{!! number_format($myTotal,2) !!}</td> --}}


                                    <td>{!! $row->ClientName !!}</td>
                                    <td>{!! $row->AgenteName !!}</td>
                                    <td>{!! $row->WalletName !!}</td>


                                    <td class="text-center">
                                        <a
                                            href="{{ route('transactions.show', ['movimiento'=> $row->Id]) }}"
                                            title="Detalles"
                                            class="btn text-dark mx-1 shadow text-center">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>


                                    {{-- aqui va anular/activar --}}
                                    {{-- dd($myTotal2) --}}

                                    <td>
                                        <a  href="{{ route('transactions.audit', $row->Id) }}" 
                                            class="btn text-dark mx-1 shadow text-center">
                                            <i class="fa fa-lg fa-fw fas fa-solid fa-list"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                            {{--
                            <tfoot style="background-color: black; color: white;">                       
                                    <td style="display: none;"></td>     
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>test</td>
                                    <td></td>
                                    <td></td>
                                    <td>test</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                            </tfoot>
                            --}}
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')
@routes
<style>
    /*
    
     Paging bar para mobiles 
     solo 2 botones
    
    */
    @media screen and (max-width: 767px) {
        li.paginate_button.previous {
            display: inline;
        }
    
        li.paginate_button.next {
            display: inline;
        }
    
        li.paginate_button {
            display: none;
        }
    }
</style>
<script>
    

    const miGrupo               = {!! $myGroup !!};
    const miUsuario             = {!! $myUser !!};
    const miWallet              = {!! $myWallet !!};
    const miTypeTransactions    = {!! $myTypeTransactions !!};
    const miTotal               = {!! $myTotal !!};   
    const myTypeCoin            = '{!! $myTypeCoin !!}';
    const myFechaDesde = '{{ $myFechaDesde }}';
    const myFechaHasta = '{{ $myFechaHasta }}';

    $(() => {
        if (miUsuario != 0 && miUsuario != ''){
            $('#theUser').val({{ $myUser}});
        }        
        if (miWallet != 0 && miWallet != ''){
            $('#theWallet').val({{ $myWallet}});
        }
        if (miGrupo != 0 && miGrupo != ''){

            $('#theGroup').val({{ $myGroup}});
        }
        if (myFechaDesde != 0 && myFechaDesde != ''){
            $('#theFechaDesde').val(myFechaDesde);
        }
        if (myFechaHasta != 0 && myFechaHasta != ''){
            $('#theFechaHasta').val(myFechaHasta);
        }
        if (myTypeCoin != 0 && myTypeCoin != ''){
            $('#theTypeCoin').val(myTypeCoin);
        }
        if (miTypeTransactions != 0 && miTypeTransactions != ''){
            $('#theTypeTransactions').val(miTypeTransactions);
        }        
    }
    );



    // alert ('myTotal ->' +);
    // console.log(miCliente);
    
    // console.log(miWallet);

    // alert('miCLiente -> ' + miCliente);
    // alert('miUser    -> ' + miUsuario);
    // alert('miWallet  -> ' + miWallet);

    const miGrupoDes = BuscaGrupo(miGrupo);

    // BuscaCliente(miCliente);
    BuscaUsuario(miUsuario);
    BuscaWallet(miWallet);
    BuscaTypeTransactions(miTypeTransactions); 
    

    BuscaMoneda(myTypeCoin);    

    $('#table').DataTable( {

        language: {
            "decimal"       : "",
            "emptyTable"    : "No hay transacciones.",
            "info"          : "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty"     : "Mostrando 0 to 0 de 0 Entradas",
            "infoFiltered"  : "(Filtrado de _MAX_ total entradas)",
            "infoPostFix"   : "",
            "thousands"     : ",",
            "lengthMenu"    : "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing"    : "Procesando...",
            "search"        : "Buscar:",
            "zeroRecords"   : "Sin resultados encontrados",
            "paginate": {
                "first"     : "Primero",
                "last"      : "Ultimo",
                "next"      : "Siguiente",
                "previous"  : "Anterior"
            }
        },
        
        // responsive: true,
        // columnDefs: [
        //      {
        //          className: 'dtr-control',
        //          orderable: false,
        //          targets: -1
        //      },                 
        //     { responsivePriority: 1, targets: 1 },
        //     { responsivePriority: 2, targets: 2 },
        //     { responsivePriority: 3, targets: 9 },
        //     { responsivePriority: 4, targets: 10 },
        //     { responsivePriority: 5, targets: 11 },

        // ],  
        //
        /*
        columnDefs: [
             {
                 className: 'dtr-control arrow-right',
                 orderable: false,
                 target: 0
             },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 9 },
            { responsivePriority: 4, targets: 10 },
            { responsivePriority: 5, targets: 11 },             
        ],  
        responsive: true,
        */
        'dom' : '<"row" <"col-12 col-md-6" B> <"col-12 col-md-6 text-align-right" f> >ti <"row" <"col-12 col-md-6" l> <"col-12 col-md-6" p>>',
        'pageLength' : 7, 
        'buttons':[
            {
                extend:  'excelHtml5',
                exportOptions: { columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11] },
                text:    '<i class="fas fa-file-excel"></i>',
                title: `Detalle de Movimientos Moneda Extranjera`,
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',
                excelStyles: [
                    {
                        "template": ["title_medium", "gold_medium"]
                    },    
                ],
                insertCells: [                  // Add an insertCells config option 
                    // {
                    //     cells: '1:1',              // Target data row 5 and 6
                    //     content: 'sssss',                // Add empty content
                    //     pushRow: true               // push the rows down to insert the content
                    // },
                    {
                        cells: 'sh',                // Target data row 5 and 6
                        content: '',           // Add empty content
                        pushRow: true               // push the rows down to insert the content
                    },                    
                ],                                                                                                               
            },
            {
                extend:  'pdfHtml5',
                exportOptions: { columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11] },
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'Detalle de movimientos moneda extranjera',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',

            },
            {
                extend:  'print',
                exportOptions: { columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11] },
                styles: { 
					fullWidth: { fontSize: 8, bold: true, alignment: 'right', margin: [0,0,0,0] }
		        },
                text:    '<i class="fas fa-print"></i>',
                titleAttr: 'Capture de pantalla',
                className: 'btn btn-info'
            },
        ]
    });

    $(() => {

       // const myFechaDesde = '{!! isset($myFechaDesde) ?? 0 !!}';

        // $('#drCustomRanges').daterangepicker({}); 
        //BuscaFechas(myFechaDesde, myFechaHasta);

        BuscaFechasBlade(myFechaDesde, myFechaHasta);

        $('#wallet').on('change', function (){

            const wallet            = $('#wallet').val();

            $('#theWallet').val(wallet);

            theRoute();

        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });  

        $('#group').on('change', function (){

            const grupo             = $('#group').val();
            $('#theGroup').val(grupo);

            theRoute();
            

        })
            .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        }); 

        $('#typeTransactions').on('change', function (){

            const typeTransactions  = $('#typeTransactions').val();

            $('#theTypeTransactions').val(typeTransactions);

            theRoute();

        })
            .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('#userole').on('change', function (){

            const usuario           = $('#userole').val();
            $('#theUser').val(usuario);

            theRoute();

        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });        
        
       

        $('#drCustomRanges').on('change', function () {

            let myFechaDesde, myFechaHasta;

            myFechaDesde = $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD');
            myFechaHasta = $('#drCustomRanges').data('daterangepicker').endDate.format('YYYY-MM-DD');

            $('#theFechaDesde').val(myFechaDesde);
            $('#theFechaHasta').val(myFechaHasta);
            
            theRoute();
        });


		$('#coin').on('change', function (){
            const coin              = $('#coin').val();    
            $('#theTypeCoin').val(coin);
            theRoute();
        })
        .on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

    });

    $('#coin').select2({
        allowClear: true
    });

    function theRoute(usuario = null, grupo = null, wallet = null, typeTransactions = null, fechaDesde = null, fechaHasta = null, coin = null){

        if ($('#theUser').val() != ''){
            usuario = $('#theUser').val();
        }

        if ($('#theGroup').val() != ''){
            grupo = $('#theGroup').val();
        }

        if ($('#theWallet').val() != ''){
            wallet = $('#theWallet').val();
        }

        if ($('#theTypeTransactions').val() != ''){
            typeTransactions = $('#theTypeTransactions').val();
        }

        if ($('#theFechaDesde').val() != ''){
            fechaDesde = $('#theFechaDesde').val();
        }

        if ($('#theFechaHasta').val() != ''){
            fechaHasta = $('#theFechaHasta').val();
        }

        if ($('#theTypeCoin').val() != ''){
            coin = $('#theTypeCoin').val();
        }

        let myRoute = "";

        myRoute = "{{ route('movimientosME', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2' , 'typeTransactions' => 'typeTransactions2', 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'coin' => 'coin2']) }}";
        // alert('ruta base -> ' + myRoute);
                       
        
        if (usuario){
            myRoute = myRoute.replace('usuario2',usuario);
        }else{
            myRoute = myRoute.replace('&amp;usuario=usuario2','');
            myRoute = myRoute.replace('&usuario=usuario2','');
            myRoute = myRoute.replace('usuario=usuario2','');
        }
        if (grupo){
            myRoute = myRoute.replace('grupo2',grupo);
        }else{
            myRoute = myRoute.replace('&amp;grupo=grupo2','');
            myRoute = myRoute.replace('&grupo=grupo2','');
        }

        if (wallet){
            myRoute = myRoute.replace('wallet2',wallet);
        }else{
            myRoute = myRoute.replace('&amp;wallet=wallet2','');
            myRoute = myRoute.replace('&wallet=wallet2','');
        }

        if (typeTransactions){
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);
        }else{
            
            myRoute = myRoute.replace('&amp;typeTransactions=typeTransactions2','');
            
            myRoute = myRoute.replace('&typeTransactions=typeTransactions2','');
        }

        if (fechaDesde){
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        }else{
            myRoute = myRoute.replace('&amp;fechaDesde=fechaDesde2','');
            myRoute = myRoute.replace('&fechaDesde=fechaDesde2','');
        }

        if (fechaHasta){
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        }else{
            myRoute = myRoute.replace('&amp;fechaHasta=fechaHasta2','');
            myRoute = myRoute.replace('&fechaHasta=fechaHasta2','');
        }

        if (coin){
            myRoute = myRoute.replace('coin2',coin);
        }else{
            myRoute = myRoute.replace('&amp;coin=coin2','');
            myRoute = myRoute.replace('&coin=coin2','');
        }
        // alert('la ruta despues -> ' + myRoute);
        myRoute = myRoute.replaceAll('amp;','');

        // alert(myRoute);
        location.href = myRoute;

    }

    function BuscaGrupo(miGrupo){
        $('#group').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miGrupo.toString()){
                    $("#group option[value="+ miGrupo +"]").attr("selected",true);
                    
                }
            });
        });
        return  $("#group option:selected").text().trim();
    }

    function BuscaCliente(miCliente){
        $('#cliente').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miCliente.toString()){
                    $("#cliente option[value="+ miCliente +"]").attr("selected",true);
                }

            });
        });
    }

    function BuscaUsuario(miUsuario){
        if (miUsuario===0){
            return;
        }
        $('#userole').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miUsuario.toString()){
                    $("#userole option[value="+ miUsuario +"]").attr("selected",true);
                }
            });
        });
    }

    function BuscaWallet(miWallet){
        if (miWallet===0){
            return;
        }

        $('#wallet').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miWallet.toString()){
                    $("#wallet option[value="+ miWallet +"]").attr("selected",true);
                }
            });
        });
        //
    }


    function BuscaTypeTransactions(miTypeTransactions){
        if (miTypeTransactions===0){
            return;
        }

        $('#typeTransactions').each( function(index, element){
            $(this).children("option").each(function(){
                if ($(this).val() === miTypeTransactions.toString()){
                    $("#typeTransactions option[value="+ miTypeTransactions +"]").attr("selected",true);
                }
            });
        });
        //
    }

    function BuscaFechas(FechaDesde = 0,FechaHasta = 0){

        myLocation  = window.location.toString();

        myArray     = myLocation.split("/");
        if (myArray.length > 4){
            FechaDesde = myArray[8];
            FechaHasta = myArray[9];
        }else{
            FechaDesde = 0;
            FechaHasta = 0;       
        }

        if (FechaDesde == 0) return;


        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);

    }

    function invierteFecha(myFecha = "2001-01-01"){
        myDay   = myFecha.substr(8,2);
        myMonth = myFecha.substr(5,2);
        myYear  = myFecha.substr(0,4);

        if (myFecha == 0){
            myFecha = "2001-01-01";
        }

        if (myFecha == "2001-01-01"){
            $("#myFecha").html('');
        }else{
            $("#myFecha").html(`${myDay}-${myMonth}-${myYear}`);
        }

    }

    function BuscaMoneda(myTypeCoin){
        if (myTypeCoin == '')  return;
        //alert("BuscaGrupo - miGrupo -> " + miGrupo);
        $('#coin').each( function(index, element){
            //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myTypeCoin.toString()){
                    //alert('Buscagrupo - encontro');
                    $("#coin option[value="+ myTypeCoin +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

    function BuscaFechasBlade(){

        let myFechaDesdeInicial = "{{ $myFechaDesde }}";
        if (myFechaDesdeInicial == "2001-01-01"){
            return;
        }
        if (myFechaDesdeInicial == ""){
            return;
        }
        // alert('myFechaDesdeInicial -> ' + myFechaDesdeInicial);

        let myFechaAnio  = '{{ substr($myFechaDesde,0,4) }}';
        let myFechaMes   = '{{ substr($myFechaDesde,5,2) }}';
        let myFechaDia   = '{{ substr($myFechaDesde,8,2) }}';

        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaDesde2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio)

        myFechaAnio  = '{{ substr($myFechaHasta,0,4) }}';
        myFechaMes   = '{{ substr($myFechaHasta,5,2) }}';
        myFechaDia   = '{{ substr($myFechaHasta,8,2) }}';

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
