<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;

use App\Models\Group_role;


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
        $roles = Role::find($role);
        $permisos = Permission::all();

        $wallet                     = app(statisticsController::class)->getWallet();
        $group                      = app(statisticsController::class)->getGroups();

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

    public function getRoleWallets (request $request){


        $myRoleDesde = 0;
        $myRoleHasta = 9999;
        if ($request->role_id){
            $myRoleDesde = $request->role_id;
            $myRoleHasta = $request->role_id;
        }

        $myQuery =
        "
            select
                group_roles.id                          as Id,
                group_roles.role_id                     as RoleID,
                roles.name                              as RoleName,
                group_roles.group_id                    as GroupID,
                groups.name                             ad GroupName,
                groups.type                             ad GroupType,
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
                groups_roles.role_id
        ";
        

        $Group_roles = DB::select($myQuery);


    }


}
