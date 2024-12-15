<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'required|min:3|max:30',
            'email' => ['required', 'email', 'unique:admins,email,' . $this->route('admin')->id],
            'password' => 'nullable|confirmed|min:8',
        ];
    }
}
