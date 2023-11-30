@extends('adminlte::page')
@section('title', 'Estadisticas')
<!-- @section('plugins.chartJs', true) -->
@section('content')

@php


// $myClass = new app\Http\Controllers\statisticsController;

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
    "showDropdowns:" => "true",
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

// dd($wallet);


$myCantGeneral                  = 0;
$totalComisionGeneral           = 0;
$totalComisionBaseGeneral       = 0;
$totalComisionExchangeGeneral   = 0;
$totalComisionGananciaGeneral   = 0;
$totalComisionGanancia2General  = 0;

$entradaCant    = 0;
$entradaMonto   = 0;

$salidaCant     = 0;
$salidaMonto    = 0;

@endphp
<style>
    .myTr {
        cursor: pointer;
    }
    .myTr:hover{
        background-color: #D7DBDD  !important;
    }
    .myTdColorBlack{
            width:1%;
            background-color: black;
            color: white;
    }
    .myTdColor2{
            width:1%;
            background-color: silver !important;
            color: black !important;
    }
    .myTdColor3{
            width:1%;
            background-color: gray !important;
            color: white !important;
    }
    .myTdColor4{
        font-weight: bold !important;
        color: green !important;
    }
    .myTdColor5 {
        width:1%;
        background-color: #2874A6  !important;
        color: white !important;          
    }
    .myTdColor6 {
        width:1%;
        background-color: #BB8FCE   !important;
        color: white !important;          
    }
    .myTdHighlight {
        font-weight: 800;
        color: green !important;          
    }    
    .myWidth {
        width: 10rem;
        min-width: 10rem;
        max-width: 10rem;
    }
</style>

<!-- <div class="container justify-content-center" style="display: contents;"> -->
<div class="container justify-content-center">

    <div class="row col-12 col-md-12 justify-content-center text-center align-items-center" style="min-height: 5rem !important">
        <h4>Historicos de cambios por transaccion</h4>
    </div>


    <div class="row col-12 col-md-12 ">

            <style>
                .myTr {
                    cursor: pointer;
                }
                .myTr:hover{
                    background-color: #D7DBDD  !important;
                }
                .myTable th {
                    width: 20% !important;
                    min-wdth: 20% !important;
                    max-wdth: 20% !important;
                    background-color: orange !important;
                }
                .myWidth2{
                    width: 12%;
                    min-width: 12%;
                    max-width: 12%;
                }
            </style>

            {{-- dd($balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore) --}}
                
            <div class ="row mb-4" style="background-color: white;" data-wallet="">
                <div class="col-12 text-center mt-5">
                    <h3>Transaccion: {{ $myMovimiento}}</h3>
                </div>            

                <div class="col-12 col-md-12">
                    
                        @if(!$transaccion)
                            <div class="col-12 justify-content-center text-center align-items-center" style="height: 20rem; width: 60rem">
                                <h3 class="mt-5">Sin registro en Historico de cambios</td>
                            </div>
                        @else
                            <table class="table thead-light" style="background-color: white;">

                                @foreach($audits as $myAudit)

                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="myWidth2" style="width: 1% !important;">ID</th>
                                            <th class="" style="width: 20% !important;">Fecha</th>                                
                                            <th class="myWidth2"                       >Usuario</th>
                                            <th class="myWidth2"                       >Accion</th>
                                            <th class=""  style="width: 5rem;"         >Datos</th>
                                        </tr>
                                    </thead>
                                    <tr class="myTr">
                                        <td>{{ $myAudit->auditable_id}}</td>
                                        <td>{{ $myAudit->created_at }}</td>                                
                                        <td>{{ $myAudit->user->name}}</td>
                                        <td>{{ campoDescripcion($myAudit->event) }}</td>
                                        <td>
                                                {{--
                                            <table>
                                                @foreach($myAudit->new_values as  $key => $theValues)
                                                    <tr>
                                                        <td>
                                                            {{ campoDescripcion($key)}}
                                                        </td>
                                                        <td>
                                                            {{ campoMascara($key, $theValues, $transaccion) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            --}}

                                            <!-- aqui -->

                                            <p>
                                            <a class="btn btn-primary" 
                                                data-toggle="collapse"
                                                href="#collapseExample{{$myAudit->id}}"
                                                role="button" 
                                                aria-expanded="false" 
                                                aria-controls="collapseExample">
                                                mas...
                                            </a>

                                            </p>
                                            <div class="collapse" id="collapseExample{{$myAudit->id}}">
                                                <div class="card card-body">
                                                    <table>
                                                        @foreach($myAudit->new_values as  $key => $theValues)
                                                            <tr>
                                                                <td>
                                                                    {{ campoDescripcion($key)}}
                                                                </td>
                                                                <td>
                                                                    {{ campoMascara($key, $theValues, $transaccion) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
  

                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="background-color: black; color:white;">
                                    <td                     ></td>
                                    <td                     ></td>
                                    <td                     ></td>
                                    <td                     ></td>
                                    <td                     ></td>
                                </tr>

                            </table>
                        @endif
                </div>

            </div>

    </div>

</div>

@endsection

@section('js')


<script>
    

    $(() => {


    });
    
    $( document ).ready(function() {

    });
    

    function theRoute(wallet = '', grupo = 0, fechaDesde = '', fechaHasta = ''){

        let myRoute = "";

        myRoute = "{{ route('USDTResumenDiario', ['wallet' => 'wallet2' , 'fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
        
        myRoute = myRoute.replace('wallet2',wallet);
        myRoute = myRoute.replace('grupo2',grupo);
        myRoute = myRoute.replace('fechaDesde2',fechaDesde);
        myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // alert(myRoute);
        location.href = myRoute;

    }


    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0, fechaDesde = 0, fechaHasta = 0){

        if (usuario  === "") usuario  = 0;
        if (grupo  === "") grupo  = 0;
        if (wallet  === "") wallet  = 0;
        if (typeTransactions  === "") typeTransactions  = 0;
        
        fechaDesde = $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD')
        fechaHasta = $('#drCustomRanges').data('daterangepicker').endDate.format('YYYY-MM-DD')

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
        // console.log(myRoute);
        // alert(myRoute);
        location.href = myRoute;

    }


</script>
@php

    function campoDescripcion($campo = ""){
        if ($campo == "") return "";
        switch ($campo) {
            case "created":                     return "Creado";                        break;
            case "updated":                     return "Actualizado";                   break;
            case "user_id":                     return "Agente";                        break;
            case "type_transaction_id":         return "Tipo Transaccion";              break;
            case "wallet_id":                   return "Caja";                          break;
            case "group_id":                    return "Grupo";                         break;
            case "type_coin_id":                return "Tipo de Moneda";                break;
            case "exchange_rate":               return "Tasa";                          break;
            case "amount_foreign_currency":     return "Monto en Moneda extranjera";    break;
            case "amount":                      return "Monto en Dorales";              break;
            case "transaction_date":            return "Fecha Transaccion";             break;
            case "percentage":                  return "Porcentaje";                    break;
            case "amount_commission":           return "Monto Comision";                break;
            case "exonerate":                   return "Estado comision";               break;
            case "amount_total":                return "Monto Total";                   break;
            case "percentage_base":             return "Porcentaje Base";               break;
            case "exchange_rate_base":          return "Porcentaje Base";               break;
            case "amount_base":                 return "Monto Base";                    break;
            case "exonerate_base":              return "Estado comision Base";          break;
            case "amount_commission_base":      return "Monto Comision Base";           break;
            case "amount_total_base":           return "Monto Total Base";              break;
            case "status":                      return "Status";                        break;
            case "amount_commission_profit":    return "Monto ganancia Comision";       break;
            case "description":                 return "Descripcion";                   break;
            case "id":                          return "Id";                            break;
            default:                            return $campo;                          break;
        }
    }

    function campoMascara($campo = "", $valor ="", $transaccion = ""){
        if ($campo == "") return "";
        
        switch ($campo) {
            case "created":                     return "Creado";                              break;
            case "updated":                     return "Actualizado";                         break;
            case "user_id":                     return $valor;                                break;
            case "type_transaction_id":         return $transaccion->type_transaction->name;  break;
            case "wallet_id":                   return $transaccion->wallet->name;            break;
            case "group_id":                    return $transaccion->group->name;             break;
            case "type_coin_id":                return $transaccion->type_coin->name;         break;
            case "exchange_rate":               return number_format($valor,2);               break;
            case "amount_foreign_currency":     return number_format($valor,2);               break;
            case "amount":                      return number_format($valor,2);               break;
            case "transaction_date":            return date_format( date_create($valor), "d-m-Y H:i:s");   break;
            case "percentage":                  return number_format($valor,2);               break;
            case "amount_commission":           return number_format($valor,2);               break;
            case "exonerate":                   
                switch ($valor){
                    case 1: 
                        return "Descuento";
                        break;
                    case 2:
                        return "Exonerado";
                        break;
                    case 3:
                        return "Incluido";
                        brek;
                    default:
                        return "Sin estado";
                        break;
                }
                break;
            case "amount_total":                return number_format($valor,2);           break;
            case "percentage_base":             return number_format($valor,2);           break;
            case "exchange_rate_base":          return number_format($valor,2);           break;
            case "amount_base":                 return number_format($valor,2);           break;
            case "exonerate_base":              return number_format($valor,2);           break;
            case "amount_commission_base":      return number_format($valor,2);           break;
            case "amount_total_base":           return number_format($valor,2);           break;
            case "status":                      return $valor;                            break;
            case "amount_commission_profit":    return number_format($valor,2);           break;
            case "description":                 return $valor;                            break;
            case "id":                          return $valor;                            break;
            default:                            return $valor;                            break;
        }        
    }


@endphp


@endsection
