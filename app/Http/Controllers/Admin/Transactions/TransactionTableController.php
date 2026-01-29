<?php

namespace App\Http\Controllers\Admin\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Calculate;
use App\Models\Merchant;
use App\Models\Transaction;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PartialPayment;

class TransactionTableController extends Controller
{
    public function __invoke(Request $request)
    {
        $transactions = PartialPayment::orderBy('id', 'DESC');
        $user_type = Auth::user()->type;
        // if($user_type=="Merchant"){
        //     $transactions->where('merchant_id', Auth::user()->merchant_id);
        // }
        // if ($request->order_id != '') {
        //     $transactions->where('order_id', 'like', "%{$request->order_id}%");
        // }

        if ($request->invoice_no != '') {
            $transactions->where('invoice_no', 'like', "%{$request->invoice_no}%");
        }

        if ($request->amount != '') {
            $transactions->where('amount', 'like', "%{$request->amount}%");
        }

        if ($request->status != '') {
            $transactions->where('status', "{$request->status}");
        }
        if ($request->payment_type != '') {
            $transactions->where('payment_type', "{$request->payment_type}");
        }

        if ($request->filter_merchant != '') {
            $name = $request->filter_merchant;
            $transactions->whereHas('merchant', function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            });
        }

        switch (request()->date_option) {
            case 'yesterday':
                $transactions = $transactions->whereDate('payment_date', '=', Carbon::yesterday());
                break;
            case 'today':
                $transactions = $transactions->whereDate('payment_date', '=', Carbon::now());
                break;
            case 'this_whole_week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                $transactions = $transactions->whereBetween('payment_date', [$start, $end]);
                break;
            case 'this_month':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                $transactions = $transactions->whereBetween('payment_date', [$start, $end]);
                break;
            case 'this_year':
                $start = Carbon::now()->startOfYear();
                $end = Carbon::now()->endOfYear();
                $transactions = $transactions->whereBetween('payment_date', [$start, $end]);
                break;
            default:
                break;
        }

        if (request()->from) {
            $from = Calculate::dateConvertion(request()->from);
            $transactions = $transactions->whereDate('payment_date', '>=', Carbon::createFromDate($from));
        }

        if (request()->to) {
            $to = Calculate::dateConvertion(request()->to);
            $transactions = $transactions->whereDate('payment_date', '<=', Carbon::createFromDate($to));
        }


        $transactions = $transactions->get();
        return DataTables::of($transactions)
           ->addColumn('id', function ($transaction) {
                return $transaction->transaction_id;
            })
            ->addColumn('checkboxes', function ($transaction) {
                $action = '<input type="checkbox" name="pdr_checkbox[]" class="pdr_checkbox" value="' . $transaction->id . '" />';
                return $action;
            })

            ->addColumn('status', function ($transaction) {
                $status ='';
                if ($transaction->status == 'pending') {
                    $status = 'Pending';
                } else if ($transaction->status == 'completed') {
                    $status = 'Completed';
                }
                return $status;
            })

            //View Button
           ->addColumn('actions', function ($transaction)  {
                $action = '';
                $action .= '
                <div class="btn-group">
                <a  href="' . route('admin.transactions.show', $transaction->transaction_id) . '"  class="btn btn-dark" data-toggle="tooltip"
                data-placement="bottom" title="Show"><i class="fa fa-eye"></i></a></div>
                ';

                return $action;
            })

            ->addColumn('partial', function ($transaction) {
                return ($transaction->transaction_id)?'Yes':'No';
            })
            
            ->addColumn('payment_type', function ($transaction) {
                $payment_type = '';
                if ($transaction->payment_type == 'credit_card') {
                    $payment_type = 'Credit Card';
                } else if ($transaction->payment_type == 'paypal') {
                    $payment_type = 'Pay Pal';
                } else if ($transaction->payment_type == 'user_credit') {
                    $payment_type = 'User Credit';
                }
                return $payment_type;
            })
            // ->addColumn('merchant', function ($transaction) {
            //     $button = '';
            //     isset($transaction->merchant) ?
            //         $button .= '<a  href="' . route('admin.merchants.show', ['merchant' => $transaction->merchant->id]) . '">' . $transaction->merchant->name . '</a>' : 'undefined';
            //     return $button;
            // })
            ->addColumn('payment_date', function ($transaction) {
                return date('m-d-Y', strtotime($transaction->payment_date));
            })
            ->addColumn('amount', function ($transaction) {
                return 'CAD ' . $transaction->amount;
            })
            ->rawColumns(['checkboxes', 'merchant', 'actions'])
            ->make(true);
    }
}
