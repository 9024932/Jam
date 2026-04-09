<?php

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
    $_SESSION["user"] = [
        "id" => $user["id"] ?? null,
        "name" => $user["name"] ?? "",
        "email" => $user["email"] ?? "",
    ];
}

function auth_logout(): void
{
    auth_init();
    session_unset();
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        // Probeer op meerdere paden te verwijderen (handig bij subfolder-projects zoals /Jam/...).
        setcookie(session_name(), "", time() - 42000, "/");
        setcookie(
            session_name(),
            "",
            time() - 42000,
            $params["path"] ?? "/",
            $params["domain"] ?? "",
            (bool) ($params["secure"] ?? false),
            (bool) ($params["httponly"] ?? true)
        );
    }

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
