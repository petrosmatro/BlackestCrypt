<?php
// Spotify Client ID a Secret
$clientId = "2810eaa769ff470d912020b8ac069eeb";
$clientSecret = "17d9248edc824df983f3005855fc11d3";
$redirectUri = "http://localhost/workspace/BlackestCrypt/spotify_callback.php";


$code = $_GET['code'];


$url = "https://accounts.spotify.com/api/token";
$data = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirectUri,
    'client_id' => $clientId,
    'client_secret' => $clientSecret
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$responseData = json_decode($response, true);


$accessToken = $responseData['access_token'];
$refreshToken = $responseData['refresh_token'];
$expiresIn = $responseData['expires_in'];


$conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}


session_start();
$userEmail = $_SESSION['email'];
$expiresAt = time() + $expiresIn;

$sql = "UPDATE users SET spotify_access_token = ?, spotify_refresh_token = ?, spotify_expires_at = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $accessToken, $refreshToken, $expiresAt, $userEmail);

if ($stmt->execute()) {
    header("Location: login.php");
} else {
    echo "Chyba: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
