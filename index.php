<?php
session_start();
require 'db.php';

?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>tavolozza - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="img/Logo.svg" class="logo-icon" />
        <h2>tavolozza</h2>
      </div>
      <nav>
        <a href="#" class="nav-link dashboard active">Dashboard</a>
        <a href="#" class="nav-link projects">My Projects</a>
        <a href="#" class="nav-link settings">Settings</a>
      </nav>
    </aside>

    <!-- Main Area -->
    <div class="main">
      <!-- Top Nav -->
      <header class="top-nav">
        <input type="text" placeholder="Search...">
        <a href="#" class="nav-link account" id="account-btn">My Account</a>
      </header>

      <!-- Content -->
      <main class="content">
        <h1>Recent Projects</h1>
        <div class="card-grid">
          <!-- Create Project Card -->
          <div class="card" id="openModalBtn">
            <img src="img/create.svg" alt="" width="40" />
            <p>Create New Project</p>
          </div>

          <!-- Modal Structure -->
          <div class="modal" id="projectModal">
            <div class="modal-content1">
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
                <!-- <a href="create.php" class="button">Create Project</a> -->
                <!-- <button type="button1" class="cancel-btn1" onclick="window.location.href='index.php'">Cancel</button> -->
                
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

    <!-- Profile Picture Section -->
    <div class="profile-photo-container">
      <!-- Default Profile Image -->
      <img src="img/default-profile.jpg" alt="Profile Picture" id="profile-img" onclick="document.getElementById('fileInput').click();" />
      
      <!-- Hidden File Input -->
      <input type="file" id="fileInput" accept="image/*" style="display:none" onchange="previewImage(event)" />
      <p class="change-photo-text">Click image to change profile picture</p>
    </div>

    <!-- Account Information -->
    <div class="account-info">
      <p><span class="info-label">ID:</span> <span class="info-value" id="id">12345</span></p>
      <p><span class="info-label">Username:</span> <span class="info-value" id="username">johndoe99</span></p>
    </div>

    <!-- Action Buttons -->
    <div class="button-container">
      <button id="logout-btn">Log Out</button>
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

  <style>
    body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background-color: #121212;
  color: #E0E0E0;
}

.dashboard {
  display: flex;
  height: 100vh;
}

/* Sidebar */
.sidebar {
  width: 240px;
  background-color: #1E1E2F;
  border-right: 1px solid #2C2C3A;
  padding: 30px 20px;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #F3F4F6;
  font-size: 24px; /* Adjust this value to make the text bigger */
}

.logo-icon {
  width: 50px; /* Adjust width to make the icon bigger */
  height: auto;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 30px;
}

nav {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.nav-link {
  text-decoration: none;
  color: #FFFFFF !important; /* White text for all links */
  font-size: 20px; /* Uniform font size for all links */
  font-weight: 500;
  height: 50px; /* Ensure there's enough height for centering */
  padding: 0 20px; /* Horizontal padding */
  border-radius: 8px;
  text-align: center; /* Center text horizontally */
  line-height: 50px; /* Vertically center the text within the link */
  transition: color 0.3s, background-color 0.3s, box-shadow 0.3s;
  display: block; /* Make the link behave like a block-level element */
  justify-content: center;
}

.nav-link:hover {
  color: #FFFFFF !important; /* Ensure hover links have white text */
  cursor: pointer;
}

.nav-link.active {
  background-color: #7E36D8; /* Purple background for active link */
  font-size: 20px;
  font-weight: 700; /* Make text bold for active state */
  color: #FFFFFF !important; /* Ensure the text stays white for active links */
  border-radius: 8px; /* Optional: keeps the rounded corners */
  box-shadow: 0 0 20px rgba(126, 54, 216, 0.5), 0 0 5px rgba(126, 54, 216, 0.7); /* Stronger and more distinct shadow */
  outline: 2px solid rgba(126, 54, 216, 0.8); /* Add a distinct outline for more emphasis */
}

.nav-link:hover.active {
  background-color: #6a28b1; /* Slightly darker purple for active link on hover */
}

.nav-link.projects {
  background-color: #2196F3; /* Blue background for My Projects link */
}

.nav-link.settings {
  background-color: #FF5722; /* Orange background for Settings link */
}

.nav-link:hover.projects {
  background-color: #1976D2; /* Darker blue for hover on My Projects */
}

.nav-link:hover.settings {
  background-color: #E64A19; /* Darker orange for hover on Settings */
}

.nav-link.active:hover {
  background-color: #6a28b1; /* Slightly darker purple for active hover */
}

/* Adjust the Dashboard button */
.nav-link.dashboard {
  padding: 0px 20px; /* Smaller padding for the Dashboard button */
  font-size: 20px; /* Slightly smaller font size for Dashboard */
}

/* Main Content Area */
.main {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background-color: #1A1A27;
}

/* Top Nav */
.top-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 30px;
  background-color: #1E1E2F;
  border-bottom: 1px solid #2C2C3A;
}

.top-nav input[type="text"] {
  padding: 10px 15px;
  border-radius: 8px;
  border: 1px solid #333;
  background-color: #2A2A3A;
  color: #E0E0E0;
  width: 300px;
}

.top-nav a {
  text-decoration: none;
  color: #A78BFA;
  font-weight: 500;
}

/* Content */
.content {
  padding: 30px;
}

.content h1 {
  margin-bottom: 20px;
  color: #E0E0E0;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
}

.card {
    background-color: #2A2A3A;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    cursor: pointer;
    display: flex; /* Ensure it's a flex container */
    flex-direction: column; /* Stack the content vertically */
    align-items: center; /* Center align the content */
}

.card a {
    text-decoration: none; /* Remove underline from link */
    color: inherit; /* Inherit color from parent */
    display: block; /* Make the entire card clickable */
    width: 100%; /* Ensure the link takes the full width of the card */
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.card {
  position: relative;
  padding: 20px;
  border-radius: 10px;
  background-color: #1f1f2e;
  color: #fff;
  text-align: center;
  transition: transform 0.2s;
}

.card:hover {
  transform: translateY(-5px);
}

.delete-form {
  position: absolute;
  top: 8px;
  right: 8px;
}

.trash-btn {
  background: none;
  border: none;
  font-size: 16px;
  cursor: pointer;
  color: #bbb;
  transition: color 0.2s ease;
}

.trash-btn:hover {
  color: #e74c3c;
}


.delete-form {
  display: flex;
  justify-content: flex-end;
}

/* Profile Photo Section */
.profile-photo-container {
  text-align: center;
  margin-bottom: 20px;
}

.profile-photo-container img {
  width: 120px; /* Size of the profile image */
  height: 120px;
  border-radius: 50%; /* Circular image */
  object-fit: cover;
  cursor: pointer; /* Indicating it's clickable */
  border: 3px solid #7e36d8; /* Purple border around the image */
  transition: transform 0.3s;
}

.profile-photo-container img:hover {
  transform: scale(1.1); /* Slight zoom effect on hover */
}

.change-photo-text {
  font-size: 14px;
  color: #6b7a99;
  margin-top: 10px;
  cursor: pointer;
}

/* Modal Styling */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Dark transparent background */
  overflow: auto;
  transition: opacity 0.3s ease-in-out;
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #1E1E2F; /* White background for modal content */
  border-radius: 12px;
  width: 400px;
  padding: 25px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.3s ease-out;
  background-color:#232331; /* Soft light gray background */
}

/* Slide-in effect */
@keyframes slideIn {
  from {
    transform: translate(-50%, -60%);
    opacity: 0;
  }
  to {
    transform: translate(-50%, -50%);
    opacity: 1;
  }
}

/* Close Button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 30px;
  font-weight: bold;
  color: #7e36d8; /* Purple close button */
  cursor: pointer;
  transition: color 0.3s;
}

.close-btn:hover {
  color: #ff6363; /* Red on hover */
}

/* Account Information Styles */
.modal-content h2 {
  font-size: 24px;
  color: #7e36d8; /* Purple for header */
  text-align: center;
  margin-bottom: 20px;
}

.modal-content p {
  font-size: 16px;
  color: #555; /* Gray text for general info */
  margin: 10px 0;
}

.modal-content img {
  display: block;
  margin: 0 auto 20px;
  border-radius: 50%;
  width: 120px;
  height: 120px;
  object-fit: cover;
  border: 3px solid #7e36d8; /* Purple border around the image */
}

/* Information Labels */
.modal-content .info-label {
  font-weight: bold;
  color:#b4b4b4; /* Darker color for labels */
}

.modal-content .info-value {
  color: #E0E0E0; /* Slightly lighter gray for the values */
  font-size: 16px;
}

/* Button Container */
.modal-content .button-container {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 20px;
}

/* Buttons Styling */
.modal-content button {
  background-color: #7e36d8; /* Purple background for buttons */
  color: #E0E0E0; /* White text on buttons */
  font-size: 16px;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 100px; /* Make buttons consistent in size */
}

.modal-content button:hover {
  background-color: #6a28b1; /* Darker purple on hover */
}

/* Responsive Adjustments */
@media (max-width: 480px) {
  .modal-content {
    width: 90%;
    padding: 15px;
  }
  .modal-content h2 {
    font-size: 20px;
  }
  .modal-content p {
    font-size: 14px;
  }
}

/* Specific styling for New Project Modal */
#projectModal {
  display: none;  /* Keep it hidden initially */
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
}

/* Modal content specific to New Project Modal */
#projectModal .modal-content1 {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #2A2A3A;
  padding: 30px;
  border-radius: 12px;
  color: white;
  width: 500px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
  
  /* Center the content */
  display: flex;
  flex-direction: column;
  align-items: center; /* Horizontally center the content */
  justify-content: center; /* Vertically center the content */
}

#projectModal h2 {
  text-align: center;
  font-size: 1.5rem;
  margin-bottom: 20px;
}

#projectModal .form-group {
  margin-bottom: 20px;
}

#projectModal .form-group label {
  font-weight: bold;
}

#projectModal input[type="text"],
#projectModal textarea,
#projectModal input[type="file"] {
  width: 94%;
  padding: 12px;
  background-color: #1E1E2F;
  color: #fff;
  border: 1px solid #444;
  border-radius: 8px;
}

#projectModal textarea {
  resize: vertical;
  min-height: 100px;
}

#projectModal .button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}

.button {
    display: inline-block;
    padding: 12px 24px;
    background-color: #5D5FEF;
    color: white;
    text-align: center;
    text-decoration: none; /* Prevent link underline */
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Adds some shadow to make it pop */
}

.button:hover {
    background-color: #4b4de0;
    transform: scale(1.05); /* Slight zoom effect on hover */
}

.button:active {
    background-color: #3d3fd8; /* Darker shade when clicked */
}

#projectModal .cancel-btn1 {
    display: inline-block;
    padding: 12px 24px;
    background-color: #5D5FEF;
    color: white;
    text-align: center;
    text-decoration: none; /* Prevent link underline */
    border-radius: 8px;
    font-weight: bolder;
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Adds some shadow to make it pop */
}

#projectModal .cancel-btn1:hover {
    background-color: #4b4de0;
    transform: scale(1.05); /* Slight zoom effect on hover */
}

#projectModal .close-btn1 {
  font-size: 24px;
  font-weight: bold;
  color: #fff;
  cursor: pointer;
  position: absolute;
  top: 10px;
  right: 10px;
}



  </style>
</body>

