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
if (isset($_POST["add_staff"])) {

    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];
    $specialization = $_POST["specialization"];

    $result = $staff->addStaff(
        $full_name,
        $phone,
        $specialization
    );

    if ($result) {
        header("Location: staff.php");
        exit;
    }
}

$allStaff = $staff->getAllStaff();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Staff | AURELIA</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/staff.css">
</head>

<body>

    <?php include "../includes/navbar.php"; ?>

    <main class="staff-page">

        <h1>Manage Staff</h1>
        <p>Manage your salon employees</p>

   
        <section class="add-staff">

            <h2>Add New Staff</h2>

            <form method="POST">

                <label for="full_name">Full Name</label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    required
                >

                <label for="phone">Phone</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                >

                <label for="specialization">Specialization</label>
                <input
                    type="text"
                    id="specialization"
                    name="specialization"
                    required
                >

                <button type="submit" name="add_staff">
                    Add Staff
                </button>

            </form>

        </section>

       
        <section class="staff-list">

            <h2>Staff Members</h2>

            <table>

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($allStaff as $item): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($item["full_name"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item["phone"] ?? "") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item["specialization"] ?? "") ?>
                            </td>

                            <td>Active</td>

                          

                            <td class="staff-actions">

                                <!-- Edit Staff -->
                                <form action="edit-staff.php" method="GET">

                                    <input
                                        type="hidden"
                                        name="staff_id"
                                        value="<?= $item["staff_id"] ?>"
                                    >

                                    <button type="submit" class="edit-btn">
                                        Edit
                                    </button>

                                </form>

                             
                                <form
                                    action="delete-staff.php"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this staff member?');"
                                >

                                    <input
                                        type="hidden"
                                        name="staff_id"
                                        value="<?= $item["staff_id"] ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="delete_staff"
                                        class="delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </section>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>