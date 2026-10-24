
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

$booking_id = $_GET["booking_id"] ?? 0;

if (isset($_POST["add_review"])) {
    $booking_id = $_POST["booking_id"] ?? 0;
}

if (!filter_var($booking_id, FILTER_VALIDATE_INT)) {
    die("Invalid booking.");
}

$bookingData = $booking->getBookingById($booking_id);

if (!$bookingData || $bookingData["user_id"] != $user_id) {
    die("This booking does not belong to you.");
}

if ($bookingData["status"] != "completed") {
    die("You can only review completed bookings.");
}

if ($review->hasReview($booking_id)) {
    die("You already reviewed this booking.");
}

$error = "";

if (isset($_POST["add_review"])) {

    $rating = $_POST["rating"] ?? "";
    $comment = trim($_POST["comment"] ?? "");

    if (!filter_var($rating, FILTER_VALIDATE_INT) || $rating < 1 || $rating > 5) {
        $error = "Please choose a rating from 1 to 5.";
    } else {

        $result = $review->addReview(
            $booking_id,
            $rating,
            $comment
        );

        if ($result == true) {
            header("Location: my-bookings.php");
            exit;
        }

        $error = "Could not save your review.";
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AURELIA | Add Review</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/add-review.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="add-review-page">

        <div class="add-review-container">

            <h1>Rate Your Experience</h1>


            
            <p>How was your appointment at AURELIA?</p>

            <?php if ($error != ""): ?>
                <p class="review-error">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form action="" method="POST" class="review-form">

                <input
                    type="hidden"
                    name="booking_id"
                    value="<?= htmlspecialchars($booking_id) ?>"
                >

                <label for="rating">Rating</label>

                <select name="rating" id="rating" required>
                    <option value="">Choose Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>

                <label for="comment">Your Comment</label>

                <textarea
                    name="comment"
                    id="comment"
                    rows="5"
                    placeholder="Write your review..."
                ></textarea>

                <button type="submit" name="add_review">
                    Submit Review
                </button>

            </form>

        </div>

    </main>

    <?php include "../includes/footer.php"; ?>

    <script src="../js/main.js"></script>

</body>
</html>
