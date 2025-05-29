<?php
session_start();
include('session_check.php');

include('connection.php');  // Adjust path if needed

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please login to reserve books.'); window.location='index.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$book_id = $_POST['book_id'] ?? null;

if (!$book_id) {
    echo "<script>alert('Invalid book selection.'); window.location='view-book.php';</script>";
    exit();
}

// Check if the book exists and is available (quantity > 0)
$check_book = mysqli_query($conn, "SELECT quantity FROM tbl_book WHERE id = '$book_id'");
if (mysqli_num_rows($check_book) == 0) {
    echo "<script>alert('Book not found.'); window.location='view-book.php';</script>";
    exit();
}

$book = mysqli_fetch_assoc($check_book);
if ($book['quantity'] < 1) {
    echo "<script>alert('Sorry, this book is currently not available.'); window.location='view-book.php';</script>";
    exit();
}

// Check if user already reserved this book and status is 'reserved'
$check_reservation = mysqli_query($conn, "SELECT * FROM reservations WHERE user_id = '$user_id' AND book_id = '$book_id' AND status = 'reserved'");
if (mysqli_num_rows($check_reservation) > 0) {
    echo "<script>alert('You have already reserved this book.'); window.location='view-book.php';</script>";
    exit();
}

// Insert reservation
$insert = mysqli_query($conn, "INSERT INTO reservations (user_id, book_id, status) VALUES ('$user_id', '$book_id', 'reserved')");

// Reduce the quantity by 1 in tbl_book
$update = mysqli_query($conn, "UPDATE tbl_book SET quantity = quantity - 1 WHERE id = '$book_id'");

if ($insert && $update) {
    echo "<script>alert('Book reserved successfully!'); window.location='view-book.php';</script>";
} else {
    echo "<script>alert('Failed to reserve the book. Please try again.'); window.location='view-book.php';</script>";
}
?>
