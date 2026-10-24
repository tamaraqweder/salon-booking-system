
<?php

class Review
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Add a new review
    public function addReview($booking_id, $rating, $comment)
    {
        $sql = "INSERT INTO reviews (booking_id, rating, comment)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $booking_id,
            $rating,
            $comment
        ]);
    }

    // Check if a booking already has a review
    public function hasReview($booking_id)
    {
        $sql = "SELECT review_id
                FROM reviews
                WHERE booking_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$booking_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

}
?>
