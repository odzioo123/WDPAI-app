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
        <?php if (isset($_SESSION['Admin'])): ?>
            <form id="addAnnouncementForm" method="post" action="">
                <textarea name="announcementText" id="announcementText" placeholder="Type your announcement here"></textarea>
                <button type="submit" name="addAnnouncementButton" id="addAnnouncementButton">Add Announcement</button>
            </form>
        <?php endif; ?>
        <button id="backButton">Back</button>
    </div>
    <div class="announcements">
        <div class="announcementsList" id="announcementsList">
            <!-- Announcements will be dynamically loaded here -->
        </div>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            event.preventDefault();
            window.location.href = 'menu';
        });

        function loadAnnouncements() {
            fetch('public/views/fetchAnnouncements.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Response is not in JSON format');
                    }
                })
                .then(announcements => {
                    var announcementsList = document.getElementById('announcementsList');
                    announcementsList.innerHTML = '';

                    announcements.forEach(announcement => {
                        var announcementItem = document.createElement('div');
                        announcementItem.className = 'announcementItem';
                        announcementItem.innerHTML = '<p>' + announcement.text + ' | ' + announcement.timePublished + '</p>';
                        announcementsList.appendChild(announcementItem);
                    });
                })
                .catch(error => {
                    console.error('Error during fetch:', error);
                });
        }
        loadAnnouncements();
    </script>
</div>
</body>
</html>
