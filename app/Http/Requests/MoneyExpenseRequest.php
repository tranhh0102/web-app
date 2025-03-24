<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoneyExpenseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'charge' => 'required|numeric|min:0.01',
            'name' => 'required',
            'date' => 'required',
            'm_expense_id' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'charge' => 'Số tiền',
            'name' => 'Mô tả',
            'date' => 'Ngày',
            'm_expense_id' => 'Loại'
        ];
    }

    public function messages(): array
    {
        return [
            'charge.required' => 'Số tiền là bắt buộc',
            'charge.numeric' => 'Số tiền phải là số',
            'charge.min' => 'Số tiền phải lớn hơn 0',
            'name.required' => 'Mô tả là bắt buộc',
            'date.required' => 'Ngày là bắt buộc',
            'm_expense_id.required' => 'Loại là bắt buộc',
        ];
    }
}
