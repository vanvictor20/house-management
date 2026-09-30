<?php
/*
 * Guard for admin action handlers: only a logged-in admin may run them.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['email'])) {
    // handlers live in admin/functions/, a few in admin/ itself
    $inFunctions = basename(dirname($_SERVER['SCRIPT_NAME'])) === 'functions';
    header('Location: ' . ($inFunctions ? '../login.php' : 'login.php'));
    exit;
}
