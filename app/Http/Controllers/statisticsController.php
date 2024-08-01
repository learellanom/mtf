<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Wallet;
use App\Models\Type_transaction;
use App\Models\Group;
// use App\Models\Supplier;
use App\Models\Transaction_master;
use App\Models\Transaction_supplier;
use App\Models\Commissions_usdt;
use App\Models\Materials_balance;
use App\Models\Type_coin;
use App\Models\Type_material;

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
use App\Http\Controllers\RoleController;


class statisticsController extends Controller
{

    private $myCreditsWallet    = "2,4,6,7,10,13,19,20,21,22,23,24,26";
    private $myDebitsWallet     = "1,3,5,8,9,11,12,14,15,16,17,18,25";

    private $myCredits          = "1,3,5,6,7,9,11,14,15,16,17,18,25";
    private $myDebits           = "2,4,8,10,12,13,19,20,21,22,23,24,26";

    private  $myTest;

    public function __construct() 
    {
        
        //$this->myTest = $this->getGroupRole(auth()->id());
        //\Log::info('leam - controller construct busco -> ' . print_r($this->myTest,true));

    }
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
    public function index_all2(Request $request)
    {
        \Log::info('Inicio index_all2');
        $myGroup        = 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;        
        if ($request->grupo) {
            $myGroup        = $request->grupo;
            $myGroupDesde   = $request->grupo;
            $myGroupHasta   = $request->grupo;
        }else{
            if ($request->group) {
                $myGroup        = $request->group;
                $myGroupDesde   = $request->group;
                $myGroupHasta   = $request->group;
            }
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
                $myTokenDesde       = "0";
                $myTokenHasta       = "ZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";        
            }
        }

        $balance        = "";
        $balanceBefore  = 0;


        $myCoin             = ($request->coin) ? $request->coin : 1;
     
        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();   


        if ($myGroup > 0){

            $balance            = $this->getBalance($myGroup, "2001-01-01" , "9999-12-31" ,$myCoin);
            $balanceBefore      = $this->getBalanceBefore($myGroup,$myFechaDesde, $myFechaHasta, $myCoin);

        }
        else
        {
            if ($myWallet > 0){
                
                $balance        = $this->getBalanceWallet($myWallet, "2001-01-01", "9999-12-31", $myCoin);
                
                $balanceBefore  = $this->getBalanceWalletBefore($myWallet,$myFechaDesde, $myFechaHasta, $myCoin);

            }
        };
        // dd($balance);


        $myUser         = 0;
        $myUserDesde    = 0;
        $myUserHasta    = 9999;

        if ($request->usuario) {
            $myUser = $request->usuario;
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;            
        }
        // \Log::info('leam - usuario    ->' . $request->usuario);
        // \Log::info('leam - user desde ->' . $myUserDesde);
        // \Log::info('leam - user hasta ->' . $myUserHasta);

        //  print_r($myGroup);
         // dd($myGroup);
        $Transacciones      = [];

        $myLimit            = 0;
        $myLimitDesde       = 0;
        $myLimitHasta       = 5000;

  
        
        $myLimitCondition   = "limit 1000";

        //\Log::info('leam - el user id es -> ' . $request->user()->id);
        //$Group_roles = app(RoleController::class)->getRoleWallets($request->user()->id);
        // $Group_roles = $this->getGroupRole($request->user()->id);
        $Group_roles = $this->getGroupRole(auth()->id());
        // \Log::info('leam - el user id es -> ' . print_r($Group_roles,true));
       
        
        //if ($myWallet == 0 and $myGroup == 0) {
        //    $myLimit            = 1000;
        //    $myLimitDesde       = 0;
        //   $myLimitHasta       = 1000;
        //}
        /*
        // Permite asignar que 
        // si es administrador vea todos los usuarios
        // si es usuario solo ve sus rtansacciones
        //
        if (!$request->usuario){
            if($this->isAdministrator()){
                $myUserDesde = auth()->user()->id;
                $myUserHasta = auth()->user()->id;

                $myUserDesde = 0;
                $myUserHasta = 9999;
            }
            else{
                $myUserDesde = auth()->user()->id;
                $myUserHasta = auth()->user()->id;
            }
        }
        */
        
        //\Log::info('leam usuario desde       ***    -> ' . $myUserDesde);
        //\Log::info('leam usuario hasta       ***    -> ' . $myUserHasta);

        // \Log::info('leam wallet desde   44444     ***    -> ' . $myWallet);
        //\Log::info('leam wallet desde        ***    -> ' . $myWalletDesde);
        //\Log::info('leam wallet hasta        ***    -> ' . $myWalletHasta);        

        //\Log::info('leam myGroup             ***    -> ' . $myGroup);        
        //\Log::info('leam group  desde        ***    -> ' . $myGroupDesde);
        //\Log::info('leam group  Hasta        ***    -> ' . $myGroupHasta);     

        //\Log::info('leam transaction         ***    -> ' . $myTypeTransactions);
        //\Log::info('leam transaction  desde  ***    -> ' . $myTypeTransactionsDesde);
        //\Log::info('leam transaction  Hasta  ***    -> ' . $myTypeTransactionsHasta);              
        

        // \Log::info('leam token desde         ***    -> ' . $myTokenDesde);
        // \Log::info('leam token hasta         ***    -> ' . $myTokenHasta);
        
        // \Log::info('leam fecha desde         ***    -> ' . $myFechaDesde);
        // \Log::info('leam fecha hasta         ***    -> ' . $myFechaHasta);
        
        // \Log::info('leam fecha desde request ***    -> ' . $request->fechaDesde);
        // \Log::info('leam fecha hasta request ***    -> ' . $request->fechaHasta);
        
        // \Log::info('leam Lmit                ***    -> ' . $myLimit);

        // \Log::info('leam - pasa sin  grupo');
        
        $busquedaGroup  = "";
        $busquedaWallet = "";
        
        if ($myGroup != 0 && $myWallet == 0){
            $busquedaGroup = " and group_id between $myGroup and $myGroup ";
        }
        // if ($myGroup == 0 && $myWallet == 0){
        //     $busquedaGroup = " and group_id between 0 and 999999 ";
        // }
        if ($myGroup == 0 && $myWallet != 0){
            $busquedaWallet  = " and wallet_id between $myWalletDesde and $myWalletHasta ";
        }
        if ($myGroup != 0 && $myWallet != 0){
            $busquedaGroup = " and group_id between $myGroupDesde and $myGroupHasta ";
            $busquedaWallet  = " and wallet_id between $myWalletDesde and $myWalletHasta ";
        }
        
        $busquedaGroupFilter      = "";
        $busquedaWalletFilter     = "";
        if ($myGroup != 0){
            if($Group_roles->allGroups == 0){
                $theGroups              = implode(",",$Group_roles->groups );
                $busquedaGroupFilter    = " and group_id in ($theGroups)";
            }
        }
        if ($myWallet != 0){
            if($Group_roles->allWallets == 0){
                $theWallets             = implode(",", $Group_roles->wallets);
                $busquedaWalletFilter   = " and wallet_id in ($theWallets)";
            }
        }
    
        //\Log::info("leam - busquedaGroupFilter -> $busquedaGroupFilter ");
        //\Log::info("leam - busquedaWalletFilter -> $busquedaWalletFilter ");
        
        $myQuery =
        "
            select
                Transactions.id                        as Id,
                Transactions.amount_foreign_currency   as MontoMoneda,
                Transactions.exchange_rate             as TasaCambio,
                Transactions.exchange_rate_base        as TasaCambioBase,
                Transactions.type_coin_id              as TipoMonedaId,
                type_coins.name                        as TipoMoneda,
                type_coins_balance.name                as TipoMonedaBalance,
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
                transactions.group_id                  as ClienteId,                    
                IFNULL(transactions.group_id,0)        as ClienteId2,
                mtf.groups.name                        as ClientName,
                IFNULL(transactions.token, '')         as token                    
            from
                    mtf.transactions
                left join mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
                left join mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
                left join mtf.users               on mtf.transactions.user_id             = mtf.users.id
                left join mtf.type_coins          on mtf.transactions.type_coin_id        = mtf.type_coins.id
                left join mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
                left join mtf.type_coins as type_coins_balance  on mtf.transactions.type_coin_balance_id        = type_coins_balance.id                
            where
                    status = 'Activo'
                and user_id             between $myUserDesde                and $myUserHasta 
                and type_transaction_id between $myTypeTransactionsDesde    and $myTypeTransactionsHasta 
                and transaction_date    between '$myFechaDesde  00:00:00'   and '$myFechaHasta 23:59:00' 
                and     type_coin_balance_id  = $myCoin
                $busquedaWallet 
                $busquedaGroup 
                $myTokenCondition
                $busquedaWalletFilter
                $busquedaGroupFilter
            order by
                Transactions.transaction_date desc
            $myLimitCondition
        ";
        
        // return $myQuery;
        //  \Log::info('leam - myQuery indexall2 ->' . $myQuery);

        $Transacciones = DB::select($myQuery);
        
        // }

        //  dd($Transacciones);
        // \Log::info('index transacciones -> ' . print_r($Transacciones,true));
        // die();

        $userole            = $this->getUser();
        $wallet             = $this->getWallet($Group_roles);
        $group              = $this->getGroups($Group_roles);

        // dd($wallet);

        // $typeTransactions   = $this->getTypeTransactions();
         $typeTransactions   = Type_transaction::orderBy('name','ASC')->pluck('name','id')->toArray();
        // switch ($Group_roles->allGroups){
        //     case 1:
        //         // \Log::info('leam - all groups -> ');
        //         $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->pluck('name', 'id')->toArray();
        //         break;
        //     case 0:
        //         // \Log::info('leam - algunos groups -> ');
        //         $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->groups)->pluck('name', 'id')->toArray();
                


        //         break;
        // }
        //  $group = $group2;
        // \Log::info('leam - wallet2 -> ' . print_r($wallet2,true));
        // \Log::info('leam - group2 -> ' . print_r($group2,true));


        if ($Group_roles->allGroups == 0){
            if ($myWallet == 0){
                $existGroup = 0;
                foreach($Group_roles->groups as  $value){
                    // \Log::info("leam - key -> $value y el mygroup -> $myGroup");
                    if ($value == $myGroup){
                        $existGroup = 1;
                    }
                }
                // \Log::info("leam -  - existgroup $existGroup es " );

                // \Log::info("leam -  - array keys es " . print_r(array_keys($Group_roles->groups, true)));


                if ($existGroup == 0 ){
                    $balance        = 0;
                    $balanceBefore  = 0;
                }
            }
        }

        if ($Group_roles->allWallets == 0){
            if ($myWallet !=  0){
            $existWallet = 0;
            foreach($Group_roles->wallets as  $value){
                // \Log::info("leam - key -> $value y el myWallet -> $myWallet");
                if ($value == $myWallet){
                    $existWallet = 1;
                }
            }
            // \Log::info("leam -  - existgroup $existGroup es " );

            // \Log::info("leam -  - array keys es " . print_r(array_keys($Group_roles->groups, true)));


            if ($existWallet == 0 ){
                $balance        = 0;
                $balanceBefore  = 0;
            }
            }
        }


        if ($myFechaDesde === "2001-01-01"){
            $myFechadesdeInvertida = "";
        }else{
            $myFechaDesdeBefore     = $this->getDayBefore($myFechaDesde);
            $myFechadesdeInvertida  = substr($myFechaDesdeBefore,8,2) . "-" . substr($myFechaDesdeBefore,5,2) . "-" . substr($myFechaDesdeBefore,0,4);
        }

        $parametros['myTypeCoinBalance']        = $myTypeCoinBalance;
        $parametros['Type_coin_balance']        = $Type_coin_balance;

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
        
        // $myQuery2 = $this->index_all2($request);
        // \Log::info('leam Myquery new ->' . $myQuery2);
        // \Log::info('leam Myquery new ->' . $request->usuario);

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
                    IFNULL(transactions.group_id,0)        as ClienteId,
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
        // \Log::info('leam - index transacciones -> ' . print_r($Transacciones,true));
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
    *       fechaTokensSummary
    * 
    *
    */
    public function fechaTokensSummary(Request $request)
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

        //

        $myCoin             = ($request->coin) ? $request->coin : 1;

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::orderBy('name','ASC')->pluck('name', 'id')->toArray();


        $Group_roles = $this->getGroupRole(auth()->id());
		// \Log::info('leam - el user id es -> ' . print_r($Group_roles,true));

        $busquedaWalletFilter     = "";
        if(isset($Group_roles->allWallets)){
            if($Group_roles->allWallets == 0){
                $theWallets             = implode(",", $Group_roles->wallets);
                $busquedaWalletFilter   = " and wallet_id in ($theWallets)";
            }
        }

        $busquedaGroupFilter      = "";
        if(isset($Group_roles->allGroups)){        
            if($Group_roles->allGroups == 0){
                $theGroups              = implode(",",$Group_roles->groups );
                $busquedaGroupFilter    = " and group_id in ($theGroups)";
            }
        }
        /*
        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                substring(transaction_date,1,10)    as fechaTransaccion,
                count(*)                            as cant_transactions,
                sum(amount)                         as total_amount,
                sum(amount_commission)              as total_commission,
                sum(amount_total)                   as total'))
            ->where('status','<>','Anulado')
            ->where('token','<>','')
            ->where('type_coin_balance_id','=',$myCoin)
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:59"])
            ->groupBy('fechaTransaccion')
            ->orderBy('fechaTransaccion', 'DESC')
            ->get();
          */  


            
        $myQuery =
        "
            select
                substring(transaction_date,1,10)    as fechaTransaccion,
                count(*)                            as cant_transactions,
                sum(amount)                         as total_amount,
                sum(amount_commission)              as total_commission,
                sum(amount_total)                   as total
            from
                mtf.transactions
            where
                    status = 'Activo'
                and Token <> '' 
                and transaction_date        between '$myFechaDesde  00:00:00'   and '$myFechaHasta 23:59:00' 
                and type_coin_balance_id    = $myCoin 
                $busquedaWalletFilter 
                $busquedaGroupFilter 
            group by
                fechaTransaccion
            order by
                fechaTransaccion DESC
            limit 300
        ";
        $Transacciones = DB::select($myQuery);
        

        // dd($myQuery);
        // dd($Transacciones);
        // \Log::info('leam My query *** -> ' . $myQuery);



        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;

        $parametros['Transacciones']        = $Transacciones;
        $parametros['myFechaDesde']         = $myFechaDesde;
        $parametros['myFechaHasta']         = $myFechaHasta;

        // \Log::info('leam - myFechaDesde ->' . $myFechaDesde);

        return view('estadisticas.statisticsFechaTokens', $parametros);
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

        $myWallet       = ($request->wallet)        ? $request->wallet      : 0;
        $fechaDesde     = ($request->fechaDesde)    ? $request->fechaDesde  : '2001-01-01';  
        $fechaHasta     = ($request->fechaHasta)    ? $request->fechaHasta  : '9999-12-31';
        $myCoin         = ($request->coin)          ? $request->coin        : 1;

        $Group_roles = $this->getGroupRole(auth()->id());

        $Transacciones  = $this->getBalanceWallet($myWallet, $fechaDesde, $fechaHasta, $myCoin);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $wallets            = $this->getWallet($Group_roles);
		$myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
		$Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();

        $parametros['myFechaDesde'] = $fechaDesde;
        $parametros['myFechaHasta'] = $fechaHasta;

        $parametros['myWallet']             = $myWallet;
        $parametros['wallets']              = $wallets;
        $parametros['Transacciones']        = $Transacciones;

        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;

        // aquix
        return view('estadisticas.statisticsResumenWallet', $parametros);
    }

   /*
    *
    *
    *   getwalletSummary
    *
    *
    */
     function getWalletSummary(Request $request) {

        $myWallet       = ($request->wallet)        ? $request->wallet      : 0;
        $fechaDesde     = ($request->fechaDesde)    ? $request->fechaDesde  : '2001-01-01';  
        $fechaHasta     = ($request->fechaHasta)    ? $request->fechaHasta  : '9999-12-31';
        $myCoin         = ($request->coin)          ? $request->coin        : 1;

        // dd($fechaDesde . " - " . $fechaHasta);
        $Transacciones  = $this->getBalanceWallet($myWallet, $fechaDesde, $fechaHasta, $myCoin);
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
        // \Log::info('leam - walletTransactionSummary ->' . $theDate);

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



        $Group_roles = $this->getGroupRole(auth()->id());


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
    

        $myCoin                             = ($request->coin) ? $request->coin : 1;
        $myTypeCoinBalance                  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance                  = Type_coin::pluck('name', 'id')->toArray();


        $Type_transactions                  = $this->getTypeTransactions();
        $wallet                             = $this->getWallet($Group_roles);

        // dd($Transacciones);             
        // dd($Transacciones2);
		$parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;

        $parametros['myWallet']             = $myWallet;
        $parametros['wallet']               = $wallet;
        $parametros['myTypeTransaction']    = $myTypeTransaction;
        $parametros['Type_transactions']    = $Type_transactions;
        $parametros['Transacciones']        = $Transacciones;
        $parametros['myFechaDesde']         = $myFechaDesde;
        $parametros['myFechaHasta']         = $myFechaHasta;
        $parametros['balance']              = $balance;

        // \Log::info('leam - statisticscontroller - myFechaDesde ->' . $myFechaDesde);
        // \Log::info('leam - statisticscontroller - myFechaHasta ->' . $myFechaHasta);

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

		$myCoin = ($request->coin) ? $request->coin : 1;

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        

        $Group_roles = $this->getGroupRole(auth()->id());




        // $Transacciones1         = $this->getWalletTransactionSummary($request);
        $Transacciones2         = $this->getWalletTransactionGroupSummary($request);
        $groups                 = $this->getGroups($Group_roles);

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
        $Type_transactions  = Type_transaction::orderBy('name','ASC')->pluck('name','id')->toArray();
        $wallet             = $this->getWallet($Group_roles);

        // dd($Transacciones2); 
        // dd($Transacciones2);

        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;
        
        $parametros['myWallet']             = $myWallet;
        $parametros['wallet']               = $wallet;
        
        $parametros['myTypeTransaction']    = $myTypeTransaction;
        $parametros['Type_transactions']    = $Type_transactions;

        $parametros['Transacciones']        = $Transacciones;

        $parametros['myFechaDesde']         = $myFechaDesde;
        $parametros['myFechaHasta']         = $myFechaHasta;

        $parametros['balance']              = $balance;
        $parametros['groups']               = $groups;

        $parametros['myGroup']              = $myGroup;
        $parametros['balanceDetail']        = $balanceDetail;
        $parametros['myFechaDesdeBefore']   = $myFechaDesdeBefore;
        $parametros['myFechaHastaBefore']   = $myFechaHastaBefore;


        return view('estadisticas.statisticsResumenWalletTransaccionGroup', $parametros);

        

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
        
        $Group_roles = $this->getGroupRole(auth()->id());

        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        $myWallet        = 0;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
            $myWallet        = $request->wallet;
        }

        $myCoin                             = ($request->coin) ? $request->coin : 1;
//      dd($myCoin);

        if ($Group_roles->allWallets == 1){

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
            ->where('type_coin_balance_id', '=',$myCoin)
            ->groupBy('WalletId', 'WalletName', 'TypeTransactionId', 'TypeTransaccionName')
            ->orderBy('WalletId','ASC')
            ->orderBy('TypeTransactionId','ASC')
            ->get();
        }else{

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
            ->whereIn('wallet_id', $Group_roles->wallets)
            ->where('type_coin_balance_id', '=',$myCoin)
            ->groupBy('WalletId', 'WalletName', 'TypeTransactionId', 'TypeTransaccionName')
            ->orderBy('WalletId','ASC')
            ->orderBy('TypeTransactionId','ASC')
            ->get();            
        }
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

            $myFechaDesde2 = $myFechaDesde;
            $myFechaHasta2 = $myFechaHasta;
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta;
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

       $myCoin = ($request->coin) ? $request->coin : 1;

       $Group_roles = $this->getGroupRole(auth()->id());
       // \Log::info('leam - getWalletTransactionGroupSummary - el user id es -> ' . print_r($Group_roles,true));



       $busquedaWalletFilter     = "";
       if (isset($Group_roles->allWallets)){
            if($Group_roles->allWallets == 0){
                $theWallets             = implode(",", $Group_roles->wallets);
                $busquedaWalletFilter   = " and wallet_id in ($theWallets)";
            }
        }


        $busquedaGroupFilter      = "";
        if (isset($Group_roles->allGroups)){
            if($Group_roles->allGroups == 0){
                $theGroups              = implode(",",$Group_roles->groups );
                $busquedaGroupFilter    = " and group_id in ($theGroups)";
            }
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
        and     type_coin_balance_id  = $myCoin
        $condicionGroup       
        $busquedaWalletFilter     
        $busquedaGroupFilter       
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
        // \Log::info('leam *** $myQuery getWalletTransactionGroupSummary -> ' . $myQuery);
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


        $myCoin         = ($request->coin) ? $request->coin : 1;

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
        and     mtf.Transactions.type_coin_balance_id  = $myCoin 
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


        $myCoin         = ($request->coin)          ? $request->coin        : 1;
        
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
        and     type_coin_balance_id  = $myCoin    
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
        // echo "aqui" . $request->fullUrl();
        // die();

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
            // $myFechaHasta = $myFechaHasta;        
        }
       
        $myCoin = 1;
        if ($request->coin){
            $myCoin = $request->coin;
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

        $Transacciones      = $this->getGroupSummary($request);

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();
        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups();

        // dd($Transacciones);
        // dd($Type_coin_balance);

        $parametros['myTypeCoinBalance']        = $myTypeCoinBalance;
        $parametros['Type_coin_balance']        = $Type_coin_balance;
        $parametros['myGroup']                  = $myGroup;
        $parametros['groups']                   = $groups;
        $parametros['Type_transactions']        = $Type_transactions;
        $parametros['Transacciones']            = $Transacciones;
        $parametros['myFechaDesde']             = $myFechaDesde;
        $parametros['myFechaHasta']             = $myFechaHasta;
        // return view('estadisticas.statisticsResumenGrupo', compact('myGroup','groups','Type_transactions','Transacciones'));

        return view('estadisticas.statisticsResumenGrupo', $parametros);
    }

    /*
    *
    *
    *       groupSummary2
    *       resumen por grupo
    *
    */
    public function groupSummary2(Request $request)
    {
        // echo "aqui" . $request->fullUrl();
        // die();

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
            // $myFechaHasta = $myFechaHasta;        
        }
       
        $Group_roles = $this->getGroupRole(auth()->id());

        $myCoin = 1;
        if ($request->coin){
            $myCoin = $request->coin;
        }
        $Transacciones      = $this->getBalance2($myGroup, $myFechaDesde, $myFechaHasta, $myCoin);
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }        

        // $Transacciones      = $this->getGroupSummary($request);

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();
        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups($Group_roles);

        // dd($Transacciones);
        // dd($Type_coin_balance);

        $parametros['myTypeCoinBalance']        = $myTypeCoinBalance;
        $parametros['Type_coin_balance']        = $Type_coin_balance;
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
        
        $myCoin = 1;
        if($request->coin){
            $myCoin = $request->coin;
        }
        // leam
        // dd('leam - aqui -> ' . $request->query('coin'));
        $Transacciones      = $this->getBalance($myGroup, $myFechaDesde, $myFechaHasta, $myCoin);

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
    *   Carga los grupos id y nombre
    *
    */
    function getGroups($Group_roles = null){

        // $group = Group::select('groups.id', 'groups.name')
        //         ->where('type','=','1')
        //         ->orderBy('groups.name')
        //         ->get();

        // $group2 = array();
        // foreach($group as $gr){
        //     $group2 [$gr->id] =  $gr->name;
        // }
        // return $group2;



        if (isset($Group_roles->allGroups)){
            switch ($Group_roles->allGroups){
                case 1:
                    // \Log::info('leam - all groups -> ');
                    // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
                case 0:
                    // \Log::info('leam - algunos groups -> ');
                    // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->groups)->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->groups)->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
            }
            // dd($group2);
            
        } else {
            $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        }

        // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();

        // echo "aqui - general";
        // echo "<pre>";
        // echo print_r($group2,true);
        // echo "</pre>";
        // die();

        return $group2;
    }
    
    /*
    *
    *
    *    Carga los tipos de transacciones
    *
    *
    */
    function getTypeTransactions(){
        // 
        /*
        $Type_transactions = Type_transaction::select('type_transactions.id', 'type_transactions.name')
        ->get();
        $Type_transactions2 = array();
        foreach($Type_transactions as $Type_transactions){
            $Type_transactions2 [$Type_transactions->id] =  $Type_transactions->name;
        }
        // $Type_transactions = Type_transaction::select('type_transactions.id', 'type_transactions.name')->get();
        */
        // echo "aaa222";
        $Type_transactions2 = Type_transaction::pluck('name', 'id')->toArray();
        // dd($Type_transactions);
        return $Type_transactions2;
    }
    /*
    *
    *
    *    Carga los tipos de transacciones con detalles
    *
    *
    */
    function getTypeTransactionsDetail($myTypeTransaction = 0){
        if ($myTypeTransaction == 0){
            $Type_transactionsDetail = Type_transaction::all();
        }else{
            $Type_transactionsDetail = Type_transaction::where('type_transaction_id','=',$myTypeTransaction)->get();
        }
        return $Type_transactionsDetail;
    }
    /*
    *
    *
    *    busca detalle tipo transaccion
    *
    *
    */
    function getTypeTransactionDetail($myTypeTransaction){
        $Type_transaction = Type_transaction::select('type_transactions.id', 'type_transactions.name')
        ->where('type_transaction_id','=', $myTypeTransaction)
        ->get();
        return $Type_transaction;
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
    function getWallet($Group_roles = null){

        //    \Log::info('leam -  Group_roles -> ' . print_r($Group_roles,true));


        // $wallet2 = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->pluck('name', 'id')->toArray();
        // return $wallet2;
        

        //\Log::info('leam - wallet3 -> ' . print_r($wallet2, true));
        //\Log::info('leam - myTest -> ' . print_r($this->myTest,true));
        
        if (isset($Group_roles->allWallets)){
            switch ($Group_roles->allWallets){
                case 1:
                    \Log::info('leam - all wallets -> ');
                    $wallet2 = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
                case 0:
                    \Log::info('leam - algunos wallets -> ');
                    \Log::info('leam - algunos wallets - group_roles -> ' . print_r($Group_roles,true));
                    $wallet2 = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->wallets)->orderBY('name','ASC')->pluck('name', 'id')->toArray();     
                    $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->wallets)->orderBY('name','ASC')->pluck('name', 'id')->toArray();     
                    break;

            }
            \Log::info('leam - statisticsController - getWallet -> ' . print_r($wallet2,true));
            return $wallet2;
        }


        $wallet2 = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        $wallet2 = Group::whereIn('type', [2,3])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        \Log::info('leam - statisticsController - getWallet general -> ' . print_r($wallet2,true));
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
    function getBalance($grupo = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31", $typeCoin = 1){

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
                and status                  <> 'Anulado'
                and mtf.groups.type         = 1
                and type_coin_balance_id    = $typeCoin
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
                and type_coin_balance_id    = $typeCoin         
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

        //  dd($myQuery);
        // \Log::info($myQuery);
        

        $Transacciones = DB::select($myQuery);

        // dd($Transacciones);
        // \Log::info($Transacciones);

        if (empty($Transacciones)) {
            return $Transacciones;
        }else {
            if ($grupoDesde === $grupoHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    /*
    *
    *
    *       getBalance2
    *
    *
    */
    function getBalance2($grupo = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31", $typeCoin = 1){

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

        // echo $myFechaDesde;
        // die();

        $myTempCredits  = $this->getCredits();
        $myTempDebits   = $this->getDebits();

        //
        //
        //
        $Group_roles = $this->getGroupRole(auth()->id());
        // \Log::info('leam - getBalance2 - Group_roles -> ' . print_r($Group_roles,true));

        $busquedaGroupFilter      = "";
        $busquedaWalletFilter     = "";
        if (isset($Group_roles)){
            \Log::info('leam - getBalance2  - entro con grupo ->' . $grupo);
            
                if($Group_roles->allGroups == 0){
                    $theGroups              = implode(",",$Group_roles->groups );
                    $busquedaGroupFilter    = " and group_id in ($theGroups)";
                }
            
        }

        $myQuery =
        "
        SELECT 
            group_id                                                                        as IdGrupo,
            mtf.groups.name                                                                 as NombreGrupo,
            count(group_id)                                                                 as Cant,
            sum(amount_total)                                                               as TotalAmount,
            sum(if(type_transaction_id in ($myTempDebits),  amount_total,0))                 as Debitos,
            sum(if(type_transaction_id in ($myTempCredits), amount_total, 0))               as Creditos,
            sum(if(type_transaction_id in ($myTempCredits), amount_total, -amount_total))   as Total
        FROM mtf.transactions
            left join mtf.groups on mtf.transactions.group_id                       = mtf.groups.id
            left join mtf.type_transactions on mtf.transactions.type_transaction_id = mtf.type_transactions.id
        where 
            group_id                between $grupoDesde                 and $grupoHasta
        and transaction_date        between '$myFechaDesde 00:00:00'    and '$myFechaHasta 23:59:00'
        and status                  <> 'Anulado'
        and type_coin_balance_id    = $typeCoin
        and mtf.groups.type = 1   
        $busquedaGroupFilter 
        group by
            IdGrupo,
            NombreGrupo   
        ";
        //  dd($myQuery);
        // \Log::info('leam - getBalance2 - myQuery -> ' . $myQuery);

        $Transacciones = DB::select($myQuery);

        // dd($Transacciones);


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
    function getBalanceBefore($myGroup = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31", $myCoin = 1){


        \Log::info('paso en before ');
        \Log::info('paso en before - myFechaDesde ->' . $myFechaDesde);
        \Log::info('paso en before - myFechaHasta ->' . $myFechaHasta);
        \Log::info('paso en before - myCoin       ->' . $myCoin);


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
                $myFechaDesdeBefore = $myFechaDesde;
                $myFechaHastaBefore = $this->getDayBefore($myFechaDesde);

            }
            
        

            $balance3           = $this->getBalance($myGroup, $myFechaDesdeBefore, $myFechaHastaBefore, $myCoin);
            // dd('las fechas - ' . $balance3->Total . ' grupo ' . $myGroup . 'fecha desde -> ' . $myFechaDesdeBefore . ' fecha hasta -> ' . $myFechaHastaBefore);
            if(isset($balance3->Total)){
                $balanceDetail  = $balance3->Total;
            }else{
                $balanceDetail = 0;
            }
        }
        
        \Log::info('Balance detail -> ' . $balanceDetail);
        
        return $balanceDetail;   
    }    
    /*
    *
    *
    *       getBalanceWalletBefore
    *
    *
    */
    function getBalanceWalletBefore($myWallet = 0, $myFechaDesde = "2001-01-01", $myFechaHasta = "9999-12-31", $myCoin = 1){

        $myFechaDesdeBefore = "2001-01-01";
        $myFechaHastaBefore = "9999-12-31";
        $balance3 = 0;

        $balanceDetail = 0;

        \Log::info('leam getBalanceBefore -> $myWallet      ' . $myWallet);
        \Log::info('leam getBalanceBefore -> $myFechaDesde  ' . $myFechaDesde);
        \Log::info('leam getBalanceBefore -> $myFechaHasta  ' . $myFechaHasta);
        \Log::info('leam getBalanceBefore -> $myCoin        ' . $myCoin);


        if ($myFechaDesde === "2001-01-01"){
            return $balanceDetail;
        }

        if ($myWallet > 0){
            // dd($indRecibeFecha);                
            if ($myFechaDesde != "2001-01-01"){

                $myFechaHastaBefore = $this->getDayBefore($myFechaDesde);

            }
            $balance3           = $this->getBalanceWallet($myWallet, $myFechaDesdeBefore, $myFechaHastaBefore, $myCoin);
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
    function getBalanceWallet($wallet = 0, $fechaDesde = "2001-01-01", $fechaHasta = "9999-12-31", $myCoin = 1){

        if ($wallet === 0){
            $walletDesde = 00000;
            $walletHasta = 99999;

        }else{
            $walletDesde = $wallet;
            $walletHasta = $wallet;
        }
         \Log::info('leam  getBalanceWallet - wallet      *** -> ' . $wallet);
         \Log::info('leam  getBalanceWallet - fecha Desde *** -> ' . $fechaDesde);
         \Log::info('leam  getBalanceWallet - fecha Hasta *** -> ' . $fechaHasta);
         \Log::info('leam  getBalanceWallet - coin        *** -> ' . $myCoin);

        $horaDesde      = " 00:00:00";
        $horaHasta      = " 23:59:00";

        $myFechaDesde   = $fechaDesde . $horaDesde;
        $myFechaHasta   = $fechaHasta . $horaHasta;

        $myTable        = "mtf.transactions";



        $myTempCredits  = $this->getWalletCredits();
        $myTempDebits   = $this->getWalletDebits();

        $Group_roles    = $this->getGroupRole(auth()->id());


        $busquedaWalletFilter     = "";

        if($Group_roles->allWallets == 0){
            $theWallets             = implode(",", $Group_roles->wallets);
            $busquedaWalletFilter   = " and wallet_id in ($theWallets)";
        }


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
            sum(Cant)                                       as Cant,
            sum(Monto)                                      as Monto,        
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
                count(*)                        as Cant,
                sum(amount)                     as Monto,
                0 				                as MontoCreditos,
                sum(amount_total_base)          as MontoDebitos,
                sum(amount_commission)          as MontoComision,
                sum(amount_commission_base)     as MontoComisionBase,
                sum(amount_commission_profit)   as MontoComisionProfit
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($myTempDebits)
                and
                transaction_date            between '$myFechaDesde' and '$myFechaHasta'
                and
                wallet_id                   between $walletDesde and $walletHasta
                and status                  <> 'Anulado'
                and type_coin_balance_id    = $myCoin
                $busquedaWalletFilter 
            group by
                IdWallet,
                NombreWallet
        union
            SELECT
                wallet_id                       as IdWallet,
                mtf.groups.name                 as NombreWallet,
                count(*)                        as Cant,   
                sum(amount)                     as Monto,                        
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
                and type_coin_balance_id = $myCoin 
                $busquedaWalletFilter         
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

        \Log::info('leam getBalanceWallet - query        *** -> ' . print_r($myQuery,true));
        \Log::info('leam getBalanceWallet - transcciones *** -> ' . print_r($Transacciones,true));

        if (empty($Transacciones)) {    
            return $Transacciones;
        }else {
            if ($walletDesde === $walletHasta){
                return $Transacciones[0];
            };
            return $Transacciones;
        }
    }
    /*
    *
    *
    *       getBalanceWallet2
    *
    *
    */
    function getBalanceWallet2($wallet = 0, $fechaDesde = "2001-01-01", $fechaHasta = "9999-12-31", $myCoin = 1){

        if ($wallet === 0){
            $walletDesde = 00000;
            $walletHasta = 99999;

        }else{
            $walletDesde = $wallet;
            $walletHasta = $wallet;
        }
         \Log::info('leam wallet      getBalanceWallet2 *** -> ' . $wallet);
         \Log::info('leam fecha Desde getBalanceWallet2 *** -> ' . $fechaDesde);
         \Log::info('leam fecha Hasta getBalanceWallet2 *** -> ' . $fechaHasta);
         \Log::info('leam coin        getBalanceWallet2 *** -> ' . $myCoin);

        $horaDesde      = " 00:00:00";
        $horaHasta      = " 23:59:00";

        $myFechaDesde   = $fechaDesde . $horaDesde;
        $myFechaHasta   = $fechaHasta . $horaHasta;

        $myTable        = "mtf.transactions";

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
            sum(Cant)                                       as Cant,
            sum(Monto)                                      as Monto,        
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
                count(*)                        as Cant,
                sum(amount)                     as Monto,
                0 				                as MontoCreditos,
                sum(amount_total_base)          as MontoDebitos,
                sum(amount_commission)          as MontoComision,
                sum(amount_commission_base)     as MontoComisionBase,
                sum(amount_commission_profit)   as MontoComisionProfit
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($myTempDebits)
                and
                transaction_date            between '$myFechaDesde' and '$myFechaHasta'
                and
                wallet_id                   between $walletDesde and $walletHasta
                and status                  <> 'Anulado'
                and type_coin_balance_id    = $myCoin
            group by
                IdWallet,
                NombreWallet
        union
            SELECT
                wallet_id                       as IdWallet,
                mtf.groups.name                 as NombreWallet,
                count(*)                        as Cant,   
                sum(amount)                     as Monto,                        
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
                and type_coin_balance_id = $myCoin                
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

          \Log::info('leam - getBalanceWallet2 *** -> ' . print_r($myQuery,true));
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



    function commissionProfitGenera(){

        $myQuery =
            "
            SELECT
                user_id,
                name,
                substr(mtf.commissions_usdt.created_at,1,10) as created_at2
            FROM mtf.commissions_usdt
            left join
                mtf.users on mtf.commissions_usdt.user_id = mtf.users.id
            group by
                user_id,
                name,
                created_at2
            ";

        // dd($myQuery);
        
        $comisionesUSDT = DB::select($myQuery);
        
        // dd($comisionesUSDT);

        // return redirect()->route("home");
        if( count($comisionesUSDT) > 0){
            $comisionesUSDT = (object) $comisionesUSDT[0];
        }else{

        
        }

        

        $parametros ['comisionesUSDT'] = $comisionesUSDT;
        // dd($parametros);
        return view('dashboardComisionesUSDTGenera', $parametros);

    }
    function commissionProfitProcess(){
        
        // buscar cajas que realizan pagos usdt
        
        Commissions_usdt::truncate();

        
        //
        // Determina todas las cajas que han recibido pagos usdt (11)
        //
        $myTransaction = 11;
        $myQuery =
        "
            select
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName
            from
                        mtf.transactions
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id                        
            where
                    status              = 'Activo'
                and type_transaction_id = $myTransaction
                and wallet_id = 93
            group by
                wallet_id,
                wallets.name
        ";

        // dd($myQuery);
        
        $cajasUSDT = DB::select($myQuery);
        // dd($cajasUSDT);
        
        $myRequest = new Request();
        
        $transacciones = [];
        foreach($cajasUSDT as $pos => $myCaja){
            
            $myRequest->wallet = $myCaja->WalletId;

            list($Recargas, $Transacciones2) = $this->commissionsProfit($myRequest);
            $transacciones [] = $Transacciones2;
            // echo "<br>";
            // echo "paso con -> " . $pos . " con el count ->" . count($Transacciones2);
            if ($pos == 2){
                // dd($Transacciones2);


                foreach($Transacciones2 as $key => $transaccion){

                    $CommissionUsdt = new Commissions_usdt;

                    $CommissionUsdt->transaction_id             = $transaccion->Id;
                    $CommissionUsdt->amount                     = $transaccion->Amount;
                    $CommissionUsdt->amount2                    = $transaccion->Amount2;
                    $CommissionUsdt->amount_commission          = $transaccion->AmountCommission;
                    $CommissionUsdt->percentage                 = $transaccion->Percentage;
                    $CommissionUsdt->type_transaction_id        = $transaccion->TypeTransactionId;
                    $CommissionUsdt->user_id                    = auth()->user()->id;
                    // $CommissionUsdt->user_id                    = 2;
                    $CommissionUsdt->group_id                   = $transaccion->GroupId;
                    $CommissionUsdt->wallet_id                  = $transaccion->WalletId;
                    $CommissionUsdt->transaction_date           = $transaccion->TransactionDate;
                    $CommissionUsdt->percentage_base            = $transaccion->PercentageBase;
                    $CommissionUsdt->amount_commission_base     = $transaccion->AmountCommissionBase;
                    $CommissionUsdt->amount_commission_profit   = $transaccion->AmountCommissionProfit;
            
                    $CommissionUsdt->reload_id                  = $transaccion->RecargaId;
                    $CommissionUsdt->reload_amount              = $transaccion->RecargaAmount;
                    $CommissionUsdt->reload_percentage_base     = $transaccion->RecargaPercentageBase;
                    $CommissionUsdt->reload_balance             = $transaccion->RecargaSaldo;
            
                    $CommissionUsdt->save();

                }

            }
            
        }
        
        return response()->json(['success' => true, 'result' => 'Procesadas', 'message' => 'Comisiones procesadas con exito'], 200);


        echo "leam - aqui -> " . auth()->id() . "-----";
        die();
        dd("leam - aqui -> " . auth()->id() . "-----");
        //foreach($transaccioness as $key => $transaccion){
        // $CommissionUsdt = new Commission_usdt;

        // $CommissionUsdt->amount                     = $transaccion->Amount;
        // $CommissionUsdt->amount2                    = $transaccion->Amount2;
        // $CommissionUsdt->amount_commission          = $transaccion->AmountCommission;
        // $CommissionUsdt->percentage                 = $transaccion->Percentage;
        // $CommissionUsdt->type_transaction_id        = $transaccion->TypeTransactionId;
        // $CommissionUsdt->user_id                    = $user
        // $CommissionUsdt->group_id                   = $transaccion->GroupId;
        // $CommissionUsdt->wallet_id                  = $transaccion->WalletId;
        // $CommissionUsdt->transaction_date           = $transaccion->TransactionDate;
        // $CommissionUsdt->percentage_base            = $transaccion->PercentageBase;
        // $CommissionUsdt->amount_commission_base     = $transaccion->AmountCommissionBase;
        // $CommissionUsdt->amount_commission_profit   = $transaccion->AmountCommissionProfit;

        // $CommissionUsdt->reload_id                  = $transaccion->RecargaId;
        // $CommissionUsdt->reload_amount              = $transaccion->RecargaAmount;
        // $CommissionUsdt->reload_percentage_base     = $transaccion->RecargaPercentageBase;
        // $CommissionUsdt->reload_balance             = $transaccion->RecargaSaldo;

        // $CommissionUsdt->save();
        //}

    }


    function materialsCierreGenera(){

                 
         
        $materialsCierre =  $this->materialBuscaCierre();

        $parametros ['materialsCierre '] = $materialsCierre;
        //  dd($parametros);
        // return view('estadisticas.materialsCierreGenera', $parametros);
        return view('estadisticas.materialsCierreGenera', ['materialsCierre' => $materialsCierre]);

    }
    function materialBuscaCierre(){

        $myQuery =
            "
            SELECT
                user_id,
                name,
                substr(mtf.materials_balance.created_at,1,10) as created_at2
            FROM mtf.materials_balance
            left join
                mtf.users on mtf.materials_balance.user_id = mtf.users.id
            group by
                user_id,
                name,
                created_at2
            ";

        $materialsCierre = DB::select($myQuery);

        if (count($materialsCierre) > 0) {
             $materialsCierre  = (object) $materialsCierre[0];
        }
        
        return $materialsCierre;

    }
    /*
    *
    *
    *       getComissions3
    *       lee comisiones usdt de la tabla commissions_usdt
    *
    */
    function commissionsProfit3(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt
        
        $request->transaction   = 11; // 11 pago usdt y 13 cobro usdt

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
        /*
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

        $myTransactionDesde     = 13; // 13 cobros usdt
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
                 1.5                                             as PercentageBase,
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
        */
        $Recargas3 = [];
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
                mtf.commissions_usdt.id                                 as Id,
                mtf.commissions_usdt.transaction_id                     as TransactionId,
                mtf.commissions_usdt.wallet_id                          as WalletId,
                wallets.name                                            as WalletName,
                mtf.commissions_usdt.group_id                           as GroupId,
                lcase(mtf.groups.name)                                  as GroupName,
                mtf.commissions_usdt.type_transaction_id                as TypeTransactionId,
                type_transactions.name                                  as TypeTransactionName,
                transaction_date                                        as TransactionDate,
                percentage                                              as Percentage,
                percentage_base                                         as PercentageBase,
                mtf.commissions_usdt.amount                             as Amount,
                mtf.commissions_usdt.amount2                            as Amount2,
                mtf.commissions_usdt.amount_commission                  as AmountCommission,
                mtf.commissions_usdt.amount_commission_base             as AmountCommissionBase,
                mtf.commissions_usdt.amount_commission_profit           as AmountCommissionProfit,
                mtf.commissions_usdt.reload_id                          as RecargaId,
                mtf.commissions_usdt.reload_amount                      as RecargaAmount,
                mtf.commissions_usdt.reload_percentage_base             as RecargaPercentageBase,
                mtf.commissions_usdt.reload_balance                     as RecargaSaldo
            from
                        mtf.commissions_usdt
            left join   mtf.type_transactions   on mtf.commissions_usdt.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.commissions_usdt.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.commissions_usdt.group_id            = mtf.groups.id
            where
                    wallet_id           between $myWalletDesde              and     $myWalletHasta
                and type_transaction_id between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date    between '$myFechaDesde'             and     '$myFechaHasta'
        ";
        
        // $Transacciones = [];
        $Transacciones = DB::select($myQuery);
        // dd($myQuery);

        
        // dd($Transacciones);
        // \Log::info('leam My query *** -> ' . $myQuery);
         

        // dd($Transacciones2);


        // dd($Transacciones4);

        return [$Recargas3, $Transacciones];
        

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


        $request->transaction   = 11; // 11 pago usdt y 13 cobro usdt

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

        $myFechaDesde   = $myFechaDesde . $horaDesde;
        $myFechaHasta   = $myFechaHasta . $horaHasta;

        
        //
        // 11 pago usdt 
        //
        $myTransactionDesde     = 11;
        $myTransactionHasta     = 11;

        $myQuery =
        "
            select
                mtf.transactions.id                             as Id,
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.groups.type                                 as GroupType,
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
                and mtf.groups.type     = 2
            order by
                mtf.transactions.group_id       ASC,
                Transactions.transaction_date   ASC
        ";
        
        /*
        echo "<pre>";
        echo var_dump($myQuery);
        echo "</pre>";
        */


        //die();
        

        $Recargas = DB::select($myQuery);
        // dd($Recargas);
        /*
        foreach($Recargas as $myRecargas){
            
            echo "<br>";
            echo         $myRecargas->Id;
            echo "," . $myRecargas->WalletId;
            echo "," . $myRecargas->WalletName;
            echo "," . $myRecargas->GroupId;
            echo "," . $myRecargas->GroupName;
            echo "," . $myRecargas->GroupType;
            echo "," . $myRecargas->TypeTransactionId;
            echo "," . $myRecargas->TypeTransactionName;
            echo "," . $myRecargas->TransactionDate;
            echo "," . $myRecargas->Percentage;
            echo "," . $myRecargas->PercentageBase;
           
            echo "," . $myRecargas->Amount;
            echo "," . $myRecargas->AmountTotal;
            echo "," . $myRecargas->AmountCommission;
            echo "," . $myRecargas->AmountBase;
            echo "," . $myRecargas->AmountTotalBase;
            echo "," . $myRecargas->AmountCommissionBase;
            echo "," . $myRecargas->AmountCommissionProfit;
            echo "," . $myRecargas->Saldo;

        }
        */
        //die('fin');
       // echo "<br> *************************************************************";

        $myTransactionDesde     = 13; // 13 cobros usdt
        $myTransactionHasta     = 13;

        $myQuery =
         "
             select
                 mtf.transactions.id                             as Id,
                 mtf.transactions.wallet_id                      as WalletId,
                 wallets.name                                    as WalletName,
                 mtf.transactions.group_id                       as GroupId,
                 mtf.groups.name                                 as GroupName,
                 mtf.groups.type                                 as GroupType,
                 mtf.transactions.type_transaction_id            as TypeTransactionId,
                 type_transactions.name                          as TypeTransactionName,
                 transaction_date                                as TransactionDate,
                 percentage                                      as Percentage,
                 1.5                                             as PercentageBase,
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
                mtf.transactions.wallet_id asc,
                Transactions.transaction_date ASC
         ";
        /*
         echo "<pre>";
         echo var_dump($myQuery);
         echo "</pre>";
        die();  
        */
        //dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);


        /*
        foreach($Recargas2 as $myRecargas){
            echo "<br>";
            echo       $myRecargas->Id;
            echo "," . $myRecargas->WalletId;
            echo "," . $myRecargas->WalletName;
            echo "," . $myRecargas->GroupId;
            echo "," . $myRecargas->GroupName;
            echo "," . $myRecargas->GroupType;
            echo "," . $myRecargas->TypeTransactionId;
            echo "," . $myRecargas->TypeTransactionName;
            echo "," . $myRecargas->TransactionDate;
            echo "," . $myRecargas->Percentage;
            echo "," . $myRecargas->PercentageBase;
           
            echo "," . $myRecargas->Amount;
            echo "," . $myRecargas->AmountTotal;
            echo "," . $myRecargas->AmountCommission;
            echo "," . $myRecargas->AmountBase;
            echo "," . $myRecargas->AmountTotalBase;
            echo "," . $myRecargas->AmountCommissionBase;
            echo "," . $myRecargas->AmountCommissionProfit;
            echo "," . $myRecargas->Saldo;
        }
        */

        // die('fin');



        $Recargas3 = array_merge($Recargas, $Recargas2);
        
        usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});
        /*
        echo '<pre>';
        echo var_dump($Recargas3);
        echo '</pre>';
        die();
        */
        // dd($Recargas3);
        /*
        
        foreach($Recargas3 as $myRecargas){
            
            echo "<br>";
            echo         $myRecargas->Id;
            echo "," . $myRecargas->WalletId;
            echo "," . $myRecargas->WalletName;
            echo "," . $myRecargas->GroupId;
            echo "," . $myRecargas->GroupName;
            echo "," . $myRecargas->GroupType;
            echo "," . $myRecargas->TypeTransactionId;
            echo "," . $myRecargas->TypeTransactionName;
            echo "," . $myRecargas->TransactionDate;
            echo "," . $myRecargas->Percentage;
            echo "," . $myRecargas->PercentageBase;
           
            echo "," . $myRecargas->Amount;
            echo "," . $myRecargas->AmountTotal;
            echo "," . $myRecargas->AmountCommission;
            echo "," . $myRecargas->AmountBase;
            echo "," . $myRecargas->AmountTotalBase;
            echo "," . $myRecargas->AmountCommissionBase;
            echo "," . $myRecargas->AmountCommissionProfit;
            echo "," . $myRecargas->Saldo;

        }
        die('fin 3');
        */
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
                mtf.groups.type                                 as GroupType,                
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
                0                                               as Saldo
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
        /*
        foreach($Transacciones as $myRecargas){
            
            echo "<br>";
            echo         $myRecargas->Id;
            echo "," . $myRecargas->WalletId;
            echo "," . $myRecargas->WalletName;
            echo "," . $myRecargas->GroupId;
            echo "," . $myRecargas->GroupName;
            echo "," . $myRecargas->GroupType;
            echo "," . $myRecargas->TypeTransactionId;
            echo "," . $myRecargas->TypeTransactionName;
            echo "," . $myRecargas->TransactionDate;
            echo "," . $myRecargas->Percentage;
            echo "," . $myRecargas->PercentageBase;
           
            echo "," . $myRecargas->Amount;
            echo "," . $myRecargas->AmountTotal;
            echo "," . $myRecargas->AmountCommission;
            echo "," . $myRecargas->AmountBase;
            echo "," . $myRecargas->AmountTotalBase;
            echo "," . $myRecargas->AmountCommissionBase;
            echo "," . $myRecargas->AmountCommissionProfit;
            echo "," . $myRecargas->Saldo;

        }
        */
        // die('transacciones');

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
        // dd('aqui');
        //\Log::info('aqui termina');
        //\Log::info(print_r($Transacciones2,true));
        //die();
        /*
        foreach($Transacciones2 as $myRecargas){
            
            echo "<br>";
            echo         $myRecargas->Id;
            echo "," . $myRecargas->WalletId;
            echo "," . $myRecargas->WalletName;
            echo "," . $myRecargas->GroupId;
            echo "," . $myRecargas->GroupName;
            echo "," . $myRecargas->GroupType;
            echo "," . $myRecargas->TypeTransactionId;
            echo "," . $myRecargas->TypeTransactionName;
            echo "," . $myRecargas->TransactionDate;
            echo "," . $myRecargas->Percentage;
            echo "," . $myRecargas->PercentageBase;
           
            echo "," . $myRecargas->Amount;
            echo "," . $myRecargas->AmountTotal;
            echo "," . $myRecargas->AmountCommission;
            echo "," . $myRecargas->AmountBase;
            echo "," . $myRecargas->AmountTotalBase;
            echo "," . $myRecargas->AmountCommissionBase;
            echo "," . $myRecargas->AmountCommissionProfit;
            echo "," . $myRecargas->Saldo;

        }
        
         die('transacciones2');
        */

        // dd($Transacciones4);

        return [$Recargas3, $Transacciones2];
        

    }    

    /*
    *
    *
    *        materialsAdquisicionResumenGrupo
    *
    *
    */
    function materialsAdquisicionResumenGrupo(Request $request){

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        
        if ($request->wallet){
            
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myTransactionDesde     = 47;
        $myTransactionHasta     = 47;
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

        $myFechaDesde2 = $myFechaDesde . ' 00:00:00';
        $myFechaHasta2 = $myFechaHasta . ' 23:59:59';


        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

        
        /*
        echo "<br>" . " leam - myWallet      -> " . $myWallet;
        echo "<br>" . " leam - myWalletDesde -> " . $myWalletDesde;
        echo "<br>" . " leam - myWalletHasta -> " . $myWalletHasta;

        echo "<br>" . " leam - myGroup      -> " . $myGroup;
        echo "<br>" . " leam - myGroupDesde -> " . $myGroupDesde;
        echo "<br>" . " leam - myGroupHasta -> " . $myGroupHasta;

        echo "<br>" . " leam - myTypeMaterial      -> " . $myType_material;
        echo "<br>" . " leam - myTypeMaterialDesde -> " . $myTypeMaterialDesde;
        echo "<br>" . " leam - myTypeMaterialHasta -> " . $myTypeMaterialHasta;
         die();
        */


        
        //  dd($myCierre);
        // var_dump($materialsCierre);
        // die();
        $myQuery =
        "
            select
                mtf.transactions.wallet_id                        as WalletId,
                wallets.name                                      as WalletName,
                mtf.transactions.group_id                         as GroupId,
                mtf.groups.name                                   as GroupName,
                mtf.transactions.type_transaction_id              as TypeTransactionId,
                type_transactions.name                            as TypeTransactionName,
                mtf.transactions.type_material_id                 as TypeMaterialId,
                mtf.type_materials.name                           as TypeMaterialName,
                count(mtf.transactions.wallet_id)                 as AdquisicionCant,  
                sum(mtf.transactions.material_price_kilos)        as AdquisicionMaterialPriceKilos,
                sum(mtf.transactions.material_amount_kilos)          as AdquisicionMaterialAmountKilos,
                sum(mtf.transactions.material_amount_total_kilos)    as AdquisicionMaterialAmountTotalKilos,
                sum(mtf.transactions.material_price_gramos)          as AdquisicionMaterialPriceGramos,
                sum(mtf.transactions.material_amount_gramos)         as AdquisicionMaterialAmountGramos,
                sum(mtf.transactions.material_amount_total_gramos)   as AdquisicionMaterialAmountTotalGramos,
                0                                                    as RecepcionCant,
                0                                                    as RecepcionMaterialPriceKilos,
                0                                                    as RecepcionMaterialAmountKilos,
                0                                                    as RecepcionMaterialAmountTotalKilos,
                0                                                    as RecepcionMaterialPriceGramos,
                0                                                    as RecepcionMaterialAmountGramos,
                0                                                    as RecepcionMaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde       and     $myWalletHasta
                and group_id                between $myGroupDesde        and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde  and     $myTransactionHasta
                and transaction_date        between '$myFechaDesde2'     and     '$myFechaHasta2'
                and type_material_id        between $myTypeMaterialDesde and    $myTypeMaterialHasta
                and material_type_adquisicion between 1 and 2
            group by 
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name,
                mtf.transactions.type_material_id,
                mtf.type_materials.name
            order by
                transactions.wallet_id,
                transactions.group_id
        ";

        // dd($myQuery);
        
        $adquisiciones = DB::select($myQuery);        
        //var_dump($adquisiciones);
        //die();
        
        // dd($adquisiciones);

        $myTransactionDesde     = 48;
        $myTransactionHasta     = 48;        

        $myQuery =
        "
            select
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                mtf.transactions.type_material_id               as TypeMaterialId,
                mtf.type_materials.name                         as TypeMaterialName,              
                0                                               as AdquisicionCant,
                0                                               as AdquisicionMaterialPriceKilos,
                0                                               as AdquisicionMaterialAmountKilos,
                0                                               as AdquisicionMaterialAmountTotalKilos,
                0                                               as AdquisicionMaterialPriceGramos,
                0                                               as AdquisicionMaterialAmountGramos,
                0                                               as AdquisicionMaterialAmountTotalGramos,
                count(mtf.transactions.wallet_id )              as RecepcionCant,
                0                                               as RecepcionMaterialPriceKilos,
                sum(mtf.transactions.material_amount_kilos)     as RecepcionMaterialAmountKilos,
                0                                               as RecepcionMaterialAmountTotalKilos,
                0                                               as RecepcionMaterialPriceGramos,
                sum(mtf.transactions.material_amount_gramos)    as RecepcionMaterialAmountGramos,
                0                                               as RecepcionMaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde      and     $myWalletHasta
                and group_id                between $myGroupDesde       and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde and     $myTransactionHasta
                and transaction_date        between '$myFechaDesde2'    and     '$myFechaHasta2'
                and type_material_id        between $myTypeMaterialDesde and    $myTypeMaterialHasta
                and material_type_adquisicion between 1 and 2                
            group by 
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name,
                mtf.transactions.type_material_id,
                mtf.type_materials.name
            order by
                transactions.wallet_id,
                transactions.group_id
        ";

        // dd($myQuery);
        
        $recepciones = DB::select($myQuery);    
        // dd($recepciones);

        $adqui = [];

        // inicio

        foreach($adquisiciones as $myAdquisiciones){
            foreach($recepciones as $myRecepciones){
                if($myAdquisiciones->WalletId == $myRecepciones->WalletId){
                    if($myAdquisiciones->GroupId == $myRecepciones->GroupId){

                        $myAdquisiciones->RecepcionMaterialAmountKilos      = $myRecepciones->RecepcionMaterialAmountKilos;
                        $myAdquisiciones->RecepcionMaterialAmountGramos     = $myRecepciones->RecepcionMaterialAmountGramos;                                           
                        $myAdquisiciones->RecepcionCant                     = $myRecepciones->RecepcionCant;

                    }
                }
            }
        }

        // fin
        // dd($adquisiciones);

        $Group_roles 	    = $this->getGroupRole(auth()->id());
        $wallet             = $this->getWallet();
        $group              = $this->getGroups($Group_roles);
        $type_material      = Type_material::pluck('name', 'id')->toArray();


        $parametros ['myFechaDesde']    = $myFechaDesde;
        $parametros ['myFechaHasta']    = $myFechaHasta;
        $parametros ['myWallet']        = $myWallet;
        $parametros ['myGroup']         = $myGroup;
        $parametros ['myType_material'] = $myType_material;
        $parametros ['wallet']          = $wallet;
        $parametros ['group']           = $group;
        $parametros ['type_material']   = $type_material;
        $parametros ['adquisiciones']   = $adquisiciones;


        return view('estadisticas.materialsAdquisicionResumenGrupo', $parametros);

    }


    
    /*
    *
    *
    *        materialsLiquidacion
    *
    *
    */
    function materialsLiquidacion(Request $request){

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            if ($request->wallet !=0 ){
                $myWallet       = $request->wallet; 
                $myWalletDesde  = $request->wallet;
                $myWalletHasta  = $request->wallet;
            }
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            if ($request->group !=0 ){
                $myGroup        = $request->group;
                $myGroupDesde   = $request->group;
                $myGroupHasta   = $request->group;
            }
        }

        $myTransactionDesde     = 47;
        $myTransactionHasta     = 47;
        if ($request->transaction){
            if ($request->transaction !=0){
                $myTransactionDesde     = $request->transaction;
                $myTransactionHasta     = $request->transaction;
            }
        }

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }

        $myFechaDesde2 = $myFechaDesde . ' 00:00:00';
        $myFechaHasta2 = $myFechaHasta . ' 23:59:59';


        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

        /*
        echo "<br>" . " leam - myTypeMaterial      -> " . $myType_material;
        echo "<br>" . " leam - myTypeMaterialDesde -> " . $myTypeMaterialDesde;
        echo "<br>" . " leam - myTypeMaterialHasta -> " . $myTypeMaterialHasta;
        die();
        */


        
        //  dd($myCierre);
        // var_dump($materialsCierre);
        // die();
        $myQuery =
        "
            select
                mtf.transactions.liquidation_number               as LiquidationNumber,
                mtf.transactions.liquidation_date                 as LiquidationDate,
                mtf.transactions.wallet_id                        as WalletId,
                wallets.name                                      as WalletName,
                mtf.transactions.group_id                         as GroupId,
                mtf.groups.name                                   as GroupName,
                mtf.transactions.type_transaction_id              as TypeTransactionId,
                type_transactions.name                            as TypeTransactionName,
                mtf.transactions.type_material_id                 as TypeMaterialId,
                mtf.type_materials.name                           as TypeMaterialName,
                count(mtf.transactions.wallet_id)                 as AdquisicionCant,  
                sum(mtf.transactions.material_price_kilos)        as AdquisicionMaterialPriceKilos,
                sum(mtf.transactions.material_amount_kilos)          as AdquisicionMaterialAmountKilos,
                sum(mtf.transactions.material_amount_total_kilos)    as AdquisicionMaterialAmountTotalKilos,
                sum(mtf.transactions.material_price_gramos)          as AdquisicionMaterialPriceGramos,
                sum(mtf.transactions.material_amount_gramos)         as AdquisicionMaterialAmountGramos,
                sum(mtf.transactions.material_amount_total_gramos)   as AdquisicionMaterialAmountTotalGramos,
                0                                                    as RecepcionCant,
                0                                                    as RecepcionMaterialPriceKilos,
                0                                                    as RecepcionMaterialAmountKilos,
                0                                                    as RecepcionMaterialAmountTotalKilos,
                0                                                    as RecepcionMaterialPriceGramos,
                0                                                    as RecepcionMaterialAmountGramos,
                0                                                    as RecepcionMaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Liquidado'
                and wallet_id               between $myWalletDesde       and     $myWalletHasta
                and group_id                between $myGroupDesde        and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde  and     $myTransactionHasta
                and liquidation_date        between '$myFechaDesde2'     and     '$myFechaHasta2'
                and type_material_id        between $myTypeMaterialDesde and    $myTypeMaterialHasta
                and material_type_adquisicion between 1 and 2
                and liquidation_number is not null
            group by 
                mtf.transactions.liquidation_number,
                mtf.transactions.liquidation_date,
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name,
                mtf.transactions.type_material_id,
                mtf.type_materials.name
            order by
                transactions.wallet_id,
                transactions.group_id
        ";

        // dd($myQuery);
        
        $adquisiciones = DB::select($myQuery);        
        //var_dump($adquisiciones);
        //die();
        
        // dd($adquisiciones);

        $myTransactionDesde     = 48;
        $myTransactionHasta     = 48;        

        $myQuery =
        "
            select
                mtf.transactions.liquidation_number             as LiquidationNumber,
                mtf.transactions.liquidation_date               as LiquidationDate,            
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName,
                mtf.transactions.type_transaction_id            as TypeTransactionId,
                type_transactions.name                          as TypeTransactionName,
                mtf.transactions.type_material_id               as TypeMaterialId,
                mtf.type_materials.name                         as TypeMaterialName,              
                0                                               as AdquisicionCant,
                0                                               as AdquisicionMaterialPriceKilos,
                0                                               as AdquisicionMaterialAmountKilos,
                0                                               as AdquisicionMaterialAmountTotalKilos,
                0                                               as AdquisicionMaterialPriceGramos,
                0                                               as AdquisicionMaterialAmountGramos,
                0                                               as AdquisicionMaterialAmountTotalGramos,
                count(mtf.transactions.wallet_id )              as RecepcionCant,
                0                                               as RecepcionMaterialPriceKilos,
                sum(mtf.transactions.material_amount_kilos)     as RecepcionMaterialAmountKilos,
                0                                               as RecepcionMaterialAmountTotalKilos,
                0                                               as RecepcionMaterialPriceGramos,
                sum(mtf.transactions.material_amount_gramos)    as RecepcionMaterialAmountGramos,
                0                                               as RecepcionMaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Liquidado'
                and wallet_id               between $myWalletDesde      and     $myWalletHasta
                and group_id                between $myGroupDesde       and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde and     $myTransactionHasta
                and liquidation_date        between '$myFechaDesde2'    and     '$myFechaHasta2'
                and type_material_id        between $myTypeMaterialDesde and    $myTypeMaterialHasta
                and material_type_adquisicion between 1 and 2             
                and liquidation_number is not null   
            group by 
                mtf.transactions.liquidation_number,
                mtf.transactions.liquidation_date,            
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name,
                mtf.transactions.type_material_id,
                mtf.type_materials.name
            order by
                transactions.wallet_id,
                transactions.group_id
        ";

        // dd($myQuery);
        
        $recepciones = DB::select($myQuery);    
        // dd($recepciones);

        $adqui = [];

        // inicio

        foreach($adquisiciones as $myAdquisiciones){
            foreach($recepciones as $myRecepciones){
                if($myAdquisiciones->WalletId == $myRecepciones->WalletId){
                    if($myAdquisiciones->GroupId == $myRecepciones->GroupId){

                        $myAdquisiciones->RecepcionMaterialAmountKilos      = $myRecepciones->RecepcionMaterialAmountKilos;
                        $myAdquisiciones->RecepcionMaterialAmountGramos     = $myRecepciones->RecepcionMaterialAmountGramos;                                           
                        $myAdquisiciones->RecepcionCant                     = $myRecepciones->RecepcionCant;

                    }
                }
            }
        }

        // fin
        // dd($adquisiciones);

        $Group_roles 	    = $this->getGroupRole(auth()->id());
        $wallet             = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        $group              = $this->getGroups($Group_roles);
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        $parametros ['myFechaDesde']    = $myFechaDesde;
        $parametros ['myFechaHasta']    = $myFechaHasta;
        $parametros ['myWallet']        = $myWallet;
        $parametros ['myGroup']         = $myGroup;
        $parametros ['myType_material'] = $myType_material;
        $parametros ['wallet']          = $wallet;
        $parametros ['group']           = $group;
        $parametros ['type_material']   = $type_material;
        $parametros ['adquisiciones']   = $adquisiciones;

        return view('estadisticas.materialsLiquidacion', $parametros);

    }



    function materialsLiquidacionCuentaGrupo(Request $request){

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

        $Group_roles 	    = $this->getGroupRole(auth()->id());
        $wallet             = Group::where('type', '=', '2')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        $group              = $this->getGroups($Group_roles);
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        $parametros ['myWallet']        = $myWallet;
        $parametros ['myGroup']         = $myGroup;
        $parametros ['myType_material'] = $myType_material;
        $parametros ['wallet']          = $wallet;
        $parametros ['group']           = $group;
        $parametros ['type_material']   = $type_material;

        return view('estadisticas.materialsLiquidacionCuentaGrupo', $parametros);

    }






    function materialsLiquidacionCuentaGrupoProcess(Request $request){

        $indLog = 0;

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde   = 00000;
        $myGroupHasta   = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

        //
        // sumar recepciones
        //
        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }
        $myFechaDesde2 = $myFechaDesde . ' 00:00:00';
        $myFechaHasta2 = $myFechaHasta . ' 23:59:59';

        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,
                mtf.transactions.group_id                           as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.transactions.type_transaction_id                as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,
                mtf.transactions.type_material_id                   as TypeMaterialId,
                mtf.type_materials.name                             as TypeMaterialName,              
                0                                                   as AdquisicionCant,
                0                                                   as AdquisicionMaterialPriceKilos,
                0                                                   as AdquisicionMaterialAmountKilos,
                0                                                   as AdquisicionMaterialAmountTotalKilos,
                0                                                   as AdquisicionMaterialPriceGramos,
                0                                                   as AdquisicionMaterialAmountGramos,
                0                                                   as AdquisicionMaterialAmountTotalGramos,
                count(mtf.transactions.wallet_id )                  as RecepcionCant,
                0                                                   as RecepcionMaterialPriceKilos,
                sum(mtf.transactions.material_amount_kilos)         as RecepcionMaterialAmountKilos,
                sum(mtf.transactions.material_amount_total_kilos)   as RecepcionMaterialAmountTotalKilos,
                0                                                   as RecepcionMaterialPriceGramos,
                sum(mtf.transactions.material_amount_gramos)        as RecepcionMaterialAmountGramos,
                sum(mtf.transactions.material_amount_total_gramos)  as RecepcionMaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id                   between $myWalletDesde          and     $myWalletHasta
                and group_id                    between $myGroupDesde           and     $myGroupHasta                
                and type_transaction_id         between 48                      and     48
                and transaction_date            between '$myFechaDesde2'        and     '$myFechaHasta2'
                and type_material_id            between $myTypeMaterialDesde    and     $myTypeMaterialHasta          
            group by          
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name,
                mtf.transactions.type_transaction_id,
                type_transactions.name,
                mtf.transactions.type_material_id,
                mtf.type_materials.name
            order by
                transactions.wallet_id,
                transactions.group_id
        ";


        $recepciones = DB::select($myQuery) ?? [];
        if (count($recepciones) > 0) {
            $recepciones = (object) $recepciones[0];
        }
        
        $myRecepcionMaterialAmountGramos        = $recepciones->RecepcionMaterialAmountGramos       ?? 0;
        $myRecepcionMaterialAmountTotalGramos   = $recepciones->RecepcionMaterialAmountTotalGramos  ?? 0;

        // dd($myQuery);
        // dd($recepciones);
        // dd($myRecepcionMaterialAmountGramos);

        if ($indLog ==1){
            echo "<br>" . "recepciones total";
            echo "<pre>";
            print_r($recepciones);
            echo "</pre>";
        }

        $myQuery =
         "
             select
                 mtf.transactions.id                                as Id,
                 mtf.transactions.wallet_id                         as WalletId,
                 wallets.name                                       as WalletName,
                 mtf.transactions.group_id                          as GroupId,
                 mtf.groups.name                                    as GroupName,
                 mtf.transactions.type_transaction_id               as TypeTransactionId,
                 type_transactions.name                             as TypeTransactionName,
                 mtf.transactions.type_material_id                  as TypeMaterialId,
                 mtf.type_materials.name                            as TypeMaterialName,
                 mtf.transactions.transaction_date                  as TransactionDate,
                 mtf.transactions.material_type_adquisicion         as MaterialTypeAdquisicion,
                 mtf.transactions.material_price_kilos              as AdquisicionMaterialPriceKilos,
                 mtf.transactions.material_amount_kilos             as AdquisicionMaterialAmountKilos,
                 mtf.transactions.material_amount_total_kilos       as AdquisicionMaterialAmountTotalKilos,
                 mtf.transactions.material_price_gramos             as AdquisicionMaterialPriceGramos,
                 mtf.transactions.material_amount_gramos            as AdquisicionMaterialAmountGramos,
                 mtf.transactions.material_amount_total_gramos      as AdquisicionMaterialAmountTotalGramos,
                 0                                                  as RecepcionCant,
                 0                                                  as RecepcionMaterialPriceKilos,
                 0                                                  as RecepcionMaterialAmountKilos,
                 0                                                  as RecepcionMaterialAmountTotalKilos,
                 0                                                  as RecepcionMaterialPriceGramos,
                 0                                                  as RecepcionMaterialAmountGramos,
                 0                                                  as RecepcionMaterialAmountTotalGramos,
                 mtf.transactions.liquidation_date                  as LiquidationDate, 
                 mtf.transactions.liquidation_number                as LiquidationNumber
             from
                         mtf.transactions
             left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
             left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
             left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
             left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
             where
                     status = 'Activo'
                 and wallet_id               between $myWalletDesde         and     $myWalletHasta
                 and group_id                between $myGroupDesde          and     $myGroupHasta                
                 and type_transaction_id     between 47                     and     47
                 and transaction_date        between '$myFechaDesde2'       and     '$myFechaHasta2'
                 and type_material_id        between $myTypeMaterialDesde   and    $myTypeMaterialHasta
                 and material_type_adquisicion between 1 and 2
             order by
                 transactions.wallet_id,
                 transactions.group_id
         ";
 
         
         
         $adquisiciones = DB::select($myQuery);  
        // dd($myQuery);
        // dd($adquisiciones);

        if ($indLog == 1){
            echo "<br>" . "adquisiciones";
            echo "<pre>";
            print_r($adquisiciones);
            echo "</pre>";
        }


        $myAmount                   = 0;
        
        $myMaterialAmmountGramosNew = 0;
        $myIdToLiquidate            = [];
        $myAdquisicionToLiquidate   = [];
        $myAdquisicionToCreate      = [];
        $myLiquidationDate          = date("Y-m-d h:i:s");
        $myLiquidationNumber        = date('YmdHis');

        foreach($adquisiciones as $myAdquisicion){

            $myAmount += $myAdquisicion->AdquisicionMaterialAmountGramos;

            if ($indLog == 1){
                echo "<br>";
                echo "myAmount -> " . number_format($myAmount,2);

                echo "---------- myRecepcionMaterialAmountGramos -> " . number_format($myRecepcionMaterialAmountGramos,2);
                echo "<br>";
            }

            if ($myAmount <= $myRecepcionMaterialAmountGramos){

                $myAdquisicionToLiquidate[] = $myAdquisicion;

                $myIdToLiquidate[]          = $myAdquisicion->Id;



            }else if ($myAmount > $myRecepcionMaterialAmountGramos){
                
                $myAdquisicionToLiquidate[]     = $myAdquisicion;
                $myIdToLiquidate[]              = $myAdquisicion->Id;


                $myMaterialAmmountGramosNew     = $myAmount - $myRecepcionMaterialAmountGramos;
                $myMaterialAmountKilosNew       = $myMaterialAmmountGramosNew / 1000;
                $myMaterialAmountKilosNew       = round($myMaterialAmountKilosNew,3);

                $myMaterialAmountTotalGramos    = $myAdquisicion->AdquisicionMaterialPriceGramos  * $myMaterialAmmountGramosNew;
                $myMaterialAmountTotalGramos    = round($myMaterialAmountTotalGramos,3);

                $myMaterialAmountTotalKilos     = $myAdquisicion->AdquisicionMaterialPriceKilos   * $myMaterialAmountKilosNew;
                $myMaterialAmountTotalKilos     = round($myMaterialAmountTotalKilos,3);

                $myAdquisicion2                 = clone $myAdquisicion;

                $myAdquisicion2->AdquisicionMaterialAmountGramos        = $myMaterialAmmountGramosNew;
                $myAdquisicion2->AdquisicionMaterialAmountKilos         = $myMaterialAmountKilosNew;
                
                $myAdquisicion2->AdquisicionMaterialAmountTotalGramos   = $myMaterialAmountTotalGramos;

                $myAdquisicion2->AdquisicionMaterialAmountTotalKilos    = $myMaterialAmountTotalKilos;
                                                                                        
                $myAdquisicion2->LiquidationDate                        = $myLiquidationDate;
                $myAdquisicion2->LiquidationNumber                      = $myLiquidationNumber;

                $myAdquisicionToCreate[] = $myAdquisicion2;

                /*
                if ($indLog ==1){
                echo "<br>" . "myAdquisicionToCreate";
                echo "<pre>";
                echo " myMaterialAmmountGramosNew   -> $myMaterialAmmountGramosNew";
                echo " myMaterialAmountKilosNew     -> $myMaterialAmountKilosNew";
                echo "</pre>";                

                
                echo "<br>" . "myAdquisicionToLiquidate";
                echo "<pre>";
                echo " myMaterialAmmountGramosNew   -> $myMaterialAmmountGramosNew";
                echo " myMaterialAmountKilosNew     -> $myMaterialAmountKilosNew";
                echo "</pre>";   
                }
                */

                break;
            }

        }

        $myAdquisicionToCreate = (object) $myAdquisicionToCreate[0];

        if ($indLog ==1){
            echo "<br>" . "myAdquisicionToLiquidate";
            echo "<pre>";
            print_r($myAdquisicionToLiquidate);
            echo "</pre>";

            echo "<br>";
            echo "<br>";
            echo "<br>" . "crear";
            echo "<pre>";
            print_r($myAdquisicionToCreate);
            echo "</pre>";
            echo "<br>";

            echo "<br>";
            echo "<br>";
            echo "<br>" . "IdToLiquidate";
            echo "<pre>";
            print_r($myIdToLiquidate);
            echo "</pre>";
            echo "<br>";

        }




        // dd($myAdquisicionToLiquidate);
        // dd($myAdquisicionToCreate);

        //
        //
        // Inicia transaccion
        DB::beginTransaction();
        try{
        //
        //
        //
        // Liquida recepciones
        //
        //
        $myQuery =
        "
            update      mtf.transactions
            set
                status = 'Liquidado',
                Liquidation_date    = '$myLiquidationDate',                 
                Liquidation_Number = '$myLiquidationNumber'    
            where
                    status = 'Activo'
                and wallet_id                   between $myWalletDesde          and     $myWalletHasta
                and group_id                    between $myGroupDesde           and     $myGroupHasta                
                and type_transaction_id         between 48                      and     48
                and transaction_date            between '$myFechaDesde2'        and     '$myFechaHasta2'
                and type_material_id            between $myTypeMaterialDesde    and     $myTypeMaterialHasta
        ";

        $recepciones = DB::update($myQuery);
        //
        //
        // Liquida todas las adquisiciones hasta la nueva creada
        //
        //
        //
        $myIdToLiquidateString = implode(",",$myIdToLiquidate);


        $myQuery =
        "
            update      mtf.transactions
            set
                status = 'Liquidado',
                Liquidation_date    = '$myLiquidationDate', 
                Liquidation_Number = '$myLiquidationNumber' 
            where
                    status = 'Activo'
                and id  in ($myIdToLiquidateString)
        ";
        
        if ($indLog ==1){
            echo "<br>";
            echo "<br>";
            echo "<br>" . "myQuery";
            echo "<pre>";
            echo $myQuery;
            echo "</pre>";
            echo "<br>";
        }

         $liquidation = DB::update($myQuery);

        // leamxxx
        // crea nueva adquisicion
        //
        
        $transactions_new = new Transaction;

        $transactions_new->type_transaction_id              = $myAdquisicionToCreate->TypeTransactionId;
        $transactions_new->user_id                          = auth()->user()->id;
        $transactions_new->group_id                         = $myAdquisicionToCreate->GroupId;
        $transactions_new->wallet_id                        = $myAdquisicionToCreate->WalletId;
        $transactions_new->status                           = "Activo";
        $transactions_new->transaction_date                 = $myAdquisicionToCreate->TransactionDate;
        $transactions_new->type_material_id                 = $myAdquisicionToCreate->TypeMaterialId;

        $transactions_new->material_type_adquisicion        = $myAdquisicionToCreate->MaterialTypeAdquisicion;

        $transactions_new->material_amount_kilos            = $myAdquisicionToCreate->AdquisicionMaterialAmountKilos;
        $transactions_new->material_amount_gramos           = $myAdquisicionToCreate->AdquisicionMaterialAmountGramos;
        $transactions_new->material_amount_total_kilos      = $myAdquisicionToCreate->AdquisicionMaterialAmountTotalKilos;
        $transactions_new->material_amount_total_gramos     = $myAdquisicionToCreate->AdquisicionMaterialAmountTotalGramos;        
        $transactions_new->material_price_kilos             = $myAdquisicionToCreate->AdquisicionMaterialPriceKilos;
        $transactions_new->material_price_gramos            = $myAdquisicionToCreate->AdquisicionMaterialPriceGramos;

        $transactions_new->liquidation_date                 = $myLiquidationDate;
        $transactions_new->liquidation_number               = $myLiquidationNumber;

        $transactions_new->save();
  

        if ($indLog ==1){
            echo "<br>" . "adquisicion Nueva ********************************************";
            echo "<pre>";
            echo var_dump($transactions_new);
            echo "</pre>";
        }

        //
        // crear una nota de debito por lo liquidado en el total de recepciones
        //

        $myAmount           = $myRecepcionMaterialAmountGramos * $myAdquisicionToCreate->AdquisicionMaterialPriceGramos;

        
        
        // dd($myAmount);

        $transactions_new   = new Transaction;

        $transactions_new->type_transaction_id              = 8;
        $transactions_new->user_id                          = auth()->user()->id;
        $transactions_new->group_id                         = $myAdquisicionToCreate->GroupId;
        
        $transactions_new->status                           = "Activo";
        $transactions_new->transaction_date                 = $myLiquidationDate;
        

        $transactions_new->description                      = "Nota de debito por liquidacion de cuenta de materiales recibidos, liquidacion nro. $myLiquidationNumber";

        $transactions_new->amount                           = $myAmount;
        $transactions_new->amount_total                     = $myAmount;
        $transactions_new->amount_total_base                = $myAmount;
        $transactions_new->amount_commission_profit          = 0;
 

        $transactions_new->type_coin_balance_id             = 1;
        $transactions_new->exchange_rate_orientation        = 1;
    
        $transactions_new->liquidation_date                 = $myLiquidationDate;
        $transactions_new->liquidation_number               = $myLiquidationNumber;    

        $transactions_new->save();
     
     
        
        if ($indLog ==1){
            echo "<br>" . "nota de debito  Nueva ********************************************";
            echo "<pre>";
            echo var_dump($transactions_new);
            echo "</pre>";
        }
        
        

        if ($indLog ==1){
            echo "<br>" . "new transactions ********************************************";
            echo "<pre>";
            echo "<br> myAdquisicionToCreate->Id                        -> $myAdquisicionToCreate->TypeTransactionId";
            echo "<br> myAdquisicionToCreate->GroupId                   -> $myAdquisicionToCreate->GroupId";
            echo "<br> myAdquisicionToCreate->WalletId                  -> $myAdquisicionToCreate->WalletId";
            echo "<br> myAdquisicionToCreate->TransactionDate           -> $myAdquisicionToCreate->TransactionDate";
            echo "<br> myAdquisicionToCreate->TypeMaterialId            -> $myAdquisicionToCreate->TypeMaterialId";
            echo "<br> myAdquisicionToCreate->MaterialTypeAdquisicion   -> $myAdquisicionToCreate->MaterialTypeAdquisicion";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialAmountKilos -> $myAdquisicionToCreate->AdquisicionMaterialAmountKilos";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialAmountGramos -> $myAdquisicionToCreate->AdquisicionMaterialAmountGramos";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialAmountTotalKilos -> $myAdquisicionToCreate->AdquisicionMaterialAmountTotalKilos";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialAmountTotalGramos -> $myAdquisicionToCreate->AdquisicionMaterialAmountTotalGramos";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialPriceKilos -> $myAdquisicionToCreate->AdquisicionMaterialPriceKilos";
            echo "<br> myAdquisicionToCreate->AdquisicionMaterialPriceGramos -> $myAdquisicionToCreate->AdquisicionMaterialPriceGramos";

            echo "</pre>";
            echo "<br>";

            echo "<br>" . "nota de debito ********************************************";
            echo "<pre>";


        }
        //
        //
        //
        // DB::rollback();

            DB::commit();


        } catch(Exception $e){
            DB::rollback();
        }

        //
        // fin transaccion
        //
        if ($indLog ==1){
            die('fin');
        }


        return response()->json(['success' => true, 'result' => 'Procesado', 'message' => 'Liquidacion de Cuenta Grupo Materiales procesada con exito'], 200);


    }


    /*
    *
    *
    *        materials_adquisicion_consolidado
    *
    *
    */
    function materials_adquisicion_consolidado(Request $request){

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myTransactionDesde     = 47;
        $myTransactionHasta     = 47;
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

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }


        $adqui              = $this->materialsProcesa($request);
        $Group_roles 	    = $this->getGroupRole(auth()->id());
        $wallet             = $this->getWallet($Group_roles);
        $group              = $this->getGroups($Group_roles);
        $type_material      = Type_material::pluck('name', 'id')->toArray();


        $parametros ['myFechaDesde']    = $myFechaDesde;
        $parametros ['myFechaHasta']    = $myFechaHasta;
        $parametros ['myWallet']        = $myWallet;
        $parametros ['myGroup']         = $myGroup;
        $parametros ['myType_material'] = $myType_material;     
        $parametros ['wallet']          = $wallet;
        $parametros ['group']           = $group;
        $parametros ['type_material']   = $type_material;        
        $parametros ['adquisiciones']   = $adqui;
        // dd($adquisiciones2);


        return view('estadisticas.materialsAdquisicionConsolidado', $parametros);

    }
    /*
    *
    *
    *        materials_adquisicion_consolidado2
    *
    *
    */
    function materials_adquisicion_consolidado2(Request $request){

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet && $request->wallet > 0){
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group && $request->group > 0){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myTransactionDesde     = 47;
        $myTransactionHasta     = 48;
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


        
        $myFechaDesde2 = $myFechaDesde . ' 00:00:00';
        $myFechaHasta2 = $myFechaHasta . ' 23:59:59';

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material && $request->type_material > 0){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

            // 

        $myQuery =
        "
        SELECT
            user_id,
            mtf.users.name,
            substr(mtf.materials_balance.created_at,1,10) as created_at2
        FROM mtf.materials_balance
        left join
            mtf.users on mtf.materials_balance.user_id = mtf.users.id
        group by
            user_id,
            name,
            mtf.materials_balance.created_at
        ";
        /*
            $myQuery =
            "
            SELECT 
                user_id,
                mtf.users.name,
                substr(mtf.materials_balance.created_at,1,10) as created_at2
            FROM mtf.materials_balance
            left join
                mtf.users on mtf.materials_balance.user_id = mtf.users.id
            limit 1
            ";
        */
        // dd($myQuery);
        
        $myCierre = DB::select($myQuery);
        if (count($myCierre)>0){
            $myCierre = $myCierre[0];
        }
        
        // dd($myCierre);

        // $adqui              = $this->materialsProcesa($request);


        $myQuery =
        "
            select
                mtf.materials_balance.id                            as Id,
                mtf.materials_balance.adquisicion_id                as AdquisicionId,
                mtf.materials_balance.wallet_id                     as WalletId,
                wallets.name                                        as WalletName,
                mtf.materials_balance.group_id                      as GroupId,
                mtf.groups.name                                     as GroupName,
                mtf.materials_balance.type_transaction_id           as TypeTransactionId,
                type_transactions.name                              as TypeTransactionName,
                mtf.materials_balance.type_material_id              as TypeMaterialId,
                mtf.type_materials.name                             as TypeMaterialName,
                mtf.materials_balance.transaction_date              as TransactionDate,
                mtf.materials_balance.created_at                    as CreatedAt,
                mtf.materials_balance.material_price                as MaterialPrice,
                mtf.materials_balance.material_amount               as MaterialAmount,
                mtf.materials_balance.material_amount_total         as MaterialAmountTotal,
                mtf.materials_balance.material_saldo                as Saldo,
                mtf.materials_balance.material_saldo2               as Saldo2,
                mtf.materials_balance.adquisicion_cierre_cant       as AdquisicionCierreCant,
                mtf.materials_balance.adquisicion_cierre_amount     as AdquisicionCierreAmount,
                mtf.materials_balance.recepcion_id                  as RecepcionId,
                mtf.materials_balance.recepcion_transaction_date    as RecepcionTransactionDate,
                mtf.materials_balance.recepcion_material_amount     as RecepcionMaterialAmount,
                mtf.materials_balance.recepcion_material_amount2    as RecepcionMaterialAmount2,
                mtf.materials_balance.recepcion_saldo               as RecepcionSaldo,
                mtf.materials_balance.recepcion_balance             as RecepcionBalance
            from
                        mtf.materials_balance
            left join   mtf.type_transactions   on mtf.materials_balance.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.materials_balance.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.materials_balance.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.materials_balance.type_material_id    = mtf.type_materials.id
            where
                    wallet_id               between $myWalletDesde          and     $myWalletHasta
                and group_id                between $myGroupDesde           and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde     and     $myTransactionHasta
                and type_material_id        between $myTypeMaterialDesde    and     $myTypeMaterialHasta
                and transaction_date        between '$myFechaDesde2'        and     '$myFechaHasta2'
            order by
                materials_balance.wallet_id,
                materials_balance.group_id,
                mtf.materials_balance.type_transaction_id ASC,
                materials_balance.transaction_date ASC,
                id ASC
        ";

       //  dd($myQuery);
        
        $adqui = DB::select($myQuery);      



        $Group_roles 	    = $this->getGroupRole(auth()->id());
        $wallet             = $this->getWallet($Group_roles);
        $group              = $this->getGroups($Group_roles);
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        // dd($adqui);
        $parametros ['myFechaDesde']    = $myFechaDesde;
        $parametros ['myFechaHasta']    = $myFechaHasta;
        $parametros ['myWallet']        = $myWallet;
        $parametros ['myGroup']         = $myGroup;
        $parametros ['myType_material'] = $myType_material;     
        $parametros ['wallet']          = $wallet;
        $parametros ['group']           = $group;
        $parametros ['type_material']   = $type_material;
        $parametros ['adquisiciones']   = $adqui;
        $parametros ['myCierre']        = $myCierre;
        // dd($adquisiciones2);

        
        return view('estadisticas.materialsAdquisicionConsolidado', $parametros);

    }

    function materialsProcesa(Request $request){


       // $request->wallet    = 521;
       // $request->group     = 43;

        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet; 
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }

        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }

        $myTransactionDesde     = 47;
        $myTransactionHasta     = 47;
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

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material        = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
        }

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde2 = $myFechaDesde . $horaDesde;
        $myFechaHasta2 = $myFechaHasta . $horaHasta;


        $myQuery =
        "
            select
                mtf.transactions.wallet_id                      as WalletId,
                wallets.name                                    as WalletName,
                mtf.transactions.group_id                       as GroupId,
                mtf.groups.name                                 as GroupName
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde         and     $myWalletHasta
                and group_id                between $myGroupDesde          and     $myGroupHasta                
                and type_transaction_id     between $myTransactionDesde    and     $myTransactionHasta            
            group by
                mtf.transactions.wallet_id,
                wallets.name,
                mtf.transactions.group_id,
                mtf.groups.name
            order by
                transactions.wallet_id,
                transactions.group_id    
        ";

        // dd($myQuery);
        
        $adquisicionesResumen = DB::select($myQuery);     

        // dd($adquisicionesResumen);

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
                mtf.transactions.type_material_id               as TypeMaterialId,
                mtf.type_materials.name                         as TypeMaterialName,
                transaction_date                                as TransactionDate,
                mtf.transactions.created_at                     as CreatedAt,
                mtf.transactions.material_price_gramos          as MaterialPrice,
                mtf.transactions.material_amount_gramos         as MaterialAmount,
                mtf.transactions.material_amount_total_gramos   as MaterialAmountTotal,
                0                                               as Saldo,
                0                                               as RecepcionId,
                0                                               as RecepcionTransactionDate,
                0                                               as RecepcionMaterialAmount,
                0                                               as RecepcionSaldo
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde      and     $myWalletHasta
                and group_id                between $myGroupDesde       and     $myGroupHasta                
                and type_transaction_id  between $myTransactionDesde    and     $myTransactionHasta
                and transaction_date     between '$myFechaDesde2'        and     '$myFechaHasta2'
                and material_type_adquisicion between 1 and 2
            order by
                transactions.wallet_id,
                transactions.group_id,
                Transactions.transaction_date ASC,
                id ASC
        ";

        // dd($myQuery);
        
        $adquisiciones = DB::select($myQuery);
        
        // dd($adquisiciones);

        $myTransactionDesde     = 48;
        $myTransactionHasta     = 48;        
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
                mtf.transactions.type_material_id               as TypeMaterialId,
                mtf.type_materials.name                         as TypeMaterialName,
                transaction_date                                as TransactionDate,
                mtf.transactions.created_at                     as CreatedAt,                
                mtf.transactions.material_price_gramos                 as MaterialPrice,
                mtf.transactions.material_amount_gramos                as MaterialAmount,
                mtf.transactions.material_amount_total_gramos          as MaterialAmountTotal,
                mtf.transactions.material_amount_gramos                as Saldo              
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            left join   mtf.type_materials      on mtf.Transactions.type_material_id    = mtf.type_materials.id
            where
                    status = 'Activo'
                and wallet_id            between $myWalletDesde         and     $myWalletHasta
                and group_id                between $myGroupDesde       and     $myGroupHasta                      
                and type_transaction_id  between $myTransactionDesde    and     $myTransactionHasta
                and transaction_date     between '$myFechaDesde2'        and     '$myFechaHasta2'
                and material_type_adquisicion between 1 and 2
            order by
                transactions.wallet_id,
                transactions.group_id,            
                Transactions.transaction_date ASC,
                id ASC
        ";

        // dd($myQuery);
        
        $recepciones = DB::select($myQuery);        
        // dd($recepciones);
        $adqui = [];


        foreach($adquisicionesResumen as $myAdquisicionesResumen){

            $verLog = 0;

            $myWalletId             = 0;
            $myGroupId              = 0;
            $myGroupCant            = 0;
            $myGroupAmount          = 0;
            $myAdquisicionId        = 0;

            $myRecepcionCant        = 0;
            $myRecepcionBalance     = 0;

            $myRecepcionIdTemp      = 0;

            foreach($adquisiciones as $key => $myAdquisicion){


                if ($myAdquisicion->WalletId != $myAdquisicionesResumen->WalletId){
                    continue;
                }

                if ($myAdquisicion->GroupId != $myAdquisicionesResumen->GroupId){
                    continue;
                }

                $myAdquisicion2             = clone $myAdquisicion;

                $myAdquisicion2->Saldo      = $myAdquisicion2->MaterialAmount;
                $myAdquisicion2->Saldo2     = $myAdquisicion2->MaterialAmount;

                // if ($myAdquisicionId <> $myAdquisicion->Id){
                //     $myGroupId      = $myAdquisicion->Id;
                //     $myGroupCant    = 0;
                //     $myGroupAmount  = 0;
                // }
                
                if ($myGroupId <> $myAdquisicion->GroupId){
                    $myGroupId      = $myAdquisicion->GroupId;
                    $myGroupCant    = 0;
                    $myGroupAmount  = 0;
                }
                
                $myGroupCant    +=  $myAdquisicion->MaterialAmount;
                $myGroupAmount  +=  $myAdquisicion->MaterialAmountTotal;

                $indRecepcion = 0;
                
                // echo "<br>" . print_r($myAdquisicion,true);
                



                foreach($recepciones as $key => $myRecepcion){

                    //  if ($key >= 4){
                    //     dd($adqui);
                    //      die();
                    //  }
                    
                    if ($myRecepcion->WalletId != $myAdquisicionesResumen->WalletId){
                        continue;
                    }
    
                    if ($myRecepcion->GroupId != $myAdquisicionesResumen->GroupId){
                        continue;
                    }

                    if ($myRecepcion->Saldo == 0){
                        continue;
                    }
                    
                    

                    $myMaterialAmount                           = $myAdquisicion2->Saldo2 - $myRecepcion->Saldo;


                    $myAdquisicion2->RecepcionId               = $myRecepcion->Id;
                    $myAdquisicion2->RecepcionTransactionDate  = $myRecepcion->TransactionDate;
                    $myAdquisicion2->RecepcionMaterialAmount   = $myRecepcion->MaterialAmount;

                    $myAdquisicion2->AdquisicionCierreCant     = $myGroupCant;
                    $myAdquisicion2->AdquisicionCierreAmount   = $myGroupAmount;

                    if ($myRecepcion->Id != ""){
                        if ($myRecepcionIdTemp != $myRecepcion->Id){
                            // echo "<br>" . "distinto ----------------->";
                            $myRecepcionCant++;
                            $myRecepcionBalance += $myRecepcion->MaterialAmount;
                            $myRecepcionIdTemp  = $myRecepcion->Id;
                        }
                    }

                    if ($myMaterialAmount == 0){
                        $myAdquisicion2->Saldo2             = 0;
                        $myAdquisicion2->RecepcionSaldo     = 0;
                
                        $myRecepcion->Saldo                 = 0;

                        $myAdquisicion2->RecepcionMaterialAmount2   = $myRecepcion->MaterialAmount;
                        $myAdquisicion2->RecepcionBalance           = $myRecepcionBalance;

                        $myAdquisicion2->RecepcionMaterialAmountTotal= $myAdquisicion2->MaterialPrice * $myRecepcion->MaterialAmount;

                        $indRecepcion = 1;

                        if ($verLog == 1){
                            echo "<br>" . "igual *************************************************** idRecepcion -> " . $indRecepcion;
                            echo "<br>" . " myRecepcionCant -> " . $myRecepcionCant;
                            echo "<br>" . " myRecepcionBalance -> " . $myRecepcionBalance;
                            echo "<br>" . " myRecepcionIdTemp -> " . $myRecepcionIdTemp;

                            $this->materials_adquisicion_consolidado_show($myAdquisicion2);
                        }

                        $adqui[] = clone $myAdquisicion2;
                        
                        $myAdquisicion2->Saldo             = 0;



                        break;
                    }

                    if ($myMaterialAmount > 0){

                        $myAdquisicion2->Saldo2                     = $myMaterialAmount;        // saldo que queda de la aduisicion por completar


                        $myAdquisicion2->RecepcionMaterialAmount2   = $myRecepcion->Saldo;      // monto utilizado de la recepecion
                        $myAdquisicion2->RecepcionBalance           = $myRecepcionBalance;      // acumulado de recepcion
                        $myAdquisicion2->RecepcionSaldo             = 0 ;                       // saldo que queda de la recepcion

                        $myRecepcion->Saldo                         = 0;                        // sal que queda de la recepcion

                        $myAdquisicion2->RecepcionMaterialAmountTotal= $myAdquisicion2->MaterialPrice * $myRecepcion->MaterialAmount;

                        $indRecepcion                               = 1;

                        if ($verLog == 1){
                            echo "<br>" . "mayor *************************************************** indRecepcion ->" . $indRecepcion;
                            echo "<br>" . " myRecepcionCant -> " . $myRecepcionCant;
                            echo "<br>" . " myRecepcionBalance -> " . $myRecepcionBalance;
                            echo "<br>" . " myRecepcionIdTemp -> " . $myRecepcionIdTemp;

                            $this->materials_adquisicion_consolidado_show($myAdquisicion2);
                        }


                        $adqui[] = clone $myAdquisicion2;
                        
                        $myAdquisicion2->Saldo             = $myMaterialAmount;
                        
                        

                    }

                    if ($myMaterialAmount < 0){



                        // $myAdquisicion2->RecepcionMaterialAmount2    = $myRecepcion->MaterialAmount - abs($myMaterialAmount);
                        $myAdquisicion2->RecepcionMaterialAmount2    = $myAdquisicion2->Saldo2 ;
                        $myAdquisicion2->Saldo2                      = 0;

                        $myAdquisicion2->RecepcionSaldo    = abs($myMaterialAmount);            
                        
                        $myRecepcion->Saldo                 = abs($myMaterialAmount);

                        $myAdquisicion2->RecepcionMaterialAmountTotal= $myAdquisicion2->MaterialPrice * $myRecepcion->MaterialAmount;

                        $myAdquisicion2->RecepcionBalance           = $myRecepcionBalance;

                        $indRecepcion = 1;

                        if ($verLog == 1){
                            echo "<br>" . "menor *************************************************** indRecepcion -> " . $indRecepcion;
                            echo "<br>" . " myMaterialAmount    -> " . $myMaterialAmount;
                            echo "<br>" . " myRecepcionCant     -> " . $myRecepcionCant;
                            echo "<br>" . " myRecepcionCant     -> " . $myRecepcionCant;
                            echo "<br>" . " myRecepcionBalance  -> " . $myRecepcionBalance;
                            echo "<br>" . " myRecepcionIdTemp   -> " . $myRecepcionIdTemp;

                            $this->materials_adquisicion_consolidado_show($myAdquisicion2);
                        }

                        $adqui[]       = clone $myAdquisicion2;
                        
                        $myAdquisicion2->Saldo  = 0;
                        $myAdquisicion2->RecepcionBalance           = 0;
                        break;                    


                    }

                    

                }


                if ($indRecepcion == 0){

                    $myAdquisicion2->Saldo2                     = 0;

                    $myAdquisicion2->AdquisicionCierreCant     = $myGroupCant;
                    $myAdquisicion2->AdquisicionCierreAmount   = $myGroupAmount;

                    $myAdquisicion2->RecepcionId                = null;
                    // $myAdquisicion2->RecepcionTransactionDate   = date("Y-m-d h:i:s");
                    $myAdquisicion2->RecepcionTransactionDate   = null;
                    $myAdquisicion2->RecepcionMaterialAmount    = 0;

                    $myAdquisicion2->RecepcionSaldo             = 0;
                    $myAdquisicion2->RecepcionMaterialAmount2   = 0; 

                    $myAdquisicion2->RecepcionBalance           = $myRecepcionBalance;
                    
                    $myAdquisicion2->RecepcionMaterialAmountTotal = 0;

                    if ($verLog == 1){
                        echo "<br>" . "sin recepcion  nnn *************************************************** indRecepcion -> " . $indRecepcion;
                        echo "<br>" . " myRecepcionCant -> " . $myRecepcionCant;
                        echo "<br>" . " myRecepcionBalance -> " . $myRecepcionBalance;
                        echo "<br>" . " myRecepcionIdTemp -> " . $myRecepcionIdTemp;

                        $this->materials_adquisicion_consolidado_show($myAdquisicion2);    
                    }

                    $adqui[]       = clone $myAdquisicion2;
                }



                if ($verLog == 1){
                    echo "<br>" . "cant recepcion  nnn *************************************************** indRecepcion -> " . $myRecepcionCant;

                }
                


            }

            // dd($myAdquisicion2->Id);
            // dd($myAdquisicion2->TransactionDate);

            /*
            echo "<pre>";
            echo var_dump($recepciones);
            echo "</pre>";
            die();
            */

            foreach($recepciones as $key => $myRecepcion){


                
                if ($myRecepcion->WalletId != $myAdquisicionesResumen->WalletId){
                    continue;
                }

                if ($myRecepcion->GroupId != $myAdquisicionesResumen->GroupId){
                    continue;
                }

                if ($verLog == 1){
                    echo "<br> ************************************************************************";
                    echo "<br> myRecepcion->WalletId ->" . $myRecepcion->WalletId;
                    echo "<br> myAdquisicionesResumen->WalletId ->" . $myAdquisicionesResumen->WalletId;
                    echo "<br> myRecepcion->GroupId ->" . $myRecepcion->GroupId;
                    echo "<br> myAdquisicionesResumen->GroupId ->" . $myAdquisicionesResumen->GroupId;
                    echo "<br> myRecepcion->Saldo ->" . $myRecepcion->Saldo;
                    }
                    
                
                if ($myRecepcion->Saldo != 0){
                    $myAdquisicion3             = clone $myAdquisicion2;
                    //$myAdquisicion3->Id                         = 0;
                    // $myAdquisicion3->adquisicion_id             = $myAdquisicion2->id ;
                    $myAdquisicion3->WalletId                   = $myAdquisicionesResumen->WalletId;
                    $myAdquisicion3->GroupId                    = $myAdquisicionesResumen->GroupId;
                    $myAdquisicion3->TypeTransactionId          = $myRecepcion->TypeTransactionId;
                    $myAdquisicion3->TypeMaterialId             = $myRecepcion->TypeMaterialId;
                    $myAdquisicion3->TransactionDate            = $myRecepcion->TransactionDate;
                    $myAdquisicion3->MaterialPrice              = 0;
                    $myAdquisicion3->MaterialAmount             = 0;
                    $myAdquisicion3->MaterialAmountTotal        = 0;
                    $myAdquisicion3->Saldo                      = 0;
                    $myAdquisicion3->Saldo2                     = 0;
                    $myAdquisicion3->AdquisicionCierreCant      = 0;
                    $myAdquisicion3->AdquisicionCierreAmount    = 0;
                    $myAdquisicion3->RecepcionId                = $myRecepcion->Id;
                    $myAdquisicion3->RecepcionTransactionDate   = $myRecepcion->TransactionDate;
                    $myAdquisicion3->RecepcionMaterialAmount    = $myRecepcion->MaterialAmount;
                    $myAdquisicion3->RecepcionMaterialAmount2   = 0;
                    $myAdquisicion3->RecepcionSaldo             = $myRecepcion->Saldo;
                    $adqui[]       = clone $myAdquisicion3;  
                    
                    if ($verLog == 1){
                        

                        echo "<br> recpecion sobrante *****************************************************************************";
                        echo "<pre>";
                        echo var_dump($myAdquisicion3);
                        echo "</pre>";
                        echo "<br>";
                        
                    }
                }
            }
            

        }
        

        // dd($adqui);
         if ($verLog == 1){
            die('fin');
        }

        return $adqui;

    }

    function materials_adquisicion_consolidado_show( $myAdquisicion2 ){
        
        echo "<br>" . "-------------------------------------------------------------------";
        echo "<br> Adquisicion Id ------------->" . $myAdquisicion2->Id;
        echo "<br> Wallet Id ------------------>" . $myAdquisicion2->WalletId;
        echo "<br> Wallet NAme ---------------->" . $myAdquisicion2->WalletName;
        echo "<br> Grupo Id ------------------->" . $myAdquisicion2->GroupId;
        echo "<br> grupo Name ----------------->" . $myAdquisicion2->GroupName;
        echo "<br> Type Transaction Id -------->" . $myAdquisicion2->TypeTransactionId;
        echo "<br> Type transaction name ------>" . $myAdquisicion2->TypeTransactionName;
        echo "<br> Material Id ---------------->" . $myAdquisicion2->TypeMaterialId;
        echo "<br> Material Name -------------->" . $myAdquisicion2->TypeMaterialName;
        //echo "<br> Transanction Date ---------->" . $myAdquisicion2->TransactionDate;
        //echo "<br> Created at ----------------->" . $myAdquisicion2->CreatedAt;
        echo "<br>";
        echo "<br> Precio --------------------->" . $myAdquisicion2->MaterialPrice;
        echo "<br> Cantidad ------------------->" . $myAdquisicion2->MaterialAmount;
        echo "<br> Monto ---------------------->" . $myAdquisicion2->MaterialAmountTotal;
        echo "<br>";
        echo "<br> Saldo ---------------------->" . $myAdquisicion2->Saldo;
        echo "<br> Saldo2 --------------------->" . $myAdquisicion2->Saldo2;
        echo "<br>";
        // echo "<br> AdquisicionCierreCant ------>" . $myAdquisicion2->AdquisicionCierreCant;
        // echo "<br> AdquisicionCierreCant ------>" . $myAdquisicion2->AdquisicionCierreAmount;
        echo "<br> Recepcion Id --------------->" . $myAdquisicion2->RecepcionId;
        echo "<br> Recepcion Date ------------->" . $myAdquisicion2->RecepcionTransactionDate;
        echo "<br>";
        echo "<br> Recepcion MaterialAmount  -->" . $myAdquisicion2->RecepcionMaterialAmount;
        echo "<br> Recepcion MaterialAmount2 -->" . $myAdquisicion2->RecepcionMaterialAmount2;
        echo "<br>";
        echo "<br> Recepcion Saldo ------------>" . $myAdquisicion2->RecepcionSaldo;
        echo "<br> Recepcion Balance ---------->" . $myAdquisicion2->RecepcionBalance;
       //  echo "<br> Recepcion Material Total Amount ---------->" . $myAdquisicion2->RecepcionMaterialTotalAmount;

    }


    function materialsCierreProcess(Request $request){

        $adqui              = $this->materialsProcesa($request);

        Materials_balance::truncate();

        
        foreach($adqui as $key => $transaccion){

            $Materials_balance = new Materials_balance;
            
            $Materials_balance->adquisicion_id              = $transaccion->Id;
            $Materials_balance->wallet_id                   = $transaccion->WalletId;
            $Materials_balance->group_id                    = $transaccion->GroupId;
            $Materials_balance->type_transaction_id         = $transaccion->TypeTransactionId;
            $Materials_balance->type_material_id            = $transaccion->TypeMaterialId;
            $Materials_balance->transaction_date            = $transaccion->TransactionDate;
            $Materials_balance->material_price              = $transaccion->MaterialPrice;
            $Materials_balance->material_amount             = $transaccion->MaterialAmount;
            $Materials_balance->material_amount_total       = $transaccion->MaterialAmountTotal;
            $Materials_balance->material_saldo              = $transaccion->Saldo;
            $Materials_balance->material_saldo2             = $transaccion->Saldo2;
            $Materials_balance->adquisicion_cierre_cant     = $transaccion->AdquisicionCierreCant;
            $Materials_balance->adquisicion_cierre_amount   = $transaccion->AdquisicionCierreAmount;
            $Materials_balance->recepcion_id                = $transaccion->RecepcionId;
            $Materials_balance->recepcion_transaction_date  = $transaccion->RecepcionTransactionDate;
            $Materials_balance->recepcion_material_amount   = $transaccion->RecepcionMaterialAmount;
            $Materials_balance->recepcion_material_amount2  = $transaccion->RecepcionMaterialAmount2;
            $Materials_balance->recepcion_saldo                 = $transaccion->RecepcionSaldo;
            $Materials_balance->recepcion_balance               = $transaccion->RecepcionBalance;
            $Materials_balance->recepcion_material_amount_total = $transaccion->RecepcionMaterialAmountTotal;
            $Materials_balance->user_id                     = auth()->user()->id;

            $Materials_balance->save();

        }

        return response()->json(['success' => true, 'result' => 'Procesado', 'message' => 'Cierre Materiales procesado con exito'], 200);

    }
    /*
    *
    *
    *       materialPosicionConsolidadaGrupo
    *
    * 
    */
    function materialPosicionConsolidadaGrupo(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt
        $myWallet      = 0; 
        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet; 
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }
        $myGroup        = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->group){
            $myGroup        = $request->group;
            $myGroupDesde = $request->group;
            $myGroupHasta = $request->group;
        }

        $request->transaction   = 11; // 11 pago usdt 
        $myTransactionDesde     = 0000;
        $myTransactionHasta     = 9999;
        if ($request->transaction){
            $myTransactionDesde     = $request->transaction;
            $myTransactionHasta     = $request->transaction;
        }

        $myType_material        = 0;
        $myTypeMaterialDesde    = 0;
        $myTypeMaterialHasta    = 9999;

        if ($request->type_material){
            $myType_material         = $request->type_material;
            $myTypeMaterialDesde    = $request->type_material;
            $myTypeMaterialHasta    = $request->type_material;
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
        //
        //
        // type_transaction = 11
        //
        //

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
                and group_id                between $myGroupDesde               and     $myGroupHasta
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
        $pagosUSDT = [];
        if ($myWallet != 0 && $myGroup != 0){
            $pagosUSDT = DB::select($myQuery);
            $pagosUSDT = $pagosUSDT [0] ?? [];
        }
        // dd($pagosUSDT->Cant);

        $balance            = $this->getBalance($myGroup, "2001-01-01" , "9999-12-31");

        //
        //
        // Adquisiciones
        //
        //
        $myTransactionDesde     = 47;
        $myTransactionHasta     = 47;


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
                sum(mtf.transactions.amount)                        as Saldo,
                sum(mtf.transactions.material_amount_kilos)         as MaterialAmountKilos,
                sum(mtf.transactions.material_amount_gramos)        as MaterialAmountGramos,
                sum(mtf.transactions.material_amount_total_kilos)   as MaterialAmountTotalKilos,
                sum(mtf.transactions.material_amount_total_gramos)  as MaterialAmountTotalGramos
            from
                        mtf.transactions
            left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
            left join   mtf.groups as wallets   on mtf.transactions.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
            and type_material_id        between $myTypeMaterialDesde        and     $myTypeMaterialHasta            
            where
                    status = 'Activo'
                and wallet_id               between $myWalletDesde              and     $myWalletHasta
                and group_id                between $myGroupDesde               and     $myGroupHasta
                and type_transaction_id     between $myTransactionDesde         and     $myTransactionHasta
                and transaction_date        between '$myFechaDesde'             and     '$myFechaHasta'
                and type_material_id        between $myTypeMaterialDesde        and     $myTypeMaterialHasta                
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
        $adquisicionesMaterial = [];
        if ($myWallet != 0 && $myGroup != 0){
            $adquisicionesMaterial = DB::select($myQuery);
            $adquisicionesMaterial = $adquisicionesMaterial[0] ?? [];
        }
        
        // dd($adquisicionesMaterial);



        //
        //
        //  Recepciones
        //
        //

        $myQuery =
        "
            select
                mtf.materials_balance.wallet_id                            as WalletId,
                wallets.name                                               as WalletName,
                mtf.materials_balance.group_id                             as GroupId,
                mtf.groups.name                                            as GroupName,             
                count(mtf.materials_balance.material_amount)               as Cant,
                sum(mtf.materials_balance.material_amount)                 as Amount,
                sum(mtf.materials_balance.material_amount_total)           as AmountTotal,
                sum(mtf.materials_balance.recepcion_material_amount)       as RecepcionMaterialAmount,
                sum(mtf.materials_balance.recepcion_material_amount_total) as RecepcionMaterialTotalAmount
            from
                        mtf.materials_balance   
            left join   mtf.groups as wallets   on mtf.materials_balance.wallet_id           = wallets.id
            left join   mtf.groups              on mtf.materials_balance.group_id            = mtf.groups.id
            where
                    wallet_id               between $myWalletDesde              and     $myWalletHasta
                and group_id                between $myGroupDesde               and     $myGroupHasta
                and transaction_date        between '$myFechaDesde'             and     '$myFechaHasta'
                and  recepcion_material_amount <> 0
            group by
                mtf.materials_balance.wallet_id,
                wallets.name,
                mtf.materials_balance.group_id,
                mtf.groups.name
            order by
                wallets.name ASC,
                mtf.groups.name ASC
        ";

        // dd($myQuery);
        $recepcionMaterial = [];
        if ($myWallet != 0 && $myGroup != 0){
            $recepcionMaterial = DB::select($myQuery);
            $recepcionMaterial = $recepcionMaterial[0] ?? [];
        }

       // dd($recepcionMaterial);
        // $Recargas3 = array_merge($Recargas, $Recargas2);
        
        // usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});

        $materialsCierre =  $this->materialBuscaCierre();
        // dd($materialsCierre);

        $wallet             = $this->getWallet();
        $group              = $this->getGroups();
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        $parametros['materialsCierre']          = $materialsCierre;
        $parametros['balance']                  = $balance;

        $parametros['myWallet']                 = $myWallet;
        $parametros['myGroup']                  = $myGroup;
        $parametros['myType_material']          = $myType_material; 
        $parametros['myFechaDesde']             = $myFechaDesde; 
        $parametros['myFechaHasta']             = $myFechaHasta;

        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;
        $parametros['type_material']            = $type_material;

        $parametros['pagosUSDT']                = $pagosUSDT;
        $parametros['adquisicionesMaterial']    = $adquisicionesMaterial;
        $parametros['recepcionMaterial']        = $recepcionMaterial;

        return view('estadisticas.materialPosicionConsolidadaGrupo', $parametros);


    }    
    /*
    *
    *
    *       USDTResumen (resumen general USDT) 10-05-2024
    *
    * leamx
    */
    function USDTResumen(Request $request){

        //  return;

        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt

        $theWallets[]   = 93;
        $theWallets[]   = 139;
        $theWallets[]   = 511;

        $myUSDTWallets  = implode(",", $theWallets);
        $wallets        = Group::where('type', '=', '2')->whereIn('id', $theWallets)->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        // dd($wallets);
        // $wallets        = Group::where('type', '=', '2')->whereIn('id', $theWallets)->orderBY('name','ASC')->get();

        $myWallet       = 0;
        $myWalletDesde  = 00000;
        $myWalletHasta  = 99999;
        if ($request->wallet){
            $myWallet       = $request->wallet;
            $myUSDTWallets  = $request->wallet;
            $myWalletDesde  = $request->wallet;
            $myWalletHasta  = $request->wallet;
        }


        //$wallet                         = $this->getWalletUSDT();
        $wallet2                        = $this->getWallet();
        $grupo                          = $this->getGroups();


        // dd($wallets);
        // dd($myUSDTWallets);

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
        $request->transaction   = 11; // 11 pago usdt 
        /*
        echo "<pre>";
        echo"fechaDesde - >" . $request->fechaDesde;
        echo"fechaHasta - >" . $request->fechaHasta;
        echo "</pre>";
        die();
        */

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        }
        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
        }
        // dd('statiscticController -> ' . $request->fechaDesde . ' -- ' . $request->fechaHasta);

        /*
        echo "<pre>";
        echo"myFechaDesde - >" . $myFechaDesde;
        echo"myFechaHasta - >" . $myFechaHasta;
        echo "</pre>";
        die();
        */


        //$myFechaDesde = "2001-01-01";
        //$myFechaHasta = "9999-12-31";

        $horaDesde = " 00:00:00";
        $horaHasta = " 23:59:00";

        $myFechaDesde2 = $myFechaDesde . $horaDesde;
        $myFechaHasta2 = $myFechaHasta . $horaHasta;

        $myTable = "mtf.transactions";


        //dd($myUSDTWallets);
        //
        //
        //  pagos que se hacen a la caja (groupid debe ser la caja)
        //
        //

        $myQuery =
        "
            select
                mtf.transactions.group_id                           as WalletId,
                mtf.groups.name                                     as WalletName,
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
                and group_id                in($myUSDTWallets)
                and type_transaction_id     = 11
                and transaction_date        between '$myFechaDesde2'             and     '$myFechaHasta2'
            group by
                WalletId,
                WalletName
            order by
                WalletName ASC
        ";

        // dd($myQuery);
        
        $Recargas = DB::select($myQuery);
        // dd($Recargas);

        $myTransactionDesde     = 13; // 13 cobros usdt
        $myTransactionHasta     = 13;
        //
        //
        // cobros que haga la caja (el wallet_id debe ser igual a la caja)
        //
        //
        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,                
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
                and mtf.transactions.wallet_id                in($myUSDTWallets)
                and type_transaction_id     = 13
                and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
            group by
                WalletId,
                WalletName
            order by
                WalletName ASC
        ";
 
        // dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);

        // $Recargas3 = array_merge($Recargas, $Recargas2);
        
        // usort($Recargas3, function($a, $b) {return strcmp($a->TransactionDate, $b->TransactionDate);});


        $myJson             = file_get_contents("filtros\myUSDTResDiaMovimientosFiltro");
        $myJsonData         = json_decode($myJson,true); 
        
        $request->groups    = $myJsonData['groupsEntrada1'];
        $myGroups           = implode(",",$request->groups);
        //
        //
        // entradas por comision son pagos (11) y cobros (13) que se paga a grupos desde el wallet usdt
        //
        //
        $myQuery =
        "
            select
                mtf.transactions.wallet_id                          as WalletId,
                wallets.name                                        as WalletName,                
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
                and wallet_id                in($myUSDTWallets)
                and group_id                 in($myGroups)
                and type_transaction_id      in(11,13)
                and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
            group by
                WalletId,
                WalletName
            order by
                wallets.name ASC
        ";
 
        //dd($myQuery);
         $comisiones = DB::select($myQuery);
        // dd($comisiones);

        // echo"<p>comisiones</p>";
        // echo "<pre>";
        // echo print_r($comisiones);
        // echo "</pre>";
        // die();


         $request->groups = $myJsonData['groupsSalida1'];
         $myGroups = implode(",",$request->groups);
        //
        //
        // salidas - pagos (11) que la caja haga a grupos
        //
        //
         $myQuery =
         "
             select
                 mtf.transactions.wallet_id                          as WalletId,
                 wallets.name                                        as WalletName,              
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
                 and wallet_id                in($myUSDTWallets)
                 and group_id                 in($myGroups)
                 and type_transaction_id      in(11)
                 and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
             group by
                WalletId,
                WalletName
             order by
                 wallets.name ASC
         ";
  
         //dd($myQuery);
          $salidas1 = DB::select($myQuery);
            // echo "<pre>";
            // echo print_r($salidas1);
            // echo "</pre>";
            // die();
        //  dd($salidas1);



          $request->groups = $myJsonData['groupsSalida2'];
          $myGroups = implode(",",$request->groups);
         //
        //
        // salidas - pagos (11) que la caja haga a grupos
        //
        //
          $myQuery =
          "
              select
                  mtf.transactions.wallet_id                          as WalletId,
                  wallets.name                                        as WalletName,               
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
                  and wallet_id                in($myUSDTWallets)
                  and group_id                 in($myGroups)
                  and type_transaction_id      in(11)
                  and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
              group by
                WalletId,
                WalletName
              order by
                  wallets.name ASC
          ";
   
          //dd($myQuery);
        $salidas2 = DB::select($myQuery);          
            // echo "<p>Salidas 2</p>";
            // echo "<pre>";
            // echo print_r($salidas2);
            // echo "</pre>";
            // die();




        $request->groups = $myJsonData['groupsSalida3'];
        $myGroups = implode(",",$request->groups);
          //
        //
        // salidas - pagos (11) que la caja ahaga a grupos
        //
        //
        $myQuery =
           "
               select
                   mtf.transactions.wallet_id                          as WalletId,
                   wallets.name                                        as WalletName,                
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
                   and wallet_id                in($myUSDTWallets)
                   and group_id                 in($myGroups)
                   and type_transaction_id      in(11)
                   and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
               group by
                    WalletId,
                    WalletName
               order by
                   wallets.name ASC
           ";
    
            //dd($myQuery);
        $salidas3 = DB::select($myQuery);
      
            // echo "<p>Salidas 3</p>";
            // echo "<pre>";
            // echo print_r($salidas3);
            // echo "</pre>";
            // die();


        $request->groups = $myJsonData['walletsSalida3'];
        $myGroups = implode(",",$request->groups);
            //
            //
            // salidas - pagos (11) que la caja ahaga a grupos
            //
            //
        $myQuery =
            "
                select
                    mtf.transactions.wallet_id                          as WalletId,
                    wallets.name                                        as WalletName,               
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
                    and wallet_id                in($myUSDTWallets)
                    and group_id                 in($myGroups)
                    and type_transaction_id      in(11)
                    and transaction_date         between '$myFechaDesde2'             and     '$myFechaHasta2'
                group by
                    WalletId,
                    WalletName
                order by
                    wallets.name ASC
            ";
     
            //dd($myQuery);
             $salidas4 = DB::select($myQuery);

            //  echo "<p>Salidas 4</p>";
            //  echo "<pre>";
            //  echo print_r($salidas4);
            //  echo "</pre>";
            //  die();

             
             $Entradas  = array_merge($Recargas, $Recargas2, $comisiones); // 
             $Salidas   = array_merge($salidas1, $salidas2, $salidas3, $salidas4); // 
            // dd($wallets);
            /*
              echo "<p>Salidas 4</p>";
              echo "<pre>";
              echo print_r($Salidas);
              echo "</pre>";
              die();
            */


            foreach($wallets as $key => $walletItem){

                if ($myWallet != 0){
                    if ($key != $myWallet){
                        continue;
                    }
                }

                $balance        = 0;
                $balanceBefore  = 0;
                if ($key > 0){
                    // 
                    $balance        = $this->getBalanceWallet($key);
                    $balance        = $balance->Total;

                    $balanceBefore  = $this->getBalanceWalletBefore($key, $myFechaDesde, $myFechaHasta);
                     
                }


                $genericObject = new \stdClass();

                $genericObject->WalletId                = $key;
                $genericObject->WalletName              = $walletItem;

                $genericObject->balance                 = $balance;
                $genericObject->balanceBefore           = $balanceBefore;

                /*
                $genericObject->WalletId                = $walletItem;
                $genericObject->EntradaCant                    = ->Cant;
                $genericObject->EntradaAmountForeignCurrency   = ->AmountForeignCurrency;
                $genericObject->EntradaAmount                  = ->Amount;
                $genericObject->EntradaAmountTotal             = ->AmountTotal;
                $genericObject->EntradaAmountCommission        = ->AmountCommission;
                $genericObject->EntradaAmountBase              = ->AmountBase;
                $genericObject->EntradaAmountCommissionBase    = ->AmountCommissionBase;
                $genericObject->EntradaAmountCommissionProfit  = ->AmountCommissionProfit;
                
                $genericObject->SalidaCant                      = ->Cant;
                $genericObject->SalidaAmountForeignCurrency     = ->AmountForeignCurrency;
                $genericObject->SalidaAmount                    = ->Amount;
                $genericObject->SalidaAmountTotal               = ->AmountTotal;
                $genericObject->SalidaAmountCommission          = ->AmountCommission;
                $genericObject->SalidaAmountBase                = ->AmountBase;
                $genericObject->SalidaAmountCommissionBase      = ->AmountCommissionBase;
                $genericObject->SalidaAmountCommissionProfit    = ->AmountCommissionProfit;
                */


                $genericObject->EntradaCant                     = 0;
                $genericObject->EntradaAmount                   = 0;
                $genericObject->EntradaAmountForeignCurrency    = 0;
                $genericObject->EntradaAmountTotal              = 0;
                $genericObject->EntradaAmountCommission         = 0;
                $genericObject->EntradaAmountBase               = 0;
                $genericObject->EntradaAmountCommissionBase     = 0;
                $genericObject->EntradaAmountCommissionProfit   = 0;


                foreach($Entradas as $item){
                    if ($key == $item->WalletId){
                        $genericObject->EntradaCant                     += $item->Cant;
                        $genericObject->EntradaAmount                   += $item->Amount;
                        $genericObject->EntradaAmountForeignCurrency    += $item->AmountForeignCurrency;
                        $genericObject->EntradaAmountTotal              += $item->AmountTotal;
                        $genericObject->EntradaAmountCommission         += $item->AmountCommission;
                        $genericObject->EntradaAmountBase               += $item->AmountBase;
                        $genericObject->EntradaAmountCommissionBase     += $item->AmountCommissionBase;
                        $genericObject->EntradaAmountCommissionProfit   += $item->AmountCommissionProfit;
                    }
                };

                $genericObject->SalidaCant                     = 0;
                $genericObject->SalidaAmount                   = 0;
                $genericObject->SalidaAmountForeignCurrency    = 0;
                $genericObject->SalidaAmountTotal              = 0;
                $genericObject->SalidaAmountCommission         = 0;
                $genericObject->SalidaAmountBase               = 0;
                $genericObject->SalidaAmountCommissionBase     = 0;
                $genericObject->SalidaAmountCommissionProfit   = 0;

                foreach($Salidas as $item){
                    if ($key == $item->WalletId){
                        $genericObject->SalidaCant                     += $item->Cant;
                        $genericObject->SalidaAmount                   += $item->Amount;
                        $genericObject->SalidaAmountForeignCurrency    += $item->AmountForeignCurrency;
                        $genericObject->SalidaAmountTotal              += $item->AmountTotal;
                        $genericObject->SalidaAmountCommission         += $item->AmountCommission;
                        $genericObject->SalidaAmountBase               += $item->AmountBase;
                        $genericObject->SalidaAmountCommissionBase     += $item->AmountCommissionBase;
                        $genericObject->SalidaAmountCommissionProfit   += $item->AmountCommissionProfit;
                    }
                };


                $genericObject->totalPendienteUSDTMonto  = ($balanceBefore + $genericObject->EntradaAmount) - $genericObject->SalidaAmount;


                $Transacciones4[] = $genericObject;

             }

            //   echo "<p>Transacciones4</p>";
            //   echo "<pre>";
            //   echo print_r($Transacciones4);
            //   echo "</pre>";
            //   die();

            $myQuery =
            "
                SELECT  distinct
                    group_id,
                    mtf.groups.name
                FROM mtf.transactions
                    left join
                    mtf.groups on mtf.transactions.group_id = mtf.groups.id 
                where
                    type_transaction_id = 11
                and mtf.groups.type     = 1
                order by
                    group_id
            ";
     
            //dd($myQuery);
            $pagosUSDTGrupos = DB::select($myQuery);
             /*
             echo "<pre>";
             echo print_r($pagosUSDTGrupos);
             echo "</pre>";
             die();
             */

            $parametros['Transacciones']    = $Transacciones4;
            $parametros['wallet']           = $wallets;
            $parametros['myWallet']         = $myWallet;
            $parametros['myFechaDesde']     = $myFechaDesde;
            $parametros['myFechaHasta']     = $myFechaHasta;

            $parametros['wallet2']          = $wallet2;
            $parametros['grupo']            = $grupo;

            $parametros['pagosUSDTGrupos']  = $pagosUSDTGrupos;
            // dd($pagosUSDTGrupos);
            return view('estadisticas.ResumenMovientosUSDT', $parametros); 
            // return $Transacciones4;

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

        $myTransactionDesde     = 13; // 13 cobros usdt
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
 
        // dd($myQuery);
         $Recargas2 = DB::select($myQuery);
        // dd($Recargas2);

        $Recargas3 = array_merge($Recargas, $Recargas2); // 
        
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
                and wallet_id between       $myWalletDesde and $myWalletHasta
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

        $horaDesde      = " 00:00:00";
        $horaHasta      = " 23:59:00";

        $myFechaDesde   = $myFechaDesde . $horaDesde;
        $myFechaHasta   = $myFechaHasta . $horaHasta;

        $myTable        = "mtf.transactions";


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
        // dd($myQuery);
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
    *       consolidadoMovimientosGrupo
    *
    *
    */
    function consolidadoMovimientosGrupo(Request $request){
        // \Log::info('leam - statisticsController - commissionsProfit - el wallet es ->' . $request->wallet);
        // $request->wallet        = 89;   // abu mahmud
        // $request->wallet        = 93;   // caja usdt
        // $request->wallet        = 139;  // caja principal usdt


        $myWalletDesde = 00000;
        $myWalletHasta = 99999;
        if ($request->wallet){
            $myWalletDesde = $request->wallet;
            $myWalletHasta = $request->wallet;
        }

        $myGrupo      = 0;
        $myGroupDesde = 00000;
        $myGroupHasta = 99999;
        if ($request->grupo){
            $myGrupo        = $request->grupo;
            $myGroupDesde   = $request->grupo;
            $myGroupHasta   = $request->grupo;
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

        // $myFechaDesde = "2001-01-01";
        // $myFechaHasta = "9999-12-31";

        $horaDesde          = " 00:00:00";
        $horaHasta          = " 23:59:00";

        $myFechaDesde       = $myFechaDesde . $horaDesde;
        $myFechaHasta       = $myFechaHasta . $horaHasta;

		$myCoin             = ($request->coin) ? $request->coin : 1;

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();

        if ($request->grupo){
            $myQuery =
            "
                select
                    mtf.transactions.group_id                       as GroupId,
                    mtf.groups.name                                 as GroupName,
                    type_transactions.type_transaction_group        as TypeTransactionGroup,
                    mtf.transactions.type_transaction_id            as TypeTransactionId,
                    type_transactions.name                          as TypeTransactionName,
                    count(mtf.transactions.id)                      as TransactionCount,
                    sum(amount)                                     as Amount,
                    sum(amount_commission)                          as AmountCommission,
                    sum(amount_commission_base)                     as AmountCommissionBase,
                    sum(amount_commission - amount_commission_base) as AmountCommissionProfit
                from
                            mtf.transactions
                left join   mtf.type_transactions   on mtf.transactions.type_transaction_id = mtf.type_transactions.id
                left join   mtf.groups              on mtf.Transactions.group_id            = mtf.groups.id
                where
                        status = 'Activo'
                    and group_id             between $myGroupDesde               and     $myGroupHasta
                    and type_transaction_id  between $myTransactionDesde         and     $myTransactionHasta
                    and transaction_date     between '$myFechaDesde'             and     '$myFechaHasta'
                    and type_coin_balance_id = $myCoin 
                group by
                    mtf.transactions.group_id, 
                    mtf.groups.name,
                    type_transactions.type_transaction_group,
                    mtf.transactions.type_transaction_id,
                    type_transactions.name
                order by
                    mtf.groups.name         asc,
                    TypeTransactionGroup    asc,
                    type_transactions.name  asc
            ";

            // dd($myQuery);
            
            $Transacciones = DB::select($myQuery);


            // dd($Transacciones);
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

            $myGroup       = 0;
            $myGroupDesde = 00000;
            $myGroupHasta = 99999;
            if ($request->grupo){
                $myGroup      = $request->grupo;
                $myGroupDesde = $request->grupo;
                $myGroupHasta = $request->grupo;
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

            $horaDesde      = " 00:00:00";
            $horaHasta      = " 23:59:00";

            $myFechaDesde = $myFechaDesde . $horaDesde;
            $myFechaHasta = $myFechaHasta . $horaHasta;
        

            $myQuery =
            "
            SELECT
                group_id                        as GroupId,
                grupos.name                     as GroupName,
                0                               as TypeTransactionGroup,
                type_transaction_id             as TypeTransactionId,
                type_transactions.name          as TypeTransactionName,            
                0                               as TransactionCount,
                amount                          as Amount,
                sum(amount_commission)          as AmountCommission,
                sum(amount_commission_base)     as AmountCommissionBase,
                sum(amount_commission_profit)   as AmountCommissionProfit
            FROM mtf.commissions_usdt
                left join mtf.groups as wallets on mtf.commissions_usdt.wallet_id   = wallets.id
                left join mtf.groups as grupos on mtf.commissions_usdt.group_id 	= grupos.id
                left join mtf.type_transactions type_transactions on mtf.commissions_usdt.type_transaction_id = type_transactions.id
            where 
                    group_id 	        between $myGroupDesde       and $myGroupHasta
                and transaction_date    between '$myFechaDesde'     and '$myFechaHasta'
                and type_coin_balance_id = $myCoin                 
            group by
                GroupId,
                grupos.name,
                TypeTransactionId,
                TypeTransactionName,
                Amount
            order by
                grupos.name
            ";

            // dd($myQuery);
            
            // \Log::info('leam My query *** -> ' . $myQuery);

            $TransaccionesUSDT  = DB::select($myQuery);
            //  $TransaccionesUSDT = [];
            // dd($Transacciones);
            //     dd($TransaccionesUSDT);
            //return;
            //return [$Transacciones, $TransaccionesUSDT];
            $myMonto                    = 0;
            $myAmountCommission         = 0;
            $myAmountCommissionBase     = 0;
            $myAmountCommissionProfit   = 0;
            foreach($TransaccionesUSDT as $MyTransaccionesUSDT){
                $myAmountCommission         += $MyTransaccionesUSDT->AmountCommission;
                $myAmountCommissionBase     += $MyTransaccionesUSDT->AmountCommissionBase;
                $myAmountCommissionProfit   += $MyTransaccionesUSDT->AmountCommissionProfit;
            }
            foreach($Transacciones as $MyTransacciones){
                if ($MyTransacciones->GroupId == $myGroup){
                    if ($MyTransacciones->TypeTransactionId == 11){
                        $MyTransacciones->AmountCommission          = $myAmountCommission;
                        $MyTransacciones->AmountCommissionBase      = $myAmountCommissionBase;
                        $MyTransacciones->AmountCommissionProfit    = $myAmountCommissionProfit;
                    }
                }
            }

            // dd($myMonto);

        }else{

            $Transacciones = [];
            $TransaccionesUSDT = [];
        }

        $grupo                           = app(statisticsController::class)->getGroups();

		$parametros['myTypeCoinBalance']        = $myTypeCoinBalance;
        $parametros['Type_coin_balance']        = $Type_coin_balance;

        $parametros['myFechaDesde']         = $myFechaDesde;
        $parametros['myFechaHasta']         = $myFechaHasta;
        $parametros['myGrupo']              = $myGrupo;
        $parametros['grupo']                = $grupo;
        $parametros['Transacciones']        = $Transacciones;
        $parametros['TransaccionesUSDT']    = $TransaccionesUSDT;

        return view('dashboardConsolidadoMovimientosGrupo', $parametros);


    }

    /*
    *
    *
    *       commissionsProfitRes3
    *
    *
    */
    function commissionsProfitRes3(Request $request){
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
        if ($request->grupo){
            $myGroupDesde = $request->grupo;
            $myGroupHasta = $request->grupo;
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
                 1.5                                             as PercentageBase,
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
        if ($request->grupo){
            $myGroupDesde = $request->grupo;
            $myGroupHasta = $request->grupo;
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
        SELECT
            wallet_id                       as WalletId,
            wallets.name                    as WalletName,
            type_transaction_id             as TypeTransactionId,
            type_transactions.name          as TypeTransactionName,
            group_id                        as GroupId,
            grupos.name                     as GroupName,
            sum(amount)                     as Amount,
            sum(amount2)                    as Amount2,
            sum(amount_commission)          as AmountCommission,
            sum(amount_commission_base)     as AmountCommissionBase,
            sum(amount_commission_profit)   as AmountCommissionProfit
        FROM mtf.commissions_usdt
            left join mtf.groups as wallets on mtf.commissions_usdt.wallet_id   = wallets.id
            left join mtf.groups as grupos on mtf.commissions_usdt.group_id 	= grupos.id
            left join mtf.type_transactions type_transactions on mtf.commissions_usdt.type_transaction_id = type_transactions.id
        where 
                wallet_id 	        between $myWalletDesde      and $myWalletHasta
            and group_id 	        between $myGroupDesde       and $myGroupHasta
            and transaction_date    between '$myFechaDesde'     and '$myFechaHasta'
        group by
            wallet_id,
            WalletName,
            GroupId,
            grupos.name,
            TypeTransactionId,
            TypeTransactionName
        order by
            wallet_id,
            grupos.name
        ";

        // dd($myQuery);
        
        // \Log::info('leam My query *** -> ' . $myQuery);

        $Transacciones  = DB::select($myQuery);
        // dd($Transacciones);
        // dd($Recargas3);
        return [$Recargas3, $Transacciones];

    }
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


    public function filtrosRolesGraba(Request $request){

        $myfile = fopen("./filtros/myRolesFiltros", "w") or die("Unable to open file!");

        $myLine = '{"wallets" : [' . implode(",",$request->myDataWallet) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        $myLine = '{"groups" : [' .implode(",",$request->myDataGroup) . "]}" . PHP_EOL;
        fwrite($myfile, $myLine);

        fclose($myfile);   



        // dd($request);
        // \Log::info(' llega por filtro wallet ->' . print_r($request->myDataWallet,true));
        // \Log::info(' llega por filtro group  ->' . print_r($request->myDataGroup,true));

        $myResponse = 
        [
            'success' => true,
            'data' => '',
            'message' => 'filtros guardados exitosamente'
        ];

        return response()->json($myResponse);
    }

    function filtrosRolesWalletsLee(){

        $myfile = fopen("./filtros/myRolesFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

        $myWallets = json_decode($myWallets,true);
        // $myGroups = json_decode($myGroups);

        // \Log::info('lee myWallets -> ' . print_r($myWallets,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroups,true));

        return $myWallets['wallets'];

    }
    function filtrosRolesGroupsLee(){

        $myfile = fopen("./filtros/myRolesFiltros", "r") or die("Unable to open file!");

        
        $myWallets = fgets($myfile);
        
        $myGroups  = fgets($myfile);



        fclose($myfile);        

        $myWallets  = json_decode($myWallets,true);
        $myGroups   = json_decode($myGroups);

        // \Log::info('lee myWallets -> ' . print_r($myWallets,true));
        // \Log::info('lee myGroups  -> ' . print_r($myGroups,true));

        return $myWallets['groups'];

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
        

        // \Log::info('lee myOcultarresumengeneral -> ' . print_r($myOcultarresumengeneral,true));
        // \Log::info('lee myOcultarresumentransaccion  -> ' . print_r($myOcultarresumentransaccion,true));
        // \Log::info('lee mytransactions  -> ' . print_r($mytransactions,true));

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

    function isAdministrator(){

        foreach(auth()->user()->roles as $roles)
        {
           if($roles->name == 'Administrador' || $roles->name == 'Supervisor'){        
                return true;
           }
        }
        return false;

    }


     function getGroupRole( $myId = 0){

    



        // $myUserId = Auth()->User()->id;
        // $myUserId = Auth::User()->id;
        // dd($myUserId);

        $Group_roles = app(RoleController::class)->getRoleWallets($myId);

        // dd($Group_roles);
        //dd($roles->id);
        return $Group_roles;

    }


    public function USDTResumenCaja(request $request)
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
        
        
        //
        $wallet                         = $this->getWalletUSDT();
        $wallet2                        = $this->getWallet();
        $grupo                          = $this->getGroups();
        $typeTransactions               = Type_transaction::pluck('name', 'id')->toArray();

        $balance                        = 0;
        $balanceBefore                  = 0;
        
        if ($myWallet > 0){
            
            $balance        = $this->getBalanceWallet($myWallet);
            $balanceBefore  = $this->getBalanceWalletBefore($myWallet,$myFechaDesde, $myFechaHasta);
             
        }

        $transaccionesGrupoSalida       = [];
        $transaccionesGrupoSalida2      = [];
        $transaccionesGrupoSalida3      = [];
        $transaccionesWalletsSalida3    = [];

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

}

?>
