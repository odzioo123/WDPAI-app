<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/addStudent.css">
    <title>Add Student</title>
</head>
<body>
<div class="container">
    <div class="options-container">
        <form method="post" action="addStudentProcess">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required>

            <button type="submit" name="addStudentButton">Add Student</button>
        </form>

        <form method="get" action="menu">
            <button>Back</button>
        </form>
    </div>
</div>
</body>
</html>
