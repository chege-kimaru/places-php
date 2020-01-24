<?php
require_once "bootstrap.php";
if (!$_GET['place_id']) {
    echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
    exit;
}
$place = findPlaceById($_GET['place_id']);
if (!$place) {
    echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit place</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<h1 class="text-center text-success">Edit Place</h1>
<div class="container">
    <form role="form" enctype="multipart/form-data"
          action="<?php echo htmlspecialchars('procedures/edit_place.php'); ?>" method="post" class="col-sm-6">
        <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php print $place['id']; ?>">
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php print $place['name']; ?>">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <option value="<?php print $place['category']; ?>"><?php print $place['category']; ?></option>
                <option value="Accommodation">Accommodation</option>
                <option value="FoodAndDrink">FoodAndDrink</option>
                <option value="Outdoors">Outdoors</option>
                <option value="Shopping">Shopping</option>
                <option value="Services">Services</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" rows="5" id="description"
                      name="description"><?php print $place['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="brand">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php print $place['location']; ?>">
        </div>
        <div class="form-group">
            <label for="brand">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php print $place['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="brand">Website:</label>
            <input type="text" class="form-control" id="website" name="website" value="<?php print $place['website']; ?>">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php print $place['price']; ?>">
        </div>
        <div class="form-group">
            <label for="brand">Status:</label>
            <select class="form-control" id="status" name="status">
                <option selected value="<?php print $place['status']; ?>">
                    <?php if ($place['status'] == 1) echo "OPEN"; else echo "CLOSED" ?>
                </option>
                <option value="1">OPEN</option>
                <option value="0">CLOSED</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="img">
            <div>Current image: <img src="<?php print "../" . $place['image']; ?>" style="width: 100px; height: 100px;"/></div>
        </div>
        <div class="form-group">
            <label for="image">Map:</label>
            <input type="file" class="form-control" id="map" name="map">
            <div>Current map: <img src="<?php print "../" . $place['map']; ?>" style="width: 100px; height: 100px;"/></div>
        </div>
        <div class="checkbox">
            <?php if ($place['featured'] == '1' || $place['featured'] == 1) { ?>
                <label><input type="checkbox" value="1" name="featured" checked="checked">Featured</label>
            <?php } else { ?>
                <label><input type="checkbox" value="1" name="featured">Featured</label>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body>
</html>