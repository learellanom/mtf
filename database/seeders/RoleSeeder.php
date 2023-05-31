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
        $role3 = Role::create(['name'=>'Supervisor']);


        Permission::create(['name' => 'home','description' => 'Ver el inicio del sistema'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboardtest','description' => 'Ver graficos del sistema'])->syncRoles([$role1, $role2, $role3]);


        Permission::create(['name' => 'roles.index','description' => 'Ver roles del sistema'])->assignRole($role1);
        Permission::create(['name' => 'roles.edit','description' => 'Editar roles del sistema'])->assignRole($role1);
        Permission::create(['name' => 'roles.update','description' => 'Actualizar roles del sistema'])->assignRole($role1);
        Permission::create(['name' => 'roles.create','description' => 'Crear roles al sistema'])->assignRole($role1);

        Permission::create(['name' => 'clients.index','description' => 'Ver clientes del sistema'])->assignRole($role1);
        Permission::create(['name' => 'clients.edit','description' => 'Editar clientes del sistema'])->assignRole($role1);
        Permission::create(['name' => 'clients.update','description' => 'Modificar clientes del sistema'])->assignRole($role1);
        Permission::create(['name' => 'clients.create','description' => 'Crear clientes al sistema'])->assignRole($role1);

        Permission::create(['name' => 'groups.index','description' => 'Ver grupos del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'groups.edit','description' => 'Editar grupos del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'groups.update','description' => 'Modificar grupos del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'groups.create','description' => 'Crear grupos al sistema'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'suppliers.index','description' => 'Ver proveedores del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'suppliers.edit','description' => 'Editar proveedores del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'suppliers.update','description' => 'Modificar proveedores del sistema'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'suppliers.create','description' => 'Crear proveedores al sistema'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'users.index','description' => 'Ver usuarios del sistema'])->assignRole($role1);
        Permission::create(['name' => 'users.password','description' => 'Cambiar contraseña de los usuarios'])->assignRole($role1);
        Permission::create(['name' => 'users.edit','description' => 'Modificar usuarios del sistema'])->assignRole($role1);
        Permission::create(['name' => 'users.create','description' => 'Crear usuarios al sistema'])->assignRole($role1);
        Permission::create(['name' => 'users.destroy','description' => 'Eliminar usuarios del sistema'])->assignRole($role1);

        Permission::create(['name' => 'type_transactions.index','description' => 'Ver tipos de transacciónes del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_transactions.edit','description' => 'Editar tipos de transacción del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_transactions.create','description' => 'Crear tipos de transacciones al sistema'])->assignRole($role1);

        Permission::create(['name' => 'type_coins.index','description' => 'Ver tipos de moneda del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_coins.edit','description' => 'Modifica tipos de moneda del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_coins.create','description' => 'Crear tipos de moneda al sistema'])->assignRole($role1);

        Permission::create(['name' => 'wallets.index','description' => 'Ver las cajas del sistema'])->assignRole($role1);
        Permission::create(['name' => 'wallets.edit','description' => 'Modificar las cajas del sistema'])->assignRole($role1);
        Permission::create(['name' => 'wallets.create','description' => 'Crear cajas al sistema'])->assignRole($role1);

        Permission::create(['name' => 'estadisticasDetalle.index','description' => 'Detalles de movimientos'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenCliente','description' => 'Resumen de movimientos por cliente'])->assignRole($role1);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenUsuario','description' => 'Resumen de movimientos por agente'])->assignRole($role1);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenWallet','description' => 'Resumen de movimientos por cajas'])->assignRole($role1);

        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenConciliacionFecha','description' => 'Conciliación por fecha'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'estadisticasDetalle.statisticsResumenConciliacionFechaGrupo','description' => 'Conciliación por grupos'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'estadisticasDetalle.estadisticasResumenWalletMaster','description' => 'Resumen de caja (Master)'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'estadisticasDetalle.estadisticasDetalleMaster','description' => 'Detalles de movimientos (Master)'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'estadisticasDetalle.estadisticasResumenProveedor',               'description' => 'Resumen por Proveedor'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'estadisticasDetalle.estadisticasResumenProveedorTransaccion',    'description' => 'Resumen Proveedor por Transaccion'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'estadisticasDetalle.estadisticasResumenConciliacionProveedor',    'description' => 'Resumen Conciliacion por Proveedor'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'transactions_master.index', 'description' => 'Ver transacciónes master'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'transactions_master.edit', 'description' => 'Modificar transacciónes master'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'transactions_master.create', 'description' => 'Crear transacciónes master'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'transactions_supplier.index', 'description' => 'Ver transacciónes a proveedor'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'transactions_supplier.edit', 'description' => 'Modificar transacciónes a proveedor'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'transactions_supplier.create', 'description' => 'Crear transacciónes a proveedor'])->syncRoles([$role1, $role3]);


        Permission::create(['name' => 'transactions.index','description' => 'Ver transacciónes'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.create', 'description' => 'Crear transacciónes'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.create_efectivo', 'description' => 'Crear transacciónes (CASH)'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.edit_efectivo', 'description' => 'Modificar transacciónes (CASH)'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'transactions.edit', 'description' => 'Modificar transacciónes'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'transactions.credit', 'description' => 'Crear credito a la caja'])->assignRole($role1);
        Permission::create(['name' => 'transactions.credit_edit', 'description' => 'Modificar credito a la caja'])->assignRole($role1);

        Permission::create(['name' => 'transactions.update_status', 'description' => 'Cambiar estatus de la transacción'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'transactions.transfer_wallet', 'description' => 'Crear transacciones de caja a caja'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.index_transfer_wallet', 'description' => 'Ver transacciones de caja a caja'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.create_pagowallet', 'description' => 'Crear pagos entre cajas'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.index_pagowallet', 'description' => 'Ver pagos de caja a caja'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'transactions.index_pagoclientes', 'description' => 'Ver pagos entre clientes'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'transactions.create_pagoclientes', 'description' => 'Crear pagos entre clientes'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'permissions.index', 'description' => 'Ver los permisos del sistema'])->assignRole($role1);
    }
}
