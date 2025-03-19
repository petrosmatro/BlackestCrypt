<?php
session_start();
include 'db.php';

$desc_id = $_POST['id_description'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    mysqli_query($conn, "DELETE FROM descriptions_for_approval WHERE id_desc = $desc_id");
}
?>