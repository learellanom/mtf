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
        
        $balance = "";
        if ($myGroup > 0){
            $balance = $this->getBalance($myGroup);
        // }else{
        //     $balance = $this->getBalance($myGroup);
        //     dd($balance);
        };

        // dd($balance);

        $myUserDesde = 0;
        $myUserHasta = 9999;

        $myGroupDesde = 0;
        $myGroupHasta = 9999;

        $myWalletDesde = 0;
        $myWalletHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($myGroup != 0){
            $myGroupDesde = $myGroup;
            $myGroupHasta = $myGroup;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
        }

        // print_r($myGroup);
        // die($myGroup);
        if ($myGroup != 0){
            $Transacciones = Transaction::select(
                'Transactions.user_id as Id',
                'Transactions.amount_foreign_currency as MontoMoneda',
                'Transactions.exchange_rate           as TasaCambio',
                // 'Transactions.type_coin_id            as TipoMonedaId',
                'type_coins.name                      as TipoMoneda',
                'users.name as AgenteName',
                'Transactions.amount as Monto',            
                'Transactions.amount_total as MontoTotal',
                'Transactions.percentage as PorcentajeComision',
                'Transactions.amount_commission as MontoComision',
                'Transactions.type_transaction_id as TransactionId',
                'type_transactions.name as TipoTransaccion',
            //  'Transactions.client_id as ClienteId',
            //  'transactions.wallet_id As WalletId',
                'wallets.name As WalletName',
                'transactions.description as Descripcion',
                'transactions.transaction_date as FechaTransaccion',
                'groups.name as ClientName',
            )->leftJoin(
                'users','users.id', '=', 'transactions.user_id'
            )->leftJoin(
                'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
            )->leftJoin(
                'wallets', 'wallets.id', '=', 'transactions.wallet_id'
            )->leftJoin(
                'groups', 'groups.id', '=', 'transactions.group_id'
            )->leftJoin(
                    'type_coins', 'type_coins.id', '=', 'transactions.type_coin_id'            
            )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
            )->whereBetween('Transactions.group_id',            [$myGroupDesde, $myGroupHasta]
            )->whereBetween('Transactions.wallet_id',           [$myWalletDesde, $myWalletHasta]
            )->whereBetween('Transactions.transaction_date',    [$myFechaDesde, $myFechaHasta]
            )->where('Transactions.status', '=', 'Activo'
            )->orderBy('Transactions.transaction_date','ASC'
            )->get();
            }else{
            
                $Transacciones = Transaction::select(
                    'Transactions.user_id as Id',
                    'Transactions.amount_foreign_currency as MontoMoneda',
                    'Transactions.exchange_rate           as TasaCambio',
                    // 'Transactions.type_coin_id            as TipoMonedaId',
                    'type_coins.name                      as TipoMoneda',
                    'users.name as AgenteName',
                    'Transactions.amount as Monto',            
                    'Transactions.amount_total as MontoTotal',
                    'Transactions.percentage as PorcentajeComision',
                    'Transactions.amount_commission as MontoComision',
                    'Transactions.type_transaction_id as TransactionId',
                    'type_transactions.name as TipoTransaccion',
                //  'Transactions.client_id as ClienteId',
                //  'transactions.wallet_id As WalletId',
                    'wallets.name As WalletName',
                    'transactions.description as Descripcion',
                    'transactions.transaction_date as FechaTransaccion',
                    'groups.name as ClientName',
                )->leftJoin(
                    'users','users.id', '=', 'transactions.user_id'
                )->leftJoin(
                    'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
                )->leftJoin(
                    'wallets', 'wallets.id', '=', 'transactions.wallet_id'
                )->leftJoin(
                    'groups', 'groups.id', '=', 'transactions.group_id'
                )->leftJoin(
                        'type_coins', 'type_coins.id', '=', 'transactions.type_coin_id'            
                )->whereBetween('Transactions.user_id',             [$myUserDesde, $myUserHasta]
                )->whereBetween('Transactions.wallet_id',           [$myWalletDesde, $myWalletHasta]
                )->whereBetween('Transactions.transaction_date',    [$myFechaDesde, $myFechaHasta]
                )->where('Transactions.status', '=', 'Activo'
                )->orderBy('Transactions.transaction_date','ASC'
                )->get();
                
                // dd($Transacciones);
            }




        // dd($Transacciones);
        // die();

        $Transacciones2 = array();
        foreach($Transacciones as $tran){
            $value1 = json_decode($tran);

            $value2 = array_values(json_decode(json_encode($tran), true));

            array_push($Transacciones2, $value2);
        }

        $userole = $this->getUser();

        $wallet = $this->getWallet();

        $group = $this->getGroups();

        // return view('estadisticas.index2', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));
        return view('estadisticas.index', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));

    }
    //
    // transacciones master
    //
    public function masterDetail(Request $request)
    {
        
        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }

        $myGroup = 0;
        if ($request->grupo) {
            $myGroup = $request->grupo;
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
        
        $balance = "";
        if ($myGroup > 0){
            $balance = $this->getBalance($myGroup);
        // }else{
        //     $balance = $this->getBalance($myGroup);
        //     dd($balance);
        };

        // dd($balance);

        $myUserDesde = 0;
        $myUserHasta = 9999;

        $myGroupDesde = 0;
        $myGroupHasta = 9999;

        $myWalletDesde = 0;
        $myWalletHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($myGroup != 0){
            $myGroupDesde = $myGroup;
            $myGroupHasta = $myGroup;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
        }

        // print_r($myUser);
        // die();


        
        $Transacciones = Transaction_master::select(
            'Transaction_masters.user_id as Id',
            'Transaction_masters.amount_foreign_currency as MontoMoneda',
            'Transaction_masters.exchange_rate           as TasaCambio',
            // 'Transaction_masters.type_coin_id            as TipoMonedaId',
            'type_coins.name                      as TipoMoneda',
            'users.name as AgenteName',
            'Transaction_masters.amount as Monto',            
            'Transaction_masters.amount_total as MontoTotal',
            'Transaction_masters.percentage as PorcentajeComision',
            'Transaction_masters.amount_commission as MontoComision',
            'Transaction_masters.type_transaction_id as TransactionId',
            'type_transactions.name as TipoTransaccion',
        //  'Transaction_masters.client_id as ClienteId',
        //  'transaction_masters.wallet_id As WalletId',
            'wallets.name As WalletName',
            'transaction_masters.description as Descripcion',
            'transaction_masters.transaction_date as FechaTransaccion',
            'groups.name as ClientName',
        )->leftJoin(
            'users','users.id', '=', 'transaction_masters.user_id'
        )->leftJoin(
            'type_transactions', 'type_transactions.id', '=', 'transaction_masters.type_transaction_id'
        )->leftJoin(
            'wallets', 'wallets.id', '=', 'transaction_masters.wallet_id'
        )->leftJoin(
            'groups', 'groups.id', '=', 'transaction_masters.group_id'
        )->leftJoin(
                'type_coins', 'type_coins.id', '=', 'transaction_masters.type_coin_id'            
        )->whereBetween('Transaction_masters.user_id', [$myUserDesde, $myUserHasta]
        )->whereBetween('Transaction_masters.group_id', [$myGroupDesde, $myGroupHasta]
        )->whereBetween('Transaction_masters.wallet_id', [$myWalletDesde, $myWalletHasta]
        )->whereBetween('Transaction_masters.transaction_date', [$myFechaDesde, $myFechaHasta]
        )->where('Transaction_masters.status', '=', 'Activo'
        )->orderBy('Transaction_masters.transaction_date','ASC'
        )->get();

        // dd($Transacciones);
        // die();

        $Transacciones2 = array();
        foreach($Transacciones as $tran){
            $value1 = json_decode($tran);

            $value2 = array_values(json_decode(json_encode($tran), true));

            array_push($Transacciones2, $value2);
        }

        $userole = $this->getUser();

        $wallet = $this->getWallet();

        $group = $this->getGroups();

        // return view('estadisticas.index2', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));
        return view('estadisticas.index', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));

    }

    public function supplierDetail(Request $request)
    {
        
        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }

        $mySupplier = 0;
        if ($request->proveedor) {
            $mySupplier = $request->proveedor;
        }
        $myGroup    = 0;
        $group      = [];

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
        
        $balance = "";
        if ($mySupplier > 0){
            $balance = $this->getBalanceSupplier($mySupplier);
        };

        // dd($balance);

        $myUserDesde = 0;
        $myUserHasta = 9999;

        $mySupplierDesde = 0;
        $mySupplierHasta = 9999;

        $myWalletDesde = 0;
        $myWalletHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($mySupplier != 0){
            $mySupplierDesde = $mySupplier;
            $mySupplierHasta = $mySupplier;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
        }

        // print_r($myUser);
        // die();



        $Transacciones = Transaction_supplier::select(
            'Transaction_suppliers.user_id as Id',
            'Transaction_suppliers.amount_foreign_currency as MontoMoneda',
            'Transaction_suppliers.exchange_rate           as TasaCambio',
         // 'Transaction_suppliers.type_coin_id            as TipoMonedaId',
            'type_coins.name                                as TipoMoneda',
            'users.name                                     as AgenteName',
            'Transaction_suppliers.amount                   as Monto',            
            'Transaction_suppliers.amount_total             as MontoTotal',
            'Transaction_suppliers.percentage               as PorcentajeComision',
            'Transaction_suppliers.amount_commission        as MontoComision',
            'Transaction_suppliers.type_transaction_id      as TransactionId',
            'type_transactions.name                         as TipoTransaccion',
            'transaction_suppliers.description              as Descripcion',
            'transaction_suppliers.transaction_date         as FechaTransaccion',
            'suppliers.name                                 as SupplierName',
        )->leftJoin('users','users.id', '=', 'transaction_suppliers.user_id'
        )->leftJoin('type_transactions', 'type_transactions.id', '=', 'transaction_suppliers.type_transaction_id'
        )->leftJoin('suppliers', 'suppliers.id', '=', 'transaction_suppliers.supplier_id'
        )->leftJoin('type_coins', 'type_coins.id', '=', 'transaction_suppliers.type_coin_id'
        )->whereBetween('Transaction_suppliers.user_id',            [$myUserDesde, $myUserHasta]
        )->whereBetween('Transaction_suppliers.supplier_id',        [$mySupplierDesde, $mySupplierHasta]
        )->whereBetween('Transaction_suppliers.transaction_date',   [$myFechaDesde, $myFechaHasta]
        )->where('Transaction_suppliers.status', '=', 'Activo'
        )->orderBy('Transaction_suppliers.transaction_date','ASC'
        )->get();

        // dd($Transacciones);
        // die();

        $Transacciones2 = array();
        foreach($Transacciones as $tran){
            $value1 = json_decode($tran);

            $value2 = array_values(json_decode(json_encode($tran), true));

            array_push($Transacciones2, $value2);
        }

        $userole = $this->getUser();

        $proveedor = $this->getSuppliers();

        $wallet = $this->getWallet();

        $group = $this->getGroups();

        // return view('estadisticas.index2', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));
        return view('estadisticas.index', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));

    }



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
        $Transacciones      = $this->getBalance($myGroup);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups();

        return view('estadisticas.statisticsResumenGrupo', compact('myGroup','groups','Type_transactions','Transacciones'));            
        
    }
    /*

        Resumen por grupo2

    */
    public function groupSummary2(Request $request)
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
        $Type_transactions  = $this->getTypeTransactions();
        $groups             = $this->getGroups();

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


        // $Transacciones = DB::table('transactions')
        //     ->select(DB::raw('
        //         groups.name as GroupName,
        //         type_transactions.name as TipoTransaccion,
        //         count(*)    as cant_transactions,
        //         sum(amount) as total_amount,
        //         sum(amount_commission) as total_commission,
        //         sum(amount_total) as total'))
        //     ->leftJoin('groups','groups.id', '=', 'transactions.group_id')
        //     ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')             
        //     ->whereBetween('Transactions.type_transaction_id', [$myTypeTransactionDesde, $myTypeTransactionHasta])            
        //     ->whereBetween('Transactions.group_id', [$myGroupDesde, $myGroupHasta])
        //     ->whereBetween('Transactions.transaction_date', [$myFechaDesde, $myFechaHasta])   
        //     ->groupBy('GroupName', 'TipoTransaccion')
        //     ->get();        


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
        ->get();

        $group2 = array();
        foreach($group as $gr){
            $group2 [$gr->id] =  $gr->name;
        }
        return $group2;
    }

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

    function getWallet(){
        $wallet = Wallet::select('wallets.id', 'wallets.name')
        ->get();

        foreach($wallet as $wallet){
            $wallet2 [$wallet->id] =  $wallet->name;
        }
        return $wallet2;

    }
    /*

        getClient


    */
    function getClient(){
        $cliente2 = array();
        foreach($cliente as $cliente){
            $cliente2 [$cliente->id] =  $cliente->name;
        }
        return $cliente2;       
    }

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

    function getBalance($grupo = 0){
        
        if ($grupo === 0){
            $grupoDesde = 00000;
            $grupoHasta = 99999;
            
        }else{
            $grupoDesde = $grupo;
            $grupoHasta = $grupo;           
        }
        \Log::info('leam grupo      *** -> ' . $grupo);        
        \Log::info('leam grupoDesde *** -> ' . $grupoDesde); 
        \Log::info('leam grupoHasta *** -> ' . $grupoHasta); 
        
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
        $myQuery =
        "
        select 
            IdGrupo as IdGrupo,
            NombreGrupo as NombreGrupo,
            sum(MontoCreditos) as Creditos,
            sum(MontoDebitos)  as Debitos,
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
            type_transaction_id in (4,8,2)
            and
            transaction_date between '0000-00-00' and '9999-12-31' 
            and
            group_id between $grupoDesde and $grupoHasta
            and status <> 'Anulado'    
        group by 
            IdGrupo,
            NombreGrupo
        union
        SELECT 
            group_id         as IdGrupo,
            mtf.groups.name  as NombreGrupo,
            sum(amount_total)  as MontoCreditos,
            0 as MontoDebitos
        FROM mtf.transactions
        left join  mtf.groups on mtf.transactions.group_id  = mtf.groups.id
        where
            type_transaction_id in(1,3,5,7,9)
            and
            transaction_date between '0000-00-00' and '9999-12-31'   
            and
            group_id between $grupoDesde and $grupoHasta
            and status <> 'Anulado'   
        group by 
            IdGrupo,
            NombreGrupo    
            
        )
        as t
        group by
            IdGrupo,
            NombreGrupo
        ";
            

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
        FROM mtf.transactions
        left join  mtf.suppliers on mtf.transactions.supplier_id  = mtf.supplier.id
        where
            type_transaction_id in (4,8,2)
            and
            transaction_date between '0000-00-00' and '9999-12-31' 
            and
            supplier_id between $supplierDesde and $supplierHasta
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
        FROM mtf.transactions
        left join  mtf.suppliers on mtf.transactions.supplier_id  = mtf.suppliers.id
        where
            type_transaction_id in(1,3,5,7,9)
            and
            transaction_date between '0000-00-00' and '9999-12-31'   
            and
            supplier_id between $supplierDesde and $supplierHasta
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
    
    
}

?>
