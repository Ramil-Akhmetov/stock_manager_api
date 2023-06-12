<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransferRequest extends FormRequest
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
            'from_room_id' => 'sometimes|integer|exists:rooms,id',
            'to_room_id' => 'sometimes|integer|exists:rooms,id',
            'item_ids' => 'sometimes|array|min:1',
            'item_ids.*' => 'integer|exists:items,id',
        ];
    }
}
