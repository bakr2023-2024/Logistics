<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => 'required|in:pending,resolved',
        ];
    }
}
