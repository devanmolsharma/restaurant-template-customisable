<?php
// Include the database connection file
require "../db_connect.php";

// Handle add, remove, and edit operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];


        switch ($action) {
            case "add":
                if (isset($_POST["name"]) && isset($_POST["opening_hours"])) {
                    // Get opening and closing hours for each day
                    $openingHours = $_POST["opening_hours"];
                    $closingHours = $_POST["closing_hours"];

                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                    // Combine days, opening, and closing hours into an array
                    $hours = array_combine($days, array_map(null, $openingHours, $closingHours));

                    // Convert array to JSON and store in the database
                    $timings = json_encode($hours);
                    $name = $_POST["name"];

                    // Insert the new record
                    $stmt = $db->prepare("INSERT INTO `timesheet`(`name`, `timings`) VALUES (:name, :timings)");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':timings', $timings);
                    $stmt->execute();
                }
                break;

            case "remove":
                if (isset($_POST["id"])) {
                    $id = $_POST["id"];

                    // Remove the record
                    $stmt = $db->prepare("DELETE FROM `timesheet` WHERE `id` = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                }
                break;

            case "edit":
                if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["opening_hours"])) {
                    // Get opening and closing hours for each day
                    $openingHours = $_POST["opening_hours"];
                    $closingHours = $_POST["closing_hours"];

                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                    // Combine days, opening, and closing hours into an array
                    $hours = array_combine($days, array_map(null, $openingHours, $closingHours));

                    // Convert array to JSON and store in the database
                    $timings = json_encode($hours);
                    $id = $_POST["id"];
                    $name = $_POST["name"];

                    // Update the record
                    $stmt = $db->prepare("UPDATE `timesheet` SET `name` = :name, `timings` = :timings WHERE `id` = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':timings', $timings);
                    $stmt->execute();
                }
                break;
        }
    }
}

// Fetch records from the database
$stmt = $db->query("SELECT * FROM `timesheet`");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Management</title>
    <style>

        h2 {
            color: #333;
        }

        .day {
            margin-bottom: 10px;
        }

        .day label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .day p {
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php require "navbar.php" ?>
    <div class="container mt-5">
        <h2>Timesheet Management</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Record</button>

        <!-- Table to display records -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Timings</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>"
                        data-timings="<?= htmlspecialchars($row['timings']) ?>">
                        <td>
                            <?= $row['id'] ?>
                        </td>
                        <td>
                            <?= $row['name'] ?>
                        </td>
                        <td>
                            <?php

                            // Decode JSON data
                            $subschedule = json_decode($row["timings"]);

                            foreach ($subschedule as $day => $hours) {
                                echo '<div class="day">';
                                echo '<label>' . $day . '</label>';
                                echo '<p> Opening: ' . $hours[0] . ' and ';
                                echo 'Closing: ' . $hours[1] . '</p>';
                                echo '</div>';
                            }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-warning edit-btn">Edit</button>
                            <button class="btn btn-danger" onclick="removeRecord(<?= $row['id'] ?>)">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div class="modal" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addForm" method="post">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                            <div class="form-group">
                                <label>
                                    <?= $day ?>
                                </label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="opening_hours[<?= $day ?>]"
                                            placeholder="Opening" value="<?= $hoursArray[$day][0] ?? '' ?>">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="closing_hours[<?= $day ?>]"
                                            placeholder="Closing" value="<?= $hoursArray[$day][1] ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editForm" method="post">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" name="action" value="edit">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                            <div class="form-group">
                                <label>
                                    <?= $day ?>
                                </label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="opening_hours[<?= $day ?>]"
                                            placeholder="Opening">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="closing_hours[<?= $day ?>]"
                                            placeholder="Closing">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="./popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function () {
            // Function to handle record removal
            function removeRecord(id) {
                $.ajax({
                    type: 'POST',
                    url: 'timings.php', // Replace with the actual filename
                    data: {
                        action: 'remove',
                        id: id
                    },
                    success: function () {
                        location.reload();
                    }
                });
            }

            // Function to populate the edit modal and handle form submission for editing a record
            function editRecord(id, name, timings) {
                $('#editModal #id').val(id);
                $('#editModal #name').val(name);

                // Parse existing timings (JSON array)
                var timingsObj = timings;

                // Populate the opening and closing hours in the edit modal
                $.each(timingsObj, function (day, hours) {
                    $('#editModal [name="opening_hours[' + day + ']"]').val(hours[0]);
                    $('#editModal [name="closing_hours[' + day + ']"]').val(hours[1]);
                });

                $('#editModal').modal('show');
            }

            // Event listener for the edit buttons
            $('.edit-btn').click(function () {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var name = row.data('name');
                var timings = row.data('timings');
                editRecord(id, name, timings);
            });
        });
    </script>

</body>

</html>