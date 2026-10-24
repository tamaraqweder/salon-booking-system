
<?php

session_start();

require "../classes/Database.php";
require "../classes/Booking.php";

$database = new Database();
$pdo = $database->connect();

$booking = new Booking($pdo);

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "customer") {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_POST["cancel_booking"])) {

    $booking_id = $_POST["booking_id"];

    $selectedBooking = $booking->getBookingById($booking_id);

    if ($selectedBooking == false) {
        die("Booking not found.");
    }

    if ($selectedBooking["user_id"] != $_SESSION["user_id"]) {
        die("You cannot cancel this booking.");
    }

    if ($selectedBooking["status"] == "cancelled") {
        die("Booking already cancelled.");
    }

    $sql = "UPDATE bookings
            SET status = 'cancelled'
            WHERE booking_id = ? AND user_id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $booking_id,
        $_SESSION["user_id"]
    ]);

    header("Location: my-bookings.php");
    exit;
}

header("Location: my-bookings.php");
exit;

?>
