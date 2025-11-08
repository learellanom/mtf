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
        $group = Group::whereIn('type',['1','3'])->orderBy('name','ASC')->pluck('name', 'id');
        return $group;   
    }


    public function getWallets(){
        $wallet = Group::whereIn('type',['2','3'])->orderBy('name','ASC')->pluck('name', 'id');
        return $wallet;
    }

    public function getWalletsEfectivo(){
        $wallet = Group::whereIn('type',['2','3'])->whereIn('type_wallet', ['efectivo'])->orderBy('name','ASC')->pluck('name', 'id');
        return $wallet;
    }


    function getWallets2($Group_roles = null){

        
        //
        // Devuelve todas las cajas tipo 2 y 3
        //
        $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        return $wallet2;


        //
        // Devuelve las cajas segun lo asignado al usuario
        //
        if (isset($Group_roles->allWallets)){
            switch ($Group_roles->allWallets){
                case 1:
                   // \Log::info('leam - GroupController - all wallets -> ');
                    
                    $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
                case 0:
                    $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->wallets)->orderBY('name','ASC')->pluck('name', 'id')->toArray();     
                    break;
                default:
                    $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
            }
            // \Log::info('leam - GroupController - getWallet -> ' . print_r($wallet2,true));
        }
        else {
            $wallet2 = Group::whereIn('type', ['2','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        }
        // \Log::info('leam - GroupController - getWallet general -> ' . print_r($wallet2,true));

        return $wallet2;

    }

    function getGroups2($Group_roles = null){

        // $group = Group::select('groups.id', 'groups.name')
        //         ->where('type','=','1')
        //         ->orderBy('groups.name')
        //         ->get();

        // $group2 = array();
        // foreach($group as $gr){
        //     $group2 [$gr->id] =  $gr->name;
        // }
        // return $group2;

        $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        return $group2;

        if (isset($Group_roles->allGroups)){
            switch ($Group_roles->allGroups){
                case 1:
                    // \Log::info('leam - all groups -> ');
                    // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
                case 0:
                    // \Log::info('leam - algunos groups -> ');
                    // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->groups)->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->whereIn('id', $Group_roles->groups)->orderBY('name','ASC')->pluck('name', 'id')->toArray();
                    break;
            }
            // dd($group2);
            
        } else {
            $group2 = Group::whereIn('type', ['1','3'])->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();
        }

        // $group2 = Group::where('type', '=', '1')->whereBetween('id', [0, 9999])->orderBY('name','ASC')->pluck('name', 'id')->toArray();

        // echo "aqui - general";
        // echo "<pre>";
        // echo print_r($group2,true);
        // echo "</pre>";
        // die();

        return $group2;
    }



    /*
    *
    *
    *   getWalletUSDT
    *
    *
    */
    function getWalletUSDT2(){
        
        $wallet = Group::selectRaw('id, LOWER(name) as lower_name')
        ->whereIn('type',['2','3,'])
        ->having('lower_name','like','%usdt%')
        ->orderBy('lower_name')
        ->get();

        $wallet2 = [];
        foreach($wallet as $wallet){
           $wallet2 [$wallet->id] =  $wallet->lower_name;
        }
        return $wallet2;

    }  
    
    

}
