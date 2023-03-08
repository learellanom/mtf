<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ClientController;
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

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('usuarios', UserController::class)->except('show')->names('users');
Route::resource('movimientos', TransactionController::class)->names('transactions');
Route::resource('clientes', ClientController::class)->except('show')->names('clients');
<<<<<<< HEAD
Route::resource('roles', RoleController::class)->except('show')->names('roles');
=======

Route::resource('agentes', AgenteController::class)->except('show')->names('agentes');

Route::get('agentes', function () {
    return view('agentes.index');
});

>>>>>>> 63a84d9766318e1634721bf7c3d286142235512a

Route::get('comanda', function () {
    return view('master.comanda');
});


Route::get('caja', function () {
    return view('master.caja');
});

Route::get('dashboardest', function () {
    return view('dashboardest');
});
