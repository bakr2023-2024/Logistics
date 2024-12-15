<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'content' => 'required|min:5',
            'subject' => 'required',
        ];
    }
}
