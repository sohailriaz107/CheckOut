<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Payment Portal</title>
    <link rel="icon" type="image/png" href="https://myoffice.mybackpocket.co/images/fav-main.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">


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

    </style>


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">

<main class="form-signin">
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6">Payement Portal</h1>
            </div>

        </div> <!-- End -->
        <div class="col-lg-6 col-md-12 row  mx-auto">
            <div class="col-md-6" style="align-text: left;">
                <img src="{{ URL::asset('merchant_logos') . '/' . $merchant->logo }}" width="250px"
                />
            </div>
            <div class="col-md-6 pull-right">
                    <span style="align-text: right; font-weight: bold;">
                        Amount : CAD {{ $transaction->amount }}
                    </span>
            </div>
        </div> <!-- End -->
        <br>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        @endif
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                @if($merchant->credit_card == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#credit-card" class="nav-link active ">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Credit Card
                                        </a>
                                    </li>
                                @endif
                                @if($merchant->paypal == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#paypal" class="nav-link ">
                                            <i class="fab fa-paypal mr-2"></i> Paypal
                                        </a>
                                    </li>
                                @endif
                                @if($merchant->user_credit == 1)
                                    <li class="nav-item">
                                        <a data-toggle="pill" href="#user_credit" class="nav-link ">
                                            <i class="fas fa-piggy-bank mr-2"></i> User Credit
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form method="POST" action="{{ route('payment.paymentSubmit') }}"
                                      id="credit-pay">
                                    @csrf
                                    <div class="form-group"><label for="name">
                                            <h6>Card Owner</h6>
                                        </label> <input type="text" name="name" placeholder="Card Owner Name"
                                                        class="form-control "></div>
                                    <div class="form-group"><label for="card">
                                            <h6>Card number</h6>
                                        </label>
                                        <div class="input-group"><input type="text" name="card"
                                                                        placeholder="Valid card number"
                                                                        class="form-control ">
                                            <div class="input-group-append"> <span
                                                    class="input-group-text text-muted"> <i
                                                        class="fab fa-cc-visa mx-1"></i> <i
                                                        class="fab fa-cc-mastercard mx-1"></i> <i
                                                        class="fab fa-cc-amex mx-1"></i> </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group"><label><span class="hidden-xs">
                                                            <h6>Expiration Date</h6>
                                                        </span></label>
                                                <div class="input-group">
                                                    <select class="form-control valid" id="month" name="month">
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
                                                    {{-- <input type="number" placeholder="MM" name="month"
                                                        class="form-control" required> <input type="number"
                                                        placeholder="YY" name="year" class="form-control"
                                                        required> --}}

                                                    <select class="form-control valid" id="year" name="year">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-4"><label data-toggle="tooltip"
                                                                                title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> <input type="text" name="cvv"
                                                                class="form-control"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit"
                                                class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment
                                        </button>
                                </form>
                            </div>
                        </div> <!-- End -->
                        <!-- Paypal info -->
                        <div id="paypal" class="tab-pane fade pt-3">

                            <p><a href="{{ route('payment.payPal') }}" class="btn btn-primary "><i
                                        class="fab fa-paypal mr-2"></i> Log
                                    into my Paypal</a></p>
                            <p class="text-muted"> Note: After clicking on the button, you will be directed to a
                                secure gateway for payment. After completing the payment process, you will be
                                redirected back to the website to view details of your order. </p>
                        </div> <!-- End -->

                        <div id="user_credit" class="tab-pane fade pt-5">

                            <p>
                                @if($credits < $transaction->amount)
                                    <a href="#!" class="btn btn-danger" style="pointer-events: none">
                                        <i class="fas fa-piggy-bank mr-2"></i>
                                        Insufficient Credit Balance
                                    </a>
                                @else
                                    <a href="{{ route('payment.userCredit') }}" class="btn btn-primary">
                                        <i class="fas fa-piggy-bank mr-2"></i>
                                        Pay using your credits
                                    </a>
                                @endif
                            </p>
                            <p class="bold">Credits : {{ $credits }}</p>
                            <p class="text-muted"></p>
                        </div>
                        <!-- bank transfer info -->

                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
</main>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id={{ \App\Models\Setting::Orderby('id', 'desc')->first()->paypal_live_client_id }}"></script>

<script>
    $(function () {
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
