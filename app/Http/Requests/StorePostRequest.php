<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function attributes(): array
    {
        return [
            'title'             => 'Sarlavha bulishi shart',
            'short_content'     => 'Qisqacha mazmuni bulishi shart',
            'photo'             => 'Rasm  bulishi shart',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'required',
            'short_content'=>'required',
            'photo'=>'required|image|max:5120',
        ];
    }
}
