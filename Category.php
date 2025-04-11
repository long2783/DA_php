<?php 
session_start();
include_once("db_conn.php");
include_once("admin/data/Category.php");

$category = null;
$categories = [];


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = getById($conn, $id);
} else {
    $categories = getAll($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog | Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "inc/NavBar.php"; ?>

<div class="container mt-5">
    <?php if ($category): ?>
        <h3 class="mb-4">Category Detail</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($category['id']) ?></td>
            </tr>
            <tr>
                <th>Category Name</th>
                <td><?= htmlspecialchars($category['category']) ?></td>
            </tr>
        </table>
        <a href="category.php" class="btn btn-secondary">Back to All</a>
    <?php else: ?>
        <h3 class="mb-4">All Categories</h3>
        <?php if (!empty($categories)): ?>
            <ul class="list-group">
                <?php foreach ($categories as $cat): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="category.php?id=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category']) ?></a>
                        <span class="badge bg-primary rounded-pill">ID: <?= $cat['id'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-warning">No categories found.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
