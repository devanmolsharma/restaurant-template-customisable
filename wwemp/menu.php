<?php
require "db_connect.php";

if ($_FILES) {
    require "file_upload.php";
}



// Handling form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            if ($uploadOk) {
                // Handle food item addition
                $foodData = [
                    'food_name' => $_POST['food_name'],
                    'food_description' => $_POST['food_description'],
                    'category_id' => $_POST['category_id'],
                    'price' => $_POST['price'],
                ];

                // Insert a new food item into the database
                $query = "INSERT INTO food_items (food_name, food_description, category_id, price) VALUES (:food_name, :food_description, :category_id, :price)";
                $statement = $db->prepare($query);
                $statement->execute($foodData);

                foreach ($target_files as $file) {

                    $subquery = "INSERT INTO food_images (food_id, img_name) VALUES ((select food_id from food_items where food_name=:food_name and category_id = :category_id),:filedir)";
                    $command = $db->prepare($subquery);
                    $command->bindValue(":food_name", $_POST['food_name']);
                    $command->bindValue(":category_id", $_POST['category_id']);
                    $command->bindValue(":filedir", $file);
                    $command->execute();
                }
            }

            // Handle image upload and linking the image to the food item (omitted in this example)

        } elseif ($action === 'edit') {
            // Handle food item editing
            $foodId = $_POST['food_id'];
            $foodData = [
                'food_name' => $_POST['food_name'],
                'food_description' => $_POST['food_description'],
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
            ];

            // Update the existing food item in the database
            $query = "UPDATE food_items SET food_name = :food_name, food_description = :food_description, category_id = :category_id, price = :price WHERE food_id = :food_id";
            $foodData['food_id'] = $foodId;
            $statement = $db->prepare($query);
            $statement->execute($foodData);

            // Handle image update (omitted in this example)
        } elseif ($action === 'add_category') {
            // Handle category addition
            $categoryName = $_POST['category_name'];
            $onNavigation = isset($_POST['on_navigation']) ? 1 : 0; // Assuming a checkbox in the form

            // Insert a new category into the database
            $categoryData = [':category_name' => $categoryName, ':on_navigation' => $onNavigation];
            $query = "INSERT INTO categories (category_name, onNavigation) VALUES (:category_name, :on_navigation)";
            $statement = $db->prepare($query);
            $statement->execute($categoryData);
        } elseif ($action === 'edit_category') {
            // Handle category edit
            $categoryId = $_POST['category_id'];
            $categoryName = $_POST['category_name'];
            $onNavigation = isset($_POST['on_navigation']) ? 1 : 0; // Assuming a checkbox in the form

            // Update the category in the database
            $categoryData = ['category_id' => $categoryId, 'category_name' => $categoryName, 'on_navigation' => $onNavigation];
            $query = "UPDATE categories SET category_name = :category_name, on_navigation = :on_navigation WHERE category_id = :category_id";
            $statement = $db->prepare($query);
            $statement->execute($categoryData);
        } elseif ($action === 'delete_category' && isset($_POST['category_id'])) {
            // Handle food item deletion
            $category_id = $_POST['category_id'];

            // First, you should delete the associated image from the database (assuming you have a table for food images).
            $imageGetQuery = "SELECT img_name FROM food_images WHERE food_id IN (SELECT food_id from food_items where category_id = :category_id)";
            $imageGetStatement = $db->prepare($imageGetQuery);
            $imageGetStatement->bindValue(":category_id", $category_id);
            $imageGetStatement->execute();
            $imageDirs = $imageGetStatement->fetchAll();

            foreach ($imageDirs as $image) {
                unlink($image["img_name"]);
            }

            // Next, delete the food item itself.
            $foodDeletionQuery = "DELETE FROM categories WHERE category_id = :category_id";
            $foodDeletionStatement = $db->prepare($foodDeletionQuery);
            $foodDeletionStatement->bindValue(":category_id", $category_id);
            $foodDeletionStatement->execute();

        } elseif ($action === 'delete' && isset($_POST['food_id'])) {
            // Handle food item deletion
            $foodId = $_POST['food_id'];

            // First, you should delete the associated image from the database (assuming you have a table for food images).
            $imageGetQuery = "SELECT img_name FROM food_images WHERE food_id = :food_id";
            $imageGetStatement = $db->prepare($imageGetQuery);
            $imageGetStatement->bindValue(":food_id", $foodId);
            $imageGetStatement->execute();
            $imageDirs = $imageGetStatement->fetchAll();

            foreach ($imageDirs as $image) {
                unlink($image["img_name"]);
            }

            // Next, delete the food item itself.
            $foodDeletionQuery = "DELETE FROM food_items WHERE food_id = :food_id";
            $foodDeletionStatement = $db->prepare($foodDeletionQuery);
            $foodDeletionStatement->bindValue(":food_id", $foodId);
            $foodDeletionStatement->execute();

        }
    }
}




// Fetch categories from the database
$query = "SELECT category_id, category_name FROM categories";
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch food items from the database, grouped by category
$query = "SELECT food_items.food_id, food_name, food_description, category_name, price ,food_items.category_id FROM food_items
          INNER JOIN categories ON food_items.category_id = categories.category_id
          ORDER BY food_items.category_id, food_name";
$statement = $db->prepare($query);
$statement->execute();
$foodItems = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * from food_images";
$statement = $db->prepare($query);
$statement->execute();
$imagesRawData = $statement->fetchAll(PDO::FETCH_ASSOC);
$food_imgs = [];


foreach ($imagesRawData as $imageData) {
    $food_imgs[$imageData["food_id"]] = $imageData["img_name"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add necessary HTML and CSS for styling -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="styles_menu.css">
</head>

<body>
    <?php require "navbar.php" ?>
    <!-- Button to open the "Add Category" dialog -->
    <button id="openAddCategoryDialogButton">Add Category</button>
    <h1>Menu</h1>
    <a target="_blank" href="print.php">Download as pdf</a>
    <div id="menu">


        <?php
        $currentCategory = null;
        foreach ($categories as $category):
            ?>
            <?php if ($currentCategory !== $category['category_name']):
                // Start a new category section
                if ($currentCategory !== null)
                    echo '</div>'; // Close the previous category section
                ?>
                <div class="category">
                    <form method="post">
                        <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                        <input type="hidden" name="action" value="delete_category">
                        <button class="deleteButton">Delete</button>
                    </form>
                    <h2>
                        <?= $category['category_name'] ?>
                    </h2>
                    <!-- Button to open the "Add Food Item" dialog -->
                    <button class="openAddDialogButton" category-id="<?= $category['category_id'] ?>">Add Item</button>
                    <?php
                    $currentCategory = $category['category_name'];
            endif;
            ?>

                <?php
                // Filter food items that belong to the current category
                $foodItemsInCategory = array_filter($foodItems, function ($foodItem) use ($category) {
                    return $foodItem['category_id'] === $category['category_id'];
                });

                foreach ($foodItemsInCategory as $foodItem):
                    ?>
                    <!-- Food Item -->
                    <div class="food-item">
                        <img src="<?= $food_imgs[$foodItem['food_id']] ?>" alt="<?= $foodItem['food_name'] ?>" class="food_img">
                        <h3>
                            <?= $foodItem['food_name'] ?>
                        </h3>
                        <p>
                            <?= $foodItem['food_description'] ?>
                        </p>
                        <p>Price: $
                            <?= $foodItem['price'] ?>
                        </p>
                        <button class="editButton" data-food-id="<?= $foodItem['food_id'] ?>">Edit</button>
                        <form method="post">
                            <input type="hidden" name="food_id" value="<?= $foodItem['food_id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button class="deleteButton">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>

            <?php endforeach; ?>

        </div> <!-- Close the last category section -->
    </div>




    <!-- Add Food Item Dialog Box -->
    <div id="addFoodItemDialog" class="dialog">
        <h2>Add Food Item</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="food_name">Name:</label>
            <input type="text" name="food_name" id="food_name" required>

            <label for="food_description">Description:</label>
            <textarea name="food_description" id="food_description" required></textarea>

            <select name="category_id" id="add_category_id" hidden>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>">
                        <?= $category['category_name'] ?>
                    </option>
                <?php endforeach ?>
            </select><br>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <label for="images">Image:</label>
            <input type="file" name="images[]" id="images" multiple="true" required>

            <input type="hidden" name="action" value="add">
            <button type="submit">Add Food Item</button>
        </form>
        <button id="closeAddDialogButton">Cancel</button>
    </div>

    <!-- Edit Food Item Dialog Box -->
    <div id="editFoodItemDialog" class="dialog">
        <h2>Edit Food Item</h2>
        <form method="post">
            <input type="hidden" name="food_id" id="edit_food_id" value="">

            <label for="food_name">Name:</label>
            <input type="text" name="food_name" id="edit_food_name" required>

            <label for="food_description">Description:</label>
            <textarea name="food_description" id="edit_food_description" required></textarea>

            <label for="category_id">Category:</label>
            <select name="category_id" id="edit_category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>">
                        <?= $category['category_name'] ?>
                    </option>
                <?php endforeach ?>
            </select><br>


            <label for="price">Price:</label>
            <input type="number" name="price" id="edit_price" step="1" required>

            <label for="food_image">Image:</label>
            <input type="file" name="food_image" id="edit_food_image">

            <input type="hidden" name="action" value="edit">
            <button type="submit">Edit Food Item</button>
        </form>
        <button id="closeEditDialogButton">Cancel</button>
    </div>


    <!-- Add Category Dialog Box -->
    <div id="addCategoryDialog" class="dialog">
        <h2>Add Category</h2>
        <form method="post">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" required>

            <input type="hidden" name="action" value="add_category">
            <div>
                <label for="on_navigation">Show on Navigation Bar?</label>
                <input type="checkbox" name="on_navigation" id="on_navigation">
            </div>
            <button type="submit">Add Category</button>
        </form>
        <button id="closeAddCategoryDialogButton">Cancel</button>
    </div>


    <!-- JavaScript to handle the dialog functionality -->
    <script>
        // Function to open the "Add Food Item" dialog
        function openAddFoodItemDialog(categoryId) {
            console.log(categoryId);
            document.getElementById('add_category_id').value = categoryId;
            document.getElementById('addFoodItemDialog').style.display = 'block';
        }

        // Function to open the "Edit Food Item" dialog
        // Function to open the "Edit Food Item" dialog and populate it with data
        function openEditFoodItemDialog(foodItemId) {
            // Find the food item data based on the foodItemId (you need to have this data available)
            const foodItemData = findFoodItemData(foodItemId);

            if (foodItemData) {
                // Set the values in the form fields
                document.getElementById('edit_food_id').value = foodItemData.food_id;
                document.getElementById('edit_food_name').value = foodItemData.food_name;
                document.getElementById('edit_food_description').value = foodItemData.food_description;
                document.getElementById('edit_price').value = foodItemData.price;
                document.getElementById('edit_category_id').value = foodItemData.category_id;

                // Display the "Edit Food Item" dialog
                document.getElementById('editFoodItemDialog').style.display = 'block';
            }
        }

        // Function to find food item data based on the foodItemId
        function findFoodItemData(foodItemId) {
            // You need to have access to the food item data, possibly by fetching it from your database or another data source
            // This is a placeholder example, and you should replace it with actual data retrieval logic
            const foodItemsData = <?php echo json_encode($foodItems); ?>;

            return foodItemsData.find(item => item.food_id == foodItemId);
        }

        const addButtons = document.querySelectorAll('.openAddDialogButton');
        addButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const categoryId = this.getAttribute('category-id');
                openAddFoodItemDialog(categoryId);
            });
        });

        // Attach a click event to the "Edit" button for each food item
        // Call openEditFoodItemDialog() with the food item ID to populate the dialog with the food item data
        const editButtons = document.querySelectorAll('.editButton');
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const foodId = this.getAttribute('data-food-id');
                openEditFoodItemDialog(foodId);
            });
        });

        document.getElementById('closeAddDialogButton').addEventListener('click', function () {
            document.getElementById('addFoodItemDialog').style.display = 'none';
        });

        document.getElementById('closeEditDialogButton').addEventListener('click', function () {
            document.getElementById('editFoodItemDialog').style.display = 'none';
        });

        // Function to open the "Add Category" dialog
        function openAddCategoryDialog() {
            document.getElementById('addCategoryDialog').style.display = 'block';
        }

        document.getElementById('openAddCategoryDialogButton').addEventListener('click', openAddCategoryDialog);

        document.getElementById('closeAddCategoryDialogButton').addEventListener('click', function () {
            document.getElementById('addCategoryDialog').style.display = 'none';
        });

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>