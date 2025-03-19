<?php
$servername = "a058um.forpsi.com";
$username = "f187109";
$password = "p9q7P63V";
$database = "f187109";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Chyba připojení: " . mysqli_connect_error());
}


mysqli_set_charset($conn, "utf8mb4");


?>