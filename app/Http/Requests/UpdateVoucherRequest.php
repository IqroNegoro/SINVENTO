<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }
    
    protected function prepareForValidation(): void
    {
        $this->merge([
            "valid_from" => Carbon::createFromTimeString($this->valid_from)->toDateString(),
            "valid_to" => Carbon::createFromTimeString($this->valid_to)->toDateString(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "code" => "required|string|unique:vouchers,code,$this->id",
            "name" => "required|string",
            "description" => "required|string",
            "value_type" => "required|in:fixed,percentage",
            "type" => "required|in:cart,item",
            "value" => "required|integer|min:1" . ($this->input("value_type") == "percentage" ? "|max:100" : ""),
            "valid_from" => "required|date|before:valid_to",
            "valid_to" => "required|date|after:valid_from",
            "stock" => $this->request->get("stock") ? "integer|min:1" : "",
            "active" => "required|boolean"
        ];
    }
}
