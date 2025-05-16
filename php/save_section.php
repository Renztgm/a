<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "d";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $projectId = $_POST['project_id'] ?? null;
    $sectionName = $_POST['sectionName'];
    $parentTo = $_POST['parentTo'];
    $sectionTemplate = $_POST['sectionTemplate'];

    // Handle file upload for image section
    $imagePath = null;

    if ($sectionTemplate === 'image' && isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === 0) {
        $targetDir = "uploads/";
        // Create uploads folder if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExtension = pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
        $uniqueName = uniqid() . "_" . basename($_FILES["imageFile"]["name"]);
        $targetFile = $targetDir . $uniqueName;

        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
                echo "✅ Image uploaded successfully: $imagePath<br>";
            } else {
                echo "❌ Failed to move uploaded image to: $targetFile<br>";
            }
        } else {
            echo "❌ Uploaded file is not a valid image.<br>";
        }
    }

    // Prepare SQL query to insert section data into the database
    $sql = "INSERT INTO sections (section_name, page_id, section_template, image_path) 
            VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $sectionName, $parentTo, $sectionTemplate, $imagePath);
        if ($stmt->execute()) {
            echo "✅ Section saved successfully!";
            header("Location: project-editor.php?page_id=$projectId");
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
}
?>
