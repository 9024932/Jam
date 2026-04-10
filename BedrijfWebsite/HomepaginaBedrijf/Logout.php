<?php
require_once __DIR__ . "/auth.php";
auth_init();

auth_logout();
auth_redirect("Login.php?logout=1");
?>