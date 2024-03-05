<?php

namespace App\Http\Controllers;

use App\Models\Type_material;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Type_materialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Type_material = Type_material::all();
        return view('type_materials.index', compact('Type_material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type_materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Type_material::create($request->all());

        flash()->addSuccess('Nuevo Tipo Material creado con exito.', 'Tipo de Material', ['timeOut' => 3000]);

        return Redirect::route('type_materials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type_material $Type_material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Type_material)
    {

        $Type_material = Type_material::find($Type_material);
        

        return view('type_materials.edit', compact('Type_material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $Type_material_id)
    {
        
        // dd('leam - aqui -> ' . print_r($Type_material,true));
        $Type_material = Type_material::find($Type_material_id);
        $Type_material->update($request->all());
        flash()->addInfo('Tipo de material modificado..', 'Tipo de material', ['timeOut' => 3000]);
        return Redirect::route('type_materials.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Type_material)
    {
        $Type_material = Type_material::find($Type_material);
        
        $Type_material->delete();

        flash()->addError('Tipo de material', 'Tipo de material Eliminado: ' . $Type_material->name,  ['timeOut' => 2000]);
        return Redirect::route('type_materials.index');
    }
}
