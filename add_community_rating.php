<?php
session_start();
include 'db.php';

$artistId = $_GET['id'];
$rating_type = $_POST['rating_type'];


$query = "INSERT INTO artist_ratings (emoji_rating, artist_id, user_id)
          VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE emoji_rating = VALUES(emoji_rating)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $rating_type, $artistId, $_SESSION['user_id']);
$stmt->execute();
?>