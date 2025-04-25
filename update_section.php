<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "d";

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch POST data safely
$id = $_POST['section_id'] ?? null;
$page_id = $_POST['page_id'] ?? '';
// $section_name = $_POST['section_name'] ?? '';
$section_template = $_POST['section_template'] ?? '';
$width = $_POST['width'] ?? '';
$height = $_POST['height'] ?? '';
$background_color = $_POST['background_color'] ?? '';
$color = $_POST['color'] ?? '';
$text_align = $_POST['text_align'] ?? '';
$font_size = $_POST['font_size'] ?? '';
$font_style = $_POST['font_style'] ?? '';
$padding = $_POST['padding'] ?? '';
$margin = $_POST['margin'] ?? '';
$content = $_POST['content'] ?? '';
$image_path = "";

// Handle image upload
if ($section_template === "image" && isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
  $target_dir = "uploads/";
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image_path = $target_file;
  } else {
    echo "Error uploading image.";
  }
}

// SQL base
$sql = "UPDATE sections SET
  page_id = ?, section_template = ?, width = ?, height = ?, background_color = ?, 
  color = ?, text_align = ?, font_size = ?, font_style = ?, padding = ?, margin = ?, content = ?";

// Add image path if uploaded
if (!empty($image_path)) {
  $sql .= ", image_path = ?";
}

$sql .= " WHERE id = ?";

$stmt = $conn->prepare($sql);

// Bind parameters
if (!empty($image_path)) {
  $stmt->bind_param(
    "isssssssssssssi",
    $page_id, $section_template, $width, $height,
    $background_color, $color, $text_align, $font_size, $font_style,
    $padding, $margin, $content, $image_path, $id
  );
} else {
  $stmt->bind_param(
    "isssssssssssi",
    $page_id, $section_template, $width, $height,
    $background_color, $color, $text_align, $font_size, $font_style,
    $padding, $margin, $content, $id
  );
}

// Execute & redirect
if ($stmt->execute()) {
  header("Location: project-editor.php?id=$page_id");
  exit();
} else {
  echo "Error updating section: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
