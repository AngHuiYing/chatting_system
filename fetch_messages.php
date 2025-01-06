<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'chat_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages between two users
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $senderId = $_SESSION['user_id'];
    $receiverId = $conn->real_escape_string($_GET['receiver_id']);

    $sql = "SELECT 
                messages.message, 
                messages.created_at, 
                users.username AS sender 
            FROM messages 
            JOIN users ON messages.sender_id = users.id 
            WHERE (sender_id = $senderId AND receiver_id = $receiverId) 
               OR (sender_id = $receiverId AND receiver_id = $senderId)
            ORDER BY messages.created_at ASC";

    $result = $conn->query($sql);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
}

$conn->close();
?>
