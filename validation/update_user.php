<!-- update_user.php -->
<?php
@include "../db/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', role = '$role' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/manage_users.php?success=User details updated successfully.");
        exit();
    } else {
        header("Location: ../admin/manage_users.php?error=Error updating user: " . mysqli_error($conn));
        exit();
    }

    mysqli_close($conn);
}
?>