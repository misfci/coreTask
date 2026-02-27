

namespace App\Services;

class TaxService
{
    /**
     * حساب الضريبة (15% حسب المثال الشائع أو حسب ما يحدده السيستم)
     */
    public function calculateTax(float $amount): float
    {
        // الـ PDF لم يحدد النسبة، فسنعتمد 15% كقيمة افتراضية
        return $amount * 0.15;
    }
}