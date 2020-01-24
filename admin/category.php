<?php
    require_once "bootstrap.php";
    if(!$_GET['category']) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
    $places = getAllPlacesInCategory($_GET['category']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Deloway</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>  
<body>
    <div class="container">
        <?php foreach ($places as $place): ?>
      <div class="col-sm-12 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading"><?php print $place['name']; ?></div>
            <div class="panel-body">
                <img src="<?php print "../".$place['image']; ?>" style="width: 100px; height: 100px;"/>
                <img src="<?php print "../".$place['map']; ?>" style="width: 100px; height: 100px;"/>
            </div>
            <div class="panel-body">
                <table>
                    <tr><td>Name: </td> <td><?php print $place['name']; ?></td></tr>
                    <tr><td>Price: </td> <td><?php print $place['price']; ?></td></tr>
                    <tr><td>Location: </td> <td><?php print $place['location']; ?></td></tr>
                    <tr><td>Phone: </td> <td><?php print $place['phone']; ?></td></tr>
                    <tr><td>Website: </td> <td><?php print $place['website']; ?></td></tr>
                    <tr><td>Description: </td> <td><?php print $place['description']; ?></td></tr>
                    <tr><td>Status: </td> <td><?php print $place['status']; ?></td></tr>
                </table>
            </div>
            <div class="panel-footer">
                <a href="placeImages.php?place_id=<?php print $place['id']; ?>"><button class="btn btn-success">Images</button></a>
                <a href="placeEdit.php?place_id=<?php print $place['id']; ?>"><button class="btn btn-warning">Edit</button></a>
            </div>
        </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>