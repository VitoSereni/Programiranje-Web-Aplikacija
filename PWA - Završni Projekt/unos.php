<?php
$current = 'unos';
$pageTitle = 'Unos vijesti';
require_once 'menu.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    ?>
    <section class="form-box">
        <h1>Unos vijesti</h1>
        <div class="message error">
            Pristup stranici za unos ima samo administrator. Prvo se prijavite u administraciju s admin računom.
        </div>
        <p><a class="button" href="administrator.php">Administracija</a></p>
    </section>
    <?php
    require_once 'footer.php';
    exit;
}
?>
<section class="form-box">
    <h1>Unos nove vijesti</h1>
    <form name="unos" action="skripta.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <label for="title">Naslov vijesti</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div class="form-row">
            <label for="about">Kratki sadržaj vijesti</label>
            <textarea name="about" id="about" required></textarea>
        </div>
        <div class="form-row">
            <label for="content">Tekst vijesti</label>
            <textarea name="content" id="content" required></textarea>
        </div>
        <div class="form-row">
            <label for="category">Kategorija</label>
            <select name="category" id="category" required>
                <option value="vijesti">Vijesti</option>
                <option value="recenzije">Recenzije</option>
                <option value="najave">Najave</option>
            </select>
        </div>
        <div class="form-row">
            <label for="ocjena">Ocjena igre</label>
            <input type="text" name="ocjena" id="ocjena" placeholder="npr. 9/10, samo za recenzije">
        </div>
        <div class="form-row">
            <label for="pphoto">Slika</label>
            <input type="file" name="pphoto" id="pphoto" accept="image/*">
        </div>
        <div class="form-row">
            <label><input type="checkbox" name="archive" value="1"> Spremi u arhivu / ne prikazuj na stranici</label>
        </div>
        <button type="submit" name="submit">Pošalji vijest</button>
    </form>
</section>
<?php require_once 'footer.php'; ?>
