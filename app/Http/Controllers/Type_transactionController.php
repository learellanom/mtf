<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type_transaction;
use Illuminate\Support\Facades\Redirect;

class Type_transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Type_transaction::all();
        return view('type_transactions.index', compact('transactions'))->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type_transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Type_transaction::create($request->all());

        flash()->addSuccess('Nuevo Tipo transacción creado con exito.', 'Tipo de Transacción', ['timeOut' => 3000]);

        return Redirect::route('type_transactions.index');
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
    public function edit($type_transaction)
    {
        $transactions = Type_transaction::find($type_transaction);

        return view('type_transactions.edit', compact('transactions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $type_transaction)
    {
        Type_transaction::findOrFail($type_transaction)->update($request->all());

        flash()->addInfo('Tipo de transacción modificado..', 'Tipo de transacción', ['timeOut' => 3000]);
        return Redirect::route('type_transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type_transaction)
    {
        $type_transactions = Type_transaction::find($type_transaction);
        $type_transactions->delete();

        flash()->addError('Tipo de transacción', 'Tipo de transacción eliminado: ' . $type_transactions->name,  ['timeOut' => 2000]);
        return Redirect::route('type_transactions.index');
    }
}
