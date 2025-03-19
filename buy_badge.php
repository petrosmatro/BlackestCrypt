<?php

session_start();
include 'db.php';

$badgeId = $_POST['id_badge'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sqlBadge = "SELECT * FROM badges WHERE id_badge = $badgeId";
    $badges = mysqli_query($conn, $sqlBadge);
    $badge = mysqli_fetch_assoc($badges);
    $price = $badge['price'];

    $users = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $_SESSION[user_id]");
    $user = mysqli_fetch_assoc($users);
    $budget = $user['coins'];

    if($price < $budget){
        mysqli_query($conn, "UPDATE users SET coins = coins - $price WHERE id_user = $_SESSION[user_id]");
        mysqli_query($conn, "INSERT INTO users_badges (user, badge) VALUES ('$_SESSION[user_id]', $badgeId)");
    }
    
}

?>