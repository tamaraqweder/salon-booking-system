
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


if (isset($_POST["add_booking"])) {

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

    $result = $booking->addBooking(
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


$allBookings = $booking->getAllBookings();

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Bookings | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/bookings.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="bookings-page">

        <h1>Manage Bookings</h1>
        <p>Manage customer appointments and bookings</p>


        <section class="add-booking">

            <h2>Add New Booking</h2>

            <form method="POST">

                <label for="user_id">User ID</label>
                <input type="number"
                       id="user_id"
                       name="user_id"
                       min="1"
                       required>

                <label for="service_id">Service ID</label>
                <input type="number"
                       id="service_id"
                       name="service_id"
                       min="1"
                       required>

                <label for="staff_id">Staff ID</label>
                <input type="number"
                       id="staff_id"
                       name="staff_id"
                       min="1"
                       required>

                <label for="booking_date">Booking Date</label>
                <input type="date"
                       id="booking_date"
                       name="booking_date"
                       required>

                <label for="start_time">Start Time</label>
                <input type="time"
                       id="start_time"
                       name="start_time"
                       required>

                <label for="end_time">End Time</label>
                <input type="time"
                       id="end_time"
                       name="end_time"
                       required>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <button type="submit" name="add_booking">
                    Add Booking
                </button>

            </form>

        </section>


        <section class="bookings-list">

            <h2>All Bookings</h2>

            <table>

                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User ID</th>
                        <th>Service ID</th>
                        <th>Staff ID</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($allBookings as $item): ?>

                        <tr>

                            <td><?= htmlspecialchars($item["booking_id"]) ?></td>
                            <td><?= htmlspecialchars($item["user_id"]) ?></td>
                            <td><?= htmlspecialchars($item["service_id"]) ?></td>
                            <td><?= htmlspecialchars($item["staff_id"]) ?></td>
                            <td><?= htmlspecialchars($item["booking_date"]) ?></td>
                            <td><?= htmlspecialchars($item["start_time"]) ?></td>
                            <td><?= htmlspecialchars($item["end_time"]) ?></td>
                            <td><?= htmlspecialchars($item["status"]) ?></td>

                            <td>

                                <a href="edit-booking.php?id=<?= $item['booking_id'] ?>"
                                   class="edit-btn">
                                    Edit
                                </a>

                                <form action="delete-booking.php"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this booking?');">

                                    <input
                                        type="hidden"
                                        name="booking_id"
                                        value="<?= htmlspecialchars($item['booking_id']) ?>"
                                    >

                                    <button type="submit"
                                            name="delete_booking"
                                            class="delete-btn">
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
