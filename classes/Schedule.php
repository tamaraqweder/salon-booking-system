<?php

class Schedule {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSchedules() {

        $sql = "SELECT * FROM staff_schedules";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function addSchedule($staff_id, $day_of_week, $start_time, $end_time) {

    $sql = "INSERT INTO staff_schedules
            (staff_id, day_of_week, start_time, end_time)
            VALUES (?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $staff_id,
        $day_of_week,
        $start_time,
        $end_time
    ]);

}
 public function getScheduleById($schedule_id) {

        $sql = "SELECT * FROM staff_schedules
                WHERE schedule_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$schedule_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    
public function updateSchedule($schedule_id, $staff_id, $day_of_week, $start_time, $end_time) {

    $sql = "UPDATE staff_schedules
            SET staff_id = ?,
                day_of_week = ?,
                start_time = ?,
                end_time = ?
            WHERE schedule_id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $staff_id,
        $day_of_week,
        $start_time,
        $end_time,
        $schedule_id
    ]);
}


}