<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmtpController;

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

require __DIR__.'/auth.php';
