<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Callback</title>
</head>
<body>
    <h1>Přihlášení přes Spotify</h1>
    <p id="token"></p>

    <script>
        const hash = window.location.hash
            .substring(1)
            .split('&')
            .reduce((initial, item) => {
                let parts = item.split('=');
                initial[parts[0]] = decodeURIComponent(parts[1]);
                return initial;
            }, {});

        const accessToken = hash.access_token;

        if (accessToken) {
            document.getElementById('token').innerText = `Access Token: ${accessToken}`;
        } else {
            document.getElementById('token').innerText = 'Nepodařilo se získat token.';
        }

        
        console.log('Access Token:', accessToken);
    </script>
</body>
</html>
