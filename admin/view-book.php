<?php
session_start();
include('admin_session_check.php');
include ('../connection.php');

// Safely retrieve session values
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id)) {
    header("Location: index.php"); 
}
?>

<?php include('include/header.php'); ?>
<div id="wrapper">
  <?php include('include/side-bar.php'); ?>

  <div id="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">View Book</a></li>
      </ol>

      <!-- Search Bar -->
      <form method="GET" action="view-book.php" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search book, author, category, publisher"
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>

      <div class="card mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Book No</th>
                  <th>Author</th>
                  <th>Publisher</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Delete book if needed
                if(isset($_GET['ids'])) {
                    $id = $_GET['ids'];
                    mysqli_query($conn, "DELETE FROM tbl_book WHERE id='$id'");
                }

                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                $cacheKey = 'cache/book_' . md5($search) . '.json';
                $results = [];

                // Use cached result if valid
                if (!empty($search) && file_exists($cacheKey) && time() - filemtime($cacheKey) < 300) {
                    $results = json_decode(file_get_contents($cacheKey), true);
                } else {
                    $sql = "SELECT * FROM tbl_book";
                    if (!empty($search)) {
                        $sql .= " WHERE book_name LIKE '%$search%' 
                                  OR author LIKE '%$search%'
                                  OR publisher LIKE '%$search%'
                                  OR category LIKE '%$search%'";
                    }
                    $query = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($query)) {
                        $results[] = $row;
                    }
                    if (!file_exists('cache')) mkdir('cache');
                    if (!empty($search)) {
                        file_put_contents($cacheKey, json_encode($results));
                    }
                }

                $sn = 1;
                foreach ($results as $row) {
                ?>
                <tr>
                  <td><?php echo $sn++; ?></td>
                  <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                  <td><?php echo htmlspecialchars($row['category']); ?></td>
                  <td><?php echo htmlspecialchars($row['isbnno']); ?></td>
                  <td><?php echo htmlspecialchars($row['author']); ?></td>
                  <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                  <td><?php echo htmlspecialchars($row['price']); ?></td>
                  <td><?php echo htmlspecialchars($row['quantity']); ?></td>

                  <?php if ($row['availability'] == 1): ?>
                    <td><span class="badge badge-success">Available</span></td>
                    <td>
                      <a href="edit-book.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a href="view-book.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </td>
                  <?php else: ?>
                    <td><span class="badge badge-danger">Not Available</span></td>
                    <td>
                      <a href="edit-book.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a href="view-book.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </td>
                  <?php endif; ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>                   
      </div>
    </div>
  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<?php include('include/footer.php'); ?>

<script>
function confirmDelete(){
    return confirm('Are you sure want to delete this Book?');
}
</script>
