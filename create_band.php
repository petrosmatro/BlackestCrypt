<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');

$genresQuery = "SELECT * FROM genres";
$genresResult = mysqli_query($conn, $genresQuery);


if(isset($_POST['upload'])){
    $artistName = $_POST['artist_name'];

    $artistCoverSrc = $_FILES["artist_cover"]["tmp_name"];
    $artistCoverName = uniqid() . $_FILES["artist_cover"]["name"];
    $target = "artistImgs/" . $artistCoverName;
    
    move_uploaded_file($artistCoverSrc, $target);


    $sql1 = "INSERT INTO artists (artist_name, artist_image) VALUES ('$artistName', '$artistCoverName')";

    if ($conn->query($sql1) === TRUE) {
        $albums = $_POST['albums'];
        $genres = $_POST['genres'];
        $artistId = $conn->insert_id;

        foreach($albums as $albumIndex => $album){
            $albumName = $album['album_name'];

            $imageData = $album['album_image'];
            $fileName = $album['image_name'];
            
            $safeFileName = uniqid() . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $fileName);

            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)){
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);

                $imageData = base64_decode($imageData);
                $filePath = 'albumImgs/' . $safeFileName;

                file_put_contents($filePath, $imageData);
            }

            $sql2 = "INSERT INTO albums (album_name, album_cover, artist) VALUES ('$albumName', '$safeFileName', $artistId)";
            mysqli_query($conn, $sql2);
        }

        foreach($genres as $genreIndex => $genre){
            $genreId = $genre['genre_id'];

            mysqli_query($conn, "INSERT INTO artists_subgenres (id_artist, id_sub) VALUES ($artistId, $genreId)");
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
            width: 100%;
            display: flex;
            align-items: center;
        }

        .top-part .artist-cover{
            height: 130px;
            width: 130px;
            border-radius: 50%;
            margin-left: 50px;
            border: 3px solid #5B5B5B;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .artist-cover input{
            display: none;
        }

        .artist-cover label{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            border: none;
            background-color: #5B5B5B;
            font-size: 40px;
            color: white;
            cursor: pointer;
        }

        .artist-title{
            margin-left: 20px;
            display: flex;
            flex-direction: column;
        }

        .artist-title input{
            background-color: #5B5B5B;
            border: none;
            border-radius: 20px;
        }

        .artist-title h4{
            color: white;
            margin-bottom: 0;
        }

        .artist-name{
            width: 150px;
            height: 30px;
        }

        .bottom-part{
            height: 70%;
        }

        .content{
            height: 90%;
            width: 100%;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .artist-preview hr{
            width: 100%;
        }

        .album-add-btn{
            height: 180px;
            width: 100px;
            border: 2px solid #5B5B5B;
            border-radius: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .plus-container{
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            background-color: #5B5B5B;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #2E2E2E;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 20px;
        }

        .genre-modal-content{
            background-color: #2E2E2E;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .genre-modal-content h2 {
            color: white;
        }

        .genre-modal-content button {
            cursor: pointer;
        }

        .genre-list{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .genre-list button{
            color: white;
            font-family: "Metal mania", serif;
            background-color: #444444;
            padding: 10px 30px;
            border: none;
            border-radius: 30px;
        }

        .subgenre-list{
            background-color: #3A3A3A;
            border-radius: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
            margin-top: 20px;
        }

        .subgenre-list button{
            color: white;
            font-family: "Metal mania", serif;
            background-color: #4A4A4A;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
        }

        .modal-content input[type="text"] {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #5B5B5B;
            background-color: #5B5B5B;
        }

        .album-image-input-container{
            width: 100px;
            height: 100px;
            border: 2px solid #5B5B5B;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .album-image-input-container input{
            display: none;
        }

        .album-image-input-container label{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 30px;
            width: 30px;
            border-radius: 50%;
            border: none;
            background-color: #5B5B5B;
            font-size: 40px;
            color: white;
            cursor: pointer;
        }

        .album-image-input-container img{
            width: 100%;
            height: 100%;
        }

        .modal-content button {
            background-color: #5B5B5B;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-family: "Metal mania", serif;
        }

        .album-card{
            height: 180px;
            width: 100px;
            background-color: #494949;
            border-radius: 10px;
            border: 2px solid #5B5B5B;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .album-card img{
            height: 100px;
            width: 100px;
            border-radius: 10px;
            border: 2px solid #868686;
        }

        .album-card p{
            margin-bottom: 0;
            color: white;
        }

        .top-part .confirm-btn{
            border: none;
            background-color: white;
            font-family: "Metal mania", serif;
            border-radius: 25px;
            padding: 10px;
            position: relative;
            outline: none;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .top-part .confirm-btn::after{
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid white;
            border-radius: 25px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .top-part .confirm-btn:hover::after{
            opacity: 1;
        }

        .add-genre-container{
            display: flex;
            flex-direction: row;
            margin-top: 10px;
        }

        .add-genre-container h4{
            margin: 0;
        }

        .add-genre-btn{
            margin-left: 10px;
            color: white;
            height: 15px;
            width: 15px;
            background-color: #5B5B5B;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .artist-cover img{
            width: 100%;
            height: 100%;
        }

        .genres-container{
            width: 400px;
            height: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .subgenre-item{
            position: relative;
            background-color: #5B5B5B;
            padding: 0px 10px;
            border-radius: 15px;
            display: flex;
            align-items: center;
        }

        .subgenre-item span{
            color: white;
            font-size: 13px;
        }

        

        .subgenre-item button{
            font-family: "Metal mania", serif;
            border-radius: 50%;
            border: none;
            margin-left: 5px;
            cursor: pointer;
        }

        .delete-album-btn{
            margin-top: 20px;
            background-color: #E34646;
            border: none;
            border-radius: 15px;
            padding: 5px 15px;
            cursor: pointer;
            font-family: "Metal mania", serif;
            color: white;
        }

        


    </style>
</head>
<body>
    <?php include "header.php";?>


    <form action="" method="post" enctype="multipart/form-data">
        <div class="artist-preview">
            <div class="top-part">
                <div class="artist-cover">
                    <input type="file" id="artist-cover-input" name="artist_cover">
                    <label for="artist-cover-input" id="artist-cover-label">+</label>
                </div>
                <div class="artist-title">
                    <label for="artist-name">
                        <h4>Artist name</h4>
                        <input type="text" name="artist_name" id="artist-name" class="artist-name">
                    </label>
                    <div class="add-genre-container">
                        <h4>Add genre</h4>
                        <div class="add-genre-btn"><span>+</span></div>
                    </div>
                    <div id="genres-list" class="genres-container">

                    </div>
                    
                </div>
                <button class="confirm-btn" name="upload" type="submit">Confirm & Upload</button>
            </div>
            <hr>
            <div class="bottom-part">
                <div id="content" class="content">
                    <div class="album-add-btn" id="add-album-btn">
                        <div class="plus-container">
                            <h1>+</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal" id="album-modal">
        <div class="modal-content">
            <h4>Add Album</h4>
            <div class="album-image-input-container">
                <input type="file" id="album-image" accept="image/*">
                <label for="album-image" id="album-image-label">+</label>
            </div>
            
            <input type="text" id="album-name" placeholder="Album Name">
            <button id="save-album">Save</button>
        </div>
    </div>

    <div class="modal" id="genre-modal">
        <div class="genre-modal-content">
            <h2>Choose Genre</h2>
            <div class="genre-list" id="genre-list">
                <?php foreach($genresResult as $genre){?>
                    <button class="genre-btn" data-genre-id="<?php echo $genre['genre_id'];?>"><?php echo $genre['name'];?></button>
                <?php }?>
            </div>
            <div class="subgenre-list" id="subgenre-list">

            </div>
        </div>
    </div>

    
    <script>
        const addAlbumBtn = document.getElementById('add-album-btn');

        const albumImageInput = document.getElementById('album-image');
        const albumNameInput = document.getElementById('album-name');
        const albumImageLabel = document.getElementById('album-image-label');

        const modal = document.getElementById('album-modal');
        const saveAlbumBtn = document.getElementById('save-album');

        const contentDiv = document.getElementById('content');

        const artistImageInput = document.getElementById('artist-cover-input');
        const artistImageLabel = document.getElementById('artist-cover-label');
        
        let albumIndex = 0;

        artistImageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    artistImageLabel.style.display = 'none';
                    artistImageInput.parentElement.appendChild(img);
                    img.style.display = 'block'; 
                };
                reader.readAsDataURL(file);
            }
        });

        function resetModal() {
            albumImageInput.value = '';
            albumNameInput.value = '';

            albumImageLabel.style.display = 'flex';
            const existingImg = albumImageInput.parentElement.querySelector('img');
            if (existingImg) {
                existingImg.remove();
            }
        }

        addAlbumBtn.addEventListener('click', () => {
            resetModal();
            modal.style.display = 'flex';
        });

        saveAlbumBtn.addEventListener('click', () => {
            const albumName = document.getElementById('album-name').value;
            const albumImage = document.getElementById('album-image').files[0];

            if (albumName && albumImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const albumCard = document.createElement('div');
                    albumCard.classList.add('album-card');
                    albumCard.innerHTML = `
                        <img src="${e.target.result}" alt="Album Cover">
                        <p>${albumName}</p>
                        <button class="delete-album-btn">Delete</button>
                        <input type="hidden" name="albums[${albumIndex}][album_name]" value="${albumName}">
                        <input type="hidden" name="albums[${albumIndex}][album_image]" value="${e.target.result}">
                        <input type="hidden" name="albums[${albumIndex}][image_name]" value="${albumImage.name}">
                    `;

                
                    contentDiv.insertBefore(albumCard, addAlbumBtn);

                    albumIndex++;
                };

                reader.readAsDataURL(albumImage);
                modal.style.display = 'none';
            } else {
                alert('Please fill out all fields!');
            }
        });

        document.getElementById('content').addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-album-btn')) {
                e.target.parentElement.remove();
            }
        });


        

        albumImageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    

                    
                    albumImageLabel.style.display = 'none';
                    albumImageInput.parentElement.appendChild(img);
                    img.style.display = 'block'; 
                };
                reader.readAsDataURL(file);
            }
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        const addGenreBtn = document.querySelector('.add-genre-btn');
        const genreModal = document.getElementById('genre-modal');
        const genreList = document.getElementById('genre-list');
        const subgenreList = document.getElementById('subgenre-list');
        let selectedGenreId = null;
        let genreIndex = 0;

        addGenreBtn.addEventListener('click', () => {
            genreModal.style.display = 'flex';
        });

        window.addEventListener('click', (e) => {
            if (e.target === genreModal) {
                genreModal.style.display = 'none';
            }
        });

        genreList.addEventListener('click', (e) => {
            if (e.target.classList.contains('genre-btn')) {
                selectedGenreId = e.target.getAttribute('data-genre-id');
                
                fetch('get_subgenres.php?genre_id=' + selectedGenreId)
                    .then(response => response.json())
                    .then(subgenres => {
                        subgenreList.innerHTML = '';
                        subgenres.forEach(subgenre => {
                            const subgenreBtn = document.createElement('button');
                            subgenreBtn.textContent = subgenre.name;
                            subgenreBtn.setAttribute('data-subgenre-id', subgenre.id_sub);
                            subgenreList.appendChild(subgenreBtn);
                        });
                    });
            }
        });

        subgenreList.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                const subgenreId = e.target.getAttribute('data-subgenre-id');
                const subgenreName = e.target.textContent;

                const subgenreDiv = document.createElement('div');
                subgenreDiv.classList.add('subgenre-item');
                subgenreDiv.innerHTML = `
                    <span>${subgenreName}</span>
                    <button class="remove-subgenre-btn">X</button>
                    <input type="hidden" name="genres[${genreIndex}][genre_id]" value="${subgenreId}">
                `;

                const genreContainer = document.getElementById('genres-list');
                genreContainer.appendChild(subgenreDiv);

                genreIndex++;

                genreModal.style.display = 'none';
            }
        });

        document.getElementById('genres-list').addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-subgenre-btn')) {
                e.target.parentElement.remove();
            }
        });

    </script>
</body>
</html>