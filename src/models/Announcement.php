<?php

namespace models;

use AnnouncementRepository;
require_once __DIR__.'/../repository/AnnouncementRepository.php';
class Announcement
{
    private $AnnouncementID;
    private $Text;
    private $Time_published;
    private $AdminID;
    public function __construct(
        string $Text,
        int $AdminID
    )
    {
        $this->Text = $Text;
        $this->AdminID = $AdminID;
    }
    public function getAnnouncementID(): int
    {
        return $this->AnnouncementID;
    }
    public function setAnnouncementID(int $AnnouncementID): void
    {
        $this->AnnouncementID = $AnnouncementID;
    }
    public function getText(): string
    {
        return $this->Text;
    }
    public function setText(string $Text): void
    {
        $this->Text = $Text;
    }
    public function getTimePublished(): string
    {
        return $this->Time_published;
    }
    public function setTimePublished(string $Time_published): void
    {
        $this->Time_published = $Time_published;
    }
    public function getAdminID(): int
    {
        return $this->AdminID;
    }
    public function setAdminID(int $AdminID): void
    {
        $this->AdminID = $AdminID;
    }
    public function addAnnouncement(string $text, int $adminID): bool
    {
        $announcement = new Announcement($text, $adminID);

        $announcementRepository = new AnnouncementRepository();
        return $announcementRepository->addAnnouncement($announcement);
    }

}
