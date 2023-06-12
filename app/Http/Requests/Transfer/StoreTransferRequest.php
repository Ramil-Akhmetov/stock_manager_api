<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
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
            'reason' => 'nullable|string',
            'from_room_id' => 'required|integer|exists:rooms,id',
            'to_room_id' => 'required|integer|exists:rooms,id',
            'item_ids' => 'required|array|min:1',
            'item_ids.*' => 'integer|exists:items,id',
        ];
    }
}
