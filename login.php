<?php

@include "./db/config.php";

session_start();

if (isset($_POST["submit"])) {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = md5($_POST["password"]);


    $select = " SELECT * FROM users WHERE email = '{$email}' && password = '{$pass}' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        if ($row["role"] == "admin") {

            $_SESSION["admin_name"] = $row["firstname"];
            $_SESSION["admin_surname"] = $row["lastname"];
            $_SESSION["admin_email"] = $row["email"];
            $_SESSION["admin_id"] = $row["id"];

            header("Location: ./superadmin/admin.php");
        } elseif ($row["role"] == "manager") {

            $_SESSION["manager_surname"] = $row["lastname"];
            $_SESSION["manager_name"] = $row["firstname"];
            $_SESSION["manager_email"] = $row["email"];
            $_SESSION["manager_id"] = $row["id"];

            header("Location: ./admin/admin.php");
        } elseif ($row["role"] == "customer") {

            $_SESSION["customer_surname"] = $row["lastname"];
            $_SESSION["customer_name"] = $row["firstname"];
            $_SESSION["customer_email"] = $row["email"];
            $_SESSION["customer_id"] = $row["id"];

            header("Location: ./shop/customer.php");
        }
    } else {
        $error[] = "Incorrect email or Password!";
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
    <title>Login Form</title>

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
                Plug Stores
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
                        <a class="nav-link" href="stores.php">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php"><button class="btn btn-outline-primary me-2" type="button">Sign In</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <!-- LOGIN FORM START  -->
    <div class="form-container">
        <form action="" method="post" class="position-absolute top-50 start-50 translate-middle border p-4 rounded-3 shadow-lg col-3">
            <h3 class="text-center">Login</h3>

            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <button type="submit" name="submit" value="Login" class="btn btn-primary">Login</button>
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>
    </div>
    <!-- LOGIN FORM END  -->


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>