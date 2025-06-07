<?php
session_start();
include('session_check.php'); //Handles login and session timeout

include ('connection.php');

// Ensure user is logged in
if (empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];

// Handle deletion if 'ids' parameter is passed
if (isset($_GET['ids'])) {
    $deleteId = intval($_GET['ids']); // Prevent SQL injection
    $delete_query = mysqli_query($conn, "DELETE FROM tbl_book WHERE id = '$deleteId'");
}
?>

<?php include('include/header.php'); ?>

<div id="wrapper">
    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">View Book</a>
                </li>
            </ol>

            <!-- Card for Book List -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Book Table -->
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Availability</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch all available books
                                $select_query = mysqli_query($conn, "SELECT * FROM tbl_book WHERE availability = 1");
                                $sn = 1;

                                while ($row = mysqli_fetch_array($select_query)) {
                                    $bookId = $row['id'];
                                    ?>
                                    <tr>
                                        <!-- Display book details -->
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                                        <td><?php echo htmlspecialchars($row['isbnno']); ?></td>

                                        <!-- Availability Status -->
                                        <td>
                                            <?php if ($row['availability'] == 1): ?>
                                                <span class="badge badge-success">Available</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Not Available</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Action Buttons Based on Issue Status -->
                                        <td>
                                            <?php
                                            $issue_query = mysqli_query($conn, "SELECT status FROM tbl_issue WHERE user_id = '$ids' AND book_id = '$bookId'");
                                            $issue_status = mysqli_fetch_row($issue_query);
                                            $status = $issue_status[0] ?? null;

                                            if ($status == 1) {
                                                echo '<span class="badge badge-success">Issued</span>';
                                            } elseif ($status == 2) {
                                                echo '<span class="badge badge-danger">Rejected</span>';
                                            } elseif ($status == 3) {
                                                echo '<span class="badge badge-primary">Request Sent</span>';
                                            } else {
                                                ?>
                                                <!-- Issue Buttons -->
                                                <a href="book-issue.php?id=<?php echo $bookId; ?>">
                                                    <button class="btn btn-success btn-sm">Issue</button></a>
                                                
                                                <!-- reserve button  -->
                                                <a href="book-reserve.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mt-1">Reserve</a>

                                                <!-- delete button -->
                                                <!-- <a href="view-book.php?ids=<?php echo $bookId; ?>" onclick="return confirmDelete();">
                                                    <button class="btn btn-danger btn-sm">Delete</button></a> -->

                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Book Table -->
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Container -->
    </div>
    <!-- End Content Wrapper -->
</div>
<!-- End Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include('include/footer.php'); ?>

<!-- Confirm Delete Script -->
<script type="text/javascript">
function confirmDelete() {
    return confirm('Are you sure you want to delete this Book?');
}
</script>