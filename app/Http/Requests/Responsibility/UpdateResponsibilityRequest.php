<?php

namespace App\Http\Requests\Responsibility;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResponsibilityRequest extends FormRequest
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'user_id' => 'sometimes|exists:users,id',
            'room_id' => 'sometimes|exists:rooms,id',
        ];
    }
}
