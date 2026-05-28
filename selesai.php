<?php

include 'koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE reminders
     SET status='Selesai'
     WHERE id='$id'"
);

header("Location: index.php");

?>