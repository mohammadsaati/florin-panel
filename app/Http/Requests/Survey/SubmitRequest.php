<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class SubmitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'          => ['required', 'integer', 'exists:users,id'],
            'answers'          => ['required', 'array', 'min:1'],
            'answers.*'        => ['required', 'integer', 'exists:answers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => 'لطفاً به حداقل یک سوال پاسخ دهید.',
            'answers.*.exists' => 'یکی از گزینه‌های انتخابی نامعتبر است.',
        ];
    }
}
