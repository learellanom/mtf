<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::all();

        return view('wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->pluck('name', 'id');

        return view('wallets.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wallets = Wallet::create($request->all());

        if($request->user){
            $wallets->user()->attach($request->user);
         }

         return Redirect::route('wallets.index', $wallets);
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
    public function edit($wallet)
    {
        $wallet = Wallet::find($wallet);
        $users = User::all()->pluck('name', 'id');
        return view('wallets.edit', compact('wallet', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $wallet)
    {
        $wallets = Wallet::find($wallet)->update($request->all());

        if($request->user){
            $wallets = Wallet::find($wallet);
            $wallets->user()->sync($request->user);
         }

        return Redirect::route('wallets.index', $wallets)->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($wallet)
    {
        Wallet::destroy($wallet);
        return Redirect::route('wallets.index')->with('delete', 'ok');
    }
}
