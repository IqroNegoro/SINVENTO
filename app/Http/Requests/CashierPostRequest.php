<?php

namespace App\Http\Requests;

use App\Models\Item;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CashierPostRequest extends FormRequest
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
            "items" => "array|required|min:1",
            "items.*.id" => "required|exists:items,id",
            "items.*.stock" => "required",
            "items.*.qty" => [
                "required",
                "min:1",
                "integer",
                function (string $attribute, mixed $value, Closure $fail) {
                    $index = explode(".", $attribute)[1];
                    $item = Item::find($this->input("items.$index.id"));
                    if ($item->stock < $value) {
                        $fail("Quantity exceed stock of $item->name product!");
                    }
                },
            ],
            "customer_id" => "nullable|exists:customers,code",
            "voucher_id" => "nullable|exists:vouchers,id",
            "items.*.sell_price" => "required|integer|exists:items,sell_price"
        ];
    }
}
