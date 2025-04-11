<?php
session_start();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    header("Location: ../admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow w-50 mx-auto">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Add New User</h4>

            <div id="alertBox"></div>

            <form id="addUserForm">
                <div class="mb-3">
                    <label for="fname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fname" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="users.php" class="btn btn-secondary btn-sm">Back to User List</a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("addUserForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const fname = document.getElementById("fname").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    fetch("api/add_user_api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({ fname, username, password })
    })
    .then(res => res.json())
    .then(data => {
        const alertBox = document.getElementById("alertBox");
        if (data.status === "success") {
            alertBox.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            document.getElementById("addUserForm").reset();
        } else {
            alertBox.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(err => {
        console.error(err);
        alert("Lỗi khi gọi API");
    });
});
</script>

</body>
</html>
