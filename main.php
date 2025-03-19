<?php

    session_start();
    include 'db.php';
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">
    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .main-items{
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 70px;
            
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

        .main-text{
            width: 400px;
            text-align: center;
        }

        .main-text p{
            color: white;
            font-size: 30px;
        }

        .bottom-part{
            margin-top: 30px;
            width: 100%;
            height: 300px;
            display: flex;
            gap: 350px;
            align-items: center;
            justify-content: center;
        }

        .bottom-part .main-card{
            height: 100%;
            width: 150px;
            background-color: black;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 3px;
            color: white;
        }

        .main-card hr{
            width: 100%;
        }

        .main-card h4{
            margin: 0;
        }

        .band-card{
            width: 100%;
            height: 30px;
            background-color: #2E2E2E;
            padding: 6px;
            display: flex;
            flex-direction: row;
            align-items: center;
            border-radius: 10px;
        }

        .band-card img{
            width: 30px;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #888888;
            object-fit: cover;
        }
        
        .band-card p{
            margin-left: 5px;
        }

        .genre-card{
            width: 100%;
            height: 30px;
            background-color: #2E2E2E;
            padding: 6px;
            display: flex;
            flex-direction: row;
            align-items: center;
            border-radius: 10px;
        }

        .genre-card img{
            width: 30px;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #888888;
            object-fit: cover;
        }
        
        .genre-card p{
            margin-left: 5px;
        }


    </style>
</head>
<body>
    <?php include "header.php";?>
    
    <div class="main-items">
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
        <div class="main-text">
            <p>The Blackest Crypt means a home for those, who are loyal to metal and rock music. Metalheads and rockers will love this.</p>
        </div>
        <div class="cross">
            <div class="vertical"></div>
            <div class="horizontal"></div>
        </div>
    </div>

    

    <script>
        
        console.log('<?php echo $accessToken;?>');

        
    </script>
</body>
</html>