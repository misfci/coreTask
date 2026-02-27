<?php

if (app()->environment('local')) {
    auth()->loginUsingId(1);
}
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Billing System API Routes (Refactored to match PDF Page 7)
|--------------------------------------------------------------------------
*/

Route::prefix('billing')->group(function () {

    // 1. عرض قائمة فواتير عقد مع الفلترة (GET /api/contracts/{id}/invoices)
    Route::get('contracts/{contract}/invoices', [InvoiceController::class, 'index']);

    // 2. إنشاء فاتورة لعقد (POST /api/contracts/{id}/invoices)
    Route::post('contracts/{contract}/invoices', [InvoiceController::class, 'store']);

    // 3. عرض تفاصيل فاتورة واحدة مع مدفوعاتها (GET /api/invoices/{id})
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);

    // 4. تسجيل عملية دفع (POST /api/invoices/{id}/payments)
    Route::post('invoices/{invoice}/payments', [InvoiceController::class, 'pay']);

    // 5. الملخص المالي للعقد (GET /api/contracts/{id}/summary)
    Route::get('contracts/{contractId}/summary', [InvoiceController::class, 'summary']);

});