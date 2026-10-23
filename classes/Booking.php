
<?php

class Booking {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllBookings() {

        $sql = "SELECT * FROM bookings";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addBooking(
        $user_id,
        $service_id,
        $staff_id,
        $booking_date,
        $start_time,
        $end_time,
        $status
    ) {

        $sql = "INSERT INTO bookings
                (user_id, service_id, staff_id,
                 booking_date, start_time, end_time, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $user_id,
            $service_id,
            $staff_id,
            $booking_date,
            $start_time,
            $end_time,
            $status
        ]);
    }


    public function getBookingById($booking_id) {

        $sql = "SELECT * FROM bookings WHERE booking_id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$booking_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateBooking(
        $booking_id,
        $user_id,
        $service_id,
        $staff_id,
        $booking_date,
        $start_time,
        $end_time,
        $status
    ) {

        $sql = "UPDATE bookings
                SET user_id = ?,
                    service_id = ?,
                    staff_id = ?,
                    booking_date = ?,
                    start_time = ?,
                    end_time = ?,
                    status = ?
                WHERE booking_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $user_id,
            $service_id,
            $staff_id,
            $booking_date,
            $start_time,
            $end_time,
            $status,
            $booking_id
        ]);
    }


    public function deleteBooking($booking_id) {

        $sql = "DELETE FROM bookings WHERE booking_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$booking_id]);
    }

}
