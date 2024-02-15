<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;

use App\Http\Models\Group_role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        $wallet                     = app(statisticsController::class)->getWallet();
        $group                      = app(statisticsController::class)->getGroups();

        $parametros['wallet']   = $wallet;
        $parametros['group']    = $group;
        $parametros['permisos'] = $permisos;

        return view('roles.create', $parametros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // leam
        print_r($request->myselect,false);
        die();


        foreach($request->myselect as $myselect){
            
            $Group_role = new Group_role;

            $Group_role->

            $Group_role->save();
        }        


        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        flash()->addSuccess('Nuevo role creado con exito.', 'Roles', ['timeOut' => 3000]);

        return Redirect::route('roles.index');
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
    public function edit($role)
    {
        $roles = Role::find($role);
        $permisos = Permission::all();

        return view('roles.edit', compact('roles', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $role)
    {

        // dd($request->permissions);

        Role::findOrFail($role)->update($request->all());

        $roles = Role::find($role);
        $roles->permissions()->sync($request->permissions);

        flash()->addInfo('Role modificado..', 'Roles', ['timeOut' => 3000]);

        return Redirect::route('roles.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role)
    {
        $role = Role::find($role);

        $role->delete();
        flash()->addError('Roles', 'Role eliminado: ' . $role->name,  ['timeOut' => 2000]);

        return Redirect::route('roles.index')->with('destroy','ok');
    }
}
