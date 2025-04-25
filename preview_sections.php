<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "d";

// Connect to DB
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch sections
$sql = "SELECT * FROM sections";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Section Preview</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      padding: 20px;
      text-decoration: none;
    }
    body a {
      text-decoration: none;
      color: #000;
    }
  </style>
</head>
<body>
<a href="project-editor.php">⬅ Back</a>
<h2>📄 Preview Sections</h2>

<?php
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $style = "width: {$row['width']}; 
              height: {$row['height']}; 
              background-color: {$row['background_color']}; 
              color: {$row['color']}; 
              text-align: {$row['text_align']}; 
              font-size: {$row['font_size']}; 
              font-family: {$row['font_style']}; 
              padding: {$row['padding']}; 
              margin: {$row['margin']};";

    echo '<div class="section-preview" style="' . $style . '">';
    echo '<div class="section-title">' . htmlspecialchars($row['section_name']) . '</div>';

    if ($row['section_template'] === 'image' && !empty($row['image_path'])) {
      echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Section Image" style="max-width:100%;">';
    } elseif ($row['section_template'] === 'custom') {
      echo $row['content']; // custom HTML
    } else {
      echo '<p>' . htmlspecialchars($row['content']) . '</p>'; // text section
    }

    echo '</div>';
  }
} else {
  echo "<p>No sections available to preview.</p>";
}

$conn->close();
?>

</body>
</html>
