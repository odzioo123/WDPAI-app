<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/announcements.css">
    <title>Plan</title>
</head>
<body>
<div class="container">
    <div class="back">
        <button id="backButton">Back</button>
    </div>
    <div class="announcements"></div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.location.href = 'menu';
        });
    </script>
</div>
</body>
</html>