<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name'       => ['required', 'string', 'max:30', Rule::unique('permissions')->ignore($this->permission)],
            'route_name' => ['required', 'string', 'max:30', Rule::unique('permissions')->ignore($this->permission)],
            'group'      => 'required|string|min:3|max:20',
        ];

        return $rules;
    }
}
