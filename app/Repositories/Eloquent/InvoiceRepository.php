namespace App\Repositories\Eloquent;

use App\Models\Invoice;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function findById(int $id): ?Invoice
    {
        return Invoice::with(['contract', 'payments'])->find($id);
    }

    public function update(int $id, array $data): bool
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            return $invoice->update($data);
        }
        return false;
    }

    public function getByContract(int $contractId)
    {
        return Invoice::where('contract_id', $contractId)->get();
    }
}