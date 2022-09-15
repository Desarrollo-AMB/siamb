<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfilesController;
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

    Route::get('form', [FormController::class, 'index'])->name('form');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', function () {
		return view('home');
	})->name('dashboard');
    Route::get('profile', [ProfilesController::class, 'show'])->name('profile');
    Route::post('update-profile/{user}', [ProfilesController::class, 'updateProfile'])->name('profile.update');
});

Route::get('no_authorize', function () {
    return view('no_authorize');
})->name('no_authorize');