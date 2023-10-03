@php

    $myClass = new app\Http\Controllers\statisticsController;

    $general2_count     = count($transaction_summary);                     // transaction_sumamry
    $general_count      = count($transaction_group_summary);    // transaction_group_summary
    $total_count        = max($general2_count, $general_count); //

    $summary_count      = count($wallet_summary);
    $groupsummary_count = count($wallet_groupsummary);
    $total_count2       = max($summary_count, $groupsummary_count);
    
    $myBackGroundColor = "#001C30";
    $myBackGroundColor = "#5DADE2";

@endphp
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <hr>

    <table>

        @if(!empty($transaction_group_summary) && !empty($transaction_summary))


            {{-- Estadisticas generales Comisiones (todas las wallets y transacciones) --}}

            <thead>
              
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COMISIONES</th>
                    
                </tr>

                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th colspan="3"></th>
                        <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>
                        
                    @else
                        <th colspan="3"></th>
                        <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            a la Fecha:  {{ date('d-m-Y') }}
                        </th>
           
                    @endif
                </tr>    

                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Base</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Exchange</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Ganancia</th>
                </tr>
            </thead>
            @php
                $cantCreditos  = 0;
                $cantDebitos   = 0;

                $totalCreditos  = 0;
                $totalDebitos   = 0;
            @endphp
            <tbody>

                {{-- Transaction wallet_summary --}}

                @foreach($transaction_summary as $general2_row)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_commission ?? '0.00' }}</td>
                        <td>{{ $general2_row->total_amount_commission_base ?? '0.00' }}</td>
                        <td>{{ $general2_row->exchange_profit ?? '0.00' }}</td>
                        <td>{{ $general2_row->total_commission_profit ?? '0.00' }}</td>

                        @php
                                
                        @endphp

                        {{-- {{ dd($general2_row) }} --}}

                    </tr>
                @endforeach

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                </tr>

                {{-- Transaccion --}}

                @foreach($transaction_summary as $general2_row)
                    <hr>
                    
                    <thead>
                        <tr>
                            <th colspan="3"></th>
                            <th colspan="7" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">{{ $general2_row->TypeTransaccionName }}</th>
                        </tr>
                        <tr>
                            @if($fechaDesde != "2001-01-01")
                                <th colspan="3"></th>
                                <th colspan="7" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                                    Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                                </th>
                                
                            @else
                                <th colspan="3"></th>
                                <th colspan="7" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                                    a la Fecha:  {{ date('d-m-Y') }}
                                </th>
                
                            @endif
                        </tr> 


                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Comision</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Comision Base</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Comision Exchange</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto COmision Ganancia</th>
                        </tr>
                    </thead>

                    {{-- Transaction Group Summary --}}
                    @php
                        $cantidad   = 0;
                        $total      = 0;
                        $total_commission =0;
                        $total_amount_commission_base = 0;
                        $exchange_profit = 0;
                        $total_commission_profit = 0;
                    @endphp     
                    @foreach($transaction_group_summary as $i => $general_row)

                            @if($general_row->TypeTransactionId == $general2_row->TypeTransactionId)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                                        
                                    <td>{{ $general_row->GroupName }}</td>
                                    <td>{{ $general_row->TypeTransaccionName }}</td>
                                    <td>{{ $general_row->cant_transactions }}</td>
                                    <td>{{ $general_row->total_commission }}</td>
                                    <td>{{ $general_row->total_amount_commission_base}}</td>
                                    <td>{{ $general_row->exchange_profit }}</td>
                                    <td>{{ $general_row->total_commission_profit }}</td>
                                </tr>        
                                @php
                                    $cantidad                       += $general_row->cant_transactions;
                                    $total                          += $general_row->total_amount;
                                    $total_commission               += $general_row->total_commission;
                                    $total_amount_commission_base   += $general_row->total_amount_commission_base;
                                    $exchange_profit                += $general_row->exchange_profit;
                                    $total_commission_profit        += $general_row->total_commission_profit ;                                    
                                @endphp                        
                            @endif

                    @endforeach

                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">{{ $cantidad }}</th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_commission }}</th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_amount_commission_base }}</th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $exchange_profit }}</th>
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_commission_profit }}</th>                        
                    </tr>

                @endforeach

                


                {{-- Transaction Group Summary end --}}



            </tbody>

        @else
        
            <!-- Estadisticas por Wallet  -->
            
            <thead>
                <tr>
                    <th ></th>
                    <th ></th>
                    <th ></th>
                    <th colspan="2" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        Saldo total: {{ number_format($balance,2)}}
                    </th>
                    <th colspan="2" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;"></th>
                    <th colspan="2" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        Saldo al corte:  {{ number_format($balanceDetail,2) }}
                    </th>

                    
                </tr>
                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th colspan="3"></th>
                        <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>

                    @else
                        <th colspan="3"></th>
                        <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            a la Fecha:  {{ date('d-m-Y') }}
                        </th>

                    @endif
                </tr>            
                <tr>
                    <th colspan="3"></th>
                    <th colspan="6" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COMISIONES POR CAJA</th>
                    
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Base</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Exchange</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Comision Ganancia</th>
                </tr>
            </thead>
            @php
                $cantCreditos   = 0;
                $cantDebitos    = 0;

                $totalCreditos  = 0;
                $totalDebitos   = 0;
                $saldo          = 0;

                $total_commission               = 0;
                $total_amount_commission_base   = 0;
                $exchange_profit                = 0;
                $total_commission_profit        = 0;


            @endphp
            <tbody>
                @foreach($wallet_summary as $summary_row)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_commission }}</td>
                        <td>{{ $summary_row->total_amount_commission_base }}</td>
                        <td>{{ $summary_row->exchange_profit }}</td>
                        <td>{{ $summary_row->total_commission_profit }}</td>

                        @php
                            $total_commission               += $summary_row->total_commission ;
                            $total_amount_commission_base   += $summary_row->total_amount_commission_base;
                            $exchange_profit                += $summary_row->exchange_profit;
                            $total_commission_profit        += $summary_row->total_commission_profit;
                        @endphp


                    </tr>
                @endforeach

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>                    
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_commission  }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_amount_commission_base  }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $exchange_profit  }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total_commission_profit }}</td>
                </tr>

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo al dia:</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $balance}}</td>
                <hr>
                <hr>

                <!-- transaccion por grupos -->

                {{-- dd($wallet_summary) --}}
                {{-- dd($wallet_groupsummary) --}}
                <style>
                    .myStyleHeader {
                        text-align:center; 
                        background-color: #001C30; 
                        color: #ffffff; 
                        font-weight: bolder; 
                        font-size: 15px; 
                        text-transform: uppercase; 
                        width:300px;                
                    }

                    .myStyleRow {
                        background-color: #001C30; 
                        color: #ffffff; 
                        font-weight: bolder; 
                        font-size: 13px; 
                        text-transform: uppercase; 
                        width:200px;
                    }
                </style>
                @foreach($wallet_summary as $summary_row)
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">{{ $summary_row->WalletName}}</th>
                        </tr>   
                        <tr>
                            @if($fechaDesde != "2001-01-01")
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                                    Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                                </th>

                            @else
                                <th></th>
                                <th></th>
                                <th></th>                                                
                                <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                                    a la Fecha:  {{ date('d-m-Y') }}
                                </th>

                            @endif    
                        </tr>                                 
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">{{ $summary_row->TypeTransaccionName}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                        </tr>
                    </thead>

                    @foreach($wallet_groupsummary as $groupsummary_row)

                        @if($groupsummary_row->TypeTransactionId == $summary_row->TypeTransactionId)

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $groupsummary_row->GroupName }}</td>
                                <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                                <td>{{ $groupsummary_row->cant_transactions }}</td>
                                <td>{{ $groupsummary_row->total_amount }}</td>
                            </tr>

                        @endif

                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                        <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                        <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $summary_row->cant_transactions }}</td>
                        <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $summary_row->total_amount }}</td>
                    </tr>              
                    <hr>

                @endforeach

            </tbody>

        @endif

    </table>

</html>
