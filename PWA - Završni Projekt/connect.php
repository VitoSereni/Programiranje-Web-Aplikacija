<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'gaminghub';

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('category_name')) {
    function category_name($slug) {
        $names = [
            'vijesti' => 'Vijesti',
            'recenzije' => 'Recenzije',
            'najave' => 'Najave'
        ];
        return $names[$slug] ?? 'Vijesti';
    }
}

$dbc = mysqli_connect($server, $username, $password, $database);
if (!$dbc) {
    die('Greška kod spajanja na bazu. Provjerite XAMPP i uvezite datoteku gaminghub.sql.');
}
mysqli_set_charset($dbc, 'utf8mb4');
?>
