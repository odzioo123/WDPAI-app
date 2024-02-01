<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/addGroupToCourse.css">
    <title>Add Group to Course</title>
</head>
<body>
<div class="container">
    <div class="options-container">
        <form method="post" action="addGroupToCourse">

            <label for="groupName">Group Name:</label>
            <input type="text" id="groupName" name="groupName" required>

            <label for="courseName">Course Name:</label>
            <input type="text" id="courseName" name="courseName" required>

            <button type="submit" name="addGroupToCourseButton">Add Group to Course</button>
        </form>

        <form method="get" action="plan">
            <button>Back</button>
        </form>
    </div>
</div>
</body>
</html>