<?php

    

    session_start();
    

    include 'db.php';

    $quizTitle = $_SESSION['quiz_title'];
    $quizDesc = $_SESSION['quiz_description'];

    $coverName = $_SESSION['quiz_cover_name'];


    $currentDate = date('Y-m-d');
    

    $quizSql = "INSERT INTO quizzes (quiz_name, quiz_desc, author, created_on, cover) VALUES ('$quizTitle', '$quizDesc', $_SESSION[user_id], '$currentDate', '$coverName')";

    if($conn->query($quizSql) === TRUE){
        $quizId = $conn->insert_id;
        foreach ($_POST['questions'] as $qIndex => $question){
            $text = $conn->real_escape_string($question['text']);

            $imageData = $question['image_data'];
            $imageName = $question['image_name'];
            
            $safeImageName = uniqid() . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $imageName);

            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)){
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);

                $imageData = base64_decode($imageData);
                $imagePath = 'questionImgs/' . $safeImageName;

                file_put_contents($imagePath, $imageData);
            }

            $questionNo = $qIndex + 1;

            $questionSql = "INSERT INTO questions (question_text, question_image, question_no, id_quiz) VALUES ('$text', '$safeImageName', $questionNo, $quizId)";

            if($conn->query($questionSql) === TRUE){
                $questionId = $conn->insert_id;

                foreach ($question['answers'] as $answer) {
                    $answerText = $conn->real_escape_string($answer['text']);
                    $isTrue = $answer['isTrue'] ? 1 : 0;
        
                    $sql = "INSERT INTO answers (answer_text, is_true, id_question) VALUES ('$answerText', $isTrue, $questionId)";
                    $conn->query($sql);
                }
            }
        }
    }

    $conn->close();
    
    exit;

?>