<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'required|min:3|max:30',
            'email' => ['required', 'email', 'unique:customers,email,' . $this->route('customer')->id],
            'password' => 'nullable|confirmed|min:8',
            'address' => 'required|min:3',
        ];
    }
}
