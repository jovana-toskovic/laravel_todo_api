<?php

namespace App\Http\Requests;

use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() && (auth()->user()->id === (int) $this->route('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'timezone' => 'nullable|in:' . implode(',', DateTimeZone::listIdentifiers()),
        ];
    }
}
