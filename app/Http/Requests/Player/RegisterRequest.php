<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    //======================================================>
    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'phone' => 'Mobile number',
            'email' => 'E-mail Address',
            'group_code' => 'Group Code',
        ];
    }
    //======================================================>
    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:players,phone',
            'email' => 'required|email|unique:players,email',
            'group_code' => 'nullable|numeric|digits:4|exists:groups,uuid',

        ];
    }
}
