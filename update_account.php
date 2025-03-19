<?php

    session_start();
    include 'db.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
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