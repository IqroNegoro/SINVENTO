<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "code" => "required|string|unique:customers,code," . $this->customer->id,
            "name" => "required|string",
            "phone" => "required|string|unique:customers,phone," . $this->customer->id,
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            "code" => strtoupper($this->code)
        ]);
    }
}
