<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Client;
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

     /**
     * Show the form for creating a new resource.
     */
    public function create(transaction $transaction)
    {

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $client = Client::pluck('name', 'id');
        $user = User::pluck('name', 'id');
        //$transaction = Transaction::find('all');
        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'client', 'user', 'transaction'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

       /*  $realname = str_slug(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $request->file('file')->getClientOriginalExtension();
        $new_name = $realname."-".time().".".$extension;
        $request->file('file')->move(public_path('uploads/'.str_slug($new_name))); */


        $transaction = Transaction::create($request->all());
        $files = [];
       if($request->hasFile('file')){
        foreach($request->file('file') as $file)
        {
            $url = Storage::put($request->id, $file);

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
        $client = Client::select('clients.id', 'clients.name', )
        ->where('user_id', auth()->id())->pluck('name', 'id');



        $user = User::pluck('name', 'id');



        return view('transactions.edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'client', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $transaction)
    {
        $transaction = Transaction::find($transaction)->update($request->all());
        $files = [];

        if($request->file('file')){
            $transaction = Transaction::find($transaction);

            $url = Storage::put('transactions', $request->file('file'));

            if($transaction->image){
                foreach($transaction->image as $imagen){
                  Storage::delete($imagen->url);

                  $files= new Image();
                  $files->file = $files;

                  $transaction->image()->update([
                  'url' => $url
                 ]);
                }
             }
          else{
            $transaction->image()->create([
                'url' => $url
            ]);
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
        $transactions = Transaction::find($transaction);

        $url = Storage::delete($transaction);
        $transactions->image()->delete($url);

        return true;


    }

}
