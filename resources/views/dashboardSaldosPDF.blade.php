@php
    $myFiltroWallet = explode(",",$filtroWallet);
    $myFiltroGroup  = explode(",",$filtroGroup);

    $myFiltroWalletB = explode(",",$filtroWalletB);
    $myFiltroGroupB  = explode(",",$filtroGroupB);

    // dd($myFiltroGroupB);


    if ($resumen == 1){
        $myFont     = "font-size: 10px;";
        $myWidth    = "width: 330px;";
    }else{
        $myFont     = "font-size: 8px;";
        $myWidth    = "";
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
        /* size: letter landscape; */
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
   .myFontSize {
        font-size: 8px;
   }
   .myBackGround {
        background-color: #5DADE2; color: white;
   }
   .myBackGroundB {
        background-color: black; color: white;
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

    {{-- Resumen por Wallet --}}

    <table style="float: left; {{$myFont}} {{$myWidth}}">
        <thead>
            <tr class="myBackGround">
                <th colspan="5">
                    Resumen por Wallet
                </th>
            </tr>
            <tr class="myBackGround">
                @if($fechaDesde != "2001-01-01")
                    <th colspan="5">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>
                @else
                    <th colspan="5">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>
                @endif
            </tr>
            @if($resumen == 0)
                <tr class="myBackGround">
                    <th>Wallet</th>
                    <th>Saldo Anterior</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Saldo</th>
                </tr>
            @else
                <tr>

                    <th colspan="2">Wallet</th>
                    <th colspan="3">Saldo</th>
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
                    foreach($myFiltroWallet as $value){
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

                        <td>{{ $summary_row->NombreWallet }}</td>
                        <td style="text-align: right;">{{ $summary_row->BalanceAnterior }}</td>
                        <td style="text-align: right;">{{ $summary_row->Creditos }}</td>
                        <td style="text-align: right;">{{ $summary_row->Debitos }}</td>
                        <td style="text-align: right;">{{ $summary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" >{{ $summary_row->NombreWallet }}</td>
                        <td colspan="3" style="text-align: right;">{{ number_format($summary_row->Total,2) }}</td>
                    </tr>                
                @endif
                @php
                    $totalCreditos  += $summary_row->Creditos;
                    $totalDebitos   += $summary_row->Debitos;
                    $saldo          += $summary_row->Total;
                @endphp
            @endforeach
        </tbody>
        <tfoot class="myBackGround">
            @if($resumen ==0)
                <tr>
                    <td>Total</td>
                    <td>{{ ' ' }}</td>
                    <td>{{ number_format($totalCreditos,2) }}</td>
                    <td>{{ number_format($totalDebitos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($saldo,2) }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="3" style="text-align: right;">{{ number_format($saldo,2) }}</td>
                </tr>
            @endif
        </tfoot>
    </table>



    

    {{-- Resumen por Wallet --}}

    <table style="float: right; {{$myFont}} {{$myWidth}}">
        <thead>
            <tr class="myBackGroundB">
                <th colspan="5">
                    Resumen por Wallet B
                </th>
            </tr>
            <tr class="myBackGroundB">
                @if($fechaDesde != "2001-01-01")
                    <th colspan="5">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>
                @else
                    <th colspan="5">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>
                @endif
            </tr>
            @if($resumen == 0)
                <tr class="myBackGroundB">
                    <th>Wallet</th>
                    <th>Saldo Anterior</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Saldo</th>
                </tr>
            @else
                <tr class="myBackGroundB">

                    <th colspan="2">Wallet</th>
                    <th colspan="3">Saldo</th>
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

                        <td>{{ $summary_row->NombreWallet }}</td>
                        <td style="text-align: right;">{{ $summary_row->BalanceAnterior }}</td>
                        <td style="text-align: right;">{{ $summary_row->Creditos }}</td>
                        <td style="text-align: right;">{{ $summary_row->Debitos }}</td>
                        <td style="text-align: right;">{{ $summary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" >{{ $summary_row->NombreWallet }}</td>
                        <td colspan="3" style="text-align: right;">{{ number_format($summary_row->Total,2) }}</td>
                    </tr>                
                @endif
                @php
                    $totalCreditos  += $summary_row->Creditos;
                    $totalDebitos   += $summary_row->Debitos;
                    $saldo          += $summary_row->Total;
                @endphp
            @endforeach
        </tbody>
        <tfoot class="myBackGroundB">
            @if($resumen ==0)
                <tr>
                    <td>Total</td>
                    <td>{{ ' ' }}</td>
                    <td>{{ number_format($totalCreditos,2) }}</td>
                    <td>{{ number_format($totalDebitos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($saldo,2) }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="3" style="text-align: right;">{{ number_format($saldo,2) }}</td>
                </tr>
            @endif
        </tfoot>
    </table>




    <div class="page-break"></div>



    {{-- 
        

            Resumen por grupo 
        

    --}}

    <table style="float: left;  {{$myFont}} {{$myWidth}}">

        <!-- transaccion por grupos -->
        {{-- dd($summary) --}}
        {{-- dd($groupsummary) --}}
            
        <thead class="myBackGround">
            <tr>
                <th colspan="5">
                    Resumen por Grupo
                </th>
            </tr>   
            <tr>
                @if($fechaDesde != "2001-01-01")
                    <th colspan="5">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>

                @else                                              
                    <th colspan="5">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>

                @endif    
            </tr>   
            @if($resumen == 0)                              
                <tr>
                    <th>Grupo</th>
                    <th>Saldo Anterior</th>
                    <th>Creditos</th>
                    <th>Debitos</th>
                    <th>Total</th>
                </tr>
            @else
                <tr>
                    <th colspan="2">Grupo</th>
                    <th colspan="3">Total</th>
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
                    foreach($myFiltroGroup as $value){
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
                        <td>{{ $groupsummary_row->NombreGrupo }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->BalanceAnterior }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Creditos }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Debitos }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" >{{ $groupsummary_row->NombreGrupo }}</td>
                        
                        <td colspan="3" style="text-align: right;">{{ number_format($groupsummary_row->Total,2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot class="myBackGround">
            @if($resumen == 0)
                <tr>
                    <td>Total</td>
                    <td style="text-align: right;">{{ number_format($totalBalanceAnterior,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalCreditos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalDebitos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalTotal,2) }}</td>                    
                </tr>            
            @else
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="3" style="text-align: right;">{{ number_format($totalTotal,2) }}</td>
                </tr>                
            @endif    
        </tfoot>      
    </table>





    
                



    {{-- 
        

            Resumen por grupo 
        

    --}}

    <table style="float: right;  {{$myFont}} {{$myWidth}}">

        <!-- transaccion por grupos -->
        {{-- dd($summary) --}}
        {{-- dd($groupsummary) --}}
            
        <thead class="myBackGroundB">
            <tr>
                <th colspan="5">
                    Resumen por Grupo B
                </th>
            </tr>   
            <tr>
                @if($fechaDesde != "2001-01-01")
                    <th colspan="5">
                        Fecha desde: {{ $fechaDesde }}   |      Fecha Hasta:  {{ $fechaHasta }}
                    </th>

                @else                                              
                    <th colspan="5">
                        a la Fecha:  {{ date('d-m-Y') }}
                    </th>

                @endif    
            </tr>   
            @if($resumen == 0)                              
                <tr>
                    <th>Grupo</th>
                    <th>Saldo Anterior</th>
                    <th>Creditos</th>
                    <th>Debitos</th>
                    <th>Total</th>
                </tr>
            @else
                <tr>
                    <th colspan="2">Grupo</th>
                    <th colspan="3">Total</th>
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
                        <td>{{ $groupsummary_row->NombreGrupo }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->BalanceAnterior }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Creditos }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Debitos }}</td>
                        <td style="text-align: right;">{{ $groupsummary_row->Total }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" >{{ $groupsummary_row->NombreGrupo }}</td>
                        
                        <td colspan="3" style="text-align: right;">{{ number_format($groupsummary_row->Total,2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot class="myBackGroundB">
            @if($resumen == 0)
                <tr>
                    <td>Total</td>
                    <td style="text-align: right;">{{ number_format($totalBalanceAnterior,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalCreditos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalDebitos,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalTotal,2) }}</td>                    
                </tr>            
            @else
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="3" style="text-align: right;">{{ number_format($totalTotal,2) }}</td>
                </tr>                
            @endif    
        </tfoot>      
    </table>

    </main>
</body>
</html>

