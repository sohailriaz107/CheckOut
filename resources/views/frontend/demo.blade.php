<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>BackPocket Payment Portal</title>
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

        .payment-div {
            display: flex;
        }

        .name-div {
            text-align: left;
            padding-left: 170px;
            flex: 1;
        }

        .input-div {
            flex: 3;
            text-align: left;
        }

        .input-div input {
            margin-bottom: 5px;
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
                <h1 class="display-6"><strong>Backpocket</strong><br>Payement Portal</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <form action="{{ route('backpocket.demo.payment.submit') }}" method="GET"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="payment-div">
                                    <div class="name-div">
                                        <label>Amount(CAD) <span>:</span></label><br>
                                        <label>Order ID <span>:</span></label><br>
                                    </div>
                                    <div class="input-div">
                                        <input type="text" id="amount" name="amount" required><br>
                                        <input type="number" id="orderId" name="orderId" required><br>
                                    </div>
                                </div>
                                <input type="hidden" id="transactionDateTime" name="transactionDateTime"
                                       value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="merchantPgIdentifier" name="merchantPgIdentifier" value="205">
                                <input type="hidden" id="currency" name="currency" value="CAD">
                                <input type="hidden" id="invoiceNumber" name="invoiceNumber" value="5">
                                <input type="hidden" id="successUrl" name="successUrl"
                                       value="{{ route('payment.success') }}">
                                <input type="hidden" id="errorUrl" name="errorUrl" value="{{ route('payment.error') }}">
                                <input type="hidden" id="storeName" name="storeName" value="store">
                                <input type="hidden" id="transactionType" name="transactionType" value="">
                                <input type="hidden" id="timeout" name="timeout" value="">
                                <input type="hidden" id="credits" name="credits"
                                       value="500">
                                <input type="hidden" id="language" name="language" value="EN">
                                <input type="hidden" id="txnToken" name="txnToken"
                                       value="token">
                                <input type="hidden" id="itemList" name="itemList" value="list">
                                <input type="hidden" id="otherInfo" name="otherInfo" value="">
                                <input type="hidden" id="merchantCustomerPhone" name="merchantCustomerPhone"
                                       value="04353563535">
                                <input type="hidden" id="merchantCustomerEmail" name="merchantCustomerEmail"
                                       value="customer@gmail.com">
                                <br>
                                <input type="submit" value="Submit">
                            </form>
                        </div> <!-- End -->
                    </div>
                </div>
            </div>
        </div>
</main>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</html>
