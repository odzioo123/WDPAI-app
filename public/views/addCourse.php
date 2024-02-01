<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/addCourse.css">
    <title>Add Course</title>
</head>
<body>
<div class="container">
    <h2>Add Course</h2>
    <form action="addCourse" method="post">
        <label for="courseName">Course Name:</label>
        <input type="text" id="courseName" name="courseName" required>

        <label for="courseStart">Course Start Time:</label>
        <input type="time" id="courseStart" name="courseStart" required>

        <label for="courseEnd">Course End Time:</label>
        <input type="time" id="courseEnd" name="courseEnd" required>

        <label for="day">Day:</label>
        <select id="day" name="day" required>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
        </select>

        <label for="lecturer">Lecturer:</label>
        <input type="text" id="lecturer" name="lecturer" required>

        <button type="submit">Add Course</button>
        <button id="backButton">Back</button>
    </form>
    <script>
        document.getElementById('backButton').addEventListener('click', function () {
            window.location.href = 'plan';
        });
    </script>
</div>
</body>
</html>
