<?php

namespace App\Http\Requests\Transfer;

use App\Models\Item;
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
            'note' => 'nullable|string',
            'room_id' => 'required|integer|exists:rooms,id',

            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:items,id',
            'items.*.room_id' => 'required|integer|exists:rooms,id',
            'items.*.quantity' => 'nullable|numeric',
        ];
    }

    //todo item.room_id (from room) should be equal, validate it
//    public function validated($key = null, $default = null)
//    {
//        $data = $this->validator->validated();
//        foreach($data['items'] as $data_item) {
//            $item = Item::find($data_item['id']);
//            if($item->room_id === $data['room_id']) {
//                abort(422, 'Items must be from 1 room');
//            }
//        }
//
//        return $data;
//    }
}
