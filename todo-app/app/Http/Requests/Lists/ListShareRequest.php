<?php

namespace app\Http\Requests\Lists;

use Illuminate\Foundation\Http\FormRequest;

class ListShareRequest extends FormRequest
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
            'user_email'=>'email',
            'list_id' => 'array',
        ];
    }
}
