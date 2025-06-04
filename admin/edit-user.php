<?php
session_start();
include('admin_session_check.php');
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}
$id = $_GET['id'];
$fetch_query = mysqli_query($conn, "select * from reg_student where id='$id'");
$row = mysqli_fetch_array($fetch_query);
if(isset($_REQUEST['sv-user']))
{
  $roll=$_POST['roll'];
  $contact=$_POST['contact'];
	$user_name = $_POST['user_name'];
  $email = $_POST['email'];
  // $role = $_POST['role'];
  // $status = $_POST['status'];

  $update_user = mysqli_query($conn,"update reg_student set roll='$roll', contact='$contact', user_name='$user_name', email='$email' where id='$id'");

    if($update_user > 0)
    {
        ?>
<script type="text/javascript">
    alert("User Updated successfully.");
    window.location.href='view-users.php';
</script>
<?php
}
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
            <a href="#">Edit User Details</a>
          </li>
          
        </ol>

  <div class="card mb-3">
          <!-- <div class="card-header">
            <i class="fa fa-info-circle"></i>
            Edit Details</div> -->
             
            <form method="post" class="form-valide">
          <div class="card-body">
                                      
                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">User Name <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" required value="<?php echo $row['user_name']; ?>">
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Roll No <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="text" name="roll" id="roll" class="form-control" placeholder="Enter Roll Number" required value="<?php echo $row['roll']; ?>">
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Contact <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter Contact Number" required value="<?php echo $row['contact']; ?>">
                                       </div>
                                  </div>


                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">EmailId <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="email" name="email" id="email" class="form-control" placeholder="Enter EmailId" required value="<?php echo $row['email']; ?>">
                                       </div>
                                  </div>

                                      <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" name="sv-user" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    
                                </div>
                                </form>
                            </div>
                        
    </div>
         
        </div>
     
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
 
 <?php include('include/footer.php'); ?>