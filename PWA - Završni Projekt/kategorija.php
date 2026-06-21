<?php
require_once 'connect.php';
$allowed = ['vijesti', 'recenzije', 'najave'];
$category = $_GET['id'] ?? 'vijesti';
if (!in_array($category, $allowed)) {
    $category = 'vijesti';
}
$current = $category;
$pageTitle = 'GamingHub - '.category_name($category);
require_once 'menu.php';

echo '<section class="category-section">';
echo '<div class="section-title '.e($category).'"><span>'.e(category_name($category)).'</span></div>';
echo '<div class="article-grid">';

$sql = "SELECT id, datum, naslov, sazetak, slika, ocjena FROM vijesti WHERE arhiva = 0 AND kategorija = ? ORDER BY id DESC";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, 's', $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo '<p>Nema članaka za ovu kategoriju.</p>';
}

while ($row = mysqli_fetch_assoc($result)) {
    $image = !empty($row['slika']) ? $row['slika'] : 'placeholder.jpg';
    echo '<article class="news-card">';
    echo '<a href="clanak.php?id='.e($row['id']).'"><img src="img/'.e($image).'" alt="'.e($row['naslov']).'"></a>';
    echo '<h2><a href="clanak.php?id='.e($row['id']).'">'.e($row['naslov']).'</a></h2>';
    echo '<time>'.e($row['datum']).'</time>';
    if ($category === 'recenzije' && !empty($row['ocjena'])) {
        echo '<div class="card-rating">Ocjena: '.e($row['ocjena']).'</div>';
    }
    echo '<p>'.e($row['sazetak']).'</p>';
    echo '</article>';
}

echo '</div></section>';
mysqli_stmt_close($stmt);
mysqli_close($dbc);
require_once 'footer.php';
?>
