<?php
require_once 'connect.php';
$current = 'registracija';
$pageTitle = 'GamingHub - Registracija';
require_once 'menu.php';

$msg = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime'] ?? '');
    $prezime = trim($_POST['prezime'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $pass2 = $_POST['pass2'] ?? '';

    if ($ime === '' || $prezime === '' || $username === '' || $pass === '' || $pass2 === '') {
        $msg = 'Sva polja su obavezna.';
    } elseif ($pass !== $pass2) {
        $msg = 'Lozinke se ne podudaraju.';
    } else {
        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_prepare($dbc, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji.';
        } else {
            mysqli_stmt_close($stmt);
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $razina = 0;
            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($dbc, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hash, $razina);
            mysqli_stmt_execute($stmt);
            $success = true;
            $msg = 'Korisnik je uspješno registriran. Sada se možete prijaviti na stranici Prijava.';
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<section class="form-box">
    <h1>Registracija korisnika</h1>
    <?php if ($msg !== ''): ?>
        <div class="message <?php echo $success ? 'success' : 'error'; ?>"><?php echo e($msg); ?></div>
    <?php endif; ?>
    <form action="registracija.php" method="POST">
        <div class="form-row">
            <label for="ime">Ime</label>
            <input type="text" name="ime" id="ime" required>
        </div>
        <div class="form-row">
            <label for="prezime">Prezime</label>
            <input type="text" name="prezime" id="prezime" required>
        </div>
        <div class="form-row">
            <label for="username">Korisničko ime</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-row">
            <label for="pass">Lozinka</label>
            <input type="password" name="pass" id="pass" required>
        </div>
        <div class="form-row">
            <label for="pass2">Ponovi lozinku</label>
            <input type="password" name="pass2" id="pass2" required>
        </div>
        <button type="submit">Registriraj se</button>
    </form>
</section>
<?php
mysqli_close($dbc);
require_once 'footer.php';
?>
