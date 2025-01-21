<?php

    $conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');

    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = md5($_POST['password']);
        $cpass = md5($_POST['cpassword']);



        $select = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $select);
        $email_count = mysqli_num_rows($result);

        $select = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $select);
        $user_count = mysqli_num_rows($result);


        if($email_count == 0 && $user_count == 0 && $pass == $cpass){
            session_start();
            $_SESSION['email'] = $email;
            $insert = "INSERT INTO users(username, email, password)
                VALUES('$username', '$email', '$pass')";

                mysqli_query($conn, $insert);
                header('location:spotify_link.php');
        }else{
            if($email_count > 0){
                $error1 = 'This email is already in use!';
            }
            if($user_count > 0){
                $error2 = 'This username is already taken!';
            }
            if($pass != $cpass){
                $error3 = 'Passwords are not matching!';
            }

        }


    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>

        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .container{
            height: 300px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 100px;
            gap: 40px;
        }

        .cross{
            height: 100%;
            width: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cross .vertical{
            height: 100%;
            width: 15px;
            background-color: white;
            position: absolute;
        }

        .cross .horizontal{
            width: 100%;
            height: 15px;
            background-color: white;
            position: absolute;
            bottom: 60px;
        }

        .register-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .register-container h1{
            color: white;
        }

        .register-container label{
            color: white;
        }

        .register-container div{
            display: flex;
            flex-direction: column;
            width: 80%;
        }

        .register-container input{
            width: 100%;
            height: 35px;
            background-color: #575757;
            border-radius: 5px;
            border: none;
            color: white;
        }

        .register-container button{
            font-family: "Metal mania", serif;
            background-color: white;
            color: black;
            border: none;
            border-radius: 35px;
            padding-left: 30px;
            padding-right: 30px;
            padding-top: 10px;
            padding-bottom: 10px;
            cursor: pointer;
            position: relative; /* Pro umístění rámečku */
            outline: none;
            transition: box-shadow 0.3s ease;
        }

        .register-container button::after {
            content: ''; /* Pseudo-element je prázdný */
            position: absolute; /* Umístění kolem tlačítka */
            top: -5px; /* Vzdálenost od horního okraje */
            left: -5px; /* Vzdálenost od levého okraje */
            right: -5px; /* Vzdálenost od pravého okraje */
            bottom: -5px; /* Vzdálenost od spodního okraje */
            border: 2px solid white; /* Rámeček */
            border-radius: 35px; /* Zaoblení okrajů rámečku */
            opacity: 0; /* Rámeček je na začátku neviditelný */
            transition: opacity 0.3s ease; /* Plynulý přechod viditelnosti */
        }

        /* Zobrazit rámeček při najetí myši */
        .register-container button:hover::after {
            opacity: 1; /* Rámeček se zobrazí */
        }

        
    </style>
</head>
<body>
    <div class="container">
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
        <form action="" method="POST">
            <div class="register-container">
                <h1>Create your freaking account</h1>
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <br>
                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <br>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <br>
                <div>
                    <label for="cpassword">Confirm password:</label>
                    <input type="password" id="cpassword" name="cpassword" required>
                </div>
                <br>
                <button type="submit" name="submit">Sign up</button>
            </div>
        </form>
        
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
    </div>
</body>
</html>