const clientId = '2810eaa769ff470d912020b8ac069eeb'; // Nahraď svým Client ID
const redirectUri = 'http://localhost/workspace/BlackestCrypt/main.php'; // URL pro přesměrování
const scopes = [
    'user-read-private',
    'user-read-email'
]; // Požadované oprávnění

document.getElementById('login-btn').addEventListener('click', () => {
    const authUrl = `https://accounts.spotify.com/authorize` +
        `?response_type=token` +
        `&client_id=${encodeURIComponent(clientId)}` +
        `&redirect_uri=${encodeURIComponent(redirectUri)}` +
        `&scope=${encodeURIComponent(scopes.join(' '))}`;

    // Přesměrování na Spotify login stránku
    window.location.href = authUrl;
});
