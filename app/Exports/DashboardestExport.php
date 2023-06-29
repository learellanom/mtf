<?php

namespace App\Exports;

use App\Http\Controllers\HomeController;
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
    use Exportable;

    private $wallet_summary, $wallet_groupsummary;

    public function __construct($wallet_summary, $wallet_groupsummary)
    {
        $this->wallet_summary = $wallet_summary; // asignas el valor inyectado a la propiedad
        $this->wallet_groupsummary = $wallet_groupsummary;
    }

    public function headings(): array
    {
        return [
            'Transacción',
            'Cantidad de movimientos',
            'Monto Transacción',
            '',
            '',
            'Grupo',
            'Cantidad de movimientos',
            'Monto Transacción',
        ];

    }


/*  public function array(): array
 {

     $summary = $this->wallet_summary;
     $group_summary = $this->wallet_groupsummary;
     //dd($summary);

        $rows = [];
        foreach ($group_summary as $row) {

            $rows = [
                $row->TypeTransaccionName,
                $row->cant_transactions,
                $row->total_amount,
                '  ',
                '  ',

            ];

        }
        $rows2 = [];
        foreach ($summary as $row2) {

                       $rows2 = [

                           $row2->WalletName,
                           $row2->TypeTransaccionName,
                           $row2->cant_transactions,
                           $row2->total_amount
                       ];

           }

         //dd($rows);
         $print = array_merge($rows, $rows2);


         return $print;

 } */


/*  public function array(): array
{
    $summary = $this->wallet_summary;
    $group_summary = $this->wallet_groupsummary;

    $rows = [];
    foreach ($group_summary as $row) {
        $rows[] = [
            $row->TypeTransaccionName,
            $row->cant_transactions,
            $row->total_amount,
            '',
            '',
        ];
    }

    foreach ($summary as $row) {
        $rows[] = [
            $row->WalletName,
            $row->TypeTransaccionName,
            $row->cant_transactions,
            $row->total_amount,
        ];
    }
      //dd($rows);
     return $rows;
} */

public function array(): array
{
    $summary = $this->wallet_summary ?? [];
    $group_summary = $this->wallet_groupsummary ?? [];

    $rows = [];


    $maxRowCount = max(count($group_summary), count($summary));
    for($i=0; $i<$maxRowCount; $i++) {
        $rowData = [
            '', '', '',
            '', '',
            '', '', '',
        ];
        if(isset($summary[$i])) {
            $rowData[0] = $summary[$i]->TypeTransaccionName ?? '';
            $rowData[1] = $summary[$i]->cant_transactions ?? '';
            $rowData[2] = $summary[$i]->total_amount ?? '';
        }
        if(isset($group_summary[$i])) {
            $rowData[5] = $group_summary[$i]->TypeTransaccionName ?? '';
            $rowData[6] = $group_summary[$i]->cant_transactions ?? '';
            $rowData[7] = $group_summary[$i]->total_amount ?? '';
        }


        $rows[] = $rowData;
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
