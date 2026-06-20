<?php

require_once "database.php";

$name = $_POST["name"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$country = $_POST["country"];

if (strlen($username) < 5 || strlen($username) > 10) {
    die("Username mora imati najmanje 5 i najviše 10 znakova.");
}

if (strlen($password) < 4) {
    die("Password mora imati najmanje 4 znaka.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, lastname, email, username, password, country)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $lastname, $email, $username, $hashedPassword, $country);

if ($stmt->execute()) {
    echo "Korisnik je uspješno registriran.";
    echo "<br><a href='index.php'>Natrag na formu</a>";
} else {
    echo "Greška: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>