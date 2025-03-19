<?php

include 'db.php';
session_start();

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$artistId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment =  $_POST['comment'];
    
    $currentDate = date('Y-m-d');
    mysqli_query($conn, "INSERT INTO artist_comments (comment, user, artist, created_at) VALUES ('$comment', $_SESSION[user_id], $artistId, '$currentDate')");

}

?>