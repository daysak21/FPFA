<?php
include('includes/connect.php');
include('functions/common_functions.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php require "navbar.php" ;?>

    <div class="auth-container">
        <div class="auth-form-container">
            <div class="auth-header">
                <h2>Contact Us</h2>
                <p>Get in touch with us for any questions or inquiries</p>
            </div>

            <form action="process_contact.php" method="post" class="auth-form">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="contact_name" class="form-control" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="contact_email" class="form-control" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <select name="contact_subject" class="form-control" required>
                        <option value="" disabled selected>Select a subject</option>
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Support">Support</option>
                        <option value="Feedback">Feedback</option>
                        <option value="Business">Business Inquiry</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Your Message</label>
                    <textarea name="contact_message" class="form-control" required placeholder="Enter your message here..."></textarea>
                </div>

                <button type="submit" name="contact_submit" class="btn-submit">Send Message</button>
            </form>

            <div class="auth-footer">
                <p>Need immediate help? Call us at <a href="tel:+216295870721">+216 29 587 0721</a></p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.js"></script>
    <?php require "footer.php" ;?>
</body>
</html>
<?php

?>
