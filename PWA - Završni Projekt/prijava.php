<?php
require_once 'connect.php';
$current = 'prijava';
$pageTitle = 'GamingHub - Prijava';

$poruka = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $username = trim($_POST['username'] ?? '');
    $lozinka = $_POST['lozinka'] ?? '';

    if ($username === '' || $lozinka === '') {
        $poruka = 'Unesite korisničko ime i lozinku.';
    } else {
        $sql = "SELECT id, ime, prezime, korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_prepare($dbc, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $ime, $prezime, $korisnickoIme, $hash, $razina);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($lozinka, $hash)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $korisnickoIme;
            $_SESSION['ime'] = $ime;
            $_SESSION['razina'] = (int)$razina;
            $_SESSION['admin'] = ((int)$razina > 0);

            $success = true;
            $poruka = 'Uspješna prijava. Dobrodošli, '.$ime.'!';
        } else {
            $poruka = 'Korisničko ime ili lozinka nisu ispravni. Ako nemate račun, prvo se registrirajte.';
        }
        mysqli_stmt_close($stmt);
    }
}

require_once 'menu.php';
?>
<section class="form-box">
    <h1>Prijava korisnika</h1>
    <p>Ovdje se mogu prijaviti već registrirani korisnici.</p>

    <?php if ($poruka !== ''): ?>
        <div class="message <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo e($poruka); ?>
            <?php if (!$success): ?>
                <a href="registracija.php">Registracija</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
        <form action="prijava.php" method="POST">
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
        <p class="small-note">Testni korisnik: <strong>student</strong> / <strong>student123</strong></p>
    <?php else: ?>
        <p><a class="button" href="index.php">Povratak na početnu</a> <a class="button" href="logout.php">Odjava</a></p>
    <?php endif; ?>
</section>
<?php
mysqli_close($dbc);
require_once 'footer.php';
?>
