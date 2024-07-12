<?php
session_start();

include("connection/connect2.php");
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "INSERT INTO register (username, email, password) VALUES ('$username', '$email', '$password')";
        
        $result = mysqli_query($con, $query);
        
        if ($result) {
            echo "<script type='text/javascript'> alert ('Successfully Registered')</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
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
</head>

<style>
    body {
        background-image: url("images/food.jpg");
        background-size: cover;
        background-position: center;
    }
</style>

<body>
   
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-50 p-50 bg-white shadow box-area">
        <div class="col-md-12 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Sign Up</h2>
                    </div>
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="username" name="user">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="email" name="email">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="password" name="pass">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>I agree to the terms and conditions</small></label>
                            </div>
                        </div>
                        <div class="input-group mt-3 mb-3">
                            <button class="btn btn-lg btn-success btn-primary w-100 fs-6">Register</button>
                        </div>
                        <div class="row">
                            <small>Already have an account? <a href="login.php">Sign In</a></small>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>   
</body>
</html>