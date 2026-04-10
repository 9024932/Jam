<?php
require_once __DIR__ . "/auth.php";
auth_init();

// Controleer of gebruiker ingelogd is
auth_require_login();

$user = auth_user();
$userId = $user["id"] ?? null;

// Haal volledige gebruikersinformatie op
$allUsers = auth_read_users();
$fullUser = auth_find_user_by_id($userId, $allUsers);

if (!$fullUser) {
    auth_redirect("index.php");
}

$error = null;
$success = null;
$formMode = "view"; // view of edit

// Controleer welke actie wordt uitgevoerd
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? null;
    $csrf = $_POST["_csrf"] ?? null;
    
    // Valideer CSRF token
    if (!auth_csrf_validate($csrf)) {
        $error = "Sessie-fout. Probeer het opnieuw.";
    } elseif ($action === "update") {
        $name = trim((string) ($_POST["name"] ?? ""));
        $email = trim((string) ($_POST["email"] ?? ""));
        
        // Validatie
        if (empty($name)) {
            $error = "Naam mag niet leeg zijn.";
        } elseif (empty($email)) {
            $error = "E-mail mag niet leeg zijn.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Ongeldig e-mailadres.";
        } else {
            // Controleer of e-mail niet al in gebruik is (door ander account)
            $normalizedEmail = auth_normalize_email($email);
            $emailExists = false;
            
            foreach ($allUsers as $checkUser) {
                $checkEmail = auth_normalize_email((string) ($checkUser["email"] ?? ""));
                if ($checkEmail === $normalizedEmail && $checkUser["id"] !== $userId) {
                    $emailExists = true;
                    break;
                }
            }
            
            if ($emailExists) {
                $error = "Dit e-mailadres is al in gebruik.";
            } else {
                $updates = [
                    "name" => $name,
                    "email" => $normalizedEmail
                ];
                
                if (auth_update_user($userId, $updates)) {
                    $success = "Profiel bijgewerkt!";
                    // Haal de huidige gegevens opnieuw op
                    $user = auth_user();
                    $fullUser = auth_find_user_by_id($userId, auth_read_users());
                } else {
                    $error = "Fout bij het bijwerken van profiel.";
                }
            }
        }
    } elseif ($action === "change_password") {
        $currentPassword = (string) ($_POST["current_password"] ?? "");
        $newPassword = (string) ($_POST["new_password"] ?? "");
        $confirmPassword = (string) ($_POST["confirm_password"] ?? "");
        
        // Validatie
        if (empty($currentPassword)) {
            $error = "Voer het huidige wachtwoord in.";
        } elseif (empty($newPassword)) {
            $error = "Voer een nieuw wachtwoord in.";
        } elseif (strlen($newPassword) < 6) {
            $error = "Wachtwoord moet minstens 6 tekens zijn.";
        } elseif ($newPassword !== $confirmPassword) {
            $error = "Wachtwoorden komen niet overeen.";
        } elseif (!password_verify($currentPassword, $fullUser["password_hash"] ?? "")) {
            $error = "Huidige wachtwoord is onjuist.";
        } else {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            if (auth_update_user($userId, ["password_hash" => $newHash])) {
                $success = "Wachtwoord gewijzigd!";
                $fullUser = auth_find_user_by_id($userId, auth_read_users());
            } else {
                $error = "Fout bij het wijzigen van wachtwoord.";
            }
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
    <title>Mijn profiel</title>
</head>
<body>
    <nav class="navbar">
        <?php include __DIR__ . "/Navbar.php"; ?>
    </nav>

    <main class="profile-container">
        <div class="profile-card">
            <h1 class="h1p">Mijn profiel</h1>

            <?php if ($error) { ?>
                <div class="flash flash--error" role="alert">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
                </div>
            <?php } ?>

            <?php if ($success) { ?>
                <div class="flash flash--success" role="status" aria-live="polite">
                    <?php echo htmlspecialchars($success, ENT_QUOTES, "UTF-8"); ?>
                </div>
            <?php } ?>

            <!-- Sectie: Persoonlijke gegevens -->
            <div class="profile-section">
                <h2>Persoonlijke gegevens</h2>
                <form method="POST" class="profile-form">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="_csrf" value="<?php echo auth_csrf_token(); ?>">

                    <div class="form-group">
                        <label for="name">Naam:</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="<?php echo htmlspecialchars($fullUser["name"] ?? "", ENT_QUOTES, "UTF-8"); ?>" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($fullUser["email"] ?? "", ENT_QUOTES, "UTF-8"); ?>" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn--primary">Gegevens opslaan</button>
                </form>
            </div>

            <!-- Sectie: Wachtwoord wijzigen -->
            <div class="profile-section">
                <h2>Wachtwoord wijzigen</h2>
                <form method="POST" class="profile-form">
                    <input type="hidden" name="action" value="change_password">
                    <input type="hidden" name="_csrf" value="<?php echo auth_csrf_token(); ?>">

                    <div class="form-group">
                        <label for="current_password">Huidig wachtwoord:</label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nieuw wachtwoord:</label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Bevestig wachtwoord:</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn--primary">Wachtwoord wijzigen</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php include __DIR__ . "/Footer.php"; ?>
    </footer>
</body>
</html>
