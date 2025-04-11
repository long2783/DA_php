<?php
include_once("db_conn.php");
include_once("admin/data/Post.php");
include_once("admin/data/Comment.php");

$posts = isset($_GET['search']) ? serach($conn, $_GET['search']) : getAll($conn);
$categories = get5Categoies($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-blog-card img {
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .main-blog-card:hover img {
      transform: scale(1.05);
      opacity: 0.9;
    }

    .main-blog-card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .main-blog-card:hover {
      transform: translateY(-5px);
    }

    .search-bar {
      margin-bottom: 30px;
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      align-items: start;
    }

    .category-aside .list-group-item {
      border: none;
      border-radius: 12px !important;
      margin-bottom: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .category-aside .list-group-item:hover {
      background-color: #0d6efd;
      color: #fff;
      transform: translateX(5px);
    }

    .category-aside .active {
      background-color: #343a40 !important;
      color: #fff !important;
      font-weight: bold;
      border-radius: 12px 12px 0 0 !important;
    }

    .category-aside a {
      text-transform: capitalize;
    }

    #category-list {
      background-color: #fff;
      padding: 5px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <?php include 'inc/NavBar.php'; ?>
  <div class="container mt-5">
    <form action="" method="get" class="search-bar">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>

    <div class="row">
      <div class="col-md-12">
        <div class="grid-container">
        <?php if (!empty($posts) && $posts != 0): ?>
          <?php foreach ($posts as $post): ?>
            <div class="card main-blog-card h-100">
              <img src="upload/blog/<?= $post['cover_url'] ?>" class="card-img-top" alt="Cover">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $post['post_title'] ?></h5>
                <p class="card-text flex-grow-1">
                  <?php 
                    $p = strip_tags($post['post_text']); 
                    echo mb_substr($p, 0, 150) . '...'; 
                  ?>
                </p>
                <a href="blog-view.php?post_id=<?= $post['post_id'] ?>" class="btn btn-sm btn-outline-primary mt-auto">Read More</a>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">Posted on <?= $post['crated_at'] ?></small>
                <div>
                  <i class="fa fa-thumbs-up"></i> <?= likeCountByPostID($conn, $post['post_id']) ?>
                  &nbsp;
                  <i class="fa fa-comment"></i> <?= CountByPostID($conn, $post['post_id']) ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle me-2"></i> Không tìm thấy bài viết nào.
          </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const categoryWrapper = document.querySelector('.category-wrapper');
    const categoryList = document.getElementById('category-list');

    if (categoryWrapper && categoryList) {
      categoryWrapper.addEventListener('mouseenter', function () {
        categoryList.style.display = 'block';
      });
      categoryWrapper.addEventListener('mouseleave', function () {
        categoryList.style.display = 'none';
      });
    }
  </script>
</body>
</html>
