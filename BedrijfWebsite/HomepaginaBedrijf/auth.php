<?php
// ================================
// Auth systeem: login, logout, sessie
// ================================

function auth_init(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function auth_users_file(): string
{
    return __DIR__ . DIRECTORY_SEPARATOR . "users.json";
}

function auth_read_users(): array
{
    $file = auth_users_file();
    if (!is_file($file)) {
        return [];
    }
    $decoded = json_decode((string) file_get_contents($file), true);
    return is_array($decoded) ? $decoded : [];
}

function auth_write_users(array $users): void
{
    file_put_contents(
        auth_users_file(),
        json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        LOCK_EX
    );
}

function auth_user(): ?array
{
    auth_init();
    $user = $_SESSION["user"] ?? null;
    return is_array($user) ? $user : null;
}

function auth_login(array $user): void
{
    auth_init();
    // Creëer een nieuwe sessie-ID om session fixation te voorkomen
    session_regenerate_id(true);

    $_SESSION["user"] = [
        "id" => $user["id"] ?? null,
        "name" => $user["name"] ?? "",
        "email" => $user["email"] ?? "",
        "role" => $user["role"] ?? "user",
    ];
}

function auth_logout(): void
{
    auth_init();

    // Verwijder alle sessievariabelen
    $_SESSION = [];
    session_unset();

    // Verwijder de session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"] ?? '/',
            $params["domain"] ?? '',
            $params["secure"] ?? false,
            $params["httponly"] ?? true
        );
    }

    // Vernietig de sessie
    session_destroy();
}

function auth_normalize_email(string $email): string
{
    return strtolower(trim($email));
}

function auth_find_user_by_email(string $email, array $users): ?array
{
    $needle = auth_normalize_email($email);
    foreach ($users as $user) {
        $uEmail = auth_normalize_email((string) ($user["email"] ?? ""));
        if ($uEmail === $needle) {
            return is_array($user) ? $user : null;
        }
    }
    return null;
}

function auth_redirect(string $path): void
{
    header("Location: " . $path);
    exit;
}

// Optioneel: helper voor beveiligde pagina's
function auth_require_login(): void
{
    if (!auth_user()) {
        auth_redirect("Login.php");
    }
}

function auth_is_admin(?array $user = null): bool
{
    $u = $user ?? auth_user();
    if (!$u) {
        return false;
    }
    return (string) ($u["role"] ?? "") === "admin";
}

function auth_csrf_token(): string
{
    auth_init();
    if (!isset($_SESSION["_csrf"]) || !is_string($_SESSION["_csrf"]) || $_SESSION["_csrf"] === "") {
        $_SESSION["_csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["_csrf"];
}

function auth_csrf_validate(?string $token): bool
{
    auth_init();
    $sessionToken = $_SESSION["_csrf"] ?? "";
    if (!is_string($sessionToken) || $sessionToken === "" || !is_string($token) || $token === "") {
        return false;
    }
    return hash_equals($sessionToken, $token);
}
?>
