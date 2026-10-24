
<?php

session_start();

require "../classes/Database.php";
require "../classes/Booking.php";

$database = new Database();
$pdo = $database->connect();

$booking = new Booking($pdo);

// التأكد أن المستخدم Customer
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "customer") {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_POST["cancel_booking"])) {

    $booking_id = $_POST["booking_id"];

    // جلب بيانات الحجز
    $selectedBooking = $booking->getBookingById($booking_id);

    // التأكد أن الحجز موجود
    if ($selectedBooking == false) {
        die("Booking not found.");
    }

    // التأكد أن الحجز تابع للمستخدم الحالي
    if ($selectedBooking["user_id"] != $_SESSION["user_id"]) {
        die("You cannot cancel this booking.");
    }

    // منع إلغاء الحجز الملغي أو المكتمل
    if ($selectedBooking["status"] == "cancelled" ||
        $selectedBooking["status"] == "completed") {
        die("This booking cannot be cancelled.");
    }

    // إلغاء الحجز
    $booking->cancelBooking($booking_id, $_SESSION["user_id"]);
}

// الرجوع لصفحة حجوزاتي
header("Location: my-bookings.php");
exit;

?>
