<?php
session_start(); // 确保会话已启动

// 检查用户是否已登录
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// 连接数据库
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 调试输出接收到的 POST 数据
var_dump($_POST);

if (isset($_POST['receiver_id']) && isset($_POST['message'])) {
    // 获取当前登录用户的 sender_id
    $sender_id = $_SESSION['user_id'];  // 动态获取当前用户的 ID
    
    // 获取接收者的 receiver_id 和消息内容
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // 插入消息到数据库
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    echo "Message sent successfully.";
} else {
    echo "Invalid input.";
}

$conn->close();
?>
