<?php
session_start();
include('connection.php');

$fine_per_day = 10; // Set your fine rate here

$query = "SELECT i.*, b.title, s.fullname 
          FROM tbl_issue i 
          JOIN tbl_book b ON i.book_id = b.id 
          JOIN reg_student s ON i.student_id = s.id";

$result = mysqli_query($conn, $query);
?>

<?php include('include/header.php'); ?>
<div id="wrapper">
<?php include('include/side-bar.php'); ?>

<div id="content-wrapper">
  <div class="container-fluid">
    <h3>Fine Calculation</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Book Title</th>
          <th>Issue Date</th>
          <th>Due Date</th>
          <th>Return Date</th>
          <th>Status</th>
          <th>Fine</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $due_date = new DateTime($row['due_date']);
            $today = new DateTime();
            $fine = 0;
            $status = $row['status'];

            if ($status == 1 && !empty($row['return_date'])) {
                $return_date = new DateTime($row['return_date']);
                if ($return_date > $due_date) {
                    $interval = $due_date->diff($return_date)->days;
                    $fine = $interval * $fine_per_day;
                }
            } else {
                if ($today > $due_date) {
                    $interval = $due_date->diff($today)->days;
                    $fine = $interval * $fine_per_day;
                }
            }
        ?>
        <tr>
          <td><?php echo $row['fullname']; ?></td>
          <td><?php echo $row['title']; ?></td>
          <td><?php echo $row['issue_date']; ?></td>
          <td><?php echo $row['due_date']; ?></td>
          <td><?php echo $row['return_date'] ?? 'Not Returned'; ?></td>
          <td><?php echo $status == 1 ? 'Returned' : 'Pending'; ?></td>
          <td><strong><?php echo $fine > 0 ? "Rs $fine" : "No Fine"; ?></strong></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?php include('include/footer.php'); ?>
