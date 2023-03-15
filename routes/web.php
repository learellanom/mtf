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
Route::get('/offline', function(){
    return view('vendor.laravelpwa.offline');
});

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


Route::resource('movimientos', TransactionController::class)->middleware('auth')->names('transactions');
Route::resource('usuarios', UserController::class)->middleware('auth')->except('show')->names('users');

Route::middleware('auth')->group(function () {
Route::get('/usuarios/{usuario}/cambio_contraseña', [UserController::class, 'password'])->name('users.password');
Route::put('/usuarios/{usuario}', [UserController::class, 'password_update'])->name('users.paswordupdate');
});

Route::resource('clientes', ClientController::class)->middleware('auth')->except('show')->names('clients');
Route::resource('grupos', GroupController::class)->middleware('auth')->except('show')->names('groups');
Route::resource('roles', RoleController::class)->middleware('auth')->except('show')->names('roles');
Route::resource('cajas', WalletController::class)->middleware('auth')->except('show')->names('wallets');
Route::resource('tipo_transaccion', Type_transactionController::class)->middleware('auth')->except('show')->names('type_transactions');
Route::resource('tipo_moneda', Type_coinController::class)->middleware('auth')->except('show')->names('type_coins');


Route::get('agentes',[App\Http\Controllers\UserController::class, 'index_all'])->name('agentes');


Route::get('comanda', function () {
    return view('master.comanda');
})->name('comanda');

Route::get('dashboardest', function () {
    return view('dashboardest');
});

?>
