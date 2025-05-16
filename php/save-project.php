<?php

session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['content']) && isset($data['title'])) {
    $userId = $_SESSION['user_id'];
    $title = $data['title'];
    $content = $data['content'];

    // Check if project already exists
    $stmt = $conn->prepare("SELECT id FROM projects WHERE user_id = ? AND title = ?");
    $stmt->bind_param("is", $userId, $title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing project
        $project = $result->fetch_assoc();
        $stmt = $conn->prepare("UPDATE projects SET content = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $content, $project['id']);
    } else {
        // Create new project
        $stmt = $conn->prepare("INSERT INTO projects (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $title, $content);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Project saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving project']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
}