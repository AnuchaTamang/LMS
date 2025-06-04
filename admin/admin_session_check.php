<?php
session_start();

if (!isset($_SESSION['id'])) {
    // Not logged in, redirect to admin login
    header("Location: login.php");
    exit();
}
?>
