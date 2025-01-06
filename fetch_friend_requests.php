<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'chat_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

$sql = "SELECT friend_requests.id, users.username AS sender 
        FROM friend_requests 
        JOIN users ON friend_requests.sender_id = users.id 
        WHERE friend_requests.receiver_id = ? AND friend_requests.status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode($requests);

$stmt->close();
$conn->close();
?>
