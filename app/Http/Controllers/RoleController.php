<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Redirect;

use App\Models\Group_role;
use App\Models\User;

use Illuminate\Support\Facades\DB;

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


        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        // leam
        // print_r($request->myselect,false);

        $delete = Group_role::where('role_id', '=', $role->role_id)->delete();

        if (!$request->myselect){
           // echo "todas las cajas con el role id ->" . $role->id; 
            
            $Group_role                 = new Group_role;

            $Group_role->role_id        = $role->id;
            $Group_role->all_wallets    = '1';
            $Group_role->all_groups     = '0';

            $Group_role->save();

        }else{

            foreach($request->myselect as $myselect){

                // echo "Cada caja -> $myselect con role_id -> $role->id"; 

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $role->id;
                $Group_role->group_id       = $myselect;
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }

        if (!$request->myselect2){
            // echo "todas los grupos con el role id ->" . $role->id; 
            
            $Group_role                 = new Group_role;
            $Group_role->role_id        = $role->id;
            $Group_role->all_wallets    = '0';            
            $Group_role->all_groups     = '1';
            

            $Group_role->save();

        }else{

            foreach($request->myselect2 as $myselect){

                // echo "Cada grupo -> $myselect con role_id -> $role->id"; 

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $role->id;
                $Group_role->group_id       = $myselect;
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }

        // die();

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
        $roles      = Role::find($role);
        $permisos   = Permission::all();

        $wallet                     = app(statisticsController::class)->getWallet();
        $group                      = app(statisticsController::class)->getGroups();

        $myRole                     = $roles->id;
        \Log::info("leam - roles - edit - roles->id -- $roles->id");

        $myRoleAllWallets           = Group_role::select('all_wallets')->where('role_id','=',$roles->id)->where('all_wallets','=','1')->get();
        
        \Log::info('leam - roles- edit - myRoleAllWallets 1a-> ' . print_r($myRoleAllWallets,true));
        \Log::info('leam - roles- edit - myRoleAllWallets 1b-> ' . $myRoleAllWallets);

        $myRoleAllWallets           = count($myRoleAllWallets) > 0 ? $myRoleAllWallets[0]->all_wallets : 0;
        $myRoleWallets              = $this->getRolesWalletsByRole($roles->id);
        

        \Log::info('leam - roles- edit - myRoleAllWallets 2 -> ' . $myRoleAllWallets);
        \Log::info('leam - roles- edit -wallets -> ' . print_r($myRoleWallets,true));
        

        $myRoleAllGroups            = Group_role::select('all_groups')->where('role_id','=',$roles->id)->where('all_groups','=','1')->get();
        $myRoleAllGroups            = count($myRoleAllGroups) > 0  ? $myRoleAllGroups[0]->all_groups : 0;
        $myRoleGroups               = $this->getRolesGroupsByRole($roles->id);
        
        \Log::info('leam - roles- edit - myRoleAllGroups -> ' . $myRoleAllGroups);
        \Log::info('leam - roles- edit - groups -> ' . print_r($myRoleGroups,true));

        $parametros['myRole']       = $myRole;
        
        $parametros['myRoleAllWallets']       = $myRoleAllWallets;
        $parametros['myRoleWallets']       = $myRoleWallets;

        $parametros['myRoleAllGroups']       = $myRoleAllGroups;
        $parametros['myRoleGroups']       = $myRoleGroups;

        $parametros['wallet']       = $wallet;
        $parametros['group']        = $group;
        $parametros['roles']        = $roles;
        $parametros['permisos']     = $permisos;

        return view('roles.edit', $parametros);
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


        // dd($request->myselect);
        //dd($roles->id);
        
        \Log::info("leam - role - update - roles->id $roles->id");

        $delete = Group_role::where('role_id', '=', $roles->id)->delete();
        
        if (!$request->myselect){
           // echo "todas las cajas con el role id ->" . $role->id; 
            
            $Group_role                 = new Group_role;

            $Group_role->role_id        = $roles->id;
            $Group_role->all_wallets    = '1';
            $Group_role->all_groups     = '0';

            $Group_role->save();
            \Log::info("leam - role - update - roles->id $roles->id -> graba todos los wallets");
        }else{

            foreach($request->myselect as $myselect){

                \Log::info("Cada caja -> $myselect con role_id -> $roles->id"); 

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $roles->id;
                $Group_role->group_id       = $myselect;
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }
        

        if (!$request->myselect2){
            // echo "todas los grupos con el role id ->" . $role->id; 
            
            $Group_role                 = new Group_role;
            $Group_role->role_id        = $roles->id;
            $Group_role->all_wallets    = '0';            
            $Group_role->all_groups     = '1';
            

            $Group_role->save();
            \Log::info("leam - role - update - roles->id $roles->id -> graba todos los grupos");
        }else{

            foreach($request->myselect2 as $myselect){

               \Log::info("Cada grupo -> $myselect con role_id -> $roles->id"); 

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $roles->id;
                $Group_role->group_id       = $myselect;
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }

        

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

    public function getRolesWalletsByRole( $theRole = 0){
        $wallets            = array();     
        
        $myQuery =
        "
            select
                group_roles.group_id                    as GroupID,
                groups.name                             as GroupName,
                groups.type                             as GroupType
            from
                mtf.group_roles
                left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
            where
                role_id                 between $theRole                and $theRole 
                and groups.type  = '2'
        ";
        

        $wallets = DB::select($myQuery);

        return $wallets;
    }

    public function getRolesGroupsByRole( $theRole = 0){
        $groups            = array();     
        
        $myQuery =
        "
            select
                group_roles.group_id                    as GroupID,
                groups.name                             as GroupName,
                groups.type                             as GroupType
            from
                mtf.group_roles
                left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
            where
                role_id                 between $theRole                and $theRole 
                and groups.type  = '1'
        ";
        

        $groups = DB::select($myQuery);

        return $groups;
    }    

    public function getRoleWallets ( $theUserId = 0){

        $wallets            = array();
        $groups             = array();

        // if ($theUserId == 0) {
        //     $myUserId           = Auth()->User()->id;
        // }else{
            $myUserId           = $theUserId;
        //}
        // $myUserId           = 2;

       // $Type_coin_balance                  = model_has_role::pluck('name', 'id')->toArray();

        // dd($myUserId);

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.id', '=', $myUserId)
                ->get();

        

        $userole = array();
        foreach($userole2 as $user){
            $myUserName         = $user->name;
            $userole [] =  $user->role_id;
        }


        $myUserRoles        = $userole;
        
        if (count($myUserRoles) == 0) { return ;}

        // dd($myUserRoles);
        $all_wallets    = 0;
        $all_groups     = 0;

        foreach($myUserRoles as $role){
            
            //     if($roles->name == 'Administrador' || $roles->name == 'Supervisor'){        
            //         dd($roles->id . ' ' . $roles->name);
            //          return true;
            //     }
            //  }


            $myRoleDesde = 0;
            $myRoleHasta = 9999;
            // if ($request->role_id){
            //     $myRoleDesde = $request->role_id;
            //     $myRoleHasta = $request->role_id;
            // }

            $myRoleDesde = $role;
            $myRoleHasta = $role;

            // $myRoleDesde = 38;
            // $myRoleHasta = 38;



            $myQuery =
            "
                select
                    group_roles.id                          as Id,
                    group_roles.role_id                     as RoleID,
                    roles.name                              as RoleName,
                    group_roles.group_id                    as GroupID,
                    groups.name                             as GroupName,
                    groups.type                             as GroupType,
                    group_roles.all_wallets                 as AllWallets,
                    group_roles.all_groups                  as AllGroups
                from
                    mtf.group_roles
                    left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                    left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                where
                    role_id                 between $myRoleDesde                and $myRoleHasta 
                    and all_wallets = '1'
            ";
            

            $Group_roles = DB::select($myQuery);



            if (count($Group_roles) > 0) {
                $all_wallets = 1;
            }


            // busca todos los grupos


            $myQuery =
            "
                select
                    group_roles.id                          as Id,
                    group_roles.role_id                     as RoleID,
                    roles.name                              as RoleName,
                    group_roles.group_id                    as GroupID,
                    groups.name                             as GroupName,
                    groups.type                             as GroupType,
                    group_roles.all_wallets                 as AllWallets,
                    group_roles.all_groups                  as AllGroups
                from
                    mtf.group_roles
                    left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                    left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                where
                    role_id                 between $myRoleDesde                and $myRoleHasta 
                    and all_groups = '1'
            ";
            

            $Group_roles = DB::select($myQuery);

            if (count($Group_roles) > 0) {
                $all_groups = 1;
            }





            // dd(' all groups -> ' . $all_groups);


            $myQuery =
            "
                select
                    group_roles.id                          as Id,
                    group_roles.role_id                     as RoleID,
                    roles.name                              as RoleName,
                    group_roles.group_id                    as GroupID,
                    groups.name                             as GroupName,
                    groups.type                             as GroupType,
                    group_roles.all_wallets                 as AllWallets,
                    group_roles.all_groups                  as AllGroups
                from
                    mtf.group_roles
                    left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                    left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                where
                    role_id                 between $myRoleDesde                and $myRoleHasta 
                having
                    GroupType = 2
                order by
                    RoleID
            ";
            

            $Group_roles = DB::select($myQuery);
            // dd($Group_roles);
            
            foreach($Group_roles as $item){
                $wallets[] = $item->GroupID;
            }
            // dd('wallets ->'. count($wallets));

            $myQuery =
            "
                select
                    group_roles.id                          as Id,
                    group_roles.role_id                     as RoleID,
                    roles.name                              as RoleName,
                    group_roles.group_id                    as GroupID,
                    groups.name                             as GroupName,
                    groups.type                             as GroupType,
                    group_roles.all_wallets                 as AllWallets,
                    group_roles.all_groups                  as AllGroups
                from
                    mtf.group_roles
                    left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                    left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                where
                    role_id                 between $myRoleDesde                and $myRoleHasta 
                having
                    GroupType = 1
                order by
                    RoleID
            ";
            

            $Group_roles = DB::select($myQuery);

            foreach($Group_roles as $item){
                $groups[] = $item->GroupID;
            }
            // \Log::info('leam - ***************');
            // \Log::info('leam - Role id      -> ' . $role);
            // \Log::info('leam - Role desde   -> ' . $myRoleDesde);
            // \Log::info('leam - Role Hasta   -> ' . $myRoleHasta);
            // \Log::info('leam - all_wallets  -> ' . $all_wallets);
            // \Log::info('leam - all_groups   -> ' . $all_groups);
            // \Log::info('leam - wallets      -> ' . print_r($wallets,true));
            // \Log::info('leam - groups       -> ' . print_r($groups,true));


        }

        sort($wallets);
        sort($groups);


        if(count($wallets) > 0)  $all_wallets = 0;
        if(count($groups) > 0)   $all_groups = 0;

        // dd("pasa con wallets -> " . print_r($wallets) . " los grupos -> " . print_r($groups));
        //echo print_r($wallets);
        //echo print_r($groups);
        // \Log::info('leam - fin');
        // \Log::info('leam - user id      -> ' . $myUserId);
        // \Log::info('leam - all_wallets  -> ' . $all_wallets);
        // \Log::info('leam - all_groups   -> ' . $all_groups);
        // \Log::info('leam - wallets      -> ' . print_r($wallets,true));
        // \Log::info('leam - groups       -> ' . print_r($groups,true));
        // \Log::info('leam - myUserRoles  -> ' . count($myUserRoles));

        //$myWallets  = json_encode($wallets);
        //$myGroups   = json_encode($groups);


        $myObject  = new \stdClass();
            
        $myObject->userId       = $myUserId;
        $myObject->userName     = $myUserName;
        $myObject->userRoles    = $myUserRoles;
        $myObject->allWallets   = $all_wallets;
        $myObject->allGroups    = $all_groups;
        $myObject->wallets      = $wallets;
        $myObject->groups       = $groups;
        
        // dd($myObject);
        // dd(json_encode($myObject));

        //\Log::info('leam - myObject ->' . print_r($myObject,true));

        // die();
        return $myObject;
    }


}

