<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Http\Controllers\statisticsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Exports\DashboardestExport;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
{

    private $myCredits   = "1,3,5,7,9,11,12";
    private $myDebits    = "2,4,6,8,10";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {

        $wallet = app(statisticsController::class)->getBalanceWallet();

        //$this->getwalletTransactionSummary($request);
        // $Transacciones2         = $this->getWalletTransactionGroupSummary($request);

        return view('home', compact('wallet'));
    }

    public function graphics(request $request)
    {

        $wallet_summary = app(statisticsController::class)->getwalletTransactionSummary($request);

        $request2 = clone $request;
        $request2->transaction = 0;
        $wallet_summary = app(statisticsController::class)->getwalletTransactionSummary($request2);

        $wallet_groupsummary = app(statisticsController::class)->getWalletTransactionGroupSummary($request);

        $wallet = app(statisticsController::class)->getWallet();

        $typeTransactions = app(statisticsController::class)->getTypeTransactions();



        /* MANTENER VALOR BUSCADO EN EL URL */
       $myWalletDesde   = 0;
       $myWalletHasta   = 9999;
       $myWallet        = 0;
       if ($request->wallet){
           $myWalletDesde   = $request->wallet;
           $myWalletHasta   = $request->wallet;
           $myWallet        = $request->wallet;
       }
       $myTypeTransaction      = 0;
       $myTypeTransactionDesde = 0;
       $myTypeTransactionHasta = 9999;
       if ($request->transaction) {
           $myTypeTransaction      = $request->transaction;
           $myTypeTransactionDesde = $request->transaction;
           $myTypeTransactionHasta = $request->transaction;

       }

       $myFechaDesde = "2001-01-01";
       $myFechaHasta = "9999-12-31";

       $myFechaDesde2 = "2001-01-01";
       $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";
        /* MANTENER VALOR BUSCADO EN EL URL */
        }

        //dd($wallet_groupsummary);

        // return view('dashboardest', compact('wallet_summary', 'wallet_groupsummary', 'wallet', 'typeTransactions', 'myWallet', 'myTypeTransaction', 'myFechaDesde', 'myFechaHasta'));\
        return view('dashboardest2', compact('wallet_summary', 'wallet_groupsummary', 'wallet', 'typeTransactions', 'myWallet', 'myTypeTransaction', 'myFechaDesde', 'myFechaHasta'));
    }


    public function export()
    {
        return Excel::download(new DashboardestExport, 'estadisticas.xlsx');
    }



}
