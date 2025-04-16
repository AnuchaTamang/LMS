
<?php
     include('connection.php');
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Student Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script>

        <link rel="stylesheet" type="text/css" href="style.css">

        <style>
        .reg_img{
    height: 820px;
    width: 100%;
    margin-top:0px;
    background-image: url('img/reg1.jpg');
    background-size: cover;
    background-repeat: no-repeat;
}
.box2{
    height: 585px;
    width: 450px;
    background-color: #cfdbe4;
    margin: 70px auto;
    opacity: .9;
    padding: 20px;
    border-radius: 8px;
}
</style>
    </head>
    <body>


        <section>
            <div class="reg_img">
                <br/><br/>
                <div class="box2">
                    <!-- <h1 style="text-align: center; font-size: 30px;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                        Library Management System</h1><br> -->
                    <h1 style="text-align: center;font-size: 30px;">User Registration Form</h1>
                    
                    <form name="Registration" action="" method="post">
                        <br>
                        <div class="login">

                            <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Enter your fullname" required>
                            <br>
                            <!-- <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Enter your lastname" required>
                            <br> -->
                            <input class="form-control" type="text" id="roll" name="roll" placeholder="Roll No" required="">
                            <br>
                            <input class="form-control" type="text" id="phone" name="contact" placeholder="Enter phonenumber" required="">
                            <br/>
                            <input class="form-control" type="text" id="email" name="email" placeholder="Enter email" required="">
                            <br/>
                            <input class="form-control" type="text" id="user_name" name="user_name" placeholder="Enter your username" required>
                            <br>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Enter your password" required>
                            <br>

                            <input class="btn btn-primary" type="submit" name="submit" value="Sign Up" style="color: white; width:100%;height: 40px; margin-top: 8px;">
                            
                            <p style="color: black; padding-left: 20px;">
                            <br>
                            <!-- <a style="color: red;font-style: italic; padding-left: 22px;" href="">Forget Password</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp -->
                            Already have an account? <a style="color: blue; text-align:center;" href="login.php">Login</a>
                            </p>

                        </div>
                    </form>
                    
                </div>
            </div>
        </section>

        <?php
if (isset($_POST['submit'])) {
    include('connection.php'); // uses $conn

    // Sanitize inputs
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $roll = mysqli_real_escape_string($conn, $_POST['roll']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
    
   
    

    // Check if email already exists
    $check_query = mysqli_query($conn, "SELECT email FROM reg_student WHERE email = '$email'");
    if (mysqli_num_rows($check_query) > 0) {
        echo "<script>alert('Email already registered');</script>";
    } else {
        // Insert user
        $insert_query = "INSERT INTO reg_student (fullname,roll, contact, email,user_name,password) 
                         VALUES ('$fullname','$roll', '$contact', '$email', '$user_name', '$password')";

        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Registration successful');</script>";
        } else {
            echo "<script>alert('Error: Registration failed');</script>";
        }
    }
}
?>


    </body>
</html>