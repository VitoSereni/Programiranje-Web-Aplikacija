<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "vjezba16";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Greška kod spajanja na bazu: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>