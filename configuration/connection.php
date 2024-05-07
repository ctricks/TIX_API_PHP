<?php
    $hostname="mysql5050.site4now.net";
    $username="a6ebb6_bok";
    $password="tix@dmin2024";
    $database="db_a6ebb6_tixdb";

$ctx = mysqli_init();

$conn = mysqli_connect ($hostname, $username, $password,$database);
if (!$conn) {
    die ('Connect error (' . $conn->connect_errno . '): ' . $conn->connect_error . "\n");
}

?>