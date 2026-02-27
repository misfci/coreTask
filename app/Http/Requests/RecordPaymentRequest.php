<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // شروط الدفع حسب الـ PDF
            'amount' => 'required|numeric|min:0.01', // لازم مبلغ، ويكون رقم، وأكبر من صفر
            'payment_method' => 'required|string|in:cash,bank_transfer,card', // لازم طريقة دفع من الأنواع دي بس
        ];
    }
}