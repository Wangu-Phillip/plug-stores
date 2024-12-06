<?php

@include "config.php";

if (isset($_POST["submit"])) {

    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = md5($_POST["password"]);
    $cpass = md5($_POST["cpassword"]);

    $select = " SELECT * FROM users WHERE email = '{$email}' && password = '{$pass}' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = "User already exists!";
        // echo "<script>alert('Email already exists.')</script>";
    } else {

        if ($pass != $cpass) {
            $error[] = "Password does not match!";
        } else {

            $insert = " INSERT INTO users (firstname, lastname, email, password) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$pass}') ";
            $insert2 = " INSERT INTO users (firstname, lastname, email) VALUES ('{$firstname}', '{$lastname}', '{$email}') ";

            mysqli_query($conn, $insert); // insert data into database
            mysqli_query($conn, $insert2); // insert data into database
            header("Location: login.php"); // redirect to login page
        }
    }
};

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Create Account</title>

    <!-- custom css file link -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">
    <!--Google Fonts-->


</head>

<body>

<!-- NAV BAR START  -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="./assets/shoe1.jpg" alt="Logo" width="30" height="30" class="d-inline-block align-top"> -->
                Sneakers.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Cart</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li> -->
                </ul>
                <div class="d-flex">
                    <a href="register.php"><button class="btn btn-outline-primary me-2 active" type="button">Sign Up</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <!-- REGISTRATION FORM START  -->
    <div class="position-absolute top-50 start-50 translate-middle border rounded-3 shadow-lg col-4">
        <form action="" method="post" class="p-4 rounded-3">
        <h3 class="text-center">CREATE AN ACCOUNT</h3>

            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" name="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Comfirm Password</label>
                <input type="password" name="cpassword" class="form-control" id="password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
    <!-- REGISTRATION FORM END  -->


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>