<?php

session_start();

require "../classes/Database.php";
require "../classes/Staff.php";

$database = new Database();
$pdo = $database->connect();

$staff = new Staff($pdo);

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_POST["delete_staff"])) {

    $staff_id = $_POST["staff_id"] ?? 0;

    if (filter_var($staff_id, FILTER_VALIDATE_INT) !== false && $staff_id > 0) {

        $staff->deleteStaff($staff_id);

    }
}

header("Location: staff.php");
exit;