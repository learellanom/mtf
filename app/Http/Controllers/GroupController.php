<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->pluck('name', 'id');
        $clients = Client::all()->pluck('name', 'id');

        return view('groups.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $groups = Group::create($request->all());

        if($request->user){
            $groups->user()->attach($request->user);
         }

         flash()->addSuccess('Nuevo grupo creado con exito.', 'Grupo', ['timeOut' => 3000]);
         return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($groups)
    {

        $group = Group::all($groups);

        return view('groups.show', compact('group'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($groups)
    {
       $group = Group::find($groups);
       $users = User::all()->pluck('name', 'id');
       $clients = Client::all()->pluck('name', 'id');



        return view('groups.edit', compact('group', 'clients', 'users'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $groups)
    {

        $group = Group::find($groups)->update($request->all());

        if($request->user){
            $group = Group::find($groups);

            $group->user()->sync($request->user);
         }

         flash()->addInfo('Grupo modificado..', 'Grupo', ['timeOut' => 3000]);

         return Redirect::route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($groups)
    {
        $group = Group::find($groups);
        $group->delete();

        flash()->addError('Grupo', 'Grupo eliminado: ' . $group->name,  ['timeOut' => 2000]);
        return Redirect::route('groups.index');

    }
}
