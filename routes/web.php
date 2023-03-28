<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\WalletController;
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
Route::get('/offline', function () {     return view('vendor/laravelpwa/offline'); });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified']);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
Route::resource('movimientos', TransactionController::class)->middleware('auth')->names('transactions');
Route::delete('movimientos/eliminar/{movimiento}', [TransactionController::class, 'destroyImg'])->name('transactions.destroyimg');
});


Route::pattern('usuarios', '[0-9]+');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('usuarios', UserController::class)->middleware('auth')->except('show', 'update', 'edit')->names('users');

    Route::get('/usuarios/editar/{usuario}/', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/usuarios/cambio_contraseña/{usuario}/', [UserController::class, 'password'])->name('users.password');

    Route::match(['put', 'patch'], '/usuarios/cambio_contraseña/{usuario}', [UserController::class, 'update_password'])->name('users.update_password');

    Route::match(['put', 'patch'], '/usuarios/editar/{usuario}', [UserController::class, 'update_users'])->name('users.update_users');

});


Route::resource('clientes', ClientController::class)->middleware('auth')->except('show')->names('clients');
Route::resource('grupos', GroupController::class)->middleware('auth')->except('show')->names('groups');
Route::resource('roles', RoleController::class)->middleware('auth')->except('show')->names('roles');
Route::resource('cajas', WalletController::class)->middleware('auth')->except('show')->names('wallets');
Route::resource('tipo_transaccion', Type_transactionController::class)->middleware('auth')->except('show')->names('type_transactions');
Route::resource('tipo_moneda', Type_coinController::class)->middleware('auth')->except('show')->names('type_coins');


Route::get('estadisticasDetalle',[App\Http\Controllers\UserController::class, 'index_all'])->name('estadisticasDetalle');
Route::get('estadisticasDetalle/{usuario}/{cliente?}/{wallet?}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\UserController::class, 'index_all'])->name('estadisticasDetalle');

// Route::get('estadisticasDetalleUsuario',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');
// Route::get('estadisticasDetalleUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userDetail'])->name('estadisticasDetalleUsuario');


Route::get('estadisticasResumenUsuario',[App\Http\Controllers\statisticsController::class, 'userSummary'])->name('estadisticasResumenUsuario');
Route::get('estadisticasResumenUsuario/{usuario}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'userSummary'])->name('estadisticasResumenUsuario');

Route::get('estadisticasResumenCliente',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->name('estadisticasResumenCliente');
Route::get('estadisticasResumenCliente/{cliente}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'clientSummary'])->name('estadisticasResumenCliente');


Route::get('estadisticasResumenWallet',[App\Http\Controllers\statisticsController::class, 'walletSummary'])->name('estadisticasResumenWallet');
Route::get('estadisticasResumenWallet/{wallet}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'walletSummary'])->name('estadisticasResumenWallet');


Route::get('estadisticasResumenTransaccion',[App\Http\Controllers\statisticsController::class, 'transactionSummary'])->name('estadisticasResumenTransaccion');
Route::get('estadisticasResumenTransaccion/{type_transaction?}/{fechaDesde?}/{fechaHasta?}',[App\Http\Controllers\statisticsController::class, 'transactionSummary'])->name('estadisticasResumenTransaccion');



Route::get('comanda', function () {
    return view('master.comanda');
})->name('comanda');

Route::get('dashboardest', function () {
    return view('dashboardest');
})->name('dashboardtest');


Route::post('/darkmode/toggle', [DarkModeController::class, 'toggle'])
    ->name('darkmode.toggle');


?>
