<?php

session_start();
include 'db.php';

$bands = mysqli_query($conn, 'SELECT * FROM artists ORDER BY id_artist DESC');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Bands</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">
    
    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }


        .title{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .artist-card{
            width: 180px;
            height: 80px;
            background-color: #5B5B5B;
            display: flex;
            align-items: center;
            border-radius: 20px;
        }

        .artist-title{
            height: 50%;
            margin-left: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .artist-title p{
            margin: 0;
        }

        .artist-name{
            color: white;
            font-size: 15px;
        }

        .artist-genres{
            color: #A1A1A1;
            font-size: 10px;
        }


        .artist-card img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #B9B9B9;
            margin-left: 10px;
            object-fit: cover;
        }

        .bands{
            width: 800px;
            height: 200px;
            margin: 60px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .bands a{
            text-decoration: none;
        }

    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="title">
        <h1>Community created bands</h1>
    </div>
    <div class="bands">
        <?php foreach ($bands as $band){?>
        
            <a href="community_band.php?id=<?php echo $band['id_artist']; ?>">
                <div class="artist-card">
                    <img src="artistImgs/<?php echo $band['artist_image']; ?>" alt="">
                    <div class="artist-title">
                        <p class="artist-name"><?php echo $band['artist_name']; ?></p>
                    </div>
                </div>
            </a>
        <?php }?>
    </div>
    
</body>
</html>