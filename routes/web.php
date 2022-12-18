<?php

use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return redirect('/invoices');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::resources([
        'invoices' => InvoiceController::class,
        'invoices.invoice_items' => InvoiceItemController::class,
    ]);

    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
});
