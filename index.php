<?php

include("db_connect.php");

$query = "SELECT * FROM events WHERE Active = 1 ORDER BY event_date DESC";
$statement = $db->prepare($query);
$statement->execute();
$events = $statement->fetchAll(PDO::FETCH_ASSOC);
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

  <title> Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg. …Delicious
    food, live entertainment, and a fascinating collection of gifts, antiques and collectibles. </title>

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

<body>

  <div class="hero_area">
    <div class="bg-box">
      <picture>
        <source media="(min-width: 600px)" srcset="images/BG.png">
        <img src="images/BG-mob.png" alt="IfItDoesntMatchAnyMedia">
      </picture>
      <!-- <img id="bg" src="images/BG.png" alt=""> -->
    </div>
    <!-- header section strats -->
    <?php include "header.php" ?>
    <!-- end header section -->
    <!-- slider section -->
    <div id="mobIcon">
      <img src="./images/about-img.png" alt="site logo">
    </div>
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Whytewold Emporium
                    </h1>
                    <p>
                      We invite you to relax with us in our unique and beautiful country setting by the lake. Time moves
                      slower here, so sit back, breathe in the fresh cottage country air and enjoy what we have to
                      offer.

                      A visit to the Whytewold Emporium is truly a memorable experience. Imagine a place where you can
                      get great food, beverages and live entertainment, while being able to shop. We pride ourselves on
                      delivering quality products at a reasonable price and insist on providing old-fashioned, friendly
                      customer service every time.</p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Whytewold Emporium
                    </h1>
                    <p>
                      A visit to the Whytewold Emporium is truly a memorable experience. Imagine a place where you can
                      get great food, beverages and live entertainment, while being able to shop. We pride ourselves on
                      delivering quality products at a reasonable price and insist on providing old-fashioned, friendly
                      customer service every time.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Whytewold Emporium
                    </h1>
                    <p>
                      The Whytewold Emporium serves fresh ground coffee too, but what we’re fast becoming famous for is
                      our pizza and our hand-crafted crepes from Brittany. We’re also pleased to offer our customers a
                      selection of wine, beer and coolers.

                      Shoppers will enjoy our distinctive selection of merchandise ranging from antiques to jewelry.
                      Gardeners and plant lovers will be pleasantly surprised by our selection of annuals, perennials
                      and our line of garden supplies.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <ol class="carousel-indicators">
            <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel1" data-slide-to="1"></li>
            <li data-target="#customCarousel1" data-slide-to="2"></li>
          </ol>
        </div>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- offer section -->

  <!-- offer section -->

  <section class="offer_section layout_padding-bottom">
    <div class="offer_container">
      <div class="container ">
        <div class="row">
          <!-- <?php foreach ($events as $event): ?>
            <div class="carousel-item <?= ($event == $events[0]) ? 'active' : '' ?>">
              <div class="container">
                <?php if (!empty($event["thumbnailUrl"])): ?>
                  <img src="./wwemp/<?= $event["thumbnailUrl"] ?>" class="img-fluid" alt="Event Image" width="300px" height="300px">
                <?php endif; ?>
                <div class="row">
                  <div class="col-md-7 col-lg-6">
                    <div class="detail-box">
                      <h1>
                        <?= $event["event_title"] ?>
                      </h1>
                      <p class="countdown"></p>
                      <?= $event['event_description'] ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?> -->
          <?php foreach ($events as $event): ?>
            <div class="col-md-6  ">
              <div class="box ">
                <div class="img-box">
                  <?php if (!empty($event["thumbnailUrl"])): ?>
                    <img src="./wwemp/<?= $event["thumbnailUrl"] ?>">
                  <?php endif; ?>
                </div>
                <div class="detail-box">
                  <h5>
                    <?= $event["event_title"] ?>
                  </h5>
                  <h6 class="countdown">
                  </h6>
                  <a href="./events.php">
                    Know More
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </section>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // JavaScript for countdown timers
      var eventDates = [
        <?php foreach ($events as $event): ?>
                    new Date('<?= $event["event_date"] ?>'),
        <?php endforeach ?>
      ];

      var countdownElements = document.querySelectorAll('.countdown');

      function updateCountdown() {
        countdownElements.forEach(function (element, index) {
          var currentDate = new Date();
          var timeDifference = eventDates[index] - currentDate;

          var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
          var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

          element.innerHTML = days > 0 ? ('Time left: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's') : days < 0 ? `${-days} days ago` : "now";
        });
      }

      // Update the countdown every second
      setInterval(updateCountdown, 1000);

      // Initial update
      updateCountdown();
    });
  </script>
  <!-- end offer section -->


  <!-- end offer section -->

  <!-- food section -->

  <?php require "menuMain.php" ?>
  <!-- end food section -->

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
                Whytewold Emporium
              </h2>
            </div>
            <p>
              We invite you to relax with us in our unique and beautiful country setting by the lake. Time moves slower
              here, so sit back, breathe in the fresh cottage country air and enjoy what we have to offer. A visit to
              the Whytewold Emporium is truly a memorable experience. Imagine a place where you can get great food,
              beverages and live entertainme
            </p>
            <a href="about.php">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end client section -->
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

</body>

</html>