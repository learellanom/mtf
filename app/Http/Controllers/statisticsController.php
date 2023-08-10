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

class statisticsController extends Controller
{




    public function getCredits(){
        return $this->myCredits;
    }

    public function getDebits(){
        return $this->myDebits;
    }

    private $myCredits          = "1,3,5,6,7,9,11,14,15,16,17,18";
    private $myDebits           = "2,4,8,10,12,13,19,20,21,22,23";
    public function getCreditDebitGroup($myType){
        /*
        $myTypeCredit[] = 1;
        $myTypeCredit[] = 3;
        $myTypeCredit[] = 5;
        $myTypeCredit[] = 6;
        $myTypeCredit[] = 7;
        $myTypeCredit[] = 9;
        $myTypeCredit[] = 11;
        $myTypeCredit[] = 14;
        $myTypeCredit[] = 15;
        $myTypeCredit[] = 16;
        $myTypeCredit[] = 17;
        $myTypeCredit[] = 18;

        $myTypeDebit[]  = 2;
        $myTypeDebit[]  = 4;
        $myTypeDebit[]  = 8;
        $myTypeDebit[]  = 10;
        $myTypeDebit[]  = 12;
        $myTypeDebit[]  = 13;
        $myTypeDebit[]  = 19;
        $myTypeDebit[]  = 20;
        $myTypeDebit[]  = 21;
        $myTypeDebit[]  = 22;
        $myTypeDebit[]  = 23;
        */
        $myTypeCredit   = explode(",",$this->myCredits);
        $myTypeDebit    = explode(",",$this->myDebits);


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
    private $myCreditsWallet    = "2,4,6,7,10,13,19,20,21,22,23";
    private $myDebitsWallet     = "1,3,5,8,9,11,12,14,15,16,17,18";
    public function getCreditDebitWallet($myType){
        /*
        $myTypeCredit[] = 2;
        $myTypeCredit[] = 4;
        $myTypeCredit[] = 6;
        $myTypeCredit[] = 7;
        $myTypeCredit[] = 10;
        $myTypeCredit[] = 13;
        $myTypeCredit[] = 19;
        $myTypeCredit[] = 20;
        $myTypeCredit[] = 21;
        $myTypeCredit[] = 22;
        $myTypeCredit[] = 23;

        $myTypeDebit[]  = 1;
        $myTypeDebit[]  = 3;
        $myTypeDebit[]  = 5;
        $myTypeDebit[]  = 8;
        $myTypeDebit[]  = 9;
        $myTypeDebit[]  = 11;
        $myTypeDebit[]  = 12;
        $myTypeDebit[]  = 14;
        $myTypeDebit[]  = 15;
        $myTypeDebit[]  = 16;
        $myTypeDebit[]  = 17;
        $myTypeDebit[]  = 18;
        */
        
         $myTypeCredit   = explode(",",$this->myCreditsWallet);
         $myTypeDebit    = explode(",",$this->myDebitsWallet);


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
    *   index_all
    *
    *
    */
    public function index_all(Request $request)
    {

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }

        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
        }

        $myWallet       = 0;
        $myWalletDesde  = 0;
        $myWalletHasta  = 9999;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
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

        $myTypeTransactions         = 0;
        $myTypeTransactionsDesde    = 0;
        $myTypeTransactionsHasta    = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions         = $request->typeTransactions;
            $myTypeTransactionsDesde    = $request->typeTransactions;
            $myTypeTransactionsHasta    = $request->typeTransactions;
        }else{
            $myTypeTransactionsDesde    = 0;
            $myTypeTransactionsHasta    = 9999;
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
            // dd('mygroup -> ' . $myGroup);

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
        }
        ;
        // dd($balance);
        $myUserDesde = 0;
        $myUserHasta = 9999;

        $myGroupDesde = 0;
        $myGroupHasta = 9999;



        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($myGroup != 0){
            $myGroupDesde = $myGroup;
            $myGroupHasta = $myGroup;
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
        if ($myGroup != 0){
            $Transacciones = Transaction::select(
                'Transactions.id                        as Id',
                'Transactions.amount_foreign_currency   as MontoMoneda',
                'Transactions.exchange_rate             as TasaCambio',
                'Transactions.type_coin_id              as TipoMonedaId',
                'type_coins.name                        as TipoMoneda',
                'users.name                             as AgenteName',
                'Transactions.amount                    as Monto',
                'Transactions.amount_total              as MontoTotal',
                'Transactions.percentage                as PorcentajeComision',
                'Transactions.amount_commission         as MontoComision',
                'Transactions.amount_total_base         as MontoTotalBase',
                'Transactions.percentage_base           as PorcentajeComisionBase',
                'Transactions.amount_commission_base    as MontoComisionBase',
                'Transactions.type_transaction_id       as TransactionId',
                'type_transactions.name                 as TipoTransaccion',
                'transactions.wallet_id                 as WalletId',
                'wallets.name                           as WalletName',
                'transactions.walletb_id                as WalletbId',
                'wallets2.name                          as WalletbName',                
                'transactions.description               as Descripcion',
                'transactions.transaction_date          as FechaTransaccion',
                'Transactions.group_id                  as ClienteId',                
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
            )->leftJoin(
                'wallets as wallets2', 'wallets2.id', '=', 'transactions.walletb_id'                    
            )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
            )->whereBetween('Transactions.group_id',            [$myGroupDesde, $myGroupHasta]
            )->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionsDesde, $myTypeTransactionsHasta]
            )->whereBetween('Transactions.transaction_date',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"]
            )->where('Transactions.status', '=', 'Activo'
            )->orderBy('Transactions.transaction_date','ASC'
            )->get();

            $Transacciones2 = array();
            foreach($Transacciones as $tran){
                $value1 = json_decode($tran);
    
                $value2 = array_values(json_decode(json_encode($tran), true));
    
                array_push($Transacciones2, $value2);
            }
    

        }else{

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


        $myUserDesde = 0;
        $myUserHasta = 9999;
        $myClienteDesde = 0;
        $myClienteHasta = 9999;
        $myWalletDesde = 0;
        $myWalletHasta = 9999;

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
    *       ajua
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

        $Transacciones          = $this->getwalletTransactionSummary($request);

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

        return view('estadisticas.statisticsResumenWalletTransaccion', compact('myWallet','wallet','myTypeTransaction', 'Type_transactions', 'Transacciones','myFechaDesde','myFechaHasta','balance'));

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

        // $Transacciones1         = $this->getwalletTransactionSummary($request);
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

        $Transacciones = DB::table('transactions')
            ->select(DB::raw("
                wallet_id                   as WalletId,
                wallets.name                as WalletName,
                type_transaction_id         as TypeTransactionId,
                type_transactions.name      as TypeTransaccionName,
                1                           as ItemGroup,                      
                ''                          as GroupId,
                ''                          as GroupName,                
                count(*)                    as cant_transactions,
                sum(amount)                 as total_amount,                
                sum(amount_commission_base) as total_amount_commission_base,
                sum(amount_commission)      as total_commission,
                sum(amount_base)            as total_amount_base,                
                sum(amount_total_base)      as total_Base,                
                (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit,
                sum(amount_total)           as total"))
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
            wallet_id                   as WalletId,
            wallets.name                as WalletName,
            type_transaction_id         as TypeTransactionId,
            type_transactions.name      as TypeTransaccionName,                       
            group_id                    as GroupId,
            groups.name                 as GroupName,
            count(*)                    as cant_transactions,
            sum(amount)                 as total_amount,
            sum(amount_base)            as total_amount_base,
            sum(amount_commission)      as total_commission,
            sum(amount_commission_base) as total_amount_commission_base,
            sum(amount_total)           as total,
            sum(amount_total_base)      as total_Base,
            (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit
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
            0                           as WalletId,
            ''                          as WalletName,
            type_transaction_id         as TypeTransactionId,
            type_transactions.name      as TypeTransaccionName,
            count(*)                    as cant_transactions,
            sum(amount)                 as total_amount,
            sum(amount_base)            as total_amount_base,
            sum(amount_commission)      as total_commission,
            sum(amount_commission_base) as total_amount_commission_base,
            sum(amount_total)           as total,
            sum(amount_total_base)      as total_Base,
            (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit
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
            0                   as WalletId,
            ''                as WalletName,
            type_transaction_id         as TypeTransactionId,
            type_transactions.name      as TypeTransaccionName,    
            group_id                    as GroupId,
            groups.name                 as GroupName,
            count(*)                    as cant_transactions,
            sum(amount)                 as total_amount,
            sum(amount_base)            as total_amount_base,
            sum(amount_commission)      as total_commission,
            sum(amount_commission_base) as total_amount_commission_base,
            sum(amount_total)           as total,
            sum(amount_total_base)      as total_Base,
            (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit
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

        $myQuery =
        "
        select
            IdGrupo             as IdGrupo,
            NombreGrupo         as NombreGrupo,
            sum(MontoCreditos)  as Creditos,
            sum(MontoDebitos)   as Debitos,
            (sum(MontoCreditos) - sum(MontoDebitos) ) as Total
        from(
        SELECT
            group_id          as IdGrupo,
            mtf.groups.name   as NombreGrupo,
            0 				  as MontoCreditos,
            sum(amount_total) as MontoDebitos
        FROM mtf.transactions
        left join  mtf.groups on mtf.transactions.group_id  = mtf.groups.id
        where
            type_transaction_id in ($this->myDebits)
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
            sum(amount_total)   as MontoCreditos,
            0                   as MontoDebitos
        FROM mtf.transactions
        left join  mtf.groups on mtf.transactions.group_id  = mtf.groups.id
        where
            type_transaction_id in($this->myCredits)
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
            (sum(MontoComision) - sum(MontoComisionBase) )  as ComisionGanancia
        from(
            SELECT
                wallet_id                   as IdWallet,
                mtf.groups.name             as NombreWallet,
                0 				            as MontoCreditos,
                sum(amount_total_base)      as MontoDebitos,
                sum(amount_commission)      as MontoComision,
                sum(amount_commission_base) as MontoComisionBase
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($this->myDebitsWallet)
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
                wallet_id                   as IdWallet,
                mtf.groups.name             as NombreWallet,
                sum(amount_total_base)      as MontoCreditos,
                0                           as MontoDebitos,
                sum(amount_commission)      as MontoComision,
                sum(amount_commission_base) as MontoComisionBase                
            FROM $myTable
            left join  mtf.groups on mtf.transactions.wallet_id  = mtf.groups.id
            where
                type_transaction_id in ($this->myCreditsWallet)
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
    * devuelve dia anterior en formato string yyy-mm-dd
    *
    */
    function getDayBefore($myDate){
        $myFecha1 = date($myDate);
        $myFecha2 = date("Y-m-d", strtotime($myFecha1 . "-1 days"));
        return $myFecha2;
    }

}

?>
