<?php
include("db_connect.php");
$category_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$query = $db->prepare("SELECT *, (SELECT category_name from categories WHERE category_id = :id) as 'category_name' FROM food_items WHERE category_id = :id");
$query->bindValue(":id", $category_id, PDO::PARAM_INT);
$query->execute();
$items = $query->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT *
          FROM food_images WHERE food_id IN (SELECT food_id FROM food_items WHERE category_id = :id) ORDER BY food_id";
$statement = $db->prepare($query);
$statement->bindValue(":id", $category_id, PDO::PARAM_INT);
$statement->execute();
$images = $statement->fetchAll(PDO::FETCH_ASSOC);

$foodImageMap = [];

foreach ($images as $image) {
    $foodId = $image['food_id'];
    $imageData = $image['img_name'];

    if (!isset($foodImageMap[$foodId])) {
        $foodImageMap[$foodId] = [];
    }

    // Append the image data to the array under the food_id key
    $foodImageMap[$foodId][] = $imageData;
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

    <title> <?=$items[0]["category_name"]?> : Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg. …Delicious
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
                <img src="images/BG-mob.png" alt="IfItDoesntMatchAnyMedia">
            </picture>
        </div>
        <!-- header section strats -->
        <?php include('header.php') ?>
        <!-- end header section -->
    </div>
    <style>
        .banner {
            background: #a770ef;
            background: -webkit-linear-gradient(to right, #a770ef, #cf8bf3, #fdb99b);
            background: linear-gradient(to right, #a770ef, #cf8bf3, #fdb99b);
        }

        .small {
            font-size: 0.8em;
        }
    </style>
    <!-- about section -->

    <div class="container-fluid">
        <br><br>
        <!-- For demo purpose -->
        <?php if (count($items) > 0): ?>
            <div class="row py-5">
                <div class="col-lg-12 mx-auto">
                    <div class="text-white p-5 shadow-sm rounded banner">
                        <h1 class="display-4">Enjoy a great collection of
                            <?= $items[0]["category_name"] ?>
                        </h1>
                        <p class="lead">Only at Whytewold Emporium.</p>
                        <p class="lead small">*actual item may differ from the image provided
                        </p>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <!-- End -->
        <div class="row">
            <?php foreach ($items as $item): ?>
                <!-- Gallery item -->
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="bg-white rounded shadow-sm">
                        <div class="bg-white rounded shadow-sm">
                            <img src="wwemp/<?= $foodImageMap[$item['food_id']][0] ?>" alt=""
                                class="img-fluid card-img-top">
                            <!-- <div class="foodItemCrousel" class="carousel" data-interval='3000' data-ride="carousel">
                                <?php foreach ($foodImageMap[$item['food_id']] as $itemImg): ?>
                                    <div class="carousel-item <?php if ($itemImg == $foodImageMap[$item['food_id']][0])
                                        echo "active" ?>"><img src="wwemp/<?= $itemImg ?>" alt="" class="img-fluid card-img-top"></div>
                                <?php endforeach ?>
                            </div> -->
                            <div class="p-4">
                                <h5> <a href="#" class="text-dark">
                                        <?= $item["food_name"] ?>
                                    </a></h5>
                                <p class="small text-muted mb-0">
                                    <?= $item["food_description"] ?>
                                </p>
                                <div
                                    class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                    <p class="small mb-0"><i class="fa fa-money mr-2"></i><span class="font-weight-bold">$
                                            <?= $item["price"] ?>
                                        </span></p>
                                    <div class="badge badge-danger px-3 rounded-pill font-weight-normal">New</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End -->
                <?php endforeach ?>
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