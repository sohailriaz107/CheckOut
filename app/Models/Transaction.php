<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'marchant_id',
        'invoice_no',
        'payment_type',
        'store_id',
        'amount', 
        'order_id',
        'code',
        'message',
        'status'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    

}
