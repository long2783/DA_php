<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}
include_once("../../db_conn.php");
$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['fname']) || empty($data['fname']) ||
    !isset($data['username']) || empty($data['username']) ||
    !isset($data['password']) || empty($data['password'])
) {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
    exit;
}

$fname = trim($data['fname']);
$username = trim($data['username']);
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "error", "message" => "Username đã tồn tại"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (fname, username, password) VALUES (?, ?, ?)");
$success = $stmt->execute([$fname, $username, $password]);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Thêm user thành công"]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi khi thêm user"]);
}
