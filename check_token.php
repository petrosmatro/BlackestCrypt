<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$sql = "SELECT spotify_access_token, spotify_refresh_token, spotify_expires_at FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['spotify_expires_at'] < time()) {
    function refreshSpotifyToken($refreshToken) {
        $clientId = "2810eaa769ff470d912020b8ac069eeb";
        $clientSecret = "17d9248edc824df983f3005855fc11d3";

        $url = "https://accounts.spotify.com/api/token";
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
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

        return $response ? json_decode($response, true) : null;
    }

    $newTokenData = refreshSpotifyToken($user['spotify_refresh_token']);
    if ($newTokenData) {
        $_SESSION['spotify_access_token'] = $newTokenData['access_token'];
        $newExpiresAt = time() + $newTokenData['expires_in'];

        $updateSql = "UPDATE users SET spotify_access_token = ?, spotify_expires_at = ? WHERE id_user = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sii", $newTokenData['access_token'], $newExpiresAt, $userId);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Token updated', 'access_token' => $newTokenData['access_token']]);
        exit;
    }
}

echo json_encode(['status' => 'ok', 'message' => 'Token still valid']);
?>

