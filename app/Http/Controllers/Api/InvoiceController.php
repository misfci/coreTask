<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\RecordPaymentRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\ContractSummaryResource;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService
    ) {}

    // 1. عرض قائمة فواتير عقد معين (مع فلترة) - ميثود جديدة
    public function index(Request $request, Contract $contract): JsonResponse
    {
        $this->authorize('view', $contract); // التأكد من الصلاحية

        $invoices = $contract->invoices()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate();

        return InvoiceResource::collection($invoices)->response();
    }

    // 2. إنشاء فاتورة لعقد (تم تعديل المسار والـ Authorize)
    public function store(StoreInvoiceRequest $request, Contract $contract): JsonResponse
    {
        $this->authorize('create', [Invoice::class, $contract]);

        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        $invoice = $this->invoiceService->createInvoice($dto);

        return InvoiceResource::make($invoice)->response()->setStatusCode(201);
    }

    // 3. عرض تفاصيل فاتورة واحدة - ميثود جديدة
    public function show(Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);
        
        return InvoiceResource::make($invoice->load(['contract', 'payments']))->response();
    }

    // 4. تسجيل دفع (تم إضافة الـ Authorize)
    public function pay(RecordPaymentRequest $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('recordPayment', $invoice);

        $dto = RecordPaymentDTO::fromRequest($request, $invoice);
        $payment = $this->invoiceService->recordPayment($dto);

        return PaymentResource::make($payment)->response();
    }

    // 5. الملخص المالي
    public function summary(int $contractId): JsonResponse
    {
        // ملاحظة: الـ Authorize هنا بتم جوه الـ Service أو باستخدام Contract Model
        $summaryData = $this->invoiceService->getContractSummary($contractId);
        return ContractSummaryResource::make($summaryData)->response();
    }
}