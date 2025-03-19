<?php

    session_start();
    include 'db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackest Crypt - Genre</title>
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

        .pagination{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .pagination button{
            border: none;
            border-radius: 50%;
            font-size: 20px;
            width: 30px;
            height: 30px;
            color: white;
            background-color: #5B5B5B;
            font-family: "Metal mania", serif;
            cursor: pointer;
        }

        .pagination span{
            color: white;
        }

        #prev-page span{
            display: inline-block;
            transform: rotate(90deg);
        }

        #next-page span{
            display: inline-block;
            transform: rotate(-90deg);
        }
    </style>
</head>
<body>
    <?php include "header.php";?>


    <div class="alphabet-buttons">
        <?php

            foreach (range('A', 'Z') as $letter) {
                echo "<button class='letter-btn' data-letter='$letter'>$letter</button>";
            }
        ?>
    </div>

    <div class="pagination">
        <button id="prev-page" disabled><span>†</span></button>
        <span id="page-info">1</span>
        <button id="next-page"><span>†</span></button>
    </div>

    <div class="genre-artists">

    </div>
    
    <script>
        const accessToken = <?php echo json_encode($accessToken);?>;
        let currentPage = 1;
        let selectedLetter = null;  
        let allArtists = [];

        function getGenreNameFromURL(){
            const params = new URLSearchParams(window.location.search);
            return params.get('name');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            

            await loadAllArtists();

            document.getElementById('next-page').addEventListener('click', () => {
                if ((currentPage * 50) < getFilteredArtists().length) {
                    currentPage++;
                    displayArtists(getCurrentPageArtists());
                }
            });

            document.getElementById('prev-page').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayArtists(getCurrentPageArtists());
                }
            });

            

            const letterButtons = document.querySelectorAll('.letter-btn');
            letterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    selectedLetter = button.getAttribute('data-letter'); 
                    currentPage = 1;
                    displayArtists(getCurrentPageArtists());
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

            document.getElementById('page-info').textContent = `${currentPage}`;
            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = (currentPage * 50) >= getFilteredArtists().length;
        }

        

        

        async function loadAllArtists() {
            const genre = getGenreNameFromURL();
            let offset = 0;
            let allData = [];

            while (offset < 500) {
                const data = await fetchArtists(genre, offset);
                if (data.length === 0) break;
                allData = [...allData, ...data];
                offset += 50;
            }

            allArtists = allData;
            displayArtists(getCurrentPageArtists());
        }

        function getFilteredArtists() {
            if (selectedLetter) {
                return allArtists.filter(artist => artist.name.charAt(0).toUpperCase() === selectedLetter);
            }
            return allArtists;
        }

        function getCurrentPageArtists() {
            const filtered = getFilteredArtists();
            const startIndex = (currentPage - 1) * 50;
            return filtered.slice(startIndex, startIndex + 50);
        }
        

        async function fetchArtists(genre, offset) {
            const encodedGenre = genre.replace(/ /g, '-');
            const response = await fetch(`https://api.spotify.com/v1/search?q=genre:${encodedGenre}&type=artist&limit=50&offset=${offset}`, {
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