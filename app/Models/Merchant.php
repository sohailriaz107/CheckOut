<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'address',
        'telephone',
        'merchant_code',
        'secret_id',
        'store_name',
        'credit_card',
        'paypal',
        'user_credit',
        'status',

    ];
}
