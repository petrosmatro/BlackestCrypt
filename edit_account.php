<?php

    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');

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


        .account-container{
            position: relative;
            width: 300px;
            height: 400px;
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

        .circle-check::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 8px;
            border: solid #1A1A1A;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "header.php";?>

    <form action="" id="editForm" method="post" enctype="multipart/form-data">
        <div class="account-container">
            <div class="profile-img-container">
                <div class="profile-img">
                    <img id="profile-img" src="profileImgs/<?php echo $image; ?>" alt="">
                    <label for="fileImg" class="edit-icon">
                        <input type="file" id="fileImg" name="edit_profile_img">
                        <span class="icon-pencil"></span>
                    </label>
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