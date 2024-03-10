<?php
include("db_connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $position = $_POST["position"];
    $message = $_POST["message"];

    // Email configuration
    $to_applicant = $email;
    $to_admin = $contactInfo['email'];
    $subject_applicant = "Application Submitted - WW Emporium";
    $subject_admin = "New Job Application";

    // Compose messages
    $message_applicant = "Dear $name,\n\nThank you for applying to Whytewold Emporium. Your application for the position of $position has been received. We will review your information and get back to you as soon as possible.\n\nBest regards,\nWW Emporium Team";

    $message_admin = "New job application received:\n\nName: $name\nEmail: $email\nPhone: $phone\nPosition: $position\nAdditional Information:\n$message";

    // Additional headers
    $headers = "From: hiring@wwemporium.com";

    // Send emails
    mail($to_applicant, $subject_applicant, $message_applicant, $headers);
    mail($to_admin, $subject_admin, $message_admin, $headers);

    // Redirect or display a success message
    header("Location: thank-you.php"); // Redirect to a thank-you page
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">

    <title> Join US - Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg.
        …Delicious
        food, live entertainment, and a fascinating collection of gifts, antiques and collectibles. </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
        integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
        crossorigin="anonymous" />
    <!-- font awesome style -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">
    <?php include "watermark.php" ?>
    <div class="hero_area">
        <div class="bg-box">
            <picture>
                <source media="(min-width: 600px)" srcset="images/BG.png">
                <img src="images/BG-mob.png" alt="IfItDoesntMatchAnyMedia">
            </picture>
        </div>
        <!-- header section strats -->
        <?php include('header.php') ?>
        <!-- end header section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container">
            <h1 class="mt-5">Join Our Team</h1>
            <p>We're always looking for talented individuals to join our team. Fill out the form below to apply for a
                position at our restaurant.</p>

            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>

                <label for="position">Position Applying For:</label>
                <div class="form-group">
                    <select class="form-control" id="position" name="position">
                        <option value="server">Server</option>
                        <option value="chef">Chef</option>
                        <option value="kitchen-helper">Kitchen Helper</option>
                        <option value="bartender">Bartender</option>
                        <option value="dishwasher">Dishwasher</option>
                        <option value="other">Other</option>
                    </select>
                </div><br><br>

                <div class="form-group">
                    <label for="message">Additional Information:</label>
                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
        </div>
    </section>

    <!-- end about section -->

    <?php require 'footer.php' ?>

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

</body>

</html>