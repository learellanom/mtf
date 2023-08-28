<?php

namespace App\Exports;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\statisticsController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\populateRows;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;


class DashboardSaldosExport implements FromView, WithColumnFormatting
{
    use Exportable;

    private $wallet_summary, $group_summary;
    private $fechaDesde, $fechasHasta;
    private $filtroWallet, $filtroGroup; 
    private $filtroWalletB, $filtroGroupB;
    private $resumen;

    public function __construct($wallet_summary, $group_summary, $fechaDesde, $fechaHasta, $myFiltroWallet, $myFiltroGroup, $myFiltroWalletB, $myFiltroGroupB, $myResumen)
    {
        $this->wallet_summary   = $wallet_summary;
        $this->group_summary    = $group_summary;


        $this->fechaDesde       = $fechaDesde;
        $this->fechaHasta       = $fechaHasta;        

        $this->filtroWallet     = $myFiltroWallet;
        $this->filtroGroup      = $myFiltroGroup;   
        
        $this->filtroWalletB     = $myFiltroWalletB;
        $this->filtroGroupB      = $myFiltroGroupB;            

        $this->resumen          = $myResumen;

    }

    public function view(): View
    {
        return view('exports.excelSaldos', [
            'wallet_summary'    => $this->wallet_summary,
            'group_summary'     => $this->group_summary,
            'fechaDesde'        => $this->fechaDesde,
            'fechaHasta'        => $this->fechaHasta,
            'filtroWallet'      => $this->filtroWallet,
            'filtroGroup'       => $this->filtroGroup,
            'filtroWalletB'     => $this->filtroWalletB,
            'filtroGroupB'      => $this->filtroGroupB,
            'resumen'           => $this->resumen,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

}

