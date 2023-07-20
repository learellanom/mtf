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

        $wallet_summary             = app(statisticsController::class)->getwalletTransactionSummary($request);

        $request2                   = clone $request;
        $request2->transaction      = 0;
        $wallet_summary             = app(statisticsController::class)->getwalletTransactionSummary($request2);

        $wallet_groupsummary        = app(statisticsController::class)->getWalletTransactionGroupSummary($request);
        // dd($wallet_groupsummary);
        $wallet                     = app(statisticsController::class)->getWallet();
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions();


        $request3                   = clone $request;
        $request3->transaction      = 0;
        $transaction_summary        = app(statisticsController::class)->getTransactionSummary($request3);

        $request4                   = clone $request;
        $transaction_group_summary  = app(statisticsController::class)->getTransactionGroupSummary($request4);

        // dd($transaction_summary);


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


        
        $balance = 0;
        
        if ($myWallet > 0){
            $balance2 = app(statisticsController::class)->getBalanceWallet($myWallet);
            if(isset($balance2->Total)){
                $balance  = $balance2->Total;
            }
            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
        };
        

       // dd($myFechaDesde);
        $balanceDetail      = 0;
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        $balance3 = 0;

        $balanceDetail = 0;
        if ($myWallet > 0){
            // dd($indRecibeFecha);                
            if ($myFechaDesde != "2001-01-01"){

                $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);

            }

            \Log::info("leam 1-> myFechaDesde  -> $myFechaDesde");
            \Log::info("leam 1-> myFechaHasta  -> $myFechaHasta");
            \Log::info("leam 1-> balanceDetail -> $balanceDetail");
            \Log::info("leam 1-> myFechaDesdeBefore -> $myFechaDesdeBefore");
            \Log::info("leam 1-> myFechaHastaBefore -> $myFechaHastaBefore");   

            /*
            $balance3           = app(statisticsController::class)->getBalanceWallet($myWallet, $myFechaDesdeBefore, $myFechaHastaBefore);
            if(isset($balance3->Total)){
                $balanceDetail  = $balance3->Total;
            }
            */
            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);            

            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
            // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta .  ' balance detail -> ' . $balanceDetail . ' ' . $myFechaDesdeBefore . ' ' . $myFechaHastaBefore);

             
            \Log::info("leam 2-> balance3 -> " . print_r($balance3,true));
            \Log::info("leam 2-> balanceDetail -> " . print_r($balanceDetail,true));         
            \Log::info("leam 2-> ");
            \Log::info("leam 2-> ");

        };

        //dd($wallet_summary);


        // if ($myWallet ==0){
        //     $wallet_summary = $transact  ion_summary;
        // }
        // return view('dashboardest', compact('wallet_summary', 'wallet_groupsummary', 'wallet', 'typeTransactions', 'myWallet', 'myTypeTransaction', 'myFechaDesde', 'myFechaHasta'));\
        return view('dashboardest2', compact('transaction_group_summary','transaction_summary','wallet_summary', 'wallet_groupsummary', 'wallet', 'typeTransactions', 'myWallet', 'myTypeTransaction', 'myFechaDesde', 'myFechaHasta','balanceDetail','myFechaDesdeBefore','myFechaHastaBefore','balance'));

    }


    public function export(request $request, $wallet)
    {
        $wallet_summary = app(statisticsController::class)->getwalletTransactionSummary($request);

        $request2 = clone $request;
        $request2->transaction = 0;

        $wallet_summary = app(statisticsController::class)->getwalletTransactionSummary($request2);

        $wallet_groupsummary = app(statisticsController::class)->getWalletTransactionGroupSummary($request);

        $request3               = clone $request;
        $request3->transaction = 0;
        $transaction_summary     = app(statisticsController::class)->getTransactionSummary($request3);

        $request4               = clone $request;
        $transaction_group_summary     = app(statisticsController::class)->getTransactionGroupSummary($request4);



        if($wallet == 0) {
            $wallet_summary = [];
            $wallet_groupsummary = [];

        }else{
            $transaction_summary = [];
            $transaction_group_summary = [];
        }



        //dd($wallet_summary);
        return Excel::download(new DashboardestExport($wallet_summary, $wallet_groupsummary, $transaction_summary, $transaction_group_summary), 'estadisticas.xlsx');
    }



}
