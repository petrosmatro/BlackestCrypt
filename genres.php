<?php

    session_start();
    include 'db.php';
    $metal = mysqli_query($conn, "SELECT * FROM subgenres WHERE genre_id = 1");
    $rock = mysqli_query($conn, "SELECT * FROM subgenres WHERE genre_id = 2");
    $punk = mysqli_query($conn, "SELECT * FROM subgenres WHERE genre_id = 3");


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Genres</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .genres-container{
            width: 100%;
            height: 300px;
            margin-top: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 80px;
            margin-bottom: 70px;
        }

        .genre{
            width: 100%;
            height: 100%;
            border-radius: 25px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            transition: transform 0.2s ease;
        }

        .genre:active{
            transform: scale(0.95);
        }

        .genre-wrapper{
            position: relative;
            height: 100%;
            width: 100px;
        }

        .genre-wrapper::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid white;
            border-radius: 30px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .genre-wrapper:hover::after {
            opacity: 1;
        }

        .genre-cover{
            width: 100%;
            height: 70%;
            overflow: hidden;
        }

        .genre-cover img{
            object-fit: cover;
            width: 100%;
            height: 100%;
            object-position: center;
        }

        .genre-title{
            background-color: #494949;
            color: white;
            overflow: hidden;
            width: 100%;
            height: 30%;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .modal{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content{
            width: 700px;
            height: 400px;
            border-radius: 30px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn {
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

        .left-side{
            height: 100%;
            width: 50%;
            overflow: hidden;
            display: inline-block;
            position: relative;
        }

        .left-side img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            display: block;
        }

        .genre-info{
            height: 20%;
            width: 100%;
            position: absolute;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .genre-info h3{
            color: white;
            margin: 0;
            margin-top: 3px;
            margin-left: 20px;
        }

        .genre-info p{
            color: white;
            font-size: 15px;
            margin: 0;
            margin-top: 3px;
            margin-left: 20px;
        }

        .genre-info hr{
            width: 90%;
            margin: 1px auto;
        }

        .right-side{
            max-height: 100%;
            width: 50%;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #2E2E2E;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
            padding-bottom: 30px;
            box-sizing: border-box;
            gap: 20px;
        }
        

        .sub-genre{
            width: 90%;
            height: 50px;
            background-color: #5B5B5B;
            border-radius: 5px;
        }

        .sub-genre:hover{
            background-color: #6B6B6B;
        }

        .sub-genre a{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sub-genre h2{
            font-size: 20px;
            color: white;
            margin-left: 10px;
        }

        .title{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .title h1{
            font-size: 50px;
            color: white;
        }
        



        
        
    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="title">
        <h1>Genres</h1>
    </div>
    

    <div class="genres-container">
        <div class="genre-wrapper">
            <div class="genre">
                <div class="genre-cover">
                    <img src="staticImgs/metal.jpg" alt="">
                </div>
                <div class="genre-title">
                    <p>Metal</p>
                </div>
            </div>
        </div>
        
        <div class="genre-wrapper">
            <div class="genre">
                <div class="genre-cover">
                    <img src="staticImgs/rock.jpg" alt="">
                </div>
                <div class="genre-title">
                    <p>Rock</p>
                </div>
            </div>
        </div>
        
        <div class="genre-wrapper">
            <div class="genre">
                <div class="genre-cover">
                    <img src="staticImgs/punk.jpg" alt="">
                </div>
                <div class="genre-title">
                    <p>Punk-rock</p>
                </div>
            </div>
        </div>

        
        
    </div>

    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="left-side">
                <img id="genre-cover" src="" alt="">
                <div class="genre-info">
                    <h3 id="genre-title"></h3>
                    <hr>
                    <p id="genre-text"></p>
                </div>
            </div>
            <div id="genre-list" class="right-side">
                
            </div>
        </div>
    </div>

    <script>

            const genres = document.querySelectorAll('.genre');
            const modal = document.getElementById('modal');
            const genreTitle = document.getElementById('genre-title');
            const genreText = document.getElementById('genre-text');
            const genreCover = document.getElementById('genre-cover');
            const closeBtn = document.querySelector('.close-btn');
            const genresList = document.getElementById('genre-list');

            function replaceSpaces(subGenreName){
                return subGenreName.replace(/ /g, '-');
            }
            genres.forEach(genre => {
                genre.addEventListener('click', async () => {
                    const genreName = genre.querySelector('p').textContent;

                    if(genreName === 'Metal'){
                        genreTitle.textContent = 'Metal';
                        genreText.textContent = 'Metal is heavy';
                        genreCover.src = 'staticImgs/metal.jpg';
                        genresList.innerHTML = `
                            <?php foreach($metal as $m){?>
                                <div class="sub-genre">
                                    <a class="sub-genre-link" href="genre.php?name=<?php echo $m['name'];?>">
                                        <h2><?php echo $m['name'];?></h2>
                                    </a>  
                                </div> 
                            <?php }?>
                        `;
                        
                    } else if(genreName === 'Rock'){
                        genreTitle.textContent = 'Rock';
                        genreText.textContent = 'Rock is soft';
                        genreCover.src = 'staticImgs/rock.jpg';
                        genresList.innerHTML = `
                            <?php foreach($rock as $r){?>
                                <div class="sub-genre">
                                    <a class="sub-genre-link" href="genre.php?name=<?php echo $r['name'];?>">
                                        <h2><?php echo $r['name'];?></h2>
                                    </a>  
                                </div> 
                                
                            <?php }?>
                        `;
                        
                    } else if(genreName === 'Punk-rock'){
                        genreTitle.textContent = 'Punk-rock';
                        genreText.textContent = 'Punk-rock is fast';
                        genreCover.src = 'staticImgs/punk.jpg';
                        genresList.innerHTML = `
                            <?php foreach($punk as $p){?>
                                <div class="sub-genre">
                                    <a class="sub-genre-link" href="genre.php?name=<?php echo $p['name'];?>">
                                        <h2><?php echo $p['name'];?></h2>
                                    </a>  
                                </div> 
                                
                            <?php }?>
                        `;
                    }

                    modal.style.display = 'flex';

                });
            });

            

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });


            
            
        

        


        
    </script>

    </script>
</body>
</html>