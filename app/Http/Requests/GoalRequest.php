<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'due_date' => 'required|date|after_or_equal:today',
            'charge' => 'required|numeric|min:0.01',
            'name' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'charge' => 'Số tiền mục tiêu',
            'due_date' => 'Ngày hết hạn',
            'name' => 'Mô tả'
        ];
    }

    public function messages(): array
    {
        return [
            'due_date.required' => 'Ngày hết hạn là bắt buộc',
            'due_date.date' => 'Ngày hết hạn là bắt buộc',
            'due_date.after_or_equal' => 'Ngày hết hạn không được là ngày quá khứ',
            'charge.required' => 'Số tiền mục tiêu là bắt buộc',
            'charge.numeric' => 'Số tiền mục tiêu phải là số',
            'charge.min' => 'Số tiền mục tiêu phải lớn hơn 0',
            'name.required' => 'Mô tả là bắt buộc'
        ];
    }
}
