<?php
include('session_check.php'); //Handles login and session timeout
include('connection.php');

$name = $_SESSION['user_name'];
$id = $_SESSION['id'];

$select_book = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_book WHERE availability=1");
$total_book = mysqli_fetch_row($select_book);

$issued_book = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_issue WHERE user_id='$id' AND status=1");
$issued_book = mysqli_fetch_row($issued_book);

$fine_per_day = 10;
$total_fine = 0;

$fetch_issues = mysqli_query($conn, "SELECT due_date FROM tbl_issue WHERE user_id='$id' AND status=1");

$today = date('Y-m-d');
while ($row = mysqli_fetch_assoc($fetch_issues)) {
    $due_date = $row['due_date'];
    $due = new DateTime($due_date);
    $now = new DateTime($today);

    if ($now > $due) {
        $diff = $due->diff($now)->days;
        $total_fine += $diff * $fine_per_day;
    }
}

include('include/header.php'); 
?>

<div id="wrapper">

    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <h4>Dashboard</h4>

            <div class="row">

                <div class="col-sm-4">
                    <section class="panel panel-featured-left panel-featured-primary">
                        <div class="panel-body total">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fa fa-book"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Books</h4>
                                        <div class="info">
                                            <strong class="amount"><?php echo $total_book[0]; ?></strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-sm-4">
                    <section class="panel panel-featured-left panel-featured-primary">
                        <div class="panel-body issued">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fa fa-book"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Book Issued</h4>
                                        <div class="info">
                                            <strong class="amount"><?php echo $issued_book[0]; ?></strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-sm-4">
                    <section class="panel panel-featured-left panel-featured-primary">
                        <div class="panel-body total">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fa fa-book"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Fine</h4>
                                        <div class="info">
                                            <strong class="amount"><?php echo $total_fine; ?></strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>

        </div>

    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include('include/footer.php'); ?>
