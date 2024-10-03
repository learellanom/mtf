<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Wallet;
use App\Models\Group_user;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Pest\Support\Str;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $users = User::all();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();

        $wallet                 = app(GroupController::class)->getWallets2();
        $group                  = app(GroupController::class)->getGroups2();
        
        $parametros['role']     = $role;
        $parametros['wallet']   = $wallet;
        $parametros['group']    = $group;

        return view('users.create', $parametros);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

          // dd($request->type);
         //dd($request->roles);


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd($request->roles);
        $myUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ])->assignRole($request->roles);
        
        $delete = Group_user::where('user_id', '=', $myUser->id)->delete();
        
        if (!$request->myselect){

 
         }else{
 
             foreach($request->myselect as $myselect){
 
                 // echo "Cada caja -> $myselect con role_id -> $role->id"; 
 
                 $Group_user                 = new Group_user;
 
                 $Group_user->user_id         = $myUser->id;
                 $Group_user->group_id        = $myselect;
 
                 $Group_user->save();

             }        
         }

        if (!$request->myselect2){

 
         }else{
 
             foreach($request->myselect2 as $myselect){
 
                 // echo "Cada caja -> $myselect con role_id -> $role->id"; 
 
                 $Group_user                 = new Group_user;
 
                 $Group_user->user_id         = $myUser->id;
                 $Group_user->group_id        = $myselect;
 
                 $Group_user->save();
                 
             }        
         }    


        return redirect()->route('users.index')->with('success', 'Agente creado con exito.');

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
    public function edit($user)
    {
        $user = User::find($user);
        $roles = Role::all();

        $wallet                     = app(GroupController::class)->getWallets2();
        $group                      = app(GroupController::class)->getGroups2();


        $userWallets    = $this->getWalletsByUserExterno($user->id);
        $userGroups     = $this->getGroupsByUserExterno($user->id);

        $parametros['user']         = $user;
        $parametros['roles']        = $roles;
        $parametros['wallet']       = $wallet;
        $parametros['group']        = $group;

        $parametros['userWallets']  = $userWallets;
        $parametros['userGroups']   = $userGroups;

         // dd($userWallets);
        // dd($userGroups);

        return view('users.edit', $parametros);
    }

    public function password($user)
    {
        $user = User::find($user);

        return view('users.password', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_password(Request $request, $user)
    {
        $user = User::findOrFail($user);
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->update();

        return Redirect::route('users.index')->with('info', 'Contraseña modificada del Agente: <strong># '. $user->name . '</strong>');
    }

    public function update_users(Request $request, $user)
    {

            User::findOrFail($user)->update($request->all());

            $user = User::find($user);
            $user->syncRoles($request->roles);


               
        $delete = Group_user::where('user_id', '=', $user->id)->delete();
        /*
        \Log::info('UserCOntroller - update_users - borra el user id de groups ' . $user->id . ' delete ' 
            . print_r($delete,true)
            . ' myselect ' 
            . print_r($request->myselect ,true)
        );
        */
        if (!$request->myselect){

 
         }else{
 
             foreach($request->myselect as $myselect){
 
                 // echo "Cada caja -> $myselect con role_id -> $role->id"; 
 
                 $Group_user                 = new Group_user;
 
                 $Group_user->user_id         = $user->id;
                 $Group_user->group_id        = $myselect;
 
                 $Group_user->save();

             }        
         }

        if (!$request->myselect2){

 
         }else{
 
             foreach($request->myselect2 as $myselect){
 
                 // echo "Cada caja -> $myselect con role_id -> $role->id"; 
 
                 $Group_user                 = new Group_user;
 
                 $Group_user->user_id         = $user->id;
                 $Group_user->group_id        = $myselect;
 
                 $Group_user->save();
                 
             }        
         }    

         
            return Redirect::route('users.index')->with('info', 'Agente/Usuario modificado  <strong># '. $user->name . '</strong>');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($usuario): RedirectResponse
    {

        $usuario = User::find($usuario);

        $usuario->delete();

        return Redirect::route('users.index')->with('error', 'Agente/Usuario eliminado  <strong># '. $usuario->name . '</strong>');
    }



    public function getWalletsByUserExterno( $myUser = 0){

        $wallets            = array();     
        
        $myQuery =
        "
            select
                group_users.group_id  as GroupID,
                mtf.groups.name       as GroupName,
                mtf.groups.type       as GroupType
            from
                mtf.group_users
                left join mtf.groups              on mtf.group_users.group_id           = mtf.groups.id
            where
                user_id                 between $myUser                and $myUser
                and mtf.groups.type  in('2','3')
        ";
        
        
        $wallets = DB::select($myQuery);
        // dd($myQuery);
        return $wallets;
    }

    public function getGroupsByUserExterno( $myUser = 0){

        $groups            = array();     
        
        $myQuery =
        "
            select
                group_users.group_id  as GroupID,
                mtf.groups.name       as GroupName,
                mtf.groups.type       as GroupType
            from
                mtf.group_users
                left join mtf.groups              on mtf.group_users.group_id           = mtf.groups.id
            where
                user_id                 between $myUser                and $myUser
                and mtf.groups.type  in('1')
        ";
        
        
        $groups = DB::select($myQuery);
        // dd($myQuery);
        return $groups;
    }

}

?>
