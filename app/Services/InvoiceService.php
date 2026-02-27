<?php
namespace App\Services;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\Interfaces\ContractRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Models\Invoice;
use App\Models\Payment;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use Illuminate\Support\Facades\DB;
use Exception;

class InvoiceService 
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService,
    ) {}

    public function createInvoice($dto): Invoice 
    {
        return DB::transaction(function () use ($dto) {
            $contract = $this->contractRepo->findById($dto->contractId);
            if (!$contract || $contract->status->value !== ContractStatus::ACTIVE->value) {
                throw new Exception("Cannot create invoice for a non-active contract.");
            }

            $tax = $this->taxService->calculateTax($contract->rent_amount);
            $total = $contract->rent_amount + $tax;

            $invoiceNumber = sprintf(
                "INV-%03d-%s-%04d",
                $contract->tenant_id,
                now()->format('Ym'),
                rand(1, 9999) 
            );

            return $this->invoiceRepo->create([
                'contract_id'    => $contract->id,
                'tenant_id'      => $contract->tenant_id,
                'invoice_number' => $invoiceNumber,
                'subtotal'       => $contract->rent_amount,
                'tax_amount'     => $tax,
                'total'          => $total,
                'status'         => InvoiceStatus::PENDING,
                'due_date'       => now()->addDays(30),
            ]);
        });
    }

    public function recordPayment($dto): Payment 
    {
        return DB::transaction(function () use ($dto) {
            $invoice = $this->invoiceRepo->findById($dto->invoiceId);
            if (!$invoice) throw new Exception("Invoice not found.");

            $paidAlready = $invoice->payments()->sum('amount');
            $remaining = $invoice->total - $paidAlready;

            if ($dto->amount > $remaining) {
                throw new Exception("Payment exceeds the remaining balance.");
            }

            $payment = $this->paymentRepo->create([
                'invoice_id'     => $invoice->id,
                'amount'         => $dto->amount,
                'payment_method' => $dto->paymentMethod,
                'paid_at'        => now(),
            ]);

            $newTotalPaid = $paidAlready + $dto->amount;
            
            $newStatus = ($newTotalPaid >= $invoice->total) 
                ? InvoiceStatus::PAID 
                : InvoiceStatus::PARTIALLY_PAID;

            $invoice->update(['status' => $newStatus]);

            return $payment;
        });
    }

    public function getContractSummary(int $contractId): array 
    {
        $contract = $this->contractRepo->findById($contractId);
        if (!$contract) throw new Exception("Contract not found.");

        $invoices = $this->invoiceRepo->getByContract($contractId);
        
        $totalInvoiced = $invoices->sum('total');
        $totalPaid = $invoices->flatMap->payments->sum('amount');

        return [
            'contract_id'         => $contract->id,
            'total_invoiced'      => $totalInvoiced,
            'total_paid'          => $totalPaid,
            'outstanding_balance' => $totalInvoiced - $totalPaid,
            'invoices_count'      => $invoices->count(),
            'latest_invoice_date' => $invoices->max('created_at')?->format('Y-m-d'),
        ];
    }
}