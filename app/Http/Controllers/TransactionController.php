<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Group;
use App\Models\Client;
use App\Models\Image;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Factories\TransactionFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Nette\Utils\Finder;
use Carbon\Carbon;
use Symfony\Component\VarDumper\Caster\TraceStub;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(transaction $transaction)
    {
         foreach(auth()->user()->roles as $roles)
         {
            if($roles->id == 1 || $roles->id == 3){
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

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('name', ['Nota de credito'])->pluck('name', 'id');
        $wallet = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');


        return view('transactions.credit', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction'));

    }

    public function credit_edit($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Credito'])->pluck('name', 'id');
        $wallet = Wallet::whereIn('type_wallet', ['efectivo'])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');



        $user = User::pluck('name', 'id');



        return view('transactions.credit_edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create(transaction $transaction)
    {

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Transacciones'])->pluck('name', 'id');
        $wallet =  Wallet::whereIn('type_wallet', ['transacciones'])->whereNotIn('id', [3])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');
        $fecha = Carbon::now();

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

            $transactiones = Transaction::whereIn('group_id', [$transactions->group->id])->paginate(3)->sortBy('transaction_date');
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
