<?php
require "db_connect.php"; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $location = $_POST["location"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $hours = $_POST["hours"];

    // // Get opening and closing hours for each day
    // $openingHours = $_POST["opening_hours"];
    // $closingHours = $_POST["closing_hours"];

    // $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    // // Combine days, opening, and closing hours into an array
    // $hours = array_combine($days, array_map(null, $openingHours, $closingHours));

    // // Convert array to JSON and store in the database
    // $hoursJson = json_encode($hours);

    // Update the contact information in the database
    $query = "UPDATE contact_info SET location = ?, phone = ?, email = ?, hours = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$location, $phone, $email, $hours]);
}

// Fetch the current contact information
$query = "SELECT * FROM contact_info LIMIT 1";
$stmt = $db->query($query);
$contactInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM timesheet";
$stmt = $db->query($query);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php require "navbar.php" ?>


    <!-- Display default information -->
    <div class="container">
        <h1>Contact Information</h1>
        <p>Location:
            <?= $contactInfo['location'] ?>
        </p>
        <p>Phone:
            <?= $contactInfo['phone'] ?>
        </p>
        <p>Email:
            <?= $contactInfo['email'] ?>
        </p>
        <p>Opening Hours: <?= $contactInfo['hours'] ?> <a href="timings.php">(manage)</a> </p> 
    </div>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
        Update Contact Information
    </button>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Contact Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form action="" method="post">
                        <label for="location">Location:</label>
                        <input type="text" name="location" value="<?= $contactInfo['location'] ?>" required><br>

                        <label for="phone">Phone:</label>
                        <input type="tel" name="phone" value="<?= $contactInfo['phone'] ?>" required><br>

                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?= $contactInfo['email'] ?>" required><br>

                        <label for="hours">Opening Hours:</label>

                        <select name="hours" id="hours">
                            <?php foreach ($schedules as $schedule): ?>
                                <option value="<?=$schedule["name"]?>"><?=$schedule["name"]?></option>
                            <?php endforeach ?>
                        </select>
                        <br>

                        <button type="submit" class="btn btn-primary">Update Contact Information</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>