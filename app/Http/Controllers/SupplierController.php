<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedor = Supplier::all();

        return view('suppliers.index', compact('proveedor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Supplier::create($request->all());

         return Redirect::route('suppliers.index')->with('success', 'Nuevo proveedor registrado');
    }


        /**
     * Display the specified resource.
     */
    public function show($transaction)
    {
 
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($supplier)
    {
        $proveedor = Supplier::find($supplier);
        return view('suppliers.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $supplier)
    {
        $proveedor = Supplier::find($supplier);

        $proveedor->update($request->all());

        flash()->addInfo('Proveedor modificado con exito.', 'Proveedor: '. $proveedor->name, ['timeOut' => 3000]);
        return Redirect::route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($supplier)
    {
        $proveedor = Supplier::find($supplier);

        $proveedor->delete();

        flash()->addError('Proveedor elimando con exito.', 'Proveedor: ' . $proveedor->name,  ['timeOut' => 2000]);
        return Redirect::route('suppliers.index');
    }
}
