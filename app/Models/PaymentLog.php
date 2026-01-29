<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';

    protected $fillable = [
        'unique_id',
        'merchant_id',
        'currency',
        'amount',
        'credits',
        'orderId',
        'successUrl',
        'errorUrl',
        'timeout',
        'transactionDateTime',
        'language',
        'txnToken',
        'itemList',
        'store_name',
        'otherInfo',
        'merchantCustomerPhone',
        'merchantCustomerEmail',
        'cart_order_id'
    ];
}
