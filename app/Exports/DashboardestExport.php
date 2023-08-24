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
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Contracts\View\View;


class DashboardestExport implements FromView, WithColumnFormatting
{
    use Exportable;

    private $wallet_summary, $wallet_groupsummary, $transaction_summary, $transaction_group_summary, $balance, $balanceDetail;
    private $fechaDesde, $fechasHasta;

    private $ocultarresumengeneral, $ocultarresumentransaccion, $transactions;

    private $myWallet, $myTypeTransaction;
    
    public function __construct($wallet_summary, $wallet_groupsummary,$transaction_summary,$transaction_group_summary, $balance, $balanceDetail, $fechaDesde, $fechaHasta, $ocultarresumengeneral, $ocultarresumentransaccion, $transactions)
    {
        $this->wallet_summary = $wallet_summary;
        $this->wallet_groupsummary = $wallet_groupsummary;

        $this->transaction_group_summary = $transaction_group_summary;
        $this->transaction_summary = $transaction_summary;

        $this->balance = $balance;
        $this->balanceDetail = $balanceDetail;

        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;     
        
        $this->ocultarresumengeneral        = $ocultarresumengeneral;
        $this->ocultarresumentransaccion    = $ocultarresumentransaccion;
        $this->transactions                 = $transactions;
    }

    public function view(): View
    {
        
        return view('exports.excel2', [
            'general'                   => $this->transaction_group_summary,
            'general2'                  => $this->transaction_summary,
            'summary'                   => $this->wallet_summary,
            'groupsummary'              => $this->wallet_groupsummary,
            'balance'                   => $this->balance,
            'balanceDetail'             => $this->balanceDetail,
            'fechaDesde'                => $this->fechaDesde,
            'fechaHasta'                => $this->fechaHasta,
            'ocultarresumengeneral'     => $this->ocultarresumengeneral,
            'ocultarresumentransaccion' => $this->ocultarresumentransaccion,
            'transactions'              => $this->transactions,
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
