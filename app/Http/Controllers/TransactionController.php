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
    public function index(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
            if($roles->name == 'Administrador' || $roles->name == 'Supervisor'){
                $transferencia = Transaction::whereNull(['transfer_number','pay_number'])->get();
            }
            else{
                $transferencia = Transaction::whereNull(['transfer_number','pay_number'])->where('user_id', '=', auth()->id())->get();
            }

         }


         return view('transactions.index', compact('transferencia'));

    }

    public function credit(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('id', ['6','7','8','12'])->pluck('name', 'id');

        $wallet             = Wallet::pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
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
        $wallet             = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
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
        $wallet             = Wallet::whereIn('type_wallet', ['transacciones'])->whereNotIn('id', [3])->pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }

    public function create_efectivo(transaction $transaction)
    {

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');
        $wallet = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        //$client = Client::pluck('name', 'id');
        $user = User::pluck('name', 'id');
        $fecha = Carbon::now();

        return view('transactions.create_efectivo', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user','fecha','transaction'));
    }

    public function edit_efectivo($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;


        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Efectivo'])->pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');



        return view('transactions.edit_efectivo', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
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

        flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

        return Redirect::route('transactions.index');


    }


    public function index_transferwallet(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
                $transactiones = DB::select('select
                mtf.transactions.id as TransactionId,
                    transfer_number as TransferNumber,
                IF(type_transactions.name = "Nota de Credito a Caja de efectivo", "Destino", "Origen") as TransferType,
                    wallet_id as WalletIdOrigen,
                    wallets.name as WalletNameOrigen,
                    amount_total as Amount,
                    transaction_date as TransactionDate,
                    users.name as Agente,
                    status as estatus,
                    type_transaction_id as TypeTransactionId,
                    transactions.description as Description,
                    type_transactions.name as TypeTransactionName
                    from mtf.transactions
                    left join  mtf.wallets on mtf.transactions.wallet_id = wallets.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where transfer_number != "" order by transfer_number, TransferType desc');

         }


         return view('transactions.index_transferwallet', compact('transactiones'));

    }

    public function index_pagowallet(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
                $transactiones = DB::select('select
                mtf.transactions.id as TransactionId,
                    pay_number as TransferNumber,
                IF(type_transactions.name = "Nota de Credito a Caja de efectivo" or type_transactions.name = "Nota de credito", "Destino", "Origen") as TransferType,
                    wallet_id as WalletIdOrigen,
                    wallets.name as WalletNameOrigen,
                    amount_total as Amount,
                    transaction_date as TransactionDate,
                    users.name as Agente,
                    status as estatus,
                    type_transaction_id as TypeTransactionId,
                    transactions.description as Description,
                    type_transactions.name as TypeTransactionName,
                    transactions.amount_commission_base as ComisionBase,
                    transactions.percentage_base as PorcentageBase,
                    transactions.exonerate_base as ExonerateBase,
                    transactions.amount_total_base as TotalBase
                    from mtf.transactions
                    left join  mtf.wallets on mtf.transactions.wallet_id = wallets.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where pay_number LIKE "%P-G" != "" order by pay_number desc');

         }

         return view('transactions.index_pagowallet', compact('transactiones'));

    }






    public function create_transferwallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Nota de Debito a Caja de Efectivo'])->pluck('id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo'])->pluck('id');
        $wallet             = Wallet::whereIn('type_wallet', ['Efectivo'])->pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();


        $number_referencia = date('YmdHis');


        return view('transactions.create_transferwallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'number_referencia', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }


    public function transfer_wallet(Request $request)
    {
        $user = Auth::id();
        $transaction = new Transaction;

        $transaction->type_transaction_id   = $request->input('type_transaction_id');
        $transaction->wallet_id             = $request->input('wallet_id');
        $transaction->amount                = $request->input('amount');
        $transaction->amount_total          = $request->input('amount_total');
        $transaction->amount_total_base     = $request->input('amount_total_base');
        $transaction->transaction_date      = $request->input('transaction_date');
        $transaction->description           = $request->input('description');
        $transaction->user_id               = $user;
        $transaction->transfer_number       = $request->input('transfer_number');

        $transaction->save();



        $transaction2 = new Transaction;

        $transaction2->type_transaction_id   = $request->input('type_transaction2_id');
        $transaction2->wallet_id             = $request->input('wallet2_id');
        $transaction2->amount                = $request->input('amount');
        $transaction2->amount_total          = $request->input('amount_total');
        $transaction2->amount_total_base     = $request->input('amount_total_base');
        $transaction2->transaction_date      = $request->input('transaction_date');
        $transaction2->description           = $request->input('description');
        $transaction2->user_id               = $user;
        $transaction2->transfer_number       = $request->input('transfer_number');

        $transaction2->save();

        flash()->addSuccess('Transferencia a caja guardado', 'Transacción', ['timeOut' => 3000]);

         return Redirect::route('transactions.index_transferwallet');

    }

    public function create_pagowallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Pago Efectivo', 'Pago en Transferencia', 'Pago Mercancia','Pago USDT','Swift'])->pluck('name','id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Nota de Credito a Caja de efectivo', 'Nota de credito'])->pluck('name','id');
        $wallet             = Wallet::pluck('name', 'id');
        $wallet2            = Wallet::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $number = date('YmdHis').'P-G';


        return view('transactions.create_pagowallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'number', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));
    }

    public function store_pagowallet(Request $request)
    {
        $user = Auth::id();
        $transactions = new Transaction;

        $transactions->type_transaction_id      = $request->input('type_transaction_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->amount                   = $request->input('amount');
        $transactions->amount_total             = $request->input('amount_total');
        $transactions->transaction_date         = $request->input('transaction_date');
        $transactions->description              = $request->input('description');
        $transactions->pay_number               = $request->input('pay_number');
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
        $transactions2->amount                  = $request->input('amount');
        $transactions2->amount_total            = $request->input('amount_total');
        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');
        $transactions2->pay_number              = $request->input('pay_number');
        $transactions2->amount_commission_base  = $request->input('amount_commission_base');
        $transactions2->percentage_base         = $request->input('percentage_base');
        $transactions2->exonerate_base          = $request->input('exonerate_base');
        $transactions2->amount_base             = $request->input('amount');
        $transactions2->amount_total_base       = $request->input('amount_total_base');
        $transactions2->user_id                 = $user;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         return Redirect::route('transactions.index_pagowallet');
    }

    public function index_pagoclientes(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
                $transactiones = DB::select('select
                mtf.transactions.id as TransactionId,
                    pay_number as TransferNumber,
                IF(type_transactions.name = "Pago Efectivo", "Destino", "Origen") as TransferType,
                    wallet_id as WalletIdOrigen,
                    wallets.name as WalletNameOrigen,
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
                    left join  mtf.wallets on mtf.transactions.wallet_id = wallets.id
                    left join  mtf.groups on mtf.transactions.group_id = groups.id
                    left join  mtf.type_transactions on mtf.transactions.type_transaction_id  = mtf.type_transactions.id
                    left join  mtf.users on mtf.transactions.user_id  = mtf.users.id
                    where pay_number LIKE "%T-C" != "" order by pay_number desc');

         }


         return view('transactions.index_pagoclientes', compact('transactiones'));

    }

    public function create_pagoclientes(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('name', ['Cobro en efectivo'])->pluck('id');
        $type_transaction2  = Type_transaction::whereIn('name', ['Pago Efectivo'])->pluck('id');
        $wallet             = Wallet::whereIn('name', ['Caja Puente'])->pluck('id');
        $group              = Group::pluck('name', 'id');
        $group2             = Group::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $number = date('YmdHis').'T-C';


        return view('transactions.create_pagocliente', compact('type_coin', 'type_transaction', 'wallet', 'type_transaction2', 'number', 'group', 'group2', 'user', 'transaction', 'fecha'));
    }

    public function store_pagocliente(Request $request)
    {
        $user = Auth::id();
        $transactions = new Transaction;

        $transactions->type_transaction_id   = $request->input('type_transaction_id');
        $transactions->group_id              = $request->input('group_id');
        $transactions->wallet_id             = $request->input('wallet_id');
        $transactions->amount                = $request->input('amount');
        $transactions->amount_total_base     = $request->input('amount');
        $transactions->amount_base           = $request->input('amount');
        $transactions->transaction_date      = $request->input('transaction_date');
        $transactions->description           = $request->input('description');
        $transactions->pay_number            = $request->input('pay_number');
        $transactions->amount_commission     = $request->input('commission');
        $transactions->percentage            = $request->input('percentage');
        $transactions->exonerate             = $request->input('exonerate');
        $transactions->amount_total          = $request->input('amount_total');
        $transactions->user_id               = $user;

        $transactions->save();



        $transactions2 = new Transaction;

        $transactions2->type_transaction_id   = $request->input('type_transaction2_id');
        $transactions2->group_id              = $request->input('group2_id');
        $transactions2->wallet_id             = $request->input('wallet2_id');
        $transactions2->amount                = $request->input('amount');
        $transactions2->amount_total_base     = $request->input('amount');
        $transactions2->amount_base           = $request->input('amount');
        $transactions2->transaction_date      = $request->input('transaction_date');
        $transactions2->description           = $request->input('description2');
        $transactions2->pay_number            = $request->input('pay_number');
        $transactions2->amount_commission     = 0;
        $transactions2->percentage            = 0;
        $transactions2->exonerate             = 2;
        $transactions2->amount_total          = $request->input('amount');
        $transactions2->user_id               = $user;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Transacción entre clientes :D', ['timeOut' => 3000]);

         return Redirect::route('transactions.index_pagoclientes');
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
                    wallets.name as WalletNameOrigen,
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
                    left join  mtf.wallets on mtf.transactions.wallet_id = wallets.id
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
        $wallet             = Wallet::pluck('name', 'id');
        $wallet2            = Wallet::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $number = date('YmdHis').'C-G';


        return view('transactions.create_cobrowallet', compact('type_coin', 'type_transaction', 'type_transaction2', 'number', 'wallet', 'wallet2', 'user', 'transaction', 'fecha'));
    }

    public function store_cobrowallet(Request $request)
    {
        $user = Auth::id();
        $transactions = new Transaction;

        $transactions->type_transaction_id      = $request->input('type_transaction_id');
        $transactions->wallet_id                = $request->input('wallet_id');
        $transactions->amount                   = $request->input('amount');
        $transactions->amount_total             = $request->input('amount_total');
        $transactions->transaction_date         = $request->input('transaction_date');
        $transactions->description              = $request->input('description');
        $transactions->pay_number               = $request->input('pay_number');
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
        $transactions2->amount                  = $request->input('amount');
        $transactions2->amount_total            = $request->input('amount_total');
        $transactions2->transaction_date        = $request->input('transaction_date');
        $transactions2->description             = $request->input('description2');
        $transactions2->pay_number              = $request->input('pay_number');
        $transactions2->amount_commission_base  = $request->input('amount_commission_base');
        $transactions2->percentage_base         = $request->input('percentage_base');
        $transactions2->exonerate_base          = $request->input('exonerate_base');
        $transactions2->amount_base             = $request->input('amount');
        $transactions2->amount_total_base       = $request->input('amount_total_base');
        $transactions2->user_id                 = $user;
        $transactions2->save();

         flash()->addSuccess('Movimiento guardado', 'Cobro entre proveedores :D', ['timeOut' => 3000]);

         return Redirect::route('transactions.index_cobrowallet');
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

        flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

        return Redirect::route('transactions.create_efectivo');


    }

    /**
     * Display the specified resource.
     */
    public function show($transaction)
    {
            $transactions = Transaction::find($transaction);

            return view('transactions.show', compact('transactions'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;


        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet =  Wallet::whereIn('type_wallet', ['transacciones'])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');



        $user = User::pluck('name', 'id');



        return view('transactions.edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $transaction)
    {
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

        flash()->addInfo('Transacción modificada..', 'Transacción <strong># ' . $transaction . '</strong>', ['timeOut' => 3000]);

        return Redirect::route('transactions.index');
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
           return Redirect::route('transactions.index')->with('error', 'Transacción anulada  <strong># '. $transaction . '</strong>');
        }
        elseif($transactions->status == 'Anulado'){
            Transaction::findOrFail($transaction)->update([
                'status' => 'Activo',
            ]);
            return Redirect::route('transactions.index')->with('success', 'Transacción activada  <strong># '. $transaction . '</strong>');
        }

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

}
