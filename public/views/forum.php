<?php

use models\ForumPost;

require_once __DIR__.'/../../src/repository/ForumPostRepository.php';
require_once __DIR__.'/../../src/models/ForumPost.php';

$forumPostRepository = new ForumPostRepository();
$forumPosts = $forumPostRepository->getForumPosts();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addForumPostButton']) && ($_SESSION['Admin'] || $_SESSION['Student'])) {
    session_start();

    $userID = null;
    if (isset($_SESSION['Admin']))
    {
        $userID = $_SESSION['Admin'];
    }
    else
    {
        $userID = $_SESSION['Student'];
    }

    $text = $_POST['forumPostText'];

    if (empty(trim($text)))
    {
        echo '<script>alert("Post text cannot be empty.");</script>';
    }
    else
    {
        $forumPost = new ForumPost($text, $userID);
        $result = $forumPostRepository->addForumPost($forumPost);

        if ($result)
        {
            header("Location: forum");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/forum.css">
    <title>Forum</title>
</head>
<body>
<div class="container">
    <div class="buttons">
        <?php if (isset($_SESSION['Admin']) || isset($_SESSION['Student'])): ?>
            <form method="POST">
                <textarea name="forumPostText" id="forumPostText" placeholder="Type your post here"></textarea>
                <button type="submit" name="addForumPostButton">Add Post</button>
                <button id="backButton">Back</button>
            </form>
        <?php endif; ?>
    </div>
    <div class="forum">
        <div class="forumPostList">
            <?php foreach ($forumPosts as $forumPost): ?>
                <div class="forumPostItem">
                    <p><?= htmlspecialchars($forumPost->getText()) . ' | ' . htmlspecialchars($forumPost->getTimePublished()) ?></p>
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
