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
if(isset($_REQUEST['sbt-usr']))
{
  $fullname = $_POST['fullname'];
  $roll = $_POST['roll'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
	$user_name = $_POST['user_name']; 
  $pwd = md5($_POST['pwd']);


  $insert_user = mysqli_query($conn,"insert into reg_student set fullname='$fullname',roll='$roll',contact='$contact', email='$email', user_name='$user_name',password='$pwd'");

    if($insert_user > 0)
    {
        ?>
<script type="text/javascript">
    alert("User added successfully.")
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
            <a href="#">Add User</a>
          </li>
          
        </ol>

  <div class="card mb-3">
          <!-- <div class="card-header">
            <i class="fa fa-info-circle"></i>
            Submit Details</div> -->
             
            <form method="post" class="form-valide">
          <div class="card-body">
                                  
                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Full Name <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                          <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Full Name" required>
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Roll NO <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                          <input type="text" name="roll" id="roll" class="form-control" placeholder="Enter Roll Number" required>
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Contact No. <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                          <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter Contact Number" required>
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">EmailId <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="email" name="email" id="emailid" class="form-control" placeholder="Enter EmailId" required>
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">User Name <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                          <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" required>
                                       </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-lg-4 col-form-label" for="remarks">Password <span class="text-danger">*</span></label>
                                       <div class="col-lg-6">
                                      <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Enter Password" required>
                                       </div>
                                  </div>
                                  
                           
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" name="sbt-usr" class="btn btn-primary">Submit</button>
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