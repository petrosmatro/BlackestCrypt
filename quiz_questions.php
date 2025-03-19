<?php

    session_start();
    include 'db.php';
    


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .main-container{
            width: 700px;
            height: 600px;
            margin: 5px auto;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
        }

        .caption-container h3{
            margin: 0;
        }

        .left-side{
            width: 25%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .bank-title{
            width: 100%;
        }

        .bank-title h3{
            color: white;
            margin: 0;
        }

        .question-bank{
            width: 100%;
            height: 70%;
            border: 3px solid #717171;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            padding: 7px;
            gap: 10px;
        }


        #add-question{
            width: 100%;
            height: 45px;
            border: 3px dashed #717171;
            color: #717171;
            background-color: #2E2E2E;
            font-size: 30px;
            border-radius: 35px;
            cursor: pointer;
        }

        .finish-btn{
            width: 100%;
            height: 45px;
            border: none;
            color: white;
            background-color: black;
            font-size: 20px;
            border-radius: 35px;
            font-family: "Metal mania", serif;
            cursor: pointer;
        }

        #question-list{
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .question-item{
            width: 100%;
            height: 45px;
            border: none;
            color: black;
            background-color: white;
            font-size: 20px;
            border-radius: 35px;
            font-family: "Metal mania", serif;
            cursor: pointer;
        }

        .question-item-wrapper {
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
        }

        .delete-question {
            width: 16px;
            height: 16px;
            background-color: red;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: -2px;
            bottom: -2px;
        }

        .right-side{
            width: 70%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .text-container{
            width: 100%;
        }

        .text-container input{
            width: 40%;
            height: 20px;
            background-color: #5B5B5B;
            border: none;
            border-radius: 10px;
            padding: 5px;
            outline: none;
        }

        .image-container{
            width: 100%;
            height: 55%;
            border: 3px solid #717171;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-container input{
            display: none;
        }

        .image-container label{
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

        .image-container label:hover{
            background-color: rgba(0, 0, 0, 0.1);

        }

        .image-container p{
            color: #717171;
        }

        .answers{
            width: 100%;
            height: 25%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .answer{
            border: 3px solid white;
            border-radius: 35px;
            padding: 10px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .answer input[type="text"]{
            background-color: #717171;
            border: none;
            border-radius: 5px;
            padding: 5px;
        }

        .answer input[type="text"]::placeholder{
            font-family: "Metal mania", serif;
            color: #9A9A9A;
        }

        .answers button{
            width: 48%;
            height: 40px;
            border: 3px dashed #717171;
            border-radius: 35px;
            color: #717171;
            font-size: 20px;
            background-color: #2E2E2E;
            cursor: pointer;
        }

        .remove-btn{
            color: white;
            cursor: pointer;
        }

        .image-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #add-answer{
            width: 100px;
            height: 40px;
            border: 3px dashed #717171;
            position: absolute;
            bottom: -160px;
            border-radius: 35px;
            color: #717171;
            font-size: 20px;
            background-color: #2E2E2E;
            cursor: pointer;
        }

        .caption-container{
            width: 100%;
            display: flex;
            justify-content: center;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="caption-container">
        <h3>Choose only 1 correct answer for each question, please...</h3>
    </div>
    
    <div class="main-container">
        <div class="left-side">
            <div class="bank-title">
                <h3>Question bank:</h3>
            </div>
            <div class="question-bank">
                <div id="question-list"></div>
                <button id="add-question">+</button>
            </div>
            <button id="finish" class="finish-btn">Finish</button>
        </div>
        <div class="right-side">
            <div class="text-container">
                <input type="text" id="question-text">
            </div>
            <div class="image-container">
                <input type="file" id="image-upload" accept="image/*">
                <label for="image-upload" id="image-upload-label">+</label>
                <p id="place-image">Here you can place image...</p>
            </div>
            <div class="answers" id="answers">
                
            </div>

            <button id="add-answer">+</button>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            let questions = [];
            let currentQuestionIndex = 0;

            let firstQuestion = { text: "", image: "", answers: [] };
            questions.push(firstQuestion);
            updateQuestionList();
            loadQuestion();

            $("#add-question").click(function() {
                let question = { text: "", image: "", answers: [] };
                questions.push(question);
                updateQuestionList();

                $(".question-bank").animate({ scrollTop: $(".question-bank")[0].scrollHeight }, 300);
            });

            function updateQuestionList() {
                $("#question-list").empty();
                questions.forEach((q, index) => {
                    let questionText = q.text.trim() ? q.text : `Question ${index + 1}`;
                    let deleteButton = index !== 0 ? `<span class="delete-question" data-index="${index}">✖</span>` : "";

                    $("#question-list").append(
                        `<div class="question-item-wrapper">
                            <button data-index="${index}" class="question-item">${questionText}</button>
                            ${deleteButton}
                        </div>`
                    );
                });

                $("#question-list").after($("#add-question"));
            }

            $(document).on("click", ".delete-question", function(event) {
                event.stopPropagation();
                let index = $(this).data("index");

                if (index !== 0) {
                    questions.splice(index, 1);
                    if (currentQuestionIndex === index) {
                        currentQuestionIndex = 0;
                    }
                    updateQuestionList();
                    loadQuestion();
                }
            });

            $(document).on("click", ".question-item", function() {
                currentQuestionIndex = $(this).data("index");
                loadQuestion();
            });

            function loadQuestion() {
                let question = questions[currentQuestionIndex];
                $("#question-text").val(question.text);
                $("#answers").empty();

                question.answers.forEach((answerObj, index) => {
                    let isChecked = answerObj.isTrue ? "checked" : "";

                    $("#answers").append(
                        `<div class="answer">
                            <input type="checkbox" class="answer-correct" data-index="${index}" ${isChecked}>
                            <input type="text" value="${answerObj.text}" class="answer-input" data-index="${index}" placeholder="Option...">
                            <span class="remove-btn" data-index="${index}">✖</span>
                        </div>`
                    );
                });

                let imageContainer = $(".image-container");
                imageContainer.find("label, p").show();

                if (question.imageData) { 
                    let img = imageContainer.find("img");

                    if (img.length) {
                        img.attr("src", question.imageData).show();
                    } else {
                        img = $("<img>").attr("src", question.imageData).addClass("preview-image");
                        imageContainer.append(img);
                    }

                    imageContainer.find("label, p").hide();
                } else {
                    imageContainer.find("img").remove();
                }

                if (question.answers.length >= 4) {
                    $("#add-answer").hide();
                } else {
                    $("#add-answer").show();
                }
            }


            $("#question-text").on("input", function() {
                if (currentQuestionIndex !== null) {
                    questions[currentQuestionIndex].text = $(this).val();
                    updateQuestionList();
                }
            });

            $("#image-upload").on("change", function(event) {
                if (currentQuestionIndex !== null) {
                    let file = event.target.files[0];

                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let img = $("<img>").attr("src", e.target.result).addClass("preview-image");

                            $(".image-container").find("label, p").hide();

                            if ($(".image-container img").length === 0) {
                                $(".image-container").append(img);
                            } else {
                                $(".image-container img").attr("src", e.target.result);
                            }

                            questions[currentQuestionIndex].imageData = e.target.result;
                            questions[currentQuestionIndex].imageFile = file;
                            questions[currentQuestionIndex].imageName = file.name;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });


            $("#add-answer").click(function() {
                if (currentQuestionIndex !== null && questions[currentQuestionIndex].answers.length < 4) {
                    questions[currentQuestionIndex].answers.push({ text: "", isTrue: false });
                    loadQuestion();
                }
            });

            $(document).on("input", ".answer-input", function() {
                let index = $(this).data("index");
                questions[currentQuestionIndex].answers[index].text = $(this).val();
            });

            $(document).on("change", ".answer-correct", function() {
                let index = $(this).data("index");
                questions[currentQuestionIndex].answers[index].isTrue = $(this).is(":checked");
            });

            $(document).on("click", ".remove-btn", function() {
                let index = $(this).data("index");
                questions[currentQuestionIndex].answers.splice(index, 1);
                loadQuestion();
            });

            $("#finish").click(function() {
                let formData = new FormData();

                let missingAnswers = [];

                questions.forEach((q, qIndex) => {
                    let hasCorrectAnswer = q.answers.some(answer => answer.isTrue);
                    if (!hasCorrectAnswer) {
                        missingAnswers.push(qIndex + 1);
                    }

                    formData.append(`questions[${qIndex}][text]`, q.text);

                    q.answers.forEach((answer, aIndex) => {
                        formData.append(`questions[${qIndex}][answers][${aIndex}][text]`, answer.text);
                        formData.append(`questions[${qIndex}][answers][${aIndex}][isTrue]`, answer.isTrue ? 1 : 0);
                    });

                    if (q.imageData) {
                        formData.append(`questions[${qIndex}][image_data]`, q.imageData);
                        formData.append(`questions[${qIndex}][image_name]`, q.imageName);
                    }
                });

                if(missingAnswers.length > 0){
                    alert("Correct answers are missing at these questions: " + missingAnswers.join(", "));
                } else {
                    $.ajax({
                        url: "save_quiz.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function() {
                            window.location.href = 'quizzes.php'
                        }
                    });
                }

                
            });


        });
    </script>
</body>
</html>