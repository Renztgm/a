<?php
include('db.php'); // or whatever your connection file is

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    // Delete the page from the database
    $stmt = $conn->prepare("DELETE FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $project_id);

    if ($stmt->execute()) {
        // Redirect back after deletion
        header("Location: index.php"); // Change this to your actual page
        exit();
    } else {
        echo "Error deleting page.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
