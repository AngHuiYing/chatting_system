<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'chat_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users except the current user
$userId = $_SESSION['user_id'];
$sql = "SELECT id, username FROM users WHERE id != $userId";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
?>
