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


        // $transferencia = Transaction::whereNull(['transfer_number','pay_number'])
        // ->whereBetween('created_at',    [$myFechaDesde . " 00:00:00", $myFechaHasta . " 23:59:00"])
        // ->whereBetween('user_id',       [$myUsuarioDesde , $myUsuarioHasta])
        // ->orderBy('created_at','desc')
        // ->limit($myLimit)            
        // ->get();



        // $groups = Group::all()->orderBy('name');
        $groups = Group::orderBy('name','ASC')->get();
        return view('groups.index', compact('groups'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->pluck('name', 'id');

        return view('groups.create', compact('users'));
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

        return view('groups.edit', compact('group', 'users'));

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


    public function getGroups(){
        $group = Group::whereIn('type',['1','3'])->pluck('name', 'id');
        return $group;   
    }


    public function getWallets(){
        $wallet = Group::whereIn('type',['2','3'])->pluck('name', 'id');
        return $wallet;
    }

}
