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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" type="text/css" href="style.css">

    </head>
    <style>
    .log_img{
    height: 820px;
    width: 100%;
    margin-top:0px;
    background-image: url('img/b3.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    
}

.box1{
    height: 400px;
    width: 450px;
    background-color: #cfdbe4;
    margin: 90px auto;
    opacity: .9;
    padding: 20px;
    border-radius: 8px;
}
form .login{
    margin: auto 20px ;
}

input{
    height: 40px;
    width: 360px;
}
    </style>
    <body>

        <section>
            <div class="log_img">
                <br><br>
                <div class="box1">
                    <!-- <h1 style="text-align: center; font-size: 30px;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                        Library Management System</h1><br> -->
                    <h1 style="text-align: center;font-size: 30px;">User Login Form</h1><br>
                    
                    <form name="login" action="" method="post">
                        <br>
                        <div class="login">
                            <input class="form-control" type="text" name="email" placeholder="Enter your email" required><br>
                            <input class="form-control" type="password" name="password" placeholder="Enter your password" required><br>

                            <input class="btn btn-primary" type="submit" name="submit" value="Login" style="color: white; width:100%;height: 40px;margin-top: 8px;">
                        </div>
                    


                        <p style="color: black; padding-left: 20px;">
                            <br>
                            <!-- <a style="color: red;font-style: italic; padding-left: 22px;" href="">Forget Password</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp -->
                            New User?<a style="color: blue;text-align: center;" href="registration.php"> Sign Up</a>
                        </p>
                    </form>
                </div>

            </div>
        </section>

        <?php
session_start();
include('connection.php'); // $conn must be defined here

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = md5($password); // match the same way as in index.php

    $query = "SELECT user_name, id FROM reg_student WHERE email='$email' AND password='$hashed_password' ";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['id'] = $row['id'];

        echo "<script>window.location='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>


    </body>
</html>