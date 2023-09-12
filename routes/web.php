<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionMasterController;
use App\Http\Controllers\TransactionSupplierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Type_transactionController;
use App\Http\Controllers\Type_coinController;

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
Route::get('dashboardest/{wallet}', [App\Http\Controllers\HomeController::class, 'graphics'])->name('dashboardest');
Route::get('dashboardest/{wallet}/{transaction?}/', [App\Http\Controllers\HomeController::class, 'graphics'])->name('dashboardest');
Route::get('dashboardest/{wallet}/{transaction?}/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'graphics'])->name('dashboardest');

Route::get('dashboardSaldos', [App\Http\Controllers\HomeController::class, 'saldos'])->name('dashboardSaldos');
Route::get('dashboardSaldos/{fechaDesde?}/{fechaHasta?}', [App\Http\Controllers\HomeController::class, 'saldos'])->name('dashboardSaldos');


Route::get('dashboard_est/export/', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet}', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet}/{transaction?}/', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_est/export/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', [App\Http\Controllers\HomeController::class, 'export'])->name('exports.excel'); //EXPORTACIÓN DE EXCEL


Route::get('dashboardest/exportpdf/',                           
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet}',                   
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet}/{transaction?}/',   
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF
Route::get('dashboardest/exportpdf/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}/{ocultarresumengeneral?}/{ocultarresumentransaccion?}/{transactions?}', 
            [App\Http\Controllers\HomeController::class, 'exportPDF'])->name('exports.EstadisticaPDF'); //EXPORTACIÓN DE PDF



Route::get('dashboard_saldos/export/', [App\Http\Controllers\HomeController::class, 'exportSaldos'])->name('exports.saldos'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_saldos/export/{fechaDesde?}/{fechaHasta?}/{filtroWallet?}/{filtroGroup?}/{filtroWalletB?}/{filtroGroupB?}/{resumen?}', [App\Http\Controllers\HomeController::class, 'exportSaldos'])->name('exports.saldos'); //EXPORTACIÓN DE EXCEL

Route::get('dashboard_saldos/exportSaldosPDF/', [App\Http\Controllers\HomeController::class, 'exportSaldosPDF'])->name('exports.SaldosPDF'); //EXPORTACIÓN DE EXCEL
Route::get('dashboard_saldos/exportSaldosPDF/{fechaDesde?}/{fechaHasta?}/{filtroWallet?}/{filtroGroup?}/{filtroWalletB?}/{filtroGroupB?}/{resumen?}', [App\Http\Controllers\HomeController::class, 'exportSaldosPDF'])->name('exports.SaldosPDF'); //EXPORTACIÓN DE EXCEL


Route::get('filtrosLeeWallet', [App\Http\Controllers\statisticsController::class, 'filtrosLeeWallet'])->name('filtrosLeeWallet'); // Lee filtros
Route::get('filtrosLeeGroup', [App\Http\Controllers\statisticsController::class, 'filtrosLeeGroup'])->name('filtrosLeeGroup'); // Lee filtros


Route::get('filtrosLeeWalletB', [App\Http\Controllers\statisticsController::class, 'filtrosLeeWalletB'])->name('filtrosLeeWalletB'); // Lee filtros
Route::get('filtrosLeeGroupB', [App\Http\Controllers\statisticsController::class, 'filtrosLeeGroupB'])->name('filtrosLeeGroupB'); // Lee filtros

Route::post('filtrosGrabaWallet', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaWallet'])->name('filtrosGrabaWallet'); // Lee filtros
Route::post('filtrosGrabaGroup', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaGroup'])->name('filtrosGrabaGroup'); // Lee filtros



Route::post('filtrosGrabaEstadisticas', [App\Http\Controllers\statisticsController::class, 'filtrosGrabaEstadisticas'])->name('filtrosGrabaEstadisticas'); // Lee filtros





/* TRANSACCIONES A CLIENTES */
Route::group(['middleware' => 'auth'], function () {
    Route::get('movimientos/efectivo', [TransactionController::class, 'create_efectivo'])->middleware('can:transactions.create_efectivo')->name('transactions.create_efectivo');
    Route::get('movimientos/{movimiento}/editar_efectivo', [TransactionController::class, 'edit_efectivo'])->middleware('can:transactions.edit_efectivo')->name('transactions.edit_efectivo');
    Route::post('movimientos/crear_efectivo', [TransactionController::class, 'store_efectivo'])->name('transactions.store_efectivo');
    Route::get('movimientos/credito', [TransactionController::class, 'credit'])->middleware('can:transactions.credit')->name('transactions.credit');
    Route::get('movimientos/{movimiento}/editar_credito', [TransactionController::class, 'credit_edit'])->middleware('can:transactions.credit_edit')->name('transactions.credit_edit');


    Route::get('movimientos/cajas', [TransactionController::class, 'index_transferwallet'])->middleware('can:transactions.index_transfer_wallet')->name('transactions.index_transferwallet');
    Route::get('movimientos/entre_cajas', [TransactionController::class, 'create_transferwallet'])->middleware('can:transactions.transfer_wallet')->name('transactions.create_transferwallet');
    Route::post('movimientos/cajas', [TransactionController::class, 'transfer_wallet'])->name('transactions.transfer_wallet');


    Route::get('movimientos/indice_pagos', [TransactionController::class, 'index_pagowallet'])->middleware('can:transactions.index_pagowallet')->name('transactions.index_pagowallet');
    Route::get('movimientos/pago_cajas', [TransactionController::class, 'create_pagowallet'])->middleware('can:transactions.create_pagowallet')->name('transactions.create_pagowallet');
    Route::post('movimientos/pago', [TransactionController::class, 'store_pagowallet'])->name('transactions.store_pagowallet');

    Route::get('movimientos/indice_cobros', [TransactionController::class, 'index_cobrowallet'])->middleware('can:transactions.index_cobrowallet')->name('transactions.index_cobrowallet');
    Route::get('movimientos/cobros_proveedores', [TransactionController::class, 'create_cobrowallet'])->middleware('can:transactions.create_cobrowallet')->name('transactions.create_cobrowallet');
    Route::post('movimientos/cobro', [TransactionController::class, 'store_cobrowallet'])->name('transactions.store_cobrowallet');

    Route::get('movimientos/indice_pagoclientes', [TransactionController::class, 'index_pagoclientes'])->middleware('can:transactions.index_pagoclientes')->name('transactions.index_pagoclientes');
    Route::get('movimientos/pago_clientes', [TransactionController::class, 'create_pagoclientes'])->middleware('can:transactions.create_pagoclientes')->name('transactions.create_pagoclientes');
    Route::post('movimientos/pgo', [TransactionController::class, 'store_pagocliente'])->name('transactions.store_pagocliente');
  
    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus_pagos_cajas', [TransactionController::class, 'updatestatus_pago'])->name('transactions.updatestatus_pago');
    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus_cajas', [TransactionController::class, 'updatestatus_transfer'])->name('transactions.updatestatus_transfer');

    Route::resource('movimientos', TransactionController::class)->middleware('auth')->names('transactions');

    Route::get('movimientos2/{movimiento}', [TransactionController::class,'edit2'])->middleware('auth')->name('transactions.edit2');

    Route::match(['put', 'patch'], 'movimientos/{movimiento}/estatus', [TransactionController::class, 'update_status'])->name('transactions.update_status');
    Route::delete('movimientos/eliminar/{movimiento}', [TransactionController::class, 'destroyImg'])->name('transactions.destroyimg');

});

/* TRANSACCIONES A MASTER */
Route::group(['middleware' => 'auth'], function () {

    Route::get('movimientos_master/credito', [TransactionMasterController::class, 'credit'])->middleware('can:transactions_master.index')->name('transactions_master.credit');
    Route::get('movimientos_master/editar_credito', [TransactionMasterController::class, 'credit_edit'])->middleware('can:transactions_master.index')->name('transactions_master.credit_edit');
    Route::resource('movimientos_master', TransactionMasterController::class)->middleware('auth')->middleware('can:transactions_master.index')->names('transactions_master');
    Route::match(['put', 'patch'], 'movimientos_master/{movimiento}/estatus', [TransactionMasterController::class, 'update_status'])->name('transactions_master.update_status');
    Route::delete('movimientos_master/eliminar/{movimiento}', [TransactionMasterController::class, 'destroyImg'])->middleware('can:transactions_master.index')->name('transactions_master.destroyimg');

});

/* TRANSACCIONES A PROVEEDORES */
Route::group(['middleware' => 'auth'], function () {

    //Route::get('movimientos_proveedores/credito', [TransactionSupplierController::class, 'credit'])->middleware('can:transactions_supplier.index')->name('transactions_supplier.credit');
    //Route::get('movimientos_proveedores/editar_credito', [TransactionSupplierController::class, 'credit_edit'])->middleware('can:transactions_supplier.index')->name('transactions_supplier.credit_edit');
    Route::resource('movimientos_proveedores', TransactionSupplierController::class)->middleware('auth')->middleware('can:transactions_supplier.index')->names('transactions_supplier');
    Route::match(['put', 'patch'], 'movimientos_proveedores/{movimiento}/estatus', [TransactionSupplierController::class, 'update_status'])->name('transactions_supplier.update_status');
    Route::delete('movimientos_proveedores/eliminar/{movimiento}', [TransactionSupplierController::class, 'destroyImg'])->middleware('can:transactions_supplier.index')->name('transactions_supplier.destroyimg');

});

Route::pattern('usuarios', '[0-9]+');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('usuarios', UserController::class)->middleware('auth')->middleware('can:users.index')->except('show', 'update', 'edit')->names('users');

    Route::get('/usuarios/editar/{usuario}/', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/usuarios/cambio_contraseña/{usuario}/', [UserController::class, 'password'])->name('users.password');

    Route::match(['put', 'patch'], '/usuarios/cambio_contraseña/{usuario}', [UserController::class, 'update_password'])->name('users.update_password');

    Route::match(['put', 'patch'], '/usuarios/editar/{usuario}', [UserController::class, 'update_users'])->name('users.update_users');

});

Route::resource('proveedores', SupplierController::class)->middleware('auth')->except('show')->middleware('can:suppliers.index')->names('suppliers');
Route::resource('clientes', ClientController::class)->middleware('auth')->except('show')->middleware('can:clients.index')->names('clients');
Route::resource('grupos', GroupController::class)->middleware('auth')->except('show')->middleware('can:groups.index')->names('groups');
Route::resource('roles', RoleController::class)->middleware('auth')->except('show')->middleware('can:roles.index')->names('roles');
Route::resource('cajas', WalletController::class)->middleware('auth')->except('show')->middleware('can:wallets.index')->names('wallets');
Route::resource('tipo_transaccion', Type_transactionController::class)->middleware('auth')->except('show')->middleware('can:type_transactions.index')->names('type_transactions');
Route::resource('tipo_moneda', Type_coinController::class)->middleware('auth')->except('show')->middleware('can:type_coins.index')->names('type_coins');
Route::resource('permisos', PermissionController::class)->middleware('auth')->except('show')->names('permissions');
//
//
// Estadisticas Detalle
//
//
Route::get('estadisticasDetalle',[App\Http\Controllers\statisticsController::class, 'index_all'])
            ->middleware('can:estadisticasDetalle.index')
            ->name('estadisticasDetalle');

Route::get('estadisticasDetalle/{usuario}/{grupo?}/{wallet?}/{typeTransactions?}/{fechaDesde?}/{fechaHasta?}/{token?}',[App\Http\Controllers\statisticsController::class, 'index_all'])
            ->middleware('can:estadisticasDetalle.index')
            ->name('estadisticasDetalle');
//
//
//
// Route::get('estadisticasDetalleUsuario',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');
// Route::get('estadisticasDetalleUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');


Route::get('estadisticasResumenUsuario',[App\Http\Controllers\statisticsController::class, 'userSummary'])->middleware('can:estadisticasDetalle.statisticsResumenUsuario')->name('estadisticasResumenUsuario');
Route::get('estadisticasResumenUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userSummary'])->name('estadisticasResumenUsuario');

Route::get('estadisticasResumenCliente',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->middleware('can:estadisticasDetalle.statisticsResumenCliente')->name('estadisticasResumenCliente');
Route::get('estadisticasResumenCliente/{cliente}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->name('estadisticasResumenCliente');

Route::get('estadisticasResumenGrupo',[App\Http\Controllers\statisticsController::class, 'groupSummary'])->name('estadisticasResumenGrupo');
Route::get('estadisticasResumenGrupo/{grupo}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'groupSummary'])->name('estadisticasResumenGrupo');
//
// Resumen Wallet Transaccion
//
Route::get('estadisticasResumenWalletTran',[App\Http\Controllers\statisticsController::class, 'walletTransactionSummary'])->name('estadisticasResumenWalletTran');
Route::get('estadisticasResumenWalletTran/{wallet?}/{transaction?}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'walletTransactionSummary'])->name('estadisticasResumenWalletTran');

//
// Resumen Wallet Transaccion grupo
//
Route::get('estadisticasResumenWalletTranGroup',[App\Http\Controllers\statisticsController::class, 'walletTransactionGroupSummary'])->name('estadisticasResumenWalletTranGroup');
Route::get('estadisticasResumenWalletTranGroup/{wallet?}/{transaction?}/{group?}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'walletTransactionGroupSummary'])->name('estadisticasResumenWalletTranGroup');
//
// Resumen Fecha Tokens
//
Route::get('estadisticasFechaTokens',[App\Http\Controllers\statisticsController::class, 'fechaTokensSummary'])->name('estadisticasFechaTokens');
Route::get('estadisticasFechaTokens/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'fechaTokensSummary'])->name('estadisticasFechaTokens');

//
//
Route::get('estadisticasResumenWallet',[App\Http\Controllers\statisticsController::class, 'walletSummary'])->middleware('can:estadisticasDetalle.statisticsResumenWallet')->name('estadisticasResumenWallet');
Route::get('estadisticasResumenWallet/{wallet}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'walletSummary'])->name('estadisticasResumenWallet');

//

Route::get('estadisticasResumenWalletMaster',[App\Http\Controllers\statisticsController::class, 'walletSummary'])
    ->middleware('can:estadisticasDetalle.estadisticasResumenWalletMaster')
    ->name('estadisticasResumenWalletMaster');

Route::get('estadisticasResumenWalletMaster/{wallet}/{fechaDesde?}/{fechaHasta?}/{master?}',
    [App\Http\Controllers\statisticsController::class, 'walletSummary'])
    ->name('estadisticasResumenWalletMaster');
//

Route::get('estadisticasResumenTransaccion',[App\Http\Controllers\statisticsController::class, 'transactionSummary'])->name('estadisticasResumenTransaccion');
Route::get('estadisticasResumenTransaccion/{type_transaction?}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'transactionSummary'])->name('estadisticasResumenTransaccion');

Route::get('estadisticasResumenGrupo',[App\Http\Controllers\statisticsController::class, 'groupSummary'])->name('estadisticasResumenGrupo');
Route::get('estadisticasResumenGrupo/{grupo}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'groupSummary'])->name('estadisticasResumenGrupo');
//
Route::get('estadisticasResumenGrupoWallet',[App\Http\Controllers\statisticsController::class, 'groupSummaryWallet'])->name('estadisticasResumenGrupoWallet');
Route::get('estadisticasResumenGrupoWallet/{grupo}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'groupSummaryWallet'])->name('estadisticasResumenGrupoWallet');


Route::get('estadisticasConciliacionGrupo',[App\Http\Controllers\statisticsController::class, 'conciliationSummaryDateGroup'])->name('estadisticasConciliacionGrupo');
Route::get('estadisticasConciliacionGrupo/{grupo}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'conciliationSummaryDateGroup'])->name('estadisticasConciliacionGrupo');

Route::get('estadisticasConciliacionFecha',[App\Http\Controllers\statisticsController::class, 'conciliationSummaryDate'])->name('estadisticasConciliacionFecha');
Route::get('estadisticasConciliacionFecha/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'conciliationSummaryDate'])->name('estadisticasConciliacionFecha');

?>
