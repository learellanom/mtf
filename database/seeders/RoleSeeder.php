<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=>'Administrador']);
        $role2 = Role::create(['name'=>'Agente']);

        Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboardtest'])->syncRoles([$role1, $role2]);


        Permission::create(['name' => 'roles.index'])->assignRole($role1);
        Permission::create(['name' => 'roles.edit'])->assignRole($role1);
        Permission::create(['name' => 'roles.update'])->assignRole($role1);
        Permission::create(['name' => 'roles.create'])->assignRole($role1);

        Permission::create(['name' => 'clients.index'])->assignRole($role1);
        Permission::create(['name' => 'clients.edit'])->assignRole($role1);
        Permission::create(['name' => 'clients.update'])->assignRole($role1);
        Permission::create(['name' => 'clients.create'])->assignRole($role1);

        Permission::create(['name' => 'groups.index'])->assignRole($role1);
        Permission::create(['name' => 'groups.edit'])->assignRole($role1);
        Permission::create(['name' => 'groups.update'])->assignRole($role1);
        Permission::create(['name' => 'groups.create'])->assignRole($role1);

        Permission::create(['name' => 'users.index'])->assignRole([$role1, $role2]);
        Permission::create(['name' => 'users.password'])->assignRole([$role1, $role2]);
        Permission::create(['name' => 'users.edit'])->assignRole($role1);
        Permission::create(['name' => 'users.update'])->assignRole($role1);
        Permission::create(['name' => 'users.create'])->assignRole($role1);
        Permission::create(['name' => 'users.destroy'])->assignRole($role1);

        Permission::create(['name' => 'type_transactions.index'])->assignRole($role1);
        Permission::create(['name' => 'type_transactions.edit'])->assignRole($role1);
        Permission::create(['name' => 'type_transactions.update'])->assignRole($role1);
        Permission::create(['name' => 'type_transactions.create'])->assignRole($role1);

        Permission::create(['name' => 'type_coins.index'])->assignRole($role1);
        Permission::create(['name' => 'type_coins.edit'])->assignRole($role1);
        Permission::create(['name' => 'type_coins.update'])->assignRole($role1);
        Permission::create(['name' => 'type_coins.create'])->assignRole($role1);

        Permission::create(['name' => 'wallets.index'])->assignRole($role1);
        Permission::create(['name' => 'wallets.edit'])->assignRole($role1);
        Permission::create(['name' => 'wallets.update'])->assignRole($role1);
        Permission::create(['name' => 'wallets.create'])->assignRole($role1);

        Permission::create(['name' => 'estadisticasDetalle.index'])->assignRole($role1);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenCliente'])->assignRole($role1);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenUsuario'])->assignRole($role1);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenWallet'])->assignRole($role1);


        Permission::create(['name' => 'transactions.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'transactions.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'transactions.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'transactions.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'transactions.credit'])->assignRole($role1);



    }
}
