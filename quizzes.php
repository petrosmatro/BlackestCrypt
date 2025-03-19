<?php

    session_start();
    include 'db.php';

    $sql = "SELECT * FROM quizzes JOIN users ON quizzes.author = users.id_user ORDER BY id_quiz DESC";
    $query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Quizzes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .href-container{
            width: 100%;
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .create-quiz-href{
            background-color: white;
            text-decoration: none;
            color: black;
            border-radius: 20px;
            padding: 10px 20px;

        }

        .quizzes-container{
            width: 800px;
            height: 200px;
            margin: 60px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .quiz{
            width: 250px;
            display: flex;
            flex-direction: column;
        }

        .quiz-cover{
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .quiz-bottom{
            width: 100%;
            height: 70px;
            background-color: #5B5B5B;
            display: flex;
        }

        .quiz-info{
            height: 100%;
            width: 60%;
            display: flex;
            align-items: center;
        }

        .quiz-info img{
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
        }

        .quiz-title{
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 5px;
        }

        .quiz-title p{
            margin: 0;
        }

        .quiz-name{
            color: white;
            font-size: 15px;
        }

        .quiz-author{
            color: #A1A1A1;
            font-size: 12px;
        }

        .quiz-href{
            width: 40%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .quiz-href a{
            text-decoration: none;
            color: black;
            background-color: white;
            padding: 5px 20px;
        }


    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="href-container">
        <a class="create-quiz-href" href="create_quiz.php">Create a Quiz</a>
    </div>

    <div class="quizzes-container">
        <?php foreach($query as $q){?>
            <div class="quiz">
                <img class="quiz-cover" src="quizImgs/<?php echo $q['cover']; ?>" alt="">
                <div class="quiz-bottom">
                    <div class="quiz-info">
                        <img src="profileImgs/<?php echo $q['image']; ?>" alt="">
                        <div class="quiz-title">
                            <p class="quiz-name"><?php echo $q['quiz_name']; ?></p>
                            <p class="quiz-author"><?php echo $q['username']; ?></p>
                        </div>
                    </div>
                    <div class="quiz-href">
                        <a href="view_quiz.php?id=<?php echo $q['id_quiz']; ?>">View</a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
    
</body>
</html>