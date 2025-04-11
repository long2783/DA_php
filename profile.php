<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include_once("db_conn.php");
include_once("admin/data/User.php");

$user_id = $_SESSION['user_id'];
$user = getUserByID($conn, $user_id);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thông tin tài khoản</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		.password-wrapper {
			position: relative;
		}
		.password-wrapper i {
			position: absolute;
			top: 50%;
			right: 10px;
			transform: translateY(-50%);
			cursor: pointer;
			color: #666;
		}
	</style>
</head>
<body class="login-page">

<div class="d-flex justify-content-center align-items-center vh-100">
	<div class="login-form-container">
		<div class="shadow w-450 p-4">
			<h4 class="display-4 fs-3 text-center mb-4">Thông tin tài khoản</h4>

			<div class="mb-3">
				<label class="form-label">Họ và tên</label>
				<input type="text" class="form-control" value="<?= htmlspecialchars($user['fname']) ?>" disabled>
			</div>

			<div class="mb-3">
				<label class="form-label">Tên đăng nhập</label>
				<input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
			</div>

			<div class="mb-3 password-wrapper">
				<label class="form-label">Mật khẩu (đã mã hóa)</label>
				<input type="password" class="form-control" id="password" value="<?= htmlspecialchars($user['password']) ?>" disabled>
				<i class="fa fa-eye" id="togglePassword"></i>
			</div>

			<div class="mt-4 text-center">
				<a href="logout.php" class="btn btn-danger">Đăng xuất</a>
				<a href="blog.php" class="btn btn-secondary ms-2">Về trang blog</a>
				<a href="change_credentials.html" class="btn btn-warning ms-2">Đổi thông tin tài khoản</a>
			</div>
		</div>
	</div>
</div>

<script>
	const togglePassword = document.getElementById('togglePassword');
	const passwordInput = document.getElementById('password');

	togglePassword.addEventListener('click', function () {
		const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);
		this.classList.toggle('fa-eye');
		this.classList.toggle('fa-eye-slash');
	});
</script>

</body>
</html>
