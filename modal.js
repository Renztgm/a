// JavaScript for Modal
const accountBtn = document.getElementById('account-btn');  // The button that opens the modal
const modal = document.getElementById('account-modal');    // The modal
const closeBtn = document.getElementById('close-btn');     // The close button inside the modal

// Show modal when "My Account" is clicked
accountBtn.addEventListener('click', () => {
  modal.style.display = 'block'; // Show the modal
});

// Close modal when the close button is clicked
closeBtn.addEventListener('click', () => {
  modal.style.display = 'none'; // Hide the modal
});

// Close modal if clicked outside of the modal content
window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.style.display = 'none'; // Hide the modal if clicked outside
  }
});

// Function to preview the image after file selection
function previewImage(event) {
    const file = event.target.files[0]; // Get the selected file
    const reader = new FileReader();
  
    reader.onload = function(e) {
      // Update the profile image with the selected image
      document.getElementById('profile-img').src = e.target.result;
    }
  
    // Read the file as a data URL (base64 format)
    reader.readAsDataURL(file);
  }

// Get the modal
const projectModal = document.getElementById("projectModal");

// Get the button that opens the modal
const openBtn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
const closeBtn1 = document.getElementById("closeModalBtn");

// When the user clicks on the button, open the modal
openBtn.onclick = function () {
  projectModal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function () {
  projectModal.style.display = "none";
};

// Close modal if clicked outside of modal content
window.onclick = function (event) {
  if (event.target == projectModal) {
    projectModal.style.display = "none";
  }
};
