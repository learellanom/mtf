<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enterprise;
use App\Models\Enterprise_wallet;
use Illuminate\Support\Facades\Redirect;


class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $enterprise = Enterprise::all();
        return view('enterprise.index', compact('enterprise'));        

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $wallet             = app(GroupController::class)->getWallets2();
        $group              = app(GroupController::class)->getGroups2();

        $parametros['group'] = $group;
        $parametros['wallet'] = $wallet;

        return view('enterprise.create', $parametros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $Enterprise = Enterprise::create($request->all());
        if (isset($request['my-select'])){
            if (count($request['my-select'])){
                foreach($request['my-select'] as $item){

                    $Enterprise_wallet = new Enterprise_wallet();
                    $Enterprise_wallet->enterprise_id   = $Enterprise->id;
                    $Enterprise_wallet->group_id        = $item;;
                    $Enterprise_wallet->save();

                }
            }
        }
        flash()->addSuccess('Nueva Caja Mayor creada con exito.', 'Caja Mayor', ['timeOut' => 3000]);

        return Redirect::route('enterprise.index');        
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

        $enterprise                         = Enterprise::find($id);
        $enterprise_wallet                  = Enterprise_wallet::where('enterprise_id',$enterprise->id)->pluck('group_id');
        $wallet                             = app(GroupController::class)->getWallets2();
        $group                              = app(GroupController::class)->getGroups2();

        $parametros['group']                = $group;
        $parametros['wallet']               = $wallet;
        $parametros['enterprise']           = $enterprise;
        $parametros['enterprise_wallet']    = $enterprise_wallet;
        // dd($enterprise);
        // dd($enterprise_wallet);
         return view('enterprise.edit', $parametros);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $enterprise = Enterprise::find($id);
        $enterprise->update($request->all());

        Enterprise_wallet::where('enterprise_id', $enterprise->id)->delete();
        if(isset($request['my-select'])){
            if (count($request['my-select'])){
                foreach($request['my-select'] as $item){

                    $Enterprise_wallet = new Enterprise_wallet();
                    $Enterprise_wallet->enterprise_id   = $enterprise->id;
                    $Enterprise_wallet->group_id        = $item;;
                    $Enterprise_wallet->save();

                }
            }
        }
        flash()->addInfo('Caja Mayor modificado..', 'Caja Mayor', ['timeOut' => 3000]);
        return Redirect::route('enterprise.index');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $enterprise_wallet  = Enterprise_wallet::where('enterprise_id',$id)->delete();
        $enterprise         = Enterprise::find($id);
        $enterprise->delete();

        flash()->addError('Caja Mayor', 'Caja Mayor Eliminada: ' . $enterprise->name,  ['timeOut' => 2000]);
        return Redirect::route('enterprise.index');        
    }
}
