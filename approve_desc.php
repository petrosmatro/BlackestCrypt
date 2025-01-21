<?php

    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');

    $desc_id = $_POST['id_description'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $select = "SELECT * FROM spotify_descriptions_for_approval WHERE id_desc = $desc_id";
        $result = mysqli_query($conn, $select);
        $desc = mysqli_fetch_assoc($result);

        $desc_content = $desc['desc_content'];
        $desc_author = $desc['desc_author'];
        $spotify_artist_id = $desc['spotify_artist_id'];

        $insert = "INSERT INTO spotify_artist_descriptions (desc_content, desc_author, spotify_artist_id) VALUES ('$desc_content', $desc_author, '$spotify_artist_id')";

        if($conn->query($insert) === TRUE){
            mysqli_query($conn, "DELETE FROM spotify_descriptions_for_approval WHERE id_desc = $desc_id");
        }
    }



?>