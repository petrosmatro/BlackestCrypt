<?php

    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');
    
    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = md5($_POST['password']);
        

        $select = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        $select = "SELECT * FROM users WHERE password = '$pass'";
        $passres = mysqli_query($conn, $select);
        $pass_count = mysqli_num_rows($passres);

        if(mysqli_num_rows($result) == 0){
            $error = "This account does not exist";
        }
        else if($pass_count == 0){
            $error2 = "Wrong password!!";
        }else{
            
            $row = mysqli_fetch_array($result);
            $userId = $row['id_user'];
            $accessToken = $row['spotify_access_token'];
            $refreshToken = $row['spotify_refresh_token'];
            $expiresAt = $row['spotify_expires_at'];

            if($accessToken && $expiresAt > time()){
                $_SESSION['spotify_access_token'] = $accessToken;
            } elseif($refreshToken){
                $newTokenData = refreshSpotifyToken($refreshToken);

                if($newTokenData){
                    $_SESSION['spotify_access_token'] = $newTokenData['access_token'];

                    $newExpiresAt = time() + $newTokenData['expires_in'];
                    $updateSql = "UPDATE users SET spotify_access_token = ?, spotify_expires_at = ? WHERE id_user = ?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bind_param("sii", $newTokenData['access_token'], $newExpiresAt, $userId);
                    $updateStmt->execute();
                    $updateStmt->close();
                }
            }
            $_SESSION['user_id'] = $userId;
            
            header('location:main.php');
        }
    }

    function refreshSpotifyToken($refreshToken) {
        $clientId = "2810eaa769ff470d912020b8ac069eeb";
        $clientSecret = "17d9248edc824df983f3005855fc11d3";
    
        $url = "https://accounts.spotify.com/api/token";
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ];
    
        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
    
        return $response ? json_decode($response, true) : null;
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

        .login-container{
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .login-container label{
            color: white;
        }

        .login-container div{
            display: flex;
            flex-direction: column;
            width: 80%;
        }

        .login-container input{
            width: 100%;
            height: 35px;
            background-color: #575757;
            border-radius: 5px;
            border: none;
            color: white;
        }

        .login-container h1{
            color: white;
        }

        .login-container button{
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
            position: relative;
            outline: none;
            transition: box-shadow 0.3s ease;
        }

        .login-container button::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid white;
            border-radius: 35px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        
        .login-container button:hover::after {
            opacity: 1;
        }

        .register-container{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .register-container p{
            color: white;
        }

        .register-container a{
            color: black;
            background-color: white;
            text-decoration: none;
            border-radius: 20px;
            padding: 5px 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
        <form action="" method="post">
            <div class="login-container">
                <h1>Sign In</h1>
                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <br>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <br>
                <button type="submit" name="submit">Sign In</button>
            </div>
        </form>
        
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
    </div>

    <div class="register-container">
        <p>You don't have an account?</p>
        <a href="register.php">Register</a>
    </div>
</body>
</html>