<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container d-flex justify-content-center align-items-center vh-100">
		<form class="shadow p-4 rounded" 
			  style="width: 100%; max-width: 450px;" 
			  action="php/signup.php" 
			  method="post">

			<h2 class="text-center mb-4">Create Account</h2>

			<?php if (isset($_GET['error'])): ?>
				<div class="alert alert-danger">
					<?php echo htmlspecialchars($_GET['error']); ?>
				</div>
			<?php endif; ?>
			<?php if (isset($_GET['success'])): ?>
				<div class="alert alert-success">
					<?php echo htmlspecialchars($_GET['success']); ?>
				</div>
			<?php endif; ?>
			<div class="mb-3">
				<label class="form-label">Full Name</label>
				<input type="text" 
					   class="form-control" 
					   name="fname" 
					   value="<?php echo isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : ''; ?>">
			</div>

			<div class="mb-3">
				<label class="form-label">User name</label>
				<input type="text" 
					   class="form-control" 
					   name="uname" 
					   value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>">
			</div>

			<div class="mb-3">
				<label class="form-label">Password</label>
				<input type="password" 
					   class="form-control" 
					   name="pass">
			</div>

			<div class="d-flex justify-content-between align-items-center">
				<button type="submit" class="btn btn-primary">Sign Up</button>
				<a href="login.php" class="link-secondary">Login</a>
			</div>
		</form>
	</div>
</body>
</html>
