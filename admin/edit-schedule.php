<?php

session_start();

require "../classes/Database.php";
require "../classes/Schedule.php";

$database = new Database();
$pdo = $database->connect();

$schedule = new Schedule($pdo);

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}


$schedule_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$schedule_id) {
    header("Location: schedules.php");
    exit;
}

$scheduleData = $schedule->getScheduleById($schedule_id);

if (!$scheduleData) {
    header("Location: schedules.php");
    exit;
}


if (isset($_POST["update_schedule"])) {

    $staff_id = $_POST["staff_id"];
    $day_of_week = $_POST["day_of_week"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    if ($end_time <= $start_time) {
        $error = "End time must be later than start time.";
    } else {
        $result = $schedule->updateSchedule(
            $schedule_id,
            $staff_id,
            $day_of_week,
            $start_time,
            $end_time
        );

        if ($result) {
            header("Location: schedules.php");
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Schedule | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/edit-schedule.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="edit-schedule-page">

        <h1>Edit Schedule</h1>
        <p>Update staff working days and hours</p>

        <section class="edit-schedule-form">

            <h2>Schedule Information</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <label for="staff_id">Staff ID</label>
                <input
                    type="number"
                    id="staff_id"
                    name="staff_id"
                    min="1"
                    value="<?= htmlspecialchars($scheduleData['staff_id']) ?>"
                    required
                >

                <label for="day_of_week">Day of Week</label>

                <select id="day_of_week" name="day_of_week" required>

                    <?php
                    $days = [
                        "Sunday",
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday",
                        "Saturday"
                    ];
                    ?>

                    <?php foreach ($days as $day): ?>

                        <option
                            value="<?= $day ?>"
                            <?= $scheduleData["day_of_week"] === $day ? "selected" : "" ?>
                        >
                            <?= $day ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <label for="start_time">Start Time</label>
                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    value="<?= htmlspecialchars($scheduleData['start_time']) ?>"
                    required
                >

                <label for="end_time">End Time</label>
                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                    value="<?= htmlspecialchars($scheduleData['end_time']) ?>"
                    required
                >

                <button type="submit" name="update_schedule">
                    Update Schedule
                </button>

            </form>

        </section>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
