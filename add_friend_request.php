<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'chat_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$senderId = $_SESSION['user_id'];
$receiverId = $_POST['receiver_id'];

// 检查是否已经发送过请求或是好友
$checkSql = "SELECT * FROM friend_requests WHERE sender_id = $senderId AND receiver_id = $receiverId AND status = 'pending'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Friend request already sent.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)");
$stmt->bind_param("ii", $senderId, $receiverId);
$stmt->execute();

echo json_encode(['success' => true, 'message' => 'Friend request sent successfully.']);
$conn->close();
?>
