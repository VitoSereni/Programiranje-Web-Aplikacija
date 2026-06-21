<?php
session_start();
require_once 'connect.php';
$current = 'admin';
$pageTitle = 'GamingHub - Administracija';
require_once 'menu.php';

$poruka = '';

if (isset($_POST['prijava'])) {
    $username = trim($_POST['username'] ?? '');
    $lozinka = $_POST['lozinka'] ?? '';

    $sql = "SELECT id, ime, korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_prepare($dbc, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $korisnikId, $ime, $korisnickoIme, $hash, $razina);
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($lozinka, $hash)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $korisnikId;
        $_SESSION['username'] = $korisnickoIme;
        $_SESSION['ime'] = $ime;
        $_SESSION['razina'] = (int)$razina;

        if ((int)$razina > 0) {
            $_SESSION['admin'] = true;
            $poruka = 'Uspješna prijava.';
        } else {
            $_SESSION['admin'] = false;
            $poruka = $ime.', nemate dovoljna prava za pristup ovoj stranici.';
        }
    } else {
        $poruka = 'Korisnik ne postoji ili lozinka nije ispravna. Prvo se registrirajte.';
    }
    mysqli_stmt_close($stmt);
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    ?>
    <section class="form-box">
        <h1>Administracija</h1>
        <?php if ($poruka !== ''): ?>
            <div class="message error"><?php echo e($poruka); ?> <a href="registracija.php">Registracija</a></div>
        <?php endif; ?>
        <form action="administrator.php" method="POST">
            <div class="form-row">
                <label for="username">Korisničko ime</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-row">
                <label for="lozinka">Lozinka</label>
                <input type="password" name="lozinka" id="lozinka" required>
            </div>
            <button type="submit" name="prijava">Prijava</button>
        </form>
        <p class="small-note">Testni admin: korisničko ime <strong>admin</strong>, lozinka <strong>admin123</strong>.</p>
    </section>
    <?php
    mysqli_close($dbc);
    require_once 'footer.php';
    exit;
}

if (isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    $sql = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $poruka = 'Vijest je obrisana.';
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
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

    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === UPLOAD_ERR_OK) {
        $original = basename($_FILES['pphoto']['name']);
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowedExt)) {
            $picture = time().'_'.preg_replace('/[^a-zA-Z0-9_.-]/', '_', $original);
            move_uploaded_file($_FILES['pphoto']['tmp_name'], 'img/'.$picture);
            $sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=?, slika=?, ocjena=? WHERE id=?";
            $stmt = mysqli_prepare($dbc, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssissi', $title, $about, $content, $category, $archive, $picture, $ocjena, $id);
        } else {
            $stmt = false;
        }
    } else {
        $sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=?, ocjena=? WHERE id=?";
        $stmt = mysqli_prepare($dbc, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssisi', $title, $about, $content, $category, $archive, $ocjena, $id);
    }

    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $poruka = 'Vijest je ažurirana.';
    }
}
?>
<section class="category-section">
    <div class="section-title vijesti"><span>Administracija</span></div>
    <?php if ($poruka !== ''): ?><div class="message success"><?php echo e($poruka); ?></div><?php endif; ?>
    <p>Prijavljeni ste kao: <strong><?php echo e($_SESSION['username']); ?></strong> | <a href="logout.php">Odjava</a></p>
    <p><a class="button" href="unos.php">Dodaj novu vijest</a></p>

<?php
$sql = "SELECT id, datum, naslov, sazetak, tekst, slika, kategorija, arhiva, ocjena FROM vijesti ORDER BY id DESC";
$result = mysqli_query($dbc, $sql);
while ($row = mysqli_fetch_assoc($result)):
    $image = !empty($row['slika']) ? $row['slika'] : 'placeholder.jpg';
?>
    <div class="admin-item">
        <img src="img/<?php echo e($image); ?>" alt="<?php echo e($row['naslov']); ?>">
        <form action="administrator.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo e($row['id']); ?>">
            <div class="form-row">
                <label>Naslov</label>
                <input type="text" name="title" value="<?php echo e($row['naslov']); ?>">
            </div>
            <div class="form-row">
                <label>Sažetak</label>
                <textarea name="about"><?php echo e($row['sazetak']); ?></textarea>
            </div>
            <div class="form-row">
                <label>Tekst</label>
                <textarea name="content"><?php echo e($row['tekst']); ?></textarea>
            </div>
            <div class="form-row">
                <label>Kategorija</label>
                <select name="category">
                    <option value="vijesti" <?php if ($row['kategorija']=='vijesti') echo 'selected'; ?>>Vijesti</option>
                    <option value="recenzije" <?php if ($row['kategorija']=='recenzije') echo 'selected'; ?>>Recenzije</option>
                    <option value="najave" <?php if ($row['kategorija']=='najave') echo 'selected'; ?>>Najave</option>
                </select>
            </div>
            <div class="form-row">
                <label>Ocjena igre</label>
                <input type="text" name="ocjena" value="<?php echo e($row['ocjena']); ?>" placeholder="npr. 9/10, samo za recenzije">
            </div>
            <div class="form-row">
                <label>Nova slika</label>
                <input type="file" name="pphoto" accept="image/*">
            </div>
            <div class="form-row">
                <label><input type="checkbox" name="archive" value="1" <?php if ((int)$row['arhiva'] === 1) echo 'checked'; ?>> Arhivirano</label>
            </div>
            <div class="admin-actions">
                <button type="submit" name="update">Spremi promjene</button>
                <button type="submit" name="delete" onclick="return confirm('Obrisati vijest?')">Obriši</button>
                <a class="button" href="clanak.php?id=<?php echo e($row['id']); ?>">Otvori</a>
            </div>
        </form>
    </div>
<?php endwhile; ?>
</section>
<?php
mysqli_close($dbc);
require_once 'footer.php';
?>
