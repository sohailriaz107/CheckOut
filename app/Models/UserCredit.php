<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    use HasFactory;
    protected $table = 'user_credits';

    protected $fillable =
        [
            'merchant_id',
            'transaction_id',
            'customer_email',
            'url',
            'domain',
            'credits'
        ];
}
