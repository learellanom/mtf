<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permission::all();

        return view('permissions.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Permission::create($request->all());

         return Redirect::route('permissions.index')->with('success', 'Nuevo permiso registrado');
    }

    public function edit($permission)
    {
        $permisos = Permission::find($permission);

        return view('permissions.edit', compact('permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $permission)
    {
        $permisos = Permission::find($permission);

        $permisos->update($request->all());

        return Redirect::route('permissions.index')->with('success', 'Permiso #'.$permission." Actualizado");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permission)
    {
        $permisos = Permission::find($permission);

        $permisos->delete();

        return Redirect::route('permissions.index')->with('success', 'Permiso #'.$permission." Eliminado");
    }
}
