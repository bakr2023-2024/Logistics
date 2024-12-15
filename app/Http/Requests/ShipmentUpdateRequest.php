<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => 'required|in:new,in-transit,delivered,delayed',
        ];
    }
}
