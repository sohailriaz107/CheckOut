<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartialPayment extends Model
{
    use HasFactory;

    protected $table = 'partial_payments';

    protected $fillable = [
        'id',
        'unique_id',
        'transaction_id',
        'order_id',
        'payment_type',
        'payment_date',
        'amount',
        'due_amount',
        'full_amount',
        'code',
        'message',
        'status',
        'created_at',
        'updated_at'
    ];
}
