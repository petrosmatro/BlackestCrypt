<?php

$conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');
session_start();

$artistId = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $description = $_POST['description'];

    mysqli_query($conn, "INSERT INTO descriptions_for_approval (desc_content, desc_author, artist_id) VALUES ('$description', $_SESSION[user_id], '$artistId')");
}


?>