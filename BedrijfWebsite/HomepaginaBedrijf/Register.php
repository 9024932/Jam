<?php
require_once __DIR__ . "/auth.php";
auth_init();

$user = auth_user();
if ($user) {
    auth_redirect("index.php");
}

$sent = (isset($_GET["registered"]) && $_GET["registered"] === "1");
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $name = preg_replace('/\s+/', ' ', $name ?? "");
    $name = substr($name, 0, 40);
    $email = auth_normalize_email((string) ($_POST["email"] ?? ""));
    $password = (string) ($_POST["password"] ?? "");

    if ($name === "" || $email === "" || $password === "") {
        $error = "Vul naam, e-mail en wachtwoord in.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Vul een geldig e-mailadres in.";
    } elseif (strlen($password) < 6) {
        $error = "Wachtwoord moet minimaal 6 tekens zijn.";
    } else {
        $users = auth_read_users();
        if (auth_find_user_by_email($email, $users)) {
            $error = "Dit e-mailadres is al geregistreerd.";
        } else {
            $id = bin2hex(random_bytes(16));
            $newUser = [
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "role" => "user",
                "password_hash" => password_hash($password, PASSWORD_DEFAULT),
                "created_at" => date("c"),
            ];
            $users[] = $newUser;
            auth_write_users($users);

            auth_login($newUser);
            auth_redirect("index.php?registered=1");
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
    <title>Registreren</title>
</head>
<body>
    <?php include "./Navbar.php" ?>

    <div class="auth-wrap">
        <h2 class="auth-title">Registreren</h2>

        <?php if ($sent) { ?>
            <div class="flash flash--success" role="status" aria-live="polite">Registratie gelukt. Je kunt nu inloggen.</div>
        <?php } ?>

        <?php if ($error) { ?>
            <div class="flash flash--error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></div>
        <?php } ?>

        <form class="auth-card" method="post" action="Register.php" novalidate>
            <label class="auth-label" for="name">Naam</label>
            <input class="auth-input" type="text" name="name" id="name" placeholder="Jouw naam" value="<?php echo htmlspecialchars($_POST["name"] ?? "", ENT_QUOTES, "UTF-8"); ?>" required>

            <label class="auth-label" for="email">E-mail</label>
            <input class="auth-input" type="email" name="email" id="email" placeholder="naam@email.com" value="<?php echo htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, "UTF-8"); ?>" required>

            <label class="auth-label" for="password">Wachtwoord</label>
            <input class="auth-input" type="password" name="password" id="password" placeholder="Minimaal 6 tekens" required>

            <button class="auth-btn" type="submit">Registreren</button>
            <p class="auth-hint">Heb je al een account? <a href="Login.php">Inloggen</a></p>
        </form>
    </div>

    <?php include "./Footer.php" ?>
</body>
</html>
