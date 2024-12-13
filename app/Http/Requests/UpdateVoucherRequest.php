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
            "valid_from" => $this->valid_from ? Carbon::parse($this->valid_from)->toDateTimeString() : $this->valid_from,
            "valid_to" => $this->valid_to ? Carbon::parse($this->valid_to)->toDateTimeString() : $this->valid_to,
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
            "code" => "required|string|unique:vouchers,code," . $this->voucher->id,
            "name" => "required|string",
            "description" => "required|string", 
            "type" => "required|in:fixed,percentage",
            "value" => "required|integer|min:1" . ($this->request->get("type") == "percentage" ? "|max:100" : ""),
            "valid_from" => "required|date" . ($this->request->get("valid_to") ? "|before_or_equal:valid_to" : ""),
            "valid_to" => $this->request->get("valid_to") ? "date|after_or_equal:valid_from" : "",
            "stock" => $this->request->get("stock") ? "integer|min:1" : "",
            "active" => "required|boolean"
        ];
    }
}
