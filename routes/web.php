<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

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

Route::get('/', function () {return inertia('Index'); });

Route::resource('/staffs', App\Http\Controllers\StaffController::class);
Route::middleware(['auth'])->group(function () {
    Route::resource('/home', App\Http\Controllers\HomeController::class);

    Route::middleware([RoleMiddleware::class])->group(function () {
        Route::resource('/services', App\Http\Controllers\ServiceController::class);
        Route::resource('/clients', App\Http\Controllers\ClientController::class);
        Route::resource('/aestheticians', App\Http\Controllers\AestheticianController::class);
        Route::resource('/appointments', App\Http\Controllers\AppointmentController::class);
        Route::resource('/reviews', App\Http\Controllers\ReviewController::class);
    });
});

require __DIR__.'/authentication.php';
