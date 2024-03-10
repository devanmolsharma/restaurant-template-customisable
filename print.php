<?php
@require "db_connect.php";
$query = "SELECT * FROM categories";
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT *
          FROM food_items f
          INNER JOIN categories c ON f.category_id = c.category_id";
$statement = $db->prepare($query);
$statement->execute();
$items = $statement->fetchAll(PDO::FETCH_ASSOC);

// Initialize an empty map
$categoryToItems = array();

// Iterate through the $items array and organize by category
foreach ($items as $item) {
    $category = $item['category_name']; // Assuming the category name is in the 'category_name' column
    if (!isset($categoryToItems[$category])) {
        $categoryToItems[$category] = array();
    }
    $categoryToItems[$category][] = $item;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
    <style media="print">
        @page {
            size: auto;
            margin: 0;
        }
    </style>
</head>

<body>
    <style>
        #menu {
            max-height: 1000px;
            min-width: 1000px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .category {
            height: min-content;
            min-width: 300px;
            margin: 20px;
        }

        .category_name {
            font-weight: lighter;
            font-size: 2.3em;
            color: brown;
            font-family: Pacifico;
        }

        .item {
            position: relative;
            margin: 5px;
        }

        .title {
            color: rgb(5, 98, 69);
            font-size: 1.3em;
            font-weight: bold;
        }

        .price {
            position: absolute;
            top: 0px;
            right: 0px;
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>


    <div id="menu">
        <?php foreach ($categories as $cat): ?>
            <div class="category">
                <div class="category_name">
                    <?= $cat["category_name"] ?>
                </div>
                <?php if(isset($categoryToItems[$cat["category_name"]])):?>
                <?php foreach ($categoryToItems[$cat["category_name"]] as $item): ?>
                    <div class="item">
                        <div class="title">
                            <?= $item["food_name"] ?>
                        </div>
                        <div class="price">$
                            <?= $item["price"] ?>
                        </div>
                        <div class="description">
                            <?= $item["food_description"] ?>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php endif?>

            </div>
        <?php endforeach ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        print()
    </script>
</body>

</html>