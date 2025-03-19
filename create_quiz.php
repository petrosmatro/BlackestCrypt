<?php

    session_start();
    include 'db.php';
    if(isset($_POST['start_creating'])){
        $_SESSION['quiz_title'] = $_POST['title'];
        $_SESSION['quiz_description'] = $_POST['description'];

        $uploadDir = "quizImgs/";
        $coverName = uniqid() . "_" . basename($_FILES["quiz_cover"]["name"]);
        $targetFile = $uploadDir . $coverName;

        
        if (move_uploaded_file($_FILES["quiz_cover"]["tmp_name"], $targetFile)) {
            $_SESSION['quiz_cover_name'] = $coverName;
        }

        header('Location:quiz_questions.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Quiz Creating</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .caption-container{
            display: flex;
            width: 100%;
            justify-content: center;
            color: white;
        }

        .overview-container{
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form{
            width: 600px;
            height: 500px;
            margin: 60px auto;
        }

        .main-container{
            width: 100%;
            height: 300px;
            background-color: #444444;
            border-radius: 20px;
            display: flex;
            flex-direction: row;
            padding: 30px;
        }

        .left-side{
            height: 100%;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left-side p{
            color: white;
            margin: 0;
        }

        

        .left-side label input{
            height: 35px;
            width: 80%;
            background-color: #717171;
            border-radius: 10px;
            border: none;
            outline: none;
        }

        .right-side{
            height: 100%;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .left-side textarea{
            width: 80%;
            height: 150px;
            resize: none;
            outline: none;
            border: none;
            border-radius: 10px;
            background-color: #717171;
        }

        .cover-container{
            width: 100%;
            height: 70%;
            border: 2px dashed #717171;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .cover-container input{
            display: none;
        }

        .cover-container label{
            width: 60px;
            height: 60px;
            border: 2px solid #717171;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #717171;
            font-size: 70px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .cover-container label:hover{
            background-color: rgba(0, 0, 0, 0.1);

        }

        .cover-container p{
            color: #717171;
        }

        .right-side button{
            width: 100%;
            height: 18%;
            border: none;
            border-radius: 10px;
            background-color: white;
            cursor: pointer;
            font-family: "Metal mania", serif;
            font-size: 25px;
        }

        .cover-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


    </style>
</head>
<body>
    <?php include "header.php";?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="overview-container">
            <div class="caption-container">
                <h2>Quiz Overview</h2>
            </div>
            <div class="main-container">
                <div class="left-side">
                    <label for="title">
                        <p>Title:</p>
                        <input type="text" name="title" id="title" required>
                    </label>
                    <label for="description">
                        <p>Description:</p>
                        <textarea name="description" id="description"></textarea>
                    </label>
                </div>
                <div class="right-side">
                    <div class="cover-container">
                        <input type="file" id="quiz-cover-input" name="quiz_cover" accept="image/*" required>
                        <label for="quiz-cover-input" id="quiz-cover-label">+</label>
                        <p id="place-cover">Place a cover for quiz...</p>
                    </div>
                    <button name="start_creating">Start Creating</button>
                </div>
            </div>
        </div>
    </form>

    

    <script>
        const quizImageInput = document.getElementById('quiz-cover-input');
        const quizImageLabel = document.getElementById('quiz-cover-label');
        const placeCover = document.getElementById('place-cover');

        quizImageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    quizImageLabel.style.display = 'none';
                    placeCover.style.display = 'none';
                    quizImageInput.parentElement.appendChild(img);
                    img.style.display = 'block'; 
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    
</body>
</html>