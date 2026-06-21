<?php
require_once 'connect.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT id, datum, naslov, sazetak, tekst, slika, kategorija, ocjena FROM vijesti WHERE id = ? AND arhiva = 0";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$article = mysqli_fetch_assoc($result);
$current = $article['kategorija'] ?? '';
$pageTitle = $article ? $article['naslov'] : 'Članak nije pronađen';
require_once 'menu.php';

if (!$article) {
    echo '<div class="message error">Članak nije pronađen ili je spremljen u arhivu.</div>';
} else {
    $image = !empty($article['slika']) ? $article['slika'] : 'placeholder.jpg';
    echo '<article class="article-page">';
    echo '<img class="main-image" src="img/'.e($image).'" alt="'.e($article['naslov']).'">';
    echo '<div class="article-content">';
    echo '<h1>'.e($article['naslov']).'</h1>';
    echo '<span class="news-date">'.e($article['datum']).' | '.e(category_name($article['kategorija'])).'</span>';
    if ($article['kategorija'] === 'recenzije' && !empty($article['ocjena'])) {
        echo '<div class="ocjena-box">Ocjena igre: <strong>'.e($article['ocjena']).'</strong></div>';
    }
    echo '<p><strong>'.e($article['sazetak']).'</strong></p>';
    echo '<p>'.nl2br(e($article['tekst'])).'</p>';
    echo '</div>';
    echo '</article>';
}
mysqli_stmt_close($stmt);
mysqli_close($dbc);
require_once 'footer.php';
?>
