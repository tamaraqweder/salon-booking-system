
<?php

session_start();

require "../classes/Database.php";
require "../classes/Booking.php";
require "../classes/Review.php";

$database = new Database();
$pdo = $database->connect();

$booking = new Booking($pdo);
$review = new Review($pdo);

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "customer") {
    header("Location: ../pages/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$myBookings = $booking->getBookingsByUserId($user_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AURELIA | My Bookings</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/my-bookings.css">
</head>

<body>

    <!-- NAVBAR -->
    <?php include "../includes/navbar.php"; ?>

    <main class="my-bookings">

        <h1>My Bookings</h1>
        <p>View and manage your salon appointments.</p>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Service ID</th>
                        <th>Staff ID</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($myBookings as $item): ?>

                        <tr>
                            <td><?= htmlspecialchars($item["booking_id"]) ?></td>
                            <td><?= htmlspecialchars($item["service_id"]) ?></td>
                            <td><?= htmlspecialchars($item["staff_id"]) ?></td>
                            <td><?= htmlspecialchars($item["booking_date"]) ?></td>
                            <td><?= htmlspecialchars($item["start_time"]) ?></td>
                            <td><?= htmlspecialchars($item["end_time"]) ?></td>
                            <td><?= htmlspecialchars($item["status"]) ?></td>

                            <td>

                                <?php if ($item["status"] == "completed"): ?>

                                    <?php if ($review->hasReview($item["booking_id"])): ?>

                                        <span>Already Reviewed</span>

                                    <?php else: ?>

                                        <a
                                            href="add-review.php?booking_id=<?= urlencode($item["booking_id"]) ?>"
                                            class="rate-btn"
                                        >
                                            Rate
                                        </a>

                                    <?php endif; ?>

                                <?php elseif ($item["status"] != "cancelled"): ?>

                                    <form
                                        action="cancel-booking.php"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                    >

                                        <input
                                            type="hidden"
                                            name="booking_id"
                                            value="<?= htmlspecialchars($item["booking_id"]) ?>"
                                        >

                                        <button type="submit" name="cancel_booking">
                                            Cancel
                                        </button>

                                    </form>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include "../includes/footer.php"; ?>

    <script src="../js/main.js"></script>

</body>
</html>
