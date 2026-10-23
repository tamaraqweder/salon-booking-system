
<?php

class Staff {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllStaff() {

        $sql = "SELECT * FROM staff";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getStaffById($staff_id) {

        $sql = "SELECT * FROM staff WHERE staff_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$staff_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
   public function addStaff($full_name, $phone, $specialization) {

    $sql = "INSERT INTO staff
            (full_name, phone, specialization)
            VALUES (?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $full_name,
        $phone,
        $specialization
    ]);
}


    public function updateStaff($staff_id, $full_name, $phone, $specialization, $is_active) {

        $sql = "UPDATE staff
                SET full_name = ?, phone = ?, specialization = ?, is_active = ?
                WHERE staff_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $full_name,
            $phone,
            $specialization,
            $is_active,
            $staff_id
        ]);
    }


    public function deleteStaff($staff_id) {

        $sql = "DELETE FROM staff WHERE staff_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$staff_id]);
    }

}
