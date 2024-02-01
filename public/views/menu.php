<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/menu.css">
    <title>Menu</title>
</head>
<body>
<div class="container">
    <div class="options-container">
        <form method="get" action="plan">
            <button>Plan</button>
        </form>
        <form method="get" action="announcements">
            <button>Ogłoszenia</button>
        </form>
        <form method="get" action="forum">
            <button>Forum</button>
        </form>
        <?php if(isset($_SESSION['Admin'])): ?>
            <form method="get" action="addStudent">
                <button>Add Student</button>
            </form>
            <form method="get" action="addUserToGroup">
                <button>Add Student to Group</button>
            </form>
        <?php endif; ?>
        <form method="post" action="logout">
            <div class="logout">
                <button>Wyloguj</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
