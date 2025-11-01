<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Redirect;

use App\Models\Group_role;
use App\Models\User;
use App\Models\Group;

use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth');
    }
    
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
       // $permisos = Permission::all();

        $permisos               = Permission::all();
        $permisos               = Permission::get()->keyBy('id');
        
        //$wallet                 = app(statisticsController::class)->getWallet();
        //$group                  = app(statisticsController::class)->getGroups();

        $wallet                 = app(GroupController::class)->getWallets2();
        $group                  = app(GroupController::class)->getGroups2();

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
        //
        // Todas la CAJAS asignadas al Role
        //
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

                $myType                     = $this->findGroupType($myselect);

                $Group_role                 = new Group_role;

                $Group_role->role_id         = $role->id;
                $Group_role->wallet_id       = $myselect;
                $Group_role->group_id        = $myselect;
                $Group_role->group_type      = $myType;
                $Group_role->all_wallets     = '0';
                $Group_role->all_groups      = '0';

                $Group_role->save();
            }        
        }
        //
        // Todas los GRUPOS asignados al Role
        //
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
                $myType                     = $this->findGroupType($myselect);

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $role->id;
                $Group_role->wallet_id      = $myselect;                
                $Group_role->group_id       = $myselect;
                $Group_role->group_type     = $myType;                
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
        $roles       = Role::find($role);
        $permisos    = Permission::all();
        $permisos    = Permission::get()->keyBy('id');
        // dd($roles->permissions);
         // dd($permisos2[53]);
        // $wallet                     = app(statisticsController::class)->getWallet();
        // $group                      = app(statisticsController::class)->getGroups();


        $wallet                     = app(GroupController::class)->getWallets2();
        $group                      = app(GroupController::class)->getGroups2();


        // dd($group);
        $myRole                     = $roles->id;
        //\Log::info("leam - roles - edit - roles->id -- $roles->id");

        $myRoleAllWallets           = Group_role::select('all_wallets')->where('role_id','=',$roles->id)->where('all_wallets','=','1')->get();
        
        //\Log::info('leam - roles- edit - myRoleAllWallets 1a-> ' . print_r($myRoleAllWallets,true));
        //\Log::info('leam - roles- edit - myRoleAllWallets 1b-> ' . $myRoleAllWallets);

        $myRoleAllWallets           = count($myRoleAllWallets) > 0 ? $myRoleAllWallets[0]->all_wallets : 0;
        $myRoleWallets              = $this->getRolesWalletsByRole($roles->id);
        // dd($myRoleWallets);

        //\Log::info('leam - roles- edit - myRoleAllWallets 2 -> ' . $myRoleAllWallets);
        //\Log::info('leam - roles- edit -wallets -> ' . print_r($myRoleWallets,true));
        

        $myRoleAllGroups            = Group_role::select('all_groups')->where('role_id','=',$roles->id)->where('all_groups','=','1')->get();
        $myRoleAllGroups            = count($myRoleAllGroups) > 0  ? $myRoleAllGroups[0]->all_groups : 0;
        $myRoleGroups               = $this->getRolesGroupsByRole($roles->id);
        
       //\Log::info('leam - roles- edit - myRoleAllGroups -> ' . $myRoleAllGroups);
       // \Log::info('leam - roles- edit - groups -> ' . print_r($myRoleGroups,true));

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
        try{
        // dd($request->permissions);
        // dd($role);
        

        Role::findOrFail($role)->update($request->all());

        //
        //
        // Busca el role y actualiza todos sus permisos sincronizandolos
        //
        //
        $roles = Role::find($role);
        $roles->permissions()->sync($request->permissions);


        // dd($request->myselect);
        // dd($roles->id);
        
        //\Log::info("leam - role - update - roles->id $roles->id");

        //
        //
        // Borra todAs las cajas y grupos del role
        //
        //
        $delete = Group_role::where('role_id', '=', $roles->id)->delete();
        //
        //
        // actualiza las cajas del role
        //
        //
        if (!$request->myselect){
           // echo "todas las cajas con el role id ->" . $role->id; 

            $Group_role                 = new Group_role;

            $Group_role->role_id        = $roles->id;
            $Group_role->all_wallets    = '1';
            $Group_role->all_groups     = '0';

            $Group_role->save();
            //\Log::info("leam - role - update - roles->id $roles->id -> graba todos los wallets");
        }else{

            foreach($request->myselect as $myselect){

                \Log::info("Cada caja -> $myselect con role_id -> $roles->id"); 
                
                $myType                     = $this->findGroupType($myselect);

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $roles->id;
                $Group_role->wallet_id      = $myselect;                
                // $Group_role->group_id       = $myselect;
                $Group_role->group_type     = $myType;                      
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }
        //
        //
        // actualiza los grupos del role
        //
        //        
        if (!$request->myselect2){
            // echo "todas los grupos con el role id ->" . $role->id; 
            
            $Group_role                 = new Group_role;
            $Group_role->role_id        = $roles->id;
            $Group_role->all_wallets    = '0';            
            $Group_role->all_groups     = '1';
            

            $Group_role->save();
            //\Log::info("leam - role - update - roles->id $roles->id -> graba todos los grupos");
        }else{
            \Log::info('RoleController - myselect2 -> ' . print_r($request->myselect2,true));
            foreach($request->myselect2 as $myselect){

               //\Log::info("Cada grupo -> $myselect con role_id -> $roles->id"); 
               $myType                     = $this->findGroupType($myselect);

                $Group_role                 = new Group_role;

                $Group_role->role_id        = $roles->id;
                // $Group_role->wallet_id       = $myselect;
                $Group_role->group_id       = $myselect;
                $Group_role->group_type     = $myType;                
                $Group_role->all_wallets    = '0';
                $Group_role->all_groups     = '0';

                $Group_role->save();
            }        
        }
        } catch (\Exception $e) {
            flash()->addError('Error al modificar el Role ..', 'Roles', ['timeOut' => 3000]);
            return Redirect::back()->with('update', 'Error al actualizar');
        }
        flash()->addInfo('Role modificado..', 'Roles', ['timeOut' => 3000]);

        return Redirect::route('roles.index')->with('update', 'ok');

    }
    // ------------------------------------------------------------------------
    //
    //
    // Remove the specified resource from storage.
    //
    //
    // ------------------------------------------------------------------------
    public function destroy($role)
    {
        $role = Role::find($role);


        $delete = Group_role::where('role_id', '=', $role->id)->delete();


        $role->delete();
        flash()->addError('Roles', 'Role eliminado: ' . $role->name,  ['timeOut' => 2000]);

        return Redirect::route('roles.index')->with('destroy','ok');
    }
    // ------------------------------------------------------------------------
    //
    //
    // Obtiene Wallets para un RoleId determinado
    //
    //
    // ------------------------------------------------------------------------
    public function getRolesWalletsByRole( $theRole = 0){

        $wallets            = array();     
        
        $myQuery =
        "
            select
                group_roles.wallet_id                   as WalletID,            
                group_roles.group_id                    as GroupID,
                mtf.groups.name                             as GroupName,
                mtf.groups.type                             as GroupType
            from
                mtf.group_roles
                left join mtf.groups              on mtf.group_roles.wallet_id           = mtf.groups.id
                left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
            where
                role_id                 between $theRole                and $theRole 
                and mtf.groups.type  in('2','3')
        ";
        
        
        $wallets = DB::select($myQuery);
        // dd($myQuery);
        return $wallets;
    }
    // ------------------------------------------------------------------------
    //
    //
    // Obtiene los Grupos de un RoleID determinado
    //
    //
    // ------------------------------------------------------------------------
    public function getRolesGroupsByRole( $theRole = 0){
        $groups            = array();     
        
        $myQuery =
        "
            select
                group_roles.wallet_id                   as WalletID,            
                group_roles.group_id                    as GroupID,
                groups.name                             as GroupName,
                groups.type                             as GroupType
            from
                mtf.group_roles
                left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
            where
                role_id                 between $theRole                and $theRole 
                and groups.type  in('1','3')
        ";
        
        $groups = DB::select($myQuery);

        return $groups;
    }    
    // ------------------------------------------------------------------------
    //
    //
    // Obtiene wallets y Groups para un UserID determinado
    //
    //
    // ------------------------------------------------------------------------
    public function getRoleWallets ( $theUserId = 0){

        $wallets            = array();
        $groups             = array();


        // \Log::info('leam 1234 - RoleController - getRoleWallets -> ' . $theUserId);

        // if ($theUserId == 0) {
        //     $myUserId           = Auth()->User()->id;
        // }else{
            $myUserId           = $theUserId;
        //}
        // $myUserId           = 2;

       // $Type_coin_balance                  = model_has_role::pluck('name', 'id')->toArray();

        // dd($myUserId);

        $userole2 = User::select('users.id', 'users.name', 'users.type', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.id', '=', $myUserId)
                ->get();
        

        $myUserType = 1;
        $userole3   = User::find($myUserId);
        // $userole3   = User::find(88);
        if($userole3){
            if (isset($userole3->type)){
                $myUserType = $userole3->type;
            }
        }else{
            \Log::info('leam - no existe ***');
        }
        // $myUserType = $userole3->type ?? 1;

        //\Log::info('leam 1234 - RoleController - getRoleWallets - userole3 - > ' . print_r($userole3,true)); 
         
        //\Log::info('leam 1234 - RoleController - getRoleWallets - userole3 test - > ' . $myUserType);
        

        $userole = array();
        foreach($userole2 as $user){
            $myUserName     = $user->name;
            $userole []     = $user->role_id;
        }


        $myUserRoles        = $userole;
        
        if (count($myUserRoles) == 0) { return ;}

        // dd($myUserRoles);
        $all_wallets    = 0;
        $all_groups     = 0;
        if ($myUserType == 1){
        // if ($myUserType == 1 or 2){            
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
                //
                //
                // Busca indicador de todos los wallets
                //
                //
                $myQuery =
                "
                    select
                        group_roles.id                          as Id,
                        group_roles.role_id                     as RoleID,
                        roles.name                              as RoleName,
                        group_roles.wallet_id                   as WalletID,
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
                //
                //
                // Busca indicador de todos los grupos
                //
                //
                $myQuery =
                "
                    select
                        group_roles.id                          as Id,
                        group_roles.role_id                     as RoleID,
                        roles.name                              as RoleName,
                        group_roles.wallet_id                   as WalletID,                    
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

                //
                // Busca los Wallets de un UserID
                //
                $myQuery =
                "
                    select
                        group_roles.id                          as Id,
                        group_roles.role_id                     as RoleID,
                        roles.name                              as RoleName,
                        group_roles.wallet_id                   as WalletID,
                        group_roles.group_id                    as GroupID,
                        case
                        when group_roles.group_type = 1 then mtf.groups.name
                        when group_roles.group_type = 2 then wallets.name
                        when group_roles.group_type = 3 then mtf.groups.name
                        end
                        as GroupName,                                        
                        group_roles.group_type                  as GroupType,
                        group_roles.all_wallets                 as AllWallets,
                        group_roles.all_groups                  as AllGroups
                    from
                        mtf.group_roles
                        left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                        left join mtf.groups as wallets   on mtf.group_roles.wallet_id          = wallets.id                    
                        left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                    where
                            role_id                 between $myRoleDesde                and $myRoleHasta 
                        and group_roles.group_type  in(2,3)            
                        and group_roles.wallet_id is not null        
                    order by
                        RoleID
                ";
                

                $Group_roles = DB::select($myQuery);
                // dd($myQuery);
                // dd($Group_roles);
                
                foreach($Group_roles as $item){
                    $wallets[] = $item->WalletID;
                }
                //  dd($wallets);
                // dd('wallets ->'. count($wallets));
                //
                // Busca los grupos de un UserID
                //
                $myQuery =
                "
                    select
                        group_roles.id                          as Id,
                        group_roles.role_id                     as RoleID,
                        roles.name                              as RoleName,
                        group_roles.wallet_id                   as WalletID,
                        group_roles.group_id                    as GroupID,
                        case
                        when group_roles.group_type = 1 then mtf.groups.name
                        when group_roles.group_type = 2 then wallets.name
                        when group_roles.group_type = 3 then mtf.groups.name
                        end
                        as GroupName,
                        group_roles.group_type                  as GroupType,
                        group_roles.all_wallets                 as AllWallets,
                        group_roles.all_groups                  as AllGroups
                    from
                        mtf.group_roles
                        left join mtf.groups              on mtf.group_roles.group_id           = mtf.groups.id
                        left join mtf.groups as wallets   on mtf.group_roles.wallet_id          = wallets.id                           
                        left join mtf.roles               on mtf.group_roles.role_id            = mtf.roles.id
                    where
                            role_id                 between $myRoleDesde                and $myRoleHasta 
                        and group_roles.group_type  in(1,3)      
                        and group_roles.group_id is not null                                             
                    order by
                        RoleID
                ";
                

                $Group_roles = DB::select($myQuery);

                foreach($Group_roles as $item){
                    $groups[] = $item->GroupID;
                }
                // dd($myQuery);
                // dd($groups);
                // \Log::info('leam - ***************');
                // \Log::info('leam - Role id      -> ' . $role);
                // \Log::info('leam - Role desde   -> ' . $myRoleDesde);
                // \Log::info('leam - Role Hasta   -> ' . $myRoleHasta);
                // \Log::info('leam - all_wallets  -> ' . $all_wallets);
                // \Log::info('leam - all_groups   -> ' . $all_groups);
                // \Log::info('leam - wallets      -> ' . print_r($wallets,true));
                // \Log::info('leam - groups       -> ' . print_r($groups,true));
                
            }
        }else{
            //
            //
            // Busca los wallets y grupos del usuario externo
            //
            //
            $myQuery =
            "
                select
                    group_users.id                          as Id,
                    group_users.user_id                     as UserID,
                    group_users.group_id                    as GroupID,
                    mtf.groups.type                         as GroupType,
                    mtf.groups.name                         as GroupName
                from
                    mtf.group_users
                    left join mtf.groups              on mtf.group_users.group_id = mtf.groups.id
                where
                        user_id                 between $myUserId                and $myUserId
                order by
                    UserID
            ";
            
             $Group_users = DB::select($myQuery);
            // dd($myQuery);
            // dd($Group_users);
             //\Log::info(' leam 1234 - Group_users - >' . print_r($Group_users, true ));

            foreach($Group_users as $item){
                switch ($item->GroupType) {
                    case 1:
                        $groups[]   = $item->GroupID;
                        break;
                    case 2:
                        $wallets[]  = $item->GroupID;    
                        break;
                    case 3:
                        $wallets[]  = $item->GroupID;
                        break;
                    default:
                        $groups[]   = $item->GroupID;
                        break;
                }
            }
            
        }
        

        sort($wallets);
        sort($groups);

        // \Log::info('leam 1234 - wallets -> ' . print_r($wallets,true));
        // \Log::info('leam 1234 - groups  -> ' . print_r($groups,true));

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
        $myObject->userType     = $myUserType;        
        $myObject->userRoles    = $myUserRoles;
        $myObject->allWallets   = $all_wallets;
        $myObject->allGroups    = $all_groups;
        $myObject->wallets      = $wallets;
        $myObject->groups       = $groups;
        
        // dd($myObject);
        // dd(json_encode($myObject));

        // \Log::info('leam 1234 - myObject ->' . print_r($myObject,true));

        // die();
        return $myObject;
    }
    // ------------------------------------------------------------------------
    //
    //
    // Busca el tipo de grupo de un Id de grupo
    //
    //
    // ------------------------------------------------------------------------
    public function findGroupType($myGroup = 0)
    {
        $myType     = "0";
        
        if ($myGroup == 0) return $myType;

        $theGroup   = Group::find($myGroup);

        if ($theGroup) $myType = $theGroup->type;

        return $myType;
    }



}

