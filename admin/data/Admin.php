<?php 

// Get All USERS
function getByID($conn, $id) {
  
    $query = "SELECT id, first_name, last_name, username FROM admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    } else {
        return null; 
    }
}

