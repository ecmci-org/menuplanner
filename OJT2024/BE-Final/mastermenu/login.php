<?php
include("connection/connect2.php"); 
error_reporting(0); 
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {   
    $email = $_POST['email'];
    $password = $_POST['pass'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "SELECT * FROM register WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] == $password) {
                    header("location: index.php");
                    die;
                }
            }
        }
        echo "<script type='text/javascript'>alert('Invalid login attempt.');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Invalid login attempt.');</script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <title>Menu Master</title>
    <style>
        body {
            background-image: url("images/food.jpg");
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-50 p-50 bg-white shadow box-area">
            <div class="col-md-12 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-3">
                        <h2>Welcome to Menu Master</h2>
                    </div>
                    <form method="POST">
                        <div class="email">
                            <input type="email" class="form-control form-control-lg mb-2 bg-light fs-6" placeholder="email" name="email">
                        </div>
                        <div class="pass">
                            <input type="pass" class="form-control form-control-lg bg-light fs-6" placeholder="password" name="pass">
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-between custom-margin">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-success btn-secondary w-100 fs-6">Login</button>
                        </div>
                        <div class="row">
                            <small>Don't have account? <a href="register.php">Sign Up</a></small>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    
</body>
</html>
