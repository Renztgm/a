<?php
include('db.php'); // Include your database connection file

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["title"] ?? '';
    $description = $_POST["description"] ?? '';
    $logoPath = ''; // Initialize properly

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Clean the filename
        $safeName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['logo']['name']));
        $logoName = uniqid() . '_' . $safeName;
        $targetFile = $uploadDir . $logoName;

        // Check if it's a valid image
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
                $logoPath = $targetFile;
            } else {
                echo "❌ Failed to upload logo.";
                exit;
            }
        } else {
            echo "❌ Uploaded file is not a valid image.";
            exit;
        }
    } else {
        echo "❌ Please select a valid image file.";
        exit;
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO projects (name, description, logo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $logoPath);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Error saving project: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
