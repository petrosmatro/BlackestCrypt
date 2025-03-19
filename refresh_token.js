function checkSpotifyToken() {
    fetch('check_token.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Spotify token updated:', data.access_token);
            }
        })
        .catch(error => console.error('Error refreshing token:', error));
}

setInterval(checkSpotifyToken, 300000);

checkSpotifyToken();