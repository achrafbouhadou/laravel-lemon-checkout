<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'whatsapp' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:stripe,paypal,lemonsqueezy', // assuming these are the payment methods
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name must not exceed 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 100 characters.',
            'whatsapp.string' => 'The WhatsApp number must be a valid string.',
            'whatsapp.max' => 'The WhatsApp number must not exceed 20 characters.',
            'payment_method.required' => 'You must select a payment method.',
            'payment_method.in' => 'The selected payment method is invalid.',
            'product_id.required' => 'The product ID is required.',
            'product_id.integer' => 'The product ID must be a valid integer.',
            'product_id.exists' => 'The selected product does not exist.',
        ];
    }
}
