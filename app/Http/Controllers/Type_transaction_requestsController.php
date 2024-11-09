<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Type_transaction_request;


class Type_transaction_requestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $Type_transaction_requests = Type_transaction_request::all();
        
        $Type_transaction_requests = Type_transaction_request::where('type_request','=','1')->get();
        // dd($Type_transaction_requests);
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
        Type_transaction_request::create($request->all());

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
        $Type_transaction_requests = Type_transaction_request::find($id);
        

        return view('type_transaction_requests.edit', compact('Type_transaction_requests'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $Type_transaction_requests = Type_transaction_request::find($id);
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
        $Type_transaction_requests = Type_transaction_request::find($id);
        
        $Type_transaction_requests->delete();

        flash()->addError('Tipo de Solicitud', 'Tipo de Solicitud Eliminada: ' . $Type_transaction_requests->name,  ['timeOut' => 2000]);
        return Redirect::route('type_transaction_requests.index');    

    }




    /**
     * Display a listing of the resource.
     */
    public function indexNotificacion()
    {
        //
        // $Type_transaction_requests = Type_transaction_request::all();
        
        $Type_transaction_requests_notificacion = Type_transaction_request::where('type_request','=','2')->get();
        // dd($Type_transaction_requests_notificacion);
        return view('type_transaction_requests_notificacion.indexNotificacion', compact('Type_transaction_requests_notificacion'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createNotificacion()
    {
        //
        return view('type_transaction_requests.createNotificacion');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeNotificacion(Request $request)
    {
        //
        Type_transaction_request::create($request->all());

        flash()->addSuccess('Nuevo Tipo de Solicitud creada con exito.', 'Tipo de Solicitud', ['timeOut' => 3000]);

        return Redirect::route('type_transaction_requests.index');
    }

    /**
     * Display the specified resource.
     */
    public function showNotificacion(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editNotificacion(string $id)
    {
        //
        $Type_transaction_requests = Type_transaction_request::find($id);
        

        return view('type_transaction_requests.edit', compact('Type_transaction_requests'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateNotificacion(Request $request, string $id)
    {
        //
        $Type_transaction_requests = Type_transaction_request::find($id);
        $Type_transaction_requests->update($request->all());
        flash()->addInfo('Tipo de Solicitud modificada..', 'Tipo de solicitud', ['timeOut' => 3000]);
        return Redirect::route('type_transaction_requests.index');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyNotificacion(string $id)
    {
        //
        $Type_transaction_requests = Type_transaction_request::find($id);
        
        $Type_transaction_requests->delete();

        flash()->addError('Tipo de Solicitud', 'Tipo de Solicitud Eliminada: ' . $Type_transaction_requests->name,  ['timeOut' => 2000]);
        return Redirect::route('type_transaction_requests.index');    

    }    
}
