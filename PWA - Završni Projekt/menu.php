<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
if (!function_exists('active_menu')) {
    function active_menu($name, $current) {
        return $name === $current ? ' class="active"' : '';
    }
}
$current = $current ?? '';
$pageTitle = $pageTitle ?? 'GamingHub';
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a href="index.php" class="logo">GamingHub</a>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php"<?php echo active_menu('home', $current); ?>>Početna</a></li>
                <li><a href="kategorija.php?id=vijesti"<?php echo active_menu('vijesti', $current); ?>>Vijesti</a></li>
                <li><a href="kategorija.php?id=recenzije"<?php echo active_menu('recenzije', $current); ?>>Recenzije</a></li>
                <li><a href="kategorija.php?id=najave"<?php echo active_menu('najave', $current); ?>>Najave</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="unos.php"<?php echo active_menu('unos', $current); ?>>Unos</a></li>
                <?php endif; ?>
                <li><a href="administrator.php"<?php echo active_menu('admin', $current); ?>>Administracija</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="logout.php">Odjava</a></li>
                <?php else: ?>
                    <li><a href="prijava.php"<?php echo active_menu('prijava', $current); ?>>Prijava</a></li>
                    <li><a href="registracija.php"<?php echo active_menu('registracija', $current); ?>>Registracija</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="page-wrap">
<?php if ($isLoggedIn): ?>
    <div class="login-info">
        Prijavljeni ste kao <strong><?php echo e($_SESSION['username'] ?? 'korisnik'); ?></strong><?php if ($isAdmin) echo ' (admin)'; ?>.
    </div>
<?php endif; ?>
