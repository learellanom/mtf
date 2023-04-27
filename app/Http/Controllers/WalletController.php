<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
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
        //$proveedores = Supplier::all()->pluck('name', 'id');
        $tipo = ['Transacciones', 'Efectivo'];
        return view('wallets.create', compact('users', 'tipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wallets = Wallet::create($request->all());

        if($request->user){
            $wallets->user()->attach($request->user);
            //$wallets->supplier()->attach($request->supplier);
         }
         flash()->addSuccess('Nueva caja registrada', 'Caja', ['timeOut' => 3000]);
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
        //$proveedores = Supplier::all()->pluck('name', 'id');
        $tipo = ['Transacciones', 'Efectivo'];
        return view('wallets.edit', compact('wallet', 'users', 'tipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $wallet)
    {
        $wallets = Wallet::find($wallet)->update($request->all());
        $caja = Wallet::find($wallet);

        if($request->user){
            $wallets = Wallet::find($wallet);
            $wallets->user()->sync($request->user);
            //$wallets->supplier()->sync($request->supplier);
         }

        flash()->addInfo('Wallet modificada del sistema', 'Caja Modifcada: ' . $caja->name, ['timeOut' => 3000]);

        return Redirect::route('wallets.index', $wallets)->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($wallet)
    {
        $caja = Wallet::find($wallet);
        Wallet::destroy($wallet);

        flash()->addError('Wallet eliminada del sistema', 'Caja Eliminada: ' . $caja->name,  ['timeOut' => 2000]);

        return Redirect::route('wallets.index')->with('delete', 'ok');
    }
}
