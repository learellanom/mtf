<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
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
        //$user = User::where('role', auth()->user()->role)->pluck('name', 'id');
        $user = User::select('users.id', 'users.name', 'model_has_roles.role_id')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('role_id', 2)
        ->get()->pluck('name', 'id');

        return view('clients.create', compact('user'));
    }

    public function store(Request $request)
    {
        Client::create($request->all());

        return Redirect::route('clients.index');
    }

    public function edit($client)
    {
        $clients = Client::find($client);
        $user = User::select('users.id', 'users.name', 'model_has_roles.role_id')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('role_id', 2)
        ->get()->pluck('name', 'id');

        return view('clients.edit', compact('clients', 'user'));
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

