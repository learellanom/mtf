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

    private $wallet_summary, $wallet_groupsummary, $transaction_summary, $transaction_group_summary;

    public function __construct($wallet_summary, $wallet_groupsummary,$transaction_summary,$transaction_group_summary)
    {
        $this->wallet_summary = $wallet_summary;
        $this->wallet_groupsummary = $wallet_groupsummary;
        $this->transaction_group_summary = $transaction_group_summary;
        $this->transaction_summary = $transaction_summary;
    }

    public function headings(): array
    {
        $summary = $this->wallet_summary;

        //dd($summary);
        $sw = [];
        foreach($summary as $sw){
            $sw = [
              $sw->WalletName
            ];
        }
       if(empty($sw)){
        return[
             ['General'],
            [
                'Transacción',
                'Cantidad de movimientos',
                'Monto Transacción',
                '',
                '',
                'Grupo',
                'Cantidad de movimientos',
                'Monto Transacción',
            ],
         ];

       }
       else{
        return[
            [$sw],
           [
               'Transacción',
               'Cantidad de movimientos',
               'Monto Transacción',
               '',
               '',
               'Grupo',
               'Cantidad de movimientos',
               'Monto Transacción',
           ],
        ];
       }

    }





public function array(): array
{
    $summary = $this->wallet_summary ?? [];
    $group_summary = $this->wallet_groupsummary ?? [];
    $general = $this->transaction_summary ?? [];
    $general2 = $this->transaction_group_summary ?? [];

    $rows = [];

    if (empty($summary) && empty($group_summary) && !empty($general) && !empty($general2)) {
        foreach($general as $gn){
            foreach($general2 as $gn2){
                $rows[] = [
                    $gn->TypeTransaccionName,
                    $gn->cant_transactions,
                    $gn->total_amount,
                    '',
                    '',
                    $gn2->GroupName,
                    $gn2->cant_transactions,
                    $gn2->total_amount,
                ];
            }
        }
    } else {
        foreach($summary as $sm){
            foreach($group_summary as $gs){
                $rows[] = [
                    $sm->TypeTransaccionName,
                    $sm->cant_transactions,
                    $sm->total_amount,
                    '',
                    '',
                    $gs->GroupName,
                    $gs->cant_transactions,
                    $gs->total_amount,
                ];
            }


          }
        }
          //dd($rows);

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
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            $sheet->mergeCells('A1:H1')

        ],
        2 => [
            'font' => [
                'bold' => true,
                'size' => 12,
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
        'C' => [
            'font' => [
                'bold' => true,
            ],
            'numberFormat' => [
                'formatCode' => '#,##0.00',
            ],
        ],
        'H' => [
            'numberFormat' => [
                'formatCode' => '#,##0.00',
            ],
            'font' => [
                'bold' => true,
            ],
        ],




     ];


 }







}
