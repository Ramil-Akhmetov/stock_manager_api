<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'name' => 'sometimes',
            'code' => 'sometimes|unique:items,code,'. $this->user()->id,
            'quantity' => 'sometimes',
            'unit' => 'nullable',
            'photo' => 'nullable|image',
            'category_id' => 'nullable|exists:categories,id',
            'type_id' => 'nullable|exists:types,id',
            'room_id' => 'sometimes|exists:rooms,id',
            'group_id' => 'nullable|exists:groups,id',
        ];
    }
}
