<?php

$conn = new mysqli("localhost", "root", "", "vjezba17");

if ($conn->connect_error) {
    die("Greška kod spajanja: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$sql = "SELECT users.name, users.lastname, countries.country_name
        FROM users
        INNER JOIN countries ON users.country_id = countries.id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Users and Countries</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 12px;
            font-size: 20px;
        }

        .icon {
            margin-right: 8px;
        }

        .name {
            color: #2e7d32;
            font-weight: bold;
        }

        .country {
            color: #333;
        }
    </style>
</head>
<body>

<h1>Users and Countries</h1>

<ul>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <li>
            <span class="icon">👤</span>
            <span class="name">
                <?php echo $row["name"] . " " . $row["lastname"]; ?>
            </span>
            <span class="country">
                (<?php echo $row["country_name"]; ?>)
            </span>
        </li>
    <?php } ?>
</ul>

</body>
</html>

<?php
$conn->close();
?>