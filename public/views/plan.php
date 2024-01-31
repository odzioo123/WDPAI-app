<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/plan.css">
    <title>Plan</title>
</head>
<body>
<div class="container">
    <div class="back">
        <button id="backButton">Back</button>
    </div>
    <div class="plan">
        <?php
        // Organize courses by days
        $coursesByDay = [];
        foreach ($courses as $course) {
            $coursesByDay[$course->getDay()][] = $course;
        }

        displayCoursesForDay('Monday', $coursesByDay);
        displayCoursesForDay('Tuesday', $coursesByDay);
        displayCoursesForDay('Wednesday', $coursesByDay);
        displayCoursesForDay('Thursday', $coursesByDay);
        displayCoursesForDay('Friday', $coursesByDay);
        ?>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.location.href = 'menu';
        });
    </script>
</div>
</body>
</html>

<?php
function displayCoursesForDay($day, $coursesByDay)
{
    echo '<div class="day-column">';
    echo '<p>' . $day . '</p>';

    if (isset($coursesByDay[$day])) {
        // Sort courses by time
        usort($coursesByDay[$day], function ($a, $b)
        {
            return strtotime($a->getCourseStart()) - strtotime($b->getCourseStart());
        });

        foreach ($coursesByDay[$day] as $course): ?>
            <div class="course">
                <p><?php echo $course->getCourseName(); ?></p>
                <p><?php echo $course->getCourseStart() . ' - ' . $course->getCourseEnd(); ?></p>
                <p><?php echo $course->getLecturer(); ?></p>
            </div>
        <?php endforeach;
    } else {
        echo '<p>No courses for ' . $day . '</p>';
    }

    echo '</div>';
}
?>

</html>
