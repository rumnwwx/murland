<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CreateOrderRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "phone" => "required|string",
            "status" => "nullable|in:pending,approved,canceled",
            'cat_ids' => 'nullable|array',
            'cat_ids.*' => 'exists:cats,id',
        ];
    }
}
