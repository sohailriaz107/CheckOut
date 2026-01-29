@extends('admin.layouts.master')

@section('content')
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-md-6">
                <div class="bg-light rounded h-100 p-4">
                    <table class="table ">
                        <tr>
                            <td>
                                <b>ID</b>
                            </td>
                            <td>
                                {{ $transaction->transaction_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Invoice Number</b>
                            </td>
                            <td>
                                {{ $transaction->invoice_no }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Referance Id</b>
                            </td>
                            <td>
                                {{$partial->transaction_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Merchant</b>
                            </td>
                            <td>
                                {{ $transaction->merchant->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Order ID</b>
                            </td>
                            <td>
                                {{ $transaction->order_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Payment Type</b>
                            </td>
                            <td>
                                @if ($transaction->payment_type == 'credit_card')
                                Credit Card
                                @elseif ($transaction->payment_type == 'paypal')
                                 Pay Pal
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Payment Date</b>
                            </td>
                            <td>
                                {{ date('m-d-Y', strtotime($transaction->payment_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Amount</b>
                            </td>
                            <td>
                                CAD {{  $transaction->amount }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Status</b>
                            </td>
                            <td>
                                @if ($transaction->status == 'pending')
                                Pending
                                @elseif ($transaction->status == 'completed')
                                Complete
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if ($transaction->payment_type == 'credit_card' AND isset($payment_log->otherInfo))
            <div class=" bg-light  col-sm-6 col-md-6 p-2">
                <button type="submit" class="btn btn-success"  onclick="showHide()">See Payment Log</button>
                <div class="bg-light rounded  p-4 hidden" id="moreInfo" style="display:none;">
                    <?php
                        $payment_log=json_decode($payment_log->otherInfo);
                    ?>
                    <table class="table">
                        <tr>
                            <td><b>ID</b></td>
                            <td>{{$payment_log->id}}</td>
                        </tr>
                        <tr>
                            <td><b>Approved</b></td>
                            <td>{{($payment_log->approved)?'Yes':'No'}}</td>
                        </tr>
                        <tr>
                            <td><b>Message</b></td>
                            <td>{{$payment_log->message}}</td>
                        </tr>
                        <tr>
                            <td><b>Created</b></td>
                            <td>{{$payment_log->created}}</td>
                        </tr>
                        <tr>
                            <td><b>Order Number</b></td>
                            <td>{{$payment_log->order_number}}</td>
                        </tr>
                        <tr>
                            <td><b>Risk Score</b></td>
                            <td>{{$payment_log->risk_score}}</td>
                        </tr>
                        <tr>
                            <td><b>Amount</b></td>
                            <td>{{number_format((float)$payment_log->amount, 2, '.', '')}}</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
            @endif
            <div class="pull-right" style="float: left;">
                <a href="{{ route('admin.transactions.index') }}"><button type="button" class="btn btn-primary">Go Back</button></a>
            </div>
    </div>
    <!-- Form End -->
@endsection

@section('js')

<script>
    function showHide() {
        var table = document.getElementById("moreInfo");
            if (table.style.display === "none") {
                table.style.display = "block";
            } else {
                table.style.display = "none";
            }
    }
</script>
@endsection
