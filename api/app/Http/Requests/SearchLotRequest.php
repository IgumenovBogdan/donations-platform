<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchLotRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'take' => intval($this->take)
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
            's' => 'string|nullable',
            'order' => 'string|in:asc,desc|nullable',
            'take' => 'required|integer'
        ];
    }
}
