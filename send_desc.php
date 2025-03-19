<?php

include 'db.php';
session_start();

$spotifyArtistId = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $description = $_POST['description'];

    mysqli_query($conn, "INSERT INTO spotify_descriptions_for_approval (desc_content, desc_author, spotify_artist_id) VALUES ('$description', $_SESSION[user_id], '$spotifyArtistId')");
    mysqli_query($conn, "UPDATE users SET coins = coins + 10 WHERE id_user = $_SESSION[user_id]");
}


?>