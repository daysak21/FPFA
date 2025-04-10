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
    <title>Ecommerce User Login Page</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>
 <script src="js.js"></script> 
<body>
    <?php require "navbar.php" ;?>

    <div class="contact">
        <div class="container py-3">
            <h2 class="text-center mb-4">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="process_contact.php" method="post" class="d-flex flex-column gap-4">
                        <!-- Name field -->
                        <div class="form-outline">
                            <label for="contact_name" class="form-label">Full Name</label>
                            <input type="text" placeholder="Enter your full name" autocomplete="off" required name="contact_name" id="contact_name" class="form-control">
                        </div>
                        
                        <!-- Email field -->
                        <div class="form-outline">
                            <label for="contact_email" class="form-label">Email Address</label>
                            <input type="email" placeholder="Enter your email" autocomplete="off" required name="contact_email" id="contact_email" class="form-control">
                        </div>
                        
                        <!-- Subject field -->
                        <div class="form-outline">
                            <label for="contact_subject" class="form-label">Subject</label>
                            <select name="contact_subject" id="contact_subject" class="form-control" required>
                                <option value="" disabled selected>Select a subject</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Support">Support</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Business">Business Inquiry</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <!-- Message field -->
                        <div class="form-outline">
                            <label for="contact_message" class="form-label">Your Message</label>
                            <textarea placeholder="Enter your message here..." rows="5" required name="contact_message" id="contact_message" class="form-control"></textarea>
                        </div>
                        
                        <div>
                            <input type="submit" value="Send Message" class="btn btn-primary mb-2" name="contact_submit">
                            <p class="mt-3">
                                Need immediate help? Call us at <a href="tel:+1234567890" class="text-primary"><strong>+216 29 587 0721</strong></a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets//js/bootstrap.bundle.js"></script>
    <?php require "footer.php" ;?>
</body>

</html>
<?php

?>