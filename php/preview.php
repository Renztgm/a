<?php
session_start();
if (!isset($_SESSION['preview_content'])) {
    header('Location: website-builder.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - tavolozza</title>
    <link rel="stylesheet" href="../css/website-builder.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
    </style>
</head>
<body class="preview-page">
    <div class="preview-content">
        <?php
        if (isset($_SESSION['preview_content'])) {
            echo $_SESSION['preview_content'];
        }
        ?>
    </div>
</body>
</html>