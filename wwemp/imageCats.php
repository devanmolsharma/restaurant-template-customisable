<?php
require "db_connect.php";

if (isset($_FILES["images"]) && isset($_GET["category"])) {
    require "file_upload.php";
    if ($uploadOk) {
        foreach ($target_files as $path) {
            $query = "INSERT INTO uploaded_images(image_category, image_path) VALUES (:image_category, :image_path)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":image_category", $_GET["category"], PDO::PARAM_STR);
            $stmt->bindValue(":image_path", $path, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}

if (isset($_POST["add_category"])) {
    // Handle form submission to add category
    $newCategory = $_POST["category"];

    // Validate and sanitize the category input as needed

    // Insert the new category into the ImageCategories table
    $query = "INSERT INTO imagecategories (category_name) VALUES (:category_name)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":category_name", $newCategory, PDO::PARAM_STR);
    $stmt->execute();
}
if (isset($_POST["deleteImage"])) {
    // Handle form submission to add category
    $id = $_POST["image_id"];

    // Insert the new category into the ImageCategories table
    $query = "DELETE FROM uploaded_images WHERE image_id=:image_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":image_id", $id, PDO::PARAM_INT);
    $stmt->execute();
    try {
        unlink($_POST["image_path"]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
// Fetch distinct image categories from ImageCategories table
$query = "SELECT * FROM imagecategories";
$statement = $db->prepare($query);
$statement->execute();
$imageCategories = $statement->fetchAll(PDO::FETCH_ASSOC);

// View all images by category
function viewImagesByCategory($category)
{
    global $db;
    $query = "SELECT * FROM uploaded_images WHERE image_category = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function viewImages()
{
    global $db;
    $query = "SELECT * FROM uploaded_images";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles_menu.css">
</head>

<body>
<?php require "navbar.php"?>
    <div class="container mt-5">
        <h2 class="mb-4">Image Gallery</h2>
        <!-- Image Categories Buttons -->
        <!-- Add Image Modal -->
        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="category">Category Name:</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>
                            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Add your form elements for adding images here -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="image">Select Image:</label>
                                <input type="file" name="images[]" class="form-control" multiple required>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Add
                                Image</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Image Categories Buttons -->
        <div class="mb-4 row">
            <form action="" method="get">
                <button type="submit" class="btn btn-secondary mr-2">
                    All
                </button>
            </form>
            <?php foreach ($imageCategories as $category): ?>
                <form action="" method="get">
                    <button type="submit" name="category" value="<?= $category["category_name"]; ?>"
                        class="btn btn-secondary mr-2">
                        <?= $category["category_name"]; ?>
                    </button>
                </form>
            <?php endforeach ?>
            <!-- Button to trigger Add Category Modal -->
            <button type="button" class="btn btn-secondary mr-2" data-toggle="modal" data-target="#addCategoryModal">
                + Add Category
            </button>
        </div>


        <!-- Image Gallery -->
        <div class="row">
            <?php
            if (isset($_GET["category"])) {
                $selectedCategory = $_GET["category"];
                $images = viewImagesByCategory($selectedCategory);
            } else {
                $images = viewImages();
            }

            foreach ($images as $image): ?>
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="<?= $image["image_path"]; ?>" class="card-img-top" alt="Image">
                        <form action="" method="post">
                            <div class="card-body">
                                <input type="hidden" name="image_id" value='<?= $image['image_id'] ?>'>
                                <input type="hidden" name="image_path" value='<?= $image['image_path'] ?>'>
                                <button class="btn btn-danger btn-sm" name='deleteImage' value="deleteImage">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if (isset($_GET["category"])): ?>
                <!-- Button to trigger Add Image Modal -->
                <button type="button" class="btn btn-primary btn-sm mr-2" id = "addPhotoButton" data-toggle="modal" data-target="#addImageModal">
                    Add Image
                </button>
            <?php endif ?>
        </div>
        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            #addPhotoButton{
                height: 50px;
                align-self: center;
                min-width: max-content;
            }
        </style>
</body>

</html>