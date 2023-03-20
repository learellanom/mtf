<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

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
    public function create()
    {
        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $client = Client::pluck('name', 'id');
        $user = User::pluck('name', 'id');

        return view('transactions.create', compact('type_coin', 'type_transaction', 'wallet', 'client', 'user'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Transaction::create($request->all());

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
        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $client = Client::select('clients.id', 'clients.name', )
        ->where('user_id', auth()->id())->pluck('name', 'id');



        $user = User::pluck('name', 'id');



        return view('transactions.edit', compact('transactions','type_coin', 'type_transaction', 'wallet', 'client', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $transaction)
    {
        Transaction::findOrFail($transaction)->update($request->all());
        return Redirect::route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($transaction)
    {
        $transactions = Transaction::find($transaction);
        $transactions->delete();

        return Redirect::route('transactions.index');
    }

}
