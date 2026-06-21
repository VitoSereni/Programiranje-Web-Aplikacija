<?php
require_once 'connect.php';
$current = 'unos';
$pageTitle = 'Obrada vijesti';
require_once 'menu.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo '<div class="message error">Samo administrator može spremati nove vijesti.</div>';
    echo '<p><a class="button" href="administrator.php">Administracija</a></p>';
    require_once 'footer.php';
    mysqli_close($dbc);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="message error">Ova stranica prima podatke samo iz forme za unos.</div>';
    echo '<p><a class="button" href="unos.php">Povratak na unos</a></p>';
    require_once 'footer.php';
    exit;
}

$title = trim($_POST['title'] ?? '');
$about = trim($_POST['about'] ?? '');
$content = trim($_POST['content'] ?? '');
$category = $_POST['category'] ?? 'vijesti';
$ocjena = trim($_POST['ocjena'] ?? '');
$allowed = ['vijesti', 'recenzije', 'najave'];
if (!in_array($category, $allowed)) {
    $category = 'vijesti';
}
if ($category !== 'recenzije') {
    $ocjena = '';
}
$archive = isset($_POST['archive']) ? 1 : 0;
$date = date('d.m.Y.');
$picture = 'placeholder.jpg';

if ($title === '' || $about === '' || $content === '') {
    echo '<div class="message error">Naslov, sažetak i tekst vijesti su obavezni.</div>';
    echo '<p><a class="button" href="unos.php">Povratak na unos</a></p>';
    require_once 'footer.php';
    exit;
}

if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['pphoto']['tmp_name'];
    $original = basename($_FILES['pphoto']['name']);
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($ext, $allowedExt)) {
        $picture = time().'_'.preg_replace('/[^a-zA-Z0-9_.-]/', '_', $original);
        move_uploaded_file($tmp, 'img/'.$picture);
    }
}

$sql = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva, ocjena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, 'ssssssis', $date, $title, $about, $content, $picture, $category, $archive, $ocjena);
mysqli_stmt_execute($stmt);
$newId = mysqli_insert_id($dbc);
mysqli_stmt_close($stmt);

echo '<div class="message success">Vijest je spremljena u bazu podataka.</div>';
echo '<article class="article-page">';
echo '<img class="main-image" src="img/'.e($picture).'" alt="'.e($title).'">';
echo '<div class="article-content">';
echo '<h1>'.e($title).'</h1>';
echo '<span class="news-date">'.e($date).' | '.e(category_name($category)).'</span>';
if ($category === 'recenzije' && $ocjena !== '') {
    echo '<div class="ocjena-box">Ocjena igre: <strong>'.e($ocjena).'</strong></div>';
}
echo '<p><strong>'.e($about).'</strong></p>';
echo '<p>'.nl2br(e($content)).'</p>';
echo '</div></article>';
if ($archive == 0) {
    echo '<p><a class="button" href="clanak.php?id='.e($newId).'">Otvori javni članak</a></p>';
} else {
    echo '<p class="small-note">Članak je arhiviran, zato se neće prikazivati na javnim stranicama.</p>';
}

mysqli_close($dbc);
require_once 'footer.php';
?>
