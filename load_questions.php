<?php
include 'db.php';
session_start();


$question_no = "";
$question = "";
$ans = "";

$queno = $_GET['questionno'];

if(isset($_SESSION["answer"][$queno])){
    $ans = $_SESSION["answer"][$queno];
}

$res = mysqli_query($conn, "SELECT * FROM questions RIGHT JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $_GET[questionno]");
$count = mysqli_num_rows($res);

if($count == 0){
    echo "over";
}
else{
    while($row = mysqli_fetch_array($res)){
        $question_no = $row['question_no'];
        $question = $row['question_text'];
        $questionImg = $row['question_image'];

        
        
    }
?>

<style>
    .question{
        width: 100%;
        color: white;
    }

    .image-container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 350px;
        border: 5px solid black;
        border-radius: 10px;
        overflow: hidden;
    }

    .image-container img{
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        margin: 10px;
        width: 40%;
        cursor: pointer;
    }

    .answers > div.active{
        color: black;
        background-color: white;
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

    .answer-checkbox{
        visibility: hidden;
    }

    .answers span{
        margin-left: 5px;
    }

    


</style>

        <div class="question" id="question">
            <div class="text-container">
                <h2><?php echo $question;?></h2>
            </div>
            <div class="image-container">
                <img src="questionImgs/<?php echo $questionImg; ?>" alt="">
            </div>
            <div class="answers" id="answers">
                <?php $letter = 'A'; $index = 1; foreach($res as $r){?>
                    <div class="answer-item-<?php echo $index; ?> <?php if($ans == $r['answer_text']){ echo "active"; } ?>">
                        <div class="answer-letter"><p><?php echo $letter;?></p></div>
                        <input type="hidden" value="<?php echo $r['id_ans'];?>">
                        <span>
                            <?php echo $r['answer_text'];?>
                            <input class="answer-checkbox" type="checkbox" value="<?php echo $r['answer_text'];?>" onclick="checkboxClick(this.value, <?php echo $question_no;?>);"
                            <?php if($ans == $r['answer_text']){ echo "checked"; } ?>>
                        </span>
                    </div>
                <?php $index++; $letter = chr(ord($letter) + 1); }?>
            </div>
        </div>






<?php
}
?>
