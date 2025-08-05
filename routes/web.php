<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipientController;

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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('recipients', RecipientController::class);
Route::get('/recipients/{recipient}/qr-code', [RecipientController::class, 'generateQrCode'])->name('recipients.qr-code');
Route::get('/recipients/{recipient}/qr-print', [RecipientController::class, 'printQrCode'])->name('recipients.qr-print');
Route::get('/scan', [RecipientController::class, 'scanQr'])->name('recipients.scan');
Route::post('/verify-qr', [RecipientController::class, 'verifyQr'])->name('recipients.verify-qr');
Route::post('/recipients/{recipient}/distribute', [RecipientController::class, 'distribute'])->name('recipients.distribute');
Route::get('/recipients/{recipient}/receipt', [RecipientController::class, 'generateReceipt'])->name('recipients.receipt');
