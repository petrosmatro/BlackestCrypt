<?php
    include 'db.php';
    session_start();

    $correct = 0;
    $wrong = 0;

    if(isset($_SESSION['answer'])){
        for($i = 1; $i <= sizeof($_SESSION['answer']); $i++){
            $answer = "";
            $res = mysqli_query($conn, "SELECT * FROM questions JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i && is_true = 1");
            while($row = mysqli_fetch_array($res)){
                $answer = $row['answer_text'];
            }
    
            if(isset($_SESSION['answer'][$i])){
                if($answer == $_SESSION['answer'][$i]){
                    $correct = $correct + 1;
                }
                else{
                    $wrong = $wrong + 1;
                }
            }
            else{
                $wrong = $wrong + 1;
            }
        }
    
    }

    $count = 0;
    $res = mysqli_query($conn, "SELECT * FROM questions WHERE id_quiz = $_SESSION[current_quiz_id]");
    $count = mysqli_num_rows($res);
    $wrong = $count - $correct;
    $accuracy = 100 / $count * $correct;

    if($correct > 0){
        $coins = $correct * 10;
        mysqli_query($conn, "UPDATE users SET coins = coins + $coins WHERE id_user = $_SESSION[user_id]");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Quiz Result</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .cards-wrap{
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 30px;
        }

        .correct-card{
            width: 100px;
            height: 210px;
            background-color: #54c772;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;
        }

        .wrong-card{
            width: 100px;
            height: 210px;
            background-color: #c54f5d;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;
        }

        .correct-symbol{
            width: 20px;
            height: 40px;
            border-bottom: 8px solid #2E2E2E;
            border-right: 8px solid #2E2E2E;
            transform: rotate(45deg);
        }

        .wrong-symbol{
            width: 50px;
            height: 50px;
            position: relative;
        }

        .wrong-symbol::before, .wrong-symbol::after{
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 8px;
            background-color: #2E2E2E;
        }

        .wrong-symbol::before{
            transform: rotate(45deg);
        }

        .wrong-symbol::after{
            transform: rotate(-45deg);
        }

        .cards-wrap p{
            font-size: 80px;
            margin: 0;
            margin-top: 30px;
        }

        .loading-bar-container{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .loading-bar-container h2{
            color: white;
        }

        .loading-container {
            width: 100px;
            height: 100px;
            background-color: #1F1F1F;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading-bar {
            width: 100%;
            height: 0;
            background-color: white;
            position: absolute;
            bottom: 0;
            transition: height 2s ease-in-out;
        }

        .loading-text-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            font-weight: bold;
            text-align: center;
            color: white;
        }

        .loading-text {
            position: absolute;
            
        }

        .black-text {
            color: black;
            clip-path: inset(100% 0 0 0);
            transition: clip-path 2.1689s ease-in-out;
        }

        .btn-container{
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .show-btn{
            width: 500px;
            height: 50px;
            color: white;
            font-family: "Metal mania", serif;
            font-size: 15px;
            background-color: #1F1F1F;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        .questions{
            width: 60%;
            margin: 50px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .question{
            width: 40%;
            color: white;
        }

        .image-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 200px;
            border: 5px solid black;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }

        .answers {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: center;
            align-items: center;
        }

        .answers > div{
            display: flex;
            flex-direction: row;
            align-items: center;
            border-radius: 20px;
            border: 2px solid black;
            padding: 5px;
            margin: 5px;
            width: 40%;
            height: 20px;
        }

        .answer-letter{
            color: white;
            width: 25px;
            height: 25px;
            background-color: black;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .answers .wrong-symbol{
            width: 15px;
            height: 15px;
            margin-left: 10px;
        }

        .answers .wrong-symbol::before, .answers .wrong-symbol::after{
            height: 4px;
            background-color: #c54f5d;
        }

        .answers .correct-symbol{
            width: 5px;
            height: 10px;
            border-width: 4px;
            border-color: #54c772;
            margin-left: 15px;
        }

        .coins-container{
            height: 210px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .coins-container img{
            width: 80px;
            height: 80px;
        }

        .coins-container span{
            color: white;
        }
    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="loading-bar-container">
        <h2>Accuracy</h2>
        <div class="loading-container">
            <div class="loading-bar"></div>
            <div class="loading-text-wrapper">
                <span class="loading-text white-text">0%</span>
                <span class="loading-text black-text">0%</span>
            </div>
            
        </div>
    </div>

    <div class="cards-wrap">
        <div class="correct-card">
            <div class="correct-symbol"></div>
            <p><?php echo $correct; ?></p>
        </div>
        <div class="coins-container">
            <img src="staticImgs/coin.png" alt="">
            <span>+<?php echo $coins; ?> coins</span>
        </div>
        <div class="wrong-card">
            <div class="wrong-symbol"></div>
            <p><?php echo $wrong; ?></p>
        </div>
    </div>

    <div class="btn-container">
        <button class="show-btn" id="showBtn">Wrong Answers</button>
    </div>

    <div class="questions">
        <?php
            for($i = 1; $i <= sizeof($_SESSION['answer']); $i++){
                $answer = "";
                $res = mysqli_query($conn, "SELECT * FROM questions JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i && is_true = 1");

                while($row = mysqli_fetch_array($res)){
                    $answer = $row['answer_text'];
                    $question = $row['question_text'];
                    $questionImg = $row['question_image'];
                }

                if(!isset($_SESSION['answer'][$i]) || $answer != $_SESSION['answer'][$i]){
                    $res = mysqli_query($conn, "SELECT * FROM questions RIGHT JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i")
                    ?>
                    <div class="question">
                        <div class="text-container">
                            <h2><?php echo $question;?></h2>
                        </div>
                        <div class="image-container">
                            <img src="questionImgs/<?php echo $questionImg; ?>" alt="">
                        </div>

                        <div class="answers">
                            <?php $letter = 'A'; $index = 1; foreach($res as $r){?>
                                <div class="answer-item-<?php echo $index?>">
                                    <div class="answer-letter">
                                        <?php echo $letter;?>
                                    </div>
                                    <input type="hidden" value="<?php echo $r['id_ans']?>">
                                    <span>
                                        <?php echo $r['answer_text'];?>
                                    </span>
                                    <?php if($r['answer_text'] == $_SESSION['answer'][$i]){ echo "<div class='wrong-symbol'></div>"; } elseif ($r['answer_text'] == $answer){ echo "<div class='correct-symbol'></div>"; }?>
                                </div>
                            <?php $index++; $letter = chr(ord($letter) + 1); }?>
                        </div>

                    </div>
                <?php
                }
                
            }
            ?>
        
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let maxValue = <?php echo $accuracy; ?>;
            let loadingBar = document.querySelector(".loading-bar");
            let loadingTextWhite = document.querySelector(".white-text");
            let loadingTextBlack = document.querySelector(".black-text");

            setTimeout(() => {
                loadingBar.style.height = maxValue + "%";
                loadingTextBlack.style.clipPath = `inset(${100 - maxValue}% 0 0 0)`;
            }, 10);

            let counter = 0;
            let interval = setInterval(() => {
                loadingTextWhite.innerText = counter + "%";
                loadingTextBlack.innerText = counter + "%";

                if (counter >= maxValue) {
                    clearInterval(interval);
                } else {
                    counter++;
                }
            }, 30);
        });

        document.querySelector('.questions').style.display = 'none';
        let isToggled = false;
        document.getElementById('showBtn').addEventListener('click', function(){
            if(isToggled){
                document.querySelector('.questions').style.display = 'none';
            } else{
                document.querySelector('.questions').style.display = 'flex';
            }

            isToggled = !isToggled;
        });

        window.addEventListener('unload', function (){
            <?php
                unset($_SESSION['answer']);
                unset($_SESSION['current_quiz_id']);
            
            ?>
        });
    </script>
</body>
</html>