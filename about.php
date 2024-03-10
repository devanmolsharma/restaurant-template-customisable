<?php
include("db_connect.php");
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

  <title> About us- Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg. …Delicious
    food, live entertainment, and a fascinating collection of gifts, antiques and collectibles.  </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
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

  <div class="hero_area">
    <div class="bg-box">
    <picture>
        <source media="(min-width: 600px)" srcset="images/BG.png">
        <img src="images/BG-mob.png" alt="else">
      </picture>
    </div>
    <!-- header section strats -->
    <?php include('header.php') ?>
    <!-- end header section -->
  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Experience the best kept secret in the Interlake...
              </h2>
            </div>
            <p>
              We invite you to relax with us in our unique and beautiful country setting by the lake. Time moves slower
              here, so sit back, breathe in the fresh cottage country air and enjoy what we have to offer.

              A visit to the Whytewold Emporium is truly a memorable experience. Imagine a place where you can get great
              food, beverages and live entertainment, while being able to shop. We pride ourselves on delivering quality
              products at a reasonable price and insist on providing old-fashioned, friendly customer service every
              time.

              The Whytewold Emporium serves fresh ground coffee too, but what we’re fast becoming famous for is our
              pizza and our hand-crafted crepes from Brittany. We’re also pleased to offer our customers a selection of
              wine, beer and coolers.

              Shoppers will enjoy our distinctive selection of merchandise ranging from antiques to jewelry. Gardeners
              and plant lovers will be pleasantly surprised by our selection of annuals, perennials and our line of
              garden supplies.
            </p>
            <a href="">
              Whytewold Emporium: something for everyone.
            </a>
          </div>
        </div>
      </div>
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