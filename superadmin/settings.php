<?php
// Include database connection
@include "../db/config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login.php");
    // exit;
}

// Handle Create/Update/Delete requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === "create" || $action === "update") {
        $hero_heading = mysqli_real_escape_string($conn, $_POST['hero_heading']);
        $slogan = mysqli_real_escape_string($conn, $_POST['slogan']);
        $btn_text = mysqli_real_escape_string($conn, $_POST['btn_text']);
        $image = '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_name = basename($_FILES['image']['name']);
            $target_dir = "../uploads/";
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $target_file;
            }
        }

        if ($action === "create") {
            $sql = "INSERT INTO hero_section (hero_heading, slogan, btn_text, image) VALUES ('$hero_heading', '$slogan', '$btn_text', '$image')";
        } elseif ($action === "update" && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $sql = "UPDATE hero_section SET hero_heading='$hero_heading', slogan='$slogan', btn_text='$btn_text'" . ($image ? ", image='$image'" : "") . " WHERE id=$id";
        }

        if ($conn->query($sql)) {
            $success_message = $action === "create" ? "Hero section created successfully!" : "Hero section updated successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }

    if ($action === "delete" && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM hero_section WHERE id=$id";

        if ($conn->query($sql)) {
            $success_message = "Hero section deleted successfully!";
        } else {
            $error_message = "Error deleting hero section: " . $conn->error;
        }
    }
}

// Fetch all records from the hero_section table
$sql = "SELECT * FROM hero_section";
$result = $conn->query($sql);
$hero_sections = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plug Stores</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">

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
                        <a class="nav-link" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_stores.php">Stores</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="settings.php">Settings</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <!-- <a href="login.php"><button class="btn btn-outline-primary me-2" type="button">Login</button> </a> -->
                    <a href="../logout.php"><button class="btn btn-outline-primary me-2" type="button">Logout</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <div class="container mt-5">
        <h1 class="text-center">Manage Hero Section</h1>

        <!-- Success/Error Messages -->
        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Tabs for Records and Form -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="records-tab" data-bs-toggle="tab" data-bs-target="#records" type="button" role="tab" aria-controls="records" aria-selected="true">Hero Section Records</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab" aria-controls="form" aria-selected="false">Create/Update Hero Section</button>
            </li>
        </ul>
        <div class="tab-content mt-4" id="myTabContent">
            <!-- Hero Section Records Tab -->
            <div class="tab-pane fade show active" id="records" role="tabpanel" aria-labelledby="records-tab">
                <div class="row">
                    <?php if (count($hero_sections) > 0) : ?>
                        <?php foreach ($hero_sections as $hero) : ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <?php if ($hero['image']) : ?>
                                        <img src="<?php echo $hero['image']; ?>" class="card-img-top product-image" alt="Hero Image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $hero['hero_heading']; ?></h5>
                                        <p class="card-text"><?php echo $hero['slogan']; ?></p>
                                        <p class="card-text"><strong>Button Text:</strong> <?php echo $hero['btn_text']; ?></p>
                                        <form method="POST" action="settings.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $hero['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No records found. Please add a new hero section.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Create/Update Hero Section Tab -->
            <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                <div class="card">
                    <div class="card-header">Create or Update Hero Section</div>
                    <div class="card-body">
                        <form method="POST" action="settings.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="hero_heading" class="form-label">Hero Heading</label>
                                <input type="text" class="form-control" id="hero_heading" name="hero_heading" required>
                            </div>
                            <div class="mb-3">
                                <label for="slogan" class="form-label">Slogan</label>
                                <textarea class="form-control" id="slogan" name="slogan" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="btn_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="btn_text" name="btn_text" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <input type="hidden" name="action" value="create">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER  -->
    <?php include '../components/admin_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
