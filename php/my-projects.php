<?php

session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's projects
$stmt = $conn->prepare("SELECT id, title, created_at, updated_at FROM projects WHERE user_id = ? ORDER BY updated_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - tavolozza</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../img/logo.svg" type="image/svg">
</head>
<body>
    <div class="projects-container">
        <h1>My Projects</h1>
        <div class="projects-grid">
            <?php while ($project = $result->fetch_assoc()): ?>
            <div class="project-card">
                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                <p>Last updated: <?php echo date('M j, Y', strtotime($project['updated_at'])); ?></p>
                <div class="project-actions">
                    <a href="website-builder.php?project=<?php echo $project['id']; ?>" class="edit-btn">Edit</a>
                    <a href="preview.php?project=<?php echo $project['id']; ?>" class="preview-btn">Preview</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>