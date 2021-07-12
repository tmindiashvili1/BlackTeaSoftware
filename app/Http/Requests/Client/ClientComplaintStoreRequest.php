<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientComplaintStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required', 'max:150', 'regex:/^[\pL\s\-]+$/u'
            ],
            'text' => [
                'required', 'max:3000'
            ],
            'client_id' => [
                'required',
                'exists:clients,id'
            ],
            'in_work' => [
                'required'
            ]
        ];
    }
}
