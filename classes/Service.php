<?php 

class Service{
    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }

public function getAllServices() {

    $sql = "SELECT services.*, categories.category_name
            FROM services
            JOIN categories
            ON services.category_id = categories.category_id";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getAllCategories(){
        $sql = "SELECT * FROM categories";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  public function addService($category_id, $service_name, $description, $price, $duration_minutes, $image)
   {
    $sql = "INSERT INTO services
        (category_id, service_name, description, price, duration_minutes, image)
        VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
    $category_id,
    $service_name,
    $description,
    $price,
    $duration_minutes,
    $image

    
   
]);





}


public function countServices() {
    $sql = "SELECT COUNT(*) FROM services";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchColumn();
}


public function deleteService($service_id) {

    $sql = "DELETE FROM services WHERE service_id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([$service_id]);
}

public function getServiceById($service_id) {

    $sql = "SELECT * FROM services WHERE service_id = ?";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$service_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function updateService($service_id, $category_id, $service_name, $description, $price, $duration_minutes, $image) {

    $sql = "UPDATE services
            SET category_id = ?,
                service_name = ?,
                description = ?,
                price = ?,
                duration_minutes = ?,
                image = ?
            WHERE service_id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $category_id,
        $service_name,
        $description,
        $price,
        $duration_minutes,
        $image,
        $service_id
    ]);
}



}




?>