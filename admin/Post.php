<?php 
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Posts</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/side-bar.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php 
      include "inc/side-nav.php"; 
      include_once("data/Post.php");
      include_once("data/Comment.php");
      include_once("../db_conn.php");
      $posts = getAllDeep($conn);
	?>
               
	<div class="main-table">
	 	<h3 class="mb-3">All Posts 
	 		<a href="post-add.php" class="btn btn-success">Add New</a></h3>

	 	<?php if (isset($_GET['error'])) { ?>	
	 		<div class="alert alert-warning"><?=htmlspecialchars($_GET['error'])?></div>
	    <?php } ?>

        <?php if (isset($_GET['success'])) { ?>	
	 		<div class="alert alert-success"><?=htmlspecialchars($_GET['success'])?></div>
	    <?php } ?>

	 	<?php if ($posts != 0) { ?>
	 	<table class="table t1 table-bordered">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th>Title</th>
		      <th>Category</th>
		      <th>Comments</th>
		      <th>Likes</th>
		      <th>Created At</th> <!-- ✅ Thêm tiêu đề thời gian tạo -->
		      <th>Updated At</th> <!-- ✅ Thêm tiêu đề thời gian cập nhật -->
		      <th>Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($posts as $post) {
		  	$category = getCategoryById($conn, $post['category']); 
		  	?>
		    <tr>
		      <th scope="row"><?=$post['post_id'] ?></th>
		      <td><a href="single_post.php?post_id=<?=$post['post_id'] ?>"><?=$post['post_title'] ?></a></td>
		      <td><?=$category['category']?></td>
		      <td>
		      	<i class="fa fa-comment" aria-hidden="true"></i> 
		        <?= CountByPostID($conn, $post['post_id']); ?>
		      </td>
		      <td>
		      	<i class="fa fa-thumbs-up" aria-hidden="true"></i> 
		        <?= likeCountByPostID($conn, $post['post_id']); ?>
		      </td>
		      <td>
		      	<?= date("d-m-Y H:i", strtotime($post['crated_at'])) ?> 
		      </td>
		      <td>
		      	<?= date("d-m-Y H:i", strtotime($post['updated_at'])) ?> 
		      </td>
		      <td>
		      	<a href="post-delete.php?post_id=<?=$post['post_id'] ?>" class="btn btn-danger">Delete</a>
		      	<a href="post-edit.php?post_id=<?=$post['post_id'] ?>" class="btn btn-warning">Edit</a>
                <?php if ($post['publish'] == 1) { ?>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=1" class="btn btn-link disabled">Public</a>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=0" class="btn btn-link">Privet</a>
		      <?php } else { ?>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=1" class="btn btn-link">Public</a>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=0" class="btn btn-link disabled">Privet</a>
		      <?php } ?>
		      </td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	<?php } else { ?>
		<div class="alert alert-warning">Empty!</div>
	<?php } ?>
	</div>

	<script>
	 	var navList = document.getElementById('navList').children;
	 	navList.item(1).classList.add("active");
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
} else {
	header("Location: ../admin-login.php");
	exit;
} 
?>
