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
use Maatwebsite\Excel\Concerns\populateRows;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;



class DashboardestExport implements FromArray,WithHeadings, ShouldAutoSize, WithStyles
{


    public function headings(): array
    {
        return [
            'Nombre del cliente',
            'Nombre del movimiento',
            'Cantidad de movimientos',
            'Monto total',
            '    ',
            '    ',


            'Nombre de la caja',
            'Nombre del movimiento',
            'Cantidad de movimientos',
            'Monto total',
        ];

    }


 public function array(): array
 {
     $request = new Request();

     $data1 = app(statisticsController::class)->getWalletTransactionGroupSummary($request);

     $data2 = app(statisticsController::class)->getwalletTransactionSummary($request);







        $rows = [];
        foreach ($data1 as $row) {

            foreach ($data2 as $row2) {
                if ($row2->WalletName ==  $row->WalletName){
                    if ($row->TypeTransaccionName ==  $row2->TypeTransaccionName){

                        $rows[] = [
                            $row->GroupName,
                            $row->TypeTransaccionName,
                            $row->cant_transactions,
                            $row->total_amount,
                            '  ',
                            '  ',
                            $row2->WalletName,
                            $row2->TypeTransaccionName,
                            $row2->cant_transactions,
                            $row2->total_amount
                        ];
                    }
                }


            }

        }


         return $rows;

 }


 public function styles(Worksheet $sheet)
 {
     return [
        1 => [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FFFFFF'],
                'name' => 'Arial',
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 0,
                'startColor' => ['argb' => '213555'],
                'endColor' => ['argb' => '213555'],
            ],

        ],
        // Estilo de celdas con datos de texto
        3 => [
            'alignment' => [
                'wrapText' => true,
            ],

        ],

        // Estilo de celdas alternas en la tabla
        4 => [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'F4F6F6'],
            ],

        ],

        // Estilo de celdas para totales
        'J' => [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'startColor' => ['argb' => '27AE60'],
                'endColor' => ['argb' => '27AE60'],
            ],
            'numberFormat' => [
                'formatCode' => '#,##0.00',
            ],
        ],
        'D' => [
            'numberFormat' => [
                'formatCode' => '#,##0.00',
            ],
        ],




     ];


 }







}
