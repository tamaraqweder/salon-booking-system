<?php


require "../classes/Database.php";
require "../classes/Auth.php";

$database=new Database();
$pdo=$database->connect();
$auth = new Auth($pdo);
$error = "";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $full_name = $_POST["full_name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $phone = $_POST["phone"] ?? "";


  $result = $auth->register($full_name, $email, $password, $phone);
  if ($result) {
    header("Location: login.php");
    exit;
}
 else {
    $error = "Email already registered";
}


}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | AURELIA</title>
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/auth.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="auth-section">

        <div class="auth-card">

            <div class="auth-heading">
                <span>JOIN AURELIA</span>
                <h1>Create Account</h1>
                <p>Create your account and start booking your beauty appointments.</p>
            </div>

            <form action="#" method="POST">

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        placeholder="Enter your full name"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required>
                </div>



                 <?php if ($error): ?>
                 <p class="error-message">
                          <?= $error ?>
                 </p>
               <?php endif; ?>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="Enter your phone number"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        minlength="8"
                        required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        minlength="8"
                        required>
                </div>

                <button type="submit" class="auth-btn">
                    Create Account
                </button>

            </form>

            <p class="auth-switch">
                Already have an account?
                <a href="login.php">Log In</a>
            </p>

        </div>

    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="../js/main.js"></script>

</body>
</html>
