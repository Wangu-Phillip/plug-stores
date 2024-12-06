<!DOCTYPE html>
<html>

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">

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
                        <a class="nav-link" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
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
    <br><br>

    <!-- SUCCESS/ERROR TOAST -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="toastNotification" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-light">
                <span id="toastIcon" class="me-2"></span>
                <strong id="toastHeading" class="me-auto">Message</strong>
                <small id="toastTime">Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                <!-- Toast Message -->
            </div>
            <div id="toastProgress" class="progress position-relative bottom-0 start-2 w-100" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>


    <!-- VIEW USERS -->
    <section class="container">
        <div class="">
            <div class="row mb-3 d-flex justify-content-end ">
                <div class="col-md-4">
                    <input
                        type="text"
                        class="form-control"
                        id="searchInput"
                        placeholder="Search user by email..."
                        onkeyup="searchUsers(this.value)" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="usersTable">
                        <div class="applications-table border rounded-2">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    <?php

                                    include '../db/config.php';

                                    // Select data from applications table
                                    $sql = "SELECT * FROM users";
                                    $result = $conn->query($sql);

                                    $count = 1;

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $count++ . "</td>";
                                            echo "<td>" . $row["firstname"] . "</td>";
                                            echo "<td>" . $row["lastname"] . "</td>";
                                            echo "<td>" . $row["email"] . "</td>";
                                            echo "<td>" . $row["role"] . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-warning btn-sm' onclick=\"editUser(
                                                    '{$row['id']}', 
                                                    '{$row['firstname']}', 
                                                    '{$row['lastname']}', 
                                                    '{$row['email']}', 
                                                    '{$row['role']}'
                                                )\">Edit</button> ";
                                            echo "<form method='post' action='../validation/delete_users.php' style='display:inline;'>";
                                            echo "<input type='hidden' name='delete' value='" . $row["email"] . "'>";
                                            echo "<input class='btn btn-danger btn-sm' type='submit' value='Delete'>";
                                            echo "</form>";
                                            echo "</td>";

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No results found</td></tr>";
                                    }

                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../validation/update_user.php" method="post">
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="mb-3">
                            <label for="editFirstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <br><br>

    <!-- FOOTER  -->
    <?php include '../components/admin_footer.php'; ?>




    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SEARCH USER FUNCTION -->
    <script>
        // SEARCH USER FUNCTION
        function searchUsers(query) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../validation/search_users.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("userTableBody").innerHTML = this.responseText;
                }
            };

            xhr.send("search=" + query);
        }

        // EDIT USER FUNCTION
        function editUser(id, firstname, lastname, email, role) {
            // Populate the modal fields with the user data
            document.getElementById('editUserId').value = id;
            document.getElementById('editFirstname').value = firstname;
            document.getElementById('editLastname').value = lastname;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;

            // Show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }

        // FUNCTION TO DISPLAY THE TOAST MESSAGE
        function showToast(isSuccess, message, duration = 5000) {
            const toastElement = document.getElementById("toastNotification");
            const toastHeading = document.getElementById("toastHeading");
            const toastMessage = document.getElementById("toastMessage");
            const toastTime = document.getElementById("toastTime");
            const toastIcon = document.getElementById("toastIcon");
            const progressBar = document.querySelector("#toastProgress .progress-bar");

            // Get current time
            const now = new Date();
            const formattedTime = now.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });
            toastTime.textContent = formattedTime;

            // Set Toast content and icon
            if (isSuccess) {
                toastHeading.textContent = "Success";
                toastHeading.classList.remove("text-danger");
                toastHeading.classList.add("text-success");
                toastMessage.textContent = message;

                // Green tick icon for success
                toastIcon.innerHTML = `<i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem;"></i>`;
                progressBar.classList.replace("bg-danger", "bg-success");
            } else {
                toastHeading.textContent = "Error";
                toastHeading.classList.remove("text-success");
                toastHeading.classList.add("text-danger");
                toastMessage.textContent = message;

                // Red X icon for error
                toastIcon.innerHTML = `<i class="bi bi-x-circle-fill text-danger" style="font-size: 1.2rem;"></i>`;
                progressBar.classList.replace("bg-success", "bg-danger");
            }

            // Reset and animate progress bar
            progressBar.style.width = "100%";
            progressBar.style.transition = `width ${duration}ms linear`;
            setTimeout(() => {
                progressBar.style.width = "0%";
            }, 0);

            // Show the Toast
            const toast = new bootstrap.Toast(toastElement, {
                delay: duration,
            });
            toast.show();
        }

        // Trigger Toast if URL contains success or error messages
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("success")) {
            showToast(true, urlParams.get("success"), 5000);
        } else if (urlParams.has("error")) {
            showToast(false, urlParams.get("error"), 5000);
        }
    </script>


</body>

</html>