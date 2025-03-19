<?php
session_start();
include 'db.php';

$desc_id = $_POST['id_description'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $select = "SELECT * FROM descriptions_for_approval WHERE id_desc = $desc_id";
    $result = mysqli_query($conn, $select);
    $desc = mysqli_fetch_assoc($result);

    $desc_content = $desc['desc_content'];
    $desc_author = $desc['desc_author'];
    $artist_id = $desc['artist_id'];

    $insert = "INSERT INTO artist_descriptions (desc_content, desc_author, artist_id) VALUES ('$desc_content', $desc_author, '$artist_id')";

    if($conn->query($insert) === TRUE){
        mysqli_query($conn, "DELETE FROM descriptions_for_approval WHERE id_desc = $desc_id");
    }
}
?>