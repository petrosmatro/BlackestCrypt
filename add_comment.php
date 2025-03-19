<?php

include 'db.php';
session_start();

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$spotifyArtistId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment =  $_POST['comment'];
    
    $currentDate = date('Y-m-d');
    mysqli_query($conn, "INSERT INTO spotify_artist_comments (comment, author_id, spotify_artist_id, created_at) VALUES ('$comment', $_SESSION[user_id], '$spotifyArtistId', '$currentDate')");

}

?>