
<?php

session_start();

require "../classes/Database.php";
require "../classes/Booking.php";
require "../classes/Service.php";
require "../classes/Staff.php";
require "../classes/Schedule.php";

$database = new Database();
$pdo = $database->connect();

$booking = new Booking($pdo);
$service = new Service($pdo);
$staff = new Staff($pdo);
$schedule = new Schedule($pdo);

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "customer") {
    header("Location: ../pages/login.php");
    exit;
}

$allServices = $service->getAllServices();
$allStaff = $staff->getAllStaff();

if (isset($_POST["add_booking"])) {

    $user_id = $_SESSION["user_id"];

    $service_id = $_POST["service_id"];
    $staff_id = $_POST["staff_id"];
    $booking_date = $_POST["booking_date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $status = "pending";

    if ($start_time >= $end_time) {
        die("End time must be after start time.");
    }

    $available = $schedule->isStaffAvailable(
        $staff_id,
        $booking_date,
        $start_time,
        $end_time
    );

    if ($available == false) {
        die("Staff is not available at this time.");
    }

    $booked = $booking->isTimeBooked(
        $staff_id,
        $booking_date,
        $start_time,
        $end_time
    );

    if ($booked == true) {
        die("This time slot is already booked.");
    }

    $result = $booking->addBooking(
        $user_id,
        $service_id,
        $staff_id,
        $booking_date,
        $start_time,
        $end_time,
        $status
    );

    if ($result == true) {
        header("Location: my-bookings.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AURELIA | Book Appointment</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/booking.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="booking-page">

        <div class="booking-container">

            <div class="booking-heading">
                <span>BOOK YOUR VISIT</span>
                <h1>Book Appointment</h1>
                <p>Choose your favorite service and preferred appointment time.</p>
            </div>

            <form action="" method="POST" class="booking-form">

                <label for="service_id">Choose Service</label>
                <select name="service_id" id="service_id" required>
                    <option value="">Select Service</option>

                    <?php foreach ($allServices as $item): ?>
                        <option value="<?= htmlspecialchars($item['service_id']) ?>">
                            <?= htmlspecialchars($item['service_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="staff_id">Choose Staff</label>
                <select name="staff_id" id="staff_id" required>
                    <option value="">Select Staff</option>

                    <?php foreach ($allStaff as $item): ?>
                        <option value="<?= htmlspecialchars($item['staff_id']) ?>">
                            <?= htmlspecialchars($item['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="booking_date">Booking Date</label>
                <input
                    type="date"
                    name="booking_date"
                    id="booking_date"
                    min="<?= date('Y-m-d') ?>"
                    required
                >

                <div class="time-fields">

                    <div>
                        <label for="start_time">Start Time</label>
                        <input
                            type="time"
                            name="start_time"
                            id="start_time"
                            required
                        >
                    </div>

                    <div>
                        <label for="end_time">End Time</label>
                        <input
                            type="time"
                            name="end_time"
                            id="end_time"
                            required
                        >
                    </div>

                </div>

                <button type="submit" name="add_booking">
                    Confirm Booking
                </button>

            </form>

        </div>

    </main>

    <?php include "../includes/footer.php"; ?>

    <script src="../js/main.js"></script>

</body>
</html>
