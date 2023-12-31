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
use Carbon\Carbon;



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

        $user           = User::pluck('name', 'id')->toArray();

        $parametros['fechaDesde']       = $myFechaDesde2;
        $parametros['fechaHasta']       = $myFechaHasta2;
        $parametros['transferencia']    = $transferencia;
        $parametros['myUser']           = $myUser;
        $parametros['user']             = $user;

        // dd($transferencia);

        return view('transactions.index', $parametros);

    }

    public function credit(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('id', ['6','7','8','12'])->pluck('name', 'id');

        $wallet             = Group::where('type','=','2')->pluck('name', 'id');
        $group              = Group::where('type','=','1')->pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.credit', compact('type_coin', 'type_transaction', 'wallet', 'group', 'fecha', 'user', 'transaction'));

    }

    public function credit_edit($transaction)
    {

        $transactions       = Transaction::find($transaction);

        $imagen             = Transaction::findOrFail($transaction)->image;

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $wallet             = Group::where('type','=','2')->whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group              = Group::where('type','=','1')->pluck('name', 'id');
        $user               = User::pluck('name', 'id');

        return view('transactions.credit_edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));

    }

     /**
     * Show the form for creating a new resource.
     */
    public function create(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=',2)->pluck('name', 'id');
        $group              = Group::whereIn('type', [1])->pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        if (auth()->id() == 99){
            return view('transactions.create2', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
            
        }
        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }

    
     /**
     * Show the form for creating a new resource.
     */
    public function create2(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=',2)->pluck('name', 'id');
        $group              = Group::whereIn('type', [1])->pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create2', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }


    public function create_efectivo(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');
        $wallet             = Group::where('type','=','2')->whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group              = Group::where('type','=','1')->pluck('name', 'id');
        //$client = Client::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create_efectivo', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user','fecha','transaction'));
    }

    public function edit_efectivo($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;


        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');
        $wallet             = Group::pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
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


    public function index_transferwallet(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
                $transactiones = DB::select("
                    select
                        mtf.transactions.id as TransactionId,
                        transfer_number as TransferNumber,
                        IF(type_transactions.name = 'Nota de Credito a Caja de efectivo', 'Destino', 'Origen') as TransferType,
                        wallet_id as WalletIdOrigen,
                        groups.name as WalletNameOrigen,
                        amount_total as Amount,
                        transaction_date as TransactionDate,
                        users.name as Agente,
                        status as estatus,
                        type_transaction_id as TypeTransactionId,
                        transactions.description as Description,
                        type_transactions.name as TypeTransactionName
                    from mtf.transactions
                    left join  mtf.groups on mtf.transactions.wallet_id = groups.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where transfer_number between '00000000000000000' and '99999999999999999'
                    order by transfer_number, TransferType desc");

         }


         return view('transactions.index_transferwallet', compact('transactiones'));

    }

    
    public function index_transferwalletop(transaction $transaction)
    {

        // if(auth()->user()->id != 2){
        //     return Redirect::route('home');
        // }

        foreach(auth()->user()->roles as $roles)
        {
            $transactiones = DB::select("
                select
                    mtf.transactions.id as TransactionId,
                    transfer_number             as TransferNumber,
                    IF(
                        type_transactions.name = 'Nota de Credito a Caja de efectivo' 
                    or  type_transactions.name = 'Nota de credito', 'Destino', 'Origen'
                    ) as TransferType,                        
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
                order by transfer_number, TransferType desc");

        }


         return view('transactions.index_transferwalletop', compact('transactiones'));

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
                where pay_number LIKE '%P-G' != ''
                and user_id between $myUsuarioDesde and $myUsuarioHasta
                and mtf.transactions.created_at between '$myFechaDesde 00:00:00' and '$myFechaHasta 23:59:59'
                order by pay_number desc
                $limit
                ";

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
        $type_transaction2  = Type_transaction::whereIn('id', [6])->pluck('id');    // 6 ENtrada de efectivo o nota de credito

        $wallet             = Group::whereIn('type_wallet', ['Efectivo'])->where('type','=','2')->pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();


        return view('transactions.create_transferwallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'user', 'transaction', 'fecha'));
    }


    public function transfer_wallet(Request $request)
    {
        $user = Auth::id();
        $transaction = new Transaction;

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

        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();




        return view('transactions.create_pagowallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));
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

        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create_transferwalletop', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));
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
        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
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
        $user = Auth::id();
        $transactions = new Transaction;

        
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
        $transactions->amount_commission_base   = $request->input('amount_commission_base');
        $transactions->percentage_base          = $request->input('percentage_base');
        $transactions->exonerate_base           = $request->input('exonerate_base');
        $transactions->amount_base              = $request->input('amount');
        $transactions->amount_total_base        = $request->input('amount_total_base');
        $transactions->user_id                  = $user;
        $transactions->transfer_number           = $number_referencia;
        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id     = $request->input('type_transaction2_id');
        $transactions2->wallet_id               = $request->input('wallet2_id');
        $transactions2->group_id                = $request->input('wallet_id');
        $transactions2->amount                  = $request->input('amount');
        $transactions2->amount_total            = $request->input('amount_total');
        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');

        $transactions2->token                   = $request->input('token');
        $transactions2->amount_base             = $request->input('amount');
        $transactions2->amount_total_base       = $request->input('amount');
        $transactions2->user_id                 = $user;
        $transactions2->transfer_number       = $number_referencia;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         return Redirect::back()->withInput();

         // return Redirect::back()->withInput();

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
        $wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id')->toArray();
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

    public function index_pagoclientes(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
                $transactiones = DB::select('select
                    mtf.transactions.id             as TransactionId,
                    pay_number                      as TransferNumber,
                    IF(type_transactions.name = "Pago Efectivo", "Destino", "Origen") as TransferType,
                    wallet_id                       as WalletIdOrigen,
                    groups2.name                    as WalletNameOrigen,
                    group_id                        as GroupIdOrigen,
                    groups.name                     as GroupNameOrigen,
                    amount_total                    as Amount,
                    transaction_date                as TransactionDate,
                    users.name                      as Agente,
                    status                          as estatus,
                    type_transaction_id             as TypeTransactionId,
                    transactions.description        as Description,
                    type_transactions.name          as TypeTransactionName,
                    transactions.amount_commission  as ComisionBase,
                    transactions.percentage         as PorcentageBase,
                    transactions.exonerate          as ExonerateBase,
                    transactions.amount_total       as TotalBase
                    from mtf.transactions
                    left join  mtf.groups  as groups2   on mtf.transactions.wallet_id = groups2.id
                    left join  mtf.groups               on mtf.transactions.group_id  = groups.id
                    left join  mtf.type_transactions    on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users                on mtf.transactions.user_id  = mtf.users.id
                    where pay_number LIKE "%T-C" != "" order by pay_number desc');

         }


         return view('transactions.index_pagoclientes', compact('transactiones'));

    }

    public function create_pagoclientes(transaction $transaction)
    {

        $type_coin                              = Type_coin::pluck('name', 'id');

        $type_transaction                       = Type_transaction::whereIn('name', ['Cobro en efectivo'])->pluck('id');
        $type_transaction2                      = Type_transaction::whereIn('name', ['Pago Efectivo'])->pluck('id');

        $wallet                                 = Group::where('type','=','2')->whereIn('name', ['Caja Puente'])->pluck('id');
        $group                                  = Group::where('type','=','1')->pluck('name', 'id');
        $group2                                 = Group::where('type','=','1')->pluck('name', 'id');
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
        $transactions->amount                       = $request->input('amount');
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
        $user           = Auth::id();
        $transactions   = new Transaction;
        $number         = date('YmdHis'). rand(100,200). 'T-C';

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
        $transactions->group_id                     = $request->input('group_id');
        $transactions->wallet_id                    = $request->input('wallet_id');
        $transactions->amount                       = $request->input('amount');
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

        $transactions2->type_transaction_id         = $request->input('type_transaction_id2');
        $transactions2->group_id                    = $request->input('group2_id');
        $transactions2->wallet_id                   = $request->input('wallet2_id');
        $transactions2->amount                      = $request->input('amount');
        $transactions2->amount_total_base           = $request->input('amount');
        $transactions2->amount_base                 = $request->input('amount');
        $transactions2->transaction_date            = $request->input('transaction_date');
        $transactions2->description                 = $request->input('description2');
        $transactions2->pay_number                  = $number;
        $transactions2->amount_commission           = $request->input('commission2');
        $transactions2->percentage                  = $request->input('percentage2');
        $transactions2->exonerate                   = $request->input('exonerate2');
        $transactions2->amount_total                = $request->input('amount_total2');
        $transactions2->amount_commission_profit     = $request->input('amount_commission_profit2');        
        $transactions2->user_id                     = $user;

        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción entre clientes :D', ['timeOut' => 3000]);

         return Redirect::back()->withInput();
    }
    public function index_cobrowallet(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
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
                    where pay_number LIKE "%C-G" != "" order by pay_number desc');

         }


         return view('transactions.index_cobrowallet', compact('transactiones'));

    }

    public function create_cobrowallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Cobro en efectivo', 'Cobro en Transferencia', 'Cobro Mercancia'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Debito a Caja de Efectivo', 'Nota de debito'])->pluck('name','id');
        $wallet             = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id');
        $wallet2            = Group::whereIn('type_wallet', ['transacciones', 'efectivo'])->where('type','=','2')->pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        //$number = date('YmdHis').'C-G';


        return view('transactions.create_cobrowallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));
    }

    public function store_cobrowallet(Request $request)
    {


        // 02-10-2023 se desincorpora el cobrod e la comision base  para nmo descuadrar el commission profit

        $user = Auth::id();
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
        $transactions->amount_total_base        = $request->input('amount_total_base');
        // $transactions->amount_commission_profit = $request->input('amount_commission_profit');
        $transactions->user_id                  = $user;

        $transactions->save();



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
        $wallet             = Group::where('type','=','2')->pluck('name', 'id');
        $group              = Group::where('type','=','1')->pluck('name', 'id');
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
        return view('transactions.edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
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
        $wallet             = Group::where('type','=','2')->pluck('name', 'id');
        $group              = Group::where('type','=','1')->pluck('name', 'id');
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



        // $myPos              = array_search($transactions->type_transction_id,$type_transaction);
        // $myName             = $type_transactions($myPos);
        // dd($transactions);
        // dd(var_dump($type_transaction));
        // dd('type transaction ->' . $transactions->type_transaction_id . 'myName ->' . $myName);
        return view('transactions.edit2', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $transaction)
    {

       //  dd($request->all());

        Transaction::find($transaction)->update($request->all());

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
        $parametros['transaccion'] = $transaction;
        $parametros['audits'] = $audits;
        $parametros['myMovimiento'] = $myMovimiento;
        return view('transactions.transactionAudit', $parametros);


    }
}
