<?php
$naslov = "Izračun";
$rezultat = "";


if (isset($_POST["a"]) && isset($_POST["b"])) {
    $a = $_POST["a"];
    $b = $_POST["b"];

    $c = (3 * $a - $b) / 2;

    $rezultat = $c;
}
?>


<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $naslov;  ?></title>
    <meta name="description" content="Prvi PHP dokument s osnovnim CSS stilom.">
</head>
<body>
    <h1>Izračunaj</h1>

    <form method="post">
        <label>Vrijednost a:</label><br>
        <input type="number" name="a"><br><br>

        <label>Vrijednost b:</label><br>
        <input type="number" name="b"><br><br>

        <input type="submit" value="Pošalji">
    </form>
    
    <h3>Rezultat: </h3>
    <h3>c = <?php echo $rezultat; ?> </h3>
</body>
</html>