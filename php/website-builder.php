<?php

session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Add this after session_start()
if (isset($_GET['project'])) {
    $stmt = $conn->prepare("SELECT content FROM projects WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $_GET['project'], $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $savedContent = $row['content'];
    }
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
    <script defer src="../js/builder.js"></script>
</head>
<body>
    <div class="builder-container">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="toolbar-header">
                <a href="index.php" class="return-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
                <h3>Components</h3>
            </div>
            
            <div class="components-group">
                <div class="group-title">Basic Elements</div>
                <div class="tool-section">
                    <!-- Add Navbar Component First -->
                    <button class="tool-btn" data-element="navbar">
                        <i class="fas fa-bars"></i>
                        <span class="tool-label">Navigation Bar</span>
                        <span class="tool-description">Add top navigation menu</span>
                    </button>
                    
                    <!-- Add Logo Component First -->
                    <button class="tool-btn" data-element="logo">
                        <i class="fas fa-crown"></i>
                        <span class="tool-label">Logo</span>
                        <span class="tool-description">Add your brand logo</span>
                    </button>
                    
                    <button class="tool-btn" data-element="heading">
                        <i class="fas fa-heading"></i>
                        <span class="tool-label">Heading</span>
                        <span class="tool-description">Add a title or subtitle</span>
                    </button>
                    
                    <button class="tool-btn" data-element="text">
                        <i class="fas fa-paragraph"></i>
                        <span class="tool-label">Paragraph</span>
                        <span class="tool-description">Add body text content</span>
                    </button>

                    <button class="tool-btn" data-element="image">
                        <i class="fas fa-image"></i>
                        <span class="tool-label">Image</span>
                        <span class="tool-description">Insert images or photos</span>
                    </button>

                    <button class="tool-btn" data-element="button">
                        <i class="fas fa-square"></i>
                        <span class="tool-label">Button</span>
                        <span class="tool-description">Add clickable buttons</span>
                    </button>
                </div>
            </div>

            <div class="action-section">
                <button class="save-btn">
                    <i class="fas fa-save"></i> Save Project
                </button>
                <button class="preview-btn" title="Open preview in new window">
                    <i class="fas fa-external-link-alt"></i> Preview Site
                </button>
            </div>
        </div>

        <!-- Canvas -->
        <div class="canvas-container">
            <div class="preview-section">
                <div id="preview-area">
                    <!-- Components will be added here -->
                </div>
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