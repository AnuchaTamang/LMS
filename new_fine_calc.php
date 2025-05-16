<?php
session_start();
$name = $_SESSION['user_name'];
$id = $_SESSION['id'];
include 'connection.php';
if(empty($name))
{
    header("Location: index.php"); 
}

// Fine rate
$fine_per_day =6;

// Fetch issued books where status = 1 (accepted/issued)
$sql = "SELECT issue.id, issue.book_id, issue.user_name, issue.issue_date, issue.due_date, books.book_name 
        FROM tbl_issue AS issue
        JOIN tbl_book AS books ON issue.book_id = books.id
        WHERE issue.status = 1";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fine Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<?php
include('connection.php');
include('include/header.php'); 

?>

<div style="display: flex;">
    <!-- Sidebar -->
    <div style="width: 250px;">
        <?php include('include/side-bar.php'); ?>
    </div>
    <div style="flex-grow: 1; padding: 20px;">

    <h2>Fine Calculation</h2>

<table>
    <thead>
        <tr>
            <th>Issue ID</th>
            <th>Book Title</th>
            <th>User Name</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Days Late</th>
            <th>Fine Amount (Rs)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $today = date('Y-m-d');
                $due_date = $row['due_date'];

                $days_late = (strtotime($today) - strtotime($due_date)) / (60 * 60 * 24);
                $days_late = floor($days_late);

                if ($days_late > 0) {
                    $fine = $days_late * $fine_per_day;
                } else {
                    $days_late = 0;
                    $fine = 0;
                }

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['book_name']}</td>
                        <td>{$row['user_name']}</td>
                        <td>{$row['issue_date']}</td>
                        <td>{$row['due_date']}</td>
                        <td>{$days_late}</td>
                        <td>{$fine}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No issued books found!</td></tr>";
        }
        ?>
    </tbody>
    </div>
    </div>
</table>

</body>
</html>

<?php
$conn->close();
?>
