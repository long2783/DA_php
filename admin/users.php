<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    header("Location: ../admin-login.php");
    exit;
}

include_once("../db_conn.php");
include_once("data/User.php");
$users = getAll($conn);
$key = "blog070304"; 

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Users</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/side-bar.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php
	 include "inc/side-nav.php"; ?>
<section class="section-1">
	<div class="main-table p-4">
		<h3 class="mb-3">
			All Users 
			<a href="user-add.php" class="btn btn-success">Add New</a>
		</h3>

		<?php if (isset($_GET['error'])) { ?>	
			<div class="alert alert-warning">
				<?=htmlspecialchars($_GET['error'])?>
			</div>
		<?php } ?>

		<?php if (isset($_GET['success'])) { ?>	
			<div class="alert alert-success">
				<?=htmlspecialchars($_GET['success'])?>
			</div>
		<?php } ?>

		<?php if ($users != 0) { ?>
			<table class="table t1 table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Full Name</th>
						<th>Username</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $user) { ?>
					<tr>
						<th scope="row"><?=$user['id']?></th>
						<td><?=$user['fname']?></td>
						<td><?=$user['username']?></td>
						<td>
							<a href="user-delete.php?user_id=<?=$user['id']?>" class="btn btn-danger">Delete</a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div class="alert alert-warning">Empty!</div>
		<?php } ?>
	</div>
</section>

<script>
	document.getElementById('navList').children.item(0).classList.add("active");
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
