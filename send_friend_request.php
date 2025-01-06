<?php
// send_friend_request.php 示例
header('Content-Type: application/json');

// 获取当前登录用户 ID 和目标用户 ID
$data = json_decode(file_get_contents('php://input'), true);
$userId = isset($data['userId']) ? $data['userId'] : null;

// 假设你已登录并存储了用户 ID
$loggedInUserId = 1; // 这里需要替换为实际登录用户的 ID

// 假设你使用数据库
$pdo = new PDO('mysql:host=localhost;dbname=chat_system', 'username', 'password');
$stmt = $pdo->prepare("INSERT INTO friend_requests (sender_id, receiver_id) VALUES (:sender_id, :receiver_id)");
$stmt->execute(['sender_id' => $loggedInUserId, 'receiver_id' => $userId]);

echo json_encode(['message' => 'Friend request sent!']);
