<?php

    session_start();
    include 'db.php';

    $spotifyArtistId = $_GET['id'];

    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Band</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .artist-preview{
            width: 75%;
            height: 600px;
            margin: 60px auto;
            
        }

        .top-part{
            height: 30%;
            display: flex;
            align-items: center;
        }

        .top-part img{
            height: 130px;
            width: 130px;
            border-radius: 50%;
            margin-left: 50px;
            border: 3px solid #B9B9B9;
            object-fit: cover;
        }

        .artist-title{
            margin-left: 20px;
        }

        .artist-title h1{
            margin: 0;
            color: white;
        }

        .artist-title p{
            margin: 0;
            color: #A1A1A1;
        }

        .bottom-part{
            height: 70%;
            margin-top: 30px;
        }

        .options{
            width: 100%;
            height: 10%;
        }

        .options button{
            font-family: "Metal mania", serif;
            color: white;
            background-color: #555555;
            border-radius: 10px 10px 0 0;
            border: none;
            padding-left: 10px;
            padding-right: 10px;
            cursor: pointer;
        }

        .bottom-part hr{
            margin: 0;
        }


        .active {
            font-weight: bold;
            text-decoration: underline;
        }

        .content{
            height: 90%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .albums-list{
            width: 96%;
            height: 93%;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
        }

        .album-card{
            height: 180px;
            width: 100px;
            background-color: #494949;
            border-radius: 10px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        .album-card img{
            height: 100px;
            width: 100px;
            border-radius: 10px;
            border: 2px solid #868686;
        }

        .album-card p{
            margin-bottom: 0;
        }

        .album-name{
            color: white;
        }

        .release-date{
            color: #929292;
            font-size: 10px;
            position: absolute;
            margin-top: 165px;
        }

        .no-description{
            width: 93%;
            height: 93%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .no-description button{
            border: none;
            border-radius: 25px;
            background-color: #636363;
            color: white;
            font-family: "Metal mania", serif;
            font-size: 30px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .description{
            width: 93%;
            height: 93%;
            background-color: #5B5B5B;
            border-radius: 30px;
            color: white;
            padding-left: 25px;
            padding-right: 25px;
        }


        .album-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .album-modal-content {
            background-color: #2E2E2E;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            color: white;
            position: relative;
        }

        .desc-modal{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .desc-modal-content{
            background-color: #2E2E2E;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            color: white;
            position: relative;
        }

        .desc-header{
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .desc-content{
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .desc-content textarea{
            width: 100%;
            height: 100%;
            resize: none;
            background-color: #5B5B5B;
            border: none;
            border-radius: 10px;
            padding: 10px;
            color: white;
            font-size: 15px;
        }

        .desc-content textarea::placeholder{
            font-family: "Metal mania", serif;
        }

        .desc-btn-container{
            width: 100%;
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .desc-btn-container button{
            background-color: white;
            border: none;
            border-radius: 20px;
            font-family: "Metal mania", serif;
            font-size: 17px;
            padding: 8px 15px 8px 15px;
            cursor: pointer;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .album-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .album-header img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .album-tracks {
            max-height: 300px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .album-tracks div {
            background-color: #444;
            padding: 10px;
            border-radius: 5px;
        }

        .album-tracks div:hover {
            background-color: #555;
        }

        

        .comments-content{
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .comments-container{
            margin-top: 50px;
        }

        

        .comment-form-container{
            width: 640px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            gap: 20px;
        }

        .comment-main{
            width: 100%;
            height: 90%;
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .comment-main textarea{
            height: 100%;
            width: 100%;
            background-color: #5B5B5B;
            font-family: "Metal mania", serif;
            font-size: 15px;
            border-radius: 10px;
            border: none;
            outline: none;
            color: white;
            padding: 5px;
            resize: none;
            top: 0;
        }

        .comment-btn-container{
            width: 100%;
            height: 10%;
        }

        .comment-btn-container button{
            right: 0;
            position: absolute;
            background-color: white;
            color: black;
            font-family: "Metal mania", serif;
            border: none;
            border-radius: 15px;
            padding: 5px 20px 5px 20px;
            cursor: pointer;
        }


        

        .profile-picture{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .rating-system{
            width: 200px;
            height: 25px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 150px;
            gap: 5px;
            right: 0;
        }

        .rating-box{
            height: 100%;
            width: 25%;
            border: 2px solid white;
            border-radius: 10px;
            cursor: pointer;
        }

        .notification{
            background-color: #1A1A1A;
            color: white;
            padding: 5px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notifications{
            position: fixed;
            bottom: 20px;
            left: 20px;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
            transform: translateY(100%);
        }

        .notifications.show {
            opacity: 1;
            transform: translateY(0);
        }

        .circle-check{
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            background-color: #54c772;
            border-radius: 50%;
            position: relative;
        }

        .circle-check::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 8px;
            border: solid #1A1A1A;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            
        }

        .desc-modal-content form{
            width: 100%;
            height: 100%;
        }

        #desc-modal-button{
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "header.php";?>


    <div class="artist-preview">
        <div class="top-part">
            <img id="artist-image" src="" alt="">
            <div class="artist-title">
                <h1 id="artist-name"></h1>
                <p id="artist-genres"></p>
            </div>
            <div class="rating-system">
                <div class="rating-box" id="rating-sad" data-type="sad">😢 <span id="rating-sad-count" class="rating-count">0</span></div>
                <div class="rating-box" id="rating-neutral" data-type="neutral">😐 <span id="rating-neutral-count" class="rating-count">0</span></div>
                <div class="rating-box" id="rating-happy" data-type="happy">😊 <span id="rating-happy-count" class="rating-count">0</span></div>
                <div class="rating-box" id="rating-very-happy" data-type="very_happy">😄 <span id="rating-very_happy-count" class="rating-count">0</span></div>
            </div>
        </div>
        <div class="bottom-part">
            <div class="options">
                <button id="description" class="active">Description</button>
                <button id="discography">Discography</button>
                <button id="comments">Comments</button>
                <hr>
            </div>
            <div id="content" class="content">

            </div>
        </div>
    </div>

    <div id="album-modal" class="album-modal">
        <div class="album-modal-content">
            <span id="close-modal" class="close-modal">&times;</span>
            <div class="album-header">
                <img id="modal-album-image" src="" alt="Album cover">
                <h2 id="modal-album-title"></h2>
            </div>
            <div id="album-tracks" class="album-tracks">
                
            </div>
        </div>
    </div>

    <div id="desc-modal" class="desc-modal">
        <div class="desc-modal-content">
            <form id="descForm" method="post">
                <span id="close-genre-modal" class="close-modal">&times;</span>
                <div class="desc-header">
                    <h2>Description</h2>
                </div>
                <div class="desc-content">
                    <textarea name="description" id="desc-text" placeholder="Write your description here..."></textarea>
                </div>
                <div class="desc-btn-container">
                    <button name="desc_submit" id="desc-submit" type="submit">Submit for Approval</button>
                </div>
            </form> 
        </div>
    </div>

    <div class="notifications" id="notifications">
        <div id="notification" class="notification">
            <div class="circle-check"></div>
            <p>Description was successfully submitted for approval</p>
        </div>

        <div id="notification" class="notification">
            <div class="circle-check"></div>
            <p>You have received 10 BlackestCoins for effort</p>
        </div>
    </div>

    


    <script>

        const accessToken = <?php echo json_encode($accessToken);?>;
        

        function getArtistIdFromURL() {
            const params = new URLSearchParams(window.location.search);
            return params.get('id');
        }

        document.addEventListener('DOMContentLoaded', async () =>{
            const artistId = getArtistIdFromURL();

            const contentDiv = document.getElementById('content');

            const descriptionButton = document.getElementById('description');
            const discographyButton = document.getElementById('discography');
            const commentsButton = document.getElementById('comments');

            const artistDetails = await fetchArtistDetails(artistId);
            if(artistDetails){
                renderArtistDetails(artistDetails);
            }

            await loadDescription();

            async function loadDescription(){
                <?php 
                    $select = "SELECT * FROM spotify_artist_descriptions WHERE spotify_artist_id = '$spotifyArtistId'";
                    $result = mysqli_query($conn, $select);
                    $desc_count = mysqli_num_rows($result);

                    if($desc_count == 0){
                ?>
                    contentDiv.innerHTML = `
                        <div class="no-description">
                            <h1>There is no description yet.</h1>
                            <button id="desc-modal-button">MAKE SOME</button>
                        </div>
                    `;
                <?php } else { $desc = mysqli_fetch_assoc($result);?>
                    contentDiv.innerHTML = `
                        <div class="description">
                            <p><?php echo $desc['desc_content'];?></p>
                        </div>
                    `
                <?php }?>
            }

            const descModal = document.getElementById('desc-modal');
            const descModalButton = document.getElementById('desc-modal-button');

            if(descModalButton){
                descModalButton.addEventListener('click', function(){
                    const closeGenreModal = document.getElementById('close-genre-modal');
                    closeGenreModal.addEventListener('click', function(){
                        descModal.style.display = 'none';
                    });
                    descModal.style.display = 'flex';
                });
            }



            

            $('#descForm').on('submit', function(event){
                event.preventDefault();

                var description = $('#desc-text').val();

                $.ajax({
                    url: 'send_desc.php?id=<?php echo $spotifyArtistId;?>',
                    type: 'POST',
                    data: {description: description},
                    success: function(){
                        $('#desc-text').val('');
                        descModal.style.display = 'none';
                        showNotification();
                    }
                });
            });

            function showNotification(){
                const notification = document.getElementById('notifications');

                notification.classList.add('show');

                setTimeout(() => {
                    notification.classList.remove('show');
                }, 5000);
            }

            async function loadDiscography(){
                const albums = await fetchArtistAlbums(artistId);
                if (albums) {
                    contentDiv.innerHTML = `<div id="albums-list" class="albums-list"></div>`;
                    renderAlbums(albums.items);
                } else {
                    contentDiv.innerHTML = `<p>Chyba při načítání diskografie interpreta.</p>`;
                }
            }

            loadRatings();

            $('.rating-box').on('click', function() {
                const ratingType = $(this).data('type');
                    

                $.ajax({
                    url: 'add_rating.php?id=<?php echo $spotifyArtistId;?>',
                    type: 'POST',
                    data: {rating_type: ratingType},
                    success: function() {
                        loadRatings();
                    }
                });
            });

            function loadRatings(){
                $.ajax({
                    url: 'load_ratings.php?id=<?php echo $spotifyArtistId;?>',
                    type: 'GET',
                    success: function(response) {
                        const ratings = JSON.parse(response);
                        ['sad', 'neutral', 'happy', 'very_happy'].forEach(type => {
                            $(`#rating-${type}-count`).text(ratings[type]);
                        });
                    }
                });
            }

            async function loadCommentsContent(){
                contentDiv.innerHTML = `
                    <div class="comments-content">
                        <form id="commentForm" class="comment-form" method="post">
                            <div class="comment-form-container">
                                <div class="comment-main">
                                    <img src="profileImgs/<?php echo $image?>" alt="Profile Picture" class="profile-picture">
                                    <textarea id="comment" name="comment" placeholder="Write your comment..." required></textarea>
                                </div>
                                <div class="comment-btn-container">
                                    <button name="post_comment" type="submit">Post</button> 
                                </div>                            
                            </div>
                        </form>
                        <div id="comments-list" class="comments-container">
                            
                        </div>
                    </div>
                `;

                
                loadComments();

                $('#commentForm').on('submit', function(event) {
                    event.preventDefault();

                    var comment = $('#comment').val();

                    $.ajax({
                        url: 'add_comment.php?id=<?php echo $spotifyArtistId;?>',
                        type: 'POST',
                        data: {comment: comment},
                        success: function() {
                            loadComments();
                            $('#comment').val('');
                        }
                    });
                });

                function loadComments() {
                    $.ajax({
                        url: 'load_comments.php?id=<?php echo $spotifyArtistId;?>',
                        type: 'GET',
                        success: function(response) {
                            $('#comments-list').html(response);
                        }
                    });
                }

                

                
            }

                

            function activateButton(button) {
                document.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            }

            descriptionButton.addEventListener('click', async () => {
                activateButton(descriptionButton);
                await loadDescription();
            });

            discographyButton.addEventListener('click', async () => {
                activateButton(discographyButton);
                await loadDiscography();
            });

            commentsButton.addEventListener('click', async () => {
                activateButton(commentsButton);
                await loadCommentsContent();
            });

            
        });


        async function fetchArtistDetails(artistId) {

            if (!accessToken) {
                console.error('Access token není dostupný.');
                return;
            }

            const url = `https://api.spotify.com/v1/artists/${artistId}`;
            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });

                if (!response.ok) {
                    throw new Error(`Chyba při načítání interpreta (${response.status}): ${response.statusText}`);
                }

                return await response.json();
            } catch (error) {
                console.error('Chyba při načítání detailů interpreta:', error);
            }
        }

        function renderArtistDetails(artist){
            document.getElementById('artist-name').textContent = artist.name;
            document.getElementById('artist-image').src = artist.images[0]?.url || 'placeholder.jpg';
            document.getElementById('artist-genres').textContent = artist.genres.slice(0, 2).join(', ');
        }

        const albumModal = document.getElementById('album-modal');
        const closeModal = document.getElementById('close-modal');
        const modalAlbumImage = document.getElementById('modal-album-image');
        const modalAlbumTitle = document.getElementById('modal-album-title');
        const albumTracks = document.getElementById('album-tracks');

        async function fetchArtistAlbums(artistId) {

            if (!accessToken) {
                console.error('Access token není dostupný.');
                return;
            }

            const url = `https://api.spotify.com/v1/artists/${artistId}/albums`;
            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });

                if (!response.ok) {
                    throw new Error(`Chyba při načítání alb (${response.status}): ${response.statusText}`);
                }

                return await response.json();
            } catch (error) {
                console.error('Chyba při načítání diskografie:', error);
            }
        }

        function renderAlbums(albums) {
            const albumsList = document.getElementById('albums-list');
            albumsList.innerHTML = '';

            albums.forEach(album => {
                const maxLength = 25;
                let albumName = album.name;
                if (albumName.length > maxLength) {
                    albumName = albumName.substring(0, maxLength) + '...';
                }

                const albumItem = document.createElement('div');
                albumItem.className = 'album-card';
                albumItem.innerHTML = `
                    <img src="${album.images[0]?.url || 'placeholder.jpg'}" alt="${album.name}">
                    <p class="album-name">${albumName}</p>
                    <p class="release-date">Released on: ${album.release_date}</p>
                `;

                albumItem.addEventListener('click', () => {
                    showAlbumTracks(album.id, album.name, album.images[0]?.url || 'placeholder.jpg');
                });

                albumsList.appendChild(albumItem);
            });
        }

        async function fetchAlbumTracks(albumId) {

            if (!accessToken) {
                console.error('Access token není dostupný.');
                return [];
            }

            try {
                const response = await fetch(`https://api.spotify.com/v1/albums/${albumId}/tracks`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                });

                if (!response.ok) {
                    console.error('Chyba při načítání skladeb:', response.status);
                    return [];
                }

                const data = await response.json();
                return data.items;
            } catch (error) {
                console.error('Chyba:', error);
                return [];
            }
        }


        async function showAlbumTracks(albumId, albumName, albumImageUrl) {
            modalAlbumTitle.textContent = albumName;
            modalAlbumImage.src = albumImageUrl;

            const tracks = await fetchAlbumTracks(albumId);

            albumTracks.innerHTML = ''; 

            if (tracks.length === 0) {
                albumTracks.innerHTML = `<p>Žádné skladby nenalezeny.</p>`;
                return;
            }

            tracks.forEach(track => {
                const trackElement = document.createElement('div');
                trackElement.textContent = track.name;
                albumTracks.appendChild(trackElement);
            });

            albumModal.style.display = 'flex'; 
        }

        albumModal.addEventListener('click', (e) =>{
            if (e.target === closeModal) {
                albumModal.style.display = 'none';
            }
        });

        

        



        
    </script>
</body>
</html>