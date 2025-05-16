document.addEventListener('DOMContentLoaded', function() {
    const accountBtn = document.getElementById('account-btn');
    const accountModal = document.getElementById('account-modal');
    const closeBtn = document.getElementById('close-btn');

    // Open modal
    accountBtn.addEventListener('click', function(e) {
        e.preventDefault();
        accountModal.style.display = 'block';
    });

    // Close modal when clicking the X
    closeBtn.addEventListener('click', function() {
        accountModal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target == accountModal) {
            accountModal.style.display = 'none';
        }
    });
});