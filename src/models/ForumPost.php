<?php

namespace models;

use ForumPostRepository;
require_once __DIR__.'/../repository/ForumPostRepository.php';
class ForumPost
{
    private $ForumPostID;
    private $Text;
    private $Time_published;
    private $UserID;
    public function __construct(
        string $Text,
        int $UserID
    )
    {
        $this->Text = $Text;
        $this->UserID = $UserID;
    }
    public function getAnnouncementID(): int
    {
        return $this->ForumPostID;
    }
    public function setAnnouncementID(int $ForumPostID): void
    {
        $this->ForumPostID = $ForumPostID;
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
    public function getUserID(): int
    {
        return $this->UserID;
    }
    public function setUserID(int $UserID): void
    {
        $this->UserID = $UserID;
    }
    public function addAnnouncement(string $text, int $userID): bool
    {
        $forumPost = new ForumPost($text, $userID);

        $forumPostRepository = new ForumPostRepository();
        return $forumPostRepository->addAnnouncement($forumPost);
    }

}
