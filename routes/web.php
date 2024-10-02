<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TransactionMasterController;
use App\Http\Controllers\TransactionSupplierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Type_transactionController;
use App\Http\Controllers\Type_coinController;
use App\Http\Controllers\Type_materialController;

use JeroenNoten\LaravelAdminLte\Http\Controllers\DarkModeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});


/* CAMBIO DE IDIOMA */
Route::get('lang/{locale}', [LanguageController::class, 'index'])->name('lang');

Route::get('/', function () {
     return view('auth.login');
});

Route::post('/darkmode/toggle', [DarkModeController::class, 'toggle'])
    ->name('darkmode.toggle');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('can:home')->name('home');

Route::get('dashboardest', [App\Http\Controllers\HomeController::class, 'graphics'])->name('dashboardest');

Route::get('dashboardSaldos', [App\Http\Controllers\HomeController::class, 'saldos'])->name('dashboardSaldos');

Route::get('dashboardComisiones', [App\Http\Controllers\HomeController::class, 'comisiones'])->name('dashboardComisiones');
Route::get('dashboardComisiones/{wallet}/{transaction?}', [App\Http\Controllers\HomeController::class, 'comisiones'])->name('dashboardComisiones');
Route::get('dashboardComisiones/{wallet}/{transaction?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'comisiones'])->name('dashboardComisiones');

Route::get('dashboardComisionesGrupo', [App\Http\Controllers\HomeController::class,                                                 'comisionesGrupo'])->name('dashboardComisionesGrupo');
// Route::get('dashboardComisionesGrupo/{wallet}/{wallet2?}', [App\Http\Controllers\HomeController::class,                             'comisionesGrupo'])->name('dashboardComisionesGrupo');
// Route::get('dashboardComisionesGrupo/{wallet}/{wallet2?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupo'])->name('dashboardComisionesGrupo');


Route::get('dashboardComisionesGrupo2', [App\Http\Controllers\HomeController::class, 'comisionesGrupo2'])->name('dashboardComisionesGrupo2');
Route::get('dashboardComisionesGrupo2/{wallet?}/{grupo?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupo2'])->name('dashboardComisionesGrupo2');
Route::get('dashboardComisionesGrupo2/{wallet?}/{grupo?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupo2'])->name('dashboardComisionesGrupo2');


Route::get('dashboardComisionesGrupo3', [App\Http\Controllers\HomeController::class, 'comisionesGrupo3'])->name('dashboardComisionesGrupo3');
Route::get('dashboardComisionesGrupo3/{wallet?}/{grupo?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupo3'])->name('dashboardComisionesGrupo3');
Route::get('dashboardComisionesGrupo3/{wallet?}/{grupo?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupo3'])->name('dashboardComisionesGrupo3');

Route::get('dashboardComisionesUSDTGenera',     [App\Http\Controllers\statisticsController::class, 'commissionProfitGenera'])->name('dashboardComisionesUSDTGenera');
Route::get('dashboardComisionesUSDTProcess',    [App\Http\Controllers\statisticsController::class, 'commissionProfitProcess'])->name('dashboardComisionesUSDTProcess');

Route::get('materialsCierreGenera',         [App\Http\Controllers\statisticsController::class, 'materialsCierreGenera'])->name('materialsCierreGenera');
Route::get('materialsCierreProcess',        [App\Http\Controllers\statisticsController::class, 'materialsCierreProcess'])->name('materialsCierreProcess');

Route::get('dashboardComisionesGrupoRes', [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes'])->name('dashboardComisionesGrupoRes');
Route::get('dashboardComisionesGrupoRes/{wallet?}/{grupo?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes'])->name('dashboardComisionesGrupoRes');
Route::get('dashboardComisionesGrupoRes/{wallet?}/{grupo?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes'])->name('dashboardComisionesGrupoRes');

Route::get('dashboardComisionesGrupoRes3',                                                  [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes3'])->name('dashboardComisionesGrupoRes3');
Route::get('dashboardComisionesGrupoRes3/{wallet?}/{grupo?}',                               [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes3'])->name('dashboardComisionesGrupoRes3');
Route::get('dashboardComisionesGrupoRes3/{wallet?}/{grupo?}/{fechaDesde?}/{fechaHasta?}',   [App\Http\Controllers\HomeController::class, 'comisionesGrupoRes3'])->name('dashboardComisionesGrupoRes3');


Route::get('USDTResumenDiario/{wallet?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'USDTResumenDiario'])->name('USDTResumenDiario');

Route::get('USDTResumen',                 [StatisticsController::class,  'USDTResumen'])->name('USDTResumen');

Route::get('consolidadoMovimientosGrupo', [App\Http\Controllers\statisticsController::class, 'consolidadoMovimientosGrupo'])->name('consolidadoMovimientosGrupo');

Route::get('dashboard_est/export/', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet}', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet}/{transaction?}/', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL

Route::get('dashboard_est/exportComisiones/', [App\Http\Controllers\HomeController::class, 'exportComisiones'])->name('exportsComisiones.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/exportComisiones/{wallet}', [App\Http\Controllers\HomeController::class, 'exportComisiones'])->name('exportsComisiones.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/exportComisiones/{wallet}/{transaction?}/', [App\Http\Controllers\HomeController::class, 'exportComisiones'])->name('exportsComisiones.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/exportComisiones/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', [App\Http\Controllers\HomeController::class, 'exportComisiones'])->name('exportsComisiones.excel'); //EXPORTACIÓN DE EXCEL

Route::get('dashboardest/exportpdf/',                           
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet}',                   
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet}/{transaction?}/',   
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', 
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF


Route::get('dashboardest/exportcomisionespdf/',                
            [App\Http\Controllers\HomeController::class, 'exportPDFComisiones'])->name('exports.EstadisticaComisionesPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportcomisionespdf/{wallet}',                   
            [App\Http\Controllers\HomeController::class, 'exportPDFComisiones'])->name('exports.EstadisticaComisionesPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportcomisionespdf/{wallet}/{transaction?}/',   
            [App\Http\Controllers\HomeController::class, 'exportPDFComisiones'])->name('exports.EstadisticaComisionesPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportcomisionespdf/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', 
            [App\Http\Controllers\HomeController::class, 'exportPDFComisiones'])->name('exports.EstadisticaComisionesPDF'); //EXPORTACIÓN DE PDF



Route::get('dashboard_saldos/export/', [App\Http\Controllers\HomeController::class, 'exportSaldos'])->name('exports.saldos'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_saldos/export/{fechaDesde?}/{fechaHasta?}/{filtroWallet?}/{filtroGroup?}/{filtroWalletB?}/{filtroGroupB?}/{resumen?}', [App\Http\Controllers\HomeController::class, 'exportSaldos'])->name('exports.saldos'); //EXPORTACIÓN DE EXCEL

Route::get('dashboard_saldos/exportSaldosPDF/', [App\Http\Controllers\HomeController::class, 'exportSaldosPDF'])->name('exports.SaldosPDF'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_saldos/exportSaldosPDF/{fechaDesde?}/{fechaHasta?}/{filtroWallet?}/{filtroGroup?}/{filtroWalletB?}/{filtroGroupB?}/{resumen?}', [App\Http\Controllers\HomeController::class, 'exportSaldosPDF'])->name('exports.SaldosPDF'); //EXPORTACIÓN DE EXCEL


Route::get('filtroUSDTResDiaMovimientosLee', [App\Http\Controllers\statisticsController::class, 'filtroUSDTResDiaMovimientosLee'])->name('filtroUSDTResDiaMovimientosLee');
Route::post('filtroUSDTResDiaMovimientosGraba', [App\Http\Controllers\statisticsController::class, 'filtroUSDTResDiaMovimientosGraba'])->name('filtroUSDTResDiaMovimientosGraba');

Route::get('filtrosLeeWallet', [App\Http\Controllers\statisticsController::class, 'filtrosLeeWallet'])->name('filtrosLeeWallet'); // Lee filtros
Route::get('filtrosLeeGroup', [App\Http\Controllers\statisticsController::class, 'filtrosLeeGroup'])->name('filtrosLeeGroup'); // Lee filtros


Route::get('filtrosLeeWalletB', [App\Http\Controllers\statisticsController::class, 'filtrosLeeWalletB'])->name('filtrosLeeWalletB'); // Lee filtros
Route::get('filtrosLeeGroupB', [App\Http\Controllers\statisticsController::class, 'filtrosLeeGroupB'])->name('filtrosLeeGroupB'); // Lee filtros

Route::post('filtrosGrabaWallet', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaWallet'])->name('filtrosGrabaWallet'); // Lee filtros
Route::post('filtrosGrabaGroup', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaGroup'])->name('filtrosGrabaGroup'); // Lee filtros


Route::post('filtrosRolesGraba',        [App\Http\Controllers\statisticsController::class, 'filtrosRolesGraba'])->name('filtrosRolesGraba'); // Lee filtros
Route::post('filtrosRolesWalletsLee',    [App\Http\Controllers\statisticsController::class, 'filtrosRolesWalletLee'])->name('filtrosRolesWalletLee'); // Lee filtros
Route::post('filtrosRolesGroupsLee',    [App\Http\Controllers\statisticsController::class, 'filtrosRolesGroupsLee'])->name('filtrosRolesGroupsLee'); // Lee filtros

Route::post('filtrosGrabaEstadisticas', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaEstadisticas'])->name('filtrosGrabaEstadisticas'); // Lee filtros

Route::post('filtrosGrabaComisiones', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaComisiones'])->name('filtrosGrabaComisiones'); // Lee filtros

Route::post('filtrosGrabaComisionesGrupo', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaComisionesgrupo'])->name('filtrosGrabaComisionesGrupo'); // Lee filtros comisiones grupo



/* TRANSACCIONES A CLIENTES */
Route::group(['middleware' => 'auth'], function () {
    Route::get('movimientos/efectivo', [TransactionController::class, 'create_efectivo'])->middleware('can:transactions.create_efectivo')->name('transactions.create_efectivo');
    Route::get('movimientos/{movimiento}/editar_efectivo', [TransactionController::class, 'edit_efectivo'])->middleware('can:transactions.edit_efectivo')->name('transactions.edit_efectivo');
    Route::post('movimientos/crear_efectivo', [TransactionController::class, 'store_efectivo'])->name('transactions.store_efectivo');
    Route::get('movimientos/credito', [TransactionController::class, 'credit'])->middleware('can:transactions.credit')->name('transactions.credit');
    Route::get('movimientos/{movimiento}/editar_credito', [TransactionController::class, 'credit_edit'])->middleware('can:transactions.credit_edit')->name('transactions.credit_edit');


    Route::get('movimientos/cajas',         [TransactionController::class, 'index_transferwallet'])->middleware('can:transactions.index_transfer_wallet')->name('transactions.index_transferwallet');
    Route::get('movimientos/entre_cajas',   [TransactionController::class, 'create_transferwallet'])->middleware('can:transactions.transfer_wallet')->name('transactions.create_transferwallet');
    Route::post('movimientos/cajas',        [TransactionController::class, 'transfer_wallet'])->name('transactions.transfer_wallet');

    Route::get('movimientos/cajasop',       [TransactionController::class, 'index_transferwalletop'])->middleware('can:transactions.index_transfer_walletop')->name('transactions.index_transferwalletop');
    Route::get('movimientos/entre_cajasop', [TransactionController::class, 'create_transferwalletop'])->middleware('can:transactions.transfer_walletop')->name('transactions.create_transferwalletop');
    Route::post('movimientos/cajasop',      [TransactionController::class, 'transfer_walletop'])->name('transactions.transfer_walletop');
    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatusop', [TransactionController::class, 'update_statusop'])->name('transactions.update_statusop');
              
    
    Route::get('movimientos/cajasop2',       [TransactionController::class, 'index_transferwalletop2'])->middleware('can:transactions.index_transfer_walletop2')->name('transactions.index_transferwalletop2');
    Route::get('movimientos/entre_cajasop2', [TransactionController::class, 'create_transferwalletop2'])->middleware('can:transactions.transfer_walletop2')->name('transactions.create_transferwalletop2');
    Route::post('movimientos/cajasop2',      [TransactionController::class, 'transfer_walletop2'])->name('transactions.transfer_walletop2');
    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatusop2', [TransactionController::class, 'update_statusop2'])->name('transactions.update_statusop2');



    Route::get('movimientos/indice_pagos',  [TransactionController::class, 'index_pagowallet'])->middleware('can:transactions.index_pagowallet')->name('transactions.index_pagowallet');
    Route::get('movimientos/pago_cajas',    [TransactionController::class, 'create_pagowallet'])->middleware('can:transactions.create_pagowallet')->name('transactions.create_pagowallet');
    Route::post('movimientos/pago',         [TransactionController::class, 'store_pagowallet'])->name('transactions.store_pagowallet');

    Route::get('movimientos/indice_cobros',         [TransactionController::class, 'index_cobrowallet'])->middleware('can:transactions.index_cobrowallet')->name('transactions.index_cobrowallet');
    Route::get('movimientos/cobros_proveedores',    [TransactionController::class, 'create_cobrowallet'])->middleware('can:transactions.create_cobrowallet')->name('transactions.create_cobrowallet');
    Route::post('movimientos/cobro',                [TransactionController::class, 'store_cobrowallet'])->name('transactions.store_cobrowallet');

    Route::get('movimientos/indice_pagoclientes',   [TransactionController::class, 'index_pagoclientes'])->middleware('can:transactions.index_pagoclientes')->name('transactions.index_pagoclientes');
    Route::get('movimientos/pago_clientes',         [TransactionController::class, 'create_pagoclientes'])->middleware('can:transactions.create_pagoclientes')->name('transactions.create_pagoclientes');
    Route::post('movimientos/pgo',                  [TransactionController::class, 'store_pagocliente'])->name('transactions.store_pagocliente');
    Route::post('movimientos/pgo2',                 [TransactionController::class, 'store_pagocliente2'])->name('transactions.store_pagocliente2');

    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus_pagos_cajas',  [TransactionController::class, 'updatestatus_pago'])->name('transactions.updatestatus_pago');
    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus_cajas',        [TransactionController::class, 'updatestatus_transfer'])->name('transactions.updatestatus_transfer');

    Route::resource('movimientos', TransactionController::class)->middleware('auth')->names('transactions');

    Route::get('adquisicion',               [TransactionController::class, 'materials_adquisicion_index']   )->name('materials.adquisicion_index');
    Route::get('adquisicion/create',        [TransactionController::class, 'materials_adquisicion_create']  )->name('materials.adquisicion_create');
    Route::post('adquisicion/store',        [TransactionController::class, 'materials_adquisicion_store']   )->name('materials.adquisicion_store');
    Route::get('adquisicion/edit',          [TransactionController::class, 'materials_adquisicion_edit']    )->name('materials.adquisicion_edit');
    Route::put('adquisicion/{movimiento}',  [TransactionController::class, 'materials_adquisicion_update']  )->middleware('auth')->name('materials.adquisicion_update');
    Route::match(['put', 'patch'], 'adquisicion/{movimiento}/estatus', [TransactionController::class, 'materials_adquisicion_update_status'])->name('materials.adquisicion_update_status');
    Route::get('adquisicion/audit/{movimiento}', [TransactionController::class,'indexAudit'])->middleware('auth')->name('materials.adquisicion_audit');
    

    Route::get('recepcion',                                             [TransactionController::class, 'materials_recepcion_index']   )->name('materials.recepcion_index');
    Route::get('recepcion/create',                                      [TransactionController::class, 'materials_recepcion_create']  )->name('materials.recepcion_create');
    Route::post('recepcion/store',                                      [TransactionController::class, 'materials_recepcion_store']   )->name('materials.recepcion_store');
    Route::get('recepcion/edit',                                        [TransactionController::class, 'materials_recepcion_edit']    )->name('materials.recepcion_edit');
    Route::put('recepcion/{movimiento}',                                [TransactionController::class, 'materials_recepcion_update']  )->middleware('auth')->name('materials.recepcion_update');
    Route::match(['put', 'patch'], 'recepcion/{movimiento}/estatus',    [TransactionController::class, 'materials_recepcion_update_status'])->name('materials.recepcion_update_status');
    Route::get('recepcion/audit/{movimiento}',                          [TransactionController::class,'indexAudit'])->middleware('auth')->name('materials.recepcion_audit');
    
    Route::get('materialsLiquidacion',                                  [App\Http\Controllers\statisticsController::class, 'materialsLiquidacion']  )->name('materialsLiquidacion');
    Route::get('liquidacionAdquisicion',                                [TransactionController::class, 'liquidacion_adquisicion_index']             )->name('materials.liquidacionAdquisicion_index');
    Route::get('liquidacionRecepcion',                                  [TransactionController::class, 'liquidacion_recepcion_index']               )->name('materials.liquidacionRecepcion_index');
    Route::get('liquidacionIndex',                                      [TransactionController::class, 'liquidacion_index']                         )->name('materials.liquidacion_index');

    //Route::get('adquisicion/edit',      [TransactionController::class, 'materials_adquisicion_edit']    )->middleware('auth')->names('materials.adquisicion_edit');

    Route::get('movimientos2/{movimiento}', [TransactionController::class,'edit2'])->middleware('auth')->name('transactions.edit2');

    
    Route::post('movimientos3/store3',           [TransactionController::class,'store3'])->middleware('auth')->name('transactions.store3');
    Route::get('movimientos3/create3',           [TransactionController::class,'create3'])->middleware('auth')->name('transactions.create3');
    Route::get('movimientos3/{movimiento}',      [TransactionController::class,'edit3'])->middleware('auth')->name('transactions.edit3');
    Route::put('movimientos3/{movimiento}',      [TransactionController::class,'update3'])->middleware('auth')->name('transactions.update3');
    Route::get('movimientos3',                   [TransactionController::class,'index3'])->middleware('auth')->name('transactions.index3');
    Route::match(['put', 'patch'], 'movimientos3/{movimiento}/estatus3', [TransactionController::class, 'update_status3'])->name('transactions.update_status3');

    Route::get('movimientosAudit/{movimiento}', [TransactionController::class,'indexAudit'])->middleware('auth')->name('transactions.audit');

    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus', [TransactionController::class, 'update_status'])->name('transactions.update_status');

    Route::post('movimientos/{movimiento}/estatusUpdate', [TransactionController::class, 'update_status_api'])->name('transactions.update_status_api');
    
    Route::delete('movimientos/eliminar/{movimiento}', [TransactionController::class, 'destroyImg'])->name('transactions.destroyimg');

});




Route::pattern('usuarios', '[0-9]+');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('usuarios', UserController::class)->middleware('auth')->middleware('can:users.index')->except('show', 'update', 'edit')->names('users');

    Route::get('/usuarios/editar/{usuario}/', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/usuarios/cambio_contraseña/{usuario}/', [UserController::class, 'password'])->name('users.password');

    Route::match(['put', 'patch'], '/usuarios/cambio_contraseña/{usuario}', [UserController::class, 'update_password'])->name('users.update_password');

    Route::match(['put', 'patch'], '/usuarios/editar/{usuario}', [UserController::class, 'update_users'])->name('users.update_users');

});

// Route::resource('proveedores', SupplierController::class)->middleware('auth')->except('show')->middleware('can:suppliers.index')->names('suppliers');
// Route::resource('clientes', ClientController::class)->middleware('auth')->except('show')->middleware('can:clients.index')->names('clients');
Route::resource('grupos', GroupController::class)->middleware('auth')->except('show')->middleware('can:groups.index')->names('groups');
Route::resource('roles', RoleController::class)->middleware('auth')->except('show')->middleware('can:roles.index')->names('roles');
// Route::resource('cajas', WalletController::class)->middleware('auth')->except('show')->middleware('can:wallets.index')->names('wallets');
Route::resource('tipo_transaccion', Type_transactionController::class)->middleware('auth')->except('show')->middleware('can:type_transactions.index')->names('type_transactions');
Route::resource('tipo_moneda', Type_coinController::class)->middleware('auth')->except('show')->middleware('can:type_coins.index')->names('type_coins');
Route::resource('permisos', PermissionController::class)->middleware('auth')->except('show')->names('permissions');
Route::resource('tipo_material', Type_materialController::class)->middleware('auth')->except('show')->middleware('can:type_materials.index')->names('type_materials');
//
//
// Estadisticas Detalle
//
//
Route::get('estadisticasDetalle',
            [App\Http\Controllers\statisticsController::class, 'index_all2'])
            ->middleware('can:estadisticasDetalle.index')
            ->name('estadisticasDetalle');
//
Route::get('estadisticasDetalle2',
            [App\Http\Controllers\statisticsController::class, 'index_all2'])
            ->name('estadisticasDetalle2');

// Route::get('estadisticasDetalleUsuario',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');
// Route::get('estadisticasDetalleUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');


// Route::get('estadisticasResumenUsuario',[App\Http\Controllers\statisticsController::class, 'userSummary'])->middleware('can:estadisticasDetalle.statisticsResumenUsuario')->name('estadisticasResumenUsuario');
// Route::get('estadisticasResumenUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userSummary'])->name('estadisticasResumenUsuario');

// Route::get('estadisticasResumenCliente',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->middleware('can:estadisticasDetalle.statisticsResumenCliente')->name('estadisticasResumenCliente');
// Route::get('estadisticasResumenCliente/{cliente}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->name('estadisticasResumenCliente');


// moneda
Route::get('estadisticasResumenGrupo',[App\Http\Controllers\statisticsController::class, 'groupSummary2'])->name('estadisticasResumenGrupo');

//
// Resumen Wallet Transaccion
//
Route::get('estadisticasResumenWalletTran',[App\Http\Controllers\statisticsController::class, 'walletTransactionSummary'])->name('estadisticasResumenWalletTran');
//
// Resumen Wallet Transaccion grupo
//
Route::get('estadisticasResumenWalletTranGroup',[App\Http\Controllers\statisticsController::class, 'walletTransactionGroupSummary'])->name('estadisticasResumenWalletTranGroup');
//
// Resumen Fecha Tokens
//
Route::get('estadisticasFechaTokens',[App\Http\Controllers\statisticsController::class, 'fechaTokensSummary'])->name('estadisticasFechaTokens');
//
//
Route::get('estadisticasResumenWallet',[App\Http\Controllers\statisticsController::class, 'walletSummary'])->middleware('can:estadisticasDetalle.statisticsResumenWallet')->name('estadisticasResumenWallet');

Route::get('materialsAdquisicionConsolidado',[App\Http\Controllers\statisticsController::class, 'materials_adquisicion_consolidado2'])->name('materialsAdquisicionConsolidado');

Route::get('materialsAdquisicionResumenGrupo',[App\Http\Controllers\statisticsController::class, 'materialsAdquisicionResumenGrupo'])->name('materialsAdquisicionResumenGrupo');

Route::get('materialPosicionConsolidadaGrupo',[App\Http\Controllers\statisticsController::class, 'materialPosicionConsolidadaGrupo'])->name('materialPosicionConsolidadaGrupo');

Route::get('materialsLiquidacionCuentaGrupo',[App\Http\Controllers\statisticsController::class, 'materialsLiquidacionCuentaGrupo'])->name('materialsLiquidacionCuentaGrupo');

Route::get('materialsLiquidacionCuentaGrupoProcess',[App\Http\Controllers\statisticsController::class, 'materialsLiquidacionCuentaGrupoProcess'])->name('materialsLiquidacionCuentaGrupoProcess');

?>
