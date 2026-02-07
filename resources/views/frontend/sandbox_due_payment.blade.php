<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Payment Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('merchant_logos/fav-main.png') }}">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
    <script>
       $(document).ready(function() {
          $("#usercredit-pay").validate();
       });
    </script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        body {
            background: #f5f5f5
	        font-family: Montserrat!important;		
        }

        .rounded {
            border-radius: 1rem
        }

        .nav-pills .nav-link {
            color: #555
        }

        .nav-pills .nav-link.active {
            color: white
        }

        input[type="radio"] {
            margin-right: 5px
        }

        .bold {
            font-weight: bold
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .display-7{
              font-size: 19px;
              font-weight: 650;
        }
        .card-header .nav-pills .nav-link, .nav-pills .show > .nav-link
        {
            color: #000;
            font-size: 18px;
            font-weight: 650;
            border: solid 1px #b0b1b3;
            border-radius: unset;
        }

        .card-header .nav-pills .show > .nav-link
        {
            background-color: #white;

        }
        .nav-pills .nav-link.active {
            background-color: #ffc435;
        }
        .card {
            background-color: white;
        }
        .btn-primary
        {
            background-color: #ffc435;
            border: solid 1px #b0b1b3; 
            font-size: 16px;
            font-weight: 650;
            color: #000;
        }
        .btn-primary:hover{
            background-color: #b0b1b3;
            border: solid 1px #000;
            color: #fff;
        }
        .btn-cancel:hover{
            background-color: red !important;  
        }
       .form-control { 
            border: 1px solid #7c7d7d;
       }
       .card-footer{
           margin-left: auto;
           margin-right: auto;
           background-color:unset;
           border:unset;
       }
       .label{
        float: left;
       }
       h6{
        font-size: 13px;
        font-weight: 575;
       }
       .text-center {
         text-align: center;
       }
       .transaction-bold{
       	color: #000;font-weight: 650;font-size: 20px;text-align: center;
       }
       .normal-transaction-bold{
       	color: #000;font-weight: 650;font-size: 20px;font-family: Montserrat;
       }

    </style>


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body >

<main class="form-signin">
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="col-lg-6 col-md-12 row  mx-auto">
            <div class="col-md-12 text-center" style="align-text: left;">
                <img src="{{ URL::asset('merchant_logos') . '/' . $merchant->logo }}" width="250px"
                     style="max-height: 100px;"/>
            </div>
<!--             <div class="col-md-6 pull-right">
                    <span style="align-text: right; font-weight: bold;">
                        Amount : CAD {{ $transaction->amount }}
                    </span>
            </div> -->
        </div> <!-- End -->
        <br>
         <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <p ><span class="display-7">PAYMENT &nbsp;&nbsp;</span> <span>(Select Payment Method)</span></p>
            </div>
        </div> <!-- End -->
       <?php 
        $payment_type=$partialPayments->payment_type;

        ?>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}  
                            </div>
                        @endif
                        <div class="shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3" style="solid 1px #979b99;">
                                 @if($merchant->user_credit == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#user_credit" class="nav-link active">
                                            CREDITS
                                        </a>
                                    </li>
                                @endif
                                @if($merchant->credit_card == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#credit-card" class="nav-link ">
                                            CREDIT CARD
                                        </a>
                                    </li>
                                @endif
                                @if($merchant->paypal == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#paypal" class="nav-link ">
                                           PAYPAL
                                        </a>
                                    </li>
                                @endif
                               
                            </ul>
                        </div> <!-- End -->

                        <div class="tab-content"> 
                        <!-- Credit payment info -->

                        <div id="user_credit" class="tab-pane fade show active">
						<table style="width:100%;text-align: center;border-bottom: 1px solid #b0acac;">
                                <tr>
                                    <th style="width:25%;text-align: right;">PAYMENT CONFIRMATION</th>
                                    <th style="width:25%;text-align: right;">AMOUNT</th>
                                </tr>
                         </table>
                         <table style="width:100%;text-align: center;">
                             <tr>
                                 <td style="width:25%;text-align: right;">REFERENCE# <b>{{$partialPayments->transaction_id}}</b></td>
                                 <td style="width:25%;text-align: right;">${{number_format((float)$partialPayments->amount, 2, '.', '')}}</td>
                             </tr>
                        </table>
                          @if($credits)
					<form method="POST" action="{{ route('payment.sandbox.user.credit') }}" id="usercredit-pay">
                           @csrf
                           <table style="width:100%;text-align: center;">
                               <tr>
                                   <td style="width:25%;text-align: right;">CREDITS BALANCE:</td>
                                   <td style="width:25%;text-align: right;"><span class="transaction-bold">${{  number_format((float)round($credits, 0), 2, '.', '') }}</span></td>
                               </tr>
                           </table>
                            @endif
                          <table style="width:100%;text-align: center;">
                               <tr>
                                   <td style="width:25%;text-align: right;">AMOUNT DUE:</td>
                                   <td style="width:25%;text-align: right;"><span class="transaction-bold">${{ number_format((float)$partialPayments->due_amount, 2, '.', '') }}</span></td>
                               </tr>
                           </table>
                               @if($credits)
                               @if($partialPayments->due_amount=="")
                                <table style="width:100%;text-align: center;">
                               <tr>
                                   <td style="width:25%;text-align: right;">PAYMENT:</td>
                                   <td style="width:25%;">
                                       <div style="display: flex; align-items: center; border: 1px solid #ced4da; border-radius: 4px; padding: 2px 5px; width: 60%; margin-left: auto;">
                                           <span style="font-weight: bold; margin-right: 5px; font-size: 16px;">$</span>
                                           <input type="text" name="pay_amount" style="width: 100%; border: none; outline: none; font-weight: bold; font-size: 16px;" />
                                       </div>
                                   </td>
                               </tr>
                                </table>
                                @endif
                                @endif
                                @if($credits < $transaction->amount)
                                  <div class="card-footer col-md-6">
                                    <a href="#!" class="btn btn-danger" style="pointer-events: none">
                                        Insufficient Credit Balance
                                    </a>
                                </div>
                                @else
                                @if($payment_type!="user_credit")
                                 <div class="card-footer col-md-6 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-primary mr-2">PAY BALANCE</button>
                                    <a class="btn btn-primary btn-cancel" href="{{ route('sandbox.cancel') }}">CANCEL</a>
                                 </div>
                                 @endif  
                                @endif  
                            </p>
							</form>

                            <p class="text-muted"></p>
                        </div> 
                        <!-- End -->
                            <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade">
				
                        <table style="width:100%;text-align: center;border-bottom: 1px solid #b0acac;">
                                <tr>
                                    <th style="width:25%;text-align: right;">PAYMENT CONFIRMATION</th>
                                    <th style="width:25%;text-align: right;">AMOUNT</th>
                                </tr>
                                <tr>
                                    <td style="width:25%;text-align: right;">REFERENCES# <b>{{$partialPayments->transaction_id}}</b></td>
                                    <td style="width:25%;text-align: right;">${{$partialPayments->amount}}</td>
                                </tr>
                         </table>
                         <div class="card-footer col-md-12">
                            <label style="font-weight:bold;text-align: center;width: 100%;">BALANCE DUE</lable>
                            <p style="font-weight:bold;text-align: center;">${{$partialPayments->due_amount}}</p>
                         </div>
                          @if($payment_type!="credit_card")
                                <form method="POST" action="{{ route('sandbox.payment.credit.card') }}?type=credit-card"
                                      id="credit-pay">
                                    @csrf
                                    <div class="form-group"><label for="name">
                                            <h6>Cardholder Name</h6>
                                        </label> <input type="text" name="name" placeholder="Card Owner Name"
                                                        class="form-control "></div>
                                    <div class="form-group"><label for="card">
                                            <h6>Card Number</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="card" placeholder="Valid card number" class="form-control ">
                                            <div class="input-group-append"> <span
                                                    class="input-group-text text-muted"> <i
                                                        class="fab fa-cc-visa mx-1"></i> <i
                                                        class="fab fa-cc-mastercard mx-1"></i> <i
                                                        class="fab fa-cc-amex mx-1"></i> </span>
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="col-md-5" style="float: left;margin-left: -14px;">
                                                    <label>
                                                        <span class="hidden-xs">
                                                            <h6>Expiration Date</h6>
                                                        </span>
                                                    </label>
                                                    <select class="form-control valid" id="month" name="month" style="width: 50%;float: left;">
                                                        <option value="">MM</option>
                                                        <option value="01">Jan</option>  
                                                        <option value="02">Feb</option>
                                                        <option value="03">Mar</option>
                                                        <option value="04">Apr</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">Aug</option>
                                                        <option value="09">Sep</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>

                                                    <select class="form-control valid" id="year" name="year" style="width: 50%;">
                                                        <option value="">YY</option>
                                                        <option value="<?php echo substr(date('Y'), 2); ?>">
                                                            <?php echo date('Y'); ?></option>
                                                        <option value="<?php echo substr(date('Y') + 1, 2); ?>">
                                                            <?php echo date('Y') + 1; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 2, 2); ?>">
                                                            <?php echo date('Y') + 2; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 3, 2); ?>">
                                                            <?php echo date('Y') + 3; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 4, 2); ?>">
                                                            <?php echo date('Y') + 4; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 5, 2); ?>">
                                                            <?php echo date('Y') + 5; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 6, 2); ?>"> 
                                                            <?php echo date('Y') + 6; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 7, 2); ?>">
                                                            <?php echo date('Y') + 7; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 8, 2); ?>">
                                                            <?php echo date('Y') + 8; ?></option>
                                                        <option value="<?php echo substr(date('Y') + 9, 2); ?>">
                                                            <?php echo date('Y') + 9; ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" style="float: left;">
                                                <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> 
                                                <input type="text" name="cvv" class="form-control" style="width: 70%;">
                                                </div>
                                                <div class="col-md-4" style="float: left;">
                                                  
                                                </div>
                                        </div>
                                    </div>
                                    <div class="card-footer  col-md-6 d-flex justify-content-center align-items-center">
                                        <button type="submit"
                                                 class="subscribe btn btn-primary btn-block shadow-sm mr-2"> PAY BY CREDIT CARD
                                        </button>
                                        <a class="btn btn-primary btn-cancel" href="{{ route('sandbox.cancel') }}">CANCEL</a>
                                    </div>
                                </form>         
                             @endif
                        </div> <!-- End -->
                        <!-- Paypal info -->
                        <div id="paypal" class="tab-pane fade">
                            <form method="POST" action="{{ route('payment.sandbox.payPal') }}" id="paypal-pay">
                            @csrf
                      <table style="width:100%;text-align: center;border-bottom: 1px solid #b0acac;">
                                <tr>
                                    <th style="width:25%;text-align: right;">PAYMENT CONFIRMATION</th>
                                    <th style="width:25%;text-align: right;">AMOUNT</th>
                                </tr>
                                <tr>
                                    <td style="width:25%;text-align: right;">REFERENCES# <b>{{$partialPayments->transaction_id}}</b></td>
                                    <td style="width:25%;text-align: right;">${{$partialPayments->amount}}</td>
                                </tr>
                          </table>
                         <div class="card-footer col-md-12">
                            <label style="font-weight:bold;text-align: center;width: 100%;">BALANCE DUE</lable>
                            <p style="font-weight:bold;text-align: center;">${{$partialPayments->due_amount}}</p>
                         </div>
                             <div class="card-footer col-md-6 d-flex justify-content-center align-items-center">
                               @if($payment_type!="paypal")
                               <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm mr-2"> PAY BYPAYPAL
                               </button>
                               <a class="btn btn-primary btn-cancel" href="{{ route('sandbox.cancel') }}">CANCEL</a>
                                @endif
                              </div>
                             <p class="text-muted"> Note: After clicking on the button, you will be directed to a
                                secure gateway for payment. After completing the payment process, you will be
                                redirected back to the website to view details of your order. </p>
                          </form>
                             </div>  
                                  

                        </div> <!-- End -->

                        <!-- bank transfer info -->
     
                    </div>
                </div>
            </div>
        </div>
</main>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id={{ \App\Models\Setting::Orderby('id', 'desc')->first()->paypal_sandbox_client_id }}"></script>

<script>

    $(function () {
    	@if ($errors->any())
    	$('a[href="#credit-card"]').click();  
    	@endif

        $('#credit-pay').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                card: {
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 16
                },
                month: {
                    required: true,
                    number: true,
                    maxlength: 2
                },
                year: {
                    required: true,
                    number: true,
                    maxlength: 2
                },
                cvv: {
                    required: true,
                    maxlength: 4
                }
            },
            // Specify the validation error messages
            messages: {
                name: {
                    required: "Please enter card holder name",
                    maxlength: "Card holder name can not be more than 30 chars"
                },
                card: {
                    required: "Please enter your card number",
                    number: "Please enter valid card number",
                    minlength: "Please enter valid card number",
                    maxlength: "Please enter valid card number"
                },
                month: "Please enter a valid month",
                year: "Please enter a valid year",
                cvv: "Please enter a valid cvv"
            },
            errorElement: 'div',
            errorLabelContainer: '.errorTxt',
            submitHandler: function (form) {
                if ($("#webteamContactForm").valid()) {
                    form.submit();
                    return false;
                }
            }
        });

    });
</script>


</html>
