<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'chat_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$friendId = $_GET['friend_id'];

// 检查是否为好友
$sql = "
    SELECT * 
    FROM friends 
    WHERE (user_id = $userId AND friend_id = $friendId) 
       OR (user_id = $friendId AND friend_id = $userId)";
$result = $conn->query($sql);

$isFriend = $result->num_rows > 0;

echo json_encode(['isFriend' => $isFriend]);

$conn->close();
?>
