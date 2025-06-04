<?php
session_start();
include('admin_session_check.php');
include ('../connection.php');
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
        <li class="breadcrumb-item">
          <a href="#">View Category</a>
        </li>
      </ol>

      <!-- Search Form -->
      <form method="GET" action="view-category.php" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search category name"
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
                  <th>Category Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($_GET['ids'])){
                    $id = $_GET['ids'];
                    mysqli_query($conn, "DELETE FROM tbl_category WHERE id='$id'");
                }

                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                $cacheKey = 'cache/category_' . md5($search) . '.json';
                $results = [];

                // Use cache if exists
                if (!empty($search) && file_exists($cacheKey) && time() - filemtime($cacheKey) < 300) {
                    $results = json_decode(file_get_contents($cacheKey), true);
                } else {
                    $sql = "SELECT * FROM tbl_category";
                    if (!empty($search)) {
                        $sql .= " WHERE category_name LIKE '%$search%'";
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
                  <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                  <td>
                    <?php if($row['status'] == 1): ?>
                      <span class="badge badge-success">Active</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="edit-category.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    <a href="view-category.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                  </td>
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

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<?php include('include/footer.php'); ?>

<script>
function confirmDelete(){
    return confirm('Are you sure want to delete this Category?');
}
</script>
