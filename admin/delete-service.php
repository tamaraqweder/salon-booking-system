<?php

session_start();

require "../classes/Database.php";
require "../classes/Service.php";

$database = new Database();
$pdo = $database->connect();

$services = new Service($pdo);

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
     {

    $service_id = $_POST["service_id"] ?? 0;

    if (filter_var($service_id, FILTER_VALIDATE_INT) !== false && $service_id > 0) {

        $services->deleteService($service_id);

    }
}

header("Location: services.php");
exit;