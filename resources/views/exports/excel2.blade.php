@php

    $myClass = new app\Http\Controllers\statisticsController;

    $general2_count     = count($general2); // transaction_sumamry
    $general_count      = count($general);  // transaction_group_summary
    $total_count        = max($general2_count, $general_count);

    $summary_count      = count($summary);
    $groupsummary_count = count($groupsummary);
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

        @if(!empty($general) && !empty($general2))


            {{-- Estadisticas generales (todas las wallets y transacciones) --}}

            <thead>
              
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">TRANSACCIONES POR CAJAS</th>
                    <th colspan="2"></th>
                </tr>

                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th colspan="3"></th>
                        <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>
                        
                    @else
                        <th colspan="3"></th>
                        <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
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
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Entradas</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Salidas</th>
                </tr>
            </thead>
            @php
                $cantCreditos  = 0;
                $cantDebitos   = 0;

                $totalCreditos  = 0;
                $totalDebitos   = 0;
            @endphp
            <tbody>

                {{-- Transaction summary --}}

                @foreach($general2 as $general2_row)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>

                        @php
                                $myTransaction  = $myClass->getCreditDebitWallet($general2_row->TypeTransactionId);
                        @endphp

                        @switch($myTransaction)
                            @case('Credito')
                                <td>{{ $general2_row->total_amount ?? '0.00' }}</td>
                                <td>{{ '0.00' }}</td>
                                @php
                                    $cantCreditos ++;
                                    $totalCreditos += $general2_row->total_amount;
                                @endphp                                
                                @break
                            @case('Debito')
                                <td>{{ '0.00' }}</td>
                                <td>{{ $general2_row->total_amount ?? '0.00' }}</td>
                                @php
                                    $cantDebitos ++;
                                    $totalDebitos += $general2_row->total_amount;
                                @endphp                                
                                @break
                            @default
                                @break
                        @endswitch



                        {{-- {{ dd($general2_row) }} --}}

                        <td></td>
                        <td></td>
                    </tr>
                @endforeach

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalCreditos }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalDebitos }}</td>
                </tr>

                {{-- Transaccion --}}

                @foreach($general2 as $general2_row)
                    <hr>
                    
                    <thead>
                        <tr>
                            <th colspan="3"></th>
                            <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">{{ $general2_row->TypeTransaccionName }}</th>
                        </tr>
                        <tr>
                            @if($fechaDesde != "2001-01-01")
                                <th colspan="3"></th>
                                <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                                    Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                                </th>
                                
                            @else
                                <th colspan="3"></th>
                                <th colspan="4" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
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
                            <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                        </tr>
                    </thead>

                    {{-- Transaction Group Summary --}}
                    @php
                        $cantidad   = 0;
                        $total      = 0;
                    @endphp     
                    @foreach($general as $i => $general_row)

                            @if($general_row->TypeTransactionId == $general2_row->TypeTransactionId)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                                        
                                    <td>{{ $general_row->GroupName }}</td>
                                    <td>{{ $general_row->TypeTransaccionName }}</td>
                                    <td>{{ $general_row->cant_transactions }}</td>
                                    <td>{{ $general_row->total_amount }}</td>
                                </tr>        
                                @php
                                    $cantidad   += $general_row->cant_transactions;
                                    $total      += $general_row->total_amount;
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
                        <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $total }}</th>
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
                    <th style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;"></th>
                    <th colspan="2" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        Saldo al corte:  {{ number_format($balanceDetail,2) }}
                    </th>

                    <th colspan="2"></th>
                </tr>
                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th colspan="3"></th>
                        <th colspan="5" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>
                        <th colspan="2"></th>
                    @else
                        <th colspan="3"></th>
                        <th colspan="5" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            a la Fecha:  {{ date('d-m-Y') }}
                        </th>
                        <th colspan="2"></th>              
                    @endif
                </tr>            
                <tr>
                    <th colspan="3"></th>
                    <th colspan="5" style="text-align:center; background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">TRANSACCIÓNES POR CAJA</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Entradas</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Salidas</th>
                    <th style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo</th>
                </tr>
            </thead>
            @php
                $cantCreditos   = 0;
                $cantDebitos    = 0;

                $totalCreditos  = 0;
                $totalDebitos   = 0;
                $saldo          = 0;
            @endphp
            <tbody>
                @foreach($summary as $summary_row)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>

                        @php
                            $myTransaction  = $myClass->getCreditDebitWallet($summary_row->TypeTransactionId);
                        @endphp

                        @switch($myTransaction)
                            @case('Credito')
                                <td>{{ $summary_row->total_amount}}</td>
                                @php
                                    $cantCreditos ++;
                                    $totalCreditos += $summary_row->total_amount;
                                @endphp                        
                                <td>{{ 0.00 }}</td>                        
                                @break
                            @case('Debito')
                                <td>{{ 0.00 }}</td>  
                                <td>{{ $summary_row->total_amount }}</td>                            
                                @php
                                    $cantDebitos ++;
                                    $totalDebitos += $summary_row->total_amount;
                                @endphp                                                  
                                @break                            
                            @default
                                @break
                        @endswitch

                    </tr>
                @endforeach

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalCreditos }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalDebitos }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $balance }}</td>
                </tr>

                <tr style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td >{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo al dia:</td>
                    <td style="background-color: {{$myBackGroundColor}}; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $balance}}</td>
                <hr>
                <hr>

                <!-- transaccion por grupos -->

                {{-- dd($summary) --}}
                {{-- dd($groupsummary) --}}
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
                @foreach($summary as $summary_row)
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

                    @foreach($groupsummary as $groupsummary_row)

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
