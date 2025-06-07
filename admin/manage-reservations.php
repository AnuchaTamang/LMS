<?php
session_start();
include('../connection.php');

// Check if admin is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    $_SESSION['id'] = $admin_id;
    $_SESSION['user_name'] = $admin_username;
    $_SESSION['role'] = 'admin'; 

    print_r($_SESSION);
    exit();
}

// Handle approve request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_id'])) {
    $reservation_id = $_POST['approve_id'];

    // Get reservation details
    $res_query = mysqli_query($conn, "SELECT * FROM tbl_reserve WHERE id = '$reservation_id'");
    $reservation = mysqli_fetch_assoc($res_query);

    if ($reservation) {
        $user_id = $reservation['user_id'];
        $book_id = $reservation['book_id'];

        // Update status to approved (1)
        mysqli_query($conn, "UPDATE tbl_reserve SET status = 1 WHERE id = '$reservation_id'");

        // Add notification
        $message = "Your reservation for Book ID $book_id has been approved.";
        $msg = mysqli_real_escape_string($conn, $message);
        mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$msg')");

        echo "<script>alert('Reservation approved successfully.'); window.location.href='manage-reservations.php';</script>";
        exit();
    }
}

// Fetch all pending reservations
$query = "
    SELECT r.id, r.user_name, r.reserve_date, r.expire_date, book_name 
    FROM tbl_reserve r
    JOIN tbl_book b ON r.book_id = book_id
    WHERE r.status = 0
    ORDER BY r.reserve_date ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Book Reservations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        button {
            padding: 5px 10px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>

    <h2>Pending Book Reservation Requests</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Student Name</th>
                    <th>Reserve Date</th>
                    <th>Expire Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo $row['reserve_date']; ?></td>
                        <td><?php echo $row['expire_date']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="approve_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Approve this reservation?')">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending reservations found.</p>
    <?php endif; ?>

</body>

</html>