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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

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
       form .error {
        color: #ff0000;
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
            </div>

        </div> <!-- End -->
        <br>
         <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <p ><span class="display-7">Backpocket Payments</span></p>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">

                        <div class="shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <h3 class="text-center">Empty Checkout</h3>
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



</html>
