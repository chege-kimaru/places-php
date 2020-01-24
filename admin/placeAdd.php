<?php
require_once "bootstrap.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Place</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<h1 class="text-center text-success">Add Product</h1>
<div class="container">
    <form role="form" enctype="multipart/form-data"
          action="<?php echo htmlspecialchars('procedures/add_place.php'); ?>" method="post" class="col-sm-6">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
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
                      name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="brand">Location:</label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <div class="form-group">
            <label for="brand">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="form-group">
            <label for="brand">Website:</label>
            <input type="text" class="form-control" id="website" name="website">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <div class="form-group">
            <label for="brand">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="1">OPEN</option>
                <option value="0">CLOSED</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="img">
        </div>
        <div class="form-group">
            <label for="image">Map:</label>
            <input type="file" class="form-control" id="map" name="map">
        </div>
        <div class="checkbox">
                <label><input type="checkbox" value="1" name="featured">Featured</label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body>
</html>