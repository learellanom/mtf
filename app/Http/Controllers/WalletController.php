<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

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
        return view('wallets.create');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
