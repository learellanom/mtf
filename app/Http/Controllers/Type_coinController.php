<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type_coin;
use Illuminate\Support\Facades\Redirect;

class Type_coinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types_coin = Type_coin::all();
        return view('type_coins.index', compact('types_coin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type_coins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Type_coin::create($request->all());

        flash()->addSuccess('Nuevo Tipo moneda creado con exito.', 'Tipo de Moneda', ['timeOut' => 3000]);

        return Redirect::route('type_coins.index');
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
    public function edit($type_coin)
    {
        $type_coin = Type_coin::find($type_coin);
        return view('type_coins.edit', compact('type_coin'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, type_coin $type_coin)
    {
        $type_coin->update($request->all());
        flash()->addInfo('Tipo de moneda modificado..', 'Tipo de moneda', ['timeOut' => 3000]);
        return Redirect::route('type_coins.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type_coin)
    {
        $type_coin = Type_coin::find($type_coin);

        $type_coin->delete();

        flash()->addError('Tipo de moneda', 'Tipo de moneda Eliminado: ' . $type_coin->name,  ['timeOut' => 2000]);
        return Redirect::route('type_coins.index');
    }
}
