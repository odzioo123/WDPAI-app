<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/addUserToGroup.css">
    <title>Add User to Group</title>
</head>
<body>
<div class="container">
    <div class="form-container">
        <form method="post" action="addUserToGroupProcess">
            <label for="userEmail">User Email:</label>
            <input type="text" id="userEmail" name="userEmail" required>

            <label for="groupName">Group Name:</label>
            <input type="text" id="groupName" name="groupName" required>

            <button type="submit" name="addUserToGroupButton">Add User to Group</button>
        </form>

        <form method="get" action="menu">
            <button>Back to Menu</button>
        </form>
    </div>
</div>
</body>
</html>
