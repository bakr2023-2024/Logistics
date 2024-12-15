<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function rules()
    {
        $isAdmin = $this->routeIs('admin.register');
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:' . ($isAdmin ? 'admins' : 'customers') . ',email',
            'password' => 'required|confirmed|min:8',
            'address' => $isAdmin ? 'nullable' : 'required|min:3',
        ];
    }
}
