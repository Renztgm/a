<?php
session_start();
require 'db.php';

?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>tavolozza - Home</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="icon" href="../img/logo.svg" type="image/svg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script defer src="../js/modal.js"></script>
</head>
  <div class="dashboard">
    <aside class="sidebar">
        <div class="logo">
            <img src="../img/logo.svg" class="logo-icon" />
            <h2>tavolozza</h2>
        </div>
        <nav class="nav-links">
            <div class="main-nav">
                <a href="#" class="nav-link dashboard active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-link projects">
                    <i class="fas fa-folder"></i>
                    My Projects
                </a>
                <a href="#" class="nav-link settings">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Area -->
    <div class="main">
        <!-- Top Nav -->
        <header class="top-nav">
            
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </header>
      <!-- Content -->
      <main class="content">
        <h1>Recent Projects</h1>
        <div class="card-grid">
          <!-- Create Project Card -->
          <a href="website-builder.php" class="card" id="createProject">
            <img src="../img/create.svg" alt="" width="40" />
            <p>Create New Project</p>
            <i class="fas fa-plus add-icon"></i>
          </a>

          <!-- Modal Structure -->
          <div class="modal" id="projectModal">
            <div class="modal-content1">
              <span class="close-btn1" id="closeModalBtn">&times;</span>
              <h2>Create New Project</h2>
              <form action="save_project.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="title">Project Title</label>
                  <input type="text" id="title" name="title" placeholder="Enter project name" required>
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="description" name="description" placeholder="Describe your project"></textarea>
                </div>

                <div class="form-group">
                  <label for="image">Upload Featured Image</label>
                  <input type="file" name="logo" accept="image/*" required>
                </div>

                <div class="button-group">
                  <button type="submit" class="button">Create Project</button>
                  <button type="button" class="cancel-btn1" id="close-btn">Cancel</button>
                </div>
              </form>
            </div>
          </div>

          <?php
            $result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<a href='project-editor.php?id={$row['project_id']}'>";
                        echo "<div class='card'>";
                        
                        // 🗑️ Delete form
                        echo "<form action='delete_project.php' class='delete-form' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this page?\");'>";
                        echo "<input type='hidden' name='project_id' value='{$row['project_id']}'>";
                        echo "<button type='submit' class='buttonbox' style='cursor:pointer;'>🗑️</button>";
                        echo "</form>";

                          
                          echo "<div class='contentCreatedBox'>"; 
                          echo "<img src='{$row['logo']}' width='50'><br>";
                          echo "</div>";
                           
                          echo "<p><b>{$row['name']}</b></p>";
                          echo "<p>- {$row['description']}</p>";
                        echo "</div>";
                        echo "</a>";
                      }
                    } else {
                      echo "<div style='text-align:center; padding: 50px; width: 100%;'>";
                      echo "<h3>No pages created yet.</h3>";
                      // echo "<button onclick='openModal()' style='padding: 10px 20px; background-color: #7e36d8; color: white; border: none; border-radius: 5px; cursor: pointer;'>Create a website now!</button>";
                      echo "</div>";
                    }
                  ?>
            <!-- </form> -->


      </main>

<!-- Modal (Account Information) -->
<div class="modal" id="account-modal">
  <div class="modal-content">
    <span class="close-btn" id="close-btn">&times;</span>
    <h2>My Account</h2>

    <!-- Profile Information -->
    <div class="profile-info">
      <div class="profile-header">
        <h3><?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?></h3>
        <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="button-container">
      <a href="settings.php" class="settings-btn">
        <i class="fas fa-cog"></i>
        Settings
      </a>
      <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Modal for Creating New Project -->
<div class="modal" id="projectModal">
  <div class="modal-content1">
    <span class="close-btn1" id="closeModalBtn">&times;</span>
    <h2>Create New Project</h2>
    <form action="save_project.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Project Title</label>
        <input type="text" id="title" name="title" placeholder="Enter project name" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Describe your project"></textarea>
      </div>

      <div class="form-group">
        <label for="image">Upload Featured Image</label>
        <input type="file" id="image" name="image" accept="image/*">
      </div>

      <div class="button-group">
        <button type="submit">Create Project</button>
        <button type="button" class="cancel-btn" onclick="window.location.href='index.php'">Cancel</button>
      </div>
    </form>
  </div>
</div>


  <!-- Link to JavaScript -->
  <script src="modal.js"></script>

  
</body>

