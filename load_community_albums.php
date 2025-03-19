<?php

include 'db.php';
session_start();

$artistId = $_GET['id'];

$sql = "SELECT * FROM albums WHERE artist = $artistId";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="album-card">
            <img src="albumImgs/<?php echo $row['album_cover']; ?>" alt="">
            <p class="album-name"><?php echo $row['album_name']; ?></p>
            <p class="release-date"></p>
        </div>
        <?php
    }
}





?>