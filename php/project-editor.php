<?php
session_start();
$project_id = $_GET['project_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Advanced CMS Page Editor</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
      height: 100vh;
    }
    .sidebar {
      width: 300px;
      background-color: #f4f4f4;
      padding: 20px;
      overflow-y: auto;
      border-right: 1px solid #ddd;
    }
    .sidebar h3 {
      font-size: 16px;
      cursor: pointer;
      user-select: none;
      margin-top: 20px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
    }
    .sidebar .section-group {
      margin: 10px 0;
      padding-left: 10px;
      display: none;
    }
    .main {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      background-color: #fff;
      position: relative;
    }
    .section {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #f9f9f9;
      position: relative;
    }
    .section[hidden] {
      display: none;
    }
    .section .tools {
      position: absolute;
      top: 5px;
      right: 5px;
    }
    input[type="text"], select, textarea {
      width: 100%;
      padding: 5px;
      margin-top: 5px;
    }
    button {
      margin-top: 10px;
      padding: 5px 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="sidebar">
  <button onclick="goBack()" style="margin-bottom: 20px; background-color: #ddd; border: none;">⬅️ Back to Home</button>
    <h3 onclick="toggleGroup(this)">🧩 General Page Settings</h3>
    <div class="section-group">
      <label>Page Title</label>
      <input type="text" id="pageTitle" oninput="updateTitle()" />
      <!-- <label>URL Slug / Permalink</label>
      <input type="text" id="pageSlug" />
      <button onclick="saveDraft()">Save Draft</button>
      <button onclick="publishPage()">Publish</button> -->
      <a href="preview_sections.php">
      <button>Preview Page</button>
      </a>
    </div>

    <h3 onclick="toggleGroup(this)">🧱 Page Structure / Sections</h3>
<div class="section-group">
  <form id="sectionForm" action="save_section.php" method="POST" enctype="multipart/form-data">
    <div>
      <label for="sectionName">Section Name:</label>
      <input type="text" id="sectionName" name="sectionName" placeholder="Enter section name" required>
    </div>
    
    <div>
      <label for="parentTo">Parent to:</label>
      <select id="parentTo" name="parentTo">
        <option value="none">None</option>
        <option value="header">Header</option>
        <option value="main">Main</option>
        <option value="footer">Footer</option>
        <!-- Add other parent options as needed -->
      </select>
    </div>
    
    <div>
      <label for="sectionTemplate">Section Type:</label>
      <select id="sectionTemplate" name="sectionTemplate" onchange="toggleImageUpload()">
        <option value="text">Text Section</option>
        <option value="image">Image Section</option>
        <option value="custom">Custom HTML</option>
      </select>
    </div>

    <div id="imageUploadSection" style="display:none;">
      <label for="imageFile">Upload Image:</label>
      <input type="file" id="imageFile" name="imageFile" accept="image/*">
    </div>

    <div>
      <button type="submit">Add Section</button>
    </div>
  </form>
</div>

<script>
  // Toggles the display of the image upload field based on the section template selection
  function toggleImageUpload() {
    const sectionTemplate = document.getElementById("sectionTemplate").value;
    const imageUploadSection = document.getElementById("imageUploadSection");

    // Show the image upload field only if "image" is selected
    if (sectionTemplate === "image") {
      imageUploadSection.style.display = "block";
    } else {
      imageUploadSection.style.display = "none";
    }
  }

  // Optional: Toggle visibility of section group for the collapsible menu
  function toggleGroup(element) {
    const group = element.nextElementSibling;
    group.style.display = group.style.display === "none" ? "block" : "none";
  }
</script>

      <div class="section-group">
        <form id="sectionForm" action="/your-endpoint" method="POST">
          <div>
            <label for="sectionName">Section Name:</label>
            <input type="text" id="sectionName" name="sectionName" placeholder="Enter section name" required>
          </div>
          
          <div>
            <label for="parentTo">Parent to:</label>
            <select id="parentTo" name="parentTo">
              <option value="none">None</option>
              <option value="header">Header</option>
              <option value="main">Main</option>
              <option value="footer">Footer</option>
              <!-- Add other parent options as needed -->
            </select>
          </div>
          
          <div>
            <label for="sectionTemplate">Section Type:</label>
            <select id="sectionTemplate" name="sectionTemplate">
              <option value="text">Text Section</option>
              <option value="image">Image Section</option>
              <option value="custom">Custom HTML</option>
            </select>
          </div>
          
          <div>
            <button type="submit">Add Section</button>
          </div>
        </form>
      </div>
<h3 onclick="toggleGroup(this)">🎨 Design & Appearance</h3>
<div class="section-group">
<form method="post" action="update_section.php" enctype="multipart/form-data">

    <?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "d";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, section_name FROM sections";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<select name="section_id">';
  echo '<option value="">-- Select Section --</option>';
  while($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['section_name']) . '</option>';
  }
  echo '</select>';
} else {
  echo "No sections found.";
}

$conn->close();
?>
        <!-- Page ID -->
    <label for="page_id">Page ID</label>
    <input type="text" id="page_id" name="page_id" required />
    <!-- Section Template -->
    <label for="section_template">Section Template</label>
    <select id="section_template" name="section_template" onchange="handleImageField(this.value)">
      <option value="text">Text Section</option>
      <option value="image">Image Section</option>
      <option value="custom">Custom HTML</option>
    </select>

    <label for="content">Content:</label>
    <input type="text" id="content" name="content" placeholder="Enter content here..." />
    <!-- Image Upload -->
    <div id="imageInputField" style="display:none;">
      <label for="image_path">Upload Image</label>
      <input type="file" name="image_path" id="image_path" accept="image/*" />
    </div>

    <!-- Width -->
    <label for="width">Width</label>
    <input type="text" name="width" id="width" placeholder="e.g. 100%, 300px" />

    <!-- Height -->
    <label for="height">Height</label>
    <input type="text" name="height" id="height" placeholder="e.g. auto, 200px" />

    <!-- Background Color -->
    <label for="background_color">Background Color</label>
    <input type="color" name="background_color" id="background_color" />

    <!-- Text Color -->
    <label for="color">Text Color</label>
    <input type="color" name="color" id="color" />

    <!-- Text Align -->
    <label for="text_align">Text Align</label>
    <select name="text_align" id="text_align">
      <option value="">Default</option>
      <option value="left">Left</option>
      <option value="center">Center</option>
      <option value="right">Right</option>
    </select>

    <!-- Font Size -->
    <label for="font_size">Font Size</label>
    <input type="text" name="font_size" id="font_size" placeholder="e.g. 16px" />

    <!-- Font Style -->
    <label for="font_style">Font Style</label>
    <select name="font_style" id="font_style">
      <option value="">Default</option>
      <option value="Arial">Arial</option>
      <option value="Georgia">Georgia</option>
      <option value="Courier New">Courier New</option>
      <option value="Times New Roman">Times New Roman</option>
    </select>

    <!-- Padding -->
    <label for="padding">Padding</label>
    <input type="text" name="padding" id="padding" placeholder="e.g. 10px, 2em" />

    <!-- Margin -->
    <label for="margin">Margin</label>
    <input type="text" name="margin" id="margin" placeholder="e.g. 0 auto, 20px" />

    <br><br>
    <button type="submit">Save Section</button>

</form>
</div>
  </div>

  <div class="main">
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

  </div>

  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <script>
    const editor = document.getElementById("pageEditor");
    const historyStack = [];
    const redoStack = [];

    function updateTitle() {
      document.getElementById("liveTitle").textContent = document.getElementById("pageTitle").value || "Page Title Preview";
    }

    function toggleGroup(header) {
      const next = header.nextElementSibling;
      next.style.display = next.style.display === "block" ? "none" : "block";
    }

    function changeBackgroundColor(color) {
      editor.style.backgroundColor = color;
    }

    function saveState() {
      historyStack.push(editor.innerHTML);
      if (historyStack.length > 20) historyStack.shift();
    }

    function undo() {
      if (historyStack.length) {
        redoStack.push(editor.innerHTML);
        editor.innerHTML = historyStack.pop();
      }
    }

    function redo() {
      if (redoStack.length) {
        historyStack.push(editor.innerHTML);
        editor.innerHTML = redoStack.pop();
      }
    }

    function addSection() {
      saveState();
      const type = document.getElementById("sectionTemplate").value;
      const section = document.createElement("div");
      section.className = "section";
      section.contentEditable = true;

      if (type === "text") {
        section.innerHTML = `<p>New text section...</p>`;
      } else if (type === "image") {
        section.innerHTML = `<input type="file" accept="image/*" onchange="uploadImage(this, this.parentElement)" />`;
      } else if (type === "custom") {
        section.innerHTML = `<p>&lt;custom html&gt;</p>`;
      }

      const tools = document.createElement("div");
      tools.className = "tools";
      tools.innerHTML = `
        <button onclick="this.parentElement.parentElement.hidden = !this.parentElement.parentElement.hidden">👁️</button>
        <button onclick="this.parentElement.parentElement.remove()">❌</button>
      `;
      section.appendChild(tools);

      editor.appendChild(section);
      autosave();
    }

    function uploadImage(input, section) {
      const file = input.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = e => {
        section.innerHTML = `<img src="${e.target.result}" style="max-width:100%" />`;
      };
      reader.readAsDataURL(file);
    }

    function saveDraft() {
      autosave();
      alert("Draft saved!");
    }

    function publishPage() {
      alert("Page published!");
    }

    function previewPage() {
  const clone = editor.cloneNode(true);
  const tools = clone.querySelectorAll(".tools");
  tools.forEach(tool => tool.remove());

  const previewWindow = window.open();
  previewWindow.document.write(`
    <html>
      <head><title>Page Preview</title></head>
      <body>${clone.innerHTML}</body>
    </html>
  `);
}


    function autosave() {
      localStorage.setItem("pageDraft", editor.innerHTML);
    }

    window.onload = function () {
      if (localStorage.getItem("pageDraft")) {
        editor.innerHTML = localStorage.getItem("pageDraft");
      }
      new Sortable(editor, {
        animation: 150,
        handle: ".section",
      });
    };

    function exportJSON() {
      const content = editor.innerHTML;
      const blob = new Blob([JSON.stringify({ content })], { type: "application/json" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "page.json";
      a.click();
    }

    function importJSON(input) {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = e => {
        const json = JSON.parse(e.target.result);
        editor.innerHTML = json.content;
      };
      reader.readAsText(file);
    }

    function downloadHTML() {
      const html = `
        <html><head><title>Exported Page</title></head><body>${editor.innerHTML}</body></html>
      `;
      const blob = new Blob([html], { type: "text/html" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "page.html";
      a.click();
    }

    let selectedSection = null;

editor.addEventListener('click', e => {
  const section = e.target.closest('.section');
  if (section) {
    selectedSection = section;
  }
});

function updateStyle(property, value) {
  if (selectedSection) {
    selectedSection.style[property] = value;
    autosave();
  } else {
    alert("Please click a section to apply styles.");
  }
}

function applyPresetStyle(preset) {
  if (!selectedSection) {
    alert("Please select a section to apply a style.");
    return;
  }

  const styles = {
    headerDefault: {
      textAlign: "center",
      fontSize: "28px",
      fontWeight: "bold",
      fontFamily: "Georgia",
      backgroundColor: "#f0f0f0",
      padding: "15px",
    },
    footerMinimal: {
      textAlign: "center",
      fontSize: "12px",
      color: "#888",
      backgroundColor: "#fafafa",
      padding: "10px",
    },
    imageFramed: {
      border: "2px solid #ccc",
      padding: "10px",
      display: "block",
      margin: "0 auto",
      textAlign: "center",
    },
    contentReadable: {
      fontSize: "16px",
      lineHeight: "1.6",
      fontFamily: "Arial",
      padding: "10px",
    },
  };

  const style = styles[preset];
  if (style) {
    Object.entries(style).forEach(([prop, value]) => {
      selectedSection.style[prop] = value;
    });
    autosave();
  }
}

function goBack() {
  window.location.href = "index.php";
}

  </script>
</body>
</html>
