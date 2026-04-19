<?php
$moje_godine = 20;
$mjeseci = $moje_godine * 12;
$dani = $moje_godine * 365;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1Zad1</title>
</head>
<body>
    <h1>Lab 1 Zadatak 1 - Vito Sereni</h1>
    <?php echo "<strong>$moje_godine</strong>" . " godina ima " . $mjeseci . " mjeseci i " .$dani . " dana."; ?>
</body>
</html>