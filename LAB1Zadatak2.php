<?php
$rezultat = "";

if (isset($_POST["visina"]) && isset($_POST["disciplina"])){

    $visina = $_POST["visina"];
    $disciplina = $_POST["disciplina"];

    if($disciplina == "Free-style") {
        $štap = $visina * 0.9;
    } else {
        if($disciplina == "Classical") {
            $štap = $visina * 0.85;
        } else {
            if($disciplina == "Nordic walk"){
                $štap = $visina * 0.68;
            }
        }
    }
}

if(isset($štap)) {
    $rezultat = "Ako je visina " . " '" . $visina . "' " . " cm i odabrana disciplina " . " '" . $disciplina . "' " . " onda je potreban štap duljine " . " '" . round($štap) . "' " . " cm.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1Zad2</title>
</head>
<body>
    <h1>Lab 1 Zadatak 2 - Vito Sereni</h1>

    <form method="post">
        <label>Visina (cm):</label>
        <br>
        <input type="number" name="visina" required>
        <br>
        <br>
        
        <label>Disciplina:</label>
        <br>
        
        <select name="disciplina">
            <option value="Free-style">Free-style</option>
            <option value="Classical">Classical</option>
            <option value="Nordic walk">Nordic walk</option>
        </select>
        <br>
        <br>
        <input type="submit" value="Izračunaj">
    </form>

    <br>
    <?php echo $rezultat; ?>
    
</body>
</html>