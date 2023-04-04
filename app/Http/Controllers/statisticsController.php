<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Wallet;
use App\Models\Type_transaction;
use App\Models\Group;

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
    /*

    * Display a listing of the resource.

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

        // print_r($myUser);
        // die();

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
            ->whereBetween('Transactions.client_id', [$myClienteDesde, $myClienteHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])   
            ->groupBy('ClientName', 'TipoTransaccion')
            ->get();
  
  
            // dd($Transacciones);
        
        return view('estadisticas.statisticsResumenCliente', compact('myCliente','cliente','Transacciones'));            
        return $myUsers2;
    }
    
    
    public function walletSummary(Request $request)
    {

        
        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myWalletDesde = 0;
        $myWalletHasta = 9999;

        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
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

       
       $wallet = Wallet::select('wallets.id', 'wallets.name')
       ->get();

       //dd($wallet);

       $wallet2 = array();
       foreach($wallet as $wallet){
           $wallet22 [$wallet->id] =  $wallet->name;
       }
       $wallet = $wallet22;

        $Transacciones = DB::table('transactions')
            ->select(DB::raw(' 
                wallets.name as WalletName,
                type_transactions.name as TipoTransaccion,                
                count(*)    as cant_transactions, 
                sum(amount) as total_amount, 
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('wallets', 'wallets.id', '=', 'transactions.wallet_id')
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')             
            ->whereBetween('Transactions.wallet_id', [$myWalletDesde, $myWalletHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])
            ->groupBy('WalletName','TipoTransaccion')
            ->get();
  
  
            // dd($Transacciones);
        
        return view('estadisticas.statisticsResumenWallet', compact('myWallet', 'wallet', 'Transacciones'));   
        return $myUsers2;
    }


        
    public function transactionSummary(Request $request)
    {

        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;        
        if ($request->type_transaction) {
            $myTypeTransaction      = $request->type_transaction;
            $myTypeTransactionDesde = $request->type_transaction;
            $myTypeTransactionHasta = $request->type_transaction;        
    
        }

        //

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



       $Type_transactions = Type_transaction::select('type_transactions.id', 'type_transactions.name')
       ->get();
       $Type_transactions2 = array();
       foreach($Type_transactions as $Type_transactions){
           $Type_transactions2 [$Type_transactions->id] =  $Type_transactions->name;
       }
       $Type_transactions = $Type_transactions2;


        $Transacciones = DB::table('transactions')
            ->select(DB::raw(' 
                type_transactions.name as TipoTransaccion,                
                count(*)    as cant_transactions, 
                sum(amount) as total_amount, 
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')             
            ->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionDesde, $myTypeTransactionHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])
            ->groupBy('TipoTransaccion')
            ->get();
  
  
            // dd($Transacciones);
        
        return view('estadisticas.statisticsResumenTransaccion', compact('myTypeTransaction', 'Type_transactions', 'Transacciones'));   
        return $myUsers2;
    }
    /*

        Resumen por grupo

    */
    public function groupSummary(Request $request)
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


        //
        $myTypeTransaction      = 0;
        $myTypeTransactionDesde = 0;
        $myTypeTransactionHasta = 9999;        
        if ($request->type_transaction) {
            $myTypeTransaction      = $request->type_transaction;
            $myTypeTransactionDesde = $request->type_transaction;
            $myTypeTransactionHasta = $request->type_transaction;        
    
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

        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                groups.name as GroupName,
                type_transactions.name as TipoTransaccion,
                count(*)    as cant_transactions,
                sum(amount) as total_amount,
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('groups','groups.id', '=', 'transactions.group_id')
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')             
            ->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionDesde, $myTypeTransactionHasta])            
            ->whereBetween('Transactions.group_id', [$myGroupDesde, $myGroupHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])   
            ->groupBy('GroupName', 'TipoTransaccion')
            ->get();
  
  
            // dd($Transacciones);
        $Type_transactions = $this->getTypeTransactions();
        $groups = $this->getGroups();

        return view('estadisticas.statisticsResumenGrupo', compact('myGroup','groups','Type_transactions','Transacciones'));            
        
    }

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


        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                groups.name as GroupName,
                type_transactions.name as TipoTransaccion,
                count(*)    as cant_transactions,
                sum(amount) as total_amount,
                sum(amount_commission) as total_commission,
                sum(amount_total) as total'))
            ->leftJoin('groups','groups.id', '=', 'transactions.group_id')
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')             
            ->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionDesde, $myTypeTransactionHasta])            
            ->whereBetween('Transactions.group_id', [$myGroupDesde, $myGroupHasta])
            ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])   
            ->groupBy('GroupName', 'TipoTransaccion')
            ->get();        



    }

    /*

        Carga los grupos id y nombre

    */
    function getGroups(){
        $group = Group::select('groups.id', 'groups.name')
        ->get();

        $group2 = array();
        foreach($group as $gr){
            $group2 [$gr->id] =  $gr->name;
        }
        return $group2;
    }
    /*

        Carga los tipos de transacciones

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

}

?>
