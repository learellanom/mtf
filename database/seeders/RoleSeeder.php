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
        $role4 = Role::create(['name'=>'Externo']);
        $role1 = Role::create(['name'=>'Administrador']);
        $role2 = Role::create(['name'=>'Agente']);
        $role3 = Role::create(['name'=>'Supervisor']);


        Permission::create(['name' => 'home','description' => 'Ver el inicio del sistema'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboardtest','description' => 'Ver graficos del sistema'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboardSaldos','description' => 'Ver Saldos posicion consolidada'])->syncRoles([$role1, $role2, $role3]);

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

        Permission::create(['name' => 'estadisticasDetalle.estadisticasResumenGrupoWallet', 'description' => 'Resumen por Grupo Wallet'])->assignRole($role1);

        Permission::create(['name' => 'dashboardSaldos',                            'description' => 'Saldos posicion consolidada'])->assignRole($role1);
        Permission::create(['name' => 'dashboardComisiones',                        'description' => 'Dashboard de Comisiones'])->assignRole($role1);
        Permission::create(['name' => 'dashboardComisionesGrupo',                   'description' => 'Consolidado de Comisiones por Grupo'])->assignRole($role1);
        Permission::create(['name' => 'dashboardComisionesGrupo2',                  'description' => 'Detalle de Comisiones USDT'])->assignRole($role1);
        Permission::create(['name' => 'USDTResumenDiario',                          'description' => 'USDT Resumen Diario de Movimientos'])->assignRole($role1);
        Permission::create(['name' => 'USDTResumenDiarioFiltro',                    'description' => 'USDT Resumen Diario de Movimientos Filtros'])->assignRole($role1);
        
        Permission::create(['name' => 'dashboardComisionesFiltro',                  'description' => 'Dashboard de Comisiones Filtro'])->assignRole($role1);

        Permission::create(['name' => 'transactions.index3',                        'description' => 'Transacciones v2 - Ver Transacciones'])->assignRole($role1);

        Permission::create(['name' => 'type_materials.index',                       'description'   => 'Ver tipos de material del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_materials.edit',                        'description'   => 'Modifica tipos de material del sistema'])->assignRole($role1);
        Permission::create(['name' => 'type_materials.create',                      'description'   => 'Crear tipos de material al sistema'])->assignRole($role1);

        Permission::create(['name' => 'materials.adquisicion_index',                'description'   => 'Ver Materiales Aquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_create',               'description'   => 'Crear Materiales Adquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_edit',                 'description'   => 'Editar Materiales Adquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_update',               'description'   => 'Actualizar Materiales Adquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_update_status',        'description'   => 'Anular/ Activar Materiales Adquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_audit',                'description'   => 'Ver Auditoria Materiales Adquisicion'])->assignRole($role1);

        Permission::create(['name' => 'materials.recepcion_index',                  'description'   => 'Ver Materiales Recepcion'])->assignRole($role1);
        Permission::create(['name' => 'materials.recepcion_create',                 'description'   => 'Crear Materiales Recepcion'])->assignRole($role1);
        Permission::create(['name' => 'materials.recepcion_edit',                   'description'   => 'Editar Materiales Recepcion'])->assignRole($role1);
        Permission::create(['name' => 'materials.recepcion_update',                 'description'   => 'Actualizar Materiales Recepcion'])->assignRole($role1);
        Permission::create(['name' => 'materials.recepcion_update_status',          'description'   => 'Anular/ Activar Materiales Recepcion'])->assignRole($role1);
        Permission::create(['name' => 'materials.recepcion_audit',                  'description'   => 'Ver Auditoria Materiales Recepcion'])->assignRole($role1);

        Permission::create(['name' => 'materials.adquisicion_rescajagrupo',         'description'   => 'Resumen Adquisicion por Caja - Grupo'])->assignRole($role1);
        Permission::create(['name' => 'materials.liquidacion_cuenta',               'description'   => 'Liquidacion de cuenta'])->assignRole($role1);
        Permission::create(['name' => 'materials.adquisicion_consolidado',          'description'   => 'Resumen Consolidado de Aquisicion'])->assignRole($role1);
        Permission::create(['name' => 'materials.consolidado_grupo',                'description'   => 'Consolidado por grupo'])->assignRole($role1);
        Permission::create(['name' => 'materials.CierreGenera',                     'description'   => 'Cierre de materiales'])->assignRole($role1);
        Permission::create(['name' => 'USDTResumenMovimientos',                     'description'   => 'Resumen de Movimientos USDT'])->assignRole($role1);

        /*
            Externo
        */
        Permission::create(['name' => 'externoDetalle',                     'description'   => 'Detalles de Movimientos'])->assignRole($role4);

    }
}
