<?php
$query = $db->prepare("SELECT * FROM categories WHERE onNavigation");
$query->execute();
$navCategories = $query->fetchAll(PDO::FETCH_ASSOC);

function displayOpeningClosingTimes($schedule)
{
    $daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $finalStr = "";
    foreach ($daysOfWeek as $day) {
        if (isset($schedule[$day])) {
            $openingTime = $schedule[$day][0];
            $closingTime = $schedule[$day][1];

            $finalStr .= "{$day}: {$openingTime}  - {$closingTime} <br>";
        }
    }
    return $finalStr;
}

// Fetch contact information from the database
$query = "SELECT * , (SELECT timings from timesheet WHERE `name` = contact_info.hours) as 'schedule' FROM contact_info LIMIT 1";
$stmt = $db->query($query);
$contactInfo = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php include "watermark.php" ?>
<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.php">
                <span>
                    <?php if ((!str_contains($_SERVER['REQUEST_URI'], ".php") || !str_contains($_SERVER['REQUEST_URI'], "index.php"))) {
                        echo "Whytewold Emporium";
                    } ?>

                </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  mx-auto ">
                    <li class="nav-item <?php if (str_ends_with($_SERVER['REQUEST_URI'], "/")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "greenhouse.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="greenhouse.php">GreenHouse</a>
                    </li>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "events.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="events.php">Events</a>
                    </li>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "menu.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "antiques.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="antiques.php">Antiques & Collectibles</a>
                    </li>
                    <?php foreach ($navCategories as $cat): ?>
                        <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "foodItem.php?id=" . $cat["category_id"])) {
                            echo "active";
                        } ?>">
                            <a class="nav-link" href="foodItem.php?id=<?= $cat["category_id"] ?>">
                                <?= $cat["category_name"] ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "about.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item <?php if (str_contains($_SERVER['REQUEST_URI'], "join.php")) {
                        echo "active";
                    } ?>">
                        <a class="nav-link" href="join.php">Join Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>