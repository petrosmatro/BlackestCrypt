<?php
include 'db.php';
session_start();


$sql = "SELECT * FROM spotify_descriptions_for_approval JOIN users ON spotify_descriptions_for_approval.desc_author = users.id_user";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="description-card">
                <div class="card-top">
                    <img src="" alt="" class="artist-image">
                    <div class="description-title">
                        <input type="hidden" class="description-id" value="<?php echo $row['id_desc'];?>">
                        <input type="hidden" class="spotify-id" name="" value="<?php echo $row['spotify_artist_id'];?>">
                        <input type="hidden" class="description-content" value="<?php echo $row['desc_content'];?>">
                        <input type="hidden" class="description-author" value="<?php echo $row['username'];?>">
                        <p class="artist-name"></p>
                        <p class="author-name">By: <strong><?php echo $row['username'];?></strong></p>
                    </div>
                </div>
                <div class="card-bottom">
                    <button class="view-button">View</button>
                </div>
            </div>
        <?php
    }
}


?>