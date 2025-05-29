<?php
session_start();
//include('session_check.php');  // This file handles session validation and redirects if needed
include('connection.php');

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    // Redirect to student login page if not logged in
    header("Location: index.php");
    exit();
}

$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
?>

<?php include('include/header.php'); ?>
<div id="wrapper">

  <?php include('include/side-bar.php'); ?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">View Book</a>
        </li>

      </ol>

      <div class="card mb-3">
        <!-- <div class="card-header">
            <i class="fa fa-info-circle"></i>
            View Book Details
          </div> -->

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  <th>Issue Date</th>
                  <th>Due Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select_query = mysqli_query($conn, "SELECT tbl_issue.book_id, tbl_book.book_name, tbl_book.category, tbl_issue.issue_date, tbl_issue.due_date FROM tbl_issue INNER JOIN tbl_book ON tbl_issue.book_id=tbl_book.id WHERE tbl_issue.user_id='$ids' AND tbl_issue.status=1");
                $sn = 1;
                while ($row = mysqli_fetch_array($select_query)) {
                  ?>
                  <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['issue_date']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td><a href="book-return.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-success">Return</button></a></td>
                  </tr>
                  <?php $sn++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php include('include/footer.php'); ?>
