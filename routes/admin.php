<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ClientController;
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


Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';
Auth::routes();




    Route::get('/offline', function(){
        return view('vendor.laravelpwa.offline');
    });

    //
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('admin.home');

    Route::resource('usuarios', UserController::class)->middleware('auth')->except('show')->names('admin.users');
    Route::resource('movimientos', TransactionController::class)->middleware('auth')->names('admin.transactions');
    Route::resource('clientes', ClientController::class)->middleware('auth')->except('show')->names('admin.clients');
    Route::resource('roles', RoleController::class)->middleware('auth')->except('show')->names('admin.roles');

    //Route::resource('agentes', AgenteController::class)->middleware('auth')->except('show')->names('admin.agentes');






?>
