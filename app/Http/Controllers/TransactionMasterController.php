<?php

namespace App\Http\Controllers;

use App\Models\Transaction_master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferencia = Transaction_master::all();
        return view('transactions_master.index', compact('transferencia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction_master $transaction_master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction_master $transaction_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction_master $transaction_master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction_master $transaction_master)
    {
        //
    }
}
