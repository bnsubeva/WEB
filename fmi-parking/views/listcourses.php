<?php
include_once 'header.php';
?>

<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ParkingDB.php';
require_once __DIR__ . '/../controllers/UserController.php';

$hasCourses = false;
$courses = array();

if (is_logged_in()) {
    $courses = UserController::getCoursesByUserId($_SESSION['u_id']);
    $hasCourses = sizeof($courses) > 0;
}
?>

<?php if (is_logged_in() && $hasCourses) { ?>
    <div class="container float-left">
        <h2>Моите Курсове</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th><p>Име</p></th>
                    <th><p>Ден</p></th>
                    <th><p>Времетраене</p></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td><p><?= $course->getTitle() ?></p></td>
                        <td><p><?= $course->getCourseDay() ?></p></td>
                        <td><p>От <?= $course->getCourseFrom() ?> До <?= $course->getCourseTo() ?></p></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } else if (is_logged_in() && !$hasCourses) { ?>
    <div class="alert alert-warning" role="alert">Нямате регистрирани курсове.</div>
<?php } ?>


 