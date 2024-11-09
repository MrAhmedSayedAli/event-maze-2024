<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //======================================================>
    public function attributes(): array
    {
        return [
            'group_id' => ' Code',
        ];
    }
    //======================================================>
    public function rules(): array
    {
        return [
            'group_id' => 'required|numeric|digits:4|exists:groups,uuid',
        ];
    }
}
