<?php

    session_start();
    include 'db.php';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - About Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">
    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .big-logo-container{
            width: 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .big-logo-container img{
            max-height: 100%;
            width: auto;
        }

        .paragraph-container{
            width: 100%;
            display: flex;
            justify-content: center;
            color: white;
        }

        .paragraph-container p{
            font-size: 20px;
            width: 50%;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "header.php";?>
    <div class="big-logo-container">
        <img src="staticImgs/logo.png" alt="">
    </div>
    <div class="paragraph-container">
        <p>We are the blackest site from Czech republic. We are there for metalheads, rockers and punkers. This site has been created as a graduation project. We focus on dark atmosphere and we hope that anyone, who comes here will have some fun at least for a while. If you are here for exploring new artists, then you are in the right place. Enjoy :D</p>
    </div>
</body>
</html>