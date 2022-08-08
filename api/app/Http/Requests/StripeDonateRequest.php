<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeDonateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'expYear' => intval($this->expYear),
            'price' => floatval($this->price)
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'price' => 'required|numeric',
            'email' => 'required|email:rfc,dns',
            'number' => 'required|string',
            'expMonth' => 'required|string',
            'expYear' => 'required|numeric',
            'cvc' => 'required|numeric',
        ];
    }
}
