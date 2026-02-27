<?php

if (app()->environment('local')) {
    auth()->loginUsingId(1);
}
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('billing')->group(function () {

    Route::get('contracts/{contract}/invoices', [InvoiceController::class, 'index']);

    Route::post('contracts/{contract}/invoices', [InvoiceController::class, 'store']);

    Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);

    Route::post('invoices/{invoice}/payments', [InvoiceController::class, 'pay']);

    Route::get('contracts/{contract}/summary', [InvoiceController::class, 'summary']);

});