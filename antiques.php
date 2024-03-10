<?php
include("db_connect.php");
// Fetch distinct categories from the database
$categories = $db->query("SELECT DISTINCT image_category FROM uploaded_images")->fetchAll(PDO::FETCH_COLUMN);

// Default category to show all images
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
// Fetch images based on the selected category
if (!empty($categoryFilter)) {
    $stmt = $db->prepare("SELECT * FROM uploaded_images WHERE image_category = :category");
    $stmt->bindParam(':category', $categoryFilter);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $db->query("SELECT * FROM uploaded_images");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title> Antiques - Whytewold Emporium – Restaurant, Antiques & Gifts, Garden Centre – A hidden gem on Lake Winnipeg. …Delicious
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
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
</head>

<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet" />
<!-- responsive style -->
<link href="css/responsive.css" rel="stylesheet" />
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .chip-container {
        display: flex;
        flex-wrap: wrap;
    }

    #base{
        min-width:90%;
    }

    .chip {
        margin: 5px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f2f2f2;
    }

    .chip a {
        text-decoration: none;
        color: #333;
    }
</style>
</head>

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

    <!-- about section -->

    <div class="container mt-5" id='base'>
        <div class="column">
            <div class="chip-container">
                <div class="chip"><a href="?category=">All</a></div>
                <?php foreach ($categories as $category): ?>
                    <div class="chip"><a href="?category=<?= $category ?>">
                            <?= $category ?>
                        </a></div>
                <?php endforeach; ?>
            </div>
            <br><br>


            <!-- Images Section -->
            <div class="col-md-9">
                <div class="row">
                    <?php foreach ($images as $index => $image): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <a href="./wwemp/<?= $image['image_path'] ?>" data-lightbox="gallery"
                                    data-title="<?= $image['image_category'] ?>">
                                    <img src="./wwemp/<?= $image['image_path'] ?>" class="card-img-top"
                                        alt="Image <?= $index + 1 ?>">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?= $image['image_category'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

</body>

</html>