
<?php

session_start();

require "../classes/Database.php";
require "../classes/Schedule.php";

$database = new Database();
$pdo = $database->connect();

$schedule = new Schedule($pdo);

// Check Admin
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_POST["delete_schedule"])) {

    $schedule_id = $_POST["schedule_id"];

    $result = $schedule->deleteSchedule($schedule_id);

    if ($result) {
        header("Location: schedules.php");
        exit;
    }
}

header("Location: schedules.php");
exit;

?>
