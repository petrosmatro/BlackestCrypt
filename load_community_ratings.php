<?php

include 'db.php';
session_start();

$artistId = $_GET['id'];

$query = "SELECT emoji_rating, COUNT(*) as count FROM artist_ratings WHERE artist_id = ? GROUP BY emoji_rating";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $artistId);
$stmt->execute();
$result = $stmt->get_result();

$ratings = ['sad' => 0, 'neutral' => 0, 'happy' => 0, 'very_happy' => 0];
while ($row = $result->fetch_assoc()) {
    $ratings[$row['emoji_rating']] = $row['count'];
}

echo json_encode($ratings);

?>