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
                <h1 class="display-6">Empty Cart</h1>
            </div>

        </div> <!-- End -->
        <div class="col-lg-6 col-md-12 row  mx-auto">
            <div class="col-md-6" style="align-text: left;">
               
            </div>
            <div class="col-md-6 pull-right">
            </div>
            @if($url)<p><a href="">Go back to home page</a></p>@endif
        </div> <!-- End -->
        <br>

</main>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id={{ \App\Models\Setting::Orderby('id', 'desc')->first()->paypal_sandbox_client_id }}"></script>

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
