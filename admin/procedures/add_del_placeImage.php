<?php
require_once "../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
//    $session->getFlashBag()->add('error', 'Sorry, access to the page you tried to visit is denied. Or is currently not available!');
//    header('location: index.php');
    echo "<h1 style='color: red'>ACCESS DENIED</h1>";
    exit;
}
$place_id = $_POST['place_id'];
if (!$place_id) {
    echo "<h1 style='color: brown'>PLACE NOT FOUND</h1>";
    exit;
}

//Add image
if (isset($_POST['add_image'])) {
    $img = $_FILES['img']['name'];
    $tmp = $_FILES['img']['tmp_name'];
    $type = $_FILES['img']['type'];

    if ($img) {
        $dir = "../../uploads/places/" . $place_id . "/images/";
        $path = "uploads/places/" . $place_id . "/images/" . time() . $img;
        $real_path = "../../uploads/places/" . $place_id . "/images/" . time() . $img;
        mkdir($dir, 0777, true);
        if (move_uploaded_file($tmp, $real_path)) {
            try {
                $stmt = $db->prepare("INSERT INTO place_images (image, place_id) VALUES(:image, :place_id)");
                $stmt->bindParam(':image', $path);
                $stmt->bindParam(':place_id', $place_id);
                $stmt->execute();
                echo "<h4 style='color: green'>Successfully added image</h4>";
            } catch (\Exception $e) {
                echo "<h4 style='color: red'>Error adding image to db" . $e->getMessage() . "</h4>";
            }
        } else {
            echo "<h4 style='color: red'>Error uploading image</h4>";
        }
    } else {
        echo "<h4 style='color: brown'>No image provided.</h4>";
    }
}

//Delete image
if (isset($_POST['delete_image'])) {
    $place_image = findPlaceImageById($_POST['image_id']);
    if ($place_image && file_exists("../../" . $place_image['image'])) {
        if (!$place_image['image']) {
            echo "<h1 style='color: brown'>Error deleting this image.</h1>";
        } else {
            try {
                $stmt = $db->prepare("DELETE FROM place_images WHERE id=?");
                $stmt->execute([$place_image['id']]);
                echo "<h4 style='color: green'>Successfully deleted image</h4>";
            } catch (\Exception $e) {
                echo "<h4 style='color: red'>Error deleting image from db" . $e->getMessage() . "</h4>";
            }
        }
    } else {
        echo "<h1 style='color: brown'>Current image unavailable</h1>";
    }
}
?>