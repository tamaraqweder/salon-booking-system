<?php
require_once "../classes/Database.php";
require_once "../classes/Service.php";

$database = new Database();
$pdo = $database->connect();

$services = new Service($pdo);

$totalServices = $services->countServices();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | AURELIA</title>
 <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="dashboard">

        <h1>Welcome, Admin</h1>
        <p>Manage your salon from one place.</p>

        <section class="stats">

            <div class="stat-card">
                <h3>Total Services</h3>
                <h2><?= $totalServices ?></h2>
            </div>

            <div class="stat-card">
                <h3>Total Staff</h3>
                <h2>0</h2>
            </div>

            <div class="stat-card">
                <h3>Total Bookings</h3>
                <h2>0</h2>
            </div>

        </section>

        <h2 class="section-title">Management</h2>

        <section class="management">

            <a href="services.php" class="manage-card">
                <h3>Manage Services</h3>
                <p>Add, edit and delete services</p>
            </a>

            <a href="staff.php" class="manage-card">
                <h3>Manage Staff</h3>
                <p>Add, edit and delete staff</p>
            </a>

            <a href="schedules.php" class="manage-card">
                <h3>Manage Schedules</h3>
                <p>Set staff working hours</p>
            </a>

            <a href="bookings.php" class="manage-card">
                <h3>Manage Bookings</h3>
                <p>View and manage appointments</p>
            </a>

        </section>

    </main>


<?php include '../includes/footer.php'; ?>

</body>
</html>