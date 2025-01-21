<style>
    .comment-container {
    background-color: #5B5B5B;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 600px;
    margin: 10px 0;
}

.btn-container{
    width: 100%;
    display: flex;
    justify-content: flex-end;
}

.btn-container button{
    background-color: red;
    border: none;
    border-radius: 20px;
    width: 80px;
    height: 30px;
    color: white;
}



.comment-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}

.comment-author-info {
    display: flex;
    flex-direction: column;
}

.comment-author {
    font-weight: bold;
    color: white;
}

.comment-date {
    color: #888;
    font-size: 0.9em;
}

.comment-body {
    margin-bottom: 10px;
    color: white;
}

.comment-body p {
    margin: 0;
    line-height: 1.5;
}

.no-comments{
    color: white;
}

</style>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');
session_start();

$spotifyArtistId = $_GET['id'];

$sql = "SELECT * FROM spotify_artist_comments JOIN users ON spotify_artist_comments.author_id = users.id_user WHERE spotify_artist_id = '$spotifyArtistId' ORDER BY id_com DESC";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="comment-container" id="comment-<?php echo $row['id_com'];?>">
            <div class="comment-header">
                <img src="profileimgs/<?php echo $row['image'];?>" alt="Profilový obrázek" class="profile-pic">
                <div class="comment-author-info">
                    <span class="comment-author"><?php echo $row['username'];?></span>
                    <span class="comment-date"><?php echo $row['created_at'];?></span>
                </div>
            </div>
            <div class="comment-body">
                <p><?php echo $row['comment'];?></p>
            </div>
        </div>
        <?php
    }
} else {
    echo "<span class='no-comments'>No comments here.</span>";
}


?>