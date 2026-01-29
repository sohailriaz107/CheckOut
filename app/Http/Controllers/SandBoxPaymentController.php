<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\Merchant;
use App\Models\PaymentLog;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SandBoxPaymentController extends Controller
{
    public function sandboxPortal(Request $request)
    {
        Session::forget('transaction_id');
        Session::forget('unique_id');
        $merchant = Merchant::where('id', $request->merchantPgIdentifier)->first();
        Session::push('errorUrl', $request->errorUrl);
        Session::push('successUrl', $request->successUrl);
        if ($request->errorUrl = ''  && $request->successUrl = '') 
        {
            $response = '05';
            return redirect()->route('sandbox.return', ['response' => $response]);
        } else{    
            if ($merchant) {
                switch ($merchant->status) 
                {	
                    case 'active':
                        $response = $this->activeStatus($merchant, $request);
                        if ($response == '00') {
                            $payment_log = $this->paymentLog($request);
                            return redirect('/sandbox-payment');
                        } else {
                            return redirect()->route('sandbox.return', ['response' => $response]);
                        }
                        break;
                    case 'not_active':
                        $response = '01';
                        return redirect()->route('sandbox.return', ['response' => $response]);
                }
            } else {
                $response = '08';
                return redirect()->route('sandbox.return', ['response' => $response]);
            }
        }


    }

       public function sandboxPortalCredtBuy(Request $request)
    {
        Session::forget('transaction_id');
        Session::forget('unique_id');
        $merchant = Merchant::where('id', $request->merchantPgIdentifier)->first();
        Session::push('errorUrl', $request->errorUrl);
        Session::push('successUrl', $request->successUrl);
        if ($request->errorUrl = ''  && $request->successUrl = '') 
        {
            $response = '05';
            return redirect()->route('sandbox.return', ['response' => $response]);
        } else{    
            if ($merchant) {
                switch ($merchant->status) 
                {   
                    case 'active':
                        $response = $this->activeStatus($merchant, $request);
                        if ($response == '00') {
                            $payment_log = $this->paymentLog($request);
                            return redirect('/sandbox-payment-credit-buy');
                        } else {
                            return redirect()->route('sandbox.return', ['response' => $response]);
                        }
                        break;
                    case 'not_active':
                        $response = '01';
                        return redirect()->route('sandbox.return', ['response' => $response]);
                }
            } else {
                $response = '08';
                return redirect()->route('sandbox.return', ['response' => $response]);
            }
        }


    }

    public function activeStatus($merchant, $request) #checking date time and empty strings
    {
        if (
            $request->currency != '' &&
            $request->invoiceNumber != '' &&
            $request->storeName != '' &&
            $request->language != '' &&
            $request->itemList != '' &&
            $request->merchantCustomerPhone != '' &&
            $request->merchantCustomerEmail != ''

        ) {
            $carbonDate = Carbon::now()->format('Y-m-d');
            $givenDate = date('Y-m-d', strtotime($request->transactionDateTime));
            if ($carbonDate == $givenDate) {
                $checked = $this->checkToken($merchant, $request);
                if ($checked == 'ok') {
                    $response = '00';
                    return $response;
                } else if ($checked == 'error') {
                    $response = '04';
                    return $response;
                }
            } else {
                $response = '02';
                return $response;
            }
        } else {
            $response = '03';
            return $response;
        }
    }

    public function checkToken($merchant, $request) #checking the token validity
    {
        if ($request->txnToken != '') {
            $token = $merchant->store_name.$request->currency.$merchant->secret_id.Carbon::now()->format('Y-m-d').$request->amount.$request->invoiceNumber;
            $hashedToken = hash('sha256', $token);
            if ($hashedToken == $request->txnToken) {
                $checked = 'ok';
            } else {
                $checked = 'error';
            }
        } else {
            $checked = 'error';
        }
        return $checked;
    }

    public function paymentLog($request) #saving array to payment_logs and transactions tables
    {
        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        if (isset($payment_log)) {
        	$payment_log->cart_order_id= $request->cart_order_id;
            $payment_log->merchant_id = $request->merchantPgIdentifier;
            $payment_log->currency = $request->currency;
            $payment_log->amount = $request->amount;
            $payment_log->credits = $request->credits;
            $payment_log->orderId = $request->orderId;
            $payment_log->invoiceNumber = $request->invoiceNumber;
            $payment_log->successUrl = Session::get('successUrl')[0];
            $payment_log->errorUrl = Session::get('errorUrl')[0];
            $payment_log->store_Name = $request->storeName;
            $payment_log->transactionType = $request->transactionType;
            $payment_log->timeout = $request->timeout;
            $payment_log->transactionDateTime = $request->transactionDateTime;
            $payment_log->language = $request->language;
            $payment_log->txnToken = $request->txnToken;
            $payment_log->itemList = $request->itemList;
            $payment_log->otherInfo = $request->otherInfo;
            $payment_log->merchantCustomerPhone = $request->merchantCustomerPhone;
            $payment_log->merchantCustomerEmail = $request->merchantCustomerEmail;
            $payment_log->sid = $request->sid;
			$payment_log->customer_id = $request->customer_id;
			$payment_log->booking_id = $request->booking_id;
            $payment_log->update();

            $transaction = Transaction::where('order_id',$request->orderId)->first();
            if($transaction){
            $transaction->merchant_id = $request->merchantPgIdentifier;
            $transaction->invoice_no = $request->invoiceNumber;
            $transaction->order_id = $request->orderId;
            $transaction->payment_type = $request->transactionType;
            $transaction->payment_date = date('Y-m-d', strtotime($request->transactionDateTime));
            $transaction->amount = $request->amount;
            $transaction->full_amount = $request->amount;
            $transaction->status = 'pending';
            $transaction->sid =$request->sid;
            $transaction->update();  
            }


        } else {
            $payment_log = new PaymentLog();
			$payment_log->cart_order_id= $request->cart_order_id;
            $payment_log->unique_id = Str::random(5);
            $payment_log->merchant_id = $request->merchantPgIdentifier;
            $payment_log->currency = $request->currency;
            $payment_log->amount = $request->amount;
            $payment_log->credits = $request->credits;
            $payment_log->orderId = $request->orderId;
            $payment_log->invoiceNumber = $request->invoiceNumber;
            $payment_log->successUrl = Session::get('successUrl')[0];
            $payment_log->errorUrl = Session::get('errorUrl')[0];
            $payment_log->store_Name = $request->storeName;
            $payment_log->transactionType = $request->transactionType;
            $payment_log->timeout = $request->timeout;
            $payment_log->transactionDateTime = $request->transactionDateTime;
            $payment_log->language = $request->language;
            $payment_log->txnToken = $request->txnToken;
            $payment_log->itemList = $request->itemList;
            $payment_log->otherInfo = $request->otherInfo;
            $payment_log->merchantCustomerPhone = $request->merchantCustomerPhone;
            $payment_log->merchantCustomerEmail = $request->merchantCustomerEmail;
            $payment_log->sid = $request->sid;
			$payment_log->customer_id = $request->customer_id;
			$payment_log->booking_id = $request->booking_id;
            $payment_log->save();

            $transaction = new Transaction();
            $transaction->merchant_id = $request->merchantPgIdentifier;
            $transaction->invoice_no = $request->invoiceNumber;
            $transaction->order_id = $request->orderId;
            $transaction->payment_type = $request->transactionType;
            $transaction->payment_date = date('Y-m-d', strtotime($request->transactionDateTime));
            $transaction->amount = $request->amount;
            $transaction->full_amount = $request->amount;
            $transaction->status = 'pending';
            $transaction->sid =$request->sid;
            $transaction->save();

            Session::push('unique_id', $payment_log->unique_id);
            Session::push('transaction_id', $transaction->id);
        }
        Session::forget('errorUrl');
        Session::forget('successUrl');
        return $payment_log->id;
    }

}
