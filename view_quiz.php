<?php

    session_start();
    include 'db.php';

    $quizId = $_GET['id'];
    $quizzes = mysqli_query($conn, "SELECT * FROM quizzes JOIN users ON quizzes.author = users.id_user WHERE id_quiz = $quizId");
    $quiz = mysqli_fetch_assoc($quizzes);

    $sqlQuestions = "SELECT COUNT(questions.id_question) AS amount FROM questions WHERE id_quiz = '$quizId'";
    $queryQuestions = mysqli_query($conn, $sqlQuestions);
    $questionRows = mysqli_fetch_assoc($queryQuestions);
    $questionsAmount = $questionRows['amount'];


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

        .caption-container{
            display: flex;
            width: 100%;
            justify-content: center;
            color: white;
        }

        .overview-container{
            width: 600px;
            height: 500px;
            margin: 60px auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


        .main-container{
            width: 100%;
            height: 300px;
            background-color: #444444;
            border-radius: 20px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 30px;
        }

        .left-side{
            height: 100%;
            width: 45%;
            display: flex;
            flex-direction: column;
        }

        .user-row{
            width: 100%;
            height: 20%;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-row img{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-row h3{
            color: white;
        }

        .left-side hr{
            width: 100%;
            background-color: #2B2B2B;
        }

        .left-side p{
            color: white;
            margin: 7px 0 7px 0;
        }


        .right-side{
            height: 100%;
            width: 45%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .cover-container{
            width: 100%;
            height: 70%;
            border: 2px solid #717171;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .right-side a{
            width: 100%;
            height: 18%;
        }

        .right-side button{
            width: 100%;
            height: 100%;
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

        .desc-container{
            background-color: #3A3A3A;
            padding: 10px;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="overview-container">
        <div class="caption-container">
            <h2>Quiz Overview</h2>
        </div>
        <div class="main-container">
            <div class="left-side">
                <div class="user-row">
                    <img src="profileImgs/<?php echo $quiz['image']; ?>" alt="">
                    <h3><?php echo $quiz['username'];?></h3>
                </div>
                <hr>
                <p>Title: <strong><?php echo $quiz['quiz_name']; ?></strong></p>
                <p>Created on: <strong><?php echo $quiz['created_on']; ?></strong></p>
                <p>Questions: <strong><?php echo $questionsAmount; ?> questions</strong></p>
                <p>Description:</p>
                <div class="desc-container">
                    <p><?php echo $quiz['quiz_desc'];?></p>
                </div>
            </div>
            <div class="right-side">
                <div class="cover-container">
                    <img src="quizImgs/<?php echo $quiz['cover']; ?>" alt="">
                </div>
                <a href="play_quiz.php?id=<?php echo $quizId; ?>">
                    <button>Play Quiz</button>
                </a>
                
            </div>
        </div>
    </div>
    
</body>
</html>