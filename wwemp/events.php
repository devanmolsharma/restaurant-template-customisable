<?php
require "db_connect.php";
if (isset($_FILES['images'])) {
    require 'file_upload.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'edit') {
            // Handle event addition or editing
            if (isset($uploadOk) && $uploadOk && (count($target_files) > 0)) {
                $eventData = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'date' => $_POST['date'],
                    'duration' => $_POST['duration'],
                    'Active' => isset($_POST['Active']) ? 1 : 0,
                    'thumbnailURL' => $target_files[0],
                ];
                if ($action === 'add') {
                    // Insert a new event into the database
                    $query = "INSERT INTO events (event_title, event_description, event_date, event_duration, Active,thumbnailURL) VALUES (:title, :description, :date, :duration, :Active , :thumbnailURL)";

                } elseif ($action === 'edit') {
                    // Update an existing event in the database
                    $eventId = $_POST['event_id'];
                    $eventData['event_id'] = $eventId;
                    $query = "UPDATE events SET event_title = :title, event_description = :description, event_date = :date, event_duration = :duration, Active = :Active , thumbnailURL = :thumbnailURL WHERE event_id = :event_id";
                }

            } else {
                $eventData = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'date' => $_POST['date'],
                    'duration' => $_POST['duration'],
                    'Active' => isset($_POST['Active']) ? 1 : 0,
                ];
                if ($action === 'add') {
                    // Insert a new event into the database
                    $query = "INSERT INTO events (event_title, event_description, event_date, event_duration, Active) VALUES (:title, :description, :date, :duration, :Active)";

                } elseif ($action === 'edit') {
                    // Update an existing event in the database
                    $eventId = $_POST['event_id'];
                    $eventData['event_id'] = $eventId;
                    $query = "UPDATE events SET event_title = :title, event_description = :description, event_date = :date, event_duration = :duration, Active = :Active WHERE event_id = :event_id";
                }

            }
            $statement = $db->prepare($query);
            $statement->execute($eventData);
        } elseif ($action === 'remove') {
            // Handle event removal
            $eventId = $_POST['event_id'];

            $query = "DELETE FROM Events WHERE event_id = :event_id";
            $statement = $db->prepare($query);
            $statement->execute(['event_id' => $eventId]);
        }
    }
}

$query = "SELECT * FROM events";
$statement = $db->prepare($query);
$statement->execute();
$events = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles_events.css">
    <title>Events</title>
</head>

<body>
    <?php require "navbar.php" ?>
    <div id="events">
        <h1>Events</h1>

        <button id="openAddDialogButton">Add Event</button>

        <!-- Event List -->
        <?php foreach ($events as $event): ?>
            <div class="event">
                <?php if (strlen($event["thumbnailUrl"]) > 1): ?>
                    <div class="thumbnail">
                        <img src="<?= $event["thumbnailUrl"] ?>" width='200px'/>
                    </div>
                <?php endif ?>
                <div class="title">
                    <?= $event["event_title"] ?>
                </div>
                <div class="description">
                    <?= $event["event_description"] ?>
                </div>
                <div class="date">
                    <?= $event["event_date"] ?>
                </div>
                <div class="duration">
                    <?= $event["event_duration"] ?> days
                </div>
                <div class="Active">
                    <?= $event["Active"] ? 'Active' : 'Inactive' ?>
                </div>

                <button class="edit" onclick="openEditEventDialog(<?= $event['event_id'] ?>)">Edit</button>



                <!-- Remove Event Form -->
                <form method="post" onsubmit="return confirm('Are you sure you want to remove this event?');">
                    <input type="hidden" name="event_id" value="<?= $event["event_id"] ?>">
                    <input type="hidden" name="action" value="remove">
                    <button class="remove" type="submit">Remove</button>
                </form>
            </div>
        <?php endforeach ?>
    </div>
    <!-- Edit Event Form -->
    <div id="editEventDialog" class="dialog" enctype="multipart/form-data">
        <h2>Edit Event</h2>
        <form method="post">
            <input type="text" name="title" value="<?= $event["event_title"] ?>" required>
            <textarea name="description" required><?= $event["event_description"] ?></textarea>
            <input type="date" name="date" value="<?= $event["event_date"] ?>" required>
            <input type="number" name="duration" value="<?= $event["event_duration"] ?>" required>
            <br>
            <label for="Active">Active: </label>
            <input type="checkbox" name="Active" value="1" <?= $event["Active"] ? 'checked' : '' ?>><br>
            <input type="hidden" name="event_id" value="<?= $event["event_id"] ?>">
            <input type="hidden" name="action" value="edit">
            <button type="submit">Edit</button>
        </form>
        <button id="closeEditDialogButton">Cancel</button>
    </div>
    <!-- Add Event Dialog Box -->
    <div id="addEventDialog" class="dialog">
        <h2>Add Event</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Event Title" required>
            <textarea name="description" placeholder="Event Description" required></textarea>
            <input type="date" name="date" required>
            <input type="number" name="duration" placeholder="Event Duration (in days)" required>
            <br>
            <label for="Active">Active: </label>
            <input type="checkbox" name="Active" value="1"><br>
            <label for="Thumbnail">Thumbnail: </label>
            <input type="file" name="images[]" id='Thumbnail' multiple><br>
            <input type="hidden" name="action" value="add">
            <button type="submit">Add Event</button>
        </form>
        <button id="closeAddDialogButton">Cancel</button>
    </div>

    <!-- JavaScript to handle the dialog functionality -->
    <script>
        // Function to open the "Add Event" dialog
        function openAddEventDialog() {
            document.getElementById('addEventDialog').style.display = 'block';
        }

        // Function to open the "Edit Event" dialog
        function openEditEventDialog(eventId) {
            // Use JavaScript to populate the form with event details for editing
            document.getElementById('editEventDialog').style.display = 'block';
        }

        document.getElementById('openAddDialogButton').addEventListener('click', openAddEventDialog);
        // Attach a click event to the "Edit" button in each event to open the "Edit Event" dialog
        // Call openEditEventDialog() with the event ID to populate the dialog with the event data

        document.getElementById('closeAddDialogButton').addEventListener('click', function () {
            document.getElementById('addEventDialog').style.display = 'none';
        });

        document.getElementById('closeEditDialogButton').addEventListener('click', function () {
            document.getElementById('editEventDialog').style.display = 'none';
        });
    </script>
</body>

</html>