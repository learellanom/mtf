<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Client;
use App\Models\Group;
use App\Models\Image;
use App\Models\User;
use Database\Factories\TransactionFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Nette\Utils\Finder;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferencia = Transaction::all();

        return view('transactions.index', compact('transferencia'));
    }

    public function credit(transaction $transaction)
    {

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereId(5);
        $wallet = Wallet::pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');

        return view('transactions.credit', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction'));
    }

    public function credit_edit($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
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
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');
        //$transaction = Transaction::find('all');
        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction'));
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

            $url = Storage::put('transactions/'.$transaction->id, $file);

            $files= new Image();
            $files->file = $files;


            $transaction->image()->create([
                'url' => $url
            ]);
            //return response()->json(['url' => $url]);
          }
        }
        return Redirect::route('transactions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($transaction)
    {

        $transactions = Transaction::find($transaction);

        $imagen = Transaction::findOrFail($transaction)->image;
        //$image = $transactions->image()->find($transactions);
        //$image = Transaction::find($transactions)

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
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
              $url = Storage::put('transactions/'.$transaction, $files);



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
        return Redirect::route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($transaction)
    {
        $transactions = Transaction::find($transaction);


        $url = Storage::delete($transaction);
        $transactions->delete();

        $transactions->image()->delete($url);



        return Redirect::route('transactions.index');
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


        return true;


    }

}
