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
        $user = User::select('users.id', 'users.name', 'model_has_roles.role_id')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('roles.id', 2)
        ->pluck('name', 'id');

        return view('wallets.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Wallet::create($request->all());

        return redirect('wallets.index');
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
        $user = User::pluck('name', 'id');
        return view('wallets.edit', compact('wallet', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $wallet)
    {
        Wallet::findOrFail($wallet)->update($request->all());
        return Redirect::route('wallets.index')->with('update', 'ok');
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