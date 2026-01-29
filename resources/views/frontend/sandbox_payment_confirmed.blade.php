<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Payment Portal</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link rel="icon" type="image/png" href="https://myoffice.mybackpocket.co/images/fav-main.png" />

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">

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
        .payment-card{
            background-color: #FFEFC0 !important;
            font-family: 'Montserrat' !important;
        }
        .card-header .nav-pills .nav-link, .nav-pills .show > .nav-link
        {
            color: #000;
            font-size: 18px;
            font-weight: 650;
            border: solid 1px #b0b1b3;
            border-radius: unset;
        }

        .card-header .nav-pills .nav-link.active, .nav-pills .show > .nav-link
        {
            background-color: #ffc435;

        }
        .card {
            background-color: #faf9f2;
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
        color: #000;font-weight: 650;font-size: 20px;
       }
       body{
            background-color: #fff !important;
       }
    </style>


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body >

<main class="form-signin">
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="col-lg-6 col-md-12 row  mx-auto mb-4">
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
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card payment-card">
                    <div class="card-header">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        @endif
                        <div class="shadow-sm pl-2 pr-2">
                            <p ><span class="display-7">PAYMENT &nbsp;&nbsp;</span> <span>(Select Payment Method)</span></p>
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3" style="solid 1px #979b99;">
                                 @if($merchant->user_credit == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#user_credit" class="nav-link <?php echo ($pay_type=="User Credit")?'active':'' ?>">
                                            CREDITS
                                        </a>
                                    </li>
                                @endif
                                @if($merchant->credit_card == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#credit_card" class="nav-link <?php echo ($pay_type=="Credit Card")?'active':'' ?>">
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
                        <div id="user_credit" class="tab-pane fade  <?php echo ($pay_type=="User Credit")?'show active':'' ?> pt-2">
                             <div class="card-footer col-md-12">
                               <table style="border-bottom: 1px solid #b0acac;">
                                <tr>
                                    <th style="text-align: left;width: 100%;">PAYMENT CONFIRMATION</th>
                                    <th style="text-align: right;">AMOUNT</th>
                                </tr>
                                  @foreach($partialPayments AS $partial)
                                 <tr>
                                    <td>REFERENCE# <b>{{$partial->transaction_id}}</b></td>
                                    <td>${{number_format((float)$partial->amount, 2, '.', '')}}</td> 
                                 </tr>
                                  @endforeach
                               </table>
                             </div> 

                             @if($credits)
                             <div class="card-footer col-md-6">
                                <h6 class="text-center">CREDITS BALANCE</h6>
                                <p class="transaction-bold">${{ $credits }}</p>
                             </div>
                            @endif
                            <div class="card-footer col-md-6">
                                <h3 class="text-center">Thank You!</h3>
                             </div>
                            <div class="card-footer  col-md-6">
                                <a class="subscribe btn btn-primary btn-block shadow-sm" href="{{$checkout_url}}"> RETURN </a>
                            </div>
                            <p class="text-muted"></p>
                        </div> 

                        <div id="credit_card" class="tab-pane fade  <?php echo ($pay_type=="Credit Card")?'show active':'' ?> pt-2">
                            <div class="card-footer col-md-12">
                                <table style="border-bottom: 1px solid #b0acac;">
                                 <tr>
                                     <th style="text-align: left;width: 100%;">PAYMENT CONFIRMATION</th>
                                     <th style="text-align: right;">AMOUNT</th>
                                 </tr>
                                   @foreach($partialPayments AS $partial)
                                 <tr>
                                    <td>REFERENCE# <b>{{$partial->transaction_id}}</b></td>
                                    <td>${{number_format((float)$partial->amount, 2, '.', '')}}</td> 
                                 </tr>
                                  @endforeach
                                </table>
                              </div>
                              <div class="card-footer col-md-6">
                                <h3 class="text-center">Thank You!</h3>
                             </div>
                             <div class="card-footer  col-md-6">
                                 <a class="subscribe btn btn-primary btn-block shadow-sm" href="{{$checkout_url}}"> RETURN </a>
                             </div>
                             <p class="text-muted"></p>
                         </div>

                        <!-- Paypal info -->
                        <div id="paypal" class="tab-pane fade pt-3 <?php echo ($pay_type=="Paypal")?'show active':'' ?>">
                            <div class="card-footer col-md-12">
                                <table style="border-bottom: 1px solid #b0acac;">
                                 <tr>
                                     <th style="text-align: left;width: 100%;">PAYMENT CONFIRMATION</th>
                                     <th style="text-align: right;">AMOUNT</th>
                                 </tr>
                                  @foreach($partialPayments AS $partial)
                                 <tr>
                                    <td>REFERENCE# <b>{{$partial->transaction_id}}</b></td>
                                    <td>${{number_format((float)$partial->amount, 2, '.', '')}}</td>  
                                 </tr>
                                  @endforeach
                                </table>
                              </div>
                             <div class="card-footer col-md-6">
                                <h3 class="text-center">Thank You!</h3>
                             </div>
                             <div class="card-footer  col-md-6">
                                 <a class="subscribe btn btn-primary btn-block shadow-sm" href="{{$checkout_url}}"> RETURN </a>
                             </div>
                             <p class="text-muted"></p>
                            
                        </div>  
                                  
                        </div> 
                        <!-- End -->

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
