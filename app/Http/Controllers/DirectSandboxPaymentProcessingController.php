<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\Merchant;
use App\Models\PaymentLog;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\PartialPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class DirectSandboxPaymentProcessingController extends Controller
{
    public function sandboxPayment()
    {
        $t_id = Session::get('transaction_id');
        $u_id = Session::get('unique_id');

        if($t_id){
            $transaction = Transaction::where('id', $t_id)->first();
            $credits = PaymentLog::OrderBy('id', 'desc')->first()->credits;
            $merchant = Merchant::where('id', $transaction->merchant_id)->first();
            return view('frontend.sandbox_payment', compact('merchant', 'transaction', 'credits')); 
        } else {
           return view('frontend.sandbox_payment_404');
        }
        
    }
	
	
	 public function sandboxDuePayment()
    {
        $t_id = Session::get('transaction_id');
        $u_id = Session::get('unique_id');
         if($u_id){
            $transaction = Transaction::where('id', $t_id)->first();
            $credits = PaymentLog::OrderBy('id', 'desc')->first()->credits;
            $merchant = Merchant::where('id', $transaction->merchant_id)->first();
            $partialCount = PartialPayment::where('unique_id', $u_id)->count();
            $partialPayments = PartialPayment::where('unique_id', $u_id)->first(); 
           return view('frontend.sandbox_due_payment', compact('merchant', 'transaction', 'credits','partialCount','partialPayments'));
        } else {
           return view('frontend.sandbox_payment_404');
        }
    }
	
    public function sandboxPaymentConfirmed()
    {
        $t_id = Session::get('transaction_id');
        $u_id = Session::get('unique_id');

        if($u_id)
        {
        $transaction = Transaction::where('id', $t_id)->first();
        $credits = PaymentLog::OrderBy('id', 'desc')->first()->credits;
        $merchant = Merchant::where('id', $transaction->merchant_id)->first();
        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        $merchant = Merchant::where('id', $payment_log->merchant_id)->first();
        Session::forget('unique_id');
        Session::forget('transaction_id');
        $successUrl = $payment_log->successUrl;
        $checkout_url= $successUrl . '?response=00' .
            $merchant->secret_id . '&pay_type=' .
            $_GET['type'] . '&reference_id=' .
            $_GET['reference_id'] . '&pay_status=1&amount=' . $payment_log->amount . '&user_credits=' . $payment_log->credits . '&currency=' . $payment_log->currency .
            '&transaction_date=' . $payment_log->transactionDateTime . '&invoice_number=' . $payment_log->invoiceNumber . '&store_name=' . $payment_log->storeName . '&txnToken=' . $payment_log->txnToken;
         $reference_id= $_GET['reference_id'];  
         $pay_type= $_GET['type'];
         $partialCount = PartialPayment::where('unique_id', $u_id)->count();
           return view('frontend.sandbox_payment_confirmed', compact('merchant', 'transaction', 'credits','checkout_url','reference_id','pay_type','partialCount'));
        } else {
           return view('frontend.sandbox_payment_404');
        }
    }
    
    public function sandboxCredtCardPayment(Request $request)
    {
    	$partial_id=1;
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

        if($transaction->due_amount!='')
        {
         $amount =  $transaction->due_amount;
        }
        else 
        {
        $amount = $transaction->amount;
        }

        $setting = Setting::Orderby('id', 'desc')->first();
        $merchant_id = $setting->credit_card_sandbox_merchant_id; //INSERT MERCHANT ID (must be a 9 digit string) Test
        $api_key = $setting->credit_card_sandbox_api_key; //INSERT API ACCESS PASSCODE Test
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

        // Add partial payments 
        $partial = PartialPayment::where('unique_id', $payment_log->unique_id)->first();
        if($partial)
        {
        	$partial_id= $partial->partial_id+1;
        }

		$partialPayment = new PartialPayment([
		'partial_id' => $partial_id,
	    'unique_id' => $payment_log->unique_id,
	    'order_id' => $transaction->order_id,
	    'payment_type' => 'credit_card',
	    'amount' => $request->pay_amount,
	    'due_amount' => (($transaction->due_amount)?$transaction->due_amount:$transaction->amount) - $request->pay_amount,
	    'full_amount' => $transaction->amount,
	    'code' => '',
	    'message' => ''
         ]);

        $partialPayment->save(); 

        // Partial payment senario 1 without due amount
        if($transaction->due_amount=='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
        {

          $payment_data = array(
                'order_number' => $order_id."_1",
                'amount' => $request->pay_amount,
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
                        $transaction->payment_type = 'credit_card';
                        $transaction->status = 'pending';
                        $transaction->full_amount=$transaction->amount;
                        $transaction->due_amount=$transaction->amount - $request->pay_amount;
                        $transaction->update();
                        $partialPayment->status = 'complete';
                        $partialPayment->update();
                        return redirect()->route('sandbox.due.payment');
                    }
                }
            } catch (\Beanstream\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }
        

            
        }
      
        // Partial payment senario 2 with due amount
        else if($transaction->due_amount!='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
        {

          $payment_data = array(
                'order_number' => $order_id."_2",
                'amount' => $request->pay_amount,
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
                        $transaction->payment_type = 'credit_card';
                        $transaction->status = 'pending';
                        $transaction->full_amount=$transaction->amount;
                        $transaction->due_amount=$transaction->amount - $request->pay_amount;
                        $transaction->update();
                        $partialPayment->status = 'complete';
                        $partialPayment->update();
                        return redirect()->route('sandbox.due.payment');
                    }
                }
            } catch (\Beanstream\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }
        }

        else {

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
                            $partialPayment->status = 'complete';
                            $partialPayment->update();
                            return redirect()
                                ->route('sandbox.confirmation', ['response' => '00','type'=>'Credit Card','reference_id'=>$transaction->id])
                                ->with('success', 'Transaction complete.');
                        }
                    }
                } catch (\Beanstream\Exception $e) {
                    return redirect()->back()->withErrors([$e->getMessage()]);
                }

        }


        // Card payment start .............................................................




        // $item_number = str_random(4) . time();


      
    }


    public function SandboxPayPal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();

        if($transaction->due_amount!='')
		{
         $amount =  $transaction->due_amount;
		}
        else 
		{
        $amount = $transaction->amount;
        }

        if($transaction->due_amount=='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
        {

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('sandbox.payPalSuccess.PartialPay'),
                        "cancel_url" => route('sandbox.return', ['response' => '06']),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "CAD",
                                "value" => "$request->pay_amount"
                            ]
                        ]
                    ]
                ]);

            
        }
      
        else if($transaction->due_amount!='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
        {
           $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('sandbox.payPalSuccess.PartialPay'),
                        "cancel_url" => route('sandbox.return', ['response' => '06']),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "CAD",
                                "value" => "$request->pay_amount"
                            ]
                        ]
                    ]
                ]);  
                
        }
        else 
        {

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('sandbox.payPalSuccess'),
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

       }

          if (isset($response['id']) && $response['id'] != null) {
                    // redirect to approve href
                    foreach ($response['links'] as $links) {
                        if ($links['rel'] == 'approve') {
                            return redirect()->away($links['href']); 
                        }
                    }
                    return redirect()
                        ->route('sandbox.return', ['response' => '06'])
                        ->with('error', 'Something went wrong.');
                } else {
                    return redirect()
                        ->route('sandbox.return', ['response' => '06'])
                        ->with('error', $response['message'] ?? 'Something went wrong.');
                }
   }

    public function DemoPayPalSuccess(Request $request)
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
                ->route('sandbox.return', ['response' => '00'])
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('sandbox.return', ['response' => '07'])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

        public function PayPalSuccessPartialPay(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        $partial_id=1;
        $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
        $partial = PartialPayment::where('unique_id', $payment_log->unique_id)->first();
        if($partial)
        {
            $partial_id= $partial->partial_id+1;
        }

        $partialPayment = new PartialPayment([
        'partial_id' => $partial_id,
        'unique_id' => $payment_log->unique_id,
        'order_id' => $transaction->order_id,
        'payment_type' => 'PayPal',
        'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
        'due_amount' => (($transaction->due_amount)?$transaction->due_amount:$transaction->amount) -$response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
        'full_amount' => $transaction->amount,
        'code' => '',
        'message' => ''
         ]);

        $partialPayment->save(); 
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
            $transaction->update();
            $transaction->payment_type = 'PayPal';
            $transaction->status = 'pending';
            $transaction->full_amount=$transaction->amount;
            $transaction->due_amount=$transaction->amount - $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $transaction->update();
            $partialPayment->status = 'complete';
            $partialPayment->update();
            return redirect()->route('sandbox.due.payment');

        } else {
            return redirect()
                ->route('sandbox.return', ['response' => '07'])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function sandboxReturn($response)
    { 
        $returnResponse = Error::where('error', $response)->first()->description;
        if ($response == '00') {
            $payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
            $merchant = Merchant::where('id', $payment_log->merchant_id)->first();
            Session::forget('unique_id');
            Session::forget('transaction_id');
            $successUrl = $payment_log->successUrl;
            return redirect($successUrl . '?response=' . $returnResponse . '&secret_id=' .
                $merchant->secret_id . '&pay_status=1&amount=' . $payment_log->amount . '&user_credits=' . $payment_log->credits . '&currency=' . $payment_log->currency .
                '&transaction_date=' . $payment_log->transactionDateTime . '&invoice_number=' . $payment_log->invoiceNumber . '&store_name=' . $payment_log->storeName . '&txnToken=' . $payment_log->txnToken);
        } elseif ($response == '05') {
            echo '<pre>';
            print_r("error url is not found");
            die();
        } elseif ($response == '08') {
            $url = Session::get('errorUrl');
            Session::forget('errorUrl');
            return redirect($url[0] . '?error=' . $returnResponse . ''); 
        } else {
            $url = Session::get('errorUrl');
            Session::forget('errorUrl');
            return redirect($url[0] . '?error=' . $returnResponse . '');
        }
    }


    public function sandboxUserCreditPayment(Request $request)
    {
		$partial_id=1;
        $transaction = Transaction::where('id', Session::get('transaction_id'))->first();
		$payment_log = PaymentLog::where('unique_id', Session::get('unique_id'))->first();
		$partial = PartialPayment::where('unique_id', $payment_log->unique_id)->first();
        if($partial)
        {
        	$partial_id= $partial->partial_id+1;
        }

		$partialPayment = new PartialPayment([
		'partial_id' => $partial_id,
	    'unique_id' => $payment_log->unique_id,
	    'order_id' => $transaction->order_id,
	    'payment_type' => 'userCredit',
	    'amount' => $request->pay_amount,
	    'due_amount' => (($transaction->due_amount)?$transaction->due_amount:$transaction->amount) - $request->pay_amount,
	    'full_amount' => $transaction->amount,
	    'code' => '',
	    'message' => ''
         ]);
  //       echo "<pre>";
		// print_r($partialPayment); die;
        $partialPayment->save(); 


		if($transaction->due_amount=='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
		{
		$transaction->payment_type = 'userCredit';
        $transaction->status = 'pending';
		$transaction->full_amount=$transaction->amount;
		$transaction->due_amount=$transaction->amount - $request->pay_amount;
        $transaction->update();
		$payment_log->credits = $payment_log->credits - $request->pay_amount;
        $payment_log->update();
        $partialPayment->status = 'complete';
        $partialPayment->update();
        // $parcial_payment= new Transaction();
        // $parcial_payment->url = $url;
        // $parcial_payment->description = $description;
        // $parcial_payment->save();
        
		return redirect()->route('sandbox.due.payment');
			
		}
      
		else if($transaction->due_amount!='' && $request->pay_amount!='' && $transaction->amount>$request->pay_amount)
		{
		$transaction->payment_type = 'userCredit';
        $transaction->status = 'pending';
		$transaction->full_amount=$transaction->amount;
		$transaction->due_amount= $transaction->amount - $request->pay_amount ;
        $transaction->update();
		$payment_log->credits = $payment_log->credits - $request->pay_amount;
        $payment_log->update();
        $partialPayment->status = 'complete';
        $partialPayment->update();
		return redirect()->route('sandbox.due.payment');	
		}
        else 
		{
        $transaction->payment_type = 'userCredit';
        $transaction->status = 'complete';
        $transaction->update();
        $payment_log->credits = $payment_log->credits - $transaction->amount;
        $payment_log->update();
        $partialPayment->status = 'complete';
        $partialPayment->update();

        return redirect()
            ->route('sandbox.confirmation', ['response' => '00','type'=>'User Credit','reference_id'=>$transaction->id])
            ->with('success', 'Transaction complete.');
		}		
    }
}
