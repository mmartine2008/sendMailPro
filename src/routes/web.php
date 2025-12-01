<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\MensajeProgramadoController;

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

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('emails', EmailController::class);
    Route::post('emails/import', [EmailController::class, 'import'])->name('emails.import');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/smtp', [SmtpController::class, 'index'])->name('smtp.index');
    Route::get('/smtp/create', [SmtpController::class, 'create'])->name('smtp.create');
    Route::post('/smtp', [SmtpController::class, 'store'])->name('smtp.store');
    Route::get('/smtp/{smtp}/edit', [SmtpController::class, 'edit'])->name('smtp.edit');
    Route::put('/smtp/{smtp}', [SmtpController::class, 'update'])->name('smtp.update');
    Route::delete('/smtp/{smtp}', [SmtpController::class, 'destroy'])->name('smtp.destroy');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/cuentas', [CuentaController::class, 'index'])->name('cuentas.index');
    Route::get('/cuentas/create', [CuentaController::class, 'create'])->name('cuentas.create');
    Route::post('/cuentas', [CuentaController::class, 'store'])->name('cuentas.store');
    Route::get('/cuentas/{cuenta}/edit', [CuentaController::class, 'edit'])->name('cuentas.edit');
    Route::put('/cuentas/{cuenta}', [CuentaController::class, 'update'])->name('cuentas.update');
    Route::delete('/cuentas/{cuenta}', [CuentaController::class, 'destroy'])->name('cuentas.destroy');

    Route::resource('mensajes', MensajeProgramadoController::class);

});

require __DIR__.'/auth.php';
