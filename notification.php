<?php
session_start();
include('connection.php');

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Optional -->
</head>
<body>

<div class="container mt-5">
    <h2>Your Notifications</h2>

    <?php
    // Fetch notifications for this user
    $query = "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0): ?>
        <ul class="list-group mt-3">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li class="list-group-item <?php echo $row['is_read'] ? '' : 'list-group-item-warning'; ?>">
                    <?php echo htmlspecialchars($row['message']); ?>
                    <small class="text-muted d-block"><?php echo $row['created_at']; ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info mt-3">You have no notifications.</div>
    <?php endif; ?>

</div>

</body>
</html>
