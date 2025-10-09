<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Group;
use App\Models\Image;
use App\Models\User;
use App\Models\Type_material;
use Carbon\Carbon;

use \stdClass;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request, transaction $transaction)
    {
        /*
        if (!$request->query('user')){
            \Log::info('leam - transaction controller - no user');
        }
        if ($request->query('user')){
            \Log::info('leam - con user');
        }
        */
        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde');
        $fechaHasta     = $request->query('fechaHasta');
        
        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($user){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        $myFechaDesde = $this->get07DayBefore($myFechaHasta);
        
         if($fechaDesde){
            $myFechaDesde = $request->fechaDesde;
         };
         if($fechaHasta){
            $myFechaHasta = $request->fechaHasta;
         };
         //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
         // dd($request);
        $myLimit = 0;
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }

        $transferencia = Transaction::whereNull(['transfer_number','pay_number'])
        ->whereBetween('created_at',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',       [$myUsuarioDesde , $myUsuarioHasta])
        ->orderBy('created_at','desc')
        ->limit($myLimit)            
        ->get();

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user                           = User::pluck('name', 'id')->toArray();

        $parametros['fechaDesde']       = $myFechaDesde2;
        $parametros['fechaHasta']       = $myFechaHasta2;
        $parametros['transferencia']    = $transferencia;
        $parametros['myUser']           = $myUser;
        $parametros['user']             = $user;

        // dd($transferencia);

        return view('transactions.index', $parametros);

    }


    /**
     * Display a listing of the resource.
     */
    public function materials_adquisicion_index(Request $request, transaction $transaction)
    {

        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde') ? $request->query('fechaDesde') : "2000-01-01";
        $fechaHasta     = $request->query('fechaHasta') ? $request->query('fechaHasta') : "9999-12-31";
            
        $myFechaDesde   = "2000-01-01";
        $myFechaHasta   = "9999-12-31";

        if($request->query('fechaDesde')){
            $myFechaDesde = $request->fechaDesde;
         };
         if($request->query('fechaHasta')){
            $myFechaHasta = $request->fechaHasta;
         };

        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($request->query('user')){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        // $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        // $myFechaDesde = $this->get07DayBefore($myFechaHasta);

        //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
        // dd($request);
        $myLimit = 0;
        /*
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }
        */
        $myCoinDesde    = 0;
        $myCoinHasta    = 9999;
        $myCoin = $request->coin ? $request->coin : 0;
        if ($request->coin){
            $myCoinDesde    = $request->coin;
            $myCoinHasta    = $request->coin;
        }


        $myGroup        = $request->group ? $request->group : 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        if ($request->group){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }
        // dd($myGroup);
        $myWallet        = $request->wallet ? $request->wallet : 0;
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
        }
        
        $myTypeMaterial  = $request->type_material ? $request->type_material : 0;
        $myTypeMaterialDesde   = 0;
        $myTypeMaterialHasta   = 9999;
        if ($request->type_material){
            $myTypeMaterialDesde   = $request->type_material;
            $myTypeMaterialHasta   = $request->type_material;
        }

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

	    $wallet             = $wallet->toArray();
	    $group              = $group->toArray();

        $myTypeTransaction = 47; // Adquisiciones de materiales


        /*
        echo "<br>" . "myTypeTransaction " . $myTypeTransaction;
        echo "<br>" . "fechaDesde        " . $fechaDesde;
        echo "<br>" . "fechaHasta        " . $fechaHasta;
        echo "<br>" . "myFechaDesde      " . $myFechaDesde;
        echo "<br>" . "myFechaHasta      " . $myFechaHasta;
        echo "<br>" . "myWalletDesde     " . $myWalletDesde;
        echo "<br>" . "myWalletHasta     " . $myWalletHasta;
        echo "<br>" . "myGroupDesde      " . $myGroupDesde;
        echo "<br>" . "myGroupHasta      " . $myGroupHasta;
        echo "<br>" . "myTypeMaterialDesde      " . $myTypeMaterialDesde;
        echo "<br>" . "myTypeMaterialHasta      " . $myTypeMaterialHasta;        
        echo "<br>" . "myUsuarioDesde    " . $myUsuarioDesde;
        echo "<br>" . "myUsuarioHasta    " . $myUsuarioHasta;
         die();
        */
        $movimientos = Transaction::where('type_transaction_id', '=', $myTypeTransaction)
        ->whereIn('status',['Activo','Anulado'])
        ->whereBetween('wallet_id',         [$myWalletDesde, $myWalletHasta])
        ->whereBetween('group_id',          [$myGroupDesde,  $myGroupHasta])
        ->whereBetween('type_material_id',  [$myTypeMaterialDesde,  $myTypeMaterialHasta])
        ->whereBetween('created_at',        [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',           [$myUsuarioDesde , $myUsuarioHasta])   
        ->orderBy('created_at','desc')       
        ->get();

        // dd($movimientos);

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();


        // $myTypeMaterial     = $request->material ? $request->material : 0;
        $Type_material      = Type_material::pluck('name', 'id')->toArray();
        


        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        
        $parametros['myWallet']               = $myWallet;
        $parametros['myGroup']                = $myGroup;

        $parametros['fechaDesde']           = $myFechaDesde2;
        $parametros['fechaHasta']           = $myFechaHasta2;
        $parametros['movimientos']          = $movimientos;
        $parametros['myUser']               = $myUser;
        $parametros['user']                 = $user;
        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;
        $parametros['myTypeMaterial']       = $myTypeMaterial;
        $parametros['Type_material']        = $Type_material;

        // dd($transferencia);

        return view('materials.adquisicion_index', $parametros);

    }

    
    
    /**
     * Display a listing of the resource.
     */
    public function liquidacion_adquisicion_index(Request $request, transaction $transaction)
    {

        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde') ? $request->query('fechaDesde') : "2000-01-01";
        $fechaHasta     = $request->query('fechaHasta') ? $request->query('fechaHasta') : "9999-12-31";
            
        $myFechaDesde   = "2000-01-01";
        $myFechaHasta   = "9999-12-31";

        if($request->query('fechaDesde')){
            $myFechaDesde = $request->fechaDesde;
         };
         if($request->query('fechaHasta')){
            $myFechaHasta = $request->fechaHasta;
         };

        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($request->query('user')){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        // $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        // $myFechaDesde = $this->get07DayBefore($myFechaHasta);

        //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
        // dd($request);
        $myLimit = 0;
        /*
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }
        */
        $myCoinDesde    = 0;
        $myCoinHasta    = 9999;
        $myCoin = $request->coin ? $request->coin : 0;
        if ($request->coin){
            $myCoinDesde    = $request->coin;
            $myCoinHasta    = $request->coin;
        }


        $myGroup        = $request->group ? $request->group : 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        if ($request->group){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }
        // dd($myGroup);
        $myWallet        = $request->wallet ? $request->wallet : 0;
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
        }
        
        $myTypeMaterial  = $request->type_material ? $request->type_material : 0;
        $myTypeMaterialDesde   = 0;
        $myTypeMaterialHasta   = 9999;
        if ($request->type_material){
            $myTypeMaterialDesde   = $request->type_material;
            $myTypeMaterialHasta   = $request->type_material;
        }

        $myLiquidationNumber = ($request->liquidation_number) ? $request->liquidation_number : 0;

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

	    $wallet             = $wallet->toArray();
	    $group              = $group->toArray();

        $myTypeTransaction = 47; // Adquisiciones de materiales


        /*
        echo "<br>" . "myTypeTransaction    " . $myTypeTransaction;
        echo "<br>" . "fechaDesde           " . $fechaDesde;
        echo "<br>" . "fechaHasta           " . $fechaHasta;
        echo "<br>" . "myFechaDesde         " . $myFechaDesde;
        echo "<br>" . "myFechaHasta         " . $myFechaHasta;
        echo "<br>" . "myWalletDesde        " . $myWalletDesde;
        echo "<br>" . "myWalletHasta        " . $myWalletHasta;
        echo "<br>" . "myGroupDesde         " . $myGroupDesde;
        echo "<br>" . "myGroupHasta         " . $myGroupHasta;
        echo "<br>" . "myTypeMaterialDesde  " . $myTypeMaterialDesde;
        echo "<br>" . "myTypeMaterialHasta  " . $myTypeMaterialHasta;        
        echo "<br>" . "myUsuarioDesde       " . $myUsuarioDesde;
        echo "<br>" . "myUsuarioHasta       " . $myUsuarioHasta;
        die();
        */

        $liquidation        = Transaction::where('liquidation_number', $myLiquidationNumber)->first();
        $myLiquidationDate  = $liquidation->liquidation_date;

        $movimientos = Transaction::where('type_transaction_id', '=', $myTypeTransaction)
        ->where('status','Liquidado')
        ->where('liquidation_number', $myLiquidationNumber)
        ->whereBetween('wallet_id',         [$myWalletDesde, $myWalletHasta])
        ->whereBetween('group_id',          [$myGroupDesde,  $myGroupHasta])
        ->whereBetween('type_material_id',  [$myTypeMaterialDesde,  $myTypeMaterialHasta])
        ->whereBetween('created_at',        [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',           [$myUsuarioDesde , $myUsuarioHasta])   
        ->orderBy('created_at','desc')       
        ->get();

        //dd($movimientos);

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();


        // $myTypeMaterial     = $request->material ? $request->material : 0;
        $Type_material      = Type_material::pluck('name', 'id')->toArray();
        

        
        $parametros['myLiquidationNumber']  = $myLiquidationNumber;
        $parametros['myLiquidationDate']    = $myLiquidationDate;

        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        
        $parametros['myWallet']               = $myWallet;
        $parametros['myGroup']                = $myGroup;

        $parametros['fechaDesde']           = $myFechaDesde2;
        $parametros['fechaHasta']           = $myFechaHasta2;
        $parametros['movimientos']          = $movimientos;
        $parametros['myUser']               = $myUser;
        $parametros['user']                 = $user;
        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;
        $parametros['myTypeMaterial']       = $myTypeMaterial;
        $parametros['Type_material']        = $Type_material;

        // dd($transferencia);

        return view('materials.liquidacion_adquisicion_index', $parametros);

    }


    
    /*
    *
     * Display a listing of the resource.
     * *
     */
    public function liquidacion_index(Request $request, transaction $transaction)
    {

        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde') ? $request->query('fechaDesde') : "2000-01-01";
        $fechaHasta     = $request->query('fechaHasta') ? $request->query('fechaHasta') : "9999-12-31";
            
        $myFechaDesde   = "2000-01-01";
        $myFechaHasta   = "9999-12-31";

        if($request->query('fechaDesde')){
            $myFechaDesde = $request->fechaDesde;
         };
         if($request->query('fechaHasta')){
            $myFechaHasta = $request->fechaHasta;
         };
         
        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($request->query('user')){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        // $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        // $myFechaDesde = $this->get07DayBefore($myFechaHasta);

        //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
        // dd($request);
        $myLimit = 0;
        /*
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }
        */
        $myCoinDesde    = 0;
        $myCoinHasta    = 9999;
        $myCoin = $request->coin ? $request->coin : 0;
        if ($request->coin){
            $myCoinDesde    = $request->coin;
            $myCoinHasta    = $request->coin;
        }


        $myGroup        = $request->group ? $request->group : 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        if ($request->group){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }
        // dd($myGroup);
        $myWallet        = $request->wallet ? $request->wallet : 0;
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        if ($request->wallet){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
        }
        
        $myTypeMaterial  = $request->type_material ? $request->type_material : 0;
        $myTypeMaterialDesde   = 0;
        $myTypeMaterialHasta   = 9999;
        if ($request->type_material){
            $myTypeMaterialDesde   = $request->type_material;
            $myTypeMaterialHasta   = $request->type_material;
        }

        $myLiquidationNumber = ($request->liquidation_number) ? $request->liquidation_number : 0;

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

	    $wallet             = $wallet->toArray();
	    $group              = $group->toArray();


        $myTypeTransaction = 47; // Adquisiciones de materiales


        /*
        echo "<br>" . "myTypeTransaction    " . $myTypeTransaction;
        echo "<br>" . "fechaDesde           " . $fechaDesde;
        echo "<br>" . "fechaHasta           " . $fechaHasta;
        echo "<br>" . "myFechaDesde         " . $myFechaDesde;
        echo "<br>" . "myFechaHasta         " . $myFechaHasta;
        echo "<br>" . "myWalletDesde        " . $myWalletDesde;
        echo "<br>" . "myWalletHasta        " . $myWalletHasta;
        echo "<br>" . "myGroupDesde         " . $myGroupDesde;
        echo "<br>" . "myGroupHasta         " . $myGroupHasta;
        echo "<br>" . "myTypeMaterialDesde  " . $myTypeMaterialDesde;
        echo "<br>" . "myTypeMaterialHasta  " . $myTypeMaterialHasta;        
        echo "<br>" . "myUsuarioDesde       " . $myUsuarioDesde;
        echo "<br>" . "myUsuarioHasta       " . $myUsuarioHasta;
        die();
        */

        $liquidation        = Transaction::where('liquidation_number', $myLiquidationNumber)->first();
        $myLiquidationDate  = $liquidation->liquidation_date;

        $movimientos = Transaction::where('type_transaction_id', '=', $myTypeTransaction)
        ->where('status','Liquidado')
        ->where('liquidation_number', $myLiquidationNumber)
        ->whereBetween('wallet_id',         [$myWalletDesde, $myWalletHasta])
        ->whereBetween('group_id',          [$myGroupDesde,  $myGroupHasta])
        ->whereBetween('type_material_id',  [$myTypeMaterialDesde,  $myTypeMaterialHasta])
        ->whereBetween('created_at',        [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',           [$myUsuarioDesde , $myUsuarioHasta])   
        ->orderBy('created_at','desc')       
        ->get();



        $myQuery = "
        select
            mtf.transactions.id             as Id,
            wallet_id                       as WalletId,
            wallets.name                    as WalletName,
            group_id                        as GroupId,
            mtf.groups.name                 as GroupName,
            transaction_date                as TransactionDate,
            mtf.transactions.created_at     as CreatedAt,
            type_material_id                as TypeMaterialId,
            mtf.type_materials.name         as TypeMaterialName,
            material_amount_kilos           as MaterialAmountKilos,
            material_amount_gramos          as MaterialAmountGramos,
            material_amount_total_kilos     as MaterialAmountTotalKilos,
            material_amount_total_gramos    as MaterialAmountTotalGramos,
            material_price_kilos            as MaterialPriceKilos,
            material_price_gramos           as MaterialPriceGramos,            
            material_type_adquisicion       as MaterialTypeAdquisicion,
            case
                when material_type_adquisicion = 1  then 'Kilos'
                when material_type_adquisicion = 2  then 'Gramos'
                when material_type_adquisicion = 3  then 'Cantidad'
                else                                ' '
            end
                                            as MaterialTypeAdquisicionName,
            users.name                      as Agente,
            status                          as Status,
            type_transaction_id             as TypeTransactionId,
            transactions.description        as Description,
            type_transactions.name          as TypeTransactionName,
            liquidation_date                as LiquidationDate,
            liquidation_number              as LiquidationNumber
        from mtf.transactions
        left join   mtf.groups as wallets   on mtf.transactions.wallet_id               = wallets.id
        left join   mtf.groups              on mtf.transactions.wallet_id               = groups.id
        left join   mtf.type_transactions   on mtf.transactions.type_transaction_id     = mtf.type_transactions.id
        left join   mtf.users               on mtf.transactions.user_id                 = mtf.users.id
        left join   mtf.type_materials      on mtf.transactions.type_material_id        = mtf.type_materials.id
        where 
                status                          = 'Liquidado'
            and liquidation_number              = $myLiquidationNumber
            and wallet_id                       between $myWalletDesde              and $myWalletHasta
            and group_id                        between $myGroupDesde               and $myGroupHasta
            and type_material_id                between $myTypeMaterialDesde        and $myTypeMaterialHasta
            and mtf.transactions.created_at     between '$myFechaDesde 00:00:00'    and '$myFechaHasta 23:59:00'
            and user_id                         between $myUsuarioDesde             and $myUsuarioHasta
            and type_transaction_id             in(47,48)
        order by 
            transaction_date,
            type_transaction_id
        ";

     //dd($myQuery);
     $movimientos = DB::select($myQuery);
    // dd($movimientos);
    

        //dd($movimientos);

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();


        // $myTypeMaterial     = $request->material ? $request->material : 0;
        $Type_material      = Type_material::pluck('name', 'id')->toArray();
        

        
        $parametros['myLiquidationNumber']  = $myLiquidationNumber;
        $parametros['myLiquidationDate']    = $myLiquidationDate;

        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        
        $parametros['myWallet']               = $myWallet;
        $parametros['myGroup']                = $myGroup;

        $parametros['fechaDesde']           = $myFechaDesde2;
        $parametros['fechaHasta']           = $myFechaHasta2;
        $parametros['movimientos']          = $movimientos;
        $parametros['myUser']               = $myUser;
        $parametros['user']                 = $user;
        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;
        $parametros['myTypeMaterial']       = $myTypeMaterial;
        $parametros['Type_material']        = $Type_material;

        // dd($transferencia);

        return view('materials.liquidacion_index', $parametros);

    }

   
    /*
    *
    * Display a listing of the resource.
    *
    */
    public function materials_recepcion_index(Request $request, transaction $transaction)
    {
        /*
        if (!$request->query('user')){
            \Log::info('leam - transaction controller - no user');
        }
        if ($request->query('user')){
            \Log::info('leam - con user');
        }
        */
        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde');
        $fechaHasta     = $request->query('fechaHasta');
        
        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($user){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        //$myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        //$myFechaDesde = $this->get07DayBefore($myFechaHasta);
        
        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        if($fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        };
        
        if($fechaHasta){
            $myFechaHasta = $request->fechaHasta;
         };

        //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
        // dd($request);
        $myLimit = "";
        /*
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }
        */
        $myWalletDesde    = 0;
        $myWalletHasta    = 9999;
        $myWallet = $request->wallet ? $request->wallet : 0;
        if ($request->wallet){
            $myWalletDesde    = $request->wallet;
            $myWalletHasta    = $request->wallet;
        }

        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        $myGroup        = $request->group ? $request->group : 0;
        if ($request->group){
            $myGroupDesde    = $request->group;
            $myGroupHasta    = $request->group;
        }


        $myTypeMaterial  = $request->type_material ? $request->type_material : 0;
        $myTypeMaterialDesde   = 0;
        $myTypeMaterialHasta   = 9999;
        if ($request->type_material){
            $myTypeMaterialDesde   = $request->type_material;
            $myTypeMaterialHasta   = $request->type_material;
        }

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

	    $wallet             = $wallet->toArray();
	    $group              = $group->toArray();


        $myTypeTransaction = 48; // Recepcion de materiales

        /*
        echo "<br>" . "recepcion myTypeTransaction ->". $myTypeTransaction;

        echo "<br>" . "recepcion myWalletDesde ->". $myWalletDesde;
        echo "<br>" . "recepcion myWalletHasta ->". $myWalletHasta;

        echo "<br>" . "recepcion myGroupDesde ->". $myGroupDesde;
        echo "<br>" . "recepcion myGroupHasta ->". $myGroupHasta;

        echo "<br>" . "recepcion myTypeMaterialDesde ->". $myTypeMaterialDesde;
        echo "<br>" . "recepcion myTypeMaterialHasta ->". $myTypeMaterialHasta;

        echo "<br>" . "recepcion myFechaDesde ->". $myFechaDesde;
        echo "<br>" . "recepcion myFechaHasta ->". $myFechaHasta;

        echo "<br>" . "recepcion myUsuarioDesde ->". $myUsuarioDesde;
        echo "<br>" . "recepcion myUsuarioHasta ->". $myUsuarioHasta;

        die();
        */
        
        $movimientos = Transaction::where('type_transaction_id', '=', $myTypeTransaction)
        ->whereIn('status',['Activo','Anulado'])
        ->whereBetween('wallet_id',         [$myWalletDesde, $myWalletHasta])
        ->whereBetween('group_id',          [$myGroupDesde,  $myGroupHasta])
        ->whereBetween('type_material_id',  [$myTypeMaterialDesde,  $myTypeMaterialHasta])        
        ->whereBetween('created_at',        [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',           [$myUsuarioDesde , $myUsuarioHasta])
        ->orderBy('created_at','desc')
        ->limit($myLimit)            
        ->get();

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $Type_material      = Type_material::pluck('name', 'id')->toArray();
        
        // \Log::info('leam - llega el material ->' . $myTypeMaterial);

        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;

        $parametros['myWallet']             = $myWallet;
        $parametros['myGroup']              = $myGroup;

        $parametros['fechaDesde']           = $myFechaDesde2;
        $parametros['fechaHasta']           = $myFechaHasta2;
        $parametros['movimientos']          = $movimientos;
        $parametros['myUser']               = $myUser;
        $parametros['user']                 = $user;

        $parametros['myTypeMaterial']       = $myTypeMaterial;
        $parametros['Type_material']        = $Type_material;

        // dd($transferencia);

        return view('materials.recepcion_index', $parametros);

    }

    
    /*
    *
    *
    * Display a listing of the resource.
    *
    */
    public function liquidacion_recepcion_index(Request $request, transaction $transaction)
    {
        /*
        if (!$request->query('user')){
            \Log::info('leam - transaction controller - no user');
        }
        if ($request->query('user')){
            \Log::info('leam - con user');
        }
        */
        $parameters     = $request->query();

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde');
        $fechaHasta     = $request->query('fechaHasta');
        
        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($user){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        //$myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        //$myFechaDesde = $this->get07DayBefore($myFechaHasta);
        
        $myFechaDesde = "2001-01-01";
        $myFechaHasta = "9999-12-31";

        if($fechaDesde){
            $myFechaDesde = $request->fechaDesde;
        };
        
        if($fechaHasta){
            $myFechaHasta = $request->fechaHasta;
         };

        //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
        // dd($request);
        $myLimit = "";
        /*
        if($this->isAdministrator()){
            if (!$user){
                $myUsuarioDesde = auth()->user()->id;
                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 500;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }
        */
        $myWalletDesde    = 0;
        $myWalletHasta    = 9999;
        $myWallet = $request->wallet ? $request->wallet : 0;
        if ($request->wallet){
            $myWalletDesde    = $request->wallet;
            $myWalletHasta    = $request->wallet;
        }

        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        $myGroup        = $request->group ? $request->group : 0;
        if ($request->group){
            $myGroupDesde    = $request->group;
            $myGroupHasta    = $request->group;
        }


        $myTypeMaterial  = $request->type_material ? $request->type_material : 0;
        $myTypeMaterialDesde   = 0;
        $myTypeMaterialHasta   = 9999;
        if ($request->type_material){
            $myTypeMaterialDesde   = $request->type_material;
            $myTypeMaterialHasta   = $request->type_material;
        }

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

        $wallet             = $wallet->toArray();
        $group              = $group->toArray();

        $myTypeTransaction = 48; // Recepcion de materiales

        $myLiquidationNumber = ($request->liquidation_number) ? $request->liquidation_number : 0;

        $liquidation        = Transaction::where('liquidation_number', $myLiquidationNumber)->first();
        $myLiquidationDate  = $liquidation->liquidation_date;



        /*
        echo "<br>" . "recepcion myTypeTransaction ->". $myTypeTransaction;

        echo "<br>" . "recepcion myWalletDesde ->". $myWalletDesde;
        echo "<br>" . "recepcion myWalletHasta ->". $myWalletHasta;

        echo "<br>" . "recepcion myGroupDesde ->". $myGroupDesde;
        echo "<br>" . "recepcion myGroupHasta ->". $myGroupHasta;

        echo "<br>" . "recepcion myTypeMaterialDesde ->". $myTypeMaterialDesde;
        echo "<br>" . "recepcion myTypeMaterialHasta ->". $myTypeMaterialHasta;

        echo "<br>" . "recepcion myFechaDesde ->". $myFechaDesde;
        echo "<br>" . "recepcion myFechaHasta ->". $myFechaHasta;

        echo "<br>" . "recepcion myUsuarioDesde ->". $myUsuarioDesde;
        echo "<br>" . "recepcion myUsuarioHasta ->". $myUsuarioHasta;

        die();
        */
        
        $movimientos = Transaction::where('type_transaction_id', '=', $myTypeTransaction)
        ->where('status','Liquidado')
        ->where('liquidation_number', $myLiquidationNumber)    
        ->whereBetween('wallet_id',         [$myWalletDesde, $myWalletHasta])
        ->whereBetween('group_id',          [$myGroupDesde,  $myGroupHasta])
        ->whereBetween('type_material_id',  [$myTypeMaterialDesde,  $myTypeMaterialHasta])  
        ->whereBetween('created_at',        [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',           [$myUsuarioDesde , $myUsuarioHasta])
        ->orderBy('created_at','desc')
        ->limit($myLimit)
        ->get();

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $Type_material      = Type_material::pluck('name', 'id')->toArray();
        
        // \Log::info('leam - llega el material ->' . $myTypeMaterial);

        $parametros['myLiquidationNumber']      = $myLiquidationNumber;
        $parametros['myLiquidationDate']        = $myLiquidationDate;

        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;

        $parametros['myWallet']                 = $myWallet;
        $parametros['myGroup']                  = $myGroup;

        $parametros['fechaDesde']               = $myFechaDesde2;
        $parametros['fechaHasta']               = $myFechaHasta2;
        $parametros['movimientos']              = $movimientos;
        $parametros['myUser']                   = $myUser;
        $parametros['user']                     = $user;

        $parametros['myTypeMaterial']           = $myTypeMaterial;
        $parametros['Type_material']            = $Type_material;

        // dd($transferencia);

        return view('materials.liquidacion_recepcion_index', $parametros);

    }


    /*
    *
    *
    * Display a listing of the resource.
    *
    *
    */
    public function index3(Request $request, transaction $transaction)
    {
        /*
        if (!$request->query('user')){
            \Log::info('leam - transaction controller - no user');
        }
        if ($request->query('user')){
            \Log::info('leam - con user');
        }
        */
        $parameters     = $request->query();

        $fechaDesde     = $request->query('fechaDesde');
        $fechaHasta     = $request->query('fechaHasta');

        $myUser         = $request->query('user') ? $request->query('user') : 0;        
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($myUser != 0){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }
        // die(' myUSerDesde ->' . $myUsuarioDesde . ' myUserHasta ->' . $myUsuarioHasta);

        $myGroup        = $request->group ? $request->group : 0;
        $myGroupDesde   = 0;
        $myGroupHasta   = 9999;
        if ($myGroup != 0){
            $myGroupDesde   = $request->group;
            $myGroupHasta   = $request->group;
        }
        // dd($myGroup);
        $myWallet        = $request->wallet ? $request->wallet : 0;
        $myWalletDesde   = 0;
        $myWalletHasta   = 9999;
        if ($myWallet != 0){
            $myWalletDesde   = $request->wallet;
            $myWalletHasta   = $request->wallet;
        }
        
        $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        $myFechaDesde = $this->get07DayBefore($myFechaHasta);
        
         if($fechaDesde){
            $myFechaDesde = $request->fechaDesde;
         };
         if($fechaHasta){
            $myFechaHasta = $request->fechaHasta;
         };
         //   dd(auth()->user()->roles);
        //  \Log::info('leam - transaction index - aqui');
        //  \Log::info('leam - transaction index - fecha desde - ' . $myFechaDesde . ' -- myFecha Hasta ->' . $myFechaHasta);
        //  \Log::info('leam - transaction index - request fecha desde - ' . $request->fechaDesde . ' -- request myFecha Hasta ->' . $request->fechaHasta);
        //  \Log::info('leam - transaction index - user  - ' . $myUser );
        //  \Log::info('leam - transaction index - request  - ' . $request );
         // dd($request);
        $myLimit = 0;
        if($this->isAdministrator()){
            if ($myUser == 0){
//                $myUsuarioDesde = auth()->user()->id;
//                $myUsuarioHasta = auth()->user()->id;
            }
            $myLimit = 1000;
        }else{
            $myUsuarioDesde = auth()->user()->id;
            $myUsuarioHasta = auth()->user()->id;
            $myLimit = 1000;
        }

        $myCoinDesde    = 0;
        $myCoinHasta    = 9999;
        $myCoin = $request->coin ? $request->coin : 0;
        if ($request->coin){
            $myCoinDesde    = $request->coin;
            $myCoinHasta    = $request->coin;
        }
   
        $myTypeTransactionDesde     = 0;
        $myTypeTransactionHasta     = 9999;
        $myTypeTransaction          = $request->typeTransaction ? $request->typeTransaction : 0;
        if ($request->typeTransaction){
            $myTypeTransactionDesde    = $request->typeTransaction;
            $myTypeTransactionHasta    = $request->typeTransaction;
        }

        /*
        echo "<br>" . "coin         - > $request->coin";
        echo "<br>" . "myCoinDesde  - > $myCoinDesde";
        echo "<br>" . "myCoinHasta  - > $myCoinHasta";
        echo "<br>" . "myGroupDesde - > $myGroupDesde";
        echo "<br>" . "myGroupHasta - > $myGroupHasta";
        echo "<br>" . "myUsuarioDesde - > $myUsuarioDesde";
        echo "<br>" . "myUsuarioHasta - > $myUsuarioHasta";

        die();
        */
        /*
        $transferencia = Transaction::whereNull(['transfer_number','pay_number'])
        ->whereBetween('wallet_id',             [$myWalletDesde , $myWalletHasta])
        ->whereBetween('group_id',              [$myGroupDesde , $myGroupHasta])
        ->whereBetween('created_at',            [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',               [$myUsuarioDesde , $myUsuarioHasta])
        ->whereBetween('type_coin_balance_id',  [$myCoinDesde , $myCoinHasta])
        ->orderBy('created_at','desc')
        ->limit($myLimit)            
        ->get();
        */
        
        $transferencia = Transaction::
          whereBetween('wallet_id',             [$myWalletDesde , $myWalletHasta])
        ->whereBetween('group_id',              [$myGroupDesde , $myGroupHasta])
        ->whereBetween('created_at',            [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        ->whereBetween('user_id',               [$myUsuarioDesde , $myUsuarioHasta])
        ->whereBetween('type_coin_balance_id',  [$myCoinDesde , $myCoinHasta])
        ->whereBetween('type_transaction_id',   [$myTypeTransactionDesde , $myTypeTransactionHasta])
        ->orderBy('created_at','desc')
        ->limit($myLimit)
        ->get();
        
        $myFechaDesde2      =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2      =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

        $user               = User::pluck('name', 'id')->toArray();

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();
     
        $wallet             = $wallet->toArray();
        $group              = $group->toArray();

        $myTypeCoinBalance  = $myCoin; // dorales siempre por ahora
        $Type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();

        $Type_transaction                   = Type_transaction::orderBy('name','ASC')->pluck('name','id')->toArray();

        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;

        $parametros['myWallet']             = $myWallet;
        $parametros['myGroup']              = $myGroup;

        $parametros['myTypeCoinBalance']    = $myTypeCoinBalance;
        $parametros['Type_coin_balance']    = $Type_coin_balance;

        $parametros['myTypeTransaction']    = $myTypeTransaction;
        $parametros['Type_transaction']     = $Type_transaction;

        $parametros['fechaDesde']           = $myFechaDesde2;
        $parametros['fechaHasta']           = $myFechaHasta2;
        $parametros['transferencia']        = $transferencia;
        $parametros['myUser']               = $myUser;
        $parametros['user']                 = $user;

        // dd($transferencia);

        return view('transactions.index3', $parametros);

    }

    public function credit(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_coin_balance  = Type_coin::pluck('name', 'id')->toArray();
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('id', ['6','7','8','12'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parametros['type_coin']            = $type_coin;
        $parametros['type_coin_balance']    = $type_coin_balance;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        $parametros['user']                 = $user;
        $parametros['fecha']                = $fecha;

        return view('transactions.credit', $parametros);

    }

    public function credit_edit($transaction)
    {

        $transactions       = Transaction::find($transaction);

        $imagen             = Transaction::findOrFail($transaction)->image;

        $type_coin          = Type_coin::pluck('name', 'id');

        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWalletsEfectivo();        
        $group              = app(GroupController::class)->getGroups();    

        $user               = User::pluck('name', 'id');

        $parametros['transactions']         = $transactions;
        $parametros['imagen']               = $imagen;
        $parametros['type_coin']            = $type_coin;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        $parametros['user']                 = $user;
        die('test');
        return view('transactions.credit_edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));

    }

     /**
     * Show the form for creating a new resource.
     */
    public function create(transaction $transaction)
    {
        
        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet             = app(GroupController::class)->getWallets2();   
        $group              = app(GroupController::class)->getGroups2();
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        // if (auth()->id() == 99){
        //     return view('transactions.create2', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
        // }

        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }
    public function create3(transaction $transaction)
    {
        // return Redirect::route('transactions.index3');
        
        $type_coin          = Type_coin::pluck('name', 'id');

        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet             = app(GroupController::class)->getWallets2();
        $group              = app(GroupController::class)->getGroups2(); 
        
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        // if (auth()->id() == 99){
        //     return view('transactions.create2', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
            
        // }

        $parametros['type_coin']            = $type_coin;
        
        $parametros['type_transaction']     = $type_transaction;
        $parametros['wallet']               = $wallet;
        $parametros['group']                = $group;
        $parametros['user']                 = $user;
        $parametros['fecha']                = $fecha;

        return view('transactions.create3', $parametros);
    }
    
     /**
     * Show the form for creating a new resource.
     */
    public function create2(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets2();
        $group              = app(GroupController::class)->getGroups2();


        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create2', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }


    public function create_efectivo(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWalletsEfectivo();
        $group              = app(GroupController::class)->getGroups2();

        //$client = Client::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create_efectivo', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user','fecha','transaction'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function materials_adquisicion_create(transaction $transaction)
    {

        $myTypeTransaction = 47;

        $type_coin                      = Type_coin::pluck('name', 'id');
        $type_transaction               = Type_transaction::where('id','=',$myTypeTransaction)->whereIn('type_transaction', ['Material'])->pluck('name', 'id');


        $wallet                         = app(GroupController::class)->getWallets2();
        $group                          = app(GroupController::class)->getGroups2();

        $user                           = User::pluck('name', 'id');
        $type_material                  = Type_material::pluck('name', 'id');    
        $fecha                          = Carbon::now();

        // dd($type_transaction);

        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        $parametros['type_material']    = $type_material;
        $parametros['fecha']            = $fecha;

        return view('materials.adquisicion_create', $parametros);
    }


     /**
     * Show the form for creating a new resource.
     */
    public function materials_recepcion_create(transaction $transaction)
    {

        $type_coin                      = Type_coin::pluck('name', 'id');
        $type_transaction               = Type_transaction::where('name','like','%Recepción%')->where('name','like','%Recepcion%')->whereIn('type_transaction', ['Material'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets2();
        $group              = app(GroupController::class)->getGroups2();

        $user                           = User::pluck('name', 'id');
        $type_material                  = Type_material::pluck('name', 'id');    
        $fecha                          = Carbon::now();


        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        $parametros['type_material']    = $type_material;
        $parametros['fecha']            = $fecha;

        return view('materials.recepcion_create', $parametros);

    }
    public function edit_efectivo($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;


        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets2();
        $group              = app(GroupController::class)->getGroups2();

        $user               = User::pluck('name', 'id');



        return view('transactions.edit_efectivo', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // dd($request->all());
        // $myRequest = $request;

        // \Log::info('request2 -> ' . $request2->all());
        // \Log::info('request  -> ' . $request->all());

        $transaction = Transaction::create($request->all() );

        $files = [];
        if($request->hasFile('file')){
            foreach($request2->file('file') as $file)
            {

                $url = Storage::put('public/Transactions/'.$transaction->id, $file);

                $files= new Image();
                $files->file = $files;


                $transaction->image()->create([
                    'url' => $url
                ]);

          }
        }

        flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);


        return Redirect::route('transactions.index');


    }


    
    /**
     * Store a newly created resource in storage.
     */

     public function store3(Request $request)
     {
        // dd($request->all());
         // $myRequest = $request;
 
         // \Log::info('request2 -> ' . $request2->all());
         // \Log::info('request  -> ' . $request->all());
 
         $transaction = Transaction::create($request->all() );
 
         $files = [];
         if($request->hasFile('file')){
             foreach($request2->file('file') as $file)
             {
 
                 $url = Storage::put('public/Transactions/'.$transaction->id, $file);
 
                 $files= new Image();
                 $files->file = $files;
 
 
                 $transaction->image()->create([
                     'url' => $url
                 ]);
 
           }
         }
 
         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);
 
 
         return Redirect::route('transactions.index3');
 
 
     }


    /**
     * Store a newly created resource in storage.
     */

    public function materials_adquisicion_store(Request $request)
    {
        //  dd($request->all());
 
        // \Log::info('request2 -> ' . $request2->all());
        // \Log::info('request  -> ' . $request->all());

         $transaction = Transaction::create($request->all() );

         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);
 
         return Redirect::route('materials.adquisicion_index');
 
 
    }

    /**
     * Store a newly created resource in storage.
     */

     public function materials_recepcion_store(Request $request)
     {
         // dd($request->all());
         // $myRequest = $request;
 
         // \Log::info('request2 -> ' . $request2->all());
         // \Log::info('request  -> ' . $request->all());
 
         $transaction = Transaction::create($request->all() );
 
         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);
 
         return Redirect::route('materials.recepcion_index');
  
    }

    public function index_transferwallet(Request $request, transaction $transaction)
    {
                                                      
        // $myTransferNumber = "transfer_number between '00000000000000000' and '99999999999999999'";
        $myTransferNumber = "transfer_number REGEXP '^[0-9]+$'";
        //     die('aqui llego');
        if ($request->transfer_number){

            $myTransferNumber = "transfer_number = '$request->transfer_number'";
        } 

        $group = Group::where('type','=',1)->pluck('name', 'id')->toArray();
        $user = User::pluck('name', 'id')->toArray();

        $myLimit = "limit 1000";
        $isAdministrator = $this->isAdministrator();
        
        $userFiltro = "";
        $myUser     = "";
        $myGroup    = "";

        if ($request->user){
            $userFiltro = "and user_id = " . $request->user;
            $myUser = $request->user;
        }else{
            if (!$isAdministrator){
                $userFiltro = "and user_id = " . auth()->user()->id;
            }
        }

        if ($request->group){
            $myGroup    = $request->group;
        }

        // dd($myUser); 


            $myQuery = "
                select
                    mtf.transactions.id      as TransactionId,
                    transfer_number          as TransferNumber,
                    IF(type_transactions.type_transaction_wallet = '1', 'Destino', 'Origen') as TransferType,
                    wallet_id                as WalletIdOrigen,
                    groups.name              as WalletNameOrigen,
                    amount_total             as Amount,
                    transaction_date         as TransactionDate,
                    users.name               as Agente,
                    status                   as estatus,
                    type_transaction_id      as TypeTransactionId,
                    transactions.description as Description,
                    type_transactions.name   as TypeTransactionName,
                    transactions.type_coin_id       as TypeCoinID,
                    type_coins.name                 as TypeCoinName                   
                from mtf.transactions
                left join  mtf.groups            on mtf.transactions.wallet_id = groups.id
                left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                left join  mtf.users             on mtf.transactions.user_id  = mtf.users.id
                left join  mtf.type_coins        on mtf.transactions.type_coin_id  = mtf.type_coins.id 
                where $myTransferNumber
                $myUser
                order by 
                    transaction_date desc,
                    transfer_number, 
                    TransferType desc
                $myLimit    
                ";

            // dd($myQuery);
            $transacciones = DB::select($myQuery);

         $parametros['myUser']          = $myUser;
         $parametros['myGroup']         = $myGroup;
         $parametros['group']           = $group;
         $parametros['user']            = $user;
         $parametros['transacciones']   = $transacciones;

         return view('transactions.index_transferwallet', $parametros);

    }

    
    public function index_transferwalletop(transaction $transaction)
    {

        // if(auth()->user()->id != 2){
        //     return Redirect::route('home');
        // }

        foreach(auth()->user()->roles as $roles)
        {

            $myLimit = "limit 1000";

            $myQuery = "
                select
                    mtf.transactions.id as TransactionId,
                    transfer_number             as TransferNumber,
                    IF(
                        type_transactions.name = 'Nota de Credito a Caja de efectivo' 
                    or  type_transactions.name = 'Nota de credito', 'Destino', 'Origen'
                    )                           as TransferType,                        
                    wallet_id                   as WalletIdOrigen,
                    groups.name                 as WalletNameOrigen,
                    amount_total                as Amount,
                    transaction_date            as TransactionDate,
                    users.name                  as Agente,
                    status                      as estatus,
                    type_transaction_id         as TypeTransactionId,
                    transactions.description    as Description,
                    type_transactions.name      as TypeTransactionName
                from mtf.transactions
                    left join  mtf.groups on mtf.transactions.wallet_id                         = groups.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id    = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id                            = mtf.users.id
                where transfer_number like '%-OP'
                order by 
                    TransactionDate desc,
                    transfer_number, 
                    TransferType desc    
                $myLimit                   
            ";

            $transactiones = DB::select($myQuery);

        }


         return view('transactions.index_transferwalletop', compact('transactiones'));

    }

    
    public function index_transferwalletop2(transaction $transaction)
    {

        // if(auth()->user()->id != 2){
        //     return Redirect::route('home');
        // }



            $myLimit = "limit 1000";

            $myQuery = "
                select
                    mtf.transactions.id         as TransactionId,
                    transfer_number             as TransferNumber,
                    IF(
                        type_transactions.name = 'Nota de Credito a Caja de efectivo' 
                    or  type_transactions.name = 'Nota de credito', 'Destino', 'Origen'
                    )                           as TransferType,                        
                    wallet_id                   as WalletIdOrigen,
                    groups.name                 as WalletNameOrigen,
                    amount_total                as Amount,
                    transaction_date            as TransactionDate,
                    users.name                  as Agente,
                    status                      as estatus,
                    type_transaction_id         as TypeTransactionId,
                    transactions.description    as Description,
                    type_transactions.name      as TypeTransactionName,
                    type_coin_id                as TypeCoinId,
                    mtf.type_coins.name         as TypeCoinName,
                    type_coin_balance_id        as TypeCoinBalanceId,
                    type_coins_balance.name     as TypeCoinBalanceName
                from mtf.transactions
                left join  mtf.groups               on mtf.transactions.wallet_id                           = groups.id
                left join  mtf.type_transactions    on mtf.transactions.type_transaction_id                 = mtf.type_transactions.id
                left join  mtf.users                on mtf.transactions.user_id                             = mtf.users.id
                left join  mtf.type_coins           on mtf.transactions.type_coin_id                        = mtf.type_coins.id
                left join  mtf.type_coins   as type_coins_balance         on mtf.transactions.type_coin_balance_id  = type_coins_balance.id
                where transfer_number like '%-OP'
                order by 
                    TransactionDate desc,
                    transfer_number, 
                    TransferType desc          
                $myLimit
                ";
                // dd($myQuery);

            $transactiones = DB::select($myQuery);

        
        // dd($transactiones);

         return view('transactions.index_transferwalletop2', compact('transactiones'));

    }
    public function index_pagowallet(request $request, transaction $transaction)
    {

        // \Log::info('leam - auth()->id() - es -> ' . auth()->id() . ' -- isAdministrator -> ' . $this->isAdministrator());

        $user           = $request->query('user');        
        $fechaDesde     = $request->query('fechaDesde');
        $fechaHasta     = $request->query('fechaHasta');

        // \Log::info('leam - user con $user ->' . $user);
        // \Log::info('leam - user con auth->user()->id ->' . auth()->user()->id );

        $myUser         = 0;
        $myUsuarioDesde = 0;
        $myUsuarioHasta = 999999;
        if ($user){
            $myUser         = $request->user;
            $myUsuarioDesde = $request->user;
            $myUsuarioHasta = $request->user;
        }


        $myFechaHasta = date("Y-m-d");
        // $myFechaDesde = $this->get03DayBefore($myFechaHasta);
        // $myFechaDesde = $this->get01DayBefore($myFechaHasta);        
        $myFechaDesde = $this->get07DayBefore($myFechaHasta);
        if($fechaDesde){
            $myFechaDesde = $request->fechaDesde;
         };
         if($fechaHasta){
            $myFechaHasta = $request->fechaHasta;
         };

        // if ($this->isAdministrator()){

        $myUserDesde    = 0;
        $myUserHasta    = 9999;
        $limit          = "";
        switch($this->isAdministrator()){
            case true:
                $limit = "limit 200";
                break;
            case false:
                $myUserDesde    = auth()->id();
                $myUserHasta    = auth()->id();
                break;
        }
        
        $myPayNumber = "pay_number LIKE '%P-G' != '' ";

        if ($request->pay_number){
            // die('aqui llego');
            $myPayNumber = "pay_number = '$request->pay_number'";
            $myUserDesde    = 0;
            $myUserHasta    = 9999;
            $limit          = "";
            $myFechaDesde = "2000-01-01";
        }   

        //    \Log::info('leam - myUserDesde -> ' . $myUserDesde . ' -- myUserHasta -> ' . $myUserHasta);

        $query = 
            "select
            mtf.transactions.id                 as TransactionId,
            pay_number                          as TransferNumber,
            IF(
                type_transactions.name = 'Nota de Credito a Caja de efectivo' 
            or  type_transactions.name = 'Nota de credito', 'Destino', 'Origen'
            ) 
                                                as TransferType,
            wallet_id                           as WalletIdOrigen,
            groups.name                         as WalletNameOrigen,
            amount_total                        as Amount,
            transaction_date                    as TransactionDate,
            users.name                          as Agente,
            status                              as estatus,
            type_transaction_id                 as TypeTransactionId,
            transactions.description            as Description,
            type_transactions.name              as TypeTransactionName,
            transactions.amount_commission_base as ComisionBase,
            transactions.percentage_base        as PorcentageBase,
            transactions.exonerate_base         as ExonerateBase,
            transactions.amount_total_base      as TotalBase
            from mtf.transactions
            left join  mtf.groups on mtf.transactions.wallet_id                         = groups.id
            left join  mtf.type_transactions on mtf.transactions.type_transaction_id    = mtf.type_transactions.id
            left join  mtf.users on mtf.transactions.user_id                            = mtf.users.id
            where $myPayNumber
            and user_id between $myUsuarioDesde and $myUsuarioHasta
            and mtf.transactions.created_at between '$myFechaDesde 00:00:00' and '$myFechaHasta 23:59:59'
            order by pay_number desc
            $limit
            ";
        // die('aqui ->' . $query);

        $transacciones  = DB::select($query);

        $user           = User::pluck('name', 'id')->toArray();

        $myFechaDesde2  =  substr($myFechaDesde,8,2) . '-' . substr($myFechaDesde,5,2) . '-' . substr($myFechaDesde,0,4);
        $myFechaHasta2  =  substr($myFechaHasta,8,2) . '-' . substr($myFechaHasta,5,2) . '-' . substr($myFechaHasta,0,4);

         // dd($query
         // \Log::info('leam - query ->' . $query);

        $parameters['fechaDesde']       = $myFechaDesde2;
        $parameters['fechaHasta']       = $myFechaHasta2;
        $parameters['myUser']           = $myUser;
        $parameters['transacciones']    = $transacciones;
        $parameters['user']             = $user;

        return view('transactions.index_pagowallet', $parameters);

    }






    public function create_transferwallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        
        // $type_transaction   = Type_transaction::whereIn('name', ['Nota de Debito a Caja de Efectivo'])->pluck('id');  // 12
        // $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo'])->pluck('id'); // 6

        $type_transaction   = Type_transaction::whereIn('id', [12])->pluck('id');   // 12 Salida de efectivo
        $type_transaction2  = Type_transaction::whereIn('id', [6])->pluck('id');    // 6 Entrada de efectivo o nota de credito

        // $wallet             = Group::whereIn('type_wallet', ['Efectivo'])->where('type','=','2')->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWalletsEfectivo();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();


        return view('transactions.create_transferwallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'user', 'transaction', 'fecha'));
    }


    public function transfer_wallet(Request $request)
    {
        $user           = Auth::id();
        $transaction    = new Transaction;

        $number_referencia = date('YmdHis'). rand(100,200);

        $transaction->type_transaction_id   = $request->input('type_transaction_id');
        $transaction->wallet_id             = $request->input('wallet_id');
        $transaction->group_id              = $request->input('wallet2_id');
        $transaction->amount                = $request->input('amount');
        $transaction->amount_total          = $request->input('amount_total');
        $transaction->amount_total_base     = $request->input('amount_total_base');
        $transaction->transaction_date      = $request->input('transaction_date');
        $transaction->description           = $request->input('description');
        $transaction->token                 = $request->input('token');
        $transaction->user_id               = $user;
        $transaction->transfer_number       = $number_referencia;

        $transaction->save();



        $transaction2 = new Transaction;

        $transaction2->type_transaction_id   = $request->input('type_transaction2_id');
        $transaction2->wallet_id             = $request->input('wallet2_id');
        $transaction2->group_id              = $request->input('wallet_id');
        $transaction2->amount                = $request->input('amount');
        $transaction2->amount_total          = $request->input('amount_total');
        $transaction2->amount_total_base     = $request->input('amount_total_base');
        $transaction2->transaction_date      = $request->input('transaction_date');
        $transaction2->description           = $request->input('description');
        $transaction2->user_id               = $user;
        $transaction2->transfer_number       = $number_referencia;

        $transaction2->save();

        flash()->addSuccess('Transferencia a caja guardado', 'Transacción', ['timeOut' => 3000]);

        return Redirect::back()->withInput();

    }

    public function create_pagowallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        // $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction   = Type_transaction::whereIn('id', [1,3,5,9,11])->pluck('name','id');

        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        //$type_transaction2  = Type_transaction::whereIn('id', [6])->pluck('name','id');

        //$wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        //$wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();

        $wallet             = app(GroupController::class)->getWallets2();
        $wallet2            = app(GroupController::class)->getWallets2();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();


        $parametros['type_coin']            = $type_coin;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['type_transaction2']    = $type_transaction2;
        $parametros['wallet']               = $wallet;
        $parametros['wallet2']              = $wallet2;
        $parametros['user']                 = $user;
        $parametros['transaction']          = $transaction;
        $parametros['fecha']                = $fecha;
        
        return view('transactions.create_pagowallet', $parametros);

    }

    public function create_transferwalletop(transaction $transaction)
    {

        $myTransactions [] = 1;
        $myTransactions [] = 5;
        $myTransactions [] = 9;
        $myTransactions [] = 11;
        $myTransactions [] = 14;
        $myTransactions [] = 15;
        $myTransactions [] = 16;
        $myTransactions [] = 17;
        $myTransactions [] = 18;
        $myTransactions [] = 25;
        $myTransactions [] = 30;
        $myTransactions [] = 31;
        $myTransactions [] = 34;
        $myTransactions [] = 36;
        $myTransactions [] = 37;

        $type_coin          = Type_coin::pluck('name', 'id');
        // $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction   = Type_transaction::whereIn('id', $myTransactions)->pluck('name','id');

        $type_transaction2  = Type_transaction::whereIn('id', [7])->pluck('name','id');
        //$type_transaction2  = Type_transaction::whereIn('id', [6])->pluck('name','id');

        $wallet             = app(GroupController::class)->getWallets()->toArray();
        $wallet2            = app(GroupController::class)->getWallets()->toArray();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parametros['type_coin']            = $type_coin;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['type_transaction2']    = $type_transaction2;
        $parametros['wallet']               = $wallet;
        $parametros['wallet2']              = $wallet2;
        $parametros['user']                 = $user;
        $parametros['fecha']                = $fecha;
        $parametros['transaction']          = $transaction;
    
        return view('transactions.create_transferwalletop', $parametros);

    }
    public function create_transferwalletop2(transaction $transaction)
    {

        $myTransactions [] = 1;
        $myTransactions [] = 5;
        $myTransactions [] = 9;
        $myTransactions [] = 11;
        $myTransactions [] = 14;
        $myTransactions [] = 15;
        $myTransactions [] = 16;
        $myTransactions [] = 17;
        $myTransactions [] = 18;
        $myTransactions [] = 25;
        $myTransactions [] = 30;
        $myTransactions [] = 31;
        $myTransactions [] = 34;
        $myTransactions [] = 36;
        $myTransactions [] = 37;

        $type_coin          = Type_coin::pluck('name', 'id')->toArray();
        $type_transaction   = Type_transaction::whereIn('id', $myTransactions)->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('id', [7])->pluck('name','id');

        $wallet             = app(GroupController::class)->getWallets()->toArray();
        $wallet2            = app(GroupController::class)->getWallets()->toArray();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parametros['type_coin']            = $type_coin;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['type_transaction2']    = $type_transaction2;
        $parametros['wallet']               = $wallet;
        $parametros['wallet2']              = $wallet2;
        $parametros['user']                 = $user;
        $parametros['transaction']          = $transaction;
        $parametros['fecha']                = $fecha;
        
        return view('transactions.create_transferwalletop2', $parametros);

        // return view('transactions.create_transferwalletop2', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));

    }    
    public function store_pagowallet(Request $request)
    {
        $user = Auth::id();
        $transactions = new Transaction;

        $number = date('YmdHis'). rand(100,200). 'P-G';

        $transactions->type_transaction_id      = $request->input('type_transaction_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->group_id                 = $request->input('wallet2_id');
        $transactions->amount                   = $request->input('amount');
        $transactions->amount_total             = $request->input('amount_total');
        $transactions->transaction_date         = $request->input('transaction_date');
        $transactions->description              = $request->input('description');
        $transactions->pay_number               = $number;
        $transactions->token                    = $request->input('token');
        $transactions->amount_commission_base   = $request->input('amount_commission_base');
        $transactions->percentage_base          = $request->input('percentage_base');
        $transactions->exonerate_base           = $request->input('exonerate_base');
        $transactions->amount_base              = $request->input('amount');
        $transactions->amount_total_base        = $request->input('amount_total_base');
        $transactions->user_id                  = $user;

        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id     = $request->input('type_transaction2_id');
        $transactions2->wallet_id               = $request->input('wallet2_id');
        $transactions2->group_id                = $request->input('wallet_id');
        $transactions2->amount                  = $request->input('amount');
        $transactions2->amount_total            = $request->input('amount_total');
        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');
        $transactions2->pay_number              = $number;
        $transactions2->token                   = $request->input('token');
        $transactions2->amount_base             = $request->input('amount');
        $transactions2->amount_total_base       = $request->input('amount');

        $transactions2->user_id                 = $user;
        
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         // return Redirect::back()->withInput();

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        //$wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        //$wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();

        $wallet             = app(GroupController::class)->getWallets()->toArray();
        $wallet2            = app(GroupController::class)->getWallets()->toArray();


        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parameters['myWallet']             = $request->input('wallet_id');
        $parameters['myWallet2']            = $request->input('wallet2_id');
        $parameters['myTypeTransactionId']  = $request->input('type_transaction_id');

        $parameters['type_coin']            = $type_coin;
        $parameters['type_transaction']     = $type_transaction;
        $parameters['type_transaction2']    = $type_transaction2;
        $parameters['wallet']               = $wallet;
        $parameters['wallet2']              = $wallet2;
        $parameters['user']                 = $user;
        $parameters['fecha']                = $fecha;

        // return Redirect::back()-with($parameters);
        return view('transactions.create_pagowallet',$parameters);
    }

    public function transfer_walletop(Request $request)
    {
        //    dd('leam - aqui');
        $user           = Auth::id();
        $transactions   = new Transaction;

        
        $number_referencia = date('YmdHis'). rand(100,200) . '-OP';
        // dd($number_referencia);
        $transactions->type_transaction_id      = $request->input('type_transaction_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->group_id                 = $request->input('wallet2_id');

        $transactions->amount                   = $request->input('amount');
        $transactions->amount_total             = $request->input('amount_total');

        $transactions->transaction_date         = $request->input('transaction_date');
        $transactions->description              = $request->input('description');   
        $transactions->token                    = $request->input('token');

        $transactions->percentage               = $request->input('percentage');
        $transactions->exonerate                = $request->input('exonerate');
        $transactions->amount_commission        = $request->input('amount_commission');

        $transactions->percentage_base          = $request->input('percentage_base');
        $transactions->exonerate_base           = $request->input('exonerate_base');
        $transactions->amount_commission_base   = $request->input('amount_commission_base');

        $transactions->amount_base              = $request->input('amount');
        $transactions->amount_total_base        = $request->input('amount_total_base');
        $transactions->user_id                  = $user;
        $transactions->transfer_number           = $number_referencia;
        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id     = $request->input('type_transaction2_id');
        $transactions2->wallet_id               = $request->input('wallet2_id');
        $transactions2->group_id                = $request->input('wallet_id');
        
        $transactions2->amount                  = $request->input('amount_total');
        $transactions2->amount_total            = $request->input('amount_total');

        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');

        $transactions2->token                   = $request->input('token');

        $transactions2->amount_base             = $request->input('amount_total');
        $transactions2->amount_total_base       = $request->input('amount_total');
        
        $transactions2->user_id                 = $user;
        $transactions2->transfer_number         = $number_referencia;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         return Redirect::back()->withInput();

         // return Redirect::back()->withInput();

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        //$wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        //$wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();

        $wallet             = app(GroupController::class)->getWallets()->toArray();
        $wallet2            = app(GroupController::class)->getWallets()->toArray();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parameters['myWallet']             = $request->input('wallet_id');
        $parameters['myWallet2']            = $request->input('wallet2_id');
        $parameters['myTypeTransactionId']  = $request->input('type_transaction_id');

        $parameters['type_coin']            = $type_coin;
        $parameters['type_transaction']     = $type_transaction;
        $parameters['type_transaction2']    = $type_transaction2;
        $parameters['wallet']               = $wallet;
        $parameters['wallet2']              = $wallet2;
        $parameters['user']                 = $user;
        $parameters['fecha']                = $fecha;

        // return Redirect::back()-with($parameters);
        return view('transactions.create_transferwalletop',$parameters);
    }

    public function transfer_walletop2(Request $request)
    {
        //   dd('leam - aqui');
        /*
        echo "<br>" . 'leam - transaction 1 ------------------------------------------------';
        echo "<br>" . 'leam - type_transaction_id               -> ' . $request->input('type_transaction_id');
        echo "<br>" . 'leam - wallet_id                         -> ' . $request->input('wallet_id');
        echo "<br>" . 'leam - group_id                          -> ' . $request->input('wallet2_id');
        echo "<br>" . 'leam - type_coin_id                      -> ' . $request->input('type_coin_id');
        echo "<br>" . 'leam - exchange_rate                     -> ' . $request->input('exchange_rate');
        echo "<br>" . 'leam - amount_foreign_currency           -> ' . $request->input('amount_foreign_currency');
        echo "<br>" . 'leam - exchange_rate_orientation         -> ' . $request->input('exchange_rate_orientation');
        echo "<br>" . 'leam - type_coin_balance_id              -> ' . $request->input('type_coin_balance_id');

        echo "<br>" . 'leam - percentage                        -> ' . $request->input('percentage');
        echo "<br>" . 'leam - amount_commission                 -> ' . $request->input('amount_commission');
        echo "<br>" . 'leam - exonerate                         -> ' . $request->input('exonerate');

        echo "<br>" . 'leam - amount                            -> ' . $request->input('amount');
        echo "<br>" . 'leam - amount_total                      -> ' . $request->input('amount_total');

        echo "<br>" . 'leam - percentage                        -> ' . $request->input('percentage_base');
        echo "<br>" . 'leam - amount_commission                 -> ' . $request->input('amount_commission_base');
        echo "<br>" . 'leam - exonerate                         -> ' . $request->input('exonerate_base');

        echo "<br>" . 'leam - amount_base                       -> ' . $request->input('amount');
        echo "<br>" . 'leam - amount_total_base                 -> ' . $request->input('amount_total_base');


        echo "<br>" . 'leam - transaction 2 ------------------------------------------------';
        echo "<br>" . 'leam - type_transaction2_id         -> ' . $request->input('type_transaction2_id');
        echo "<br>" . "leam - wallet2_id                   -> " . $request->input('wallet2_id');
        echo "<br>" . 'leam - type_coin_id2                -> ' . $request->input('type_coin_id');
        echo "<br>" . 'leam - type_coin_id22                -> ' . $request->input('type_coin_id22');
        echo "<br>" . 'leam - exchange_rate2               -> ' . $request->input('exchange_rate2');
        echo "<br>" . 'leam - amount_foreign_currency2     -> ' . $request->input('amount_foreign_currency2');
        echo "<br>" . 'leam - exchange_rate_orientation2   -> ' . $request->input('exchange_rate_orientation2');
        echo "<br>" . 'leam - type_coin_balance_id2        -> ' . $request->input('type_coin_balance_id2');
        echo "<br>" . 'leam - amount2                      -> ' . $request->input('amount2');
        echo "<br>" . 'leam - amount_total                 -> ' . $request->input('amount2');
        echo "<br>" . 'leam - amount_base                  -> ' . $request->input('amount2');
        echo "<br>" . 'leam - amount_total_base            -> ' . $request->input('amount2');
        

        

        echo "pasa";
        die();
        */
       // dd();
        
        $user = Auth::id();
        $transactions = new Transaction;

        
        $number_referencia = date('YmdHis'). rand(100,200) . '-OP';
        // dd($number_referencia);
        $transactions->type_transaction_id      = $request->input('type_transaction_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->group_id                 = $request->input('wallet2_id');

        $transactions->type_coin_id             = $request->input('type_coin_id');
        $transactions->exchange_rate            = $request->input('exchange_rate');
        $transactions->amount_foreign_currency  = $request->input('amount_foreign_currency');

        $transactions->exchange_rate_orientation = $request->input('exchange_rate_orientation');

        $transactions->type_coin_balance_id     = $request->input('type_coin_balance_id');
        $transactions->amount                   = $request->input('amount');

        $transactions->token                    = $request->input('token');
        $transactions->transaction_date         = $request->input('transaction_date');

        $transactions->percentage               = $request->input('percentage');
        $transactions->amount_commission        = $request->input('amount_commission');        
        $transactions->exonerate                = $request->input('exonerate');
        $transactions->amount_total             = $request->input('amount_total');


        $transactions->percentage_base          = $request->input('percentage_base');
        $transactions->amount_commission_base   = $request->input('amount_commission_base');
        $transactions->exonerate_base           = $request->input('exonerate_base');
        $transactions->amount_base              = $request->input('amount');
        $transactions->amount_total_base        = $request->input('amount_total_base');

        $transactions->user_id                  = $user;
        $transactions->transfer_number           = $number_referencia;

        $transactions->description              = $request->input('description');   

        $transactions->save();




        $transactions2 = new Transaction;

        $transactions2->type_transaction_id     = $request->input('type_transaction2_id');
        $transactions2->wallet_id               = $request->input('wallet2_id');
        
        $transactions2->type_coin_id             = $request->input('type_coin_id');
        $transactions2->exchange_rate            = $request->input('exchange_rate2');
        $transactions2->amount_foreign_currency  = $request->input('amount_foreign_currency2');

        $transactions2->exchange_rate_orientation = $request->input('exchange_rate_orientation2');

        $transactions2->type_coin_balance_id     = $request->input('type_coin_balance_id2');
        $transactions2->amount                   = $request->input('amount2');

        $transactions2->amount_total            = $request->input('amount2');

        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');

        $transactions2->token                   = $request->input('token');

        $transactions2->amount_base             = $request->input('amount2');
        $transactions2->amount_total_base       = $request->input('amount2'); // revisar si es asi
        
        $transactions2->user_id                 = $user;
        $transactions2->transfer_number         = $number_referencia;
        $transactions2->save();
       // \Log::info('transaction controller - type_coin_balance_id2 -> ' . $transactions->type_coin_balance_id);
        // \Log::info('leam - pasa');
        // die(); leamx
        
         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         // return Redirect::back()->withInput();
        // return redirect('transactions.create_transferwalletop2');


        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        //$wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        //$wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();

        $wallet             = app(GroupController::class)->getWallets()->toArray();
        $wallet2            = app(GroupController::class)->getWallets()->toArray();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $parameters['myWallet']             = $request->input('wallet_id');
        $parameters['myWallet2']            = $request->input('wallet2_id');
        $parameters['myTypeTransactionId']  = $request->input('type_transaction_id');

        $parameters['type_coin']            = $type_coin;
        $parameters['type_transaction']     = $type_transaction;
        $parameters['type_transaction2']    = $type_transaction2;
        $parameters['wallet']               = $wallet;
        $parameters['wallet2']              = $wallet2;
        $parameters['user']                 = $user;
        $parameters['fecha']                = $fecha;

        // return Redirect::back()-with($parameters);
        return view('transactions.create_transferwalletop2',$parameters);
    }
    public function index_pagoclientes(Request $request, transaction $transaction)
    {
        
        $myGroup = null;
        $myPayNumber = "pay_number LIKE '%T-C' != '' ";
        

        // $request->group_id = 272;
        $myGroupFilter = "";
        if ($request->grupo){
            $myGroup = $request->grupo;
            $groupTransaction = Transaction::select('pay_number')->where('group_id',$request->grupo)->where('pay_number','like','%T-C')->pluck('pay_number')->toArray();
            // dd($groupTransaction);
            if (count($groupTransaction)){
                foreach($groupTransaction as $item){
                    $myGroupFilter = $myGroupFilter . "'$item'";
                    $myGroupFilter = $myGroupFilter . ",";
                }
                $myGroupFilter = rtrim($myGroupFilter,",");
                // dd($myGroupFilter);
                $myGroupFilter = "and pay_number in($myGroupFilter)";
                // dd($myGroupFilter);
                
            }
        }

        if ($request->pay_number){
            // die('aqui llego');
            $myPayNumber = "pay_number = '$request->pay_number'";
        }        
        $fechaDesde = null;
        $fechaHasta = null;
        $fechaFiltro = null;
        if ($request->fechaDesde){
            $fechaDesde = $request->fechaDesde;
            $fechaHasta = $request->fechaHasta;
        }
        if ($request->fechaHasta){
            $fechaDesde = $request->fechaDesde;
            $fechaHasta = $request->fechaHasta;
            $fechaFiltro = "and transaction_date between '$fechaDesde 00:00:00' and '$fechaHasta 23:59:59'";
        }
        $group = Group::where('type','=',1)->pluck('name', 'id')->toArray();
        $user = User::pluck('name', 'id')->toArray();

        $myUser = null;
        $myUserFiltro = null;

        $myAdministratorFilter = "";

            if ($request->user){
                $myUser = $request->user;
                $myUserFiltro = "and user_id = $myUser";
            }else{
                // si es administrador no limita las transacciones al un usuario
                if($this->isAdministrator()){
                    $myAdministratorFilter = "limit 300";
                }else{
                    $myUser = auth()->user()->id;
                    $myUserFiltro = "and user_id = $myUser";          
                }
            }
    
        


        // dd($group);


         // foreach(auth()->user()->roles as $roles)
         // {
            // IF(type_transactions.name = 'Pago Efectivo', 'Destino', 'Origen') as TransferType,
            $myQuery ="
            select
                mtf.transactions.id             as TransactionId,
                pay_number                      as TransferNumber, 
                IF(type_transactions.type_transaction_group = '1', 'Destino', 'Origen') as TransferType,
                wallet_id                       as WalletIdOrigen,
                groups2.name                    as WalletNameOrigen,
                group_id                        as GroupIdOrigen,
                groups.name                     as GroupNameOrigen,
                amount                          as Amount,
                amount_total                    as AmountTotal,
                exchange_rate                   as ExchangeRate,
                date_format(transaction_date,'%Y-%m-%d')                as TransactionDate,
                date_format(transactions.created_at,'%Y-%m-%d')  as TransactionCreated,
                users.name                      as Agente,
                status                          as estatus,
                type_transaction_id             as TypeTransactionId,
                transactions.description        as Description,
                type_transactions.name          as TypeTransactionName,
                transactions.amount_commission  as ComisionBase,
                transactions.percentage         as PorcentageBase,
                transactions.exonerate          as ExonerateBase,
                transactions.amount_total       as TotalBase,
                transactions.type_coin_id       as TypeCoinID,
                type_coins.name                 as TypeCoinName,
                transactions.amount_foreign_currency         as AmountForeignCurrency
            from mtf.transactions
            left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
            left join  mtf.groups               on mtf.transactions.group_id  = groups.id
            left join  mtf.type_transactions    on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
            left join  mtf.users                on mtf.transactions.user_id  = mtf.users.id
            left join  mtf.type_coins            on mtf.transactions.type_coin_id  = mtf.type_coins.id 
            where 
            $myPayNumber
            $myUserFiltro
            $myGroupFilter
            $fechaFiltro 
            order by 
                transaction_date DESC,
                pay_number ASC,
                type_transactions.type_transaction_group DESC
            $myAdministratorFilter
            ";
            // dd($myQuery);
            $transactiones = DB::select($myQuery);
            // dd($transactiones);
         // }
         //}

         //$wallet                = Group::where('type','=','2')->orderBy('name','asc')->pluck('name', 'id')->toArray();
         //$group                 = Group::where('type','=','1')->orderBy('name','asc')->pluck('name', 'id')->toArray();
         //$Type_coin_balance     = Type_coin::pluck('name', 'id')->toArray();   
         //$user                  = User::pluck('name', 'id')->toArray();


         $parametros['myUser'] = $myUser;
         $parametros['myGroup'] = $myGroup;
         $parametros['group'] = $group;
         $parametros['user'] = $user;
         $parametros['myFechaDesde'] = $fechaDesde;
         $parametros['myFechaHasta'] = $fechaHasta;
         $parametros['transactiones'] = $transactiones;
        
         return view('transactions.index_pagoclientes', $parametros);

    }

    public function create_pagoclientes(transaction $transaction)
    {

        $type_coin                              = Type_coin::pluck('name', 'id');

        $type_transaction                       = Type_transaction::whereIn('name', ['Cobro en efectivo'])->pluck('id');
        $type_transaction2                      = Type_transaction::whereIn('name', ['Pago Efectivo'])->pluck('id');

        $wallet                                 = Group::where('type','=','2')->whereIn('name', ['Caja Puente'])->pluck('id');
        //$group                                  = Group::where('type','=','1')->pluck('name', 'id');
        //$group2                                 = Group::where('type','=','1')->pluck('name', 'id');

        $group                                  = app(GroupController::class)->getGroups();
        $group2                                 = app(GroupController::class)->getGroups();

        $user                                   = User::pluck('name', 'id');
        $fecha                                  = Carbon::now();

        $type_transaction_debit                 = Type_transaction::where('type_transaction_group', '2')->pluck('name', 'id');
        $type_transaction_credit                = Type_transaction::where('type_transaction_group', '1')->pluck('name', 'id');

        $parametros['type_coin']                = $type_coin;
        $parametros['type_transaction']         = $type_transaction;
        $parametros['type_transaction2']        = $type_transaction2;
        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;
        $parametros['group2']                   = $group2;
        $parametros['user']                     = $user;
        $parametros['fecha']                    = $fecha;
        $parametros['type_transaction_debit']   = $type_transaction_debit;
        $parametros['type_transaction_credit']  = $type_transaction_credit;

        
        //$number = date('YmdHis').'T-C';
        // dd($wallet);
        /*
        if (auth()->id() == 99){
            return view('transactions.create_pagocliente2', $parametros);
        }else{
            return view('transactions.create_pagocliente', compact('type_coin', 'type_transaction', 'wallet', 'type_transaction2', 'group', 'group2', 'user', 'transaction', 'fecha'));
        }
        */
        return view('transactions.create_pagocliente2', $parametros);
    }

    public function store_pagocliente(Request $request)
    {
        $user           = Auth::id();
        $transactions   = new Transaction;
        $number         = date('YmdHis'). rand(100,200). 'T-C';


        $transactions->type_transaction_id          = $request->input('typetrasnferencia2Debit');
        $transactions->group_id                     = $request->input('group_id');
        $transactions->wallet_id                    = $request->input('wallet_id');
        $transactions->amount_foreign_current       = $request->input('amount_foreign_current');
        $transactions->amount                       = $request->input('amount_foreign_current');
        $transactions->amount_total                 = $request->input('amount');
        $transactions->amount_total_base            = $request->input('amount');
        $transactions->amount_base                  = $request->input('amount');
        $transactions->transaction_date             = $request->input('transaction_date');
        $transactions->description                  = $request->input('description');
        $transactions->pay_number                   = $number;
        $transactions->amount_commission            = $request->input('commission');
        $transactions->percentage                   = $request->input('percentage');
        $transactions->exonerate                    = $request->input('exonerate');
        $transactions->amount_total                 = $request->input('amount_total');
        $transactions->amount_commission_profit     = $request->input('amount_commission_profit');
        $transactions->user_id                      = $user;

        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id         = $request->input('typetrasnferencia2Credit');
        $transactions2->group_id                    = $request->input('group2_id');
        $transactions2->wallet_id                   = $request->input('wallet2_id');
        $transactions2->amount_foreign_current      = $request->input('amount_foreign_current');
        $transactions2->amount                      = $request->input('amount');
        $transactions2->amount_total_base           = $request->input('amount');
        $transactions2->amount_base                 = $request->input('amount');
        $transactions2->transaction_date            = $request->input('transaction_date');
        $transactions2->description                 = $request->input('description2');
        $transactions2->pay_number                  = $number;
        $transactions2->amount_commission           = 0;
        $transactions2->percentage                  = 0;
        $transactions2->exonerate                   = 2;
        $transactions2->amount_total                = $request->input('amount');
        $transactions2->user_id                     = $user;

        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción entre clientes :D', ['timeOut' => 3000]);

         return Redirect::back()->withInput();
    }

    public function store_pagocliente2(Request $request)
    {

        // return Redirect::back()->withInput();

        $user           = Auth::id();
        $transactions   = new Transaction;
        $number         = date('YmdHis'). rand(100,200). 'T-C';
 
        $type_coin_id               = $request->input('type_coin_id');

        if ($type_coin_id == 1){
            $amount_foreign_currency    = $request->input('amount_foreign_currency');
            $amount                     = $request->input('amount_foreign_currency');
            $amount_total               = $request->input('amount');

            $amount2                    = $request->input('amount_foreign_currency');
            $amount_total2              = $request->input('amount2');
        }else{
            $amount_foreign_currency    = $request->input('amount_foreign_currency');
            $amount                     = $request->input('amount');
            $amount_total               = $request->input('amount');
    
            $amount2                    = $request->input('amount2');
            $amount_total2              = $request->input('amount2');            
        }

        // dd('amount -> ' . $amount);
        // dd('amount_total -> ' . $amount_total);

        /*
        \Log::info('store_pagocliente2 type_transaction_id     -> ' . $request->input('type_transaction_id'));
        \Log::info('store_pagocliente2 group_id                    -> ' . $request->input('group_id'));
        \Log::info('store_pagocliente2 wallet_id                   -> ' . $request->input('wallet_id'));
        \Log::info('store_pagocliente2 amount                      -> ' . $request->input('amount'));
        \Log::info('store_pagocliente2 transaction_date            -> ' . $request->input('transaction_date'));
        \Log::info('store_pagocliente2 description                 -> ' . $request->input('description'));
        \Log::info('store_pagocliente2 number                      -> ' . $number);
        \Log::info('store_pagocliente2 commission                  -> ' . $request->input('commission'));
        \Log::info('store_pagocliente2 percentage                  -> ' . $request->input('percentage'));
        \Log::info('store_pagocliente2 exonerate                   -> ' . $request->input('exonerate'));
        \Log::info('store_pagocliente2 amount_total                -> ' . $request->input('amount_total'));
        \Log::info('store_pagocliente2 amount_commission_profit    -> ' . $request->input('amount_commission_profit'));
        */
        

        $transactions->type_transaction_id          = $request->input('type_transaction_id');
        $transactions->type_coin_id                 = $request->input('type_coin_id');
        $transactions->group_id                     = $request->input('group_id');
        $transactions->wallet_id                    = $request->input('wallet_id');
        $transactions->amount                       = $amount;
        $transactions->amount_foreign_currency      = $amount_foreign_currency;
        $transactions->amount_total_base            = $amount;
        $transactions->amount_base                  = $amount;
        $transactions->transaction_date             = $request->input('transaction_date');
        $transactions->description                  = $request->input('description');
        $transactions->pay_number                   = $number;
        $transactions->amount_commission            = $request->input('commission');
        $transactions->exchange_rate                = $request->input('exchange');
        $transactions->percentage                   = $request->input('percentage');
        $transactions->exonerate                    = $request->input('exonerate');
        $transactions->amount_total                 = $amount_total;
        $transactions->amount_commission_profit     = $request->input('amount_commission_profit');
        $transactions->user_id                      = $user;

        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id          = $request->input('type_transaction_id2');
        $transactions2->type_coin_id                 = $request->input('type_coin_id');
        $transactions2->group_id                     = $request->input('group2_id');
        $transactions2->wallet_id                    = $request->input('wallet2_id');
        $transactions2->amount                       = $amount2;
        $transactions2->amount_foreign_currency      = $amount_foreign_currency;
        $transactions2->amount_total_base            = $amount2;
        $transactions2->amount_base                  = $amount2;
        $transactions2->transaction_date             = $request->input('transaction_date');
        $transactions2->description                  = $request->input('description2');
        $transactions2->pay_number                   = $number;
        $transactions2->amount_commission            = $request->input('commission2');
        $transactions2->exchange_rate                = $request->input('exchange2');
        $transactions2->percentage                   = $request->input('percentage2');
        $transactions2->exonerate                    = $request->input('exonerate2');
        $transactions2->amount_total                 = $amount_total2;
        $transactions2->amount_commission_profit     = $request->input('amount_commission_profit2');        
        $transactions2->user_id                      = $user;

        $transactions2->save();

        flash()->addSuccess('Movimiento guardado', 'Transacción entre clientes :D', ['timeOut' => 3000]);

        return Redirect::back()->withInput();
    }


    public function update_pagoclientes(Request $request)
    {
            
        $user           = Auth::id();
        $nroTransferencia = $request->input('nroTransferencia');


        
        $myPayNumber = "";
        if ($nroTransferencia){
            $myPayNumber = "pay_number = '" . $nroTransferencia . "'";
        }else{
            return;
        }

        
        $myQuery ="
        select 
            mtf.transactions.id                              as TransactionId,
            pay_number                                       as PayNumber, 
            type_transactions.type_transaction_group         as TypeTransactionGroup,
            IF(type_transactions.type_transaction_group = '1', 'Destino', 'Origen') as TypeTransactionGroupName,
            wallet_id                                        as WalletIdOrigen,
            groups2.name                                     as WalletNameOrigen,
            group_id                                         as GroupIdOrigen,
            groups.name                                      as GroupNameOrigen,
            amount                                           as Amount,
            date_format(transaction_date,'%Y-%m-%d')         as TransactionDate,
            date_format(transactions.created_at,'%Y-%m-%d')  as TransactionCreated,
            user_id                                          as AgenteId,
            users.name                                       as Agente,
            status                                           as estatus,
            type_transaction_id                              as TypeTransactionId,
            transactions.description                         as Description,
            type_transactions.name                           as TypeTransactionName,
            transactions.amount_commission                   as AmountCommission,
            transactions.percentage                          as Porcentage,
            transactions.exonerate                           as Exonerate,
            transactions.amount_total                        as AmountTotal
        from mtf.transactions
        left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
        left join  mtf.groups               on mtf.transactions.group_id  = groups.id
        left join  mtf.type_transactions    on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
        left join  mtf.users                on mtf.transactions.user_id  = mtf.users.id
        where 
        $myPayNumber
        order by 
            transaction_date DESC,
            pay_number ASC,
            type_transactions.type_transaction_group DESC
        ";


        // dd($myQuery);
        $transactions = DB::select($myQuery);

        $myFecha = date('Y-m-d h:i:s', strtotime($request->input('transaction_date')));
        

        foreach($transactions as $item){
            switch ($item->TypeTransactionGroup){
                case '2':
                    $theTransaction = Transaction::find($item->TransactionId);
                    $theTransaction->type_transaction_id          = $request->input('type_transaction_id');
                    $theTransaction->group_id                     = $request->input('group_id');
                    $theTransaction->type_coin_id                 = $request->input('type_coin_id');
                    $theTransaction->group_id                     = $request->input('group_id');
                    $theTransaction->amount                       = $request->input('amount');
                    $theTransaction->amount_total_base            = $request->input('amount');
                    $theTransaction->amount_base                  = $request->input('amount');
                    $theTransaction->transaction_date             = $myFecha;
                    $theTransaction->description                  = $request->input('description');
                    $theTransaction->amount_commission            = $request->input('commission');
                    $theTransaction->percentage                   = $request->input('percentage');
                    $theTransaction->exonerate                    = $request->input('exonerate');
                    $theTransaction->amount_total                 = $request->input('amount_total');
                    $theTransaction->amount_commission_profit     = $request->input('amount_commission_profit');
                    $theTransaction->exchange_rate                = $request->input('exchange');
                    $theTransaction->user_id                      = $user;
                    $theTransaction->update();
                    break;
                case '1':

                    $theTransaction = Transaction::find($item->TransactionId);
                    $theTransaction->type_transaction_id          = $request->input('type_transaction_id2');                    
                    $theTransaction->group_id                     = $request->input('group2_id');                    
                    $theTransaction->type_coin_id                 = $request->input('type_coin_id');
                    $theTransaction->group_id                     = $request->input('group2_id');
                    $theTransaction->amount                       = $request->input('amount');
                    $theTransaction->amount_total_base            = $request->input('amount');
                    $theTransaction->amount_base                  = $request->input('amount');
                    $theTransaction->transaction_date             = $myFecha;
                    $theTransaction->description                  = $request->input('description2');
                    $theTransaction->amount_commission            = $request->input('commission2');
                    $theTransaction->percentage                   = $request->input('percentage2');
                    $theTransaction->exonerate                    = $request->input('exonerate2');
                    $theTransaction->amount_total                 = $request->input('amount_total2');
                    $theTransaction->amount_commission_profit     = $request->input('amount_commission_profit2');
                    $theTransaction->exchange_rate                = $request->input('exchange2');
                    $theTransaction->user_id                      = $user;
                    $theTransaction->update();
                    break;
            }            
        }

        // dd($transactions);

         flash()->addSuccess('Movimiento actualizado', 'Transacción entre clientes :D', ['timeOut' => 3000]);
         

          return Redirect::back()->withInput();
          // transactions.index_pagoclientes
    }




    public function edit_pagoclientes(Request $request){

        $myPayNumber = "";
        if ($request->TransferNumber){
            $myPayNumber = "pay_number = '" . $request->TransferNumber . "'";
        }else{
            return;
        }
        $nroTransferencia = $request->TransferNumber;

        $type_coin                              = Type_coin::pluck('name', 'id');

        $type_transaction                       = Type_transaction::whereIn('name', ['Cobro en efectivo'])->pluck('id');
        $type_transaction2                      = Type_transaction::whereIn('name', ['Pago Efectivo'])->pluck('id');

        $wallet                                 = Group::where('type','=','2')->whereIn('name', ['Caja Puente'])->pluck('id');
        //$group                                  = Group::where('type','=','1')->pluck('name', 'id');
        //$group2                                 = Group::where('type','=','1')->pluck('name', 'id');

        $group                                  = app(GroupController::class)->getGroups();
        $group2                                 = app(GroupController::class)->getGroups();

        $user                                   = User::pluck('name', 'id');
        $fecha                                  = Carbon::now();

        $type_transaction_debit                 = Type_transaction::where('type_transaction_group', '2')->pluck('name', 'id');
        $type_transaction_credit                = Type_transaction::where('type_transaction_group', '1')->pluck('name', 'id');


        // dd($type_transaction_debit);

         // dd('aqui ->' . $myPayNumber . '<-');
        $myQuery ="
        select 
            mtf.transactions.id                              as TransactionId,
            pay_number                                       as PayNumber, 
            type_transactions.type_transaction_group         as TypeTransactionGroup,
            IF(type_transactions.type_transaction_group = '1', 'Destino', 'Origen') as TypeTransactionGroupName,
            wallet_id                                        as WalletIdOrigen,
            groups2.name                                     as WalletNameOrigen,
            group_id                                         as GroupIdOrigen,
            groups.name                                      as GroupNameOrigen,
            amount_foreign_currency                          as AmountForeignCurrency,
            amount                                           as Amount,
            date_format(transaction_date, '%Y-%m-%d %H:%i')  as TransactionDate,
            date_format(transactions.created_at,'%Y-%m-%d')  as TransactionCreated,
            user_id                                          as AgenteId,
            users.name                                       as Agente,
            status                                           as estatus,
            type_transaction_id                              as TypeTransactionId,
            transactions.description                         as Description,
            type_transactions.name                           as TypeTransactionName,
            transactions.amount_commission                   as AmountCommission,
            transactions.percentage                          as Porcentage,
            transactions.exonerate                           as Exonerate,
            transactions.amount_total                        as AmountTotal,
            mtf.transactions.exchange_rate                   as Exchange,
            mtf.transactions.type_coin_id                    as TypeCoinId
        from mtf.transactions
        left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
        left join  mtf.groups               on mtf.transactions.group_id  = groups.id
        left join  mtf.type_transactions    on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
        left join  mtf.users                on mtf.transactions.user_id  = mtf.users.id
        where 
        $myPayNumber
        order by 
            transaction_date DESC,
            pay_number ASC,
            type_transactions.type_transaction_group DESC
        ";


        // dd($myQuery);
        $transactions = DB::select($myQuery);
        // dd($transactions);


        $transaction = new stdClass();
        $transaction->TransactionId = "";
        $transaction->PayNumber ="";
        $transaction->TypeTransactionGroup = "";
        $transaction->Destino = "";
        $transaction->WalletIdOrigen = "";
        $transaction->WalletNameOrigen = "";
        $transaction->GroupIdOrigen = "";
        $transaction->GroupNameOrigen = "";
        $transaction->Amount = "";
        $transaction->AmountForeignCurrency = "";
        $transaction->TransactionDate = "";
        $transaction->TransactionCreated = "";
        $transaction->AgenteId = "";
        $transaction->Agente = "";
        $transaction->estatus = "";
        $transaction->TypeTransactionId = "";
        $transaction->Description = "";
        $transaction->TypeTransactionName = "";
        $transaction->AmountCommission = "";
        $transaction->Porcentage = "";
        $transaction->Exonerate = "";
        $transaction->AmounTotal = "";   
        $transaction->Exchange = "";  
        $transaction->TypeCoinId = "";  

        $transactionOrigen   = $transaction;
        $transactionDestino = $transaction;

        foreach($transactions as $item){
            switch ($item->TypeTransactionGroup){
                case '2':
                    $transactionOrigen = $item;
                    break;
                case '1':
                    $transactionDestino = $item;
                    break;
            }            
        }
        // dd($transactionOrigen);
        // dd($transactionDestino);
        // dd($transaction);     
    
        // $parametros['transactionOrigen'] = $tansactionOrigen;
        // $parametros['transactionDestino'] = $transactionDestino;

        $fecha                                  = Carbon::now();
        
        $parametros['nroTransferencia']         = $nroTransferencia;
        $parametros['type_coin']                = $type_coin;
        $parametros['type_transaction']         = $type_transaction;
        $parametros['type_transaction2']        = $type_transaction2;
        $parametros['wallet']                   = $wallet;
        $parametros['group']                    = $group;
        $parametros['group2']                   = $group2;
        $parametros['user']                     = $user;
        $parametros['type_transaction_debit']   = $type_transaction_debit;
        $parametros['type_transaction_credit']  = $type_transaction_credit;
        $parametros['fecha']                    = $fecha;
        $parametros['fecha']                    = $fecha;
        $parametros['transactionOrigen']       = $transactionOrigen;
        $parametros['transactionDestino']       = $transactionDestino;
        
        return view('PagoClientes.Edit_pagoclientes', $parametros);


    }

    public function index_cobrowallet(Request $request, transaction $transaction)
    {

        $myPayNumber = 'pay_number LIKE "%C-G" != ""';
        // die('aqui llego ->' . $request->pay_number );
        if ($request->pay_number){

            $myPayNumber = "pay_number = '$request->pay_number'";
        }  


         foreach(auth()->user()->roles as $roles)
         {

                $myQuery = "
                    select
                        mtf.transactions.id as TransactionId,
                        pay_number as TransferNumber,
                        IF(type_transactions.name = 'Nota de Debito a Caja de Efectivo' or type_transactions.name = 'Nota de debito', 'Destino', 'Origen') as TransferType,
                        wallet_id as WalletIdOrigen,
                        groups2.name as WalletNameOrigen,
                        group_id  as GroupIdOrigen,
                        groups.name as GroupNameOrigen,
                        amount_total as Amount,
                        transaction_date as TransactionDate,
                        users.name as Agente,
                        status as estatus,
                        type_transaction_id as TypeTransactionId,
                        transactions.description as Description,
                        type_transactions.name as TypeTransactionName,
                        transactions.amount_commission as ComisionBase,
                        transactions.percentage as PorcentageBase,
                        transactions.exonerate as ExonerateBase,
                        transactions.amount_total as TotalBase
                    from mtf.transactions
                        left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
                        left join  mtf.groups on mtf.transactions.group_id = groups.id
                        left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                        left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where $myPayNumber
                    order by pay_number desc                
                ";
                $transactiones = DB::select($myQuery);

                /*
                $transactiones = DB::select('select
                mtf.transactions.id as TransactionId,
                    pay_number as TransferNumber,
                IF(type_transactions.name = "Nota de Debito a Caja de Efectivo" or type_transactions.name = "Nota de debito", "Destino", "Origen") as TransferType,
                    wallet_id as WalletIdOrigen,
                    groups2.name as WalletNameOrigen,
                    group_id  as GroupIdOrigen,
                    groups.name as GroupNameOrigen,
                    amount_total as Amount,
                    transaction_date as TransactionDate,
                    users.name as Agente,
                    status as estatus,
                    type_transaction_id as TypeTransactionId,
                    transactions.description as Description,
                    type_transactions.name as TypeTransactionName,
                    transactions.amount_commission as ComisionBase,
                    transactions.percentage as PorcentageBase,
                    transactions.exonerate as ExonerateBase,
                    transactions.amount_total as TotalBase
                    from mtf.transactions
                    left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
                    left join  mtf.groups on mtf.transactions.group_id = groups.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where pay_number LIKE "%C-G" != "" 
                    order by pay_number desc');
                */
         }


         return view('transactions.index_cobrowallet', compact('transactiones'));

    }

    public function create_cobrowallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Cobro en efectivo', 'Cobro en Transferencia', 'Cobro Mercancia'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Debito a Caja de Efectivo', 'Nota de debito'])->pluck('name','id');
        //$wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id');
        //$wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $wallet2            = app(GroupController::class)->getWallets();

        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        //$number = date('YmdHis').'C-G';
        $parametros['type_coin']            = $type_coin;
        $parametros['type_transaction']     = $type_transaction;
        $parametros['type_transaction2']    = $type_transaction2;
        $parametros['wallet']               = $wallet;
        $parametros['wallet2']              = $wallet2;
        $parametros['user']                 = $user;
        $parametros['transaction']          = $transaction;
        $parametros['fecha']                = $fecha;
        
        return view('transactions.create_cobrowallet', $parametros);

    }

    public function store_cobrowallet(Request $request)
    {


        // 02-10-2023 se desincorpora el cobrod e la comision base  para nmo descuadrar el commission profit

        $user = Auth::id();

        //
        // Nota de debito
        //

        $transactions = new Transaction;
        $number = date('YmdHis'). rand(100,200). 'C-G';

        $transactions->type_transaction_id      = $request->input('type_transaction2_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->group_id                 = $request->input('wallet2_id');
        $transactions->amount                   = $request->input('amount');
        $transactions->amount_total             = $request->input('amount_total');
        $transactions->transaction_date         = $request->input('transaction_date');
        $transactions->description              = $request->input('description');
        $transactions->pay_number               = $number;
        $transactions->token                    = $request->input('token');
        // $transactions->amount_commission_base   = $request->input('amount_commission_base');
        // $transactions->percentage_base          = $request->input('percentage_base');
        // $transactions->exonerate_base           = $request->input('exonerate_base');
        $transactions->amount_base              = $request->input('amount');
        $transactions->amount_total_base        = $request->input('amount');
        // $transactions->amount_commission_profit = $request->input('amount_commission_profit');
        $transactions->user_id                  = $user;

        $transactions->save();

        //
        // cobro
        //

        $transactions2 = new Transaction;

        $transactions2->type_transaction_id     = $request->input('type_transaction_id');
        $transactions2->wallet_id               = $request->input('wallet2_id');
        $transactions2->group_id                = $request->input('wallet_id');
        $transactions2->amount                  = $request->input('amount');
        $transactions2->amount_total            = $request->input('amount_total');
        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');
        $transactions2->pay_number              = $number;
        $transactions2->token                   = $request->input('token');
        // $transactions2->amount_commission_base  = $request->input('amount_commission_base');
        // $transactions2->percentage_base         = $request->input('percentage_base');
        // $transactions2->exonerate_base          = $request->input('exonerate_base');
        $transactions2->amount_base             = $request->input('amount');
        $transactions2->amount_total_base       = $request->input('amount_total_base');
        // $transactions2->amount_commission_profit = $request->input('amount_commission_profit');        
        $transactions2->user_id                 = $user;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Cobro entre proveedores :D', ['timeOut' => 3000]);

         return Redirect::back()->withInput();
    }






    public function updatestatus_pago(Request $request, $transaction)
    {
            $transferencia = Transaction::find($transaction);

             if($transferencia->status == 'Activo'){

                  Transaction::where('pay_number', $transferencia->pay_number)->update(['status' => 'Anulado']);


                   return Redirect::back()->with('info', 'Transferencia anulada  <strong># '.$transferencia->pay_number. '</strong>');

            }

            elseif($transferencia->status == 'Anulado'){

                Transaction::where('pay_number', $transferencia->pay_number)->update(['status' => 'Activo']);


                return Redirect::back()->with('success', 'Transferencia activa  <strong>#'.$transferencia->pay_number.'</strong>');

            }

    }






    public function updatestatus_transfer(Request $request, $transaction)
    {
            $transferencia = Transaction::find($transaction);

             if($transferencia->status == 'Activo'){

                  Transaction::where('transfer_number', $transferencia->transfer_number)->update(['status' => 'Anulado']);


                   return Redirect::route('transactions.index_transferwallet')->with('info', 'Transferencia anulada  <strong># '.$transferencia->transfer_number. '</strong>');

            }

            elseif($transferencia->status == 'Anulado'){

                Transaction::where('transfer_number', $transferencia->transfer_number)->update(['status' => 'Activo']);


                return Redirect::route('transactions.index_transferwallet')->with('success', 'Transferencia activa  <strong>#'.$transferencia->transfer_number.'</strong>');

            }

    }

    public function store_efectivo(Request $request)
    {

        $transaction = Transaction::create($request->all());
        $files = [];
       if($request->hasFile('file')){
        foreach($request->file('file') as $file)
        {

            $url = Storage::put('public/Transactions/'.$transaction->id, $file);

            $files= new Image();
            $files->file = $files;


            $transaction->image()->create([
                'url' => $url
            ]);

          }
        }

        //flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

        //return Redirect::route('transactions.create_efectivo');
        return Redirect::back()->withInput()->with('success', 'Transferencia en efectivo guardada.  <strong>#'. $transaction->id .'</strong>');

    }

    /**
     * Display the specified resource.
     */
    public function show($transaction)
    {
           //  dd('aqui ' . $transaction);
            $transactions = Transaction::find($transaction);

            return view('transactions.show', compact('transactions'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($transaction)
    {

        $transactions       = Transaction::find($transaction);

        $imagen             = Transaction::findOrFail($transaction)->image;


        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::pluck('name', 'id');


        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();
        
        
        $user               = User::pluck('name', 'id');

        $myName = "";
        foreach($type_transaction as $key => $value){
            if ($transactions->type_transaction_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_transaction_name = $myName;

        $myName = "";
        foreach($type_coin as $key => $value){
            if ($transactions->type_coin_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_coin_name = $myName;

        $myName = "";
        foreach($wallet as $key => $value){
            if ($transactions->wallet_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->wallet_name = $myName;

        $myName = "";
        foreach($group as $key => $value){
            if ($transactions->group_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        $myName = "";
        foreach($user as $key => $value){
            if ($transactions->user_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        // $myPos              = array_search($transactions->type_transction_id,$type_transaction);
        // $myName             = $type_transactions($myPos);
        // dd($transactions);
        // dd(var_dump($type_transaction));
        // dd('type transaction ->' . $transactions->type_transaction_id . 'myName ->' . $myName);

        $parametros['transactions']     = $transactions;
        $parametros['imagen']           = $imagen;
        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        
        return view('transactions.edit', $parametros);

        // return view('transactions.edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit2($transactionid)
    {
        
        $transactions       = Transaction::find($transactionid);
        
        $imagen             = Transaction::findOrFail($transactionid)->image;

        
        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

        $user               = User::pluck('name', 'id');
        
        $myName = "";
        foreach($type_transaction as $key => $value){
            if ($transactions->type_transaction_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_transaction_name = $myName;

        $myName = "";
        foreach($type_coin as $key => $value){
            if ($transactions->type_coin_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_coin_name = $myName;

        $myName = "";
        foreach($wallet as $key => $value){
            if ($transactions->wallet_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->wallet_name = $myName;

        $myName = "";
        foreach($group as $key => $value){
            if ($transactions->group_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        $parametros['transactions']     = $transactions;
        $parametros['imagen']           = $imagen;
        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        
        return view('transactions.edit2', $parametros);

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit3($transactionid)
    {
        
        $transactions       = Transaction::find($transactionid);
        
        $imagen             = Transaction::findOrFail($transactionid)->image;

        
        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

        $user               = User::pluck('name', 'id');
        
        $myName = "";
        foreach($type_transaction as $key => $value){
            if ($transactions->type_transaction_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_transaction_name = $myName;

        $myName = "";
        foreach($type_coin as $key => $value){
            if ($transactions->type_coin_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_coin_name = $myName;

        $myName = "";
        foreach($wallet as $key => $value){
            if ($transactions->wallet_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->wallet_name = $myName;

        $myName = "";
        foreach($group as $key => $value){
            if ($transactions->group_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        $myName = "";
        foreach($type_coin as $key => $value){
            if ($transactions->type_coin_balance_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_coin_balance_name = $myName;

        // $myPos              = array_search($transactions->type_transction_id,$type_transaction);
        // $myName             = $type_transactions($myPos);
        // dd($transactions);
        // dd(var_dump($type_transaction));
        // dd('type transaction ->' . $transactions->type_transaction_id . 'myName ->' . $myName);
        $parametros['transactions']     = $transactions;
        $parametros['imagen']           = $imagen;
        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        return view('transactions.edit3', $parametros);
        // return view('transactions.edit3', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }


    
    /**
     * Show the form for editing the specified resource.
     */
    public function materials_adquisicion_edit(Request $request)
    {
        $myId = 0;
        if (isset($request->id)){
            $myId = $request->id;
        }
        $transactions        = Transaction::find($myId);

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

        $user               = User::pluck('name', 'id');
        $type_coin_balance  = Type_coin::pluck('name', 'id');

        

        // leamx
        
        $myTypeMaterial     = $request->material ? $request->material : 0;
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        $myName = "";
        foreach($type_transaction as $key => $value){
            if ($transactions->type_transaction_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_transaction_name = $myName;

        $myName = "";
        foreach($type_coin as $key => $value){
            if ($transactions->type_coin_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_coin_name = $myName;

        $myName = "";
        foreach($wallet as $key => $value){
            if ($transactions->wallet_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->wallet_name = $myName;

        $myName = "";
        foreach($group as $key => $value){
            if ($transactions->group_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        $myName = "";
        foreach($user as $key => $value){
            if ($transactions->user_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        // $myPos              = array_search($transactions->type_transction_id,$type_transaction);
        // $myName             = $type_transactions($myPos);
        // dd($transactions);
        // dd(var_dump($type_transaction));
        // dd('type transaction ->' . $transactions->type_transaction_id . 'myName ->' . $myName);


        $parametros['transactions']     = $transactions;
        $parametros['type_coin']        = $type_coin;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;
        $parametros['user']             = $user;
        $parametros['type_coin']        = $type_coin;
        $parametros['type_material']    = $type_material;

        return view('materials.adquisicion_edit', $parametros);

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function materials_recepcion_edit(Request $request)
    {
        $myId = 0;
        if (isset($request->id)){
            $myId = $request->id;
        }
        $transactions        = Transaction::find($myId);

        
        $type_transaction   = Type_transaction::pluck('name', 'id');

        $wallet             = app(GroupController::class)->getWallets();
        $group              = app(GroupController::class)->getGroups();

        $myTypeMaterial     = $request->material ? $request->material : 0;
        $type_material      = Type_material::pluck('name', 'id')->toArray();

        $myName = "";
        foreach($type_transaction as $key => $value){
            if ($transactions->type_transaction_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->type_transaction_name = $myName;


        $myName = "";
        foreach($wallet as $key => $value){
            if ($transactions->wallet_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->wallet_name = $myName;

        $myName = "";
        foreach($group as $key => $value){
            if ($transactions->group_id == $key){
                $myName = $value;
                break;
            }
        }
        $transactions->group_name = $myName;

        $parametros['transactions']     = $transactions;
        $parametros['type_transaction'] = $type_transaction;
        $parametros['wallet']           = $wallet;
        $parametros['group']            = $group;

        $parametros['type_material']    = $type_material;

        return view('materials.recepcion_edit', $parametros);

    }

    /*
     * 
     * Update the specified resource in storage.
     * 
     */
    public function update(Request $request, $transaction)
    {

        // dd($request->percentage);

        Transaction::find($transaction)->update($request->all());

        $myTransaccion = Transaction::find($transaction);
        $myTransaccion->percentage = $request->percentage;
        $myTransaccion->save();
        // dd($myTransaccion);



        $movimientos = Transaction::findOrFail($transaction);
        $file = [];

        if($request->file('file')){
           foreach($request->file('file') as $files){

              $url = Storage::put('public/Transactions/'.$transaction, $files); 



         if($request->file('file')){

             $file= new Image();
             $file->file = $file;

              $movimientos->image()->create([
                'url' => $url
            ]);

         }

        else{

            $files= new Image();
            $files->file = $files;

            $movimientos->image()->create([
                'url' => $url
            ]);

          }

        }
      }



        return Redirect::route('transactions.index')->with('warning', 'Transacción Modificada <strong># ' . $transaction . '</strong>');
    }
    /*
     * 
     * Update the specified resource in storage.
     * 
     */
    public function update3(Request $request, $transaction)
    {

        // dd($request->percentage);

        Transaction::find($transaction)->update($request->all());

        $myTransaccion = Transaction::find($transaction);
        $myTransaccion->percentage = $request->percentage;
        $myTransaccion->save();
        // dd($myTransaccion);



        $movimientos = Transaction::findOrFail($transaction);
        $file = [];

        if($request->file('file')){
           foreach($request->file('file') as $files){

              $url = Storage::put('public/Transactions/'.$transaction, $files); 



         if($request->file('file')){

             $file= new Image();
             $file->file = $file;

              $movimientos->image()->create([
                'url' => $url
            ]);

         }

        else{

            $files= new Image();
            $files->file = $files;

            $movimientos->image()->create([
                'url' => $url
            ]);

          }

        }
      }



        return Redirect::route('transactions.index3')->with('warning', 'Transacción Modificada <strong># ' . $transaction . '</strong>');
    }

    /*
     * 
     * Update the specified resource in storage.
     * 
     */             
    public function materials_adquisicion_update(Request $request, $transaction)
    {

        // dd($request->percentage);

        Transaction::find($transaction)->update($request->all());

        $myTransaccion = Transaction::find($transaction);
        $myTransaccion->percentage = $request->percentage;
        $myTransaccion->save();
        // dd($myTransaccion);

        return Redirect::route('materials.adquisicion_index')->with('warning', 'Transacción Modificada <strong># ' . $transaction . '</strong>');
    }
    /*
    * 
    * Update the specified resource in storage.
    * 
    */             
    public function materials_recepcion_update(Request $request, $transaction)
    {

        // dd($request->percentage);

        Transaction::find($transaction)->update($request->all());

        $myTransaccion = Transaction::find($transaction);
        $myTransaccion->percentage = $request->percentage;
        $myTransaccion->save();
        // dd($myTransaccion);

        return Redirect::route('materials.recepcion_index')->with('warning', 'Transacción Modificada <strong># ' . $transaction . '</strong>');
    }
   /**
     * Remove the specified resource from storage.
     */


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
         // return response()->json(['success' => true, 'diets' => $diets], 200);
     }

    /**
     * Remove the specified resource from storage.
     */


    public function materials_adquisicion_update_status(Request $request, $transaction)
    {
        \Log::info('leam -  materials_adquisicion_update_status -  $transaction ->' . $transaction);
        $transactions = Transaction::find($transaction);

        if($transactions->status == 'Activo'){
        Transaction::findOrFail($transaction)->update([
            'status' => 'Anulado',
        ]);
           return Redirect::route('materials.adquisicion_index')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
        }
        elseif($transactions->status == 'Anulado'){
            
            Transaction::findOrFail($transaction)->update([
                'status' => 'Activo',
            ]);
            return Redirect::route('materials.adquisicion_index')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
        }
        // return response()->json(['success' => true, 'diets' => $diets], 200);
    }
    /*
     * 
     * Remove the specified resource from storage.
     * 
     */
     public function materials_recepcion_update_status(Request $request, $transaction)
     {
         \Log::info('leam -  materials_recepcion_update_status -  $transaction ->' . $transaction);
         $transactions = Transaction::find($transaction);
 
         if($transactions->status == 'Activo'){
            Transaction::findOrFail($transaction)->update([
                'status' => 'Anulado',
            ]);
            return Redirect::route('materials.recepcion_index')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
         }
         elseif($transactions->status == 'Anulado'){
             
             Transaction::findOrFail($transaction)->update([
                 'status' => 'Activo',
             ]);
             return Redirect::route('materials.recepcion_index')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
         }
         // return response()->json(['success' => true, 'diets' => $diets], 200);
     }
    /**
     * Remove the specified resource from storage.
     */


     public function update_status3(Request $request, $transaction)
     {
         
         $transactions = Transaction::find($transaction);
 
         if($transactions->status == 'Activo'){
         Transaction::findOrFail($transaction)->update([
             'status' => 'Anulado',
         ]);
            return Redirect::route('transactions.index3')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
         }
         elseif($transactions->status == 'Anulado'){
             
             Transaction::findOrFail($transaction)->update([
                 'status' => 'Activo',
             ]);
             return Redirect::route('transactions.index3')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
         }
         // return response()->json(['success' => true, 'diets' => $diets], 200);
     }

    public function update_statusop(Request $request, $transaction)
    {
        
        $transactions = Transaction::find($transaction);
        
        if($transactions->status == 'Activo'){
             Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Anulado']);
            

           return Redirect::route('transactions.index_transferwalletop')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
        }
        elseif($transactions->status == 'Anulado'){
            
             Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Activo']);
            

            return Redirect::route('transactions.index_transferwalletop')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
        }
        // return response()->json(['success' => true, 'diets' => $diets], 200);
    }

    public function update_statusop2(Request $request, $transaction)
    {
        
        $transactions = Transaction::find($transaction);
         
        if($transactions->status == 'Activo'){
            // dd($transactions->transfer_number);
            Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Anulado']);
    
            return Redirect::route('transactions.index_transferwalletop2')->with('info', 'Transacción anulada  <strong># '. $transaction . '</strong>');
        }
        elseif($transactions->status == 'Anulado'){
            
             Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Activo']);
            

            return Redirect::route('transactions.index_transferwalletop2')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
        }
        // return response()->json(['success' => true, 'diets' => $diets], 200);
    }

    public function update_status_api(Request $request, $transaction)
    {
        $transactions = Transaction::find($transaction);

        

        if(is_null($transactions->pay_number)){
            if(is_null($transactions->transfer_number)){
                // anula normal si no es un pago entre proveedor

                if($transactions->status == 'Activo'){
                    
                    Transaction::findOrFail($transaction)->update([
                        'status' => 'Anulado',
                    ]);
                    return response()->json(['success' => true, 'result' => 'anulada', 'message' => 'Transaccion anulada'], 200);
                }
                elseif($transactions->status == 'Anulado'){
                    Transaction::findOrFail($transaction)->update([
                        'status' => 'Activo',
                    ]);
                    return response()->json(['success' => true, 'result' => 'activo', 'message' => 'Transaccion anulada'], 200);
                }
            }else{

                if($transactions->status == 'Activo'){
                
                    Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Anulado']);
    
                    return response()->json(['success' => true, 'result' => 'anulada', 'message' => 'Transaccion anulada'], 200);
                }
                elseif($transactions->status == 'Anulado'){
                    
                    Transaction::where('transfer_number', $transactions->transfer_number)->update(['status' => 'Activo']);
    
                    return response()->json(['success' => true, 'result' => 'activo', 'message' => 'Transaccion anulada'], 200);
                }                
            }
        }else{

            // anula si es un pago de proveedor para poder anular el par

            if($transactions->status == 'Activo'){
                
                Transaction::where('pay_number', $transactions->pay_number)->update(['status' => 'Anulado']);

                return response()->json(['success' => true, 'result' => 'anulada', 'message' => 'Transaccion anulada'], 200);
            }
            elseif($transactions->status == 'Anulado'){
                
                Transaction::where('pay_number', $transactions->pay_number)->update(['status' => 'Activo']);

                return response()->json(['success' => true, 'result' => 'activo', 'message' => 'Transaccion anulada'], 200);
            }          
        }
        // return response()->json(['success' => true, 'result' => 'anulada', 'message' => 'Transaccion anulada'], 200);
    }

    public function destroyImg($transaction){



        $img=Image::whereId($transaction)->first();


        // Busca la imagen en base de datos
        if(!$img){
            return response()
                    ->json(['error'=>'Lo sentimos, la imagen no esta en nuetra base de datos.']);
        }
        // Comprobar imagen en archivos
        if(!Image::exists('/'.$img->url)){
            return response()
                    ->json(['error'=>'Lo sentimos, la imagen no está en la carpeta de transacciones']);
        }

        unlink(storage_path('app\\'.$img->url));



        $img->delete();

        flash()->addError('Imagen eliminada de la transacción numero '. '# '. $transaction, 'Transacción', ['timeOut' => 2000]);

        return true;


    }


        /*
    *
    *
    * get30DayBefore
    * recibe fecha con formato yyyy-mm-dd
    * devuelve dia anterior en formato string yyyy-mm-dd
    *
    */
    function get07DayBefore($myDate){
        $myFecha1 = date($myDate);
        $myFecha2 = date("Y-m-d", strtotime($myFecha1 . "-7 days"));
        return $myFecha2;
    }
    function get03DayBefore($myDate){
        $myFecha1 = date($myDate);
        $myFecha2 = date("Y-m-d", strtotime($myFecha1 . "-3 days"));
        return $myFecha2;
    }
    function get01DayBefore($myDate){
        $myFecha1 = date($myDate);
        $myFecha2 = date("Y-m-d", strtotime($myFecha1 . "-1 days"));
        return $myFecha2;
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

    public function indexAudit(Request $request)
    {

       // dd($request->movimiento);
        $myMovimiento   = $request->movimiento ? $request->movimiento : 0;
        //$myMovimiento   = 22833;
        //$myMovimiento   = 0;
        $transaction  = Transaction::find($myMovimiento);
        
         // if (!$transaction) {
        //     dd('nulo');
        // }
        // dd($transaction);
        $audits= [];
        if ($transaction) {
            $audits = $transaction->audits()->get();
        }
        // dd($myAudit);

        
        // echo "<br>" . $myTransaction->type_transaction->name;
        // echo "<br>" . $myTransaction->wallet->name;
        // echo "<br>" . $myTransaction->group->name;
        // echo "<br>" . $myTransaction->type_coin->name;
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // foreach($audits as $value){
        //     echo "<br>  auditable_id -> "   . $value->auditable_id . "<br>";
        //     echo "<br>  user->name->"       . $value->user->name . "<br>";
        //     echo "<br>  user->name->"       . $value->type_transactions . "<br>";
        //     echo "<br>  event -> " . $value->event . "<br>";
        //     echo "<br>  created_at -> " . $value->created_at . "<br>";
        //     // echo "<br>  con new value -> " . print_r($value->new_values);
        //     foreach($value->new_values as $key => $theValues){
        //         echo "<br> the key ->" . $key . " theValues ->" . $theValues;
        //     }
        // }
        // die();
        
        // $audit = $myTransaction->audits()->first();
        // dd('leam - indexAudit ' . print_r($audit,true));
        // dd('leam - indexAudit ' . print_r($audit->getMetadata(),true));
        // dd('leam - indexAudit ' . print_r($audit->getModified(),true));
        //  dd('leam - indexAudit ' . print_r($myAudit->getModified(),true));
        // Transaction::audits;
        $parametros['transaccion']  = $transaction;
        $parametros['audits']       = $audits;
        $parametros['myMovimiento'] = $myMovimiento;
        
        return view('transactions.transactionAudit', $parametros);


    }

    function getDesTyperAdquisicion($myType){
        switch ($myType){
            case 1:
                return "Kilos";
                break;
            case 2:
                return "Gramos";
                break;
            case 3:
                return "Cantidad";
                break;
            deafult:
                return "";
        }
    }


}
