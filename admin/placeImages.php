<?php
require_once "bootstrap.php";
if (!$_GET['place_id']) {
    echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
    exit;
}
$place_id = $_GET['place_id'];
$place_images = getPlaceImages($place_id);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Deloway</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <?php foreach ($place_images as $product_image): ?>
        <div class="col-sm-2">
            <div class="panel panel-info">
                <div class="panel-body">
                    <img src="<?php print "../" . $product_image['image']; ?>" style="width: 100px; height: 100px;"/>
                </div>
                <div class="panel-footer">
                    <form method="post" action="<?php echo htmlspecialchars('procedures/add_del_placeImage.php'); ?>">
                        <input type="hidden" class="form-control" id="place_id" name="place_id" value="<?php print $place_id ?>">
                        <input type="hidden" value="<?php print $product_image['id']; ?>" name="image_id"/>
                        <button class="btn btn-warning" type="submit" name="delete_image">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <hr>
    <form role="form" enctype="multipart/form-data" method="post" class="col-sm-6"
          action="<?php echo htmlspecialchars('procedures/add_del_placeImage.php'); ?>">
        <h4>Add Image</h4>
        <input type="hidden" class="form-control" id="place_id" name="place_id" value="<?php print $place_id ?>">
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="img">
        </div>
        <button type="submit" class="btn btn-default" name="add_image">Submit</button>
    </form>
</div>
</body>
</html>