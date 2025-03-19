<?php
session_start();
include 'db.php';

$spotifyArtistId = $_GET['id'];
$rating_type = $_POST['rating_type'];


$query = "INSERT INTO spotify_artist_ratings (emoji_rating, spotify_artist_id, user_id)
          VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE emoji_rating = VALUES(emoji_rating)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $rating_type, $spotifyArtistId, $_SESSION['user_id']);
$stmt->execute();
?>
