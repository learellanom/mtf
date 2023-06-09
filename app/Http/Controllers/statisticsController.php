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

    private $myCredits   = "1,3,5,7,9,11,12";
    private $myDebits    = "2,4,6,8,10,13";


    public function getCredits(){
        return $this->myCredits;
    }

    public function getDebits(){
        return $this->myDebits;
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

        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myHoraDesde = "00:00:00";
        $myHoraHasta = "23:59:00";

        $myFechaDesde = "2001-01-01 00:00:00";
        $myFechaHasta = "9999-12-31 23:59:00";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;

            $myFechaDesde = $myFechaDesde . " 00:00:00";
            $myFechaHasta = $myFechaHasta . " 23:59:00";


        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta = $myFechaHasta . " 23:59:00";           
        }

        $myTypeTransactions         = 0;
        $myTypeTransactionsDesde    = 0;
        $myTypeTransactionsHasta    = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions         = $request->typeTransactions;
            $myTypeTransactionsDesde    = $request->typeTransactions;
            $myTypeTransactionsHasta    = $request->typeTransactions;
        }else{
            $myTypeTransactionsDesde = 0;
            $myTypeTransactionsHasta = 9999;
        }

        // \Log::info('leam usuario *** -> ' . $request->usuario);
        // \Log::info('leam cliente *** -> ' . $request->cliente);
        // \Log::info('leam wallet *** -> ' . $request->wallet);

        $balance = "";
        if ($myGroup > 0){
            $balance = $this->getBalance($myGroup);
            // $balance = $this->getBalance($myGroup, $myFechaDesde, $myFechaHasta);
        };

        if ($myWallet > 0){
            $balance = $this->getBalanceWallet($myWallet);
        };

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
                    Transactions.client_id                 as ClienteId,
                    transactions.wallet_id                 as WalletId,
                    wallets.name                           as WalletName,
                    transactions.description               as Descripcion,
                    transactions.transaction_date          as FechaTransaccion,
                    mtf.groups.name                        as ClientName,
                    transactions.token                     as token
                from
                    mtf.transactions
                left join mtf.type_transactions on mtf.transactions.type_transaction_id = mtf.type_transactions.id
                left join mtf.wallets           on mtf.transactions.wallet_id           = mtf.wallets.id
                left join mtf.users             on mtf.transactions.user_id             = mtf.users.id
                left join mtf.type_coins        on mtf.transactions.type_coin_id        = mtf.type_coins.id
                left join mtf.groups            on mtf.Transactions.group_id            = mtf.groups.id
                where
                        status = 'Activo'
                    and user_id             between $myUserDesde                and $myUserHasta                        
                    and wallet_id           between $myWalletDesde              and $myWalletHasta
                    and type_transaction_id between $myTypeTransactionsDesde    and $myTypeTransactionsHasta
                    and transaction_date    between '$myFechaDesde'             and '$myFechaHasta'
                order by
                    Transactions.transaction_date ASC

            ";
    
            // dd($myQuery);
    
            $Transacciones = DB::select($myQuery);
    

        }

        //  dd($Transacciones);
        // die();

        $userole            = $this->getUser();

        $wallet             = $this->getWallet();

        $group              = $this->getGroups();

        $typeTransactions   = $this->getTypeTransactions();

        return view('estadisticas.index', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance','typeTransactions','myTypeTransactions','myFechaDesde','myFechaHasta'));

    }
    /*
    *
    *
    *       masterDetail
    *
    *
    */
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
            'Transaction_masters.id                         as Id',
            'Transaction_masters.amount_foreign_currency    as MontoMoneda',
            'Transaction_masters.exchange_rate              as TasaCambio',
        //  'Transaction_masters.type_coin_id               as TipoMonedaId',
            'type_coins.name                                as TipoMoneda',
            'users.name                                     as AgenteName',
            'Transaction_masters.amount                     as Monto',
            'Transaction_masters.amount_total               as MontoTotal',
            'Transaction_masters.percentage                 as PorcentajeComision',
            'Transaction_masters.amount_commission          as MontoComision',
            'Transaction_masters.type_transaction_id        as TransactionId',
            'type_transactions.name                         as TipoTransaccion',
        //  'Transaction_masters.client_id                  as ClienteId',
        //  'transaction_masters.wallet_id                  As WalletId',
            'wallets.name                                   As WalletName',
            'transaction_masters.description                as Descripcion',
            'transaction_masters.transaction_date           as FechaTransaccion',
            'groups.name                                    as ClientName',
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
        )->whereBetween('Transaction_masters.user_id',          [$myUserDesde, $myUserHasta]
        )->whereBetween('Transaction_masters.group_id',         [$myGroupDesde, $myGroupHasta]
        )->whereBetween('Transaction_masters.wallet_id',        [$myWalletDesde, $myWalletHasta]
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

        $userole    = $this->getUser();

        $wallet     = $this->getWallet();

        $group      = $this->getGroups();


        return view('estadisticas.statisticsDetailMaster', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance'));

    }
    /*
    *
    *
    *       supplierDetail
    *
    *
    */
    public function supplierDetail(Request $request)
    {

        $mySupplier = 0;
        if ($request->supplier) {
            $mySupplier = $request->supplier;
        }

        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myTypeTransactions = 0;
        $myTypeTransactionsDesde = 0;
        $myTypeTransactionsHasta = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions = $request->typeTransactions;
            $myTypeTransactionsDesde = $request->typeTransactions;
            $myTypeTransactionsHasta = $request->typeTransactions;
        }else{
            $myTypeTransactionsDesde = 0;
            $myTypeTransactionsHasta = 9999;
        }
        // dd('myTypeTransactionsDesde '   .  $myTypeTransactionsDesde . ' myTypeTransactionsHasta ' . $myTypeTransactionsHasta);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            // dd('myFechaDesde -> '   .  $myFechaDesde . ' myFechaHasta -> ' . $myFechaHasta);
            $myFechaHasta = $request->fechaHasta;
        }


        // \Log::info('leam usuario *** -> ' . $request->usuario);
        // \Log::info('leam cliente *** -> ' . $request->cliente);
        // \Log::info('leam wallet  *** -> ' . $request->wallet);

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
            'Transaction_suppliers.id                       as Id',
            'Transaction_suppliers.amount_foreign_currency  as MontoMoneda',
            'Transaction_suppliers.exchange_rate            as TasaCambio',
         // 'Transaction_suppliers.type_coin_id             as TipoMonedaId',
            'type_coins.name                                as TipoMoneda',
            'users.name                                     as AgenteName',
            'Transaction_suppliers.amount                   as Monto',
            'Transaction_suppliers.amount_total             as MontoTotal',
            'Transaction_suppliers.percentage               as PorcentajeComision',
            'Transaction_suppliers.amount_commission        as MontoComision',
            'Transaction_suppliers.type_transaction_id      as TransactionId',
            'type_transactions.name                         as TipoTransaccion',
        //  'transaction_suppliers.wallet_id                as WalletId',
            'wallets.name                                   as WalletName',
            'transaction_suppliers.description              as Descripcion',
            'transaction_suppliers.transaction_date         as FechaTransaccion',
            'suppliers.name                                 as SupplierName',
        )->leftJoin('users',                'users.id',             '=', 'transaction_suppliers.user_id'
        )->leftJoin('type_transactions',    'type_transactions.id', '=', 'transaction_suppliers.type_transaction_id'
        )->leftJoin('suppliers',            'suppliers.id',         '=', 'transaction_suppliers.supplier_id'
        )->leftJoin('type_coins',           'type_coins.id',        '=', 'transaction_suppliers.type_coin_id'
        )->leftJoin('wallets',              'wallets.id',           '=', 'transaction_suppliers.wallet_id'
        )->whereBetween('Transaction_suppliers.user_id',                [$myUserDesde, $myUserHasta]
        )->whereBetween('Transaction_suppliers.supplier_id',            [$mySupplierDesde, $mySupplierHasta]
        )->whereBetween('Transaction_suppliers.transaction_date',       [$myFechaDesde, $myFechaHasta]
        )->whereBetween('Transaction_suppliers.wallet_id',              [$myWalletDesde, $myWalletHasta]
        )->whereBetween('Transaction_suppliers.type_transaction_id',    [$myTypeTransactionsDesde, $myTypeTransactionsHasta]
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

        $supplier = $this->getSuppliers();

        $wallet = $this->getWallet();

        $Type_transactions  = $this->getTypeTransactions();

        return view('estadisticas.statisticsDetailSupplier', compact('Transacciones','supplier','wallet','mySupplier','myWallet','myTypeTransactions','balance','Type_transactions','myFechaDesde','myFechaHasta'));

    }
    /*
    *
    *
    *       supplierDetailConciliation
    *
    *
    */
    public function supplierDetailConciliation(Request $request)
    {

        $mySupplier = 0;
        if ($request->supplier) {
            $mySupplier = $request->supplier;
        }

        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myTypeTransactions = 0;
        $myTypeTransactionsDesde = 0;
        $myTypeTransactionsHasta = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions = $request->typeTransactions;
            $myTypeTransactionsDesde = $request->typeTransactions;
            $myTypeTransactionsHasta = $request->typeTransactions;
        }else{
            $myTypeTransactionsDesde = 0;
            $myTypeTransactionsHasta = 9999;
        }
        // dd('myTypeTransactionsDesde '   .  $myTypeTransactionsDesde . ' myTypeTransactionsHasta ' . $myTypeTransactionsHasta);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            // dd('myFechaDesde -> '   .  $myFechaDesde . ' myFechaHasta -> ' . $myFechaHasta);
            $myFechaHasta = $request->fechaHasta;
        }


        // \Log::info('leam usuario *** -> ' . $request->usuario);
        // \Log::info('leam cliente *** -> ' . $request->cliente);
        // \Log::info('leam wallet  *** -> ' . $request->wallet);

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



        $tabla = "mtf.transaction_suppliers";


    //     'Transaction_suppliers.id                       as Id',
    //     'Transaction_suppliers.amount_foreign_currency  as MontoMoneda',
    //     'Transaction_suppliers.exchange_rate            as TasaCambio',
    //  // 'Transaction_suppliers.type_coin_id             as TipoMonedaId',
    //     'type_coins.name                                as TipoMoneda',
    //     'users.name                                     as AgenteName',
    //     'Transaction_suppliers.amount                   as Monto',
    //     'Transaction_suppliers.amount_total             as MontoTotal',
    //     'Transaction_suppliers.percentage               as PorcentajeComision',
    //     'Transaction_suppliers.amount_commission        as MontoComision',
    //     'Transaction_suppliers.type_transaction_id      as TransactionId',
    //     'type_transactions.name                         as TipoTransaccion',
    // //  'transaction_suppliers.wallet_id                as WalletId',
    //     'wallets.name                                   as WalletName',
    //     'transaction_suppliers.description              as Descripcion',
    //     'transaction_suppliers.transaction_date         as FechaTransaccion',
    //     'suppliers.name                                 as SupplierName',


        $myQuery =
        "
            select
                mtf.transaction_suppliers.id 						as Id,
                mtf.transaction_suppliers.amount_foreign_currency   as MontoMoneda,
                mtf.transaction_suppliers.exchange_rate             as TasaCambio,
                mtf.transaction_suppliers.type_coin_id              as TipoMonedaId,
                type_coins.name                        				as TipoMoneda,
                mtf.transaction_suppliers.status               		as Status,
                mtf.transaction_suppliers.description               as Descripcion,
                mtf.transaction_suppliers.transaction_date          as FechaTransaccion,
                mtf.transaction_suppliers.user_id                 	as AgenteId,
                mtf.users.name                             			as AgenteName,
                mtf.transaction_suppliers.type_transaction_id 		as TransactionId,
                mtf.type_transactions.name 							as TipoTransaccion,
                mtf.transaction_suppliers.supplier_id				as SupplierId,
                mtf.suppliers.name          						as SupplierName,
                mtf.transaction_suppliers.wallet_id					as WalletId,
                mtf.wallets.name									as WalletName,
                mtf.transaction_suppliers.percentage				as PorcentajeComision,
                mtf.transaction_suppliers.amount					as Monto,
                mtf.transaction_suppliers.amount_total				as MontoTotal,
                mtf.transaction_suppliers.amount_commission			as MontoComision,
                (	select count(*)
                    from mtf.transactions
                    where 	mtf.transactions.wallet_id 			= WalletId
                    and 	mtf.transactions.type_transaction_id 	= mtf.transaction_suppliers.type_transaction_id
                    and 	status 									<> 'Anulado'
                    and 	mtf.transactions.amount 				= mtf.transaction_suppliers.amount
                ) as CantDiferencia
            from
                mtf.transaction_suppliers
            left join mtf.suppliers         on mtf.transaction_suppliers.supplier_id         = mtf.suppliers.id
            left join mtf.type_transactions on mtf.transaction_suppliers.type_transaction_id = mtf.type_transactions.id
            left join mtf.wallets           on mtf.transaction_suppliers.wallet_id           = mtf.wallets.id
            left join mtf.users             on mtf.transaction_suppliers.user_id             = mtf.users.id
            left join mtf.type_coins        on mtf.transaction_suppliers.type_coin_id        = mtf.type_coins.id
            where
                    status <> 'Anulado'
                and Supplier_id between $mySupplierDesde            and $mySupplierDesde
                and wallet_id between $myWalletDesde              and $myWalletHasta
                and type_transaction_id between $myTypeTransactionsDesde    and $myTypeTransactionsHasta
            having
                CantDiferencia = 0
            order by
                SupplierId,
                WalletId,
                TransactionId
        ";

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);

        // dd($Transacciones);

        $supplier = $this->getSuppliers();

        $wallet = $this->getWallet();

        $Type_transactions  = $this->getTypeTransactions();

        return view('estadisticas.statisticsDetailSupplier', compact('Transacciones','supplier','wallet','mySupplier','myWallet','myTypeTransactions','balance','Type_transactions','myFechaDesde','myFechaHasta'));

    }

    /*
    *
    *
    *       supplierDetailConciliationTran
    *       
    *
    */
    public function supplierDetailConciliationTran(Request $request)
    {

        $mySupplier = 0;
        if ($request->supplier) {
            $mySupplier = $request->supplier;
        }

        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }

        $myTypeTransactions = 0;
        $myTypeTransactionsDesde = 0;
        $myTypeTransactionsHasta = 9999;
        if ($request->typeTransactions) {
            $myTypeTransactions = $request->typeTransactions;
            $myTypeTransactionsDesde = $request->typeTransactions;
            $myTypeTransactionsHasta = $request->typeTransactions;
        }else{
            $myTypeTransactionsDesde = 0;
            $myTypeTransactionsHasta = 9999;
        }
        // dd('myTypeTransactionsDesde '   .  $myTypeTransactionsDesde . ' myTypeTransactionsHasta ' . $myTypeTransactionsHasta);

        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";
        if ($request->fechaDesde){
            $myFechaDesde = $request->fechaDesde;
            $myFechaHasta = $request->fechaHasta;
        }

        if ($request->fechaHasta){
            // dd('myFechaDesde -> '   .  $myFechaDesde . ' myFechaHasta -> ' . $myFechaHasta);
            $myFechaHasta = $request->fechaHasta;
        }


        // \Log::info('leam usuario *** -> ' . $request->usuario);
        // \Log::info('leam cliente *** -> ' . $request->cliente);
        // \Log::info('leam wallet  *** -> ' . $request->wallet);

        $balance = "";
        if ($mySupplier > 0){
            $balance = $this->getBalanceSupplier($mySupplier);
        };

        // dd($balance);
        $myUser         = 0;
        $myUserDesde    = 0;
        $myUserHasta    = 9999;

        $mySupplierDesde = 0;
        $mySupplierHasta = 9999;

        $myWalletDesde = 0;
        $myWalletHasta = 9999;

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



        $tabla = "mtf.transaction_suppliers";


    //     'Transaction_suppliers.id                       as Id',
    //     'Transaction_suppliers.amount_foreign_currency  as MontoMoneda',
    //     'Transaction_suppliers.exchange_rate            as TasaCambio',
    //  // 'Transaction_suppliers.type_coin_id             as TipoMonedaId',
    //     'type_coins.name                                as TipoMoneda',
    //     'users.name                                     as AgenteName',
    //     'Transaction_suppliers.amount                   as Monto',
    //     'Transaction_suppliers.amount_total             as MontoTotal',
    //     'Transaction_suppliers.percentage               as PorcentajeComision',
    //     'Transaction_suppliers.amount_commission        as MontoComision',
    //     'Transaction_suppliers.type_transaction_id      as TransactionId',
    //     'type_transactions.name                         as TipoTransaccion',
    // //  'transaction_suppliers.wallet_id                as WalletId',
    //     'wallets.name                                   as WalletName',
    //     'transaction_suppliers.description              as Descripcion',
    //     'transaction_suppliers.transaction_date         as FechaTransaccion',
    //     'suppliers.name                                 as SupplierName',


        $myQuery =
        "
            select
                mtf.transactions.id 						as Id,
                mtf.transactions.amount_foreign_currency   	as MontoMoneda,
                mtf.transactions.exchange_rate             	as TasaCambio,
                mtf.transactions.type_coin_id              	as TipoMonedaId,
                type_coins.name                        		as TipoMoneda,
                mtf.transactions.status               		as Status,
                mtf.transactions.description               	as Descripcion,
                mtf.transactions.transaction_date          	as FechaTransaccion,
                mtf.transactions.user_id                 	as AgenteId,
                mtf.users.name                             	as AgenteName,
                mtf.transactions.type_transaction_id 		as TransactionId,
                mtf.type_transactions.name 					as TipoTransaccion,
                '0'											as SupplierId,
                ' '          								as SupplierName,
                mtf.transactions.wallet_id					as WalletId,
                mtf.wallets.name							as WalletName,
                mtf.transactions.percentage					as PorcentajeComision,
                mtf.transactions.amount						as Monto,
                mtf.transactions.amount_total				as MontoTotal,
                mtf.transactions.amount_commission			as MontoComision,
                mtf.groups.name                             as ClientName,
                mtf.transactions.token                                   as token,
                (	select count(*)
                    from mtf.transaction_suppliers
                    where 	mtf.transaction_suppliers.wallet_id 			= WalletId
                    and 	mtf.transaction_suppliers.type_transaction_id 	= mtf.transactions.type_transaction_id
                    and 	status 											<> 'Anulado'
                    and 	mtf.transaction_suppliers.amount 				= mtf.transactions.amount
                ) as CantDiferencia
        from
            mtf.transactions
        left join mtf.type_transactions on mtf.transactions.type_transaction_id = mtf.type_transactions.id
        left join mtf.wallets           on mtf.transactions.wallet_id           = mtf.wallets.id
        left join mtf.users             on mtf.transactions.user_id             = mtf.users.id
        left join mtf.type_coins        on mtf.transactions.type_coin_id        = mtf.type_coins.id
        left join mtf.groups            on mtf.transactions.group_id            = mtf.groups.id
        where
                status <> 'Anulado'
            and wallet_id 				between $myWalletDesde and $myWalletHasta
            and type_transaction_id 	between $myTypeTransactionsDesde and $myTypeTransactionsHasta
        having
            CantDiferencia = 0
        order by
            SupplierId,
            WalletId,
            TransactionId
        ";

        // dd($myQuery);

        $Transacciones = DB::select($myQuery);

        // dd($Transacciones);

        $supplier = $this->getSuppliers();

        $wallet = $this->getWallet();

        $Type_transactions  = $this->getTypeTransactions();

        $userole            = $this->getUser();

        $group              = $this->getGroups();

        $typeTransactions   = $this->getTypeTransactions();

        $myGroup            = 0;


        //                 return view('estadisticas.index', compact('myUser','userole','Transacciones','group','wallet','myGroup','myUser','myWallet','balance','typeTransactions','myTypeTransactions'));
        return view('estadisticas.index', compact('myUser','userole','myGroup','group','Transacciones','wallet','myWallet','mySupplier','supplier','myTypeTransactions','typeTransactions','balance','myFechaDesde','myFechaHasta'));

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
    *   walletSummary
    *
    *
    */
    public function walletSummary(Request $request) {

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

        $Type_transactions  = $this->getTypeTransactions();
        $wallets            = $this->getWallet();

        return view('estadisticas.statisticsResumenWallet', compact('myWallet', 'wallets', 'Transacciones'));
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
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";            
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

       $balance = 0;
       if ($myWallet > 0){
              $balance2 = $this->getBalanceWallet($myWallet);
              $balance  = $balance2->Total;
           // $balance = $this->getBalancemyWallet($myWallet, $myFechaDesde, $myFechaHasta);
       };
       // dd($balance);

        $Type_transactions  = $this->getTypeTransactions();
        $wallet             = $this->getWallet();

        $Transacciones = DB::table('transactions')
            ->select(DB::raw('
                wallet_id                   as WalletId,
                wallets.name                as WalletName,
                type_transaction_id         as TypeTransactionId,
                type_transactions.name      as TypeTransaccionName,
                count(*)                    as cant_transactions,
                sum(amount)                 as total_amount,                
                sum(amount_commission_base) as total_amount_commission_base,
                sum(amount_commission)      as total_commission,
                (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit,
                sum(amount_total)           as total'))
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id')
            ->leftJoin('wallets',           'wallets.id', '=', 'transactions.wallet_id')
            ->where('status','<>','Anulado')
            ->whereBetween('Transactions.wallet_id',            [$myWalletDesde, $myWalletHasta])
            ->whereBetween('Transactions.type_transaction_id',  [$myTypeTransactionDesde, $myTypeTransactionHasta])
            ->whereBetween('Transactions.transaction_date',     [$myFechaDesde2, $myFechaHasta2])
            ->groupBy('WalletId', 'WalletName', 'TypeTransactionId', 'TypeTransaccionName')
            ->orderBy('WalletId','ASC')
            ->orderBy('TypeTransactionId','ASC')
            ->get();


        // dd($Transacciones);

        return view('estadisticas.statisticsResumenWalletTransaccion', compact('myWallet','wallet','myTypeTransaction', 'Type_transactions', 'Transacciones','myFechaDesde','myFechaHasta','balance'));

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
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";
        }

        if ($request->fechaHasta){
            $myFechaHasta = $request->fechaHasta;
            $myFechaHasta2 = $myFechaHasta . " 12:59:00";            
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
                sum(amount_commission_base) as total_amount_commission_base,
                sum(amount_commission)      as total_commission,
                (sum(amount_commission)-sum(amount_commission_base)) as total_commission_profit,
                sum(amount_total)           as total'
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
   /*
    *
    *
    *       transactionSummary
    *
    *
    */
    public function transactionSummarySupplier(Request $request)
    {
        $mySupplier = ($request->proveedor) ? $request->proveedor : 0;
        // $mySupplier = 0;
        if ($mySupplier === 0){
            $supplierDesde = 0;
            $supplierHasta = 9999;
        }else{
            $supplierDesde = $supplierHasta = $mySupplier;
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

        $Type_transactions  = $this->getTypeTransactions();

        $supplier           = $this->getSuppliers();

        $Transacciones = DB::table('transaction_suppliers')
            ->select(DB::raw('
                supplier_id                 as IdSupplier,
                type_transactions.name      as TipoTransaccion,
                count(*)                    as cant_transactions,
                sum(amount)                 as total_amount,
                sum(amount_commission)      as total_commission,
                sum(amount_total)           as total'))
            ->leftJoin('type_transactions', 'type_transactions.id', '=', 'transaction_suppliers.type_transaction_id')
            ->whereBetween('Transaction_suppliers.supplier_id',         [$supplierDesde, $supplierHasta])
            ->whereBetween('Transaction_suppliers.type_transaction_id', [$myTypeTransactionDesde, $myTypeTransactionHasta])
            ->whereBetween('Transaction_suppliers.transaction_date',    [$myFechaDesde, $myFechaHasta])
            ->groupBy('IdSupplier','TipoTransaccion')
            ->get();

        // dd($Transacciones);

        return view('estadisticas.statisticsResumenSupplierTransaccion', compact('mySupplier','supplier', 'Type_transactions', 'Transacciones'));

    }
    /*
    *
    *
    *       groupSummary
    *
    *
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
    *
    *
    *       supplierSummary
    *
    *
    */
    public function supplierSummary(Request $request)
    {

        $mySupplier = 0;
        if ($request->proveedor) {
            $mySupplier = $request->proveedor;
        }
        $Transacciones      = $this->getBalanceSupplier($mySupplier);

        //
        // si es un solo grupo devuelve un objeto y debe convertirse a array de 1
        //
        if (gettype($Transacciones) == "object"){
            $Transacciones = [$Transacciones];
        }

        $Type_transactions  = $this->getTypeTransactions();
        $suppliers             = $this->getSuppliers();

        return view('estadisticas.statisticsResumenSupplier', compact('mySupplier','suppliers','Type_transactions','Transacciones'));

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
    *       conciliationSummarySupplier
    *
    */
    public function conciliationSummarySupplier(Request $request)
    {

        $mySupplier = ($request->proveedor) ? $request->proveedor : 0;

        $mySupplierDesde = 0;
        $mySupplierHasta = 9999;
        if ($mySupplier != 0){
            $mySupplierDesde = $mySupplier;
            $mySupplierHasta = $mySupplier;
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
            supplier_id					as SupplierId,
            mtf.suppliers.name          as SupplierName,
            wallet_id					as WalletId,
            mtf.wallets.name			as WalletName,
            type_transaction_id 		as TypeTransactionId,
            mtf.type_transactions.name 	as TypeTransactionsName,
            count(supplier_id)			as CantSupplier,
            sum(amount) 			as TotalSupplier,
            (select COUNT(*) 			from mtf.transactions where mtf.transactions.wallet_id = WalletId and type_transaction_id = TypeTransactionId and status <> 'Anulado') as CantWallet,
            (select sum(amount)   from mtf.transactions where mtf.transactions.wallet_id = WalletId and type_transaction_id = TypeTransactionId and status <> 'Anulado') as MontoWallet
        from
            mtf.transaction_suppliers
        left join mtf.suppliers         on mtf.transaction_suppliers.supplier_id         = mtf.suppliers.id
        left join mtf.type_transactions on mtf.transaction_suppliers.type_transaction_id = mtf.type_transactions.id
        left join mtf.wallets           on mtf.transaction_suppliers.wallet_id           = mtf.wallets.id
        where
                status <> 'Anulado'
            and type_transaction_id in ($this->myCredits)
            and Supplier_id between $mySupplierDesde and $mySupplierHasta
        group by
                supplier_id,
                SupplierName,
                wallet_id,
                WalletName,
                TypeTransactionId,
                TypeTransactionsName
        order by
            SupplierId,
            WalletId,
            TypeTransactionId
        ");

        $suppliers          = $this->getSuppliers();

        $Type_transactions  = $this->getTypeTransactions();

        // dd($Transacciones); leamx

        return view('estadisticas.statisticsResumenConciliacionSupplier', compact('mySupplier','suppliers', 'Transacciones'));

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
        $wallet = Wallet::select('wallets.id', 'wallets.name')
        ->get();

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
        \Log::info('leam getBalance grupo        *** -> ' . $grupo);
        \Log::info('leam getBalance grupoDesde   *** -> ' . $grupoDesde);
        \Log::info('leam getBalance grupoHasta   *** -> ' . $grupoHasta);
        \Log::info('leam getBalance myFechaDesde *** -> ' . $myFechaDesde);
        \Log::info('leam getBalance myFechaHasta *** -> ' . $myFechaHasta);

        // $myFechaDesde = "2001-01-01";
        // $myFechaHasta = "9999-12-31";
        //
        // 04-05-2023
        //
        // Debitos
        //  4 cobro en efectivo
        //  8 Nota de debito
        //  2 cobro transferencia
        //  10  cobro en mercancia
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
            transaction_date between '$myFechaDesde' and '$myFechaHasta'
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
            type_transaction_id in($this->myCredits)
            and
            transaction_date between '$myFechaDesde' and '$myFechaHasta'
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
        \Log::info('leam wallet      *** -> ' . $wallet);        
        \Log::info('leam fecha Desde *** -> ' . $fechaDesde); 
        \Log::info('leam fecha Hasta *** -> ' . $fechaHasta); 
        
        $horaDesde = " 00:00:00";
        $horaHasta = " 12:59:00";

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
                mtf.wallets.name            as NombreWallet,
                0 				            as MontoCreditos,
                sum(amount_total_base)      as MontoDebitos,
                sum(amount_commission)      as MontoComision,
                sum(amount_commission_base) as MontoComisionBase
            FROM $myTable
            left join  mtf.wallets on mtf.transactions.wallet_id  = mtf.wallets.id
            where
                type_transaction_id in ($this->myDebits)
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
                mtf.wallets.name            as NombreWallet,
                sum(amount_total_base)      as MontoCreditos,
                0                           as MontoDebitos,
                sum(amount_commission)      as MontoComision,
                sum(amount_commission_base) as MontoComisionBase                
            FROM $myTable
            left join  mtf.wallets on mtf.transactions.wallet_id  = mtf.wallets.id
            where
                type_transaction_id in ($this->myCredits)
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
        ";

        // dd($myQuery);
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


}

?>
