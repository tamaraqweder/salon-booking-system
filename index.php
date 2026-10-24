
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aurelia Salon | Home</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>

    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main>

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="container hero-content">

                <div class="hero-text">
                    <span class="section-label">WELCOME TO AURELIA SALON</span>

                    <h1>Your Beauty, <span>Our Passion.</span></h1>

                    <p>
                        Discover a world of elegance and beauty.
                        Enjoy professional salon services designed
                        to make you look and feel your best.
                    </p>

                    <div class="hero-buttons">
                        <a href="customer/create-booking.php" class="btn btn-gold">
                            Book Appointment →
                        </a>

                        <a href="#services" class="btn btn-outline">
                            Explore Services
                        </a>
                    </div>

                </div>

                <div class="hero-image">
                    <img src="asstes\images\hero.jpg" alt="Aurelia Salon">
                </div>

            </div>
        </section>

        <!-- SERVICES SECTION -->
        <section class="services section-padding" id="services">
            <div class="container">

                <div class="section-heading">
                    <span class="section-label">OUR SERVICES</span>
                    <h2>Beauty Services</h2>
                    <p>Choose the perfect treatment for you.</p>
                </div>

                <div class="services-grid">

                    <article class="service-card">
                        <img src="asstes\images\hair.jpg.png" alt="Hair Styling">

                        <div class="service-info">
                            <h3>Hair Styling</h3>
                            <p>Professional haircuts, coloring and styling.</p>

                            <a href="customer/create-booking.php">
                                Book Now →
                            </a>
                        </div>
                    </article>

                    <article class="service-card">
                        <img src="asstes\images\makeup.jpg.png" alt="Makeup">

                        <div class="service-info">
                            <h3>Makeup</h3>
                            <p>Beautiful makeup for every occasion.</p>

                            <a href="customer/create-booking.php">
                                Book Now →
                            </a>
                        </div>
                    </article>

                    <article class="service-card">
                        <img src="asstes\images\nails.jpg.png" alt="Nail Care">

                        <div class="service-info">
                            <h3>Nail Care</h3>
                            <p>Manicure, pedicure and nail treatments.</p>

                            <a href="customer/create-booking.php">
                                Book Now →
                            </a>
                        </div>
                    </article>

                    <article class="service-card">
                        <img src="asstes\images\facial.jpg.png" alt="Facial Treatments">

                        <div class="service-info">
                            <h3>Facial Treatments</h3>
                            <p>Relaxing skincare and facial treatments.</p>

                            <a href="customer/create-booking.php">
                                Book Now →
                            </a>
                        </div>
                    </article>

                </div>

            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section class="about section-padding" id="about">
            <div class="container about-content">

                <div class="about-image">
                    <img src="asstes\images\about.jpg.png" alt="About Aurelia Salon">
                </div>

                <div class="about-text">
                    <span class="section-label">ABOUT US</span>

                    <h2>Where Beauty Meets Elegance</h2>

                    <p>
                        At Aurelia Salon, we believe beauty is about
                        confidence, relaxation and self-care.
                    </p>

                    <p>
                        Our experienced beauty professionals provide
                        personalized services in a comfortable and
                        elegant environment.
                    </p>

                    <a href="customer/create-booking.php" class="btn btn-gold">
                        Book Your Visit →
                    </a>
                </div>

            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="cta section-padding">
            <div class="container cta-content">

                <span class="section-label">YOUR BEAUTY AWAITS</span>

                <h2>Ready for Your Next Beauty Experience?</h2>

                <p>Book your appointment today and let us take care of you.</p>

                <a href="customer/create-booking.php" class="btn btn-dark">
                    Book Appointment →
                </a>

            </div>
        </section>

    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="js/main.js"></script>

</body>
</html>
