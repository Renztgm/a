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
      <label>URL Slug / Permalink</label>
      <input type="text" id="pageSlug" />
      <button onclick="saveDraft()">Save Draft</button>
      <button onclick="publishPage()">Publish</button>
      <button onclick="previewPage()">Preview Page</button>
    </div>

    <h3 onclick="toggleGroup(this)">🧱 Page Structure / Sections</h3>
    <div class="section-group">
      <select id="sectionTemplate">
        <option value="text">Text Section</option>
        <option value="image">Image Section</option>
        <option value="custom">Custom HTML</option>
      </select>
      <button onclick="addSection()">Add Section</button>
      <button onclick="undo()">Undo</button>
      <button onclick="redo()">Redo</button>
      <button onclick="exportJSON()">Export JSON</button>
      <input type="file" accept=".json" onchange="importJSON(this)" />
      <button onclick="downloadHTML()">Download as HTML</button>
    </div>

    <h3 onclick="toggleGroup(this)">🎨 Design & Appearance</h3>
    <div class="section-group">
      <label>Page Layout</label>
        <select>
          <option>Full-width</option>
          <option>Boxed</option>
        </select>
      <h4>Apply a Style Template</h4>
        <select onchange="applyPresetStyle(this.value)">
          <option value="">-- Choose Template --</option>
          <option value="headerDefault">Header - Centered Bold</option>
          <option value="footerMinimal">Footer - Small & Muted</option>
          <option value="imageFramed">Image - Framed</option>
          <option value="contentReadable">Content - Readable</option>
        </select>

      <label>Background Color</label>
        <input type="color" onchange="changeBackgroundColor(this.value)" />
      <label>Typography</label>
        <select>
          <option>Default</option>
          <option>Serif</option>
          <option>Sans-serif</option>
        </select>
      <h4>Section Style Settings</h4>
        <label>Width</label>
        <input type="text" id="sectionWidth" placeholder="e.g. 100%, 300px" oninput="updateStyle('width', this.value)" />

        <label>Height</label>
        <input type="text" id="sectionHeight" placeholder="e.g. auto, 200px" oninput="updateStyle('height', this.value)" />

        <label>Text Align</label>
        <select id="sectionTextAlign" onchange="updateStyle('textAlign', this.value)">
          <option value="">Default</option>
          <option value="left">Left</option>
          <option value="center">Center</option>
          <option value="right">Right</option>
        </select>

          <label>Font Size</label>
          <input type="text" id="sectionFontSize" placeholder="e.g. 16px" oninput="updateStyle('fontSize', this.value)" />

          <label>Font Style</label>
          <select id="sectionFontStyle" onchange="updateStyle('fontFamily', this.value)">
            <option value="">Default</option>
            <option value="Arial">Arial</option>
            <option value="Georgia">Georgia</option>
            <option value="Courier New">Courier New</option>
            <option value="Times New Roman">Times New Roman</option>
          </select>

          <label>Text Color</label>
          <input type="color" onchange="updateStyle('color', this.value)" />

          <label>Background Color</label>
          <input type="color" onchange="updateStyle('backgroundColor', this.value)" />

    </div>

    <h3 onclick="toggleGroup(this)">🔗 Navigation Settings</h3>
    <div class="section-group">
      <label>Include in Menu</label>
      <select><option>Yes</option><option>No</option></select>
      <label>Menu Order</label>
      <input type="text" />
    </div>

    <h3 onclick="toggleGroup(this)">⚙️ SEO Settings</h3>
    <div class="section-group">
      <label>Meta Title</label><input type="text" />
      <label>Meta Description</label><input type="text" />
      <label>Open Graph Tags</label><input type="text" />
    </div>

    <h3 onclick="toggleGroup(this)">🧪 Advanced Settings</h3>
    <div class="section-group">
      <label>Custom CSS</label><textarea rows="3"></textarea>
      <label>Custom JavaScript</label><textarea rows="3"></textarea>
      <label>Page Redirect URL</label><input type="text" />
    </div>

    <h3 onclick="toggleGroup(this)">👥 Permissions & Access</h3>
    <div class="section-group">
      <label>Visibility</label>
      <select><option>Public</option><option>Private</option><option>Password-Protected</option></select>
      <label>Who Can Edit/View</label><input type="text" />
    </div>
  </div>

  <div class="main" id="pageEditor">
    <h1 id="liveTitle">Page Title Preview</h1>
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
