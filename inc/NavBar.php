<?php
if (!isset($logged)) {
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  $logged = isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

include_once("admin/data/Post.php"); 
$categories = get5Categoies($conn);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-light" href="blog.php">
      <i class="fa fa-pencil-square-o me-2"></i>Blog
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown" id="categoryDropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="categoryMenu" role="button">
            <i class="fa fa-th-list me-1"></i> Category
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoryMenu">
            <?php foreach ($categories as $category): ?>
              <li>
                <a class="dropdown-item" href="category.php?category_id=<?= $category['id'] ?>">
                  <?= htmlspecialchars($category['category']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>

        <?php if ($logged): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fa fa-user-circle me-1"></i> @<?= $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user me-1"></i> Profile</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out me-1"></i> Logout</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="login.php">
            <i class="fa fa-sign-in me-1"></i> Login | Signup
          </a>
        </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
<style>
  /* Mở dropdown khi hover */
  #categoryDropdown:hover > .dropdown-menu {
    display: block;
    margin-top: 0;
  }
</style>

<script>
  // Fix cho mobile hoặc hover sai hành vi
  const dropdown = document.getElementById("categoryDropdown");
  dropdown.addEventListener("click", function(e) {
    e.stopPropagation();
    this.classList.toggle("show");
  });
</script>