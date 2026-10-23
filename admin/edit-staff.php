
<?php

session_start();

require "../classes/Database.php";
require "../classes/Staff.php";

$database = new Database();
$pdo = $database->connect();

$staff = new Staff($pdo);


if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}


$staff_id = $_GET["staff_id"] ?? 0;

if (!filter_var($staff_id, FILTER_VALIDATE_INT) || $staff_id <= 0) {
    header("Location: staff.php");
    exit;
}


$staffData = $staff->getStaffById($staff_id);

if (!$staffData) {
    header("Location: staff.php");
    exit;
}

if (isset($_POST["update_staff"])) {

    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];
    $specialization = $_POST["specialization"];

    
    $is_active = $staffData["is_active"];

    $result = $staff->updateStaff(
        $staff_id,
        $full_name,
        $phone,
        $specialization,
        $is_active
    );

    if ($result) {
        header("Location: staff.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Staff | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/edit-staff.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="edit-staff-page">

        <section class="edit-staff-form">

            <h1>Edit Staff</h1>
            <p>Update staff member information</p>

            <form method="POST">

                <label for="full_name">Full Name</label>

                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    value="<?= htmlspecialchars($staffData["full_name"]) ?>"
                    required
                >

                <label for="phone">Phone</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="<?= htmlspecialchars($staffData["phone"] ?? "") ?>"
                >

                <label for="specialization">Specialization</label>

                <input
                    type="text"
                    id="specialization"
                    name="specialization"
                    value="<?= htmlspecialchars($staffData["specialization"] ?? "") ?>"
                    required
                >

                <button type="submit" name="update_staff">
                    Update Staff
                </button>

            </form>

        </section>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
