<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'photo' => 'nullable|image',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = $this->validator->validated();
        if ($this->input('password')) {
            $data['password'] = Hash::make($this->input('password'));
        }
        $data['remember_token'] = Str::random(10);

        if ($this->has('photo') && $this->photo) {
            $data['photo'] = $this->photo->store('images', 'public');
        }

        return $data;
    }
}
