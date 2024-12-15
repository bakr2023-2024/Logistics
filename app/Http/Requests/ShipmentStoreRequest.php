<?php

namespace App\Http\Requests;

use App\Models\Shipment;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'cost' => 'required|numeric|min:0',
        ];
    }
}
