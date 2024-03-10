<?php
include("db_connect.php");

$query = "SELECT *
          FROM timesheet WHERE `name` = 'greenhouse'";
$statement = $db->prepare($query);
$statement->execute();
$times = $statement->fetch(PDO::FETCH_ASSOC);


function displayTimes($schedule) {
    $daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $finalStr = "<div style='font-family: Arial, sans-serif;'>";
    foreach($daysOfWeek as $day) {
        if(isset($schedule[$day])) {
            $openingTime = $schedule[$day][0];
            $closingTime = $schedule[$day][1];

            $finalStr .= "<p><strong>{$day}:</strong> {$openingTime} - {$closingTime}</p>";
        }
    }
    $finalStr .= "</div>";
    return $finalStr;
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

    <title> Greenhouse - Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg. …Delicious
    food, live entertainment, and a fascinating collection of gifts, antiques and collectibles.  </title>

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        /* Add your custom styles here */
        body {
            background-color: #f8f9fa;
        }

        .custom-container {
            min-width: 100vw;
            margin: 0 auto;
        }

        .custom-image {
            border-radius: 15px;
            margin-top: 10px;
            border: 3px solid #587178;
            width: 90%;
        }

        .custom-heading {
            color: #cd3c3c;
            text-align: center;
        }

        .container img {
            margin: 30px;
        }
    </style>

</head>
<style>
    .carousel{
        float:right;
        max-width: 500px;
        max-height: 300px;
        margin: 20px;
        margin-bottom: 40px;
    }

    .carousel img{
        max-width: 500px;
        max-height: 300px;
        
    }
    aside {
        float: left;
        /* border-right: 1px solid grey; */
        padding-right: 20px;
        margin-right: 20px;
        /* border: 1px solid black; */
    }

    @media screen and (max-width:600px) {
        aside {
        float: none;
        /* border-right: 1px solid grey; */
        padding-right: 20px;
        margin-right: 20px;
    }
    }

    body {
            background-color: #f8f9fa;
        }

        .custom-container {
            margin-top: 20px;
        }

        #customCarousel2 img {
            border-radius: 5px;
            height: 300px; /* Adjust as needed */
            object-fit: cover;
        }

        .custom-heading {
            color: #007bff; /* Bootstrap primary color */
        }

        aside {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #495057;
        }

        hr {
            border-color: #007bff; /* Bootstrap primary color */
            margin: 40px 0;
        }
</style>

<body class="sub_page">

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
    <div class="container custom-container">
    <div class="row">
        <div class="col-md-12">
            <div id="customCarousel2" class="carousel slide" data-interval='3000' data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="http://wwemporium.com/wp-content/uploads/2017/03/Karen-greenhouse.jpg"
                             class="d-block w-100" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="http://wwemporium.com/wp-content/uploads/2017/03/img1-4.jpg" class="d-block w-100"
                             alt="">
                    </div>
                </div>
            </div>

            <hr>

            <aside>
                <h1 class="custom-heading">Timings:</h1><br>
                <?= displayTimes(json_decode($times['timings'], true)) ?>
            </aside>

            <h3 class="custom-heading">We have Bedding Plants for every gardener's needs!</h3>
            <p class="text-center">The Whytewold Emporium greenhouse and garden center operates on a seasonal basis.
                We specialize in unique annuals and perennials and even offer custom container planting services for
                our customers.</p>
            <p class="text-center">We start growing bedding plans for customers in our 20’ X 50’ greenhouse in
                March. <span>We also have a second 27’ X</span><span> 30’ </span><span>greenhouse</span>.</p>
            <h4 class="text-center">Some of the products we offer include:</h4>
            <p class="text-center">• Beautiful hanging baskets<br>
                • Quality line of garden supplies like pots, stands, and hangers<br>
                • Bagged soil, compost, and peat moss</p>
            <p class="text-center"><strong>NOTE:</strong> We do not sell any pesticides due to environmental and
                food handling concerns</p>

            <hr>
        </div>
    </div>
</div>
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