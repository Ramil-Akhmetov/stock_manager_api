<?php

namespace App\Http\Requests\Checkin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCheckinRequest extends FormRequest
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
            'note' => 'nullable|string',
            'supplier_id' => 'sometimes|integer|exists:suppliers,id',

            'items' => 'sometimes|array|min:1',
            'items.*.name' => 'sometimes',
            'items.*.code' => 'sometimes|unique:items,code',
            'items.*.quantity' => 'sometimes',
            'items.*.unit' => 'sometimes',
            'items.*.photo' => 'nullable|image',
            'items.*.category_id' => 'nullable|exists:categories,id',
            'items.*.type_id' => 'nullable|exists:types,id',
            'items.*.room_id' => 'nullable|exists:rooms,id',
            'items.*.group_id' => 'nullable|exists:groups,id',
        ];
    }
}
