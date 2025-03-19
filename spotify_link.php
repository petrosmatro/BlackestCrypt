<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Link</title>

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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
        <div class="login-container">
            <h1>Link account with Spotify</h1>
            <button id="spotify-connect">Link with Spotify</button>
        </div>
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
    </div>

    <script>
        document.getElementById("spotify-connect").addEventListener("click", function () {
            
            const clientId = "2810eaa769ff470d912020b8ac069eeb";
            const redirectUri = "https://blackest-crypt.com/spotify_callback.php";
            const scope = "user-read-email playlist-read-private";

            const authUrl = `https://accounts.spotify.com/authorize?client_id=${clientId}&response_type=code&redirect_uri=${encodeURIComponent(redirectUri)}&scope=${encodeURIComponent(scope)}`;
            window.location.href = authUrl;
        });
    </script>
</body>
</html>