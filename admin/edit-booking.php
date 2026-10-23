
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


$booking_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$booking_id) {
    header("Location: bookings.php");
    exit;
}


$bookingData = $booking->getBookingById($booking_id);

if (!$bookingData) {
    header("Location: bookings.php");
    exit;
}


if (isset($_POST["update_booking"])) {

    $user_id = $_POST["user_id"];
    $service_id = $_POST["service_id"];
    $staff_id = $_POST["staff_id"];
    $booking_date = $_POST["booking_date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $status = $_POST["status"];

    if ($start_time >= $end_time) {
        die("End time must be after start time.");
    }

    $result = $booking->updateBooking(
        $booking_id,
        $user_id,
        $service_id,
        $staff_id,
        $booking_date,
        $start_time,
        $end_time,
        $status
    );

    if ($result) {
        header("Location: bookings.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Booking | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/edit-booking.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="edit-booking-page">

        <h1>Edit Booking</h1>
        <p>Update customer booking information</p>

        <section class="edit-booking-form">

            <h2>Booking #<?= htmlspecialchars($bookingData["booking_id"]) ?></h2>

            <form method="POST">

                <label for="user_id">User ID</label>
                <input
                    type="number"
                    id="user_id"
                    name="user_id"
                    min="1"
                    value="<?= htmlspecialchars($bookingData["user_id"]) ?>"
                    required
                >

                <label for="service_id">Service ID</label>
                <input
                    type="number"
                    id="service_id"
                    name="service_id"
                    min="1"
                    value="<?= htmlspecialchars($bookingData["service_id"]) ?>"
                    required
                >

                <label for="staff_id">Staff ID</label>
                <input
                    type="number"
                    id="staff_id"
                    name="staff_id"
                    min="1"
                    value="<?= htmlspecialchars($bookingData["staff_id"]) ?>"
                    required
                >

                <label for="booking_date">Booking Date</label>
                <input
                    type="date"
                    id="booking_date"
                    name="booking_date"
                    value="<?= htmlspecialchars($bookingData["booking_date"]) ?>"
                    required
                >

                <label for="start_time">Start Time</label>
                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    value="<?= htmlspecialchars($bookingData["start_time"]) ?>"
                    required
                >

                <label for="end_time">End Time</label>
                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                    value="<?= htmlspecialchars($bookingData["end_time"]) ?>"
                    required
                >

                <label for="status">Status</label>
                <select id="status" name="status" required>

                    <option value="pending"
                        <?= $bookingData["status"] === "pending" ? "selected" : "" ?>>
                        Pending
                    </option>

                    <option value="confirmed"
                        <?= $bookingData["status"] === "confirmed" ? "selected" : "" ?>>
                        Confirmed
                    </option>

                    <option value="cancelled"
                        <?= $bookingData["status"] === "cancelled" ? "selected" : "" ?>>
                        Cancelled
                    </option>

                </select>

                <button type="submit" name="update_booking">
                    Update Booking
                </button>

            </form>

        </section>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
