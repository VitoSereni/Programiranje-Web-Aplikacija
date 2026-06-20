<?php

$conn = mysqli_connect("localhost", "root", "", "vjezba17");

if (!$conn) {
    die("Greška kod spajanja na bazu.");
}

mysqli_set_charset($conn, "utf8mb4");

$poruka = "";

if (isset($_POST["spremi"])) {
    $id = (int)$_POST["id"];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $country_id = (int)$_POST["country_id"];

    $sql = "UPDATE users 
            SET name = '$name', lastname = '$lastname', country_id = $country_id
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        $poruka = "Podaci su uspješno spremljeni.";
    } else {
        $poruka = "Greška kod spremanja podataka.";
    }
}

$editUser = null;

if (isset($_GET["edit"])) {
    $editId = (int)$_GET["edit"];

    $sql = "SELECT * FROM users WHERE id = $editId";
    $result = mysqli_query($conn, $sql);
    $editUser = mysqli_fetch_array($result);
}

$sqlUsers = "SELECT users.id, users.name, users.lastname, countries.country_name
             FROM users
             LEFT JOIN countries ON users.country_id = countries.id";

$users = mysqli_query($conn, $sqlUsers);

$sqlCountries = "SELECT * FROM countries";
$countries = mysqli_query($conn, $sqlCountries);

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Vježba 18</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h1, h2 {
            color: #222;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            font-size: 20px;
            margin-bottom: 12px;
        }

        .ime {
            color: green;
            font-weight: bold;
        }

        .edit {
            margin-left: 15px;
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        form {
            width: 400px;
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ccc;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        .poruka {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Lista korisnika</h1>

<?php if ($poruka != "") { ?>
    <p class="poruka"><?php echo $poruka; ?></p>
<?php } ?>

<ul>
    <?php while ($row = mysqli_fetch_array($users)) { ?>
        <li>
            👤
            <span class="ime">
                <?php echo $row["name"] . " " . $row["lastname"]; ?>
            </span>
            (<?php echo $row["country_name"]; ?>)

            <a class="edit" href="index.php?edit=<?php echo $row["id"]; ?>">
                Edit
            </a>
        </li>
    <?php } ?>
</ul>

<?php if ($editUser != null) { ?>

    <h2>Edit korisnika</h2>

    <form method="POST" action="index.php">

        <input type="hidden" name="id" value="<?php echo $editUser["id"]; ?>">

        <label>Ime:</label>
        <input type="text" name="name" value="<?php echo $editUser["name"]; ?>" required>

        <label>Prezime:</label>
        <input type="text" name="lastname" value="<?php echo $editUser["lastname"]; ?>" required>

        <label>Država:</label>
        <select name="country_id" required>
            <?php while ($country = mysqli_fetch_array($countries)) { ?>
                <option value="<?php echo $country["id"]; ?>"
                    <?php if ($country["id"] == $editUser["country_id"]) echo "selected"; ?>>
                    <?php echo $country["country_name"]; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" name="spremi">Spremi promjene</button>

    </form>

<?php } ?>

</body>
</html>

<?php
mysqli_close($conn);
?>