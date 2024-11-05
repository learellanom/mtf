<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Type_transaction_requests;

class Type_transaction_requestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Type_transaction_requests = Type_transaction_requests::all();
        return view('type_transaction_requests.index', compact('Type_transaction_requests'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('type_transaction_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Type_transaction_requests::create($request->all());

        flash()->addSuccess('Nuevo Tipo de Solicitud creada con exito.', 'Tipo de Solicitud', ['timeOut' => 3000]);

        return Redirect::route('type_transaction_requests.index');
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
        $Type_transaction_requests = Type_transaction_requests::find($id);
        

        return view('type_transaction_requests.edit', compact('Type_transaction_requests'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $Type_transaction_requests = Type_material::find($$id);
        $Type_transaction_requests->update($request->all());
        flash()->addInfo('Tipo de Solicitud modificada..', 'Tipo de solicitud', ['timeOut' => 3000]);
        return Redirect::route('type_transaction_requests.index');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $Type_transaction_requests = Type_material::find($id);
        
        $Type_transaction_requests->delete();

        flash()->addError('Tipo de Solicitud', 'Tipo de Solicitud Eliminada: ' . $Type_transaction_requests->name,  ['timeOut' => 2000]);
        return Redirect::route('type_transaction_requests.index');    
            
    }
}
