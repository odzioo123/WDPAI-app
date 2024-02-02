<?php

use models\Announcement;
session_start();
require_once 'AppController.php';
require_once __DIR__.'/../models/Announcement.php';
class AnnouncementsController extends AppController {
    public function announcements()
    {
        session_start();
        if (isset($_SESSION['Admin']) || isset($_SESSION['Student']))
        {
            $this->render('announcements');
        }
        else
        {
            $this->render('login');
        }
    }

    public function fetchAnnouncements() {
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
    }
}

