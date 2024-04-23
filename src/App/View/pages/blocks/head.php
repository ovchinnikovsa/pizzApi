<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <style>
        body {
            font-family: Consolas ;
        }

        .links {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .links li {
            list-style: circle;
        }

        .links .dir, li:before {
            list-style: square;
        }

        a {
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="links">