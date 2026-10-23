<?php

require "../classes/Database.php";
require "../classes/Service.php";

$database = new Database();
$pdo = $database->connect();

$services = new Service($pdo);



$allCategories = $services->getAllCategories();

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $category_id=$_POST["category_id"];
    $service_name=$_POST["service_name"];
    $description=$_POST["description"];
    $price=$_POST["price"];
    $duration_minutes=$_POST["duration_minutes"];
     $image = $_FILES["image"]; 

       $imageName = null;
     
       if ($_FILES["image"]["error"] === UPLOAD_ERR_OK)
         {
             $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
              move_uploaded_file( $_FILES["image"]["tmp_name"], "../uploads/" . $imageName );

        }

        $result = $services->addService(
    $category_id,
    $service_name,
    $description,
    $price,
    $duration_minutes,
    $imageName
);



}

$allServices = $services->getAllServices();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services | AURELIA</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/services.css">
</head>

<body>

      <?php include '../includes/navbar.php'; ?>

    <main class="services-page">

        <h1>Manage Services</h1>
        <p>Add, edit, and delete salon services.</p>

        <section class="add-service">
            <h2>Add New Service</h2>

           <form method="POST" enctype="multipart/form-data" >
               <label for="category">Category</label>

                  <select id="category" name="category_id" required>
                 <option value="">Select Category</option>

                     <?php foreach ($allCategories as $category): ?>
                            <option value="<?= $category['category_id'] ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>
                    <?php endforeach; ?>

                  </select>

                <label for="service_name">Service Name</label>
                <input type="text" id="service_name" name="service_name" required>

                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>

                <label for="price">Price (JOD)</label>
                <input type="number" id="price" name="price"
                       min="0" step="0.01" required>

                <label for="duration">Duration (minutes)</label>
                <input type="number" id="duration" name="duration_minutes"
                       min="1" required>

                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit">Add Service</button>

            </form>
        </section>

        <section class="services-list">

            <h2>Services List</h2>

            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                 <tbody>
    <?php foreach ($allServices as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item["service_name"]) ?></td>

            <td><?= htmlspecialchars($item["category_name"]) ?></td>

            <td><?= htmlspecialchars($item["price"]) ?> JOD</td>

            <td><?= htmlspecialchars($item["duration_minutes"]) ?> min</td>

            <td>
                <?= $item["is_active"] == 1 ? "Active" : "Inactive" ?>
            </td>

            <td>
                <form action="edit-service.php" method="GET">
                      <input type="hidden"   name="service_id" value="<?= $item["service_id"] ?>">

                    <button type="submit" class="edit-btn">
                           Edit
                     </button>

                </form>

                <form action="delete-service.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">

                  <input type="hidden" name="service_id" value="<?= $item["service_id"] ?>" >

                         <button type="submit" name="delete_service" class="delete-btn">  Delete </button>
                </form>
            </td>
       
       
       
       
       
       
            </tr>
         
        
        
        
        <?php endforeach; ?>
           
    
    
    
            </tbody>
            </table>

        </section>

    </main>


   <?php include '../includes/footer.php'; ?>

</body>
</html>