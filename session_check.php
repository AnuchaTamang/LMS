<?php
session_start();

// 15-minute inactivity timeout
$timeout_duration = 300;


if (!isset($_SESSION['id'])) {
    // User is not logged in
    header("Location: index.php");
    exit();
}

// Session timeout check
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // Inactivity timeout reached
    session_unset();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();
?>
