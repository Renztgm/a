<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $data['id'], $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
