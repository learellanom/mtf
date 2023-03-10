<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Group;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = Group::pluck('name', 'id');

        return view('clients.create', compact('group'));
    }

    public function store(Request $request)
    {
        Client::create($request->all());

        return Redirect::route('clients.index');
    }

    public function edit($client)
    {
        $clients = Client::find($client);
        $group = Group::pluck('name', 'id');

        return view('clients.edit', compact('clients', 'group'));
    }

    public function update(Request $request, $clients)
    {
        Client::findOrFail($clients)->update($request->all());

        return Redirect::route('clients.index');
    }

    public function destroy($clients)
    {
        $client = Client::find($clients);

        $client->delete();

        return Redirect::route('clients.index');
    }


}

