namespace App\Repositories\Interfaces;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function create(array $data): Invoice;
    public function findById(int $id): ?Invoice;
    public function update(int $id, array $data): bool;
    public function getByContract(int $contractId);
}