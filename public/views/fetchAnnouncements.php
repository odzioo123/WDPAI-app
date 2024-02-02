<?php
use models\Announcement;
session_start();
require_once __DIR__.'/../../src/repository/AnnouncementRepository.php';
require_once __DIR__.'/../../src/models/Announcement.php';

$announcementRepository = new AnnouncementRepository();
$announcements = $announcementRepository->getAnnouncements();

$result = [];

foreach ($announcements as $announcement) {
    $result[] = [
        'text' => htmlspecialchars($announcement->getText()),
        'timePublished' => htmlspecialchars($announcement->getTimePublished())
    ];
}

header('Content-Type: application/json');
echo json_encode($result);

die();
?>
