<?php

namespace App\Http\Requests\Checkin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckinRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'items' => 'required|array|min:1',

            'items.*.name' => 'required',
            'items.*.code' => 'required|unique:items,code',
            'items.*.quantity' => 'required_with:items.*.unit',
            'items.*.unit' => 'required_with:items.*.quantity',
            'items.*.photo' => 'nullable|image',
            'items.*.category_id' => 'nullable|exists:categories,id',
            'items.*.type_id' => 'nullable|exists:types,id',
            'items.*.room_id' => 'nullable|exists:rooms,id',
            'items.*.group_id' => 'nullable|exists:groups,id',
        ];
    }
}
