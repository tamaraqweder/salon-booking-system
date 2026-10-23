
<?php

session_start();

require "../classes/Database.php";
require "../classes/Service.php";

$database = new Database();
$pdo = $database->connect();

$services = new Service($pdo);

// Check Admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

// Get Categories
$allCategories = $services->getAllCategories();

// Get Service ID
$service_id = $_GET["service_id"] ?? 0;

if (!filter_var($service_id, FILTER_VALIDATE_INT) || $service_id <= 0) {
    header("Location: services.php");
    exit;
}

// Get Service Information
$service = $services->getServiceById($service_id);

if (!$service) {
    header("Location: services.php");
    exit;
}

// Update Service
if (isset($_POST["update_service"])) {

    $category_id = $_POST["category_id"];
    $service_name = $_POST["service_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $duration_minutes = $_POST["duration_minutes"];

    // Keep Old Image
    $imageName = $service["image"];

    // Upload New Image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {

        $newImage = uniqid() . "_" . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $newImage)) {
            $imageName = $newImage;
        }
    }

    // Save Changes
    $result = $services->updateService(
        $service_id,
        $category_id,
        $service_name,
        $description,
        $price,
        $duration_minutes,
        $imageName
    );

    if ($result) {
        header("Location: services.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Service | AURELIA</title>
      <link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/edit-service.css">

</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="edit-service-page">

        <div class="edit-service-container">

            <h1>Edit Service</h1>
            <p>Update your service details</p>

            <form method="POST" enctype="multipart/form-data">

                <label for="category">Category</label>

                <select id="category" name="category_id" required>

                    <?php foreach ($allCategories as $category): ?>

                        <option
                            value="<?= $category["category_id"] ?>"
                            <?= $service["category_id"] == $category["category_id"] ? "selected" : "" ?>
                        >
                            <?= htmlspecialchars($category["category_name"]) ?>
                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="service_name">Service Name</label>

                <input
                    type="text"
                    id="service_name"
                    name="service_name"
                    value="<?= htmlspecialchars($service["service_name"]) ?>"
                    required
                >


                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                ><?= htmlspecialchars($service["description"] ?? "") ?></textarea>


                <label for="price">Price (JOD)</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    min="0"
                    step="0.01"
                    value="<?= htmlspecialchars($service["price"]) ?>"
                    required
                >


                <label for="duration">Duration (minutes)</label>

                <input
                    type="number"
                    id="duration"
                    name="duration_minutes"
                    min="1"
                    value="<?= htmlspecialchars($service["duration_minutes"]) ?>"
                    required
                >


                <label for="image">Change Image (Optional)</label>

                <?php if (!empty($service["image"])): ?>

                    <img
                        src="../uploads/<?= htmlspecialchars($service["image"]) ?>"
                        alt="Service Image"
                        width="120"
                    >

                <?php endif; ?>

                <input
                    type="file"
                    id="image"
                    name="image"
                >


                <button type="submit" name="update_service">
                    Save Changes
                </button>

                <a href="services.php" class="cancel-btn">
                    Cancel
                </a>

            </form>

        </div>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
