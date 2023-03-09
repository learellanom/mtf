<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Role::create($request->all());
        return Redirect::route('admin.roles.index');
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

        return view('admin.roles.edit', compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $role)
    {
        Role::findOrFail($role)->update($request->all());
        return Redirect::route('admin.roles.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role)
    {
        $role = Role::find($role);

        $role->delete();

        return Redirect::route('admin.roles.index')->with('destroy','ok');
    }
}
