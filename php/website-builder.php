<?php

session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Builder - tavolozza</title>
    <link rel="stylesheet" href="../css/website-builder.css">
    <link rel="icon" href="../img/logo.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="builder-container">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="tool-section">
                <button class="tool-btn" data-element="heading">
                    <i class="fas fa-heading"></i> Heading
                </button>
                <button class="tool-btn" data-element="text">
                    <i class="fas fa-paragraph"></i> Text
                </button>
                <button class="tool-btn" data-element="image">
                    <i class="fas fa-image"></i> Image
                </button>
                <button class="tool-btn" data-element="button">
                    <i class="fas fa-square"></i> Button
                </button>
            </div>
            <div class="action-section">
                <button class="save-btn">
                    <i class="fas fa-save"></i> Save
                </button>
                <button class="preview-btn">
                    <i class="fas fa-eye"></i> Preview
                </button>
            </div>
        </div>

        <!-- Canvas -->
        <div class="canvas-container">
            <div class="canvas" id="builder-canvas">
                <!-- Draggable elements will be added here -->
            </div>
        </div>

        <!-- Properties Panel -->
        <div class="properties-panel">
            <h3>Element Properties</h3>
            <div class="properties-content">
                <!-- Properties will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <script src="../js/website-builder.js"></script>
</body>
</html>