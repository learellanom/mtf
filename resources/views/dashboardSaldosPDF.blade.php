@php
    $myFiltroWalletB = explode(",",$filtroWallet);
    $myFiltroGroupB  = explode(",",$filtroGroup);

    // dd($myFiltroWalletB);

    $myBackGroundColor = "#5DADE2";
    
    $myStyle    = "background-color: $myBackGroundColor; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; ";    
    $myStyle2   = "text-align:center; background-color: $myBackGroundColor; color: #ffffff; font-weight: bolder; font-size: 08px; text-transform: uppercase;";

    if ($resumen == 1){
        $myDisplay = "display: none;";
    }else{
        $myDisplay = "display: block;";
    }

@endphp
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
    @page {
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        margin-bottom: 1.5cm;
    }
    h3{
        text-align: center;
        text-transform: uppercase;
    }
    /*
    html{
        font-size: 12px;
        margin: 50pt 50pt 50pt 50pt;
    }
    */
    body {
        margin-top: 2.5cm;
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 2cm;
    }            
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1.5cm;

        text-align: center;
        line-height: 1cm;
    }
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 0.5cm;

        text-align: center;
        line-height: 0.5cm;
    }
    .page-break {
        page-break-after: always;
    }       
    .pagenum:before {
        content: counter(page);
    }   
   
</style>
<body>
    <header style="font-size: 9px;">
        <img src="{{asset('./img/AdminLTELogo.png')}}" width="50" height="50" style="float: left;">
        MTF
        <span style="float: right;">{{date("d-m-Y H:i:s")}}</span>
        <hr>
    </header>
    <footer>
        <hr>            
        <span class="pagenum"></span>
    </footer>

    <main>

    <hr>

    <table  >
        <thead >
            <tr>
                <th></th>
                <th></th>
                <th></th>
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
            @if($resumen == 0)
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="{{ $myStyle2 }}">Wallet</th>
                    <th style="{{ $myStyle2 }}">Saldo Anterior</th>
                    <th style="{{ $myStyle2 }}{{$myDisplay}}">Entradas</th>
                    <th style="{{ $myStyle2 }}{{$myDisplay}}">Salidas</th>
                    <th style="{{ $myStyle2 }}">Saldo</th>
                </tr>
            @else
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2"  style="{{ $myStyle2 }}">Wallet</th>
                    <th colspan="3" style="{{ $myStyle2 }}">Saldo</th>
                </tr>
            @endif
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

                @if($resumen ==0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $summary_row->NombreWallet }}</td>
                        <td style="{{$myDisplay}}">{{ $summary_row->BalanceAnterior }}</td>
                        <td style="{{$myDisplay}}">{{ $summary_row->Creditos }}</td>
                        <td style="{{$myDisplay}}">{{ $summary_row->Debitos }}</td>
                        <td>{{ $summary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2" >{{ $summary_row->NombreWallet }}</td>
                        <td colspan="3" >{{ $summary_row->Total }}</td>
                    </tr>                
                @endif
                @php
                    $totalCreditos  += $summary_row->Creditos;
                    $totalDebitos   += $summary_row->Debitos;
                    $saldo          += $summary_row->Total;                    
                @endphp
            @endforeach
            @if($resumen ==0)
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
            @else
            <tr style="{{ $myStyle }}">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td colspan="2"  style="{{ $myStyle }}">{{ ' ' }}</td>
                <td colspan="3" style="{{ $myStyle }}">{{ $saldo }}</td>
            </tr>
            @endif

        </tbody>
    </table>
    
    <hr>
    <hr>

    <table style="float: left;">

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
            @if($resumen == 0)                              
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="{{ $myStyle }}">Grupo</th>
                    <th style="{{ $myStyle }}{{$myDisplay}}">Saldo Anterior</th>
                    <th style="{{ $myStyle }}{{$myDisplay}}">Creditos</th>
                    <th style="{{ $myStyle }}{{$myDisplay}}">Debitos</th>
                    <th style="{{ $myStyle }}">Total</th>
                </tr>
            @else
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2" style="{{ $myStyle }}">Grupo</th>
                    <th colspan="3" style="{{ $myStyle }}">Total</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @php
                $totalBalanceAnterior   = 0;
                $totalCreditos          = 0;
                $totalDebitos           = 0;
                $totalTotal             = 0;
            @endphp
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
                @php 
                    $totalBalanceAnterior   += $groupsummary_row->BalanceAnterior;
                    $totalCreditos          += $groupsummary_row->Creditos;
                    $totalDebitos           += $groupsummary_row->Debitos;
                    $totalTotal             += $groupsummary_row->Total;
                @endphp
                @if($resumen ==0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $groupsummary_row->NombreGrupo }}</td>
                        <td style="{{$myDisplay}}">{{ $groupsummary_row->BalanceAnterior }}</td>
                        <td style="{{$myDisplay}}">{{ $groupsummary_row->Creditos }}</td>
                        <td style="{{$myDisplay}}">{{ $groupsummary_row->Debitos }}</td>
                        <td>{{ $groupsummary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2" >{{ $groupsummary_row->NombreGrupo }}</td>
                        <td colspan="3" >{{ $groupsummary_row->Total }}</td>
                    </tr>
                @endif
            @endforeach
            @if($resumen == 0)
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="{{ $myStyle }}"></td>
                    <td style="{{ $myStyle }}">{{ $totalBalanceAnterior }}</td>
                    <td style="{{ $myStyle }}">{{ $totalCreditos }}</td>
                    <td style="{{ $myStyle }}">{{ $totalDebitos }}</td>
                    <td style="{{ $myStyle }}">{{ $totalTotal }}</td>                    
                </tr>            
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2" style="{{ $myStyle }}"></td>
                    <td colspan="3" style="{{ $myStyle }}">{{ $totalTotal }}</td>
                </tr>                
            @endif  
            <hr>
        </tbody>
    </table>
    </main>
</body>
</html>

