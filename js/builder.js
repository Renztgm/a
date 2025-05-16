document.addEventListener('DOMContentLoaded', function() {
    const toolButtons = document.querySelectorAll('.tool-btn');
    const previewArea = document.getElementById('preview-area');

    toolButtons.forEach(button => {
        button.addEventListener('click', function() {
            const elementType = this.getAttribute('data-element');
            addElement(elementType);
        });
    });

    function addElement(type) {
        let element;
        
        switch(type) {
            case 'navbar':
                element = document.createElement('nav');
                element.className = 'preview-navbar';
                element.innerHTML = `
        <div class="nav-container">
            <div class="preview-logo empty">
                <div class="logo-container">
                    <img src="../img/placeholder-logo.svg" alt="Logo" class="logo-image">
                    <div class="logo-overlay">
                        <i class="fas fa-upload"></i>
                        <span>Upload Logo</span>
                    </div>
                </div>
                <input type="file" class="logo-upload" accept="image/*" style="display: none;">
            </div>
            <h1 class="preview-heading header-title" contenteditable="true">Website Title</h1>
            <div class="nav-links">
                <a href="#" contenteditable="true">Home</a>
                <a href="#" contenteditable="true">About</a>
                <a href="#" contenteditable="true">Services</a>
                <a href="#" contenteditable="true">Contact</a>
            </div>
        </div>
        <div class="component-controls">
            <button class="delete-component">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;

    // Add logo upload functionality
    const logoUpload = element.querySelector('.logo-upload');
    const logoContainer = element.querySelector('.logo-container');
    
    logoContainer.addEventListener('click', (e) => {
        e.stopPropagation();
        logoUpload.click();
    });

    logoUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    // Set maximum dimensions
                    const maxWidth = 120;
                    const maxHeight = 40;
                    
                    // Calculate aspect ratio
                    let width = img.width;
                    let height = img.height;
                    const ratio = Math.min(maxWidth / width, maxHeight / height);
                    
                    width = width * ratio;
                    height = height * ratio;
                    
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    element.querySelector('.logo-image').src = canvas.toDataURL('image/png');
                    element.querySelector('.preview-logo').classList.remove('empty');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Add to preview area
    previewArea.insertBefore(element, previewArea.firstChild);
    return;
            case 'heading':
                element = document.createElement('h2');
                element.className = 'preview-heading';
                element.contentEditable = true;
                element.textContent = 'New Heading';
                element.innerHTML += `
                    <div class="component-controls">
                        <button class="delete-component">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                break;

            case 'text':
                element = document.createElement('p');
                element.className = 'preview-text';
                element.contentEditable = true;
                element.textContent = 'Add your text here';
                element.innerHTML += `
                    <div class="component-controls">
                        <button class="delete-component">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                break;

            case 'image':
                element = document.createElement('div');
                element.className = 'preview-image-container';
                element.innerHTML = `
                    <img src="../img/placeholder.jpg" alt="Preview Image" class="preview-image">
                    <input type="file" class="image-upload" accept="image/*" style="display: none;">
                    <div class="component-controls">
                        <button class="delete-component">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                
                // Add image upload functionality
                const imgInput = element.querySelector('.image-upload');
                const img = element.querySelector('.preview-image');
                element.addEventListener('click', () => imgInput.click());
                imgInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = e => img.src = e.target.result;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
                break;

            case 'button':
                element = document.createElement('button');
                element.className = 'preview-button';
                element.contentEditable = true;
                element.textContent = 'Click Me';
                element.innerHTML += `
                    <div class="component-controls">
                        <button class="delete-component">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                break;

            case 'logo':
                element = document.createElement('div');
                element.className = 'preview-logo empty';
                element.innerHTML = `
                    <div class="logo-container">
                        <img src="../img/placeholder-logo.svg" alt="Logo" class="logo-image">
                        <div class="logo-overlay">
                            <i class="fas fa-upload"></i>
                            <span>Click to upload logo</span>
                        </div>
                    </div>
                    <input type="file" class="logo-upload" accept="image/*" style="display: none;">
                    <div class="component-controls">
                        <button class="delete-component">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;

                // Add click handler for logo container
                const logoContainerLogo = element.querySelector('.logo-container');
                logoContainerLogo.addEventListener('click', function(e) {
                    e.stopPropagation();
                    element.querySelector('.logo-upload').click();
                });

                // Handle file upload
                const fileInput = element.querySelector('.logo-upload');
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = new Image();
                            img.onload = function() {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                
                                // Set maximum dimensions
                                const maxWidth = 150;
                                const maxHeight = 60;
                                
                                // Calculate aspect ratio
                                let width = img.width;
                                let height = img.height;
                                const ratio = Math.min(maxWidth / width, maxHeight / height);
                                
                                // Set new dimensions
                                width = width * ratio;
                                height = height * ratio;
                                
                                // Set canvas dimensions
                                canvas.width = width;
                                canvas.height = height;
                                
                                // Draw and resize image
                                ctx.drawImage(img, 0, 0, width, height);
                                
                                // Update logo image and remove empty state
                                element.querySelector('.logo-image').src = canvas.toDataURL('image/png');
                                element.classList.remove('empty');
                            };
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Add delete functionality
                const deleteBtn = element.querySelector('.delete-component');
                deleteBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (confirm('Are you sure you want to delete this logo?')) {
                        element.remove();
                    }
                });

                // Check if header section exists
                let headerSection = document.querySelector('.header-section');
                if (!headerSection) {
                    headerSection = document.createElement('div');
                    headerSection.className = 'header-section';
                    previewArea.insertBefore(headerSection, previewArea.firstChild);
                }
                
                // Add to header section
                headerSection.insertBefore(element, headerSection.firstChild);
                return;
        }

        if (element) {
            // Add delete functionality to all components
            const deleteBtn = element.querySelector('.delete-component');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (confirm('Are you sure you want to delete this component?')) {
                        element.remove();
                    }
                });
            }

            // Add to preview area
            previewArea.appendChild(element);
        }
    }

    function addDragListeners(element) {
        element.addEventListener('dragstart', handleDragStart);
        element.addEventListener('dragend', handleDragEnd);
    }

    function handleDragStart(e) {
        this.style.opacity = '0.4';
        e.dataTransfer.effectAllowed = 'move';
    }

    function handleDragEnd(e) {
        this.style.opacity = '1';
    }

    // Add preview button functionality
    const previewBtn = document.querySelector('.preview-btn');
    previewBtn.addEventListener('click', function() {
        // Get the preview area content
        const previewContent = document.getElementById('preview-area').innerHTML;
        
        // Send the content to the server
        fetch('save-preview.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content: previewContent })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Open preview in new tab
                window.open('preview.php', '_blank');
            }
        });
    });

    // Add save button functionality
    const saveBtn = document.querySelector('.save-btn');
    saveBtn.addEventListener('click', function() {
        // Show project title input dialog
        const title = prompt('Enter project title:');
        if (!title) return;

        const previewContent = document.getElementById('preview-area').innerHTML;
        
        // Send the content to the server
        fetch('save-project.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title: title,
                content: previewContent
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Project saved successfully!');
            } else {
                alert('Error saving project: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving project');
        });
    });

    function showNavbarProperties(navbar) {
        const propertiesPanel = document.querySelector('.properties-content');
        propertiesPanel.innerHTML = `
            <div class="property-group">
                <h4>Navbar Properties</h4>
                
                <div class="property-item">
                    <label>Background Color</label>
                    <input type="color" id="navBgColor" value="#1e1e2f">
                </div>
                
                <div class="property-item">
                    <label>Link Color</label>
                    <input type="color" id="navLinkColor" value="#ffffff">
                </div>
                
                <div class="property-item">
                    <label>Font Size</label>
                    <input type="range" id="navFontSize" min="12" max="24" value="16">
                    <span class="value-display">16px</span>
                </div>
                
                <div class="property-item">
                    <label>Link Spacing</label>
                    <input type="range" id="navLinkSpacing" min="10" max="60" value="40">
                    <span class="value-display">40px</span>
                </div>
                
                <div class="property-item">
                    <label>Alignment</label>
                    <select id="navAlignment">
                        <option value="flex-start">Left</option>
                        <option value="center" selected>Center</option>
                        <option value="flex-end">Right</option>
                    </select>
                </div>
                
                <div class="property-item">
                    <label>Padding</label>
                    <input type="range" id="navPadding" min="5" max="30" value="15">
                    <span class="value-display">15px</span>
                </div>
            </div>
        `;

        // Add event listeners for property changes
        document.getElementById('navBgColor').addEventListener('input', function(e) {
            navbar.style.backgroundColor = e.target.value;
        });

        document.getElementById('navLinkColor').addEventListener('input', function(e) {
            navbar.querySelectorAll('a').forEach(link => {
                link.style.color = e.target.value;
            });
        });

        document.getElementById('navFontSize').addEventListener('input', function(e) {
            navbar.querySelectorAll('a').forEach(link => {
                link.style.fontSize = e.target.value + 'px';
            });
            this.nextElementSibling.textContent = e.target.value + 'px';
        });

        document.getElementById('navLinkSpacing').addEventListener('input', function(e) {
            navbar.querySelector('.nav-links').style.gap = e.target.value + 'px';
            this.nextElementSibling.textContent = e.target.value + 'px';
        });

        document.getElementById('navAlignment').addEventListener('change', function(e) {
            navbar.querySelector('.nav-links').style.justifyContent = e.target.value;
        });

        document.getElementById('navPadding').addEventListener('input', function(e) {
            navbar.style.padding = e.target.value + 'px 30px';
            this.nextElementSibling.textContent = e.target.value + 'px';
        });
    }
});