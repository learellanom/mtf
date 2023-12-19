<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Wallet;
use App\Models\Type_transaction;
use App\Models\Group;
use App\Models\Supplier;
use App\Models\Transaction_master;
use App\Models\Transaction_supplier;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Pest\Support\Str;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Config;

class statisticsController extends Controller
{

    private $myCreditsWallet    = "2,4,6,7,10,13,19,20,21,22,23,24,26";
    private $myDebitsWallet     = "1,3,5,8,9,11,12,14,15,16,17,18,25";

    private $myCredits          = "1,3,5,6,7,9,11,14,15,16,17,18,25";
    private $myDebits           = "2,4,8,10,12,13,19,20,21,22,23,24,26";

    public function getCredits(){

        // $myTemp = $this->myCredits;
        // return $myTemp;

        $myTemp = $this->loadGroupCredits();
        $myTemp = implode(",",$myTemp);
        // dd($myTemp);
        return $myTemp;
    
    }

    public function getDebits(){

        // $myTemp = $this->myDebits;
        // return $myTemp;
        
        $myTemp = $this->loadGroupDebits();
        $myTemp = implode(",",$myTemp);
        // dd($myTemp);
        return $myTemp;
    }

    public function getWalletCredits(){

        // $myTemp = $this->myCreditsWallet;
        // // dd($myTemp);
        // return $myTemp;

        
        $myTemp = $this->loadWalletCredits();
        $myTemp = implode(",",$myTemp);
        // dd($myTemp);
        return $myTemp;
    }

    public function getWalletDebits(){

        // $myTemp = $this->myDebitsWallet;
        // // dd($myTemp);
        // return $myTemp;

        
        $myTemp = $this->loadWalletDebits();
        $myTemp = implode(",",$myTemp);
        // dd($myTemp);
        return $myTemp;
    }


    
    public function getCreditDebitGroup($myType){
 
        //$myTypeCredit   = explode(",",$this->myCredits);
        //$myTypeDebit    = explode(",",$this->myDebits);

        $myTypeCredit   = $this->loadGroupCredits();
        $myTypeDebit    = $this->loadGroupDebits();

        foreach($myTypeCredit as $value){
            if ($value == $myType){
                return "Credito";
            }
        }

        foreach($myTypeDebit as $value){
            if ($value == $myType){
                return "Debito";
            }
        }

        return "";

    }
    /*
    *
    *
    *   getCreditDebitWallet
    *
    *
    */

    public function getCreditDebitWallet($myType){

        
        // $myTypeCredit   = explode(",",$this->myCreditsWallet);
        // $myTypeDebit    = explode(",",$this->myDebitsWallet);

         $myTypeCredit   = $this->loadWalletCredits();
         $myTypeDebit    = $this->loadWalletDebits();

        foreach($myTypeCredit as $value){
            if ($value == $myType){
                return "Credito";
            }
        }

        foreach($myTypeDebit as $value){
            if ($value == $myType){
                return "Debito";
            }
        }

        return "";

    }    


    function loadWalletCredits(){
        $Type_transactions = Type_transaction::select('type_transactions.id')
        ->where('type_transaction_wallet','=','1')
        ->pluck('id');
        $myArray = array();
        foreach($Type_transactions as $value){
            array_push($myArray,$value);
        }
        // \Log::info( 'leam *** statisticsController -> loadGroupCredits ->' . $Type_transactions);

        return $myArray;
    }

    function loadWalletDebits(){
        $Type_transactions = Type_transaction::select('type_transactions.id')
        ->where('type_transaction_wallet','=','2')
        ->pluck('id');
        $myArray = array();
        foreach($Type_transactions as $value){
            array_push($myArray,$value);
        }
        // \Log::info( 'leam *** statisticsController -> loadGroupCredits ->' . $Type_transactions);

        return $myArray;
    }
    function loadGroupCredits(){
        $Type_transactions = Type_transaction::select('type_transactions.id')
        ->where('type_transaction_group','=','1')
        ->pluck('id');
        $myArray = array();
        foreach($Type_transactions as $value){
            array_push($myArray,$value);
        }
        // \Log::info( 'leam *** statisticsController -> loadGroupCredits ->' . $Type_transactions);

        return $myArray;
    }

    function loadGroupDebits(){
        $Type_transactions = Type_transaction::select('type_transactions.id')
        ->where('type_transaction_group','=','2')
        ->pluck('id');
        // \Log::info( 'leam *** statisticsController -> loadGroupDebits ->' . $Type_transactions);
        $myArray = array();        
        foreach($Type_transactions as $value){
            array_push($myArray,$value);
        }
        return $myArray;
    }
    /*
    *
    *
    *   index_all
    *
    *
    */
    public function index_all(Request $request)
    {
        


        $myGroup        = 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;        
        if ($request->grupo) {
            $myGroup        = $request->grupo;
            $myGroupDesde   = $request->grupo;
            $myGroupHasta   = $request->grupo;
        }

        $myWallet       = 0;
        $myWalletDesde  = 0;
        $myWalletHasta  = 9999;
        if ($request->wallet) {
            $myWallet       = $request->wallet;
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }
        // dd('myWalletDesde -> ' . $myWalletDesde . 'myWalletDesde ->  ' . $myWalletHasta);
        $myHoraDesde    = "00:00:00";
        $myHoraHasta    = "23:59:00";

        $myFechaDesde   = "2001-01-01";
        $myFechaHasta   = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde;
            $myFechaHasta = $myFechaHasta;


        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta;           
        }

        $myTypeTransactions         = 0;
        $myTypeTransactionsDesde    = 0;
        $myTypeTransactionsHasta    = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions         = $request->typeTransactions;
            $myTypeTransactionsDesde    = $request->typeTransactions;
            $myTypeTransactionsHasta    = $request->typeTransactions;
        }

        // token

        $myToken            = 0;
        $myTokenDesde       = "";
        $myTokenHasta       = "ZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";
        $myTokenCondition   = "";

        if ($request->token){
            if($request->token == 1){
                $myTokenDesde       = "0";
                $myTokenHasta       = "ZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";        
            }
        }

        $balance        = "";
        $balanceBefore  = 0;

        if ($myGroup > 0){

            $balance            = $this->getBalance($myGroup);
            $balanceBefore      = $this->getBalanceBefore($myGroup,$myFechaDesde, $myFechaHasta);
           // $balance = $this->getBalanceGroup($myGroup, $myFechaDesde, $myFechaHasta);
           
        }
        else
        {
            if ($myWallet > 0){
                $balance        = $this->getBalanceWallet($myWallet);
                $balanceBefore  = $this->getBalanceWalletBefore($myWallet,$myFechaDesde, $myFechaHasta);
            }
        };
        // dd($balance);

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }
        $myUserDesde = 0;
        $myUserHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }


        //  print_r($myGroup);
         // dd($myGroup);
         $Transacciones = [];
        $myLimit        = 0;
        $myLimitDesde   = 0;
        $myLimitHasta   = 5000;
        if ($myWallet == 0 and $myGroup == 0) {
            $myLimit        = 300;
            $myLimitDesde   = 300;
            $myLimitHasta   = 300;
        }

        
        \Log::info('leam usuario desde       ***    -> ' . $myUserDesde);
        \Log::info('leam usuario hasta       ***    -> ' . $myUserHasta);

        \Log::info('leam wallet desde        ***    -> ' . $myWalletDesde);
        \Log::info('leam wallet hasta        ***    -> ' . $myWalletHasta);        

        \Log::info('leam myGroup             ***    -> ' . $myGroup);        
        \Log::info('leam group  desde        ***    -> ' . $myGroupDesde);
        \Log::info('leam group  Hasta        ***    -> ' . $myGroupHasta);     

        \Log::info('leam transaction         ***    -> ' . $myTypeTransactions);
        \Log::info('leam transaction  desde  ***    -> ' . $myTypeTransactionsDesde);
        \Log::info('leam transaction  Hasta  ***    -> ' . $myTypeTransactionsHasta);              
        

        \Log::info('leam token desde         ***    -> ' . $myTokenDesde);
        \Log::info('leam token hasta         ***    -> ' . $myTokenHasta);
        
        \Log::info('leam fecha desde         ***    -> ' . $myFechaDesde);
        \Log::info('leam fecha hasta         ***    -> ' . $myFechaHasta);
        
        \Log::info('leam fecha desde request ***    -> ' . $request->fechaDesde);
        \Log::info('leam fecha hasta request ***    -> ' . $request->fechaHasta);
        
        \Log::info('leam Lmit                ***    -> ' . $myLimit);


         if ($myGroup != 0 or $myWallet != 0){
            

            \Log::info('leam - pasa con grupo');

            $Transacciones = Transaction::select(
                'Transactions.id                        as Id',
                'Transactions.amount_foreign_currency   as MontoMoneda',
                'Transactions.exchange_rate             as TasaCambio',
                'Transactions.exchange_rate_base        as TasaCambioBase',
                'Transactions.type_coin_id              as TipoMonedaId',
                'type_coins.name                        as TipoMoneda',
                'users.name                             as AgenteName',
                'Transactions.amount                    as Monto',
                'Transactions.amount_total              as MontoTotal',
                'Transactions.percentage                as PorcentajeComision',
                'Transactions.amount_commission         as MontoComision',
                'Transactions.amount_total_base         as MontoTotalBase',
                'Transactions.amount_base               as MontoBase',
                'Transactions.percentage_base           as PorcentajeComisionBase',
                'Transactions.amount_commission_base    as MontoComisionBase',
                'Transactions.type_transaction_id       as TransactionId',
                'type_transactions.name                 as TipoTransaccion',
                'transactions.wallet_id                 as WalletId',
                'wallets.name                           as WalletName',              
                'transactions.description               as Descripcion',
                'transactions.transaction_date          as FechaTransaccion',
                'transactions.group_id                  as ClienteId',
                DB::raw('IFNULL(transactions.group_id, 0) as ClienteId2'),
                'groups.name                            as ClientName',
                DB::raw('IFNULL(transactions.token, "") as token')            
            )->leftJoin(
                'users','users.id', '=', 'transactions.user_id'
            )->leftJoin(
                'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
            )->leftJoin(
                'groups as wallets', 'wallets.id', '=', 'transactions.wallet_id'
            )->leftJoin(
                'groups', 'groups.id', '=', 'transactions.group_id'
            )->leftJoin(
                'type_coins', 'type_coins.id', '=', 'transactions.type_coin_id'                  
            )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
            )->whereBetween('Transactions.wallet_id',           [$myWalletDesde, $myWalletHasta]
            )->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionsDesde, $myTypeTransactionsHasta]
            )->whereBetween('Transactions.transaction_date',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"]
            )->where('Transactions.status', '=', 'Activo'
            )->havingBetween('ClienteId2',      [$myGroupDesde, $myGroupHasta]
            )->havingBetween('token',           [$myTokenDesde, $myTokenHasta]
            )->orderBy('Transactions.transaction_date','ASC')
            ->get();

            // $Transacciones2 = array();
            // foreach($Transacciones as $tran){
            //     $value1 = json_decode($tran);
    
            //     $value2 = array_values(json_decode(json_encode($tran), true));
    
            //     array_push($Transacciones2, $value2);
            // }
            // dd('aqui');
            
        }else {

            \Log::info('leam - pasa sin  grupo');

            $Transacciones = Transaction::select(
                'Transactions.id                        as Id',
                'Transactions.amount_foreign_currency   as MontoMoneda',
                'Transactions.exchange_rate             as TasaCambio',
                'Transactions.exchange_rate_base        as TasaCambioBase',
                'Transactions.type_coin_id              as TipoMonedaId',
                'type_coins.name                        as TipoMoneda',
                'users.name                             as AgenteName',
                'Transactions.amount                    as Monto',
                'Transactions.amount_total              as MontoTotal',
                'Transactions.percentage                as PorcentajeComision',
                'Transactions.amount_commission         as MontoComision',
                'Transactions.amount_total_base         as MontoTotalBase',
                'Transactions.amount_base               as MontoBase',
                'Transactions.percentage_base           as PorcentajeComisionBase',
                'Transactions.amount_commission_base    as MontoComisionBase',
                'Transactions.type_transaction_id       as TransactionId',
                'type_transactions.name                 as TipoTransaccion',
                'transactions.wallet_id                 as WalletId',
                'wallets.name                           as WalletName',              
                'transactions.description               as Descripcion',
                'transactions.transaction_date          as FechaTransaccion',
                'transactions.group_id                  as ClienteId',
                DB::raw('IFNULL(transactions.group_id, 0) as ClienteId2'),
                'groups.name                            as ClientName',
                DB::raw('IFNULL(transactions.token, "") as token')            
            )->leftJoin(
                'users','users.id', '=', 'transactions.user_id'
            )->leftJoin(
                'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
            )->leftJoin(
                'groups as wallets', 'wallets.id', '=', 'transactions.wallet_id'
            )->leftJoin(
                'groups', 'groups.id', '=', 'transactions.group_id'
            )->leftJoin(
                'type_coins', 'type_coins.id', '=', 'transactions.type_coin_id'                  
            )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
            )->whereBetween('Transactions.wallet_id',           [$myWalletDesde, $myWalletHasta]
            )->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionsDesde, $myTypeTransactionsHasta]
            )->whereBetween('Transactions.transaction_date',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"]
            )->where('Transactions.status', '=', 'Activo'
            )->havingBetween('ClienteId2',      [$myGroupDesde, $myGroupHasta]
            )->havingBetween('token',           [$myTokenDesde, $myTokenHasta]
            )->orderBy('Transactions.transaction_date','ASC')
            ->limit(300)
            ->get();

       }

        //  dd($Transacciones);
        // \Log::info('index transacciones -> ' . print_r($Transacciones,true));
        // die();

        $userole            = $this->getUser();
        $wallet             = $this->getWallet();
        $group              = $this->getGroups();
        $typeTransactions   = $this->getTypeTransactions();

        if ($myFechaDesde === "2001-01-01"){
            $myFechadesdeInvertida = "";
        }else{
            $myFechaDesdeBefore     = $this->getDayBefore($myFechaDesde);
            $myFechadesdeInvertida  = substr($myFechaDesdeBefore,8,2) . "-" . substr($myFechaDesdeBefore,5,2) . "-" . substr($myFechaDesdeBefore,0,4);
        }

        $parametros['userole']                  = $userole;
        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;
        $parametros['typeTransactions']         = $typeTransactions;
        $parametros['Transacciones']            = $Transacciones;
        $parametros['myUser']                   = $myUser;
        $parametros['myGroup']                  = $myGroup;
        $parametros['myWallet']                 = $myWallet;
        $parametros['balance']                  = $balance;
        $parametros['myTypeTransactions']       = $myTypeTransactions;
        $parametros['myFechaDesde']             = $myFechaDesde;
        $parametros['myFechaHasta']             = $myFechaHasta;
        $parametros['balanceBefore']            = $balanceBefore;
        $parametros['myFechadesdeInvertida']    = $myFechadesdeInvertida;

        // dd($myFechadesdeInvertida);
        // \Log::info('leam ----> ' .  json_encode($Transacciones, JSON_PRETTY_PRINT));
        return view('estadisticas.index', $parametros);

    }    
    /*
    *
    *
    *   index_allOld
    *
    *
    */
    public function index_allOld(Request $request)
    {
        


        $myGroup        = 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;        
        if ($request->grupo) {
            $myGroup        = $request->grupo;
            $myGroupDesde   = $request->grupo;
            $myGroupHasta   = $request->grupo;
        }

        $myWallet       = 0;
        $myWalletDesde  = 0;
        $myWalletHasta  = 9999;
        if ($request->wallet) {
            $myWallet       = $request->wallet;
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }
        // dd('myWalletDesde -> ' . $myWalletDesde . 'myWalletDesde ->  ' . $myWalletHasta);
        $myHoraDesde    = "00:00:00";
        $myHoraHasta    = "23:59:00";

        $myFechaDesde   = "2001-01-01";
        $myFechaHasta   = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde;
            $myFechaHasta = $myFechaHasta;


        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta;           
        }

        $myTypeTransactions         = 0;
        $myTypeTransactionsDesde    = 0;
        $myTypeTransactionsHasta    = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions         = $request->typeTransactions;
            $myTypeTransactionsDesde    = $request->typeTransactions;
            $myTypeTransactionsHasta    = $request->typeTransactions;
        }

        // token

        $myToken            = 0;
        $myTokenDesde       = "";
        $myTokenHasta       = "ZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";
        $myTokenCondition   = "";

        if ($request->token){
            if($request->token == 1){
                $myTokenCondition = " and token    between '$myTokenDesde'             and '$myTokenHasta'";
            }
        }

        $balance        = "";
        $balanceBefore  = 0;

        if ($myGroup > 0){

            $balance            = $this->getBalance($myGroup);
            $balanceBefore      = $this->getBalanceBefore($myGroup,$myFechaDesde, $myFechaHasta);
           // $balance = $this->getBalanceGroup($myGroup, $myFechaDesde, $myFechaHasta);
           
        }
        else
        {
            if ($myWallet > 0){
                $balance        = $this->getBalanceWallet($myWallet);
                $balanceBefore  = $this->getBalanceWalletBefore($myWallet,$myFechaDesde, $myFechaHasta);
            }
        };
        // dd($balance);

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }
        $myUserDesde = 0;
        $myUserHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }

        /*
        \Log::info('leam usuario *** -> ' . $request->usuario);
        \Log::info('leam cliente *** -> ' . $request->cliente);
        \Log::info('leam wallet ***  -> ' . $request->wallet);
        \Log::info('leam wallet desde        *** -> ' . $myWalletDesde);
        \Log::info('leam wallet hasta        *** -> ' . $myWalletHasta);        
        \Log::info('leam wallet  hasta       *** -> ' . $myGroup);        
        \Log::info('leam group  desde        *** -> ' . $myGroupDesde);
        \Log::info('leam group  Hasta        *** -> ' . $myGroupHasta);     
        \Log::info('leam transaction         *** -> ' . $myTypeTransactions);
        \Log::info('leam transaction  desde  *** -> ' . $myTypeTransactionsDesde);
        \Log::info('leam transaction  Hasta  *** -> ' . $myTypeTransactionsHasta);              
        \Log::info('leam typeTransactions    *** -> ' . $request->typeTransactions);             
        \Log::info('leam token               ***   -> ' . $request->token);
        \Log::info('leam fecha desde         ***   -> ' . $myFechaDesde);
        \Log::info('leam fecha hasta         ***   -> ' . $myFechaHasta);
        \Log::info('leam fecha desde request ***   -> ' . $request->fechaDesde);
        \Log::info('leam fecha hasta request ***   -> ' . $request->fechaHasta);
        */

        //  print_r($myGroup);
         // dd($myGroup);
         $Transacciones = [];

        if ($myGroup != 0){
            $Transacciones = Transaction::select(
                'Transactions.id                        as Id',
                'Transactions.amount_foreign_currency   as MontoMoneda',
                'Transactions.exchange_rate             as TasaCambio',
                'Transactions.exchange_rate_base        as TasaCambioBase',
                'Transactions.type_coin_id              as TipoMonedaId',
                'type_coins.name                        as TipoMoneda',
                'users.name                             as AgenteName',
                'Transactions.amount                    as Monto',
                'Transactions.amount_total              as MontoTotal',
                'Transactions.percentage                as PorcentajeComision',
                'Transactions.amount_commission         as MontoComision',
                'Transactions.amount_total_base         as MontoTotalBase',
                'Transactions.amount_base               as MontoBase',
                'Transactions.percentage_base           as PorcentajeComisionBase',
                'Transactions.amount_commission_base    as MontoComisionBase',
                'Transactions.type_transaction_id       as TransactionId',
                'type_transactions.name                 as TipoTransaccion',
                'transactions.wallet_id                 as WalletId',
                'wallets.name                           as WalletName',              
                'transactions.description               as Descripcion',
                'transactions.transaction_date          as FechaTransaccion',
                'transactions.group_id                  as ClienteId',
                DB::raw('IFNULL(transactions.group_id, 0) as ClienteId2'),
                'groups.name                            as ClientName',
                'transactions.token                     as token'
            )->leftJoin(
                'users','users.id', '=', 'transactions.user_id'
            )->leftJoin(
                'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
            )->leftJoin(
                'groups as wallets', 'wallets.id', '=', 'transactions.wallet_id'
            )->leftJoin(
                'groups', 'groups.id', '=', 'transactions.group_id'
            )->leftJoin(
                'type_coins', 'type_coins.id', '=', 'transactions.type_coin_id'                  
            )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
            // )->whereBetween('Transactions.group_id',            [$myGroupDesde, $myGroupHasta]
            )->whereBetween('Transactions.wallet_id',           [$myWalletDesde, $myWalletHasta]
            )->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionsDesde, $myTypeTransactionsHasta]
            )->whereBetween('Transactions.transaction_date',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"]
            )->where('Transactions.status', '=', 'Activo'
            )->havingBetween('ClienteId2',[$myGroupDesde, $myGroupHasta]
            )->orderBy('Transactions.transaction_date','ASC')
            ->get();

            // $Transacciones2 = array();
            // foreach($Transacciones as $tran){
            //     $value1 = json_decode($tran);
    
            //     $value2 = array_values(json_decode(json_encode($tran), true));
    
            //     array_push($Transacciones2, $value2);
            // }
            // dd('aqui');

        }else {

            $myQuery =
            "
                select
                    Transactions.id                        as Id,
                    Transactions.amount_foreign_currency   as MontoMoneda,
                    Transactions.exchange_rate             as TasaCambio,
                    Transactions.exchange_rate_base        as TasaCambioBase,
                    Transactions.type_coin_id              as TipoMonedaId,
                    type_coins.name                        as TipoMoneda,
                    users.name                             as AgenteName,
                    Transactions.amount                    as Monto,            
                    Transactions.amount_total              as MontoTotal,
                    Transactions.percentage                as PorcentajeComision,
                    Transactions.amount_commission         as MontoComision,
                    Transactions.amount_base               as MontoBase,              
                    Transactions.amount_total_base         as MontoTotalBase,
                    Transactions.percentage_base           as PorcentajeComisionBase,
                    Transactions.amount_commission_base    as MontoComisionBase,
                    Transactions.type_transaction_id       as TransactionId,
                    type_transactions.name                 as TipoTransaccion,
                    transactions.wallet_id                 as WalletId,
                    wallets.name                           as WalletName,
                    transactions.description               as Descripcion,
                    transactions.transaction_date          as FechaTransaccion,
                    IFNULL(transactions.group_id,0)          as ClienteId,
                    mtf.groups.name                        as ClientName,
                    transactions.token                     as token
                from
                    mtf.transactions
                left join mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
                left join mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
                left join mtf.users               on mtf.transactions.user_id             = mtf.users.id
                left join mtf.type_coins          on mtf.transactions.type_coin_id        = mtf.type_coins.id
                left join mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
                where
                        status = 'Activo'
                    and user_id             between $myUserDesde                and $myUserHasta                        
                    and wallet_id           between $myWalletDesde              and $myWalletHasta
                    and type_transaction_id between $myTypeTransactionsDesde    and $myTypeTransactionsHasta
                    and transaction_date    between '$myFechaDesde  00:00:00'   and '$myFechaHasta 23:59:00' 
                    $myTokenCondition
                order by
                    Transactions.transaction_date ASC
                limit 300
            ";
    
            // dd($myQuery);
            // \Log::info('leam My query *** -> ' . $myQuery);
            $Transacciones = DB::select($myQuery);

        }

        //  dd($Transacciones);
        // \Log::info('index transacciones -> ' . print_r($Transacciones,true));
        // die();

        $userole            = $this->getUser();
        $wallet             = $this->getWallet();
        $group              = $this->getGroups();
        $typeTransactions   = $this->getTypeTransactions();

        if ($myFechaDesde === "2001-01-01"){
            $myFechadesdeInvertida = "";
        }else{
            $myFechaDesdeBefore     = $this->getDayBefore($myFechaDesde);
            $myFechadesdeInvertida  = substr($myFechaDesdeBefore,8,2) . "-" . substr($myFechaDesdeBefore,5,2) . "-" . substr($myFechaDesdeBefore,0,4);
        }

        $parametros['userole']                  = $userole;
        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;
        $parametros['typeTransactions']         = $typeTransactions;
        $parametros['Transacciones']            = $Transacciones;
        $parametros['myUser']                   = $myUser;
        $parametros['myGroup']                  = $myGroup;
        $parametros['myWallet']                 = $myWallet;
        $parametros['balance']                  = $balance;
        $parametros['myTypeTransactions']       = $myTypeTransactions;
        $parametros['myFechaDesde']             = $myFechaDesde;
        $parametros['myFechaHasta']             = $myFechaHasta;
        $parametros['balanceBefore']            = $balanceBefore;
        $parametros['myFechadesdeInvertida']    = $myFechadesdeInvertida;

        // dd($myFechadesdeInvertida);
        // \Log::info('leam ----> ' .  json_encode($Transacciones, JSON_PRETTY_PRINT));
        return view('estadisticas.index', $parametros);

    }
    /*
    *
    *
    *   Display a listing of the resource.
    *
    *
    */
    public function userDetail(Request $request)
    {

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }

        $myCliente = 0;
        if ($request->cliente) {
            $myCliente = $request->cliente;
        }


        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        // \Log::info('leam usuario *** -> ' . $request->usuario);
        // \Log::info('leam cliente *** -> ' . $request->cliente);
        // \Log::info('leam wallet *** -> ' . $request->wallet);


        $myUserDesde    = 0;
        $myUserHasta    = 9999;
        $myClienteDesde = 0;
        $myClienteHasta = 9999;
        $myWalletDesde  = 0;
        $myWalletHasta  = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($myCliente != 0){
            $myClienteDesde = $myCliente;
            $myClienteHasta = $myCliente;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
        }

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

        // echo $userole;
        $userole = array();
        foreach($userole2 as $user){
            $userole [$user->id] =  $user->name;
        }

        $Transacciones = Transaction::select(
        //  'Transactions.user_id as Id',
            'users.name as AgenteName',
            'Transactions.amount as Monto',
        //  'Transactions.type_transaction_id as TransactionId',
            'type_transactions.name as TipoTransaccion',
        //  'Transactions.client_id as ClienteId',
        //  'transactions.wallet_id As WalletId',
            'wallets.name As WalletName',
            'transactions.transaction_date as FechaTransaccion',
            'clients.name as ClientName',
        )->leftJoin(
            'users','users.id', '=', 'transactions.user_id'
        )->leftJoin(
            'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
        )->leftJoin(
            'wallets', 'wallets.id', '=', 'transactions.wallet_id'
        )->leftJoin(
            'clients', 'clients.id', '=', 'transactions.client_id'
        )->whereBetween('Transactions.user_id', [$myUserDesde, $myUserHasta]
        )->whereBetween('Transactions.client_id', [$myClienteDesde, $myClienteHasta]
        )->whereBetween('Transactions.wallet_id', [$myWalletDesde, $myWalletHasta]
        )->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta]
        )->get();

        $Transacciones2 = array();
        foreach($Transacciones as $tran){
            // echo " trans " . json_decode($tran);
            $value1 = json_decode($tran);

            $value2 = array_values(json_decode(json_encode($tran), true));

            array_push($Transacciones2, $value2);
        }


          $cliente = Client::select('clients.id', 'clients.name')
          ->get();

          //dd($cliente);

          //*********************************************************

          $cliente2 = array();
          foreach($cliente as $cliente){
              $cliente2 [$cliente->id] =  $cliente->name;
          }
          $cliente = $cliente2;

          //***********************************************************

          $wallet = Wallet::select('wallets.id', 'wallets.name')
          ->get();

          //dd($wallet);

          $wallet2 = array();
          foreach($wallet as $wallet){
              $wallet22 [$wallet->id] =  $wallet->name;
          }
          $wallet = $wallet22;

        return view('estadisticas.index', compact('myUser','userole','Transacciones','cliente','wallet','myCliente','myUser','myWallet'));

    }
    /*
    *
    *
    *       usersummary
    *
    *
    */
    public function userSummary(Request $request)
    {

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }

        $myUserDesde = 0;
        $myUserHasta = 9999;
        if ($request->usuario) {
            $myUserDesde = $request->usuario;
            $myUserHasta = $request->usuario;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

        // echo $userole;
        $userole = array();
        foreach($userole2 as $user){
            $userole [$user->id] =  $user->name;
        }

        $myUsers = DB::table('transactions')
            ->select(DB::raw('
                users.name as AgenteName,
                wallets.name As WalletName,
                type_transactions.name as TipoTransaccion,
                count(*)    as cant_transactions,
                sum(amount) as total_amount,
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('users','users.id', '=', 'transactions.user_id')
            ->leftJoin('wallets', 'wallets.id', '=', 'transactions.wallet_id')
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
            ->whereBetween('Transactions.user_id', [$myUserDesde, $myUserHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])
            ->groupBy('user_id', 'AgenteName', 'wallet_id', 'WalletName', 'type_transaction_id', 'TipoTransaccion')
            ->get();


            // dd($myUsers);

            $Transacciones = array();
            foreach($myUsers as $myValue){

                $value2 = json_encode($myValue);

                array_push($Transacciones, $value2);
            }

            $Transacciones = $myUsers;

            // dd($Transacciones);

        return view('estadisticas.statisticsResumenUsuario', compact('myUser','userole','Transacciones'));
        return $myUsers2;
    }
    /*
    *
    *
    *       clientSummary
    *
    *
    */
    public function clientSummary(Request $request)
    {

        $myCliente = 0;
        if ($request->cliente) {
            $myCliente = $request->cliente;
        }

        $myClienteDesde = 0;
        $myClienteHasta = 9999;


        if ($myCliente != 0){
            $myClienteDesde = $myCliente;
            $myClienteHasta = $myCliente;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

        // echo $userole;
        $userole = array();
        foreach($userole2 as $user){
            $userole [$user->id] =  $user->name;
        }

        //

        $cliente = Client::select('clients.id', 'clients.name')
        ->get();

        $cliente2 = array();
        foreach($cliente as $cliente){
            $cliente2 [$cliente->id] =  $cliente->name;
        }
        $cliente = $cliente2;

        //

        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                clients.name as ClientName,
                type_transactions.name as TipoTransaccion,
                count(*)    as cant_transactions,
                sum(amount) as total_amount,
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('clients','clients.id', '=', 'transactions.client_id')
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
            ->whereBetween('Transactions.client_id',        [$myClienteDesde, $myClienteHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])
            ->groupBy('ClientName', 'TipoTransaccion')
            ->get();


            // dd($Transacciones);

        return view('estadisticas.statisticsResumenCliente', compact('myCliente','cliente','Transacciones'));
        return $myUsers2;
    }
    /*
    *
    *
    *       clientSummary
    *
    *
    */
    public function fechaTokensSummary(Request $request)
    {

        $myCliente = 0;
        if ($request->cliente) {
            $myCliente = $request->cliente;
        }

        $myClienteDesde = 0;
        $myClienteHasta = 9999;


        if ($myCliente != 0){
            $myClienteDesde = $myCliente;
            $myClienteHasta = $myCliente;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        //
         

        $myFechaDesde = $myFechaDesde;
        $myFechaHasta = $myFechaHasta;

        // dd(" Fecha desde : " . $myFechaDesde . " Fecha Hasta : " . $myFechaHasta);

        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                substring(transaction_date,1,10)    as fechaTransaccion,
                count(*)                            as cant_transactions,
                sum(amount)                         as total_amount,
                sum(amount_commission)              as total_commission,
                sum(amount_total)                   as total'))
            ->where('status','<>','Anulado')
            ->where('token','<>','')
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:59"])
            ->groupBy('fechaTransaccion')
            ->orderBy('fechaTransaccion', 'DESC')
            ->get();


            //    dd($Transacciones);

        return view('estadisticas.statisticsFechaTokens', compact('Transacciones', 'myFechaDesde', 'myFechaHasta'));
        return $myUsers2;
    }

    /*
    *
    *
    *   walletSummary
    *
    *
    */
    public function walletSummary(Request $request) {

        $myWallet       = ($request->wallet)        ? $request->wallet : 0;
        $fechaDesde     = ($request->fechaDesde)    ? $request->fechaDesde : '2001-01-01';  
        $fechaHasta     = ($request->fechaHasta)    ? $request->fechaHasta : '9999-12-31';


        $Transacciones  = $this->getBalanceWallet($myWallet, $fechaDesde, $fechaHasta);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $wallets            = $this->getWallet();

        return view('estadisticas.statisticsResumenWallet', compact('myWallet', 'wallets', 'Transacciones'));
    }
   /*
    *
    *
    *   getwalletSummary
    *
    *
    */
     function getWalletSummary(Request $request) {

        $myWallet       = ($request->wallet)        ? $request->wallet : 0;
        $fechaDesde     = ($request->fechaDesde)    ? $request->fechaDesde : '2001-01-01';  
        $fechaHasta     = ($request->fechaHasta)    ? $request->fechaHasta : '9999-12-31';

        // dd($fechaDesde . " - " . $fechaHasta);
        $Transacciones  = $this->getBalanceWallet($myWallet, $fechaDesde, $fechaHasta);
        // dd($Transacciones);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        return $Transacciones;
    }

    /*
    *
    *
    *   walletSummaryMaster
    *
    *
    */
    public function walletSummaryMaster(Request $request) {

        $myWallet       = ($request->wallet) ? $request->wallet : 0;
        $master         = true;

        $Transacciones  = $this->getBalanceWallet($myWallet);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $wallets            = $this->getWallet();

        return view('estadisticas.statisticsResumenWalletMaster', compact('myWallet', 'wallets', 'Transacciones','master'));
    }    
    /*
    *
    *
    *       walletTransactionSummary
    *       
    *
    */
    public function walletTransactionSummary(Request $request)
    {
        // dd($request->transaction);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //
        $theDate = date('Y-m-d');
        \Log::info('leam - walletTransactionSummary ->' . $theDate);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        $myFechaHasta = date('Y-m-d');

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";
        $myFechaHasta2 = date('Y-m-d');

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
        // var_dump($myFechaDesde);
        // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta);

       //
       $myWalletDesde   = 0;
       $myWalletHasta   = 9999;
       $myWallet        = 0;
       if ($request->wallet){
           $myWalletDesde   = $request->wallet;
           $myWalletHasta   = $request->wallet;
           $myWallet        = $request->wallet;
       }

        $Transacciones          = $this->getWalletTransactionSummary($request);

        $balance = 0;
        if ($myWallet > 0){
                $balance2 = $this->getBalanceWallet($myWallet);
                
                if(isset($balance2->Total)){
                    $balance  = $balance2->Total;
                }
            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
        };
        // dd($balance);
    
        $Type_transactions  = $this->getTypeTransactions();
        $wallet             = $this->getWallet();

        // dd($Transacciones);             
        // dd($Transacciones2);
        $parametros['myWallet']             = $myWallet;
        $parametros['wallet']               = $wallet;
        $parametros['myTypeTransaction']    = $myTypeTransaction;
        $parametros['Type_transactions']    = $Type_transactions;
        $parametros['Transacciones']        = $Transacciones;
        $parametros['myFechaDesde']         = $myFechaDesde;
        $parametros['myFechaHasta']         = $myFechaHasta;
        $parametros['balance']              = $balance;

        \Log::info('leam - statisticscontroller - myFechaDesde ->' . $myFechaDesde);
        \Log::info('leam - statisticscontroller - myFechaHasta ->' . $myFechaHasta);

        return view('estadisticas.statisticsResumenWalletTransaccion', $parametros);
    }
    /*
    *
    *
    *       walletTransactionGroupSummary
    *       ajuax
    *
    */
    public function walletTransactionGroupSummary(Request $request)
    {
        $indRecibeFecha = 0;
        // dd($request->transaction);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //
        
        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";
        
        if ($request->fechaDesde){
            $indRecibeFecha = 1;
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
        // var_dump($myFechaDesde);
        // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta . ' indRecibeFecha -> ' . $indRecibeFecha);

       //
        $myWallet        = 0;
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;

        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde   = 0;
        $myGrouptHasta  = 9999;

        if ($request->group){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
            $myGroup        = $request->group;
        }

        // $Transacciones1         = $this->getWalletTransactionSummary($request);
        $Transacciones2         = $this->getWalletTransactionGroupSummary($request);
        $groups                 = $this->getGroups();

        // $this->getWalletTransactionGroupTotal($Transacciones1, $Transacciones2);

        $Transacciones       = $Transacciones2;

        // dd($Transacciones);

        $balance = 0;
        if ($myWallet > 0){
            $balance2 = $this->getBalanceWallet($myWallet);
            if(isset($balance2->Total)){
                $balance  = $balance2->Total;
            }
            // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
        };
        // dd($balance);
        // ajuax
        $balanceDetail = 0;
        // Resto 1 dia a la fecha desde
        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = $this->getDayBefore($myFechaDesde);

        if ($indRecibeFecha == 1){
            $balanceDetail = 0;
            if ($myWallet > 0){
                // dd($indRecibeFecha);                
                
                $balance3 = $this->getBalanceWallet($myWallet, $myFechaDesde, $myFechaHasta);
                if(isset($balance3->Total)){
                    $balanceDetail  = $balance3->Total;
                }
                // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
                //  dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta . ' indRecibeFecha -> ' . $indRecibeFecha . ' balance detail -> ' . $balanceDetail . ' ' . $myFechaHastaBefore . ' ' . $myFechaDesdeBefore);
            };
        }
        $Type_transactions  = $this->getTypeTransactions();
        $wallet             = $this->getWallet();

        // dd($Transacciones2); 
        // dd($Transacciones2);

        return view('estadisticas.statisticsResumenWalletTransaccionGroup', compact('myWallet','wallet','myTypeTransaction', 'Type_transactions', 'Transacciones','myFechaDesde','myFechaHasta','balance','groups', 'myGroup','balanceDetail','myFechaDesdeBefore', 'myFechaDesdeBefore'));

    }    
    /*
    *
    *
    *       walletGroupTransactionSummary
    *       ajua
    *
    */
    public function walletGroupTransactionSummary(Request $request)
    {
        // dd($request->transaction);

        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        $myGroup        = 0;
        if ($request->group){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
            $myGroup        = $request->group;
        }
 
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
        // var_dump($myFechaDesde);
        // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta);

       //


       $balance = 0;
       if ($myGroup > 0){
              $balance2 = $this->getBalanceGroup($myGroup);
              $balance  = $balance2->Total;
           // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
       };
       // dd($balance);

        $Type_transactions  = $this->getTypeTransactions();
        $group              = $this->getGroups();
        $wallet             = $this->getWallet();

        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                wallet_id                   as WalletId,
                wallets.name                as WalletName,
                group_id                    as GroupId,
                groups.name                 as GroupName,
                type_transaction_id         as TypeTransactionId,
                type_transactions.name      as TypeTransaccionName,
                count(*)                    as cant_transactions,
                sum(amount)                 as total_amount,
                sum(amount_base)            as total_amount_base,
                sum(amount_commission)      as total_commission,
                sum(amount_commission_base) as total_amount_commission_base,
                sum(amount_total)           as total,
                sum(amount_total_base)      as total_Base,
                (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit,
                '
                ))
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
            ->leftJoin('wallets',           'wallets.id', '=', 'transactions.wallet_id')
            ->leftJoin('groups',            'groups.id', '=', 'transactions.group_id')            
            ->where('status','<>','Anulado')
            ->whereBetween('Transactions.wallet_id',            [$myWalletDesde, $myWalletHasta])
            ->whereBetween('Transactions.group_id',             [$myGroupDesde, $myGroupHasta])            
            ->whereBetween('Transactions.type_transaction_id',  [$myTypeTransactionDesde, $myTypeTransactionHasta])
            ->whereBetween('Transactions.transaction_date',     [$myFechaDesde2, $myFechaHasta2])
            ->groupBy('WalletId', 'WalletName', 'GroupId', 'GroupName','TypeTransactionId', 'TypeTransaccionName')
            ->orderBy('WalletId','ASC')
            ->orderBy('GroupId','ASC')
            ->orderBy('TypeTransactionId','ASC')
            ->get();


        // dd($Transacciones);

        return view('estadisticas.statisticsResumenWalletGroupTransaccion', compact('myWallet','wallet','myGroup','group','myTypeTransaction', 'Type_transactions', 'Transacciones','myFechaDesde','myFechaHasta','balance'));

    }


    public function getWalletTransactionSummary(Request $request){
        // dd($request);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            // dd($request->transaction);
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

            if ($request->transaction == 0){
                $myTypeTransaction      = 0;
                $myTypeTransactionDesde = 0;
                $myTypeTransactionHasta = 9999;   
            }

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        $myFechaHasta = date('Y-m-d');

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";
        $myFechaHasta2 = date('Y-m-d');

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
            // var_dump($myFechaDesde);
            // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta);

        //
        // dd($request->wallet);

        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $Transacciones = DB::table('transactions')
            ->select(DB::raw("
                wallet_id                       as WalletId,
                wallets.name                    as WalletName,
                type_transaction_id             as TypeTransactionId,
                type_transactions.name          as TypeTransaccionName,
                1                               as ItemGroup,                      
                ''                              as GroupId,
                ''                              as GroupName,                
                count(*)                        as cant_transactions,
                sum(amount)                     as total_amount,                
                sum(amount_commission_base)     as total_amount_commission_base,
                sum(amount_commission)          as total_commission,
                sum(amount_base)                as total_amount_base,                
                sum(amount_total_base)          as total_Base,                
                sum(amount_commission_profit)   as total_commission_profit,
                (IFNULL(sum(amount_commission),0) - IFNULL(sum(amount_commission_base),0)) as total_commission_profit_2,
                sum(amount_total)               as total,
                sum(case 
				    when percentage is null and exchange_rate is not null  then amount_commission_profit
				    when percentage is null and exchange_rate is null then 0
			        end )
                as exchange_profit"
                )
                )
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
            ->leftJoin('groups as wallets',           'wallets.id', '=', 'transactions.wallet_id')
            ->where('status','<>','Anulado')
            ->whereBetween('Transactions.wallet_id',            [$myWalletDesde, $myWalletHasta])
            ->whereBetween('Transactions.type_transaction_id',  [$myTypeTransactionDesde, $myTypeTransactionHasta])
            ->whereBetween('Transactions.transaction_date',     [$myFechaDesde2, $myFechaHasta2])
            ->groupBy('WalletId', 'WalletName', 'TypeTransactionId', 'TypeTransaccionName')
            ->orderBy('WalletId','ASC')
            ->orderBy('TypeTransactionId','ASC')
            ->get();
        // dd($Transacciones);
        return $Transacciones;
    }
    
    /*
    *
    *
    * 
    *
    *
    */
    public function getWalletTransactionGroupSummary(Request $request){
        // dd($request->wallet);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
        // var_dump($myFechaDesde);
        // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta);

       //
       $myWalletDesde   = 0;
       $myWalletHasta   = 9999;
       $myWallet        = 0;
       if ($request->wallet){
           $myWalletDesde   = $request->wallet;
           $myWalletHasta   = $request->wallet;
           $myWallet        = $request->wallet;
       }
       
       $myGroupDesde   = 0;
       $myGroupHasta   = 9999;
       $myGroup        = 0;
       $condicionGroup = "";
       if ($request->group){
           $myGroupDesde   = $request->group;
           $myGroupHasta   = $request->group;
           $myGroup        = $request->group;
           $condicionGroup = " and     Transactions.group_id        between  $myGroupDesde    and     $myGroupHasta";
       }

       
        $myQuery =
        "
        select
            wallet_id                       as WalletId,
            wallets.name                    as WalletName,
            type_transaction_id             as TypeTransactionId,
            type_transactions.name          as TypeTransaccionName,                       
            group_id                        as GroupId,
            groups.name                     as GroupName,
            count(*)                        as cant_transactions,
            sum(amount)                     as total_amount,
            sum(amount_base)                as total_amount_base,
            sum(amount_commission)          as total_commission,
            sum(amount_commission_base)     as total_amount_commission_base,
            sum(amount_total)               as total,
            sum(amount_total_base)          as total_Base,
            sum(amount_commission_profit)   as total_commission_profit,
            (IFNULL(sum(amount_commission),0) - IFNULL(sum(amount_commission_base),0)) as total_commission_profit_2,
			sum(case 
				when percentage is null and exchange_rate is not null  then amount_commission_profit
				when percentage is null and exchange_rate is null then 0
			end )
            as exchange_profit               
        from mtf.transactions
            left join  mtf.groups as wallets    on wallet_id                = mtf.wallets.id
            left join  mtf.groups               on group_id                 = mtf.groups.id
            left join  mtf.type_transactions    on type_transaction_id      = mtf.type_transactions.id     
        where        
                mtf.Transactions.status <> 'Anulado'
        and     mtf.Transactions.wallet_id             between  $myWalletDesde              and     $myWalletHasta
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde     and     $myTypeTransactionHasta      
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 23:59:00'
        $condicionGroup                  
        group by
            WalletId,
            WalletName,
            TypeTransactionId,
            TypeTransaccionName,
            GroupId,
            GroupName
        order by
            WalletName,
            TypeTransaccionName,
            GroupName            
        ";
       
       /*
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde and     $myTypeTransactionHasta
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 59:59:99'
       */

       // dd($myQuery);

        $Transacciones = DB::select($myQuery);
       // dd($Transacciones);
       //  \Log::info('leam *** $myQUery -> ' . $myQuery);       
       //  \Log::info('leam *** $Transacciones3 -> ' . print_r($Transacciones3,true));
       
       return $Transacciones;

    }



    public function getTransactionSummary(Request $request){
        // dd($request);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }

        $myQuery =
        "
        select
            0                             as WalletId,
            ''                            as WalletName,
            type_transaction_id           as TypeTransactionId,
            type_transactions.name        as TypeTransaccionName,
            count(*)                      as cant_transactions,
            sum(amount)                   as total_amount,
            sum(amount_base)              as total_amount_base,
            sum(amount_commission)        as total_commission,
            sum(amount_commission_base)   as total_amount_commission_base,
            sum(amount_total)             as total,
            sum(amount_total_base)        as total_Base,
            sum(amount_commission_profit) as total_commission_profit,
            (IFNULL(sum(amount_commission),0) - IFNULL(sum(amount_commission_base),0)) as amount_commission_profit_2,
			sum(case 
				when percentage is null and exchange_rate is not null  then amount_commission_profit
				when percentage is null and exchange_rate is null then 0
			end )
            as exchange_profit               
        from mtf.transactions
            left join  mtf.type_transactions    on type_transaction_id      = mtf.type_transactions.id     
        where        
                mtf.Transactions.status                 <> 'Anulado'
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde     and     $myTypeTransactionHasta      
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 23:59:00'         
        group by
            WalletId,
            WalletName,
            TypeTransactionId,
            TypeTransaccionName
        ";

       /*
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde and     $myTypeTransactionHasta
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 59:59:99'
       */

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);
        // dd($Transacciones);
        // \Log::info('leam *** $myQUery -> ' . $myQuery);       
        // \Log::info('leam *** $Transacciones3 -> ' . print_r($Transacciones3,true));
       
        return $Transacciones;

    }

    

    public function getTransactionGroupSummary(Request $request){
        // dd($request);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }



        
        $myQuery =
        "
        select
            0                                   as WalletId,
            ''                                  as WalletName,
            type_transaction_id                 as TypeTransactionId,
            type_transactions.name              as TypeTransaccionName,    
            group_id                            as GroupId,
            groups.name                         as GroupName,
            count(*)                            as cant_transactions,
            sum(amount)                         as total_amount,
            sum(amount_base)                    as total_amount_base,
            sum(amount_commission)              as total_commission,
            sum(amount_commission_base)         as total_amount_commission_base,
            sum(amount_total)                   as total,
            sum(amount_total_base)              as total_Base,
            sum(amount_commission_profit)       as total_commission_profit,
            (IFNULL(sum(amount_commission),0) - IFNULL(sum(amount_commission_base),0)) as amount_commission_profit_2,
			sum(case 
				when percentage is null and exchange_rate is not null  then amount_commission_profit
				when percentage is null and exchange_rate is null then 0
			end )
            as exchange_profit                    
        from mtf.transactions
            left join  mtf.groups               on group_id                 = mtf.groups.id
            left join  mtf.type_transactions    on type_transaction_id      = mtf.type_transactions.id     
        where        
                mtf.Transactions.status                 <> 'Anulado'
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde     and     $myTypeTransactionHasta      
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 23:59:00'         
        group by
            TypeTransactionId,
            TypeTransaccionName,
            GroupId,
            GroupName
        ";

       /*
        and     mtf.Transactions.type_transaction_id   between  $myTypeTransactionDesde and     $myTypeTransactionHasta
        and     mtf.Transactions.transaction_date      between  '$myFechaDesde2 00:00:00'   and     '$myFechaHasta2 59:59:99'
       */

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);
        // dd($Transacciones);
        // \Log::info('leam *** $myQUery -> ' . $myQuery);       
        // \Log::info('leam *** $Transacciones3 -> ' . print_r($Transacciones3,true));
       
        return $Transacciones;

    }

    //
    public function getWalletGroups(Request $request){
        // dd($request->wallet);
        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;
        if ($request->transaction) {
            $myTypeTransaction      = $request->transaction;
            $myTypeTransactionDesde = $request->transaction;
            $myTypeTransactionHasta = $request->transaction;

        }

        //

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $myFechaDesde2 = "2001-01-01";
        $myFechaHasta2 = "9999-12-31";

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde2 = $myFechaDesde . " 00:00:00";
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 23:59:00";            
        }
        // var_dump($myFechaDesde);
        // dd('Fecha desde -> ' . $myFechaDesde . ' Fecha Hasta -> ' . $myFechaHasta);

       //
       $myWalletDesde   = 0;
       $myWalletHasta   = 9999;
       $myWallet        = 0;
       if ($request->wallet){
           $myWalletDesde   = $request->wallet;
           $myWalletHasta   = $request->wallet;
           $myWallet        = $request->wallet;
       }
       
       $myGroupDesde   = 0;
       $myGroupHasta   = 9999;
       $myGroup        = 0;
       if ($request->group){
           $myGroupDesde   = $request->group;
           $myGroupHasta   = $request->group;
           $myGroup        = $request->group;
       }      

        $Transacciones = DB::table('transactions')
        ->select(DB::raw('
            wallet_id                   as WalletId,
            wallets.name                as WalletName,      
            group_id                    as GroupId,
            groups.name                 as GroupName,
            count(*)                    as cant_transactions
            '
            ))
        ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
        ->leftJoin('groups as wallets', 'wallets.id', '=', 'transactions.wallet_id')
        ->leftJoin('groups',            'groups.id', '=', 'transactions.group_id')            
        ->where('status','<>','Anulado')
        ->whereBetween('Transactions.wallet_id',            [$myWalletDesde, $myWalletHasta])
        ->whereBetween('Transactions.group_id',             [$myGroupDesde, $myGroupHasta])            
        ->whereBetween('Transactions.type_transaction_id',  [$myTypeTransactionDesde, $myTypeTransactionHasta])
        ->whereBetween('Transactions.transaction_date',     [$myFechaDesde2, $myFechaHasta2])
        ->groupBy('WalletId', 'WalletName', 'GroupId', 'GroupName')
        ->orderBy('WalletId','ASC')
        ->orderBy('GroupId','ASC')
        ->get();

       return $Transacciones;

    }



    //
    // ajua
    //
    public function getWalletTransactionGroupTotal($Transacciones, $Transacciones2){
        // dd($Transacciones);
        // dd($Transacciones2);       

        foreach($Transacciones as $Tran){

            foreach($Transacciones2 as $Tran2){
                if (
                    $Tran->WalletId             == $Tran2->WalletId 
                and $Tran->TypeTransactionId    == $Tran2->TypeTransactionId               
                ){

                    $Tran2->cant_transactions_wallet            = $Tran->cant_transactions;
                    $Tran2->total_amount_wallet                 = $Tran->total_amount;
                    $Tran2->total_amount_commission_base_wallet = $Tran->total_amount_commission_base;
                    $Tran2->total_commission_wallet             = $Tran->total_commission;
                    $Tran2->total_commission_profit_wallet      = $Tran->total_commission_profit;
                    $Tran2->total_wallet                        = $Tran->total;
                };
            };

         // dd($Transacciones);

        // die();
    
        }
    }
    /*
    *
    *
    *       groupSummary
    *       resumen por grupo
    *
    */
    public function groupSummary(Request $request)
    {
        

        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
        }

        $myHoraDesde = "00:00:00";
        $myHoraHasta = "23:59:00";

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        $myFechaHasta = date('Y-m-d');
        
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde;
            $myFechaHasta = $myFechaHasta;


        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta;           
        }
        
       /* 
        $Transacciones      = $this->getBalance($myGroup, $myFechaDesde, $myFechaHasta);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }
        */

        $Transacciones = $this->getGroupSummary($request);


        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups();


        $parametros['myGroup']                  = $myGroup;
        $parametros['groups']                   = $groups;
        $parametros['Type_transactions']        = $Type_transactions;
        $parametros['Transacciones']            = $Transacciones;
        $parametros['myFechaDesde']             = $myFechaDesde;
        $parametros['myFechaHasta']             = $myFechaHasta;
        // return view('estadisticas.statisticsResumenGrupo', compact('myGroup','groups','Type_transactions','Transacciones'));

        return view('estadisticas.statisticsResumenGrupo', $parametros);
    }


    function getGroupSummary(Request $request){

        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
        }

        $myHoraDesde = "00:00:00";
        $myHoraHasta = "23:59:00";

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        $myFechaHasta = date('Y-m-d');

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde;
            $myFechaHasta = $myFechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta;           
        }
        
        
        $Transacciones      = $this->getBalance($myGroup, $myFechaDesde, $myFechaHasta);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }       
            
        return $Transacciones;

    }

    /*
    *
    *
    *       groupSummaryWallet
    *       resumen por grupo wallet
    *
    */
    public function groupSummaryWallet(Request $request)
    {
        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
        }



        $myHoraDesde = "00:00:00";
        $myHoraHasta = "23:59:00";

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde;
            $myFechaHasta = $myFechaHasta;


        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta;           
        }
        
        
        $Transacciones      = $this->getBalance($myGroup, $myFechaDesde, $myFechaHasta);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups();


        $parametros['myGroup']                  = $myGroup;
        $parametros['groups']                   = $groups;
        $parametros['Type_transactions']        = $Type_transactions;
        $parametros['Transacciones']            = $Transacciones;
        $parametros['myFechaDesde']             = $myFechaDesde;
        $parametros['myFechaHasta']             = $myFechaHasta;
        // return view('estadisticas.statisticsResumenGrupo', compact('myGroup','groups','Type_transactions','Transacciones'));

        return view('estadisticas.statisticsResumenGrupoWallet', $parametros);
    }    
    /*
    *
    *
    *       conciliationSummaryDateGroup
    *
    *
    */

    public function conciliationSummaryDateGroup(Request $request)
    {
        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
        }

        $myGroupDesde = 0;
        $myGroupHasta = 9999;


        if ($myGroup != 0){
            $myGroupDesde = $myGroup;
            $mygroupHasta = $myGroup;
        }



        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }




        $Transacciones = DB::select("
        select
            fecha       as Fecha,
            grupo		as GrupoId,
            grupo_des	as Grupo,
            sum(cant) 	as CantTrans,
            sum(monto) 	as MontoTrans,
            sum(cant2) 	as CantMaster,
            sum(monto2) as MontoMaster,
            (sum(cant) - sum(cant2)) as Cant,
            (sum(monto) - sum(monto2)) as Monto
        from(
            select
                myTransactions.transaction_date 		as fecha,
                myTransactions.group_id 				as grupo,
                mtf.groups.name							as grupo_des,
                count(myTransactions.transaction_date) 	as cant,
                sum(myTransactions.amount_total) 		as monto,
                0 										as cant2,
                0										as monto2
            from mtf.transactions as myTransactions
            left join  mtf.groups on myTransactions.group_id  = mtf.groups.id
            group by
                myTransactions.transaction_date,
                myTransactions.group_id,
                mtf.groups.name
            union
            select
                myTransactions.transaction_date 		as fecha,
                myTransactions.group_id 				as grupo,
                mtf.groups.name							as grupo_des,
                0 										as cant,
                0										as monto,
                count(myTransactions.transaction_date) 	as cant2,
                sum(myTransactions.amount_total) 		as monto2
            from mtf.transaction_masters 				as myTransactions
            left join  mtf.groups on myTransactions.group_id  = mtf.groups.id
            group by
                myTransactions.transaction_date,
                myTransactions.group_id,
                mtf.groups.name
        ) as t
        where
            grupo between " . $myGroupDesde . " and " . $myGroupHasta . "
            and
            fecha between '0000-01-01' and '9999-12-31'
        group by
            fecha,
            grupo,
            grupo_des
        ");

        $groups = $this->getGroups();

        // dd($Transacciones);

        return view('estadisticas.statisticsResumenConciliacionFechaGrupo', compact('myGroup','groups', 'Transacciones'));

    }
    /*
    *
    *
    *       conciliationSummaryDate
    *
    *
    */
    public function conciliationSummaryDate(Request $request)
    {

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }


        $Transacciones = DB::select("
        select
            fecha						as Fecha,
            sum(cant) 					as CantTrans,
            sum(monto) 					as MontoTrans,
            sum(cant2) 					as CantMaster,
            sum(monto2) 				as MontoMaster,
            (sum(cant) - sum(cant2)) 	as Cant,
            (sum(monto) - sum(monto2)) 	as Monto
        from(
            select
                myTransactions.transaction_date 		as fecha,
                count(myTransactions.transaction_date) 	as cant,
                sum(myTransactions.amount_total) 		as monto,
                0 										as cant2,
                0										as monto2
            from mtf.transactions as myTransactions
            group by
                myTransactions.transaction_date
            union
            select
                myTransactions.transaction_date 		as fecha,
                0 										as cant,
                0										as monto,
                count(myTransactions.transaction_date) 	as cant2,
                sum(myTransactions.amount_total) 		as monto2
            from mtf.transaction_masters as myTransactions
            group by
                myTransactions.transaction_date
        ) as t
        group by
            fecha
        ");

        // dd($Transacciones);

        return view('estadisticas.statisticsResumenConciliacionFecha', compact('Transacciones'));

    }
    /*

        Carga los grupos id y nombre

    */
    function getGroups(){

        $group = Group::select('groups.id', 'groups.name')
                ->where('type','=','1')
                ->orderBy('groups.name')
                ->get();

        $group2 = array();
        foreach($group as $gr){
            $group2 [$gr->id] =  $gr->name;
        }
        return $group2;
    }
    /*
    *
    *    getSuppliers
    *
    */
    function getSuppliers(){
        $supplier = Supplier::select('suppliers.id', 'suppliers.name')
        ->get();

        $supplier2 = array();
        foreach($supplier as $supplier){
            $supplier2 [$supplier->id] =  $supplier->name;
        }
        return $supplier2;
    }
    /*
    *
    *
    *    Carga los tipos de transacciones
    *
    *
    */
    function getTypeTransactions(){
        $Type_transactions = Type_transaction::select('type_transactions.id', 'type_transactions.name')
        ->get();
        $Type_transactions2 = array();
        foreach($Type_transactions as $Type_transactions){
            $Type_transactions2 [$Type_transactions->id] =  $Type_transactions->name;
        }
        return $Type_transactions2;
    }
        /*
    *
    *
    *   getWalletDetail
    *
    *
    */
    function getWalletDetail($myWallet = 0){
        $wallet = Group::select('groups.id', 'groups.name')
        ->find($myWallet);
        return $wallet;

    }
    /*
    *
    *
    *   getWallet
    *
    *
    */
    function getWallet(){
        $wallet = Group::select('groups.id', 'groups.name')->where('type','=','2')->orderBy('groups.name')
        ->get();
        // dd($wallet);
        foreach($wallet as $wallet){
           $wallet2 [$wallet->id] =  $wallet->name;
        }
        return $wallet2;

    }
    /*
    *
    *
    *   getWalletUSDT
    *
    *
    */
    function getWalletUSDT(){
        $wallet = Group::select('groups.id', 'groups.name')
            ->where('type','=','2')
            ->where('type','=','2')
            ->where('name','like','%USDT%')
            ->where('name','like','%usdt%')
            ->orderBy('groups.name')
        ->get();
        // dd($wallet);
        foreach($wallet as $wallet){
           $wallet2 [$wallet->id] =  $wallet->name;
        }
        return $wallet2;

    }    
    /*
    *
    *
    *    getClient
    *
    *
    */
    function getClient(){
        $cliente2 = array();
        foreach($cliente as $cliente){
            $cliente2 [$cliente->id] =  $cliente->name;
        }
        return $cliente2;
    }
    /*
    *
    *
    *   getUser
    *
    *
    */
    function getUser(){
        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->get();

        $userole = array();
        foreach($userole2 as $user){
            $userole [$user->id] =  $user->name;
        }
        return $userole;
    }
    /*
    *
    *
    *       getBalance
    *
    *
    */
    function getBalance($grupo = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31"){

        if ($grupo === 0){
            $grupoDesde = 00000;
            $grupoHasta = 99999;

        }else{
            $grupoDesde = $grupo;
            $grupoHasta = $grupo;
        }
        //\Log::info('leam getBalance grupo        *** -> ' . $grupo);
        //\Log::info('leam getBalance grupoDesde   *** -> ' . $grupoDesde);
        //\Log::info('leam getBalance grupoHasta   *** -> ' . $grupoHasta);
        //\Log::info('leam getBalance myFechaDesde *** -> ' . $myFechaDesde);
        //\Log::info('leam getBalance myFechaHasta *** -> ' . $myFechaHasta);


        $myTempCredits  = $this->getCredits();
        $myTempDebits   = $this->getDebits();

        $myQuery =
        "
        select
            IdGrupo             as IdGrupo,
            NombreGrupo         as NombreGrupo,
            sum(Cant)   as Cant,
            sum(MontoCreditos)  as Creditos,
            sum(MontoDebitos)   as Debitos,
            (sum(MontoCreditos) - sum(MontoDebitos) ) as Total
        from(
            SELECT
                group_id                as IdGrupo,
                mtf.groups.name         as NombreGrupo,
                count(amount_total)     as Cant,
                0 				        as MontoCreditos,
                sum(amount_total)       as MontoDebitos
            FROM mtf.transactions
            left join  mtf.groups on mtf.transactions.group_id  = mtf.groups.id
            where
                type_transaction_id in ($myTempDebits)
                and
                transaction_date between '$myFechaDesde 00:00:00' and '$myFechaHasta 23:59:00'
                and
                group_id between $grupoDesde and $grupoHasta
                and status <> 'Anulado'
                and mtf.groups.type = 1
            group by
                IdGrupo,
                NombreGrupo
        union
            SELECT
                group_id            as IdGrupo,
                mtf.groups.name     as NombreGrupo,
                count(amount_total)     as Cant,
                sum(amount_total)   as MontoCreditos,
                0                   as MontoDebitos
            FROM mtf.transactions
            left join  mtf.groups on mtf.transactions.group_id  = mtf.groups.id
            where
                type_transaction_id in($myTempCredits)
                and
                transaction_date between '$myFechaDesde 00:00:00' and '$myFechaHasta 23:59:00'
                and
                group_id between $grupoDesde and $grupoHasta
                and status <> 'Anulado'
                and mtf.groups.type = 1            
            group by
                IdGrupo,
                NombreGrupo

        )
        as t
        group by
            IdGrupo,
            NombreGrupo
        order by 
            NombreGrupo
        ";

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);

        // \Log::info('leam grupo query  *** -> ' . print_r($myQuery,true));
        // \Log::info('leam grupo transacciones *** -> ' . print_r($Transacciones,true));

        if (empty($Transacciones)) {
            // \Log::info('leam vacio *** -> ' . print_r($Transacciones,true));
            return $Transacciones;
        }else {
            // \Log::info('*** leam gettype -> ' . gettype($Transacciones));
            if ($grupoDesde === $grupoHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    /*
    *
    *
    *       getBalanceWalletBefore
    *
    *
    */
    function getBalanceBefore($myGroup = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31"){



        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        $balance3           = 0;
        $balanceDetail      = 0;

        if ($myFechaDesde === "2001-01-01"){
            
            return $balanceDetail;
        }



        if ($myGroup > 0){
            // dd($indRecibeFecha);      
            if ($myFechaDesde != "2001-01-01"){

                $myFechaHastaBefore = $this->getDayBefore($myFechaDesde);

            }
            
        

            $balance3           = $this->getBalance($myGroup, $myFechaDesdeBefore, $myFechaHastaBefore);
            // dd('las fechas - ' . $balance3->Total . ' grupo ' . $myGroup . 'fecha desde -> ' . $myFechaDesdeBefore . ' fecha hasta -> ' . $myFechaHastaBefore);
            if(isset($balance3->Total)){
                $balanceDetail  = $balance3->Total;
            }else{
                $balanceDetail = 0;
            }
        }

        return $balanceDetail;   
    }    
    /*
    *
    *
    *       getBalanceWalletBefore
    *
    *
    */
    function getBalanceWalletBefore($myWallet = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31"){

        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        $balance3 = 0;

        $balanceDetail = 0;

        if ($myFechaDesde === "2001-01-01"){
            return $balanceDetail;
        }

        if ($myWallet > 0){
            // dd($indRecibeFecha);                
            if ($myFechaDesde != "2001-01-01"){

                $myFechaHastaBefore = $this->getDayBefore($myFechaDesde);

            }
            $balance3           = $this->getBalanceWallet($myWallet, $myFechaDesdeBefore, $myFechaHastaBefore);
            if(isset($balance3->Total)){
                $balanceDetail  = $balance3->Total;
            }else{
                $balanceDetail = 0;
            }
            return $balanceDetail;

        }        
    }
    /*
    *
    *
    *       getBalanceWallet
    *
    *
    */
    function getBalanceWallet($wallet = 0, $fechaDesde = "2001-01-01", $fechaHasta = "9999-12-31"){

        if ($wallet === 0){
            $walletDesde = 00000;
            $walletHasta = 99999;

        }else{
            $walletDesde = $wallet;
            $walletHasta = $wallet;
        }
        // \Log::info('leam wallet      getBalanceWallet *** -> ' . $wallet);        
        // \Log::info('leam fecha Desde getBalanceWallet *** -> ' . $fechaDesde); 
        // \Log::info('leam fecha Hasta getBalanceWallet *** -> ' . $fechaHasta); 
        
        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $fechaDesde . $horaDesde;
        $myFechaHasta = $fechaHasta . $horaHasta;

        $myTable = "mtf.transactions";

        $myTempCredits  = $this->getWalletCredits();
        $myTempDebits   = $this->getWalletDebits();
         // dd("wallet debits ->" . $myTempDebits . " wallet credits ->" . $myTempCredits ); // ajuax
         
        //
        // 26-04-2023
        //
        // Debitos
        //  4 cobro en efectivo
        //  8 Nota de debito
        //  2 cobro transferencia
        //  6 Nota de credito a caja
        //
        // Creditos
        //  1 transferencia
        //  3 pago en efectivo
        //  5 mercancia
        //  7 notas de credito
        //  9 switft
        //  11 pago usdt
        //
        $myQuery =
        "
        select
            IdWallet                                        as IdWallet,
            NombreWallet                                    as NombreWallet,
            sum(MontoCreditos)                              as Creditos,
            sum(MontoDebitos)                               as Debitos,
            sum(MontoComision)                              as Comision,
            sum(MontoComisionBase)                          as ComisionBase,
            (sum(MontoCreditos) - sum(MontoDebitos) )       as Total,
            sum(MontoComisionProfit)                        as ComisionGanancia
        from(
            SELECT
                wallet_id                       as IdWallet,
                mtf.groups.name                 as NombreWallet,
                0 				                as MontoCreditos,
                sum(amount_total_base)          as MontoDebitos,
                sum(amount_commission)          as MontoComision,
                sum(amount_commission_base)     as MontoComisionBase,
                sum(amount_commission_profit)  as MontoComisionProfit
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($myTempDebits)
                and
                transaction_date    between '$myFechaDesde' and '$myFechaHasta'
                and
                wallet_id           between $walletDesde and $walletHasta
                and status <> 'Anulado'
            group by
                IdWallet,
                NombreWallet
        union
            SELECT
                wallet_id                       as IdWallet,
                mtf.groups.name                 as NombreWallet,
                sum(amount_total_base)          as MontoCreditos,
                0                               as MontoDebitos,
                sum(amount_commission)          as MontoComision,
                sum(amount_commission_base)     as MontoComisionBase,
                sum(amount_commission_profit)   as MontoComisionProfit
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($myTempCredits)
                and
                transaction_date between '$myFechaDesde' and '$myFechaHasta'
                and
                wallet_id between $walletDesde and $walletHasta
                and status <> 'Anulado'
            group by
                IdWallet,
                NombreWallet
        )
        as t
        group by
            IdWallet,
            NombreWallet
        order by 
            NombreWallet
        ";

        // dd($myQuery);
        $Transacciones = DB::select($myQuery);

         // \Log::info('leam grupo query          getBalanceWallet *** -> ' . print_r($myQuery,true));
         // \Log::info('leam grupo transacciones  getBalanceWallet *** -> ' . print_r($Transacciones,true));

        if (empty($Transacciones)) {
            // \Log::info('leam vacio *** -> ' . print_r($Transacciones,true));
            return $Transacciones;
        }else {
            // \Log::info('*** leam gettype -> ' . gettype($Transacciones));
            if ($walletDesde === $walletHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    /*
    *
    *
    *       getTotals
    *
    *
    */
    function getTotals($wallet = 0, $group = 0, $transaction = 0, $fechaDesde = "2001-01-01", $fechaHasta = "9999-12-31"){

        if ($wallet === 0){
            $walletDesde = 00000;
            $walletHasta = 99999;

        }else{
            $walletDesde = $wallet;
            $walletHasta = $wallet;
        }
   
        if ($group === 0){
            $groupDesde = 00000;
            $groupHasta = 99999;

        }else{
            $groupDesde = $group;
            $groupHasta = $group;
        }

        if ($transaction === 0){
            $transactionDesde = 00000;
            $transactionHasta = 99999;

        }else{
            $transactionDesde = $group;
            $groupHasta = $group;
        }

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $fechaDesde . $horaDesde;
        $myFechaHasta = $fechaHasta . $horaHasta;

        $myTable = "mtf.transactions";

        $myQuery =
        "
            select
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.transactions.type_transaction_id            as TransactionId,
                type_transactions.name                          as TipoTransaccion,
                sum(mtf.transactions.amount_foreign_currency)   as MontoMoneda,
                sum(mtf.transactions.amount)                    as Monto,            
                sum(mtf.transactions.amount_total)              as MontoTotal,
                sum(mtf.transactions.amount_commission)         as MontoComision,
                sum(mtf.transactions.amount_base)               as MontoBase,              
                sum(mtf.transactions.amount_total_base)         as MontoTotalBase,
                sum(mtf.transactions.amount_commission_base)    as MontoComisionBase                
            from
                mtf.transactions
            left join mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and wallet_id           between $myWalletDesde              and $myWalletHasta
                and type_transaction_id between $myTypeTransactionsDesde    and $myTypeTransactionsHasta
                and transaction_date    between '$myFechaDesde'             and '$myFechaHasta'
            order by
                Transactions.transaction_date ASC

        ";

        // dd($myQuery);
        // \Log::info('leam My query *** -> ' . $myQuery);
        $Transacciones = DB::select($myQuery);
        // \Log::info('leam grupo query           *** -> ' . print_r($myQuery,true));
        // \Log::info('leam grupo transacciones   *** -> ' . print_r($Transacciones,true));

        if (empty($Transacciones)) {
            // \Log::info('leam vacio *** -> ' . print_r($Transacciones,true));
            return $Transacciones;
        }else {
            // \Log::info('*** leam gettype -> ' . gettype($Transacciones));
            if ($walletDesde === $walletHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    /*
    *
    *
    *       getComissions
    *
    *
    */
    function commissionsProfit(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt

        $request->transaction   = 11; // pago usdt y 13 cobro usdt

        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";

        $myQuery =
        "
            select
                mtf.transactions.id                             as Id,
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                transaction_date                                as TransactionDate,
                percentage                                      as Percentage,
                percentage_base                                 as PercentageBase,
                exchange_rate                                   as ExchangeRate,
                exchange_rate_base                              as ExchangeRateBase,
                mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                mtf.transactions.amount                         as Amount,
                mtf.transactions.amount_total                   as AmountTotal,
                mtf.transactions.amount_commission              as AmountCommission,
                mtf.transactions.amount_base                    as AmountBase,
                mtf.transactions.amount_total_base              as AmountTotalBase,
                mtf.transactions.amount_commission_base         as AmountCommissionBase,
                mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                mtf.transactions.amount                         as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and group_id            between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
            order by
                Transactions.transaction_date ASC,
                id ASC
        ";

        // dd($myQuery);
        
        $Recargas = DB::select($myQuery);
        // dd($Recargas);

        $myTransactionDesde     = 13; // 13 corbos usdt
        $myTransactionHasta     = 13;

        $myQuery =
         "
             select
                 mtf.transactions.id                             as Id,
                 mtf.transactions.wallet_id                      as WalletId,
                 wallets.name                                    as WalletName,
                 mtf.transactions.group_id                       as GroupId,
                 mtf.groups.name                                 as GroupName,
                 mtf.transactions.type_transaction_id            as TypeTransactionId,
                 type_transactions.name                          as TypeTransactionName,
                 transaction_date                                as TransactionDate,
                 percentage                                      as Percentage,
                 1.5                                 as PercentageBase,
                 exchange_rate                                   as ExchangeRate,
                 exchange_rate_base                              as ExchangeRateBase,
                 mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                 mtf.transactions.amount                         as Amount,
                 mtf.transactions.amount_total                   as AmountTotal,
                 mtf.transactions.amount_commission              as AmountCommission,
                 mtf.transactions.amount_base                    as AmountBase,
                 mtf.transactions.amount_total_base              as AmountTotalBase,
                 mtf.transactions.amount_commission_base         as AmountCommissionBase,
                 mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                 mtf.transactions.amount                         as Saldo
             from
                         mtf.transactions
             left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
             left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
             left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
             where
                     status = 'Activo'
                 and wallet_id           between $myWalletDesde              and     $myWalletHasta
                 and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                 and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
             order by
                 Transactions.transaction_date ASC,
                 id ASC
 
         ";
 
        //dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);

        $Recargas3 = array_merge($Recargas, $Recargas2);
        
        usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});

       // dd($Recargas3);
        //
        //
        // Busca transacciones de pagos
        //
        //
        $request->transaction   = 11; // pago usdt

        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde = 00000;
        $myTransactionHasta = 99999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFechaDesde   = "2001-01-01";
        $myFechaHasta   = "9999-12-31";
        $horaDesde      = " 00:00:00";
        $horaHasta      = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;
      

        $myQuery =
        "
            select
                mtf.transactions.id                             as Id,
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                lcase(mtf.groups.name)                          as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                transaction_date                                as TransactionDate,
                percentage                                      as Percentage,
                percentage_base                                 as PercentageBase,
                exchange_rate                                   as ExchangeRate,
                exchange_rate_base                              as ExchangeRateBase,
                mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                mtf.transactions.amount                         as Amount,
                mtf.transactions.amount_total                   as AmountTotal,
                mtf.transactions.amount_commission              as AmountCommission,
                mtf.transactions.amount_base                    as AmountBase,
                mtf.transactions.amount_total_base              as AmountTotalBase,
                mtf.transactions.amount_commission_base         as AmountCommissionBase,
                mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                0                                                as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and wallet_id           between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
            order by
                Transactions.transaction_date ASC,
                wallets.name ASC,
                mtf.groups.name ASC

        ";

        // dd($myQuery);
         // dd($Transacciones);
        // \Log::info('leam My query *** -> ' . $myQuery);

        $Transacciones  = DB::select($myQuery);
       
        $Transacciones2 = [];
        $verLog         = 0;
       
        foreach($Transacciones as $key => $myTransaccion){

            $cant = 0;
            
            
            $myTransaccion2             = clone $myTransaccion;

            $myTransaccion2->Amount2    = $myTransaccion->Amount;

            foreach($Recargas3 as $myRecarga){
                //
                // Busca solo las recargas que tengan saldo
                //
                
                if ($myRecarga->Saldo <= 0) {
                    continue;
                }

                // if ($cant > 100) { dd($Transacciones2); }

                if ($verLog ==1){
                    echo "<br>";
                    echo "<br>";
                    echo "<br> Transaccion2  ********************************************************************************************  " . $key;

                    echo "<br>";
                    echo "<br>";
                    echo "<br> Transaccion2  ------ ";
                    echo "<br>";
                    echo "<br>";
                    echo "<pre>";
                    print_r($myTransaccion2);  
                    echo "</pre>";
                    echo "<br>";
                    echo "<br>" . "recarga -------";
                    echo "<br>";
                    echo "<pre>";
                    echo print_r($myRecarga,true);
                    echo "</pre>";
                                       
                }

                if($myTransaccion2->Amount2 <= $myRecarga->Saldo) {
                    $myTransaccion2->RecargaSaldoAntes          = $myRecarga->Saldo;       
                    $myTransaccion2->RecargaPercentageBase      = $myRecarga->PercentageBase;
                    $myTransaccion2->RecargaId                  = $myRecarga->Id;
                    $myTransaccion2->RecargaAmount              = $myRecarga->Amount;
                    $myRecarga->Saldo                           -= $myTransaccion2->Amount2;
                    $myTransaccion2->RecargaSaldo               = $myRecarga->Saldo;

                    $myTransaccion2->key                        = $key;

                    $myTransaccion2->AmountCommission           = ($myTransaccion2->Amount2 *  $myTransaccion2->Percentage) / 100; // nueva 09-11-2023

                    $myTransaccion2->PercentageBase             = $myRecarga->PercentageBase;
                    $myTransaccion2->AmountCommissionBase       = ($myTransaccion2->Amount2 * $myRecarga->PercentageBase) / 100;
                    $myTransaccion2->AmountBase                 = $myTransaccion2->Amount2;
                    $myTransaccion2->AmountTotalBase            = $myTransaccion2->Amount2 + $myTransaccion2->AmountCommissionBase;
                    $myTransaccion2->AmountCommissionProfit     = $myTransaccion2->AmountCommission - $myTransaccion2->AmountCommissionBase;

                    $Transacciones2 [] = $myTransaccion2;

                    if ($verLog ==1){
                        echo "<br>";
                        echo "<br>";
                        echo "<br> Transaccion2 despues menor ------ ";
                        echo "<br>";
                        echo "<br>";
                        echo "<pre>";
                        print_r($myTransaccion2);  
                        echo "</pre>";
                        echo "<br>";
                        echo "<br>" . "recarga despues menor -------";
                        echo "<br>";
                        echo "<pre>";
                        echo print_r($myRecarga,true);
                        echo "</pre>";
                                           
                    }

                    break;
                }else{

                    if($myTransaccion2->Amount2 > $myRecarga->Saldo) {


                        $myAmount22                                 = $myTransaccion2->Amount2  - $myRecarga->Saldo; 

                        $myAmount2                                  = $myTransaccion2->Amount2 - ($myTransaccion2->Amount2  - $myRecarga->Saldo); 

                        $myTransaccion2->Amount2                    = $myAmount2;
                        $myTransaccion2->AmountCommission           = ($myAmount2 * $myTransaccion2->Percentage) / 100; // nueva 09-11-2023

                        $myTransaccion2->RecargaSaldoAntes          = $myRecarga->Saldo;
                        $saldoRecarga2                              = $myRecarga->Saldo;
                        $myTransaccion2->RecargaPercentageBase      = $myRecarga->PercentageBase;
                        $myTransaccion2->RecargaId                  = $myRecarga->Id;
                        $myTransaccion2->RecargaAmount              = $myRecarga->Amount;
                        $myRecarga->Saldo                           = 0;
                        $myTransaccion2->RecargaSaldo               = 0;
                        $myTransaccion2->PercentageBase             = $myRecarga->PercentageBase;
                        $myTransaccion2->AmountCommissionBase       = ($myTransaccion2->Amount2 * $myRecarga->PercentageBase) / 100;
                        $myTransaccion2->AmountCommissionProfit     = $myTransaccion2->AmountCommission - $myTransaccion2->AmountCommissionBase;
                        $myTransaccion2->AmountBase                 = $myAmount2;
                        $myTransaccion2->AmountTotalBase            = $myAmount2 + $myTransaccion2->AmountCommissionBase;
                        $myTransaccion2->key                        = $key;

                       // $Transacciones2 []                          = $myTransaccion2;
                        array_push($Transacciones2,$myTransaccion2);
                        if ($verLog ==1){
                            echo "<br>";
                            echo "<br>";
                            echo "<br> Transaccion2 despues mayor ------ ";
                            echo "<br>";
                            echo "<br>";
                            echo "<pre>";
                            print_r($myTransaccion2);  
                            echo "</pre>";
                            echo "<br>";
                            echo "<br>" . "recarga despues mayor -------";
                            echo "<br>";
                            echo "<pre>";
                            echo print_r($myRecarga,true);
                            echo "</pre>";
                                               
                            
                        }

                        $myTransaccion3                         = clone $myTransaccion2;

                        $myTransaccion3->Amount2                = $myAmount22;
                        $myTransaccion3->RecargaSaldoAntes      = 0;
                        // $myTransaccion2->Amount2                = $myTransaccion2->Amount - $saldoRecarga2;
                        $myTransaccion3->key                    = $key;


                        $myTransaccion2 = clone $myTransaccion3;

                        /*
                        if ($verLog ==1){
                            echo "<br>";
                            echo "<br>";
                            echo "<br> Transaccion2 restante despues mayor ------ ";
                            echo "<br>";
                            echo "<br>";
                            echo "<pre>";
                            print_r($myTransaccion2);  
                            echo "</pre>";
                            echo "<br>";
                            echo "<br>" . "recarga restante despues mayor -------";
                            echo "<br>";
                            echo "<pre>";
                            echo print_r($myRecarga,true);
                            echo "</pre>";
                                               
                            
                        }
                        */
                        if ($myTransaccion3->Amount2  <= 0){
                            break;
                        }

                        $cant++;
                        // if ($key == 10) dd($Transacciones2);

                        // dd($myTransaccion2);
                        // dd($myRecarga);
                        continue;
                    }
                }

            }
        
            
        };
         
        if ($verLog == 1){
            die();
        }
        // dd($Transacciones2);


        // dd($Transacciones4);

        return [$Recargas3, $Transacciones2];
        

    }    
        /*
    *
    *
    *       USDTResumen
    *
    *
    */
    function USDTResumenWallet(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt

        $request->transaction   = 11; // 11 pago usdt 

        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }
        // dd('statiscticController -> ' . $request->fechaDesde . ' -- ' . $request->fechaHasta);
        //$myFechaDesde = "2001-01-01";
        //$myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";

        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,
                mtf.transactions.group_id                           as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.transactions.type_transaction_id                as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,                
                count(mtf.transactions.amount)                      as Cant,
                sum(mtf.transactions.amount_foreign_currency)       as AmountForeignCurrency,
                sum(mtf.transactions.amount)                        as Amount,
                sum(mtf.transactions.amount_total)                  as AmountTotal,
                sum(mtf.transactions.amount_commission)             as AmountCommission,
                sum(mtf.transactions.amount_base)                   as AmountBase,
                sum(mtf.transactions.amount_total_base)             as AmountTotalBase,
                sum(mtf.transactions.amount_commission_base)        as AmountCommissionBase,
                sum(mtf.transactions.amount_commission_profit)      as AmountCommissionProfit,
                sum(mtf.transactions.amount)                        as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and group_id                between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id     between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date        between '$myFechaDesde'             and     '$myFechaHasta'
            group by
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name
            order by
                wallets.name ASC,
                mtf.groups.name ASC
        ";

        // dd($myQuery);
        
        $Recargas = DB::select($myQuery);
        // dd($Recargas);

        $myTransactionDesde     = 13; // 13 corbos usdt
        $myTransactionHasta     = 13;

        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,
                mtf.transactions.group_id                           as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.transactions.type_transaction_id                as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,                    
                count(mtf.transactions.amount)                      as Cant,
                sum(mtf.transactions.amount_foreign_currency)       as AmountForeignCurrency,
                sum(mtf.transactions.amount)                        as Amount,
                sum(mtf.transactions.amount_total)                  as AmountTotal,
                sum(mtf.transactions.amount_commission)             as AmountCommission,
                sum(mtf.transactions.amount_base)                   as AmountBase,
                sum(mtf.transactions.amount_total_base)             as AmountTotalBase,
                sum(mtf.transactions.amount_commission_base)        as AmountCommissionBase,
                sum(mtf.transactions.amount_commission_profit)      as AmountCommissionProfit,
                sum(mtf.transactions.amount)                        as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and wallet_id                between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id      between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date         between '$myFechaDesde'             and     '$myFechaHasta'
            group by
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name                
            order by
                wallets.name ASC,
                mtf.groups.name ASC
        ";
 
        //dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);

        $Recargas3 = array_merge($Recargas, $Recargas2);
        
       // usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});



        return $Recargas3;


    }    


    /*
    *
    *
    *       USDTResumen
    *
    *
    */
    function USDTResumenGrupoComision(Request $request){



        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        // $request->group = 158; // comision usdt
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->groups){
            $myGroups = implode(",",$request->groups);
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        //$myFechaDesde = "2001-01-01";
        //$myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";


        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,
                mtf.transactions.group_id                           as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.transactions.type_transaction_id                as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,                                    
                count(mtf.transactions.amount)                      as Cant,
                sum(mtf.transactions.amount_foreign_currency)       as AmountForeignCurrency,
                sum(mtf.transactions.amount)                        as Amount,
                sum(mtf.transactions.amount_total)                  as AmountTotal,
                sum(mtf.transactions.amount_commission)             as AmountCommission,
                sum(mtf.transactions.amount_base)                   as AmountBase,
                sum(mtf.transactions.amount_total_base)             as AmountTotalBase,
                sum(mtf.transactions.amount_commission_base)        as AmountCommissionBase,
                sum(mtf.transactions.amount_commission_profit)      as AmountCommissionProfit,
                sum(mtf.transactions.amount)                        as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and group_id                in($myGroups)
                and type_transaction_id     in (11,13)
                and transaction_date        between '$myFechaDesde'             and     '$myFechaHasta'
            group by
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name                    
            order by
                wallets.name ASC,
                mtf.groups.name ASC
        ";
        // dd($myQuery);
        $transaccionGrupoComision = DB::select($myQuery);

        return $transaccionGrupoComision;

    }

    /*
    *
    *
    *       USDTResumen
    *
    *
    */
    function USDTResumenGrupoSalida(Request $request){



        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }
        
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        
        $myGroupsDesde = 00000;
        $myGroupsHasta = 99999;
        if ($request->groups){
            $myGroups = implode(",",$request->groups);
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }


        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        //$myFechaDesde = "2001-01-01";
        //$myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";


        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,
                mtf.transactions.group_id                           as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.transactions.type_transaction_id                as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,                   
                count(mtf.transactions.amount)                      as Cant,
                sum(mtf.transactions.amount_foreign_currency)       as AmountForeignCurrency,
                sum(mtf.transactions.amount)                        as Amount,
                sum(mtf.transactions.amount_total)                  as AmountTotal,
                sum(mtf.transactions.amount_commission)             as AmountCommission,
                sum(mtf.transactions.amount_base)                   as AmountBase,
                sum(mtf.transactions.amount_total_base)             as AmountTotalBase,
                sum(mtf.transactions.amount_commission_base)        as AmountCommissionBase,
                sum(mtf.transactions.amount_commission_profit)      as AmountCommissionProfit,
                sum(mtf.transactions.amount)                        as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde              and     $myWalletHasta                    
                and group_id                in($myGroups)
                and type_transaction_id     in (11)
                and transaction_date        between '$myFechaDesde'             and     '$myFechaHasta'
            group by
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name                    
            order by
                wallets.name ASC,
                mtf.groups.name ASC,
                type_transactions.name ASC
        ";

        $transaccionGrupoComision = DB::select($myQuery);
        // dd('leam - groups ->' . print_r($request->groups,true) . ' implode ->' . $myGroups . ' - myQuery ->' . $myQuery . '- trasaccionGrupoComision ->' . print_r($transaccionGrupoComision,true));
        return $transaccionGrupoComision;

    }

    /*
    *
    *
    *       getComissions
    *
    *
    */
    function commissionsProfitRes(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt

        $request->transaction   = 11; // pago usdt y 13 cobro usdt

        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";

        $myQuery =
        "
            select
                mtf.transactions.id                             as Id,
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                transaction_date                                as TransactionDate,
                percentage                                      as Percentage,
                percentage_base                                 as PercentageBase,
                exchange_rate                                   as ExchangeRate,
                exchange_rate_base                              as ExchangeRateBase,
                mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                mtf.transactions.amount                         as Amount,
                mtf.transactions.amount_total                   as AmountTotal,
                mtf.transactions.amount_commission              as AmountCommission,
                mtf.transactions.amount_base                    as AmountBase,
                mtf.transactions.amount_total_base              as AmountTotalBase,
                mtf.transactions.amount_commission_base         as AmountCommissionBase,
                mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                mtf.transactions.amount                         as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and group_id            between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
            order by
                Transactions.transaction_date ASC,
                id ASC
        ";

        // dd($myQuery);
        
        $Recargas = DB::select($myQuery);
        // dd($Recargas);

        $myTransactionDesde     = 13; // 13 corbos usdt
        $myTransactionHasta     = 13;

        $myQuery =
         "
             select
                 mtf.transactions.id                             as Id,
                 mtf.transactions.wallet_id                      as WalletId,
                 wallets.name                                    as WalletName,
                 mtf.transactions.group_id                       as GroupId,
                 mtf.groups.name                                 as GroupName,
                 mtf.transactions.type_transaction_id            as TypeTransactionId,
                 type_transactions.name                          as TypeTransactionName,
                 transaction_date                                as TransactionDate,
                 percentage                                      as Percentage,
                 1.5                                 as PercentageBase,
                 exchange_rate                                   as ExchangeRate,
                 exchange_rate_base                              as ExchangeRateBase,
                 mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                 mtf.transactions.amount                         as Amount,
                 mtf.transactions.amount_total                   as AmountTotal,
                 mtf.transactions.amount_commission              as AmountCommission,
                 mtf.transactions.amount_base                    as AmountBase,
                 mtf.transactions.amount_total_base              as AmountTotalBase,
                 mtf.transactions.amount_commission_base         as AmountCommissionBase,
                 mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                 mtf.transactions.amount                         as Saldo
             from
                         mtf.transactions
             left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
             left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
             left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
             where
                     status = 'Activo'
                 and wallet_id           between $myWalletDesde              and     $myWalletHasta
                 and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                 and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
             order by
                 Transactions.transaction_date ASC,
                 id ASC
 
         ";
 
        //dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);

        $Recargas3 = array_merge($Recargas, $Recargas2);
        
        usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});

       // dd($Recargas3);
        //
        //
        // Busca transacciones de pagos
        //
        //
        $request->transaction   = 11; // pago usdt

        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $myTransactionDesde = 00000;
        $myTransactionHasta = 99999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFechaDesde   = "2001-01-01";
        $myFechaHasta   = "9999-12-31";
        $horaDesde      = " 00:00:00";
        $horaHasta      = " 23:59:00";

        $myFechaDesde = $myFechaDesde . $horaDesde;
        $myFechaHasta = $myFechaHasta . $horaHasta;
      

        $myQuery =
        "
            select
                mtf.transactions.id                             as Id,
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                lcase(mtf.groups.name)                          as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                transaction_date                                as TransactionDate,
                percentage                                      as Percentage,
                percentage_base                                 as PercentageBase,
                exchange_rate                                   as ExchangeRate,
                exchange_rate_base                              as ExchangeRateBase,
                mtf.transactions.amount_foreign_currency        as AmountForeignCurrency,
                mtf.transactions.amount                         as Amount,
                mtf.transactions.amount_total                   as AmountTotal,
                mtf.transactions.amount_commission              as AmountCommission,
                mtf.transactions.amount_base                    as AmountBase,
                mtf.transactions.amount_total_base              as AmountTotalBase,
                mtf.transactions.amount_commission_base         as AmountCommissionBase,
                mtf.transactions.amount_commission_profit       as AmountCommissionProfit,
                0                                                as Saldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            where
                    status = 'Activo'
                and wallet_id           between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
            order by
                Transactions.transaction_date ASC,
                wallets.name ASC,
                mtf.groups.name ASC

        ";

        // dd($myQuery);
         // dd($Transacciones);
        // \Log::info('leam My query *** -> ' . $myQuery);

        $Transacciones  = DB::select($myQuery);
       
        $Transacciones2 = [];
        $verLog         = 0;
       
        foreach($Transacciones as $key => $myTransaccion){

            $cant = 0;
            
            $myTransaccion2             = clone $myTransaccion;

            $myTransaccion2->Amount2    = $myTransaccion->Amount;

            foreach($Recargas3 as $myRecarga){
                //
                // Busca solo las recargas que tengan saldo
                //
                
                if ($myRecarga->Saldo <= 0) {
                    continue;
                }

                // if ($cant > 100) { dd($Transacciones2); }

                if ($verLog ==1){
                    echo "<br>";
                    echo "<br>";
                    echo "<br> Transaccion2  ********************************************************************************************  " . $key;

                    echo "<br>";
                    echo "<br>";
                    echo "<br> Transaccion2  ------ ";
                    echo "<br>";
                    echo "<br>";
                    echo "<pre>";
                    print_r($myTransaccion2);  
                    echo "</pre>";
                    echo "<br>";
                    echo "<br>" . "recarga -------";
                    echo "<br>";
                    echo "<pre>";
                    echo print_r($myRecarga,true);
                    echo "</pre>";
                                       
                }

                if($myTransaccion2->Amount2 <= $myRecarga->Saldo) {
                    $myTransaccion2->RecargaSaldoAntes          = $myRecarga->Saldo;       
                    $myTransaccion2->RecargaPercentageBase      = $myRecarga->PercentageBase;
                    $myTransaccion2->RecargaId                  = $myRecarga->Id;
                    $myTransaccion2->RecargaAmount              = $myRecarga->Amount;
                    $myRecarga->Saldo                           -= $myTransaccion2->Amount2;
                    $myTransaccion2->RecargaSaldo               = $myRecarga->Saldo;

                    $myTransaccion2->key                        = $key;

                    $myTransaccion2->AmountCommission           = ($myTransaccion2->Amount2 *  $myTransaccion2->Percentage) / 100; // nueva 09-11-2023

                    $myTransaccion2->PercentageBase             = $myRecarga->PercentageBase;
                    $myTransaccion2->AmountCommissionBase       = ($myTransaccion2->Amount2 * $myRecarga->PercentageBase) / 100;
                    $myTransaccion2->AmountBase                 = $myTransaccion2->Amount2;
                    $myTransaccion2->AmountTotalBase            = $myTransaccion2->Amount2 + $myTransaccion2->AmountCommissionBase;
                    $myTransaccion2->AmountCommissionProfit     = $myTransaccion2->AmountCommission - $myTransaccion2->AmountCommissionBase;

                    $Transacciones2 [] = $myTransaccion2;

                    if ($verLog ==1){
                        echo "<br>";
                        echo "<br>";
                        echo "<br> Transaccion2 despues menor ------ ";
                        echo "<br>";
                        echo "<br>";
                        echo "<pre>";
                        print_r($myTransaccion2);  
                        echo "</pre>";
                        echo "<br>";
                        echo "<br>" . "recarga despues menor -------";
                        echo "<br>";
                        echo "<pre>";
                        echo print_r($myRecarga,true);
                        echo "</pre>";
                                           
                    }

                    break;
                }else{

                    if($myTransaccion2->Amount2 > $myRecarga->Saldo) {


                        $myAmount22                                 = $myTransaccion2->Amount2  - $myRecarga->Saldo; 

                        $myAmount2                                  = $myTransaccion2->Amount2 - ($myTransaccion2->Amount2  - $myRecarga->Saldo); 

                        $myTransaccion2->Amount2                    = $myAmount2;
                        $myTransaccion2->AmountCommission           = ($myAmount2 * $myTransaccion2->Percentage) / 100; // nueva 09-11-2023

                        $myTransaccion2->Amount2                    = $myAmount2;
                        $myTransaccion2->RecargaSaldoAntes          = $myRecarga->Saldo;
                        $saldoRecarga2                              = $myRecarga->Saldo;
                        $myTransaccion2->RecargaPercentageBase      = $myRecarga->PercentageBase;
                        $myTransaccion2->RecargaId                  = $myRecarga->Id;
                        $myTransaccion2->RecargaAmount              = $myRecarga->Amount;
                        $myRecarga->Saldo                           = 0;
                        $myTransaccion2->RecargaSaldo               = 0;
                        $myTransaccion2->PercentageBase             = $myRecarga->PercentageBase;
                        $myTransaccion2->AmountCommissionBase       = ($myTransaccion2->Amount2 * $myRecarga->PercentageBase) / 100;
                        $myTransaccion2->AmountCommissionProfit     = $myTransaccion2->AmountCommission - $myTransaccion2->AmountCommissionBase;
                        $myTransaccion2->AmountBase                 = $myAmount2;
                        $myTransaccion2->AmountTotalBase            = $myAmount2 + $myTransaccion2->AmountCommissionBase;
                        $myTransaccion2->key                        = $key;

                       // $Transacciones2 []                          = $myTransaccion2;
                        array_push($Transacciones2,$myTransaccion2);
                        if ($verLog ==1){
                            echo "<br>";
                            echo "<br>";
                            echo "<br> Transaccion2 despues mayor ------ ";
                            echo "<br>";
                            echo "<br>";
                            echo "<pre>";
                            print_r($myTransaccion2);  
                            echo "</pre>";
                            echo "<br>";
                            echo "<br>" . "recarga despues mayor -------";
                            echo "<br>";
                            echo "<pre>";
                            echo print_r($myRecarga,true);
                            echo "</pre>";
                                               
                            
                        }

                        $myTransaccion3                         = clone $myTransaccion2;

                        $myTransaccion3->Amount2                = $myAmount22;
                        $myTransaccion3->RecargaSaldoAntes      = 0;
                        // $myTransaccion2->Amount2                = $myTransaccion2->Amount - $saldoRecarga2;
                        $myTransaccion3->key                    = $key;


                        $myTransaccion2 = clone $myTransaccion3;

                        /*
                        if ($verLog ==1){
                            echo "<br>";
                            echo "<br>";
                            echo "<br> Transaccion2 restante despues mayor ------ ";
                            echo "<br>";
                            echo "<br>";
                            echo "<pre>";
                            print_r($myTransaccion2);  
                            echo "</pre>";
                            echo "<br>";
                            echo "<br>" . "recarga restante despues mayor -------";
                            echo "<br>";
                            echo "<pre>";
                            echo print_r($myRecarga,true);
                            echo "</pre>";
                                               
                            
                        }
                        */
                        if ($myTransaccion3->Amount2  <= 0){
                            break;
                        }

                        $cant++;
                        // if ($key == 10) dd($Transacciones2);

                        // dd($myTransaccion2);
                        // dd($myRecarga);
                        continue;
                    }
                }

            }
        
            
        };
         
        if ($verLog == 1){
            die();
        }
        // dd($Transacciones2);

        //
        //
        // transcacioens resumidas por wallet - grupo
        //
        //
        $Transacciones3     = $Transacciones2;

        $myGroup            = array_column($Transacciones3, 'GroupName');
        $myTransactionDate  = array_column($Transacciones3, 'TransactionDate');

        array_multisort($myGroup, SORT_ASC, $myGroup, $myTransactionDate, SORT_DESC, $Transacciones3);

        $myIdTemp                           = 0;
        $myWalletIdTemp                     = 0;
        $myWalletNameTemp                   = "";                
        $myGroupIdTemp                      = 0;
        $myGroupNameTemp                    = "";
        $myTypeTransactionIdTemp            = 0;
        $myTypeTransactionName              = "";
        $myTransactionDateTemp              = "";

        $myAmountFecha                      = 0;
        $myAmountTotalFecha                 = 0;
        $myAmountCommissionFecha            = 0;
        $myAmountBaseFecha                  = 0;
        $myAmountTotalBaseFecha             = 0;
        $myAmountCommissionBaseFecha        = 0;
        $myAmountCommissionProfitFecha      = 0;   

        $myAmountFechaGrupo                      = 0;
        $myAmountCommissionFechaGrupo            = 0;
        $myAmountCommissionBaseFechaGrupo        = 0;
        $myAmountCommissionProfitFechaGrupo      = 0;   

        $cant                               = 0;

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

      

        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        foreach($Transacciones3 as $key => $myTransaccion3){
            

            $myDate      = substr($myTransaccion3->TransactionDate,0,10);
            // \Log::info('leam - statisticsComntroller - commisionFProfit - myDate ->' . $myDate . ' -- myFechaDesde ->' . $myFechaDesde . ' -- myFechaHasta ->' . $myFechaHasta);

            if ($myDate < $myFechaDesde || $myDate > $myFechaHasta){
                // \Log::info('leam - statisticsComntroller - commisionFProfit - myDate' . $myDate . ' -- myFechaDesde ->' . $myFechaDesde . ' -- myFechaHasta ->' . $myFechaHasta . ' -- continue');
                continue;
            }

            if ($cant === 0){
                // dd('el primero ->' . ' el key ->' . $key . ' -- ' . print_r($myTransaccion3, true));
                $myIdTemp                   = $myTransaccion3->Id;
                $myWalletIdTemp             = $myTransaccion3->WalletId;
                $myWalletNameTemp           = $myTransaccion3->WalletName;                
                $myGroupIdTemp              = $myTransaccion3->GroupId;
                $myGroupNameTemp            = $myTransaccion3->GroupName;
                $myTypeTransactionIdTemp    = $myTransaccion3->TypeTransactionId;
                $myTypeTransactionName      = $myTransaccion3->TypeTransactionName;
                $myTransactionDateTemp      = substr($myTransaccion3->TransactionDate,0,10);
            }

            if ($myIdTemp != $myTransaccion3->Id){

                $myAmountFechaGrupo                         += $myAmountFecha;
                $myAmountCommissionFechaGrupo               += $myAmountCommissionFecha;
                $myAmountCommissionBaseFechaGrupo           += $myAmountCommissionBaseFecha;
                $myAmountCommissionProfitFechaGrupo         += $myAmountCommissionProfitFecha;

                
                $myAmountCommissionFecha                    = 0;
                $myAmountCommissionBaseFecha                = 0;
                $myAmountCommissionProfitFecha              = 0;

                $myIdTemp                                   = $myTransaccion3->Id;
            }

            // if ($myGroupNameTemp != $myTransaccion3->GroupName || $myTransactionDateTemp != $myTransaccion3->TransactionDate){ 
            if ($myGroupNameTemp != $myTransaccion3->GroupName){
                // $genericObject = new stdClass();

                $genericObject = new \stdClass();

                $genericObject->Id                      = $myIdTemp;
                $genericObject->WalletId                = $myWalletIdTemp;
                $genericObject->WalletName              = $myWalletNameTemp;
                $genericObject->GroupId                 = $myGroupIdTemp ;
                $genericObject->GroupName               = $myGroupNameTemp;
                $genericObject->TypeTransactionId       = $myTypeTransactionIdTemp;
                $genericObject->TypeTransactionName     = $myTypeTransactionName;
                $genericObject->TransactionDate         = $myTransactionDateTemp;

                $genericObject->Amount                  = $myAmountFechaGrupo;
                $genericObject->AmountBase              = $myAmountTotalFecha;

                $genericObject->AmountCommission        = $myAmountCommissionFechaGrupo ;
                $genericObject->AmountCommissionBase    = $myAmountCommissionBaseFechaGrupo ;
                $genericObject->AmountTotal             = $myAmountTotalFecha;
                $genericObject->AmountTotalBase         = $myAmountTotalBaseFecha ;
                $genericObject->AmountCommissionProfit  = $myAmountCommissionProfitFechaGrupo;

                $Transacciones4[] = $genericObject;

                $myAmountFecha                          = 0;
                $myAmountTotalFecha                     = 0;
                $myAmountBaseFecha                      = 0;
                $myAmountTotalBaseFecha                 = 0;

                $myAmountFechaGrupo                     = 0;
                $myAmountCommissionFechaGrupo           = 0;
                $myAmountCommissionBaseFechaGrupo       = 0;
                $myAmountCommissionProfitFechaGrupo     = 0;

                $myIdTemp                   = $myTransaccion3->Id;
                $myWalletIdTemp             = $myTransaccion3->WalletId;
                $myWalletNameTemp           = $myTransaccion3->WalletName;                
                $myGroupIdTemp              = $myTransaccion3->GroupId;
                $myGroupNameTemp            = $myTransaccion3->GroupName;
                $myTypeTransactionIdTemp    = $myTransaccion3->TypeTransactionId;
                $myTypeTransactionName      = $myTransaccion3->TypeTransactionName;
                $myTransactionDateTemp      = substr($myTransaccion3->TransactionDate,0,10);
                //die();
            }



            $myAmountFecha                      = $myTransaccion3->Amount;
            $myAmountTotalFecha                 = $myTransaccion3->AmountTotal;
            $myAmountCommissionFecha            += $myTransaccion3->AmountCommission;

            $myAmountBaseFecha                  += $myTransaccion3->AmountBase;
            $myAmountTotalBaseFecha             += $myTransaccion3->AmountTotalBase;
            $myAmountCommissionBaseFecha        += $myTransaccion3->AmountCommissionBase;
            $myAmountCommissionProfitFecha      += $myTransaccion3->AmountCommissionProfit;

            $cant++;

        }

        $myAmountFechaGrupo                         += $myAmountFecha;    
        $myAmountCommissionFechaGrupo               += $myAmountCommissionFecha;
        $myAmountCommissionBaseFechaGrupo           += $myAmountCommissionBaseFecha;
        $myAmountCommissionProfitFechaGrupo         += $myAmountCommissionProfitFecha;

        $myAmountFecha                              = 0;
        $myAmountCommissionFecha                    = 0;
        $myAmountCommissionBaseFecha                = 0;
        $myAmountCommissionProfitFecha              = 0;

        $genericObject = new \stdClass();

        $genericObject->Id                      = $myIdTemp;
        $genericObject->WalletId                = $myWalletIdTemp;
        $genericObject->WalletName              = $myWalletNameTemp;
        $genericObject->GroupId                 = $myGroupIdTemp ;
        $genericObject->GroupName               = $myGroupNameTemp;
        $genericObject->TypeTransactionId       = $myTypeTransactionIdTemp;
        $genericObject->TypeTransactionName     = $myTypeTransactionName;
        $genericObject->TransactionDate         = $myTransactionDateTemp;

        $genericObject->Amount                  = $myAmountFechaGrupo;
        $genericObject->AmountBase              = $myAmountTotalFecha;

        $genericObject->AmountCommission        = $myAmountCommissionFechaGrupo ;
        $genericObject->AmountCommissionBase    = $myAmountCommissionBaseFechaGrupo ;
        $genericObject->AmountCommissionProfit  = $myAmountCommissionProfitFechaGrupo;
        $genericObject->AmountTotal             = $myAmountTotalFecha;
        $genericObject->AmountTotalBase         = $myAmountTotalBaseFecha ;

        $Transacciones4[] = $genericObject;

        $myAmountFecha                      = 0;
        $myAmountTotalFecha                 = 0;
        $myAmountCommissionFecha            = 0;
        $myAmountBaseFecha                  = 0;
        $myAmountTotalBaseFecha             = 0;
        $myAmountCommissionBaseFecha        = 0;
        $myAmountCommissionProfitFecha      = 0;      

        // dd($Transacciones4);

        return [$Recargas3, $Transacciones4, $Transacciones2];
        // return $Transacciones2;

    }        
    /*
    *
    *
    *       getBalanceSupplier
    *
    *
    */
    /*
    function getBalanceSupplier($proveedor = 0){

        if ($proveedor === 0){
            $proveedorDesde = 00000;
            $proveedorHasta = 99999;

        }else{
            $proveedorDesde = $proveedor;
            $proveedorHasta = $proveedor;
        }
        \Log::info('leam proveedor      *** -> ' . $proveedor);
        \Log::info('leam proveedorDesde *** -> ' . $proveedorDesde);
        \Log::info('leam proveedorHasta *** -> ' . $proveedorHasta);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        //
        // 26-04-2023
        //
        // Debitos
        //  4 cobro en efectivo
        //  8 Nota de debito
        //  2 cobro transferencia
        //
        // Creditos
        //  1 transferencia
        //  3 pago en efectivo
        //  5 mercancia
        //  7 notas de credito
        //  9 switft
        //
        //

        $tabla = "mtf.transaction_suppliers";

        $myQuery =
        "
        select
            IdSupplier         as IdSupplier,
            NombreSupplier     as NombreSupplier,
            sum(MontoCreditos) as Creditos,
            sum(MontoDebitos)  as Debitos,
            (sum(MontoCreditos) - sum(MontoDebitos) ) as Total
        from(
        SELECT
            supplier_id          as IdSupplier,
            mtf.suppliers.name   as NombreSupplier,
            0 			  	     as MontoCreditos,
            sum(amount_total)    as MontoDebitos
        FROM $tabla
        left join  mtf.suppliers on $tabla.supplier_id  = mtf.suppliers.id
        where
            type_transaction_id in ($this->myDebits)
            and
            transaction_date between '0000-00-00' and '9999-12-31'
            and
            supplier_id between $proveedorDesde and $proveedorHasta
            and status <> 'Anulado'
        group by
            IdSupplier,
            NombreSupplier
        union
        SELECT
            supplier_id         as IdSupplier,
            mtf.suppliers.name  as NombreSupplier,
            sum(amount_total)   as MontoCreditos,
            0                   as MontoDebitos
        FROM $tabla
        left join  mtf.suppliers on $tabla.supplier_id  = mtf.suppliers.id
        where
            type_transaction_id in($this->myCredits)
            and
            transaction_date between '0000-00-00' and '9999-12-31'
            and
            supplier_id between $proveedorDesde and $proveedorHasta
            and status <> 'Anulado'
        group by
            IdSupplier,
            NombreSupplier

        )
        as t
        group by
            IdSupplier,
            NombreSupplier
        ";

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);

        // \Log::info('leam grupo query  *** -> ' . print_r($myQuery,true));
        // \Log::info('leam grupo transacciones *** -> ' . print_r($Transacciones,true));

        if (empty($Transacciones)) {
            // \Log::info('leam vacio *** -> ' . print_r($Transacciones,true));
            return $Transacciones;
        }else {
            // \Log::info('*** leam gettype -> ' . gettype($Transacciones));
            if ($proveedorDesde === $proveedorHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    */

    /*
    *
    *
    * getDayBefore
    * recibe fecha con formato yyyy-mm-dd
    * devuelve dia anterior en formato string yyyy-mm-dd
    *
    */
    function getDayBefore($myDate){
        $myFecha1 = date($myDate);
        $myFecha2 = date("Y-m-d", strtotime($myFecha1 . "-1 days"));
        return $myFecha2;
    }

    public function filtrosGuarda($filtroWallet,$filtroGroup){
        $myResponse = 
        [
            'success' => true,
            'data' => '1,2,3',
            'message' => 'mi mensaje de guardar'
        ];
        return response()->json($myResponse);
    }

    
    public function filtroUSDTResDiaMovimientosLee(){

        $myJson         = file_get_contents("filtros\myUSDTResDiaMovimientosFiltro");
        $myJsonData     = json_decode($myJson,true); 

        \Log::info('leam - lee USDT filtro -> ' . print_r($myJsonData,true));


        $myResponse = 
        [
            'success' => true,
            'data' => $myJsonData,
            'message' => 'mi mensaje de leer'
        ];

        return response()->json($myResponse);
    }


    public function filtroUSDTResDiaMovimientosGraba(Request $request){

        // dd($request);


        $json = json_encode($request->data);
        
        \Log::info('leam - Graba USDT filtro -  filtroUSDTResDiaMovimientosGraba ->' . $json);

        file_put_contents("filtros\myUSDTResDiaMovimientosFiltro", $json);


        // dd($request);

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }   

    public function filtrosLeeWallet(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

        $myWallets = json_decode($myWallets,true);
        // $myGroups = json_decode($myGroups);

        // \Log::info('lee myWallets         -> ' . print_r($myWallets,true));

        // \Log::info('lee myWallets value -> ' . implode(",",$myWallets['wallets']));

        

        $myResponse = 
        [
            'success' => true,
            'data' => $myWallets['wallets'],
            'message' => 'mi mensaje de leer'
        ];

        return response()->json($myResponse);
    }


    public function filtrosLeeWalletB(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);

        $myWalletsB = fgets($myfile);
        
        $myGroupsB  = fgets($myfile);

        fclose($myfile);        

        $myWalletsB = json_decode($myWalletsB,true);
        // $myGroups = json_decode($myGroups);

        // \Log::info('lee myWallets         -> ' . print_r($myWalletsB,true));

        // \Log::info('lee myWallets value -> ' . implode(",",$myWalletsB['walletsB']));

        

        $myResponse = 
        [
            'success' => true,
            'data' => $myWalletsB['walletsB'],
            'message' => 'mi mensaje de leer'
        ];

        return response()->json($myResponse);
    }

    public function filtrosLeeGroup(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

        $myGroups = json_decode($myGroups,true);

        $myResponse = 
        [
            'success' => true,
            'data' => $myGroups['groups'],
            'message' => 'mi mensaje de leer'
        ];

        return response()->json($myResponse);
    }





    public function filtrosLeeGroupB(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);

        $myWalletsB = fgets($myfile);
        
        $myGroupsB  = fgets($myfile);


        fclose($myfile);        

        $myGroupsB = json_decode($myGroupsB,true);

        $myResponse = 
        [
            'success' => true,
            'data' => $myGroupsB['groupsB'],
            'message' => 'mi mensaje de leer'
        ];

        return response()->json($myResponse);
    }


    public function filtrosGrabaWallet(Request $request){

        $myfile = fopen("myFiltros", "w") or die("Unable to open file!");

        $myLine = '{"wallets" : [' . implode(",",$request->myDataWallet) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"groups" : [' .implode(",",$request->myDataGroup) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"walletsB" : [' . implode(",",$request->myDataWalletB) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"groupsB" : [' .implode(",",$request->myDataGroupB) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        fclose($myfile);   



        // dd($request);
         \Log::info(' llega por filtro wallet ->' . print_r($request->myDataWallet,true));
         \Log::info(' llega por filtro group  ->' . print_r($request->myDataGroup,true));

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }



    function filtrosLeeWallet2(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

         $myWallets = json_decode($myWallets,true);
        // $myGroups = json_decode($myGroups);

        // \Log::info('lee myWallets -> ' . print_r($myWallets,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroups,true));

        return $myWallets['wallets'];

    }
    function filtrosLeeWallet2B(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);

        $myWalletsB = fgets($myfile);
        
        $myGroupsB  = fgets($myfile);

        fclose($myfile);        

         $myWalletsB = json_decode($myWalletsB,true);
        // $myGroups = json_decode($myGroups);

        // \Log::info('lee myWallets -> ' . print_r($myWalletsB,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroupsB,true));

        return $myWalletsB['walletsB'];

    }

    function filtrosLeeGroup2(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

        // $myWallets = json_decode($myWallets,true);
         $myGroups = json_decode($myGroups,true);

        // \Log::info('lee myWallets -> ' . print_r($myWallets,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroups,true));

        return $myGroups['groups'];

    }
    

    function filtrosLeeGroup2B(){

        $myfile = fopen("myFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);

        $myWalletsB = fgets($myfile);
        
        $myGroupsB  = fgets($myfile);


        fclose($myfile);        

        // $myWallets = json_decode($myWallets,true);
         $myGroupsB = json_decode($myGroupsB,true);

        // \Log::info('lee myWallets -> ' . print_r($myWalletsB,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroupsB,true));

        return $myGroupsB['groupsB'];

    }

    function filtrosLeeEstadisticas(){

        $myfile = fopen("./filtros/myStatistics", "r") or die("Unable to open file!");

        
        $myOcultarresumengeneral        = fgets($myfile);
        $myOcultarresumentransaccion    = fgets($myfile);
        $mytransactions                 = fgets($myfile);

        fclose($myfile);  

        $myOcultarresumengeneral = json_decode($myOcultarresumengeneral);
        $myOcultarresumentransaccion = json_decode($myOcultarresumentransaccion);
        $mytransactions = json_decode($mytransactions);
        

        \Log::info('lee myOcultarresumengeneral -> ' . print_r($myOcultarresumengeneral,true));
        \Log::info('lee myOcultarresumentransaccion  -> ' . print_r($myOcultarresumentransaccion,true));
        \Log::info('lee mytransactions  -> ' . print_r($mytransactions,true));

        $myData['ocultarresumengeneral']        = $myOcultarresumengeneral->ocultarresumengeneral;
        $myData['ocultarresumentransaccion']    = $myOcultarresumentransaccion->ocultarresumentransaccion;
        $myData['transactions']                 = $mytransactions->transactions;

        // dd($myData);

        return $myData;

    }

    function filtrosLeeComisiones(){

        $myfile = fopen("./filtros/myCommissions", "r") or die("Unable to open file!");

        
        $myOcultarresumengeneral        = fgets($myfile);
        $myOcultarresumentransaccion    = fgets($myfile);
        $mytransactions                 = fgets($myfile);

        fclose($myfile);  

        $myOcultarresumengeneral = json_decode($myOcultarresumengeneral);
        $myOcultarresumentransaccion = json_decode($myOcultarresumentransaccion);
        $mytransactions = json_decode($mytransactions);
        

        // \Log::info('lee myOcultarresumengeneral -> ' . print_r($myOcultarresumengeneral,true));
        // \Log::info('lee myOcultarresumentransaccion  -> ' . print_r($myOcultarresumentransaccion,true));
        // \Log::info('lee mytransactions  -> ' . print_r($mytransactions,true));

        $myData['ocultarresumengeneral']        = $myOcultarresumengeneral->ocultarresumengeneral;
        $myData['ocultarresumentransaccion']    = $myOcultarresumentransaccion->ocultarresumentransaccion;
        $myData['transactions']                 = $mytransactions->transactions;

        // dd($myData);

        return $myData;

    }

    
    function filtrosLeeComisionesGrupo(){

        $myfile                         = fopen("./filtros/myCommissionsGrupo", "r") or die("Unable to open file!");

        $myOcultarresumengeneral        = fgets($myfile);
        $myOcultarresumentransaccion    = fgets($myfile);
        $mytransactions                 = fgets($myfile);

        fclose($myfile);  

        $myOcultarresumengeneral        = json_decode($myOcultarresumengeneral);
        $myOcultarresumentransaccion    = json_decode($myOcultarresumentransaccion);
        $mytransactions                 = json_decode($mytransactions);
        
        // \Log::info('lee myOcultarresumengeneral -> ' . print_r($myOcultarresumengeneral,true));
        // \Log::info('lee myOcultarresumentransaccion  -> ' . print_r($myOcultarresumentransaccion,true));
        // \Log::info('lee mytransactions  -> ' . print_r($mytransactions,true));

        $myData['ocultarresumengeneral']        = $myOcultarresumengeneral->ocultarresumengeneral;
        $myData['ocultarresumentransaccion']    = $myOcultarresumentransaccion->ocultarresumentransaccion;
        $myData['transactions']                 = $mytransactions->transactions;

        // dd($myData);

        return $myData;

    }


    public function filtrosGrabaEstadisticas(Request $request){

        // dd($request);

        \Log::info(' llega por filtro ocultarresumengeneral        ->' . print_r($request->ocultarresumengeneral,true));
        \Log::info(' llega por filtro ocultarresumentransaccion    ->' . print_r($request->ocultarresumentransaccion,true));
        \Log::info(' llega por filtro transactions                 ->' . print_r($request->transactions,true));

        $myfile = fopen("./filtros/myStatistics", "w") or die("Unable to open file!");

        $myLine = '{"ocultarresumengeneral" : ' . $request->ocultarresumengeneral . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"ocultarresumentransaccion" : ' . $request->ocultarresumentransaccion . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"transactions" : [' .implode(",",$request->transactions) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        fclose($myfile);   



        // dd($request);

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }    

    public function filtrosGrabaComisiones(Request $request){

        // dd($request);

        \Log::info(' filtrosGrabaComisiones - llega por filtro ocultarresumengeneral        ->' . print_r($request->ocultarresumengeneral,true));
        \Log::info(' filtrosGrabaComisiones - llega por filtro ocultarresumentransaccion    ->' . print_r($request->ocultarresumentransaccion,true));
        \Log::info(' filtrosGrabaComisiones - llega por filtro transactions                 ->' . print_r($request->transactions,true));

        $myfile = fopen("./filtros/myCommissions", "w") or die("Unable to open file!");

        $myLine = '{"ocultarresumengeneral" : ' . $request->ocultarresumengeneral . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"ocultarresumentransaccion" : ' . $request->ocultarresumentransaccion . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"transactions" : [' .implode(",",$request->transactions) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        fclose($myfile);   



        // dd($request);

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }    
    public function filtrosGrabaComisionesGrupo(Request $request){

        // dd($request);

        \Log::info(' filtrosGrabaComisiones - llega por filtro ocultarresumengeneral        ->' . print_r($request->ocultarresumengeneral,true));
        \Log::info(' filtrosGrabaComisiones - llega por filtro ocultarresumentransaccion    ->' . print_r($request->ocultarresumentransaccion,true));
        \Log::info(' filtrosGrabaComisiones - llega por filtro transactions                 ->' . print_r($request->transactions,true));

        $myfile = fopen("./filtros/myCommissionsGrupo", "w") or die("Unable to open file!");

        $myLine = '{"ocultarresumengeneral" : ' . $request->ocultarresumengeneral . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"ocultarresumentransaccion" : ' . $request->ocultarresumentransaccion . "}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"transactions" : [' .implode(",",$request->transactions) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        fclose($myfile);   



        // dd($request);

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }    
    public function update_status(Request $request, $transaction)
    {
        $transactions = Transaction::find($transaction);

        if($transactions->status == 'Activo'){
        Transaction::findOrFail($transaction)->update([
            'status' => 'Anulado',
        ]);
           return Redirect::route('transactions.index')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
        }
        elseif($transactions->status == 'Anulado'){
            Transaction::findOrFail($transaction)->update([
                'status' => 'Activo',
            ]);
            return Redirect::route('transactions.index')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
        }

    }



}

?>
