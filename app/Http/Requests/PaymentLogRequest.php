<?php

namespace App\Http\Requests;

use App\Models\PaymentLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class PaymentLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function paymentLogProcess()
    {
        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        if(isset($payment_log))
        {
            $payment_log->merchant_id = $request->merchantPgIdentifier;
            $payment_log->currency = $request->currency;
            $payment_log->amount = $request->amount;
            $payment_log->orderId = $request->orderId;
            $payment_log->invoiceNumber = $request->invoiceNumber;
            $payment_log->successUrl = $request->successUrl;
            $payment_log->errorUrl = $request->errorUrl;
            $payment_log->storeName = $request->storeName;
            $payment_log->transactionType = $request->transactionType;
            $payment_log->timeout = $request->timeout;
            $payment_log->transactionDateTime = $request->transactionDateTime;
            $payment_log->language = $request->language;
            $payment_log->txnToken = $request->txnToken;
            $payment_log->itemList = $request->itemList;
            $payment_log->otherInfo = $request->otherInfo;
            $payment_log->merchantCustomerPhone = $request->merchantCustomerPhone;
            $payment_log->merchantCustomerEmail = $request->merchantCustomerEmail;
            $payment_log->update();
        }else{
            echo '<pre>';
            print_r('vv');
            die();
        }
    }
}
