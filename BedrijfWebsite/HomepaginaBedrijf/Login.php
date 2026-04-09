<?php
require_once __DIR__ . "/auth.php";
auth_init();

$user = auth_user();
if ($user) {
    auth_redirect("index.php");
}

$loggedOut = (isset($_GET["logout"]) && $_GET["logout"] === "1");
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = auth_normalize_email((string) ($_POST["email"] ?? ""));
    $password = (string) ($_POST["password"] ?? "");

    if ($email === "" || $password === "") {
        $error = "Vul e-mail en wachtwoord in.";
    } else {
        $users = auth_read_users();
        $user = auth_find_user_by_email($email, $users);

        if (!$user || !password_verify($password, (string) ($user["password_hash"] ?? ""))) {
            $error = "Onjuiste inloggegevens.";
        } else {
            auth_login($user);
            auth_redirect("index.php?login=1");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inloggen</title>
</head>
<body>
    <?php include "./Navbar.php" ?>

    <div class="auth-wrap">
        <h2 class="auth-title">Inloggen</h2>

        <?php if ($loggedOut) { ?>
            <div class="flash flash--success" role="status" aria-live="polite">Je bent uitgelogd.</div>
        <?php } ?>

        <?php if ($error) { ?>
            <div class="flash flash--error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></div>
        <?php } ?>

        <form class="auth-card" method="post" action="Login.php" novalidate>
            <label class="auth-label" for="email">E-mail</label>
            <input class="auth-input" type="email" name="email" id="email" placeholder="naam@email.com" value="<?php echo htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, "UTF-8"); ?>" required>

            <label class="auth-label" for="password">Wachtwoord</label>
            <input class="auth-input" type="password" name="password" id="password" required>

            <button class="auth-btn" type="submit">Inloggen</button>
            <p class="auth-hint">Nog geen account? <a href="Register.php">Registreren</a></p>
        </form>
    </div>

    <?php include "./Footer.php" ?>
</body>
</html>
