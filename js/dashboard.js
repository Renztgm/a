function deleteProject(projectId) {
    if (confirm('Are you sure you want to delete this project?')) {
        fetch('delete-project.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: projectId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting project');
            }
        });
    }
}