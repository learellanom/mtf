<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Http\Controllers\statisticsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Exports\DashboardestExport;
use App\Exports\DashboardExportComisiones;
use App\Exports\DashboardSaldosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Type_coin;

class HomeController extends Controller
{



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

        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request);
        // dd($wallet_summary );
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


        $myCoin             = ($request->coin) ? $request->coin : 1;

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
		$Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();

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

            // \Log::info("leam 1-> myFechaDesde  -> $myFechaDesde");
            // \Log::info("leam 1-> myFechaHasta  -> $myFechaHasta");
            // \Log::info("leam 1-> balanceDetail -> $balanceDetail");
            // \Log::info("leam 1-> myFechaDesdeBefore -> $myFechaDesdeBefore");
            // \Log::info("leam 1-> myFechaHastaBefore -> $myFechaHastaBefore");

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);



            // \Log::info("leam 2-> balance3 -> " . print_r($balance3,true));
            // \Log::info("leam 2-> balanceDetail -> " . print_r($balanceDetail,true));
            // \Log::info("leam 2-> ");
            // \Log::info("leam 2-> ");

        };


        $parametros['transaction_group_summary']    = $transaction_group_summary;
        $parametros['transaction_summary']          = $transaction_summary;
        $parametros['wallet_summary']               = $wallet_summary;
        $parametros['wallet_groupsummary']          = $wallet_groupsummary;
        $parametros['wallet']                       = $wallet;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = $myFechaDesde;
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['balanceDetail']                = $balanceDetail;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;
        $parametros['balance']                      = $balance;
        $parametros['myTypeCoinBalance']            = $myTypeCoinBalance;
        $parametros['Type_coin_balance']            = $Type_coin_balance;

        return view('dashboardest2', $parametros);

        return view('dashboardest2', compact(
        'transaction_group_summary',
        'transaction_summary',
        'wallet_summary', 
        'wallet_groupsummary', 
        'wallet', 
        'typeTransactions', 
        'myWallet', 
        'myTypeTransaction', 
        'myFechaDesde', 
        'myFechaHasta',
        'balanceDetail',
        'myFechaDesdeBefore',
        'myFechaHastaBefore',
        'balance'));

    }

    
    public function comisiones(request $request)
    {
     
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);

        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request);
        // dd($wallet_summary );
        $request2                   = clone $request;
        $request2->transaction      = 0;
        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request2);
        // dd($wallet_summary);
        $wallet_groupsummary        = app(statisticsController::class)->getWalletTransactionGroupSummary($request);
        // dd($wallet_groupsummary);
        $wallet                     = app(statisticsController::class)->getWallet();
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions();


        $request3                   = clone $request;
        $request3->transaction      = 0;
        $transaction_summary        = app(statisticsController::class)->getTransactionSummary($request3);
        // dd($transaction_summary);
        $request4                   = clone $request;
        $transaction_group_summary  = app(statisticsController::class)->getTransactionGroupSummary($request4);

        // dd($transaction_group_summary);


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
        $balance3           = 0;

        $balanceDetail = 0;
        if ($myWallet > 0){
            // dd($indRecibeFecha);
            if ($myFechaDesde != "2001-01-01"){
                $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);
            }

            // \Log::info("leam 1-> myFechaDesde  -> $myFechaDesde");
            // \Log::info("leam 1-> myFechaHasta  -> $myFechaHasta");
            // \Log::info("leam 1-> balanceDetail -> $balanceDetail");
            // \Log::info("leam 1-> myFechaDesdeBefore -> $myFechaDesdeBefore");
            // \Log::info("leam 1-> myFechaHastaBefore -> $myFechaHastaBefore");

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);



            // \Log::info("leam 2-> balance3 -> " . print_r($balance3,true));
            // \Log::info("leam 2-> balanceDetail -> " . print_r($balanceDetail,true));
            // \Log::info("leam 2-> ");
            // \Log::info("leam 2-> ");

        };

        $parametros['transaction_group_summary']    = $transaction_group_summary;
        $parametros['transaction_summary']          = $transaction_summary;
        $parametros['wallet_summary']               = $wallet_summary;
        $parametros['wallet_groupsummary']          = $wallet_groupsummary;
        $parametros['wallet']                       = $wallet;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = $myFechaDesde;
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['balanceDetail']                = $balanceDetail;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;
        $parametros['balance']                      = $balance;

        //  dd($transaction_summary);
        //  dd($wallet_groupsummary);

        return view('dashboardComisiones2', $parametros);

    }

    public function comisionesGrupo(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        
        // new
       // if (auth()->id() == 2){


        // }


        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request);
        // dd($wallet_summary );
        $request2                   = clone $request;
        $request2->transaction      = 0;
        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request2);
        // dd($wallet_summary);
        $wallet_groupsummary        = app(statisticsController::class)->getWalletTransactionGroupSummary($request);
        // dd($wallet_groupsummary);

        $requestGeneral             = clone $request;
        $requestGeneral->wallet     = $requestGeneral->wallet2 ?? 0;
        // dd($requestGeneral->wallet);
        $wallet_groupsummaryGeneral = app(statisticsController::class)->getWalletTransactionGroupSummary($requestGeneral);
        // dd($wallet_groupsummary);

        $wallet                     = app(statisticsController::class)->getWallet();
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions();


        $request3                   = clone $request;
        $request3->transaction      = 0;
        $transaction_summary        = app(statisticsController::class)->getTransactionSummary($request3);
        // dd($transaction_summary);
        $request4                   = clone $request;
        $transaction_group_summary  = app(statisticsController::class)->getTransactionGroupSummary($request4);

        // dd($transaction_group_summary);


        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myWallet2 = 0;
        if ($request->wallet2){
            $myWalletDesde   = $request->wallet2;
            $myWalletHasta   = $request->wallet2;
            $myWallet2        = $request->wallet2;
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
        $balance3           = 0;

        $balanceDetail = 0;
        if ($myWallet > 0){
            // dd($indRecibeFecha);
            if ($myFechaDesde != "2001-01-01"){
                $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);
            }

            // \Log::info("leam 1-> myFechaDesde  -> $myFechaDesde");
            // \Log::info("leam 1-> myFechaHasta  -> $myFechaHasta");
            // \Log::info("leam 1-> balanceDetail -> $balanceDetail");
            // \Log::info("leam 1-> myFechaDesdeBefore -> $myFechaDesdeBefore");
            // \Log::info("leam 1-> myFechaHastaBefore -> $myFechaHastaBefore");

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);



            // \Log::info("leam 2-> balance3 -> " . print_r($balance3,true));
            // \Log::info("leam 2-> balanceDetail -> " . print_r($balanceDetail,true));
            // \Log::info("leam 2-> ");
            // \Log::info("leam 2-> ");

        };

        $parametros['transaction_group_summary']    = $transaction_group_summary;
        $parametros['transaction_summary']          = $transaction_summary;
        $parametros['wallet_summary']               = $wallet_summary;
        $parametros['wallet_groupsummary']          = $wallet_groupsummary;
        $parametros['wallet']                       = $wallet;                  //
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;                //
        $parametros['myWallet2']                    = $myWallet2;               //
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = $myFechaDesde;
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['balanceDetail']                = $balanceDetail;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;
        $parametros['balance']                      = $balance;
        $parametros['wallet_groupsummaryGeneral']   = $wallet_groupsummaryGeneral;
        
        //  dd($transaction_summary);
        //  dd($wallet_groupsummary);

        return view('dashboardComisionesGrupo', $parametros);

    }
    
    public function comisionesGrupo2(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions(); // *
        
        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myGrupoDesde   = 0;
        $myGrupoHasta   = 9999;
        $myGrupo        = 0;
        if ($request->grupo){
            $myGrupoDesde   = $request->grupo;
            $myGrupoHasta   = $request->grupo;
            $myGrupo        = $request->grupo;
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

        // dd($myFechaDesde);
        
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        
        $wallet                          = app(statisticsController::class)->getWallet();
        $grupo                           = app(statisticsController::class)->getGroups();
        
        if ($myWallet != 0){
            
            list($Recargas, $Transacciones2) = app(statisticsController::class)->commissionsProfit($request);
        }else{
            $Recargas = [];
            $Transacciones2 = [];
        }

        // dd('transacciones 2 ->' . print_r($Transacciones2,true));

        $parametros['wallet']                       = $wallet;
        $parametros['grupo']                        = $grupo;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myGrupo']                      = $myGrupo;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = urlencode($myFechaDesde);
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;

        // die(urlencode($myFechaDesde));

        $parametros['Recargas']                     = $Recargas;
        $parametros['Transacciones']                = $Transacciones2;
        
        // dd($Recargas);
         
        // dd($parametros);
        // dd('leam aqui 3');
                     
        return view('dashboardComisionesGrupo2', $parametros);

    }

    
    public function comisionesGrupo3(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions(); // *
        
        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myGrupoDesde   = 0;
        $myGrupoHasta   = 9999;
        $myGrupo        = 0;
        if ($request->grupo){
            $myGrupoDesde   = $request->grupo;
            $myGrupoHasta   = $request->grupo;
            $myGrupo        = $request->grupo;
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

        // dd($myFechaDesde);
        
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        
        $wallet                          = app(statisticsController::class)->getWallet();
        $grupo                           = app(statisticsController::class)->getGroups();
        
        if ($myWallet != 0){
            
            list($Recargas, $Transacciones2) = app(statisticsController::class)->commissionsProfit3($request);
        }else{
            $Recargas = [];
            $Transacciones2 = [];
        }

        // dd('transacciones 2 ->' . print_r($Transacciones2,true));

        $parametros['wallet']                       = $wallet;
        $parametros['grupo']                        = $grupo;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myGrupo']                      = $myGrupo;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = urlencode($myFechaDesde);
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;

        // die(urlencode($myFechaDesde));

        $parametros['Recargas']                     = $Recargas;
        $parametros['Transacciones']                = $Transacciones2;
        
        // dd($Recargas);
         
        // dd($parametros);
        // dd('leam aqui 3');
                     
        return view('dashboardComisionesGrupo3', $parametros);

    }

    public function USDTResumenDiario(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        // dd($wallet);
        // if ($request->query('wallet')){
        // };

        
        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;    
        }

        $myGrupoDesde   = 0;
        $myGrupoHasta   = 9999;
        $myGrupo        = 0;
        if ($request->grupo){
            $myGrupoDesde   = $request->grupo;
            $myGrupoHasta   = $request->grupo;
            $myGrupo        = $request->grupo;
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
       // dd($request->fechaDesde . ' ' . $request->fechaHasta);
       // dd($myFechaDesde);
        
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        
        

        $wallet                         = app(statisticsController::class)->getWalletUSDT();
        $wallet2                        = app(statisticsController::class)->getWallet();
        $grupo                          = app(statisticsController::class)->getGroups();
        $typeTransactions               = app(statisticsController::class)->getTypeTransactions();

        $balance                        = 0;
        $balanceBefore                  = 0;
        
        if ($myWallet > 0){
            
            $balance        = app(statisticsController::class)->getBalanceWallet($myWallet);
            $balanceBefore  = app(statisticsController::class)->getBalanceWalletBefore($myWallet,$myFechaDesde, $myFechaHasta);
             
        }

        $transaccionesGrupoSalida = [];
        $transaccionesGrupoSalida2 = [];
        $transaccionesGrupoSalida3 = [];
        $transaccionesWalletsSalida3 = [];

        if ($myWallet != 0){
            
            $myJson         = file_get_contents("filtros\myUSDTResDiaMovimientosFiltro");
            $myJsonData     = json_decode($myJson,true); 
            // dd($myJsonData['groupsEntrada1']);
            // dd($myJsonData);
            $RecargasWallet             = app(statisticsController::class)->USDTResumenWallet($request);

            //$temp [] = 158;
            //$request->groups = $temp;

            $request->groups = $myJsonData['groupsEntrada1'];
            $transaccionesGrupoComision = app(statisticsController::class)->USDTResumenGrupoComision($request);

            // salida yaguara
            // $temp [] = 44;
            // $temp [] = 43;
            // $temp [] = 63;
            // $temp [] = 78;
            // $temp [] = 145;
            // $temp [] = 35;
            // $temp [] = 166;
            // $temp [] = 11;
            // $temp [] = 14;
            // $temp [] = 239;
            // $temp [] = 273;
            // $temp [] = 350;
            // $temp [] = 351;
            // $temp [] = 60;
            // $temp [] = 30;
            // $temp [] = 139;
            // $request->groups = $temp;


            $request->groups = $myJsonData['groupsSalida1'];
            $transaccionesGrupoSalida   = app(statisticsController::class)->USDTResumenGrupoSalida($request);

            // salida por operaciones
            // unset($temp);
            // $temp [] = 168;
            // $temp [] = 194;
            // $temp [] = 195;
            // $temp [] = 185;
            // $temp [] = 182;
            // $temp [] = 183;
            // $temp [] = 174;
            // $temp [] = 186;
            // $temp [] = 173;
            // $temp [] = 171;
            // $temp [] = 169;
            // $temp [] = 178;
            // $temp [] = 356;
            // $temp [] = 190;
            // $temp [] = 184;
            // $temp [] = 189;
            // $temp [] = 179;
            // $temp [] = 170;
            // $temp [] = 172;
            // $temp [] = 180;
            // $temp [] = 187;
            // $temp [] = 181;
            // $temp [] = 196;
            // $temp [] = 33;
            // $temp [] = 203;
            // $temp [] = 330;
            // $request->groups = $temp;

            $request->groups = $myJsonData['groupsSalida2'];
            $transaccionesGrupoSalida2   = app(statisticsController::class)->USDTResumenGrupoSalida($request);
            
            // gastos varios

            // unset($temp);
            // $temp [] = 219;
            // $temp [] = 188;
            // $temp [] = 205;
            // $temp [] = 174;
            // $temp [] = 228;
            // $temp [] = 204;
            // $temp [] = 208;
            // $temp [] = 225; // compra
            // $temp [] = 175; // cambio brasil
            // $temp [] = 267; // pendiente
            // $temp [] = 227; // otros gastos
            // $request->groups = $temp;

            // dd(print_r($request->groups,true));
            $request->groups = $myJsonData['groupsSalida3'];
            $transaccionesGrupoSalida3   = app(statisticsController::class)->USDTResumenGrupoSalida($request);

            $request->groups = $myJsonData['walletsSalida3'];
            $transaccionesWalletsSalida3   = app(statisticsController::class)->USDTResumenGrupoSalida($request);
            // salida gastos varios
            //$request->groups =[44,43,63];
            //$transaccionesGrupoSalida3   = app(statisticsController::class)->USDTResumenGrupoSalida($request);


        }else{
            $RecargasWallet             = [];
            $transaccionesGrupoComision = [];
        }

        // dd('transacciones 2 ->' . print_r($Transacciones2,true));

        $parametros['wallet']                       = $wallet;
        $parametros['wallet2']                       = $wallet2;
        $parametros['grupo']                        = $grupo;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myGrupo']                      = $myGrupo;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = urlencode($myFechaDesde);
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;

        // die(urlencode($myFechaDesde));

        $parametros['balance']                      = $balance;
        $parametros['balanceBefore']                = $balanceBefore;

        $parametros['RecargasWallet']               = $RecargasWallet;
        $parametros['transaccionesGrupoComision']   = $transaccionesGrupoComision;
        $parametros['transaccionesGrupoSalida']     = $transaccionesGrupoSalida;
        $parametros['transaccionesGrupoSalida2']    = $transaccionesGrupoSalida2;
        $parametros['transaccionesGrupoSalida3']    = $transaccionesGrupoSalida3;
        $parametros['transaccionesWalletsSalida3']  = $transaccionesWalletsSalida3;

        // dd($RecargasWallet);
        // dd($transaccionesGrupoComision);
         // dd($transaccionesGrupoSalida);
        // dd($transaccionesGrupoSalida2);
        // dd($transaccionesGrupoSalida3);
        // dd($transaccionesWalletsSalida3);
        // dd($parametros);
        // dd('leam aqui 3');
                     
        return view('usdt.USDTResDiaMovimientos', $parametros);

    }

    public function comisionesGrupoRes(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions(); // *

        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }
        
        $myGrupoDesde   = 0;
        $myGrupoHasta   = 9999;
        $myGrupo        = 0;
        if ($request->grupo){
            $myGrupoDesde   = $request->grupo;
            $myGrupoHasta   = $request->grupo;
            $myGrupo        = $request->grupo;
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

       // dd($myFechaDesde);
        
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        
        $wallet                          = app(statisticsController::class)->getWallet();
        $grupo                           = app(statisticsController::class)->getGroups();
        
        if ($myWallet != 0){
            list($Recargas3, $Transacciones4, $Transacciones2) = app(statisticsController::class)->commissionsProfitRes($request);
        }else{
            $Recargas3      = [];
            $Transacciones4 = [];
            $Transacciones2 = [];
        }

        // dd('transacciones 2 ->' . print_r($Transacciones4,true));

        $parametros['wallet']                       = $wallet;
        $parametros['grupo']                        = $grupo;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myGrupo']                      = $myGrupo;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = urlencode($myFechaDesde);
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;

        // die(urlencode($myFechaDesde));

        $parametros['Recargas']                     = $Recargas3;
        $parametros['Transacciones']                = $Transacciones4;   //
        $parametros['Transacciones2']               = $Transacciones2;   //        
         // dd($Recargas3);
         
        // dd($parametros);
        // dd('leam aqui 3');
                     
        return view('dashboardComisionesGrupoRes', $parametros);

    }  

    public function comisionesGrupoRes3(request $request)
    {
        
        // dd($request->fechaDesde . ' ' . $request->fechaHasta);
        
        // dd($wallet);
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions(); // *

        /* MANTENER VALOR BUSCADO EN EL URL */
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }
        
        $myGrupoDesde   = 0;
        $myGrupoHasta   = 9999;
        $myGrupo        = 0;
        if ($request->grupo){
            $myGrupoDesde   = $request->grupo;
            $myGrupoHasta   = $request->grupo;
            $myGrupo        = $request->grupo;
        }
        // dd($request->grupo);
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

       // dd($myFechaDesde);
        
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        
        $wallet                          = app(statisticsController::class)->getWallet();
        $grupo                           = app(statisticsController::class)->getGroups();
        
        if ($myWallet != 0){
            list($Recargas3, $Transacciones) = app(statisticsController::class)->commissionsProfitRes3($request);
        }else{
            $Recargas3      = [];
            $Transacciones  = [];
        }

        // dd('transacciones 2 ->' . print_r($Transacciones4,true));

        $parametros['wallet']                       = $wallet;
        $parametros['grupo']                        = $grupo;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myGrupo']                      = $myGrupo;
        $parametros['myTypeTransaction']            = $myTypeTransaction;
        $parametros['myFechaDesde']                 = urlencode($myFechaDesde);
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;

        // die(urlencode($myFechaDesde));

        $parametros['Recargas']                     = $Recargas3;
        $parametros['Transacciones']                = $Transacciones;
         // dd($Recargas3);
         
        // dd($parametros);
        // dd('leam aqui 3');
                     
        return view('dashboardComisionesGrupoRes3', $parametros);

    }  
    public function saldos(request $request)
    {
        
        $wallet_summary             = app(statisticsController::class)->getWalletSummary($request);
        


        //$request2                   = clone $request;
        //$request2->transaction      = 0;
        // $wallet_summary             = app(statisticsController::class)->getwalletTransactionSummary($request2);

        $group_summary              = app(statisticsController::class)->getGroupSummary($request);

        // dd($group_summary);
        
        $wallet                     = app(statisticsController::class)->getWallet();
        // dd($wallet);
        $group                      = app(statisticsController::class)->getGroups();
        $typeTransactions           = app(statisticsController::class)->getTypeTransactions();

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
        //
        // obtiene saldo anterior wallets
        // 
        $balanceDetail      = 0;
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        if ($myFechaDesde != "2001-01-01"){
            $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);
        }
        foreach($wallet_summary as $wallet3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($wallet3->IdWallet, $myFechaDesde, $myFechaHasta);
            
            $wallet3->BalanceAnterior = $balanceDetail;
        }

        // dd($wallet_summary);
        //
        // obtiene saldo anterior groups
        //
        foreach($group_summary as $group3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceBefore($group3->IdGrupo, $myFechaDesde, $myFechaHasta);
            
            $group3->BalanceAnterior = $balanceDetail;
        }

        // dd($group_summary);

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

            // \Log::info("leam 1-> myFechaDesde  -> $myFechaDesde");
            // \Log::info("leam 1-> myFechaHasta  -> $myFechaHasta");
            // \Log::info("leam 1-> balanceDetail -> $balanceDetail");
            // \Log::info("leam 1-> myFechaDesdeBefore -> $myFechaDesdeBefore");
            // \Log::info("leam 1-> myFechaHastaBefore -> $myFechaHastaBefore");

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);



            // \Log::info("leam 2-> balance3 -> " . print_r($balance3,true));
            // \Log::info("leam 2-> balanceDetail -> " . print_r($balanceDetail,true));
            // \Log::info("leam 2-> ");
            // \Log::info("leam 2-> ");

        };
        
        $myParameters['wallet_summary']     = $wallet_summary;
        $myParameters['group_summary']      = $group_summary;
        $myParameters['wallet']             = $wallet;
        $myParameters['group']              = $group;
        $myParameters['typeTransactions']   = $typeTransactions;
        $myParameters['myWallet']           = $myWallet;
        $myParameters['myTypeTransaction']  = $myTypeTransaction;
        $myParameters['myFechaDesde']       = $myFechaDesde;
        $myParameters['myFechaHasta']       = $myFechaHasta;
        $myParameters['balanceDetail']      = $balanceDetail;
        $myParameters['myFechaDesdeBefore'] = $myFechaDesdeBefore;
        $myParameters['balance']            = $balance;

        return view('dashboardSaldos', $myParameters);

    }


    


    public function export(request $request)
    {
        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request);

        $request2                   = clone $request;
        $request2->transaction      = 0;

        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request2);

        $wallet_groupsummary        = app(statisticsController::class)->getWalletTransactionGroupSummary($request);

        $request3                   = clone $request;
        $request3->transaction      = 0;
        $transaction_summary        = app(statisticsController::class)->getTransactionSummary($request3);

        $request4                   = clone $request;
        $transaction_group_summary  = app(statisticsController::class)->getTransactionGroupSummary($request4);

        //$request5               = clone $request;
        $balance                    = 0;

        $wallet = 0;
        if ($request->wallet){
            $wallet = $request->wallet;
        }

        if ($wallet > 0){
            $balance2 = app(statisticsController::class)->getBalanceWallet($wallet);

            if(isset($balance2->Total)){
                $balance  = $balance2->Total;
                //dd($balance);

            }
            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
        };

        $fechaDesde     = "2001-01-01";
        $fechaHasta     = "9999-12-31";
        if ($request->fechaDesde){
            $fechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $fechaHasta = $request->fechaHasta;
        }


        if($wallet == 0) {
            $wallet_summary = [];
            $wallet_groupsummary = [];

        }else{
            $transaction_summary = [];
            $transaction_group_summary = [];
        }

        $balanceDetail = app(statisticsController::class)->getBalanceWalletBefore($wallet, $fechaDesde, $fechaHasta);


        // dd($request->ocultarresumengeneral . ' ' . $request->ocultarresumentransaccion . ' ' . $request->transactions . ' wallet ' . $request->wallet);

        $ocultarresumengeneral          = $request->ocultarresumengeneral;
        $ocultarresumentransaccion      = $request->ocultarresumentransaccion;
        $transactions                   = $request->transactions;

        //dd($balanceDetail);
        return Excel::download(new DashboardestExport($wallet_summary, $wallet_groupsummary, $transaction_summary, $transaction_group_summary, $balance, $balanceDetail, $fechaDesde, $fechaHasta, $ocultarresumengeneral, $ocultarresumentransaccion, $transactions), 'Estadisticas por Caja.xlsx');

    }

    
    public function exportComisiones(request $request)
    {
        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request);

        $request2                   = clone $request;
        $request2->transaction      = 0;

        $wallet_summary             = app(statisticsController::class)->getWalletTransactionSummary($request2);

        $wallet_groupsummary        = app(statisticsController::class)->getWalletTransactionGroupSummary($request);

        $request3                   = clone $request;
        $request3->transaction      = 0;
        $transaction_summary        = app(statisticsController::class)->getTransactionSummary($request3);

        $request4                   = clone $request;
        $transaction_group_summary  = app(statisticsController::class)->getTransactionGroupSummary($request4);

        //$request5               = clone $request;
        $balance                    = 0;

        $wallet = 0;
        if ($request->wallet){
            $wallet = $request->wallet;
        }

        if ($wallet > 0){
            $balance2 = app(statisticsController::class)->getBalanceWallet($wallet);

            if(isset($balance2->Total)){
                $balance  = $balance2->Total;
                //dd($balance);

            }
            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
        };

        $fechaDesde     = "2001-01-01";
        $fechaHasta     = "9999-12-31";
        if ($request->fechaDesde){
            $fechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $fechaHasta = $request->fechaHasta;
        }


        if($wallet == 0) {
            $wallet_summary = [];
            $wallet_groupsummary = [];

        }else{
            $transaction_summary = [];
            $transaction_group_summary = [];
        }

        $balanceDetail = app(statisticsController::class)->getBalanceWalletBefore($wallet, $fechaDesde, $fechaHasta);


        // dd($request->ocultarresumengeneral . ' ' . $request->ocultarresumentransaccion . ' ' . $request->transactions . ' wallet ' . $request->wallet);

        $ocultarresumengeneral          = $request->ocultarresumengeneral;
        $ocultarresumentransaccion      = $request->ocultarresumentransaccion;
        $transactions                   = $request->transactions;

        

        $wallets        = app(statisticsController::class)->getWallet();
        $myWallet       = $wallet;
        $myWalletName   = "";
        if ($myWallet != 0){
            foreach($wallets as $key => $value){
                if($myWallet == $key){
                    $myWalletName = $value;
                }
            }
        }


        //dd($balanceDetail);
        return Excel::download(new DashboardExportComisiones($wallet_summary, $wallet_groupsummary, $transaction_summary, $transaction_group_summary, $balance, $balanceDetail, $fechaDesde, $fechaHasta, $ocultarresumengeneral, $ocultarresumentransaccion, $transactions, $myWallet, $myWalletName), 'Estadisticas Comisiones.xlsx');

    }

    public function exportSaldos(request $request)
    {
        
        $wallet_summary             = app(statisticsController::class)->getWalletSummary($request);

        $group_summary              = app(statisticsController::class)->getGroupSummary($request);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFiltroWallet     = "";
        $myFiltroGroup      = "";
        if ($request->filtroWallet) {
            $myFiltroWallet = $request->filtroWallet;

        }
        if ($request->filtroGroup) {
            $myFiltroGroup  = $request->filtroGroup;
        }        




        $myFiltroWalletB     = "";
        $myFiltroGroupB      = "";
        if ($request->filtroWalletB) {
            $myFiltroWalletB = $request->filtroWalletB;

        }
        if ($request->filtroGroupB) {
            $myFiltroGroupB  = $request->filtroGroupB;
        } 





        //
        // obtiene saldo anterior wallets
        // 
        $balanceDetail      = 0;
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        if ($myFechaDesde != "2001-01-01"){
            $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);
        }
        foreach($wallet_summary as $wallet3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($wallet3->IdWallet, $myFechaDesde, $myFechaHasta);
            
            $wallet3->BalanceAnterior = $balanceDetail;
        }

        foreach($group_summary as $group3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceBefore($group3->IdGrupo, $myFechaDesde, $myFechaHasta);
            
            $group3->BalanceAnterior = $balanceDetail;
        }

        $myResumen = 0;
        if ($request->resumen){
            $myResumen = $request->resumen;
        }

        
        //dd($balanceDetail);
        return Excel::download(new DashboardSaldosExport($wallet_summary, $group_summary, $myFechaDesde, $myFechaHasta, $myFiltroWallet, $myFiltroGroup, $myFiltroWalletB, $myFiltroGroupB, $myResumen), 'Saldos al corte.xlsx');
                                   
    }

    public function exportSaldosPDF(request $request){
        
        $wallet_summary             = app(statisticsController::class)->getWalletSummary($request);

        $group_summary              = app(statisticsController::class)->getGroupSummary($request);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFiltroWallet     = "";
        $myFiltroGroup      = "";
        if ($request->filtroWallet) {
            $myFiltroWallet = $request->filtroWallet;

        }
        if ($request->filtroGroup) {
            $myFiltroGroup  = $request->filtroGroup;
        }        

        $myFiltroWalletB     = "";
        $myFiltroGroupB      = "";
        if ($request->filtroWalletB) {
            $myFiltroWalletB = $request->filtroWalletB;

        }
        if ($request->filtroGroupB) {
            $myFiltroGroupB  = $request->filtroGroupB;
        }   

        // dd('aqui en homrecontrolelr myFiltroGrupoB ->' . $myFiltroGroupB);

        //
        // obtiene saldo anterior wallets
        // 
        $balanceDetail      = 0;
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        if ($myFechaDesde != "2001-01-01"){
            $myFechaHastaBefore = app(statisticsController::class)->getDayBefore($myFechaDesde);
        }
        foreach($wallet_summary as $wallet3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($wallet3->IdWallet, $myFechaDesde, $myFechaHasta);
            
            $wallet3->BalanceAnterior = $balanceDetail;
        }

        foreach($group_summary as $group3){            
            $balanceDetail           = app(statisticsController::class)->getBalanceBefore($group3->IdGrupo, $myFechaDesde, $myFechaHasta);
            
            $group3->BalanceAnterior = $balanceDetail;
        }

        $myResumen = 0;
        if ($request->resumen){
            $myResumen = $request->resumen;
        }

        
        //dd($balanceDetail);

        $parametros['wallet_summary']   = $wallet_summary;        
        $parametros['group_summary']    = $group_summary;      
        $parametros['fechaDesde']     = $myFechaDesde;
        $parametros['fechaHasta']     = $myFechaHasta;
        $parametros['filtroWallet']     = $myFiltroWallet;
        $parametros['filtroGroup']      = $myFiltroGroup;
        $parametros['filtroWalletB']     = $myFiltroWalletB;
        $parametros['filtroGroupB']      = $myFiltroGroupB;        
        $parametros['resumen']          = $myResumen;
        
        $pdf = \PDF::loadView('dashboardSaldosPDF', $parametros);
        return $pdf->download('Consolidado de Saldos.pdf');
        
    }

    public function exportPDF(request $request){

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

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);

        };

        $parametros['transaction_group_summary']    = $transaction_group_summary;        
        $parametros['transaction_summary']          = $transaction_summary;  
        $parametros['wallet_summary']               = $wallet_summary;
        $parametros['wallet_groupsummary']          = $wallet_groupsummary;
        $parametros['wallet']                       = $wallet;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myTypeTransaction']            = $myTypeTransaction;      
        $parametros['myFechaDesde']                 = $myFechaDesde;
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['balanceDetail']                = $balanceDetail;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;
        $parametros['balance']                      = $balance;
        
        $pdf = \PDF::loadView('dashboardest22', $parametros);
        return $pdf->download('Estadisticas.pdf');

    }

    public function exportPDFComisiones(request $request){


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

            $balanceDetail           = app(statisticsController::class)->getBalanceWalletBefore($myWallet, $myFechaDesde, $myFechaHasta);

        };


        $wallets        = app(statisticsController::class)->getWallet();
        
        $myWalletName   = "";
        if ($myWallet != 0){
            foreach($wallets as $key => $value){
                if($myWallet == $key){
                    $myWalletName = $value;
                }
            }
        }



        $parametros['transaction_group_summary']    = $transaction_group_summary;        
        $parametros['transaction_summary']          = $transaction_summary;  
        $parametros['wallet_summary']               = $wallet_summary;
        $parametros['wallet_groupsummary']          = $wallet_groupsummary;
        $parametros['wallet']                       = $wallet;
        $parametros['typeTransactions']             = $typeTransactions;
        $parametros['myWallet']                     = $myWallet;
        $parametros['myTypeTransaction']            = $myTypeTransaction;      
        $parametros['myFechaDesde']                 = $myFechaDesde;
        $parametros['myFechaHasta']                 = $myFechaHasta;
        $parametros['balanceDetail']                = $balanceDetail;
        $parametros['myFechaDesdeBefore']           = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']           = $myFechaHastaBefore;
        $parametros['balance']                      = $balance;
        $parametros['myWalletName']                 = $myWalletName;
        
         $pdf = \PDF::loadView('dashboardComisionesPDF', $parametros);
         return $pdf->download('EstadisticasComisiones.pdf');


        // $pdf = \PDF::loadView('dashboardest22', $parametros);
        // return $pdf->download('Estadisticas.pdf');


    }

}

