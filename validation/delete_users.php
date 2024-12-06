<!-- delete_users.php -->

<?php

session_start();

if (!isset($_SESSION["admin_name"])) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    include "../db/config.php";

    $email = mysqli_real_escape_string($conn, $_POST["delete"]);

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin/manage_users.php?success=User with email $email deleted successfully.");
    } else {
        $error_message = $conn->error;
        header("Location: ../admin/manage_users.php?error=Error deleting user: $error_message");
    }

    // Close the database connection
    $conn->close();
    exit;
} else {
    header("Location: ../admin/manage_users.php");
    exit;
}
?>