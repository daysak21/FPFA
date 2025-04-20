<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Afar.tn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-4">Welcome to <span class="text-primary">Afar.tn</span></h1>
                    <p class="lead mb-4">Your trusted destination for quality products and exceptional service in Tunisia.</p>
                    <div class="hero-stats d-flex justify-content-center gap-4 mt-4">
                        <div class="stat-item">
                            <h3 class="text-primary">1000+</h3>
                            <p>Happy Customers</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-primary">500+</h3>
                            <p>Products</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-primary">24/7</h3>
                            <p>Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mission-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>To revolutionize online shopping in Tunisia by providing high-quality products, exceptional service, and a seamless shopping experience that exceeds customer expectations.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vision-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p>To become the leading e-commerce platform in Tunisia, setting new standards for quality, customer satisfaction, and innovative shopping solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values">
        <div class="container">
            <h2 class="section-title text-center">Our Core Values</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Quality First</h4>
                        <p>We never compromise on the quality of our products and services.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Trust & Integrity</h4>
                        <p>Building long-term relationships based on trust and transparency.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation</h4>
                        <p>Constantly evolving to provide better shopping experiences.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Customer Focus</h4>
                        <p>Your satisfaction is our ultimate goal and motivation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title text-center">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shipping-fast"></i>
                        <h4>Fast Delivery</h4>
                        <p>Quick and reliable shipping across Tunisia</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Secure Payments</h4>
                        <p>Safe and secure payment methods</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-headset"></i>
                        <h4>24/7 Support</h4>
                        <p>Always here to help you</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require "footer.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>