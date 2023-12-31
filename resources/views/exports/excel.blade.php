@php
    $general2_count     = count($general2);
    $general_count      = count($general);
    $total_count        = max($general2_count, $general_count);

    $summary_count      = count($summary);
    $groupsummary_count = count($groupsummary);
    $total_count2       = max($summary_count, $groupsummary_count);
@endphp
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

    <table>
        @if(!empty($general) && !empty($general2))
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">TRANSACCIONES POR CAJA</th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Entradas</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Salidas</th>
            </tr>
        </thead>
        @php
            $cantCreditos  = 0;
            $cantDebitos   = 0;

            $totalCreditos  = 0;
            $totalDebitos   = 0;
        @endphp
        <tbody>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>

                        @if(in_array($general2_row->TypeTransactionId, [1, 3, 5, 8, 11, 12, 14, 15, 16, 17]))
                            <td>{{ '0.00' }}</td>
                        @else
                            <td>{{ number_format($general2_row->total_amount, 2) ?? '0.00' }}</td>
                            @php
                                $cantCreditos ++;
                                $totalCreditos += $general2_row->total_amount;
                            @endphp
                        @endif

                        @if(in_array($general2_row->TypeTransactionId, [2, 4, 6, 7, 9, 10, 13]))
                            <td>{{ '0.00' }}</td>
                        @else
                            <td>{{ number_format($general2_row->total_amount, 2) ?? '0.00' }}</td>
                            @php
                                $cantDebitos ++;
                                $totalDebitos += $general2_row->total_amount;
                            @endphp
                        @endif
                        {{-- {{ dd($general2_row) }} --}}
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                </tr>


            @endfor
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></th>
                </tr>
            </thead>

            <tr style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ number_format($totalCreditos,2) }}</td>
                <td >{{ number_format($totalDebitos,2)}}</td>
            </tr>

            <hr>
            <hr>
            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN TRANSFERENCIA</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN TRANSFERENCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @foreach($general as $i => $general_row)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td></td>
                    @if($general_row->TypeTransactionId == 1)
                        <td>{{ $general_row->GroupName }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                    @else
                        <td>No hay información</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endforeach

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN TRANSFERENCIA</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN TRANSFERENCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @foreach($general as $i => $general_row)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td></td>
                    @if($general_row->TypeTransactionId == 2)
                        <td>{{ $general_row->GroupName }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                    @else
                        <td>No hay información</td>

                    @endif
                </tr>
            @endforeach

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EFECTIVO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td></td>
                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 3)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor
            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN EFECTIVO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                @if($i < $general2_count)
                    @php
                        $general2_row = $general2[$i];
                    @endphp
                    <td>{{ $general2_row->TypeTransaccionName }}</td>
                    <td>{{ $general2_row->cant_transactions }}</td>
                    <td>{{ $general2_row->total_amount }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                <td></td>
                <td></td>
                <td></td>
                @if($i < $general_count)
                    @php
                        $general_row = $general[$i];
                    @endphp

                    @if($general_row->TypeTransactionId == 4)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                    @endif
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN MERCANCIA</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN MERCANCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 5)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor
            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO A CAJA EFECTIVO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO A CAJA EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>
                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 6)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 7)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                @if($i < $general2_count)
                    @php
                        $general2_row = $general2[$i];
                    @endphp
                    <td>{{ $general2_row->TypeTransaccionName }}</td>
                    <td>{{ $general2_row->cant_transactions }}</td>
                    <td>{{ $general2_row->total_amount }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                <td></td>
                <td></td>
                <td></td>

                @if($i < $general_count)
                    @php
                        $general_row = $general[$i];
                    @endphp

                    @if($general_row->TypeTransactionId == 8)
                    <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                    <td>{{ $general_row->TypeTransaccionName }}</td>
                    <td>{{ $general_row->cant_transactions }}</td>
                    <td>{{ $general_row->total_amount }}</td>
                    @endif


                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">SWIFT</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">SWIFT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 9)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO MERCANCIA</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO MERCANCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 10)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>

            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO USDT</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO USDT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 11)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO A CAJA EFECTIVO</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO A CAJA EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)
                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp

                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp
                        {{-- {{ dd($general_row); }} --}}
                        @if($general_row->TypeTransactionId == 12)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO USDT</th>
                    <th colspan="3"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO USDT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count; $i++)

                <tr>
                    @if($i < $general2_count)
                        @php
                            $general2_row = $general2[$i];
                        @endphp
                        <td>{{ $general2_row->TypeTransaccionName }}</td>
                        <td>{{ $general2_row->cant_transactions }}</td>
                        <td>{{ $general2_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td></td>

                    @if($i < $general_count)
                        @php
                            $general_row = $general[$i];
                        @endphp

                        @if($general_row->TypeTransactionId == 13)
                        <td>{{ $general_row->GroupName ?? 'A cajas' }}</td>
                        <td>{{ $general_row->TypeTransaccionName }}</td>
                        <td>{{ $general_row->cant_transactions }}</td>
                        <td>{{ $general_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>


            @endfor
        </tbody>

        @else
        <!-- aqui -->
        
        <thead>
            <tr>
                <th colspan="3"></th>
                <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">
                    Saldo total: {{ number_format($balance,2)}}   |      Saldo al corte:  {{ number_format($balanceDetail,2) }}
                </th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th colspan="5" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">TRANSACCIÓNES POR CAJA</th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Entradas</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Salidas</th>
                <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo</th>
            </tr>
        </thead>
        @php
            $cantCreditos  = 0;
            $cantDebitos   = 0;

            $totalCreditos  = 0;
            $totalDebitos   = 0;
            $saldo = 0;
        @endphp
        <tbody>
            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp

                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>


                        @if(in_array($summary_row->TypeTransactionId, [1, 3, 5, 8, 11, 12, 14, 15, 16, 17]))
                            <td>{{ 0.00 }}</td>
                        @else
                            {{-- <td>{{ number_format($summary_row->total_amount, 2) ?? '0.00' }}</td> --}}
                            <td>{{ number_format($summary_row->total_amount, 2)}}</td>                            
                            @php
                                $cantCreditos ++;
                                $totalCreditos += $summary_row->total_amount;
                            @endphp
                        @endif

                        @if(in_array($summary_row->TypeTransactionId, [2, 4, 6, 7, 9, 10, 13]))
                            <td>{{ 0.00 }}</td>
                        @else
                            {{-- <td>{{ number_format($summary_row->total_amount, 2) ?? '0.00' }}</td> --}}
                            <td>{{ number_format($summary_row->total_amount, 2) }}</td>                            
                            @php
                                $cantDebitos ++;
                                $totalDebitos += $summary_row->total_amount;
                            @endphp
                        @endif

                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                </tr>

            @endfor

            <tr style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ number_format($totalCreditos,2) }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ number_format($totalDebitos,2)}}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ number_format($balance,2)}}</td>
            </tr>

            <tr style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td >{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ ' ' }}</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;"></td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Saldo al dia:</td>
                <td style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">{{ number_format($balance,2)}}</td>
            </tr>
            <hr>

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN TRANSFERENCIA</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EN TRANSFERENCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 1)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor


            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN TRANSFERENCIA</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN TRANSFERENCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>

            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 2)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EFECTIVO</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>

            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 3)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor


            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN EFECTIVO</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO EN EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>

            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 4)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO MERCANCIA</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO MERCANCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)
                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 5)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO A CAJA DE EFECTIVO
                    </th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE CREDITO A CAJA DE EFECTIVO
                    </th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>

            @for($i = 0; $i < $total_count2; $i++)
                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 6)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA CREDITO</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA CREDITO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 7)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DEBITO</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DEBITO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 8)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">SWIFT</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">SWIFT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 9)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO MERCANCIA</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO MERCANCIA</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

            <tr>
                @if($i < $summary_count)
                    @php
                        $summary_row = $summary[$i];
                    @endphp
                    <td>{{ $summary_row->TypeTransaccionName }}</td>
                    <td>{{ $summary_row->cant_transactions }}</td>
                    <td>{{ $summary_row->total_amount }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                <td></td>
                <td></td>

                @if($i < $groupsummary_count)
                    @php
                        $groupsummary_row = $groupsummary[$i];
                    @endphp

                    @if($groupsummary_row->TypeTransactionId == 10)
                    <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                    <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                    <td>{{ $groupsummary_row->cant_transactions }}</td>
                    <td>{{ $groupsummary_row->total_amount }}</td>
                    @endif


                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO USDT</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">PAGO USDT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

            <tr>
                @if($i < $summary_count)
                    @php
                        $summary_row = $summary[$i];
                    @endphp
                    <td>{{ $summary_row->TypeTransaccionName }}</td>
                    <td>{{ $summary_row->cant_transactions }}</td>
                    <td>{{ $summary_row->total_amount }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                <td></td>
                <td></td>

                @if($i < $groupsummary_count)
                    @php
                        $groupsummary_row = $groupsummary[$i];
                    @endphp

                    @if($groupsummary_row->TypeTransactionId == 11)
                    <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                    <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                    <td>{{ $groupsummary_row->cant_transactions }}</td>
                    <td>{{ $groupsummary_row->total_amount }}</td>
                    @endif


                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>


            @endfor

            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO A CAJA DE EFECTIVO</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">NOTA DE DEBITO A CAJA DE EFECTIVO</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)

            <tr>
                @if($i < $summary_count)
                    @php
                        $summary_row = $summary[$i];
                    @endphp
                    <td>{{ $summary_row->TypeTransaccionName }}</td>
                    <td>{{ $summary_row->cant_transactions }}</td>
                    <td>{{ $summary_row->total_amount }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                <td></td>
                <td></td>

                @if($i < $groupsummary_count)
                    @php
                        $groupsummary_row = $groupsummary[$i];
                    @endphp

                    @if($groupsummary_row->TypeTransactionId == 12)
                    <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                    <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                    <td>{{ $groupsummary_row->cant_transactions }}</td>
                    <td>{{ $groupsummary_row->total_amount }}</td>
                    @endif


                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>


            @endfor


            <thead>
                <tr>
                    <th colspan="3" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO USDT</th>
                    <th colspan="2"></th>
                    <th colspan="4" style="text-align:center; background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 15px; text-transform: uppercase; width:300px;">COBRO USDT</th>
                </tr>
                <tr>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto Transacción</th>
                    <th></th>
                    <th></th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Grupo</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:150px;">Cant transacción</th>
                    <th style="background-color: #001C30; color: #ffffff; font-weight: bolder; font-size: 13px; text-transform: uppercase; width:200px;">Monto transacción</th>
                </tr>
            </thead>
            @for($i = 0; $i < $total_count2; $i++)
                <tr>
                    @if($i < $summary_count)
                        @php
                            $summary_row = $summary[$i];
                        @endphp
                        <td>{{ $summary_row->TypeTransaccionName }}</td>
                        <td>{{ $summary_row->cant_transactions }}</td>
                        <td>{{ $summary_row->total_amount }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td></td>
                    <td></td>

                    @if($i < $groupsummary_count)
                        @php
                            $groupsummary_row = $groupsummary[$i];
                        @endphp

                        @if($groupsummary_row->TypeTransactionId == 13)
                        <td>{{ $groupsummary_row->GroupName ?? $groupsummary_row->TypeTransaccionName. '|' . $groupsummary_row->WalletName }}</td>
                        <td>{{ $groupsummary_row->TypeTransaccionName }}</td>
                        <td>{{ $groupsummary_row->cant_transactions }}</td>
                        <td>{{ $groupsummary_row->total_amount }}</td>
                        @endif


                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endfor
        </tbody>

        @endif

    </table>

</html>
