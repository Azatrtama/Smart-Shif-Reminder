<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "smart_shift_reminder"
);

if (!$conn) {

    die("Koneksi gagal: " . mysqli_connect_error());

}

?>