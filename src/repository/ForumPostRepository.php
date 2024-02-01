<?php

use models\ForumPost;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/ForumPost.php';
class ForumPostRepository extends Repository
{

    public function addForumPost(ForumPost $forumPost): bool
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."ForumPosts" ("Text", "Time_published", "UserID")
            VALUES (:text, CURRENT_TIMESTAMP, :userID)
        ');

        $text = $forumPost->getText();
        $userID = $forumPost->getUserID();

        $stmt->bindParam(':text', $text, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getForumPosts(): array
    {
        $stmt = $this->database->connect()->query('
            SELECT "PostID", "Text", TO_CHAR("Time_published", \'YYYY-MM-DD HH24:MI\') AS "Time_published", "UserID"
        FROM public."ForumPosts"
        ORDER BY "Time_published"
        ');

        $forumPosts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $forumPost = new ForumPost($row['Text'], $row['UserID']);
            $forumPost->setAnnouncementID($row['PostID']);
            $forumPost->setTimePublished($row['Time_published']);
            $forumPosts[] = $forumPost;
        }

        return $forumPosts;
    }


}