
<?php

session_start();

require "../classes/Database.php";
require "../classes/Booking.php";

$database = new Database();
$pdo = $database->connect();

$booking = new Booking($pdo);

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_POST["delete_booking"])) {

    $booking_id = filter_input(
        INPUT_POST,
        "booking_id",
        FILTER_VALIDATE_INT
    );

    if ($booking_id) {
        $booking->deleteBooking($booking_id);
    }
}

header("Location: bookings.php");
exit;
