<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Http\Controllers\statisticsController;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DashboardestExport implements FromArray,WithHeadings
{


    public function headings(): array
    {
        return [
            'Nombre de la caja',
            'Nombre del movimiento',
            'Cantidad de movimientos',
            'Monto total',
        ];
    }


    public function array(): array
    {
        $data = app(StatisticsController::class)->getBalanceWallet();
        $request = new Request();
        $data2 = app(statisticsController::class)->getwalletTransactionSummary($request);
        //dd($data2);
        $rows = [];

        foreach ($data as $row) {
            $rows[] = [
                $row->IdWallet,
                $row->NombreWallet,
                $row->Creditos,
                $row->Debitos,
                $row->Comision,
                $row->ComisionBase,
                $row->Total,
                $row->ComisionGanancia,
            ];
        }
        $rows2 = [];
        foreach ($data2 as $row) {
            $rows[] = [
                $row->WalletName,
                $row->TypeTransaccionName,
                $row->cant_transactions,
                $row->total_amount,
            ];
        }

        return $rows;
        return $rows2;
    }

}
