<?php

namespace App\Http\Requests; // ده عنوان الملف عشان لارافيل يعرف يلاقيه

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * هل اليوزر مسموح له يعمل الطلب ده؟
     * بنخليها true حالياً عشان نتخطى الـ Permissions
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * شروط البيانات (Validation Rules)
     * هنا بنقول للارافيل "متقبلش الطلب غير لو الشروط دي اتحققت"
     */
    public function rules(): array
    {
        return [
            // الـ contract_id مش محتاجينه هنا لأنه هييجي من الـ URL (Route)
            'notes' => 'nullable|string|max:500', // الملاحظات اختيارية، نص، مش أكتر من 500 حرف
        ];
    }
}