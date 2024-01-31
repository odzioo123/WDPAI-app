<?php

use models\Announcement;

require_once __DIR__.'/../../src/repository/AnnouncementRepository.php';
require_once __DIR__.'/../../src/models/Announcement.php';

$announcementRepository = new AnnouncementRepository();
$announcements = $announcementRepository->getAnnouncements();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addAnnouncementButton']) && $_SESSION['Admin']) {
    session_start();

    $adminID = $_SESSION['Admin'];
    $text = $_POST['announcementText'];


    if (empty(trim($text)))
    {
        echo '<script>alert("Announcement text cannot be empty.");</script>';
    }
    else
    {
        $announcement = new Announcement($text, $adminID);
        $result = $announcementRepository->addAnnouncement($announcement);

        if ($result)
        {
            header("Location: announcements");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/announcements.css">
    <title>Announcements</title>
</head>
<body>
<div class="container">
    <div class="buttons">
        <form method="POST">
            <?php if (isset($_SESSION['Admin'])): ?>
                <textarea name="announcementText" id="announcementText" placeholder="Type your announcement here"></textarea>
                <button type="submit" name="addAnnouncementButton">Add Announcement</button>
            <?php endif; ?>
            <button id="backButton">Back</button>
        </form>
    </div>
    <div class="announcements">
        <div class="announcementsList">
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcementItem">
                    <p><?= htmlspecialchars($announcement->getText()) . ' | ' . htmlspecialchars($announcement->getTimePublished()) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            event.preventDefault();
            window.location.href = 'menu';
        });
    </script>
</div>
</body>
</html>
