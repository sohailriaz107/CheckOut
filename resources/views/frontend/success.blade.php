<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
        }

        .container {
            background-color: rgb(146, 204, 146);
            width: 100%;
            height: 100vh;
            position: relative;
        }

        p {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);

            font-size: 100px;
            font-family: Arial, Helvetica, sans-serif;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <p class="message">Success !</p>
</div>

</body>
</html>
