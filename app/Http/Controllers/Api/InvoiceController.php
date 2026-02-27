<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use App\DTO\CreateInvoiceDTO;
use App\DTO\RecordPaymentDTO;
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
    ) {
    }

    public function index(Request $request, Contract $contract): JsonResponse
    {
        $this->authorize('view', $contract);

        $invoices = $contract->invoices()
        ->when($request->status, fn($q) => $q->where('status', $request->status))

        ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))

        ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))

        ->latest()
        ->paginate();

        return InvoiceResource::collection($invoices)->response();
    }

    public function store(StoreInvoiceRequest $request, Contract $contract): JsonResponse
    {
        $this->authorize('create', [Invoice::class, $contract]);

        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        $invoice = $this->invoiceService->createInvoice($dto);

        return InvoiceResource::make($invoice)->response()->setStatusCode(201);
    }

    public function show(Invoice $invoice): JsonResponse
    {
        $this->authorize('show', $invoice);

        return InvoiceResource::make($invoice->load(['contract', 'payments']))->response();
    }

    public function pay(RecordPaymentRequest $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('recordPayment', $invoice);

        $dto = RecordPaymentDTO::fromRequest($request, $invoice);
        $payment = $this->invoiceService->recordPayment($dto);

        return PaymentResource::make($payment)->response();
    }

    public function summary(Contract $contract): JsonResponse
    {
        $this->authorize('view', $contract);

        $summaryData = $this->invoiceService->getContractSummary($contract->id);
        return ContractSummaryResource::make($summaryData)->response();
    }
}
