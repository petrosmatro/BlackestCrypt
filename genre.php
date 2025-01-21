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

        .controls {
            margin: 20px auto;
            text-align: center;
        }

        .controls button {
            padding: 10px;
            margin: 5px;
            background-color: #5B5B5B;
            font-family: "Metal mania", serif;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .controls button:hover {
            background-color: #3C3C3C;
        }

        .alphabet-buttons {
            margin: 20px auto;
            text-align: center;
        }

        .alphabet-buttons button {
            padding: 8px;
            margin: 3px;
            background-color: #5B5B5B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: "Metal mania", serif;
        }

        .alphabet-buttons button:hover {
            background-color: #3C3C3C;
        }

        .genre-artists{
            width: 800px;
            height: 200px;
            margin: 60px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
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

        .genre-artists a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include "header.php";?>

    <div class="controls">
        <button id="sort-asc">Sort A-Z</button>
        <button id="sort-desc">Sort Z-A</button>
    </div>

    <div class="alphabet-buttons">
        <?php

            foreach (range('A', 'Z') as $letter) {
                echo "<button class='letter-btn' data-letter='$letter'>$letter</button>";
            }
        ?>
    </div>

    <div class="genre-artists">

    </div>

    <script>
        const accessToken = <?php echo json_encode($accessToken);?>;
        let artistsData = [];
        let filteredArtists = [];

        function getGenreNameFromURL(){
            const params = new URLSearchParams(window.location.search);
            return params.get('name');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const genre = getGenreNameFromURL();
            

            const artistsData = await fetchArtists(genre);
            filteredArtists = artistsData;

            displayArtists(filteredArtists);

            document.getElementById('sort-asc').addEventListener('click', () => {
                filteredArtists.sort((a, b) => a.name.localeCompare(b.name));
                displayArtists(filteredArtists);
            });

            document.getElementById('sort-desc').addEventListener('click', () => {
                filteredArtists.sort((a, b) => b.name.localeCompare(a.name));
                displayArtists(filteredArtists);
            });

            // Kliknutí na tlačítka pro písmena
            const letterButtons = document.querySelectorAll('.letter-btn');
            letterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const letter = button.getAttribute('data-letter');
                    filteredArtists = artistsData.filter(artist => artist.name.charAt(0).toUpperCase() === letter);
                    displayArtists(filteredArtists);
                });
            });

            
        });

        function displayArtists(artists) {
            const artistsDiv = document.querySelector('.genre-artists');
            artistsDiv.innerHTML = '';

            if (artists.length === 0) {
                artistsDiv.innerHTML = '<p>Žádné výsledky.</p>';
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
                artistsDiv.appendChild(artistCard);
            });
        }
        

        async function fetchArtists(genre){
            const encodedGenre = genre.replace(/ /g, '-');
            const response = await fetch(`https://api.spotify.com/v1/search?q=genre:${encodedGenre}&type=artist&limit=50&offset=50`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            const data = await response.json();
            return data.artists.items;
        }
    </script>
</body>
</html>