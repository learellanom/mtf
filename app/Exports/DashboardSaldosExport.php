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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class DashboardestExport implements FromView
{
    use Exportable;

    private $wallet_summary, $group_summary;
    private $fechaDesde, $fechasHasta;

    public function __construct($wallet_summary, $group_summary, $fechaDesde, $fechaHasta)
    {
        $this->wallet_summary   = $wallet_summary;
        $this->group_summary    = $group_summary;

        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;        
    }

    public function view(): View
    {
        return view('exports.excel2', [
            'general'       => $this->transaction_group_summary,
            'general2'      => $this->transaction_summary,
            'summary'       => $this->wallet_summary,
            'groupsummary'  => $this->wallet_groupsummary,
            'balance'       => $this->balance,
            'balanceDetail' => $this->balanceDetail,
            'fechaDesde'    => $this->fechaDesde,
            'fechaHasta'    => $this->fechaHasta,                        
        ]);
    }

}
