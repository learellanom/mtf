@php
    $myFiltroWalletB = explode(",",$filtroWallet);
    $myFiltroGroupB  = explode(",",$filtroGroup);

    // dd($myFiltroWalletB);

@endphp
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <hr>

    <table>

        <thead>
            <tr>
                <th ></th>
                <th ></th>
                <th ></th>
                <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                    Resumen por Wallet
                </th>
            </tr>
            <tr>
                @if($fechaDesde != "2001-01-01")
                    <th colspan="3"></th>
                    <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>

                @else
                    <th colspan="3"></th>
                    <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>
                @endif
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Wallet</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Saldo Anterior</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Entradas</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Salidas</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo</th>
            </tr>
        </thead>
        @php
            $totalCreditos  = 0;
            $totalDebitos   = 0;
            $saldo          = 0;
        @endphp
        <tbody>
            @foreach($wallet_summary as $summary_row)

                @php
                    $indFiltro = 0;
                    foreach($myFiltroWalletB as $value){
                        if ($value == $summary_row->IdWallet){
                            $indFiltro = 1;
                        }
                    }
                @endphp
                @if($indFiltro ==1)
                    @continue
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $summary_row->NombreWallet }}</td>
                    <td>{{ $summary_row->BalanceAnterior }}</td>
                    <td>{{ $summary_row->Creditos }}</td>
                    <td>{{ $summary_row->Debitos }}</td>
                    <td>{{ $summary_row->Total }}</td>
                </tr>
                @php
                    $totalCreditos  += $summary_row->Creditos;
                    $totalDebitos   += $summary_row->Debitos;
                    $saldo          += $summary_row->Total;                    
                @endphp
            @endforeach

            <tr style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalCreditos }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $totalDebitos }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ $saldo }}</td>
            </tr>

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
            
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                        Resumen por Grupo
                    </th>
                </tr>   
                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>

                    @else
                        <th></th>
                        <th></th>
                        <th></th>                                                
                        <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                            a la Fecha:  {{ date('d-m-Y') }}
                        </th>

                    @endif    
                </tr>                                 
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo Anterior</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Creditos</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Debitos</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Total</th>
                </tr>
            </thead>

            @foreach($group_summary as $groupsummary_row)
                    @php
                        $indFiltro = 0;
                        foreach($myFiltroGroupB as $value){
                            if ($value == $groupsummary_row->IdGrupo){
                                $indFiltro = 1;
                            }
                        }
                    @endphp
                    @if($indFiltro ==1)
                        @continue
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $groupsummary_row->NombreGrupo }}</td>
                        <td>{{ $groupsummary_row->BalanceAnterior }}</td>
                        <td>{{ $groupsummary_row->Creditos }}</td>
                        <td>{{ $groupsummary_row->Debitos }}</td>
                        <td>{{ $groupsummary_row->Total }}</td>
                    </tr>

            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>                    
            </tr>              
            <hr>

        </tbody>

    </table>

</html>
