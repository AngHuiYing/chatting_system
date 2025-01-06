<?php
// search_users.php 示例
header('Content-Type: application/json');

// 获取搜索查询
$query = isset($_GET['query']) ? $_GET['query'] : '';

// 假设你使用的是数据库连接
$pdo = new PDO('mysql:host=localhost;dbname=chat_system', 'username', 'password');
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE username LIKE :query LIMIT 10");
$stmt->execute(['query' => "%$query%"]);

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
