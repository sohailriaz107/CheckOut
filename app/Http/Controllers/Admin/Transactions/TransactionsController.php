<?php
namespace App\Http\Controllers\Admin\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use App\Models\PartialPayment;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.transactions.index');
    }

    public function show(Transaction $transaction){
        $payment_log = PaymentLog::where('invoiceNumber',$transaction->invoice_no)->where('merchant_id',$transaction->merchant_id)->first();
        $partial = PartialPayment::where('order_id',$transaction->order_id)->first();
        return view('admin.transactions.show', compact('transaction','payment_log','partial'));
    }
}
