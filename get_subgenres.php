<?php

session_start();
$conn = mysqli_connect('localhost', 'root', '', 'blackest_crypt');

if (isset($_GET['genre_id'])) {
    $genreId = $_GET['genre_id'];
    
    // Načítání podžánrů pro daný žánr
    $sql = "SELECT * FROM subgenres WHERE genre_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $genreId);
    $stmt->execute();
    $result = $stmt->get_result();

    $subgenres = [];
    while ($subgenre = $result->fetch_assoc()) {
        $subgenres[] = $subgenre;
    }

    echo json_encode($subgenres);
}

?>