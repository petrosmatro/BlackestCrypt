<?php

    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');
    


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

        .search-bar{
            margin: 40px auto;
            display: flex;
            justify-content: center;
            border-radius: 25px;
            padding: 10px 20px;
            width: 500px;
            background-color: #5B5B5B;
        }

        .search-button{
            width: 15px;
            height: 15px;
            border: 2px solid #FFFFFF;
            border-radius: 50%;
            position: relative;
            margin-right: 10px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .search-button::after{
            content: '';
            width: 15px;
            height: 2px;
            background-color: #FFFFFF;
            position: absolute;
            bottom: -6px;
            right: -12px;
            transform: rotate(45deg);
            transform-origin: center;
        }

        .search-bar input{
            border: none;
            outline: none;
            flex: 1;
            font-size: 16px;
            color: white;
            font-family: "Metal mania", serif;
            padding: 5px;
            background-color: transparent;
        }

        .search-bar input::placeholder{
            font-family: "Metal mania", serif;
        }

        .results{
            width: 800px;
            height: 200px;
            margin: 60px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .results a{
            text-decoration: none;
        }

        .artist-card{
            width: 180px;
            height: 80px;
            background-color: #5B5B5B;
            display: flex;
            align-items: center;
            border-radius: 20px;
        }

        .artist-title{
            height: 50%;
            margin-left: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .artist-title p{
            margin: 0;
        }

        .artist-name{
            color: white;
            font-size: 15px;
        }

        .artist-genres{
            color: #A1A1A1;
            font-size: 10px;
        }


        .artist-card img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #B9B9B9;
            margin-left: 10px;
        }

        .link-container{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 40px;
        }

        .community-bands-a{
            text-decoration: none;
            color: black;
            background-color: white;
            padding: 10px 20px;
            border-radius: 20px;
        }

    </style>
</head>
<body>

    <?php include "header.php";?>

    <div class="link-container">
        <a class="community-bands-a" href="community_bands.php">Community Bands Archive</a>
    </div>
    
    <div class="search-bar">
        <div class="search-button" id="search-button"></div>
        <input type="text" id="search-input" placeholder="Search for some brutal freaks...">
    </div>


    <div class="results" id="results"></div>
    <script>

        const accessToken = <?php echo json_encode($accessToken);?>;

        document.getElementById("search-button").addEventListener('click', async () =>{
            const query = document.getElementById("search-input").value;
            const artists = await searchArtists(query);

            const resultsDiv = document.getElementById("results");
            resultsDiv.innerHTML = '';

            if (artists.length === 0) {
                resultsDiv.innerHTML = '<p>No results.</p>';
                return;
            }

            artists.forEach(artist => {
                const artistCard = document.createElement('div');
                artistCard.innerHTML = `
                    <a href="band.php?id=${artist.id}">
                        <div class="artist-card">
                            <img src="${artist.images[0]?.url || 'placeholder.jpg'}" alt="${artist.name}">
                            <div class="artist-title">
                                <p class="artist-name">${artist.name}</p>
                                <p class="artist-genres">${artist.genres.slice(0, 2).join(', ')}</p>
                            </div>
                        </div>
                    </a>
                `;
                resultsDiv.appendChild(artistCard);
            });


        });

        async function searchArtists(query){
            const response = await fetch(`https://api.spotify.com/v1/search?q=${encodeURIComponent(query)}&type=artist&limit=10`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            const data = await response.json();
            const filteredArtists = data.artists.items.filter(artist => 
                artist.genres.some(genre => /metal|rock|punk/i.test(genre))
            );
            return filteredArtists;
        }


        

        
    </script>
</body>
</html>