<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', 'min:1', 'exists:employees,id'],
            'name' => ['required', 'string', 'between:2,256']
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), $this->route()->parameters);
    }
}