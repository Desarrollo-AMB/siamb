<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FormaFAMController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\PersonalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [LoginController::class, 'logout']);
Route::group(['middleware' => ['auth','access']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::delete('permissions', [PermissionController::class, 'clean'])->name('permissions.clean'); 
    
    Route::get('/sireh/ingreso_personal', [PersonalController::class, 'ingresoPersonal'])->name('sireh.ingreso-personal');
    Route::post('/sireh/ingreso_personal', [PersonalController::class, 'registraPersonal'])->name('sireh.registra-personal');
    
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', function () {
		return view('home');
	})->name('dashboard');
    Route::get('profile', [ProfilesController::class, 'show'])->name('profile');
    Route::post('update-profile/{user}', [ProfilesController::class, 'updateProfile'])->name('profile.update');
     
});

//RUTA FORMULARIO FAM002 
Route::group(['middleware' => ['auth']], function() {
    Route::get('FormaFAM',             [FormaFAMController::class, 'index'])->name('FormaFAM');
    Route::get('aeronaves_grupos',     [FormaFAMController::class, 'aeronaves_grupos'])->name('aeronaves_grupos'); 
    Route::get('seriales',             [FormaFAMController::class, 'seriales'])->name('seriales'); 
    Route::get('matriculas',           [FormaFAMController::class, 'matriculas'])->name('matriculas'); 
    
    Route::post('steps',               [FormaFAMController::class, 'steps'])->name('steps'); 
    Route::post('store_header',        [FormaFAMController::class, 'store'])->name('store_header'); 
    Route::post('store_a1',            [FormaFAMController::class, 'store_a1'])->name('store_a1'); 
    Route::post('consumibles',         [FormaFAMController::class, 'consumibles'])->name('consumibles'); 
    Route::post('store_a1_consumibles',[FormaFAMController::class, 'store_a1_consumibles'])->name('store_a1_consumibles'); 
});

Route::get('no_authorize', function () {
    return view('no_authorize');
})->name('no_authorize');