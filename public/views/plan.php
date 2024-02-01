<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/plan.css">
    <title>Plan</title>
</head>
<body>
<div class="container">
    <?php
    // Check if the user is an admin
    $isAdmin = isset($_SESSION['Admin']);
    ?>

    <div class="buttons">
        <?php if ($isAdmin): ?>
            <button id="addGroupToCourse">Add Group to Course</button>
            <button id="addCourse">Add Course</button>
        <?php endif; ?>
        <button id="backButton">Back</button>
    </div>
    <div class="plan" id="planContainer">
        <?php
        // Organize courses by days
        $coursesByDay = [];
        foreach ($courses as $course) {
            $coursesByDay[$course->getDay()][] = [
                'courseName' => $course->getCourseName(),
                'courseStart' => $course->getCourseStart(),
                'courseEnd' => $course->getCourseEnd(),
                'lecturer' => $course->getLecturer(),
            ];
        }
        ?>

        <script>
            const coursesByDay = <?= json_encode($coursesByDay); ?>;
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

            const planContainer = document.getElementById('planContainer');

            days.forEach(day => {
                const dayColumn = document.createElement('div');
                dayColumn.classList.add('day-column');
                dayColumn.innerHTML = `<p>${day}</p>`;

                if (coursesByDay[day]) {
                    // Sort courses by time
                    coursesByDay[day].sort((a, b) => {
                        return new Date('1970/01/01 ' + a.courseStart) - new Date('1970/01/01 ' + b.courseStart);
                    });

                    coursesByDay[day].forEach(course => {
                        const courseElement = document.createElement('div');
                        courseElement.classList.add('course');
                        courseElement.innerHTML = `
                    <p>${course.courseName}</p>
                    <p>${course.courseStart} - ${course.courseEnd}</p>
                    <p>${course.lecturer}</p>
                `;
                        dayColumn.appendChild(courseElement);
                    });
                } else {
                    const noCoursesElement = document.createElement('p');
                    noCoursesElement.textContent = `No courses for ${day}`;
                    dayColumn.appendChild(noCoursesElement);
                }

                planContainer.appendChild(dayColumn);
            });
        </script>

    <script>
        document.getElementById('backButton').addEventListener('click', function () {
            window.location.href = 'menu';
        });
        document.getElementById('addCourse').addEventListener('click', function () {
            window.location.href = 'addCourse';
        });
        document.getElementById('addGroupToCourse').addEventListener('click', function () {
            window.location.href = 'addGroupToCourse'; // Corrected route
        });
    </script>
</div>
</body>
</html>
