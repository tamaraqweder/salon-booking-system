<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>



<header class="site-header">

    <nav class="navbar container">

        <!-- LOGO -->
        <a href="/salon-booking-system/index.php" class="logo">
            <span>✦</span> AURELIA
        </a>

        <!-- NAV LINKS -->
        <ul class="nav-links" id="navLinks">
            <li>
                <a href="/salon-booking-system/index.php">Home</a>
            </li>

            <li>
                <a href="/salon-booking-system/index.php#services">Services</a>
            </li>

            <li>
                <a href="/salon-booking-system/index.php#about">About Us</a>
            </li>
        </ul>

        <!-- ACTION BUTTONS -->
        <div class="nav-actions">
            <a href="/salon-booking-system/pages/login.php">
                Log In
            </a>



            <?php if (isset($_SESSION["user_id"])): ?>

                 <a href="/salon-booking-system/pages/logout.php">
                  Log Out
                    </a>

            <?php endif; ?>


            <?php if (isset($_SESSION["user_id"]) && ($_SESSION["role"] ?? "") === "customer"): ?>

    <a href="/salon-booking-system/customer/my-bookings.php">
        My Bookings
    </a>

<?php endif; ?>


            
           <a href="/salon-booking-system/customer/create-booking.php" class="btn btn-gold">
             Book Now
           </a>

        </div>

        <!-- BURGER BUTTON -->
        <button class="burger-menu"
                type="button"
                aria-label="Toggle navigation"
                onclick="toggleMenu()">
            ☰
        </button>

    </nav>

</header>
