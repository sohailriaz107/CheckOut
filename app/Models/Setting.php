<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'paypal_sandbox_client_id',
        'paypal_sandbox_client_secret',
        'paypal_live_client_id',
        'paypal_live_client_secret',
        'credit_card_sandbox_merchant_id',
        'credit_card_sandbox_api_key',
        'credit_card_live_merchant_id',
        'credit_card_live_api_key'
    ];
}
