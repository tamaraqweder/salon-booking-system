<?php
session_start();

require "../classes/Database.php";
require "../classes/Auth.php";

$database = new Database();
$pdo = $database->connect();

$auth = new Auth($pdo);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = $auth->login($email, $password);

    if ($user) { 
        //بخزن البيانات اذا صح
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            header("Location: ../index.php");
            exit;
        }

    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | AURELIA</title>
     <link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/auth.css">
      
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="auth-section">

        <div class="auth-card">

            <div class="auth-heading">
                <span>WELCOME BACK</span>
                <h1>Log In</h1>
                <p>Welcome back to AURELIA. Log in to your account.</p>
            </div>

            <form action="" method="POST">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required>
                </div>

                <button type="submit" class="auth-btn">
                    Log In
                </button>

                 <?php if ($error): ?>
                 <p class="error-message">
                          <?= $error ?>
                 </p>
               <?php endif; ?>

            </form>

            <p class="auth-switch">
                Don't have an account?
                <a href="register.php">Create Account</a>
            </p>

        </div>

    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="../js/main.js"></script>

</body>
</html>
