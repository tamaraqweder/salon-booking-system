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

if (isset($_POST["add_schedule"])) {

    $staff_id = $_POST["staff_id"];
    $day_of_week = $_POST["day_of_week"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $result = $schedule->addSchedule(
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

$allSchedules = $schedule->getAllSchedules();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Schedules | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/schedules.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="schedules-page">

        <h1>Manage Schedules</h1>
        <p>Manage staff working days and hours</p>


        
<section class="add-schedule">

    <h2>Add New Schedule</h2>

    <form method="POST">

        <label for="staff_id">Staff ID</label>
        <input
            type="number"
            id="staff_id"
            name="staff_id"
            min="1"
            required
        >

        <label for="day_of_week">Day of Week</label>
        <select id="day_of_week" name="day_of_week" required>
            <option value="">Select Day</option>
            <option value="Sunday">Sunday</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
        </select>

        <label for="start_time">Start Time</label>
        <input
            type="time"
            id="start_time"
            name="start_time"
            required
        >

        <label for="end_time">End Time</label>
        <input
            type="time"
            id="end_time"
            name="end_time"
            required
        >

        <button type="submit" name="add_schedule">
            Add Schedule
        </button>

    </form>

</section>


<section class="schedules-list">

            <h2>Staff Schedules</h2>

            <table>

                <thead>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Staff ID</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($allSchedules as $item): ?>
                        
<tr>
    <td><?= htmlspecialchars($item["schedule_id"]) ?></td>
    <td><?= htmlspecialchars($item["staff_id"]) ?></td>
    <td><?= htmlspecialchars($item["day_of_week"]) ?></td>
    <td><?= htmlspecialchars($item["start_time"]) ?></td>
    <td><?= htmlspecialchars($item["end_time"]) ?></td>

    <td>
        <a href="edit-schedule.php?id=<?= $item['schedule_id'] ?>"
           class="edit-btn">
            Edit
        </a>

        <form action="delete-schedule.php"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this schedule?');">

            <input
                type="hidden"
                name="schedule_id"
                value="<?= htmlspecialchars($item['schedule_id']) ?>"
            >

            <button type="submit" name="delete_schedule" class="delete-btn">
                Delete
            </button>

        </form>
    </td>
</tr>


                       
                    <?php endforeach; ?>

                </tbody>

            </table>

        </section>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
