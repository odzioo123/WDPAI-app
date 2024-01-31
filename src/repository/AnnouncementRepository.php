<?php

use models\Announcement;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Announcement.php';
class AnnouncementRepository extends Repository
{

    public function addAnnouncement(Announcement $announcement): bool
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."Announcements" ("Text", "Time_published", "AdminID")
            VALUES (:text, CURRENT_TIMESTAMP, :adminID)
        ');

        $text = $announcement->getText();
        $adminID = $announcement->getAdminID();

        $stmt->bindParam(':text', $text, PDO::PARAM_STR);
        $stmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAnnouncements(): array
    {
        $stmt = $this->database->connect()->query('
            SELECT "AnnouncementID", "Text", TO_CHAR("Time_published", \'YYYY-MM-DD HH24:MI\') AS "Time_published", "AdminID"
        FROM public."Announcements"
        ORDER BY "Time_published"
        ');

        $announcements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $announcement = new Announcement($row['Text'], $row['AdminID']);
            $announcement->setAnnouncementID($row['AnnouncementID']);
            $announcement->setTimePublished($row['Time_published']);
            $announcements[] = $announcement;
        }

        return $announcements;
    }


}