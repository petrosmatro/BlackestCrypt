<?php

    session_start();
    include 'db.php';
    
    $descriptions = mysqli_query($conn, "SELECT * FROM descriptions_for_approval JOIN users ON descriptions_for_approval.desc_author = users.id_user JOIN artists ON descriptions_for_approval.artist_id = artists.id_artist ORDER BY id_desc DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">
    
    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }

        .descriptions-container{
            margin: 50px auto;
            width: 600px;
            height: 600px;
            background-color: #1A1A1A;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 10px;
        }

        .description-card{
            width: 100%;
            height: 130px;
            overflow: hidden;
            border-radius: 15px;
        }

        .card-top{
            height: 65%;
            width: 100%;
            background-color: #363636;
            display: flex;
            align-items: center;
        }

        .card-top img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
        }

        .description-title{
            height: 50%;
            margin-left: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .description-title p{
            margin: 0;
        }

        .artist-name{
            color: white;
        }

        .author-name{
            color: #A1A1A1;
            font-size: 11px;
        }

        .card-bottom{
            height: 35%;
            width: 100%;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-bottom button{
            color: white;
            font-family: "Metal mania", serif;
            background-color: #242424;
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
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

        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .modal-top{
            width: 100%;
            display: flex;
            align-items: center;
        }

        .modal-top p{
            margin: 0;
        }

        .modal-top img{
            height: 70px;
            width: 70px;
            border-radius: 50%;
            object-fit: cover;
        }

        .modal-desc-title{
            margin-left: 10px;
        }

        .modal-author-name-p{
            color: #A1A1A1;
            font-size: 13px;
        }

        .modal-bottom{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .modal-bottom button{
            margin-top: 20px;
            font-family: "Metal mania", serif;
            border-radius: 20px;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        .approve-btn{
            background-color: white;
            color: black;
        }

        .modal-desc-container{
            width: 100%;
            height: 200px;
            background-color: #454545;
            padding: 10px;
            border-radius: 10px;
        }

        .modal-desc-container p{
            margin: 0;
        }

        .desc-modal form{
            width: 100%;
            height: 100%;
        }

        .notification{
            position: fixed;
            bottom: 20px;
            left: 20px;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
            transform: translateY(100%);
            background-color: #1A1A1A;
            color: white;
            padding: 5px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification.show {
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

        .caption-container{
            width: 100%;
            display: flex;
            justify-content: center;
            color: white;
            margin-top: 30px;
        }

        .caption-container h2{
            margin: 0;
        }

        .delete-btn{
            background-color: #e04350;
            color: white;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "header.php";?>

    <div class="caption-container">
        <h2>Community Descriptions for Approval</h2>
    </div>
    <div class="descriptions-container">
        <?php foreach($descriptions as $desc){?>
            <div class="description-card">
                <div class="card-top">
                    <img src="artistImgs/<?php echo $desc['artist_image']; ?>" alt="" class="artist-image">
                    <div class="description-title">
                        <input type="hidden" class="description-id" value="<?php echo $desc['id_desc'];?>">
                        <input type="hidden" class="artist-id" name="" value="<?php echo $desc['artist_id'];?>">
                        <input type="hidden" class="description-content" value="<?php echo $desc['desc_content'];?>">
                        <input type="hidden" class="description-author" value="<?php echo $desc['username'];?>">
                        <p class="artist-name"><?php echo $desc['artist_name']; ?></p>
                        <p class="author-name">By: <strong><?php echo $desc['username'];?></strong></p>
                    </div>
                </div>
                <div class="card-bottom">
                    <button class="view-button">View</button>
                </div>
            </div>
        <?php }?>

        <div class="desc-modal">
            <div class="desc-modal-content">
                <form id="descForm" action="" method="post">
                    <span id="close-modal" class="close-modal">&times;</span>
                    <input type="hidden" id="id-description" class="modal-description-id">
                    <div class="modal-top">
                        <img id="modal-artist-image" src="" alt="">
                        <div class="modal-desc-title">
                            <p class="modal-artist-name"></p>
                            <p class="modal-author-name-p">By: <strong class="modal-author-name"></strong></p>
                            
                        </div>
                    </div>
                    <div class="modal-bottom">
                        <div class="modal-desc-container">
                            <p class="modal-desc-content"></p>
                        </div>
                        <div class="modal-btns-container">
                            <button id="confirm-desc" class="approve-btn">Pin the Description to the Band</button>
                            <button id="delete-desc" type="button" class="delete-btn">Delete the Description</button>
                        </div>
                        
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <div id="notification" class="notification">
        <div class="circle-check"></div>
        <p>Description was successfully approved</p>
    </div>

    <script>
        const descriptionCards = document.querySelectorAll('.description-card');
        const descModal = document.querySelector('.desc-modal');
        const modalArtistName = document.querySelector('.modal-artist-name');
        const modalAuthorName = document.querySelector('.modal-author-name');
        const modalDescContent = document.querySelector('.modal-desc-content');
        const modalArtistImage = document.getElementById('modal-artist-image');
        const modalDescId = document.querySelector('.modal-description-id');
        const closeButton = document.querySelector('.close-modal');

        descriptionCards.forEach(card => {
            const artistId = card.querySelector('.artist-id').value;
            const imgElement = card.querySelector('.artist-image');
            const nameElement = card.querySelector('.artist-name');
            const viewButton = card.querySelector('.view-button');
            const descriptionContent = card.querySelector('.description-content').value;
            const descriptionAuthor = card.querySelector('.description-author').value;
            const descriptionId = card.querySelector('.description-id').value;

            viewButton.addEventListener('click', () => {
                modalDescId.value = descriptionId;
                modalArtistName.textContent = nameElement.textContent;
                modalAuthorName.textContent = descriptionAuthor;
                modalArtistImage.src = imgElement.src;
                modalDescContent.textContent = descriptionContent;
                descModal.style.display = 'flex';
            });
        });

        closeButton.addEventListener('click', () => {
            descModal.style.display = 'none';
        });

        
        window.addEventListener('click', (event) => {
            if (event.target === descModal) {
                descModal.style.display = 'none';
            }
        });

        $('#descForm').on('submit', function(event){
            event.preventDefault();

            var idDescription = $('#id-description').val();
            var descriptionCardToRemove;

            
            descriptionCards.forEach(card => {
                const descriptionId = card.querySelector('.description-id').value;
                if (descriptionId === idDescription) {
                    descriptionCardToRemove = card;
                }
            });

            $.ajax({
                url: 'approve_community_desc.php',
                type: 'POST',
                data: {id_description: idDescription},
                success: function(){
                    descModal.style.display = 'none';

                    if (descriptionCardToRemove) {
                        descriptionCardToRemove.remove();
                    }

                    showNotification();
                }
            });
        });

        $('#delete-desc').on('click', function(){
            var idDescription = $('#id-description').val();
            var descriptionCardToRemove;

            
            descriptionCards.forEach(card => {
                const descriptionId = card.querySelector('.description-id').value;
                if (descriptionId === idDescription) {
                    descriptionCardToRemove = card;
                }
            });

            $.ajax({
                url: 'delete_community_desc.php',
                type: 'POST',
                data: {id_description: idDescription},
                success: function(){
                    descModal.style.display = 'none';

                    if (descriptionCardToRemove) {
                        descriptionCardToRemove.remove();
                    }
                }
            });
        });

        

        function showNotification(){
            const notification = document.getElementById('notification');

            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
    </script>
</body>
</html>