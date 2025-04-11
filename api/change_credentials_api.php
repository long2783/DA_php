<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập!']);
    exit;
}

include_once("../db_conn.php");
include_once("../admin/data/User.php");

$user_id = $_SESSION['user_id'];
$user = getUserByID($conn, $user_id);

$data = json_decode(file_get_contents("php://input"), true);

$current_pass = $data['current_password'] ?? '';
$new_pass     = $data['new_password'] ?? '';
$confirm_pass = $data['confirm_password'] ?? '';
$new_username = trim($data['new_username'] ?? '');

if (!password_verify($current_pass, $user['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu hiện tại không đúng!']);
    exit;
}

if ($new_pass !== $confirm_pass) {
    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu mới và xác nhận không khớp!']);
    exit;
}

if (strlen($new_pass) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự!']);
    exit;
}

if (empty($new_username)) {
    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập không được để trống!']);
    exit;
}
try {  
    $sqlCheck = "SELECT id FROM users WHERE username = ? AND id != ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->execute([$new_username, $user_id]);

    if ($stmtCheck->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại!']);
        exit;
    }
    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$hashed, $new_username, $user_id]);

    $_SESSION['username'] = $new_username;

    echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công!']);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi CSDL: ' . $e->getMessage()]);
}
