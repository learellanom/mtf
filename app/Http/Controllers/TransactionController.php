<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
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
                $transferencia = Transaction::all();
            }
            else{
                $transferencia = Transaction::where('user_id', '=', auth()->id())->get();
            }

         }




         return view('transactions.index', compact('transferencia'));

    }

    public function credit(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('id', ['6','7','8','12'])->pluck('name', 'id');
        // $wallet             = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        // $wallet             = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $wallet             = Wallet::pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
        $user               = User::pluck('name', 'id');

        return view('transactions.credit', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction'));

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
    /*
    *
    *
    * transferWallet
    * 23-05-2023
    *
    *
    */

    public function create_transferwallet(transaction $transaction)
    {

        $type_coin          = Type_coin::pluck('name', 'id');
        $type_transaction   = Type_transaction::whereIn('id', ['8','9'])->pluck('name', 'id');
        $wallet             = Wallet::pluck('name', 'id');
        $group              = Group::pluck('name', 'id');
        $user               = User::pluck('name', 'id');
        $fecha              = Carbon::now();

        $number_referencia  = Carbon::now();




        return view('transactions.create_transferwallet', compact('type_coin', 'type_transaction', 'number_referencia', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }


    public function transfer_wallet(Request $request)
    {
        $user = Auth::id();
        $transaction = new Transaction;

        $transaction->type_transaction_id   = $request->input('type_transaction_id');
        $transaction->wallet_id             = $request->input('wallet_id');
        $transaction->amount                = $request->input('amount');
        $transaction->amount_total          = $request->input('amount_total');
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
        $transaction2->transaction_date      = $request->input('transaction_date');
        $transaction2->description           = $request->input('description');
        $transaction2->user_id               = $user;
        $transaction2->transfer_number        = $request->input('transfer_number');

        $transaction2->save();



        flash()->addSuccess('Movimiento guardado', 'Transacción', ['timeOut' => 3000]);

         return Redirect::route('transactions.index');

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
        if($transactions->group == null){
            return view('transactions.show', compact('transactions'));
        }
        else{

            $transactiones = Transaction::whereIn('group_id', [$transactions->group->id])->whereNotIn('id', [$transaction])->latest('id')->paginate(3);
            return view('transactions.show', compact('transactions', 'transactiones'));
        }

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
