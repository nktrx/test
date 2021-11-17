<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

/**
 * @property-read string $name
 * @property-read string $phone
 * @property-read string $email
 * @property-read string $date
 * @property-read float $salary
 * @property-read int $header
 * @property-read int $position
 * @property-read UploadedFile $photo
 */
class CreateEmployeeRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:2,256'],
            'date' => ['required', 'date'],
            'phone' => ['required', 'string', 'regex:/^\+380 \(\d{2}\) \d{3} \d{2} \d{2}$/'],
            'email' => ['required', 'string', 'email:rfc'],
            'salary' => ['required', 'numeric', 'between:0,500000'],
            'header' => ['required', 'int', 'min:1', 'exists:employees,id'],
            'position' => ['required', 'int', 'min:1', 'exists:positions,id'],
            'photo' => ['required', 'file', 'mimes:jpg,png', 'max:5120']
        ];
    }
}
