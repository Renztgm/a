<?php

session_start();

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['content'])) {
    // Store the content in session
    $_SESSION['preview_content'] = $data['content'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}