<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'subject', 'content', 'status'];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}