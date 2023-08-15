@php
    $myFiltroWalletB = explode(",",$filtroWallet);
    $myFiltroGroupB  = explode(",",$filtroGroup);

    // dd($myFiltroWalletB);
    $myStyle = "background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;";

    $myStyle2 = "text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;";

    $myStyle = "background-color: #5DADE2; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;";
    $myStyle2 = "text-align:center; background-color: #5DADE2; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;";


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
                <th colspan="5" style="{{ $myStyle2 }}">
                    Resumen por Wallet
                </th>
            </tr>
            <tr>
                @if($fechaDesde != "2001-01-01")
                    <th colspan="3"></th>
                    <th colspan="5" style="{{ $myStyle2 }}">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>

                @else
                    <th colspan="3"></th>
                    <th colspan="5" style="{{ $myStyle2 }}">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>
                @endif
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="{{ $myStyle }}">Wallet</th>
                <th style="{{ $myStyle }}">Saldo Anterior</th>
                <th style="{{ $myStyle }}">Entradas</th>
                <th style="{{ $myStyle }}">Salidas</th>
                <th style="{{ $myStyle }}">Saldo</th>
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

            <tr style="{{ $myStyle }}">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td style="{{ $myStyle }}">{{ ' ' }}</td>
                <td style="{{ $myStyle }}">{{ ' ' }}</td>
                <td style="{{ $myStyle }}">{{ $totalCreditos }}</td>
                <td style="{{ $myStyle }}">{{ $totalDebitos }}</td>
                <td style="{{ $myStyle }}">{{ $saldo }}</td>
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
                    <th colspan="5" style="{{ $myStyle2 }}">
                        Resumen por Grupo
                    </th>
                </tr>   
                <tr>
                    @if($fechaDesde != "2001-01-01")
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="5" style="{{ $myStyle2 }}">
                            Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                        </th>

                    @else
                        <th></th>
                        <th></th>
                        <th></th>                                                
                        <th colspan="5" style="{{ $myStyle2 }}">
                            a la Fecha:  {{ date('d-m-Y') }}
                        </th>

                    @endif    
                </tr>                                 
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="{{ $myStyle }}">Grupo</th>
                    <th style="{{ $myStyle }}">Saldo Anterior</th>
                    <th style="{{ $myStyle }}">Creditos</th>
                    <th style="{{ $myStyle }}">Debitos</th>
                    <th style="{{ $myStyle }}">Total</th>
                </tr>
            </thead>

            @foreach($group_summary as $groupsummary_row)
                    @php
                        $indFiltro = 1;
                        foreach($myFiltroGroupB as $value){
                            if ($value == $groupsummary_row->IdGrupo){
                                $indFiltro = 0;
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
                <td style="{{ $myStyle }}"></td>
                <td style="{{ $myStyle }}"></td>
                <td style="{{ $myStyle }}"></td>
                <td style="{{ $myStyle }}"></td>
                <td style="{{ $myStyle }}"></td>                    
            </tr>              
            <hr>

        </tbody>

    </table>

</html>
