<?php

    include 'db.php';
    session_start();

    if(isset($_GET['id'])){
        $_SESSION['current_quiz_id'] = $_GET['id'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Quiz Playing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .load-questions{
            padding: 10px;
            background-color: #3D3D3D;
            border-radius: 20px;
            width: 600px;
            margin: 50px auto;
            padding-right: 20px;
        }

        button{
            font-family: "Metal mania", serif;
            width: 70px;
            height: 40px;
            border: none;
            border-radius: 20px;
            background-color: white;
            color: black;
            font-size: 33px;
            cursor: pointer;
        }

        .previous-btn span{
            display: inline-block;
            transform: rotate(90deg);
        }

        .next-btn span{
            display: inline-block;
            transform: rotate(-90deg);
        }

        .questions-count{
            display: flex;
            flex-direction: row;
            margin-left: 900px;
            position: absolute;
            margin-top: 90px;
            color: white;
        }

        .btns-container{
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 800px;
            position: absolute;
            margin-top: -30%;
        }

        
    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="questions-count">
        <div id="current_que">0</div>
        <div>/</div>
        <div id="total_que">0</div>
    </div>

    <div id="load_questions" class="load-questions">

    </div>

    <div class="btns-container">
        <button class="previous-btn" onclick="load_previous();">
            <span>†</span>
        </button>
        
        <button class="next-btn" onclick="load_next();">
            <span>†</span>
        </button>
    </div>
    

    <script>
        function load_total_que(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById("total_que").innerHTML=xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "load_total_que.php", true);
            xmlhttp.send(null);
        }

        var questionno = "1";
        load_questions(questionno);

        function load_questions(questionno){
            document.getElementById("current_que").innerHTML = questionno;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    if(xmlhttp.responseText=="over"){
                        <?php ?>
                            window.location = "result.php";
                        <?php ?>
                    }
                    else{
                        document.getElementById("load_questions").innerHTML=xmlhttp.responseText;
                        load_total_que();
                    }
                }
            };
            xmlhttp.open("GET", "load_questions.php?questionno=" + questionno, true);
            xmlhttp.send(null);
        }

        function load_previous(){
            if(questionno=="1"){
                load_questions(questionno);
            }
            else{
                questionno = eval(questionno) - 1;
                load_questions(questionno);
            }
        }

        function load_next(){
            questionno = eval(questionno) + 1;
            load_questions(questionno);
        }

        function checkboxClick(checkboxValue, questionno){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    
                }
            };
            xmlhttp.open("GET", "save_answer_in_session.php?questionno=" + questionno + "&value1=" + checkboxValue, true);
            xmlhttp.send(null);
        }

        document.body.addEventListener('click', function(event) {
            
            var outerDiv = event.target.closest('div[class^="answer-item"]');
            if (outerDiv) {
                var checkbox = outerDiv.querySelector('.answer-checkbox');
                if (checkbox) {
                    document.querySelectorAll('.answer-checkbox').forEach(cb => {
                        if (cb !== checkbox) {
                            cb.checked = false;
                            cb.closest('div[class^="answer-item"]').classList.remove('active');
                        }
                    });

                    checkbox.click();
                }
                if(checkbox.checked) {
                    outerDiv.classList.add('active');
                } else{
                    outerDiv.classList.remove('active');
                }
                
            }
        });

        
        
    </script>
</body>
</html>