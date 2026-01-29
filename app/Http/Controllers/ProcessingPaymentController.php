<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\PaymentLog;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class ProcessingPaymentController extends Controller
{
    public function payment()
    {
        $t_id = Session::get('transaction_id');
        $transaction = Transaction::where('id', $t_id)->first();
        $credits = PaymentLog::OrderBy('id', 'desc')->first()->credits;
        $merchant = Merchant::where('id', $transaction->merchant_id)->first();

        return view('frontend.payment', compact('merchant', 'transaction', 'credits'));
    }

    public function paymentSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'card' => 'required|integer',
            'month' => 'required|between:1,31',
            'year' => 'required|integer',
            'cvv' => 'required',
        ]);
        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();

        $order_id = $transaction->order_id;
        $amount = $transaction->amount;
        // Card payment start .............................................................

        // $merchant_id = '378880029'; //INSERT MERCHANT ID (must be a 9 digit string)  Live
        // $api_key = '258a709e95134cAEBC997e5E4d1dD703'; //INSERT API ACCESS PASSCODE   Live
        $setting = Setting::Orderby('id', 'desc')->first();
        $merchant_id = $setting->credit_card_live_merchant_id;; //INSERT MERCHANT ID (must be a 9 digit string) Test
        $api_key = $setting->credit_card_live_api_key; //INSERT API ACCESS PASSCODE Test
        $api_version = 'v1'; //default
        $platform = 'api'; //default

        //Create Beanstream Gateway
        $beanstream = new \Beanstream\Gateway($merchant_id, $api_key, $platform, $api_version);

        //Example Card Payment Data
        $name = $request->input('name');
        $card = $request->input('card');
        $month = $request->input('month');
        $year = $request->input('year');
        $cvv = $request->input('cvv');


        // $item_number = str_random(4) . time();


        $payment_data = array(
            'order_number' => $order_id,
            'amount' => $amount,
            'payment_method' => 'card',
            'card' => array(
                'name' => $name,
                'number' => $card, //'4030000010001234',
                'expiry_month' => $month,
                'expiry_year' => $year,
                'cvd' => $cvv
            )
        );


        $complete = TRUE; //set to FALSE for PA
        //Try to submit a Card Payment
        try {
            ///working here

            $result = $beanstream->payments()->makeCardPayment($payment_data, $complete);

            if ($result) {
                if ($order_id) {
                    $transaction->status = 'complete';
                    $transaction->payment_type = 'credit_card';
                    $transaction->update();


                    return redirect()
                        ->route('payment.live.return', ['response' => '00'])
                        ->with('success', 'Transaction complete.');
                }
            }

        } catch (\Beanstream\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }


    public function payPal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $payment_log = PaymentLog::where('id', Session::get('unique_id'))->first();
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
        $amount = $transaction->amount;


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.payPalSuccess'),
                "cancel_url" => route('sandbox.return', ['response' => '06']),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "CAD",
                        "value" => "$amount"
                    ]
                ]
            ]
        ]);


        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('payment.live.return', ['response' => '06'])
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('payment.live.return', ['response' => '06'])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }


    }

    public function payPalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
            $transaction->payment_type = 'paypal';
            $transaction->status = 'complete';
            $transaction->update();
            return redirect()
                ->route('payment.live.return', ['response' => '00'])
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('payment.live.return', ['response' => '07'])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function userCredit()
    {
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
        $transaction->payment_type = 'userCredit';
        $transaction->status = 'complete';
        $transaction->update();

        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        $payment_log->credits = $payment_log->credits - $transaction->amount;
        $payment_log->update();

        return redirect()
            ->route('payment.live.return', ['response' => '00'])
            ->with('success', 'Transaction complete.');
    }
}
