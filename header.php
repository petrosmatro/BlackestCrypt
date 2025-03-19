<header>
    <?php
        if(isset($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
            $accessToken = $_SESSION['spotify_access_token'];
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id_user = $userId"));
            $username = $user['username'];
            $image = $user['image'];
            $user_type = $user['user_type'];
            $userBadges = mysqli_query($conn, "SELECT * FROM users_badges JOIN badges ON users_badges.badge = badges.id_badge WHERE user = '$_SESSION[user_id]'");
    ?>
    <div class="nav-items">
        <a href="bands.php">Bands</a>
        <a href="genres.php">Genres</a>
        <div class="logo-container">
            <a href="main.php" class="logo-a">
                <img src="staticImgs/logo.png" alt="">
            </a>   
        </div>
        <a href="quizzes.php">Quizzes</a>
        <a href="about_us.php">About Us</a>
    </div>
    
        <div id="user-info" class="user-items" onclick="toggleMenu();">
            <img id="user-image" src="profileImgs/<?php echo $image; ?>" alt="">
            <div class="username-badges">
                <span id="user-name"><?php echo $username; ?></span>
                <div class="badges">
                    <?php foreach($userBadges as $ub){?>
                        <img src="badges/<?php echo $ub['badge_image'];?>" alt="">
                    <?php }?>
                </div>
                
            </div>
        </div>
    
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <a href="edit_account.php" class="sub-menu-link">
                    <p>Edit Account</p>
                    <span>></span>
                </a>
                <?php if($user_type == 'admin'){?>
                    <a href="descriptions_for_approval.php" class="sub-menu-link">
                        <p>Spotify Descriptions for Approval</p>
                        <span>></span>
                    </a>
                    <a href="community_descriptions_for_approval.php" class="sub-menu-link">
                        <p>Community Descriptions for Approval</p>
                        <span>></span>
                    </a>
                <?php }?>
                <a href="logout.php" class="sub-menu-link">
                    <p>Logout</p>
                    <span>></span>
                </a>
            </div>
        </div>
    <?php } else{?>
        <div class="not-logged-info">
            <h3>You must be logged in to access this page content.</h3>
        </div>
        <a href="login.php" id="login-button" class="login-btn">Log In</a>
    <?php }?>
</header>


<script>

    


    let subMenu = document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    function checkSpotifyToken() {
        fetch('check_token.php')
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                if (data.status === 'success') {
                    console.log('Spotify token updated:', data.access_token);
                }
            })
            .catch(error => console.error('Error refreshing token:', error));
    }

    setInterval(checkSpotifyToken, 300000);

    checkSpotifyToken();
</script>

<style>
    header{
        background-color: black;
        height: 100px;
        width: 100%;
        position: relative;
    }

    .not-logged-info{
        color: white;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .not-logged-info h3{
        margin: 0;
    }

    .sub-menu-wrap{
        position: absolute;
        top: 100%;
        right: 2%;
        width: 220px;
        display: none;
        opacity: 0;
        transform: scale(0.8);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .sub-menu-wrap.open-menu{
        display: block;
        opacity: 1;
        transform: scale(1);
    }

    .sub-menu{
        background: #575757;
        margin: 2px 0;
        border-radius: 4px;
        overflow: hidden;
    }

    .sub-menu-link{
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #D6D6D6;
        height: 40px;
        width: 100%;
    }

    .sub-menu-link p{
        margin-left: 5px;
        width: 90%;
    }

    .sub-menu-link span{
        font-family: "Helvetica Neue",Helvetica;
    }

    .sub-menu-link:hover{
        background: #727272;
    }

    .nav-items{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        position: absolute;
    }

    .nav-items a:not(.logo-a){
        text-decoration: none;
        padding: 3px;
        padding-left: 20px;
        padding-right: 20px;
        color: black;
        background-color: #D9D9D9;
        border-radius: 5px;
        position: relative;
    }

    .logo-container{
        height: 90%;
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
    }

    .logo-container img{
        max-width: 100%;
        height: auto;
        margin: 0;
        padding: 0;
    }

    .user-items{
        height: 50px;
        width: 80px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        position: absolute;
        gap: 5px;
        right: 80px;
        top: 23px;
        cursor: pointer;
    }

    .user-items > img{
        height: 100%;
        width: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-items span{
        color: white;
        margin: 0;
    }

    .username-badges{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .badges{
        display: flex;
        align-items: center;
    }

    .username-badges img{
        height: 20px;
        width: 20px;
        object-fit: cover;
    }


    .login-btn{
        position: absolute;
        text-decoration: none;
        right: 80px;
        top: 32px;
        background-color: white;
        font-family: "Metal mania", serif;
        color: black;
        border: none;
        border-radius: 35px;
        padding-left: 30px;
        padding-right: 30px;
        padding-top: 10px;
        padding-bottom: 10px;
        cursor: pointer;
    }

    

    

    


</style>