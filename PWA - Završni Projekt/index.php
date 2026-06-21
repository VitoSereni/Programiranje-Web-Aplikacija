<?php
require_once 'connect.php';
$current = 'home';
$pageTitle = 'GamingHub - Početna';
require_once 'menu.php';

$categories = ['vijesti', 'recenzije', 'najave'];
foreach ($categories as $cat) {
    echo '<section class="category-section">';
    echo '<div class="section-title '.e($cat).'"><span>'.e(category_name($cat)).'</span></div>';
    echo '<div class="article-grid">';

    $sql = "SELECT id, datum, naslov, sazetak, slika, ocjena FROM vijesti WHERE arhiva = 0 AND kategorija = ? ORDER BY id DESC LIMIT 3";
    $stmt = mysqli_prepare($dbc, $sql);
    mysqli_stmt_bind_param($stmt, 's', $cat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '<p>Trenutno nema objava u ovoj kategoriji.</p>';
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $image = !empty($row['slika']) ? $row['slika'] : 'placeholder.jpg';
        echo '<article class="news-card">';
        echo '<a href="clanak.php?id='.e($row['id']).'"><img src="img/'.e($image).'" alt="'.e($row['naslov']).'"></a>';
        echo '<h2><a href="clanak.php?id='.e($row['id']).'">'.e($row['naslov']).'</a></h2>';
        echo '<time>'.e($row['datum']).'</time>';
        if ($cat === 'recenzije' && !empty($row['ocjena'])) {
            echo '<div class="card-rating">Ocjena: '.e($row['ocjena']).'</div>';
        }
        echo '<p>'.e($row['sazetak']).'</p>';
        echo '</article>';
    }
    mysqli_stmt_close($stmt);
    echo '</div></section>';
}
mysqli_close($dbc);
require_once 'footer.php';
?>
