<?php 
session_start();
include('connection.php');

// Check session
if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['user_name'];
$book_id = $_GET['id'];

$reserve_date = date("Y-m-d");
$expire_date = date("Y-m-d", strtotime("+7 days"));

// Check if already reserved (pending or approved)
$check = mysqli_query($conn, "SELECT * FROM tbl_reserve WHERE user_id='$user_id' AND book_id='$book_id' AND status IN (0,1)");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('You have already reserved this book.'); window.location.href='book.php';</script>";
    exit();
}

// Insert reservation
$insert_reserve = mysqli_query($conn, "INSERT INTO tbl_reserve 
    (book_id, user_id, user_name, reserve_date, expire_date, status) 
    VALUES ('$book_id', '$user_id', '$user_name', '$reserve_date', '$expire_date', 0)");

if ($insert_reserve) {
    $message = "Your book reservation request is pending admin approval.";
    $message_escaped = mysqli_real_escape_string($conn, $message);
    mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message_escaped')");

    echo "<script>alert('Book reserved successfully. Admin will review your request.'); window.location.href='book.php';</script>";
} else {
    echo "<script>alert('Reservation failed.'); window.location.href='book.php';</script>";
}
?>
