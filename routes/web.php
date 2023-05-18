<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\auth;

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
    return view('welcome');
});

auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('services', ServiceController::class);
});
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/services/{service}/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/services/{service}/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

Route::post('/pay', [PaystackController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaystackController::class, 'handleGatewayCallback']);