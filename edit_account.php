<?php

    session_start();
    include 'db.php';

    if(isset($_POST['save_changes'])){
        $newUsername = mysqli_real_escape_string($conn, $_POST['edit_username']);

        $select = "SELECT * FROM users WHERE username = '$newUsername'";
        $result = mysqli_query($conn, $select);
        $user_count = mysqli_num_rows($result);

        if($user_count == 0){
            $updateUser = "UPDATE users SET username = '$newUsername' WHERE id_user = '$_SESSION[user_id]'";
            mysqli_query($conn, $updateUser);
            $successmsg = "Changes have been saved successfully.";
        } else{
            $errormsg = "This username is already in use";
        }

        if(!empty($_FILES["edit_profile_img"]["name"])){
            $src = $_FILES["edit_profile_img"]["tmp_name"];
            $imageName = uniqid() . $_FILES["edit_profile_img"]["name"];
            $target = "profileImgs/" . $imageName;
    
            move_uploaded_file($src, $target);
    
            $updateImg = "UPDATE users SET image = '$imageName' WHERE id_user = '$_SESSION[user_id]'";
            mysqli_query($conn, $updateImg);
            $successmsg = "Changes have been saved successfully.";
        }

        if(!empty($_POST['edit_password'])){
            $newPassword = md5($_POST['edit_password']);
            $cpassword = md5($_POST['cpassword']);

            if($newPassword == $cpassword){
                $updatePassword = "UPDATE users SET password = '$newPassword' WHERE id_user = '$_SESSION[user_id]'";
                mysqli_query($conn, $updatePassword);
                $successmsg = "Changes have been saved successfully";
            } else{
                $errormsg2 = "Passwords are not matching";
            }
        }


    }

    $badgesSql = "SELECT * FROM badges LEFT JOIN users_badges ON badges.id_badge = users_badges.badge AND users_badges.user = '$_SESSION[user_id]' WHERE users_badges.badge IS NULL";
    $badges = mysqli_query($conn, $badgesSql);

    $myBadgesSql = "SELECT * FROM users_badges JOIN badges ON users_badges.badge = badges.id_badge WHERE user = '$_SESSION[user_id]'";
    $myBadges = mysqli_query($conn, $myBadgesSql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&display=swap" rel="stylesheet">

    <style>
        body{
            margin: 0;
            font-family: "Metal mania", serif;
            background-color: #2E2E2E;
        }


        .account-container{
            position: relative;
            width: 300px;
            height: 500px;
            margin: 50px auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #5B5B5B;
            border-radius: 20px;
            color: white;
        }

        .profile-img-container{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .change-label{
            width: 100%;
        }

        .change-label p{
            margin-bottom: 7px;
        }

        .change-label input{
            background-color: #5B5B5B;
            height: 40px;
            border: none;
            border-radius: 20px;
            font-family: "Metal mania", serif;
            color: white;
            outline: none;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .account-container button{
            background-color: white;
            color: black;
            font-family: "Metal mania", serif;
            border: none;
            border-radius: 20px;
            padding: 10px 30px 10px 30px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .profile-img{
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile-img img{
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .edit-icon{
            position: absolute;
            bottom: -3px;
            right: -3px;
            width: 25px;
            height: 25px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            border: 5px solid #2E2E2E;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .edit-icon input[type="file"]{
            display: none;
        }

        .edit-icon .icon-pencil::before {
            content: "\270E";
            font-size: 16px;
        }

        .notification{
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #1A1A1A;
            color: white;
            padding: 5px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
            transform: translateY(100%);
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

        .circle-check::before{
            content: '';
            position: absolute;
            width: 4px;
            height: 8px;
            border: solid #1A1A1A;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            
        }

        .coins-count{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 5px;
        }

        .coins-count img{
            width: 30px;
            height: 30px;
        }

        .coins-count span{
            color: white;
            font-size: 20px;
        }

        .cart-icon{
            width: 25px;
            height: 25px;
            margin-left: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }

        .modal{
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content{
            background-color: #2E2E2E;
            padding: 20px;
            margin: 10% auto;
            width: 50%;
            border-radius: 5px;
        }

        .badge-modal{
            display: none;
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .badge-modal-content{
            background-color: #2E2E2E;
            padding: 10px;
            margin: 10% auto;
            width: 30%;
            height: 200px;
            border-radius: 5px;
            color: white;
        }

        .badge-modal-content form{
            width: 100%;
            height: 100%;
        }

        .close{
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .close-2{
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .badges-list{
            width: 100%;
            height: 300px;
            display: flex;
            flex-wrap: wrap;
            background-color: #5B5B5B;
            padding: 10px;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .badge{
            height: 100px;
            width: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .my-badge{
            height: 100px;
            width: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .badge:hover{
            background-color: #6B6B6B;
        }

        .badge-img{
            height: 50px;
            width: 50px;
            object-fit: cover;
        }

        .my-badge img{
            height: 70px;
            width: 70px;
            object-fit: cover;
        }

        .my-badge span{
            color: white;
            font-size: 12px;
        }

        .badge-price{
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .badge-price img{
            width: 20px;
            height: 20px;
            border-radius: 50%;
            object-fit: cover;
        }

        .badge-price span{
            color: white;
        }
        
        .modal-top{
            width: 100%;
            height: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .modal-top #modal-badge-image{
            height: 100px;
            width: 100px;
            object-fit: cover;
        }

        .modal-coin{
            width: 20px;
            height: 20px;
        }

        .modal-badge-info{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modal-badge-info h2{
            margin: 0;
        }

        .price-container{
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .modal-bottom{
            width: 100%;
            height: 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-bottom button{
            height: 100%;
            width: 45%;
            color: white;
            font-family: "Metal mania", serif;
            cursor: pointer;
        }

        .cancel-badge{
            border: 1px solid white;
            background-color: #2E2E2E;
            border-radius: 5px;
        }

        .proceed-badge{
            border: none;
            border-radius: 5px;
            background-color: #007bff;
        }

        .cross{
            height: 25px;
            width: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-color: #007bff;
            border-radius: 50%;
            cursor: pointer;
        }

        .cross .vertical{
            height: 70%;
            width: 2px;
            background-color: white;
            position: absolute;
        }

        .cross .horizontal{
            width: 35%;
            height: 2px;
            background-color: white;
            position: absolute;
            bottom: 8px;
        }

        .modal-content{
            color: white;
        }

        .my-badges-caption{
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .shop-caption-container{
            width: 100%;
            display: flex;
            justify-content: center;
            color: white;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include "header.php";?>

    <form action="" id="editForm" method="post" enctype="multipart/form-data">
        <div class="account-container">
            <div class="profile-img-container">
                <div class="profile-img">
                    <img id="profile-img" src="profileImgs/<?php echo $image; ?>" alt="">
                    <label for="fileImg" class="edit-icon">
                        <input type="file" id="fileImg" name="edit_profile_img" accept="image/*">
                        <span class="icon-pencil"></span>
                    </label>
                </div>
            </div>

            <div class="coins-count">
                <img src="staticImgs/coin.png" alt="">
                <span><?php echo $user['coins'];?></span>
                <div id="buyBadges" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <div class="cross">
                        <div class="vertical"></div>
                        <div class="horizontal"></div>
                    </div>
                </div>
            </div>
            
            <label class="change-label" for="username">
                <p>Username:</p>
                <input type="text" id="username" name="edit_username" value="<?php echo $username; ?>">
            </label>

            <label class="change-label" for="password">
                <p>Password:</p>
                <input type="password" id="password" name="edit_password">
            </label>

            <label class="change-label" for="cpassword">
                <p>Confirm Password:</p>
                <input type="password" id="cpassword" name="cpassword">
            </label>

            <button type="submit" name="save_changes">Save Changes</button>
        </div>
    </form>

    <div id="notification" class="notification">
        <div class="circle-check"></div>
        <p>Changes have been saved successfully</p>
    </div>

    <div id="myBadgesModal" class="modal">
        <div class="modal-content">
            <span class="close-2">&times;</span>
            <div class="my-badges-caption">
                <h2>My Badges</h2>
            </div>
            <div class="badges-list">
                <?php foreach($myBadges as $myBadge){?>
                    <div class="my-badge">
                        <img class="badge-image" src="badges/<?php echo $myBadge['badge_image'];?>" alt="">
                        <span><?php echo $myBadge['badge_name'];?></span>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>

    <div id="badgesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="shop-caption-container">
                <h2>Badges Shop</h2>
            </div>
            <div class="badges-list">
                <?php foreach($badges as $badge){?>
                    <div class="badge">
                        <input type="hidden" class="badge-id" value="<?php echo $badge['id_badge']; ?>">
                        <input type="hidden" class="badge-image" value="<?php echo $badge['badge_image']; ?>">
                        <input type="hidden" class="badge-name" value="<?php echo $badge['badge_name']; ?>">
                        <input type="hidden" class="hidden-price" value="<?php echo $badge['price']; ?>">
                        <img class="badge-img" src="badges/<?php echo $badge['badge_image'];?>" alt="">
                        <div class="badge-price">
                            <img src="staticImgs/coin.png" alt="">
                            <span><?php echo $badge['price']; ?></span>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>

    <div id="badgeModal" class="badge-modal">
        <div class="badge-modal-content">
            <form id="badgeForm" action="" method="post">
                <input type="hidden" id="id-badge" class="modal-badge-id">
                <div class="modal-top">
                    <img id="modal-badge-image" src="" alt="">
                    <div class="modal-badge-info">
                        <h2 class="modal-badge-name"></h2>
                        <div class="price-container">
                            <img class="modal-coin" src="staticImgs/coin.png" alt="">
                            <span class="modal-badge-price"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-bottom">
                    <button class="cancel-badge" type="button">Cancel</button>
                    <button class="proceed-badge" type="submit">Proceed</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileImg');
        const profileImg = document.getElementById('profile-img');

        fileInput.addEventListener('change', function(event){
            const file = event.target.files[0];

            if(file){
                const reader = new FileReader();

                reader.onload = function(e){
                    profileImg.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

        $('#editForm').on('submit', function(event){
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'update_account.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(){
                    showNotification();
                }
            });
        });

        const badgeModal = document.querySelector('.badge-modal');
        const badges = document.querySelectorAll('.badge');
        const modalBadgeName = document.querySelector('.modal-badge-name');
        const modalBadgeImage = document.getElementById('modal-badge-image');
        const modalBadgeId = document.querySelector('.modal-badge-id');
        const modalBadgePrice = document.querySelector('.modal-badge-price');

        badges.forEach(badge => {
            const badgeId = badge.querySelector('.badge-id').value;
            const badgeImage = badge.querySelector('.badge-image').value;
            const badgeName = badge.querySelector('.badge-name').value;
            const badgePrice = badge.querySelector('.hidden-price').value;

            badge.addEventListener('click', () => {
                modalBadgeName.textContent = badgeName;
                modalBadgeImage.src = `badges/${badgeImage}`;
                modalBadgeId.value = badgeId;
                modalBadgePrice.textContent = badgePrice;

                badgeModal.style.display = 'block';
            });
        });

        $('#badgeForm').on('submit', function(event){
            event.preventDefault();

            var idBadge = $('#id-badge').val();

            $.ajax({
                url: 'buy_badge.php',
                type: 'POST',
                data: {id_badge: idBadge},
                success: function(){
                    badgeModal.style.display = 'none';
                }
            });
        });

        document.querySelector('.cancel-badge').addEventListener('click', function (){
            badgeModal.style.display = 'none';
        });

        document.getElementById('buyBadges').addEventListener('click', function (){
            document.getElementById('badgesModal').style.display = 'block';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('badgesModal').style.display = "none";
        });

        document.querySelector('.cross').addEventListener('click', function() {
            document.getElementById('myBadgesModal').style.display = 'block';
        });

        document.querySelector('.close-2').addEventListener('click', function() {
            document.getElementById('myBadgesModal').style.display = "none";
        });

        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('badgesModal')) {
                document.getElementById('badgesModal').style.display = "none";
            }
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