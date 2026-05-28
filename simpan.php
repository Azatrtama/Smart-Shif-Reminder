<?php

include 'koneksi.php';

$bed = $_POST['bed'];
$action = $_POST['action'];
$date = $_POST['date'];
$time = $_POST['time'];
$shift = $_POST['shift'];

$query = "INSERT INTO reminders
(
    bed,
    action_name,
    tanggal,
    jam,
    shift_name,
    status
)

VALUES
(
    '$bed',
    '$action',
    '$date',
    '$time',
    '$shift',
    'Pending'
)";

mysqli_query($conn, $query);

header("Location: index.php");

?>